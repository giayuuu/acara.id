<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\EventModel;

class RegistrationModel extends Model
{
    protected $table = 'event_registrations';
    protected $allowedFields = ['user_id', 'event_id', 'signature', 'registered_at']; // Pastikan kolom registered_at ada

    public function getJoinedParticipants()
    {
        return $this->select('event_registrations.*, events.name AS event_name, users.full_name, users.position, users.nip')
            ->join('events', 'events.id = event_registrations.event_id')
            ->join('users', 'users.id = event_registrations.user_id')
            ->findAll();
    }

    public function getJoinedParticipantsByCreator($userId)
    {
        return $this->db->table('event_registrations')
            ->select('event_registrations.*, users.full_name, users.nip, users.position, events.name as event_name')
            ->join('users', 'users.id = event_registrations.user_id')
            ->join('events', 'events.id = event_registrations.event_id')
            ->where('events.created_by', $userId)
            ->orderBy('event_registrations.registered_at', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function registerForm($eventId)
    {
        $eventModel = new EventModel();
        $data['event'] = $eventModel->find($eventId);
        return view('event/register_event', $data);
    }

    public function getHistoryByUserId($userId)
    {
        return $this->select('event_registrations.id AS registration_id, event_registrations.*, events.name AS event_name, events.date AS event_date, events.time AS event_time, events.location AS event_location, events.material_link')
            ->join('events', 'events.id = event_registrations.event_id')
            ->where('event_registrations.user_id', $userId)
            ->orderBy('event_registrations.registered_at', 'DESC') // Tambahkan urutan descending supaya terbaru di atas
            ->findAll();
    }
}
