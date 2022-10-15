<?php

namespace Spork\Calendar\Models;

use Spork\Core\Models\FeatureList;
use App\Models\User;
use App\Models\Userable;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RRule\RRule;

class RepeatEvent extends Model
{
    use HasFactory;

    protected $dates = [
        'date_start',
        'date_end',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'color',
        'interval',
        'frequency',
        'weekday_start',
        'number_of_occurrences',
        'date_start',
        'date_end',
        'for_months',
        'for_week_numbers',
        'for_year_day',
        'for_month_day',
        'for_day',
        'for_hour',
        'for_minute',
        'for_second',
        'for_set_position',
        'user_id',
        'feature_list_id',
    ];

    public function repeatable()
    {
        return $this->morphTo();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function users()
    {
        return $this->morphMany(Userable::class, 'userable');
    }

    public function nextOccurence(): DateTime
    {
        $event = new RRule(array_merge(
            $this->weekday_start !== null ? ['WKST' => $this->weekday_start] : [],
            $this->interval !== null ? ['INTERVAL' => 1] : [],
            $this->date_start !== null ? ['DTSTART' => $this->date_start] : [],
            $this->count !== null ? ['COUNT' => $this->count] : [],
            $this->for_second !== null ? ['BYSECOND' => $this->for_second] : [],
            $this->for_minute !== null ? ['BYMINUTE' => $this->for_minute] : [],
            $this->for_hour !== null ? ['BYHOUR' => $this->for_hour] : [],
            $this->for_day !== null ? ['BYDAY' => $this->for_day] : [],
            $this->for_month_day !== null ? ['BYMONTHDAY' => $this->for_month_day] : [],
            $this->for_year_day !== null ? ['BYYEARDAY' => $this->for_year_day] : [],
            $this->for_week_numbers !== null ? ['BYWEEKNO' => $this->for_week_numbers] : [],
            $this->for_months !== null ? ['BYMONTH' => $this->for_months] : [],
            $this->for_set_position !== null ? ['BYSETPOS' => $this->for_set_position] : [],
            $this->count !== null ? ['COUNT' => $this->count] : [],
            $this->frequency !== null ? ['FREQ' => $this->frequency] : [],
            $this->date_end !== null ? ['UNTIL' => $this->date_end] : []
        ));

        return $event->getOccurrencesBefore(now(), true, 1)[0];
    }

    public function nextOccurences(int $numberOfOccurrences): array
    {
        $event = new RRule(array_merge(
            $this->weekday_start !== null ? ['WKST' => $this->weekday_start] : [],
            $this->interval !== null ? ['INTERVAL' => 1] : [],
            $this->date_start !== null ? ['DTSTART' => $this->date_start] : [],
            $this->count !== null ? ['COUNT' => $this->count] : [],
            $this->for_second !== null ? ['BYSECOND' => $this->for_second] : [],
            $this->for_minute !== null ? ['BYMINUTE' => $this->for_minute] : [],
            $this->for_hour !== null ? ['BYHOUR' => $this->for_hour] : [],
            $this->for_day !== null ? ['BYDAY' => $this->for_day] : [],
            $this->for_month_day !== null ? ['BYMONTHDAY' => $this->for_month_day] : [],
            $this->for_year_day !== null ? ['BYYEARDAY' => $this->for_year_day] : [],
            $this->for_week_numbers !== null ? ['BYWEEKNO' => $this->for_week_numbers] : [],
            $this->for_months !== null ? ['BYMONTH' => $this->for_months] : [],
            $this->for_set_position !== null ? ['BYSETPOS' => $this->for_set_position] : [],
            $this->count !== null ? ['COUNT' => $this->count] : [],
            $this->frequency !== null ? ['FREQ' => $this->frequency] : [],
            $this->date_end !== null ? ['UNTIL' => $this->date_end] : []
        ));
        
        return $event->getOccurrencesBefore(now(), true, $numberOfOccurrences);
    }
}
