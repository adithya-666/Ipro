<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employee_activity extends Model
{
    use HasFactory;

             /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'employee_activitys';

    protected $fillable = [
        'employee_id', 'visiting_productivity_id', 'checkin', 'checkin_location', 'location', 'maintenance', 'report_time', 'checkout', 'checkout_location' ,'status'
    ];
}
