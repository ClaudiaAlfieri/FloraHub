<?php

namespace App\Enums;

enum Light: string
{
    case Low = 'low';
    case Medium = 'medium';
    case BrightIndirect = 'bright_indirect';
    case Direct = 'direct';

    /**
     * The translated label shown in the interface.
     */
    public function label(): string
    {
        return match ($this) {
            self::Low => __('Low light'),
            self::Medium => __('Medium light'),
            self::BrightIndirect => __('Bright indirect light'),
            self::Direct => __('Direct sunlight'),
        };
    }
}
