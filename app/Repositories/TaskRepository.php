<?php

namespace App\Repositories;

use App\Abstracts\AbstractRepository;
use App\Enums\TaskStatus;
use App\Http\Requests\CreateTask;
use App\Http\Requests\UpdateTask;
use App\Models\Task;

class TaskRepository extends AbstractRepository
{
    /**
     * @param CreateTask $request
     * @return Task
     */
    public function create(CreateTask $request): Task
    {
        return Task::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'status' => $request->input('status'),
            'deadline' => $request->input('deadline'),
        ]);
    }

    /**
     * @param UpdateTask $request
     * @param Task $task
     * @return void
     */
    public function updateByTask(UpdateTask $request, Task $task): void
    {
        $task->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'status' => TaskStatus::fromValue($request->input('status')), // Значення статусу із запиту в Enum
            'deadline' => $request->input('deadline'),
        ]);
    }
}
