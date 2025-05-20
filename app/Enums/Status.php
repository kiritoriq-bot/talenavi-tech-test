<?php

namespace App\Enums;

use App\Traits\HasCaseResolver;

enum Status: string
{
    use HasCaseResolver;

    case Pending = 'pending';

    case Open = 'open';

    case InProgress = 'in_progress';

    case Completed = 'completed';
}