<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

class TaskStatus extends Enum
{
    public const NotStarted = 'not_started';
    public const InProgress = 'in_progress';
    public const Completed = 'completed';
}
