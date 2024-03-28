<?php

namespace App\Repositories;

use App\Abstracts\AbstractRepository;
use App\Models\TaskUser;

class TaskUserRepository extends AbstractRepository
{
    /**
     * @param int $user_id ID поточного користувача
     * @param int $task_id ID створенной задачі
     * @return mixed
     */
    public function create(int $user_id, int $task_id)
    {
        return TaskUser::create([
            'user_id' => $user_id,
            'task_id' => $task_id,
        ]);
    }
}
