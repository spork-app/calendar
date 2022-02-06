<?php

namespace Spork\Calendar\Models;

use App\Models\FeatureList;
use App\Models\User;
use App\Models\Userable;
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
}
