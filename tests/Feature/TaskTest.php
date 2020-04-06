<?php

namespace Tests\Feature;

use App\Models\Status;
use App\Models\Task;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TaskTest extends TestCase
{
    use DatabaseTransactions;
    public function testCreateTaskSuccess()
    {
        $user = factory(User::class)->create()->first();
        $status = factory(Status::class)->create(['status'=>'View'])->first();
        $this->json('POST', '/api/tasks',
            ["title"=>"aaa","description"=>"bbb","status"=>$status->id,"user"=>$user->user_id])
            ->assertSee(
                'bbb'
            );
    }
    public function testUpdateTaskSuccess()
    {
        factory(User::class)->create();
        factory(Status::class)->create();
        $task = factory(Task::class)->create();
        $this->json('PUT', '/api/tasks/'.$task->id,
            ["title"=>"aqwrqwraa","description"=>"asdasd"],[
            'Accept' => 'application/json',
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'application/json'
        ])
            ->assertSee(
                'aqwrqwraa'
            );
    }
    public function testDeleteTaskSuccess()
    {
        factory(User::class)->create();
        factory(Status::class)->create();
        $task = factory(Task::class)->create();
        $this->json('DELETE', '/api/tasks/'.$task->id)
            ->assertSee(
                $task->description
            );
    }
}
