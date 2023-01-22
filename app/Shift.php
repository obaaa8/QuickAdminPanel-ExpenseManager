<?php

namespace App;

use App\Traits\MultiTenantModelTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use MultiTenantModelTrait;

    public $table = 'shifts';

    protected $dates = [
        'start_at',
        'end_at',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'start_at',
        'end_at',
        'total_amount',
        'employee_id',
        'status',
    ];

    // public function income_category()
    // {
    //     return $this->belongsTo(IncomeCategory::class, 'income_category_id');
    // }

    // public function getEntryDateAttribute($value)
    // {
    //     return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    // }

    // public function setEntryDateAttribute($value)
    // {
    //     $this->attributes['entry_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    // }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}
