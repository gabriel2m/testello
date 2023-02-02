<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string name
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Collection|Delivery[] deliveries
 */
class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }
}
