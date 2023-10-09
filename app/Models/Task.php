<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'deadline',
    ];

    protected $casts = [
        'status' => TaskStatus::class,
    ];

    public function task()
    {
        return $this->hasOne(TaskUser::class, 'task_id');
    }
}
