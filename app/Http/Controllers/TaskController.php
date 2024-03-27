<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Http\Requests\CreateTask;
use App\Http\Requests\UpdateTask;
use App\Models\Task;
use App\Models\TaskUser;
use App\Models\User;
use App\Services\TaskService;
use App\Services\UpdateTaskService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct(
        protected UpdateTaskService $updateTaskService,
        protected TaskService       $taskService
    )
    {
    }

    /**
     * Вивод списку задач
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        return view('tasks/index', [
            'tasks' => $this->taskService->index()
        ]);
    }

    /**
     * Відображення форми створення задачі
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        if (!$this->taskService->create()) {
            return redirect()
                ->route('home')->with('error', 'У Вас немає прав.');
        }

        return view('tasks/create');
    }

    /**
     * Сохранение новой задачи
     *
     * @param CreateTask $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateTask $request)
    {
        if ($this->updateTaskService->store($request)) {
            return redirect()
                ->route('home')->with('error', 'Дедлайн повинен бути більше, ніж поточний час');
        }

        $this->taskService->store($request);

        // Перенаправлення користувача на сторінку списку завдань з повідомленням про успіх
        return redirect()
            ->route('task.list')
            ->with('success', 'Задача успішно створена.');
    }

    /**
     * Відображення форми редагування завдання
     *
     * @param Task $task
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse
     */
    public function edit(Task $task)
    {
        if ($this->taskService->edit($task)) {
            return view('tasks/edit', [
                'task' => $task
            ]);
        }

        return redirect()
            ->route('home')->with('error', 'У Вас немає прав.');
    }

    /**
     * Оновлення завдання
     *
     * @param UpdateTask $request
     * @param Task $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateTask $request, Task $task)
    {
        if ($this->updateTaskService->update($request)) {
            return redirect()
                ->route('home')->with('error', 'Дедлайн має бути більше ніж поточний час');
        }

        if ($this->taskService->update($request, $task)) {
            // Перенаправлення користувача на сторінку списку завдань із повідомленням про успіх
            return redirect()->route('task.list')->with('success', 'Завдання успішно оновлено.');
        }

        return redirect()
            ->route('home')->with('error', 'У Вас немає прав.');
    }

    /**
     * @param Task $task
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse
     */
    public function view(Task $task)
    {
        if ($this->taskService->view($task)) {
            return view('tasks/view', [
                'task' => $task
            ]);
        }

        return redirect()
            ->route('home')->with('error', 'У Вас немає прав.');
    }

    /**
     * Видалення завдання
     *
     * @param Task $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Task $task)
    {
        if ($this->taskService->delete($task)) {
            // Перенаправлення користувача на сторінку списку завдань із повідомленням про успіх
            return redirect()
                ->route('task.list')->with('success', 'Завдання успішно видалено.');
        }

        return redirect()
            ->route('home')->with('error', 'У Вас немає прав.');
    }
}
