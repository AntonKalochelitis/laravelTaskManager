<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string title
 * @property string description
 * @property string status
 * @property string deadline
 * @property string created_at
 * @property string updated_at
 *
 * @property TaskUser task
 */
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
