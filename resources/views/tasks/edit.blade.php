@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">
            <a href="{{ route('task.list') }}">Tables</a> / </span> Edit Task #{{ $task->id }}
        </h4>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Редактировать задачу</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('task.update', ['task' => $task]) }}">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="title">Заголовок</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                           value="{{ old('title', $task->title) }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="description">Описание</label>
                                    <textarea class="form-control" id="description"
                                              name="description">{{ old('description', $task->description) }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="status">Статус</label>
                                    <select class="form-control" id="status" name="status" required>
                                        @foreach(\App\Enums\TaskStatus::getValues() as $status)
                                            <option value="{{ $status }}"
                                                    @if($status == old('status', $task->status)) selected @endif>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="deadline">Крайний срок</label>
                                    <input
                                        id="deadline"
                                        type="datetime-local"
                                        class="form-control"
                                        name="deadline"
                                        value="{{ old('deadline', $task->deadline) }}"
                                        required
                                    />
                                </div>

                                <hr class="border-top">

                                <button type="submit" class="btn btn-primary">Сохранить</button>
                                <a href="{{ route('task.list') }}" class="btn btn-primary">Back to List</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
