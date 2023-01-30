<?php

namespace Tests\Unit\Entity\User;

use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PhoneTest extends TestCase
{
    use DatabaseTransactions; // laralearn - это чтоб после всех манипуляцай автоматом весь мусор записанный в БД удалялся

    public function testDefault(): void
    {
        /** @var User $user */
        $user = factory(User::class)->create([
            'phone' => null,
            'phone_verified' => false,
            'phone_verify_token' => null,
        ]);

        self::assertFalse($user->isPhoneVerified());
    }

    public function testRequestEmptyPhone(): void
    {
        /** @var User $user */
        $user = factory(User::class)->create([
            'phone' => null,
            'phone_verified' => false,
            'phone_verify_token' => null,
        ]);

        $this->expectExceptionMessage('Phone number is empty.');
        // laralearn Carbon – это пакет, расширяющий стандартный PHP класс DateTime
        $user->requestPhoneVerification(Carbon::now());
    }

    public function testRequest(): void
    {
        /** @var User $user */
        $user = factory(User::class)->create([
            'phone' => '79000000000',
            'phone_verified' => false,
            'phone_verify_token' => null,
        ]);

        $token = $user->requestPhoneVerification(Carbon::now());

        self::assertFalse($user->isPhoneVerified());
        self::assertNotEmpty($token);
    }

    public function testRequestWithOldPhone(): void
    {
        /** @var User $user */
        $user = factory(User::class)->create([
            'phone' => '79000000000',
            'phone_verified' => true,
            'phone_verify_token' => null,
        ]);

        self::assertTrue($user->isPhoneVerified());

        $user->requestPhoneVerification(Carbon::now());

        self::assertFalse($user->isPhoneVerified());
        self::assertNotEmpty($user->phone_verify_token);
    }

    public function testRequestAlreadySentTimeout(): void
    {
        /** @var User $user */
        $user = factory(User::class)->create([
            'phone' => '79000000000',
            'phone_verified' => true,
            'phone_verify_token' => null,
        ]);

        $user->requestPhoneVerification($now = Carbon::now());
        $user->requestPhoneVerification($now->copy()->addSeconds(500));

        self::assertFalse($user->isPhoneVerified());
    }

    // попытка запросить новый код подтверждения телефона, раньше чем через 300 секунд
    public function testRequestAlreadySent(): void
    {
        /** @var User $user */
        $user = factory(User::class)->create([
            'phone' => '79000000000',
            'phone_verified' => true,
            'phone_verify_token' => null,
        ]);

        $user->requestPhoneVerification($now = Carbon::now());

        $this->expectExceptionMessage('Token is already requested.');
        $user->requestPhoneVerification($now->copy()->addSeconds(15));
    }

    // попытка ввести левый токен
    public function testVerify(): void
    {
        /** @var User $user */
        $user = factory(User::class)->create([
            'phone' => '79000000000',
            'phone_verified' => false,
            'phone_verify_token' => $token = 'token',
            'phone_verify_token_expire' => $now = Carbon::now(),
        ]);

        self::assertFalse($user->isPhoneVerified());

        $user->verifyPhone($token, $now->copy()->subSeconds(15));

        self::assertTrue($user->isPhoneVerified());
    }

    public function testVerifyIncorrectToken(): void
    {
        /** @var User $user */
        $user = factory(User::class)->create([
            'phone' => '79000000000',
            'phone_verified' => false,
            'phone_verify_token' => 'token',
            'phone_verify_token_expire' => $now = Carbon::now(),
        ]);

        $this->expectExceptionMessage('Incorrect verify token.');
        $user->verifyPhone('other_token', $now->copy()->subSeconds(15));
    }

    // попытка ввести корректный токен, но позже отведенного на это время
    public function testVerifyExpiredToken(): void
    {
        /** @var User $user */
        $user = factory(User::class)->create([
            'phone' => '79000000000',
            'phone_verified' => false,
            'phone_verify_token' => $token = 'token',
            'phone_verify_token_expire' => $now = Carbon::now(),
        ]);

        $this->expectExceptionMessage('Token is expired.');
        $user->verifyPhone($token, $now->copy()->addSeconds(500));
    }
}
