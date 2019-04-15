<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function user_is_created()
    {
        $user = User::create(['name'=>'Eric', 'email'=>'aaaaaaa', 'password'=>'secret', 'client_id'=>'1']);
        $this->assertEquals('Eric', $user->name);
    }
}
