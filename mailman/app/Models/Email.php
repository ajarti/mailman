<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'service_id',
        'custom_id',
        'client_id',
        'message_id',
        'to_email',
        'to_name',
        'from_email',
        'from_name',
        'subject',
        'priority',
        'markdown',
        'text',
        'html',
    ];

}


