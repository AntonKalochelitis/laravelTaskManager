<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Http\Requests\CreateTask;
use App\Http\Requests\UpdateTask;
use App\Models\Task;
use App\Models\TaskUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Вивод списку задач
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        // Отримати ID текущего користувача
        $user_id = Auth::id();

        // Отримати завдання, пов'язані з поточним користувачем
        $user = User::find($user_id);
        $tasks = $user->userToTasks;

        return view('tasks/index', [
            'tasks' => $tasks
        ]);
    }

    /**
     * Відображення форми створення задачі
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function create()
    {
        return view('tasks/create');
    }

    /**
     * Сохранение новой задачи
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateTask $request)
    {
        $deadline = $request->input('deadline');
        $deadlineTimestamp = Carbon::parse($deadline)->timestamp;
        if (time() < $deadlineTimestamp) {
            return redirect()
                ->route('home')->with('error', 'Дедлайн повинен бути більше, ніж поточний час');
        }

        // Створення нової задачі в базі даних
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
        // Отримати ID поточного користувача
        $user_id = Auth::id();

        if ($task->task->user->id == $user_id) {
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
     * @param Request $request
     * @param Task $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateTask $request, Task $task)
    {
        // Отримати ID поточного користувача
        $user_id = Auth::id();

        $deadline = $request->input('deadline');
        $deadlineTimestamp = Carbon::parse($deadline)->timestamp;
        if (time() < $deadlineTimestamp) {
            return redirect()
                ->route('home')->with('error', 'Дедлайн має бути більше ніж поточний час');
        }

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
        // Отримати ID поточного користувача
        $user_id = Auth::id();

        if ($task->task->user->id == $user_id) {
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
        // Отримати ID поточного користувача
        $user_id = Auth::id();

        if ($task->task->user->id == $user_id) {
            // Видалення завдання з бази даних
            $task->delete();

            // Перенаправлення користувача на сторінку списку завдань із повідомленням про успіх
            return redirect()->route('task.list')->with('success', 'Завдання успішно видалено.');
        }

        return redirect()
            ->route('home')->with('error', 'У Вас немає прав.');
    }
}
