<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string from_postcode
 * @property string to_postcode
 * @property int from_weight
 * @property int to_weight
 * @property int cost
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Customer customer
 */
class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'from_postcode',
        'to_postcode',
        'from_weight',
        'to_weight',
        'cost',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
