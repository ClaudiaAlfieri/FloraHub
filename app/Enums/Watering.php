<?php

namespace App\Enums;

enum Watering: string
{
    case Frequent = 'frequent';
    case Weekly = 'weekly';
    case Biweekly = 'biweekly';
    case Monthly = 'monthly';

    /**
     * The translated label shown in the interface.
     */
    public function label(): string
    {
        return match ($this) {
            self::Frequent => __('Frequent'),
            self::Weekly => __('Weekly'),
            self::Biweekly => __('Every two weeks'),
            self::Monthly => __('Monthly'),
        };
    }
}
