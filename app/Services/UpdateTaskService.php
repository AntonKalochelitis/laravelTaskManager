<?php

namespace App\Services;

use App\Abstracts\AbstractService;
use App\Http\Requests\CreateTask;
use App\Http\Requests\UpdateTask;
use Carbon\Carbon;

class UpdateTaskService extends AbstractService
{
    public function __construct()
    {
    }

    public function store(CreateTask $request): bool
    {
        $deadline = $request->input('deadline');
        $deadlineTimestamp = Carbon::parse($deadline)->timestamp;
        if (time() > $deadlineTimestamp) {
            return true;
        }

        return false;
    }

    public function update(UpdateTask $request): bool
    {
        $deadline = $request->input('deadline');
        $deadlineTimestamp = Carbon::parse($deadline)->timestamp;
        if (time() < $deadlineTimestamp) {
            return true;
        }

        return false;
    }
}
