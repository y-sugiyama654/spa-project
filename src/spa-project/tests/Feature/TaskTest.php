<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use phpDocumentor\Reflection\Types\Void_;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->actingAs($user);
    }

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
    public function タイトルが空の場合は登録することができない()
    {
        $data = [
            'title' => ''
        ];

        $response = $this->postJson('api/task', $data);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'title' => 'The title field is required.'
            ]);
    }

    /**
     * @test
     */
    public function タイトルの文字数が256文字の場合は登録することができない()
    {
        $data = [
            'title' => str_repeat('a', 256)
        ];

        $response = $this->postJson('api/task', $data);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'title' => 'The title must not be greater than 255 characters.'
            ]);
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
