<?php

namespace App\Services;

use App\Abstracts\AbstractService;
use App\Enums\TaskStatus;
use App\Http\Requests\CreateTask;
use App\Http\Requests\UpdateTask;
use App\Models\Task;
use App\Models\TaskUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TaskService extends AbstractService
{
    public function __construct()
    {
    }

    public function index()
    {
        // Отримати ID текущего користувача
        $user_id = Auth::id();

        // Отримати завдання, пов'язані з поточним користувачем
        /** @var User $user */
        $user = User::find($user_id);

        return $user->userToTasks;
    }

    public function create(): bool
    {
        $user_id = Auth::id();
        if (!empty($user_id)) {
            return true;
        }

        return false;
    }

    public function store(CreateTask $request)
    {
        // Створення нової задачі в базі даних
        /** @var Task $newTask */
        $newTask = Task::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'status' => $request->input('status'),
            'deadline' => $request->input('deadline'),
        ]);

        // Отримання ID поточного користувача
        $user_id = Auth::id();
        // Получение id створенной задачі
        $task_id = $newTask->id;

        // Створення зв'язку користувача і завдань
        TaskUser::create([
            'user_id' => $user_id,
            'task_id' => $task_id,
        ]);
    }

    public function edit(Task $task): bool
    {
        // Отримати ID поточного користувача
        $user_id = Auth::id();

        if ($task->task->user->id == $user_id) {
            return true;
        }

        return false;
    }

    public function update(UpdateTask $request, Task $task): bool
    {
        // Отримати ID поточного користувача
        $user_id = Auth::id();

        if ($task->task->user->id == $user_id) {
            // Отримайте значення статусу із запиту та перетворіть його на екземпляр Enum
            $status = TaskStatus::fromValue($request->input('status'));

            // Оновлення завдання у базі даних
            $task->update([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'status' => $status,
                'deadline' => $request->input('deadline'),
            ]);

            return true;
        }

        return false;
    }

    public function view(Task $task): bool
    {
        // Отримати ID поточного користувача
        $user_id = Auth::id();

        if ($task->task->user->id == $user_id) {
            return true;
        }

        return false;
    }

    public function delete(Task $task): bool
    {
        // Отримати ID поточного користувача
        $user_id = Auth::id();

        if ($task->task->user->id == $user_id) {
            // Видалення завдання з бази даних
            $task->delete();

            return true;
        }

        return false;
    }
}
