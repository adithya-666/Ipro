<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class report_detail extends Model
{
    use HasFactory;

          /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'report_detail';
    

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'visiting_activity_id', 'report', 'file','file_name'
    ];
}
