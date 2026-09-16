<?php
namespace App\Models;
use CodeIgniter\Model;

class AttendanceModel extends Model {
    protected $table = 'event_attendance';
    protected $allowedFields = ['registration_id'];
}
