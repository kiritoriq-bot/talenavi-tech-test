<?php

namespace App\Traits;

use BackedEnum;
use Illuminate\Support\Str;
use UnitEnum;

trait HasCaseResolver
{
    public static function getCases(): array
    {
        $cases = [];

        foreach (self::cases() as $case) {
            $cases[] = static::resolveValue(enum: $case);
        }

        return $cases;
    }

    public static function getValues(): array
    {
        $values = [];

        foreach (self::cases() as $case) {
            $values[] = $case->value;
        }

        return $values;
    }

    public static function getCaseOptions(): array
    {
        $cases = [];

        foreach (self::cases() as $case) {
            $cases[$case->value] = static::resolveValue(enum: $case);
        }

        return $cases;
    }

    public static function resolveValue(UnitEnum | BackedEnum $enum)
    {
        return $enum instanceof BackedEnum
            ? Str::headline($enum->value)
            : $enum->value;
    }
}