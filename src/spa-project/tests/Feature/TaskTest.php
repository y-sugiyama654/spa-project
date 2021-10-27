<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function 一覧を取得できる()
    {
        $tasks = Task::factory()->count(10)->create();
        $response = $this->getJson('api/task');

        $response
            ->assertOk()
            ->assertJsonCount($tasks->count());
    }

    /**
     * @test
     */
    public function 登録することができる()
    {
        $data = [
            'title' => 'hogehoge'
        ];
        $response = $this->postJson('api/task', $data);

        $response
            ->assertCreated()
            ->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function 更新することができる()
    {
        $task = Task::factory()->create();
        $task->title = '書き換え';


        $response = $this->patchJson("api/task/{$task->id}", $task->toArray());

        $response
            ->assertOk()
            ->assertJsonFragment($task->toArray());
    }

    /**
     * @test
     */
    public function 削除することができる()
    {
        $task = Task::factory()->count(10)->create();

        $response = $this->deleteJson("api/task/22");
        $response->assertOk();

        $response = $this->getJson("api/task");
        $response
            ->assertJsonCount($task->count() - 1);
    }
}
