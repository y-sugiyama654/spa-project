<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * TaskController constructor.
     */
    public function __construct()
    {
        $this->middleware('can:checkUser,task')->only([
            'updateDone',
            'update',
            'destroy '
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Task[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Task::orderByDesc('id')->get();
        //return Task::where('user_id', Auth::id())->orderByDesc('id')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(TaskRequest $request)
    {
        $request->merge([
            'user_id' => Auth::id()
        ]);

        $task = Task::create($request->all());

        return $task
            ? response()->json($task, 201)
            : response()->json([], 500);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Task $task
     * @return Response
     */
    public function update(TaskRequest $request, Task $task)
    {
        $task->title = $request->title;

        return $task->update()
            ? response()->json($task)
            : response()->json([], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     * @return Response
     */
    public function destroy(Task $task)
    {
        return $task->delete()
            ? response()->json($task)
            : response()->json([], 500);
    }

    /**
     * is_doneの更新
     *
     * @param Task $task
     * @param Request $request
     * @return void
     */
    public function updateDone(Task $task, Request $request)
    {
        $task->is_done = $request->is_done;

        return $task->update()
            ? response()->json($task)
            : response()->json([], 500);
    }
}
