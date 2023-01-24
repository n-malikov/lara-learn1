<?php

namespace Tests\Unit\Entity\User;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterTest extends TestCase
{
    use DatabaseTransactions; // laralearn - это чтоб после всех манипуляцай автоматом весь мусор записанный в БД удалялся

    public function testRequest(): void
    {
        $user = User::register(
            $name    = 'name',
            $email   = 'email',
            $password= 'password'
        );

        self::assertNotEmpty($user);

        self::assertEquals($name, $user->name);
        self::assertEquals($email, $user->email);
        self::assertNotEmpty($user->password);
        self::assertNotEquals($password, $user->password); // laralearn проверка, что мы храним не прямые пароли, а их хэши

        self::assertTrue($user->isWait());
        self::assertFalse($user->isActive());
        self::assertFalse($user->isAdmin());
    }

    public function testVerify(): void
    {
        $user = User::register('name', 'email', 'password');

        $user->verify();

        self::assertFalse($user->isWait());
        self::assertTrue($user->isActive());
        self::assertFalse($user->isAdmin());
    }

    public function testAlreadyVerified(): void
    {
        $user = User::register('name', 'email', 'password');
        $user->verify();

        $this->expectExceptionMessage('User is already verified.');
        $user->verify();
    }

}
