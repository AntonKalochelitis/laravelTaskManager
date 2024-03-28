<?php

namespace App\Services;

use App\Abstracts\AbstractService;
use App\Enums\TaskStatus;
use App\Http\Requests\CreateTask;
use App\Http\Requests\UpdateTask;
use App\Models\Task;
use App\Models\TaskUser;
use App\Models\User;
use App\Repositories\TaskRepository;
use App\Repositories\TaskUserRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class TaskService extends AbstractService
{
    public function __construct(
        protected UserRepository     $userRepository,
        protected TaskRepository     $taskRepository,
        protected TaskUserRepository $taskUserRepository
    )
    {
    }

    public function index()
    {
        // Отримати завдання, пов'язані з поточним користувачем
        $user = $this->userRepository->findCurrentUser();

        return $user->userToTasks;
    }

    public function create(): bool
    {
        if (!empty(Auth::id())) {
            return true;
        }

        return false;
    }

    public function store(CreateTask $request)
    {
        // Створення нової задачі в базі даних
        $newTask = $this->taskRepository->create($request);

        // Створення зв'язку користувача і завдань
        $this->taskUserRepository->create(Auth::id(), $newTask->id);
    }

    public function edit(Task $task): bool
    {
        // ID поточного користувача
        $user_id = Auth::id();

        if ($task->task->user->id == $user_id) {
            return true;
        }

        return false;
    }

    public function update(UpdateTask $request, Task $task): bool
    {
        // ID поточного користувача
        if ($task->task->user->id == Auth::id()) {
            // Оновлення завдання у базі даних
            $this->taskRepository->updateByTask($request, $task);

            return true;
        }

        return false;
    }

    public function view(Task $task): bool
    {
        // ID поточного користувача
        if ($task->task->user->id == Auth::id()) {
            return true;
        }

        return false;
    }

    public function delete(Task $task): bool
    {
        // ID поточного користувача
        if ($task->task->user->id == Auth::id()) {
            // Видалення завдання з бази даних
            $task->delete();

            return true;
        }

        return false;
    }
}
