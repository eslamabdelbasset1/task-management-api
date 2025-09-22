<?php

namespace App\Enums;

enum Priority: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';

    public function label(): string
    {
        return match ($this) {
            self::LOW => 'Low Priority',
            self::MEDIUM => 'Medium Priority',
            self::HIGH => 'High Priority',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
