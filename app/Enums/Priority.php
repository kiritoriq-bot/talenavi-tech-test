<?php

namespace App\Enums;

use App\Traits\HasCaseResolver;

enum Priority: string
{
    use HasCaseResolver;

    case Low = 'low';

    case Medium = 'medium';

    case High = 'high';
}