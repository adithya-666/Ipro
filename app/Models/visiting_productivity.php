<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\client;
use App\Models\employee;

class visiting_productivity extends Model
{
    use HasFactory;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'visiting_productivitys';
    protected $with = ['clients', 'employees'];
    

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id', 'client_id', 'schedule', 'working_type'
    ];

    public function clients()
    {
        return $this->belongsTo(client::class, 'client_id', 'id');
    }

    public function employees()
    {
        return $this->belongsTo(employee::class, 'employee_id', 'id');
    }
}
