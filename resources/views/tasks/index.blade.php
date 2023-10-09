@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('task.list') }}">Tables</a> /</span>
            Tasks List</h4>

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <button class="btn btn-sm">
                <a href="{{ route('task.create') }}" class="btn btn-primary btn-sm">Створити завдання</a>
            </button>

            <h5 class="card-header">Table Basic</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Заголовок</th>
                        <th>Статус</th>
                        <th>Крайній термін</th>
                        <th>Дії</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach ($tasks as $task)
                        <tr>
                            <td><i class="fab fa-angular fa-lg text-danger me-3"></i><strong>{{ $task->id }}</strong>
                            </td>
                            <td>{{ $task->task->title }}</td>
                            <td>
                                @if (\App\Enums\TaskStatus::NotStarted == $task->task->status)
                                    <span class="badge bg-label-warning me-1">{{ $task->task->status }}</span>
                                @elseif(\App\Enums\TaskStatus::InProgress == $task->task->status)
                                    <span class="badge bg-label-primary me-1">{{ $task->task->status }}</span>
                                @else
                                    <span class="badge bg-label-success me-1">{{ $task->task->status }}</span>
                                @endif
                            </td>
                            <td>{{ $task->task->deadline }}</td>
                            <td>
                                <a href="{{ route('task.view', $task->task->id) }}"
                                   class="btn btn-sm btn-success">Переглянути</a>
                                <a href="{{ route('task.edit', $task->task->id) }}" class="btn btn-sm btn-warning">Редагувати</a>
                                <form action="{{ route('task.delete', $task->task->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Ви впевнені?')">
                                        Удалить
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
    </div>
@endsection
