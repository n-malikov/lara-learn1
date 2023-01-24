<?php

namespace Tests\Feature\Auth;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseTransactions; // laralearn - это чтоб после всех манипуляцай автоматом весь мусор записанный в БД удалялся

    public function testForm() : void
    {
        $response = $this->get('/login');

        $response
            ->assertStatus(200)
            ->assertSee('Login');
    }

    public function testErrors() : void
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => '',
        ]);

        $response
            ->assertStatus(302)
            ->assertSessionHasErrors(['email', 'password']);
    }

    public function testWait()
    {
        // сначала генерим рандомного пользователя со статусом WAIT
        $user = factory(User::class)->create(['status' => User::STATUS_WAIT]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'secret',
        ]);

        $response
            ->assertStatus(302)
            ->assertRedirect('/')
            ->assertSessionHas('error', 'You need to confirm your account. Please check your email.');
    }

    public function testActive()
    {
        // теперь уже со статусом ACTIVE
        $user = factory(User::class)->create(['status' => User::STATUS_ACTIVE]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'secret',
        ]);

        $response
            ->assertStatus(302)
            ->assertRedirect('/cabinet');

        $this->assertAuthenticated();
    }

}
