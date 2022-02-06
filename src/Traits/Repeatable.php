<?php
declare(strict_types=1);

namespace Spork\Calendar\Traits;

use Spork\Calendar\Models\RepeatEvent;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use RRule\RRule;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait Repeatable
{
    public function repeatable()
    {
        return $this->morphMany(RepeatEvent::class, 'repeatable');
    }

    // Includes the current date
    public function currentPeriod()
    {
        return new RRule([
            'FREQ' => $this->frequency,
            'DTSTART' => $this->date_start,
            'INTERVAL' => $this->interval,
            'WKST' => $this->weekday_start,
            'COUNT' => $this->number_of_occurrences,
            'UNTIL' => $this->date_end,
            'BYMONTH' => $this->for_months,
            'BYWEEKNO' => $this->for_week_numbers,
            'BYYEARDAY' => $this->for_year_day,
            'BYMONTHDAY' => $this->for_month_day,
            'BYDAY' => $this->for_day,
            'BYMINUTE' => $this->for_minute,
            'BYSECOND' => $this->for_second,
            'BYSETPOS' => $this->for_set_position,
        ]);
    }
}

