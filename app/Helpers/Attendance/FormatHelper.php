<?php

namespace App\Helpers\Attendance;

class FormatHelper
{
    // Add formatting helper methods here

    /**
     * Example: Format a date for attendance display.
     *
     * @param \DateTimeInterface|string $date
     * @param string $format
     * @return string
     */
    public static function formatDate($date, $format = 'Y-m-d')
    {
        if ($date instanceof \DateTimeInterface) {
            return $date->format($format);
        }

        if (is_string($date)) {
            $dt = date_create($date);
            if ($dt) {
                return $dt->format($format);
            }
        }

        return '';
    }
}
