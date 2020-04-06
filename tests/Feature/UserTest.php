<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    public function testGetUsers()
    {
        $user = factory(User::class)->create([
            'email' => 'testlogin@user.com',
            'password' => bcrypt('11111111'),
        ]);
        $this->json('GET', 'api/users')
            ->assertStatus(200)
            ->assertSee(
                'testlogin@user.com'
            );
    }

    public function testCreateUserSuccess()
    {
        $this->json('POST', 'api/users',
            ["first_name"=>"aaa","last_name"=>"bbb","password"=>"11111111","email"=>'asdasd@gmail.com'])
            ->assertSee(
                'asdasd@gmail.com'
            );
    }

    public function testCreateUserEmailAlreadyExists()
    {
        $email = 'testlogin@user.com';
        $user = factory(User::class)->create([
            'email' => $email,
            'password' => bcrypt('11111111'),
        ]);

        $this->json('POST', 'api/users',
            ["first_name"=>"aaa","last_name"=>"bbb","password"=>"11111111","email"=>$email])
            ->assertSee(
                'The email has already been taken.'
            );
    }

    public function testUpdateUser()
    {
        $email = 'testlogin@user212.com';
        $newEmail = 'new@user1.com';
        $user = factory(User::class)->create([
            'email' => $email,
            'password' => bcrypt('11111111'),
        ]);
       $this->json('PUT', '/api/users/'.$user->id, ["email"=>$newEmail], [
            'Accept' => 'application/json',
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'application/json'
        ])->assertSee(
            $newEmail);;
    }

    public function testUpdateUserEmailAlreadyTaken()
    {
        $email = 'testlogin@user21sfa222f35.com';
        factory(User::class)->create([
            'email' => $email,
            'password' => bcrypt('11111111'),
        ]);
        $user1 = factory(User::class)->create();
        $this->json('PUT', '/api/users/'.$user1->id, ["email"=>$email], [
            'Accept' => 'application/json',
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'application/json'
        ])->assertSee('email is already taken');

    }

    public function testDeleteUser()
    {
        $user = factory(User::class)->create();
        $this->json('DELETE', '/api/users/'.$user->id, [
            'Accept' => 'application/json',
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'application/json'
        ])->assertSee($user->email);

    }
}
