<?php

namespace App\Models;

use \App\Model as Model;

/**
 * Class Attend
 * @package App\Models
 * @version November 1, 2021, 6:15 pm UTC
 *
 * @property integer user_id
 * @property integer day
 * @property integer month
 * @property integer year
 * @property integer start_work_time
 * @property integer end_work_time
 * @property integer start_break_time
 * @property integer end_break_time
 */
class Attend extends Model
{

    public $table = 'attends';
    




    public $upload_path = 'uploads/attends';

    public $search_fields = [
        'user_id',
        'day',
        'month',
        'year',
        'start_work_time',
        'end_work_time',
        'start_break_time',
        'end_break_time',
        'memo'
    ];
    public $fillable = [
        'user_id',
        'day',
        'month',
        'year',
        'start_work_time',
        'end_work_time',
        'start_break_time',
        'end_break_time',
        'memo'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'day' => 'integer',
        'month' => 'integer',
        'year' => 'integer',
        'start_work_time' => 'string',
        'end_work_time' => 'string',
        'start_break_time' => 'string',
        'end_break_time' => 'string',
        'memo' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'day' => 'required',
        'month' => 'required',
        'year' => 'required'
    ];

    
}
