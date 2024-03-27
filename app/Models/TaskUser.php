<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property int task_id
 * @property int user_id
 *
 * @property Task task
 * @property User user
 */
class TaskUser extends Model
{
    use HasFactory;

    protected $table = 'task_user';

    // Відключаємо використання updated_at і created_at
    public $timestamps = false;

    protected $fillable = ['user_id', 'task_id'];

    // Зв'язок Многие ко Многим з моделью Task
    public function task()
    {
        return $this->hasOne(Task::class, 'id', 'task_id');
    }

    // Зв'язок Многие ко Многим з моделью User
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
