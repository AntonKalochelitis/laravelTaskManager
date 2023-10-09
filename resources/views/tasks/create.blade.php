@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('task.list') }}">Tables</a>/</span> Create Task</h4>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Create New Task</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('task.store') }}">
                                @csrf

                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description"
                                              name="description"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        @foreach(\App\Enums\TaskStatus::getValues() as $status)
                                            <option value="{{ $status }}" >{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="deadline">Deadline</label>
                                    <input
                                        id="deadline"
                                        type="datetime-local"
                                        class="form-control"
                                        name="deadline"
                                        required
                                    />
                                </div>

                                <hr class="border-top">

                                <button type="submit" class="btn btn-primary">Create Task</button>

                                <a href="{{ route('task.list') }}" class="btn btn-primary">Back to List</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
