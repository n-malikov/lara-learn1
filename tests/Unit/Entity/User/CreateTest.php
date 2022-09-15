<?php

namespace Tests\Unit\Entity\User;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateTest extends TestCase
{
    use DatabaseTransactions;

    public function testNewUser(): void
    {
        $user = User::newUser(
            $name = 'name',
            $email = 'email'
        );

        self::assertNotEmpty($user);

        self::assertEquals($name, $user->name);
        self::assertEquals($email, $user->email);
        self::assertNotEmpty($user->password);

        self::assertTrue($user->isActive());
    }

}
