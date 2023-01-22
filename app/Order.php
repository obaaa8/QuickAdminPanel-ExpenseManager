<?php

namespace App;

use App\Traits\MultiTenantModelTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use MultiTenantModelTrait;

    public $table = 'orders';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'customer_id',
        'shift_id',
        'total_amount',
        'created_by',
        'paid',
    ];

    // public function income_category()
    // {
    //     return $this->belongsTo(IncomeCategory::class, 'income_category_id');
    // }

    // public function getEntryDateAttribute($value)
    // {
    //     return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    // }

    public function setEntryDateAttribute($value)
    {
        $this->attributes['entry_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
    
    public function createdby()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }
}
