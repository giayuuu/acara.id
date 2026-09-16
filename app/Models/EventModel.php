<?php

namespace App\Models;

use CodeIgniter\Model;

class EventModel extends Model
{
    protected $table = 'events';
    protected $allowedFields = [
        'name',
        'date',
        'time',
        'location',
        'quota',
        'quota_remaining',
        'material_link',
        'qr_code',
        'status',
        'user_id',
        'created_at',
        'created_by',

    ];
}
