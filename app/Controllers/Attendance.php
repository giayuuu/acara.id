<?php

namespace App\Controllers;

use App\Models\AttendanceModel;
use App\Models\EventModel;
use App\Models\UserModel;
use App\Models\RegistrationModel;

class Attendance extends BaseController
{
    public function scanPage()
    {
        $eventModel = new EventModel();
        $registrationModel = new RegistrationModel();
        $attendanceModel = new AttendanceModel();

        // Ambil semua event untuk dropdown
        $events = $eventModel->findAll();

        // Ambil event yang dipilih via GET parameter
        $selectedEventId = $this->request->getGet('event_id');

        // Default data statistik
        $stats = [
            'quota' => '-',
            'total_registered' => '-',
            'total_attended' => '-',
            'total_absent' => '-',
            'male_attended' => '-',
            'female_attended' => '-',
        ];

        if ($selectedEventId) {
            $event = $eventModel->find($selectedEventId);
            $quota = $event ? (int) $event['quota'] : 0;

            // Hitung jumlah pendaftar
            $totalRegistered = (int) $registrationModel
                ->where('event_id', $selectedEventId)
                ->countAllResults();

            // Hitung jumlah yang sudah hadir
            $totalAttended = (int) $attendanceModel
                ->join('event_registrations', 'event_registrations.id = event_attendance.registration_id')
                ->where('event_registrations.event_id', $selectedEventId)
                ->countAllResults();

            // Hadir laki-laki
            $maleAttended = (int) $attendanceModel
                ->join('event_registrations', 'event_registrations.id = event_attendance.registration_id')
                ->join('users', 'users.id = event_registrations.user_id')
                ->where('event_registrations.event_id', $selectedEventId)
                ->where('users.gender', 'Laki-laki')
                ->countAllResults();

            // Hadir perempuan
            $femaleAttended = (int) $attendanceModel
                ->join('event_registrations', 'event_registrations.id = event_attendance.registration_id')
                ->join('users', 'users.id = event_registrations.user_id')
                ->where('event_registrations.event_id', $selectedEventId)
                ->where('users.gender', 'Perempuan')
                ->countAllResults();

            // Hitung yang belum hadir
            $totalAbsent = $totalRegistered - $totalAttended;
            if ($totalAbsent < 0) {
                $totalAbsent = 0;
            }

            $stats = [
                'quota' => $quota,
                'total_registered' => $totalRegistered,
                'total_attended' => $totalAttended,
                'total_absent' => $totalAbsent,
                'male_attended' => $maleAttended,
                'female_attended' => $femaleAttended,
            ];
        }

        return view('attendance/scan', [
            'events' => $events,
            'selectedEventId' => $selectedEventId,
            'stats' => $stats,
        ]);
    }

    public function processScan()
    {
        // Proses scan QR dan simpan data kehadiran
    }

    public function attendanceList()
    {
        $session = session();
        $role = $session->get('role');
        $userId = $session->get('user_id'); // Asumsi kamu simpan user id di session

        if ($role !== 'admin' && $role !== 'admindinas') {
            return redirect()->to('/dashboard');
        }

        $attendanceModel = new AttendanceModel();
        $eventModel = new EventModel();

        // Ambil semua event sesuai role
        if ($role === 'admin') {
            // Admin bisa lihat semua event
            $events = $eventModel->findAll();
        } else if ($role === 'admindinas') {
            // Admin dinas hanya lihat event yang dia tambahkan (misal kolom 'created_by' di tabel events)
            $events = $eventModel->where('created_by', $userId)->findAll();
        }

        $eventId = $this->request->getGet('event_id');

        // Jika eventId dipilih, batasi query
        $query = $attendanceModel
            ->join('event_registrations', 'event_registrations.id = event_attendance.registration_id')
            ->join('users', 'users.id = event_registrations.user_id')
            ->join('events', 'events.id = event_registrations.event_id')
            ->select('event_attendance.id as attendance_id, events.name as event_name, events.date as event_date, users.full_name, users.nip, users.institution, event_attendance.attendance_time,users.dinas,users.position')
            ->orderBy('event_attendance.attendance_time', 'DESC');

        if (!empty($eventId)) {
            $query->where('events.id', $eventId);
        } else {
            // Jika admin dinas, batasi hanya event yang dia buat
            if ($role === 'admindinas') {
                $query->where('events.created_by', $userId);
            }
        }

        $attendances = $query->findAll();

        // Statistik mirip scanPage
        $stats = [
            'quota' => '-',
            'total_registered' => '-',
            'total_attended' => '-',
            'total_absent' => '-',
            'male_attended' => '-',
            'female_attended' => '-',
        ];

        if (!empty($eventId)) {
            $event = $eventModel->find($eventId);
            if ($event && ($role === 'admin' || ($role === 'admindinas' && $event['created_by'] == $userId))) {
                $quota = (int) $event['quota'];

                $registrationModel = new RegistrationModel();

                $totalRegistered = (int) $registrationModel
                    ->where('event_id', $eventId)
                    ->countAllResults();

                $totalAttended = (int) $attendanceModel
                    ->join('event_registrations', 'event_registrations.id = event_attendance.registration_id')
                    ->where('event_registrations.event_id', $eventId)
                    ->countAllResults();

                $maleAttended = (int) $attendanceModel
                    ->join('event_registrations', 'event_registrations.id = event_attendance.registration_id')
                    ->join('users', 'users.id = event_registrations.user_id')
                    ->where('event_registrations.event_id', $eventId)
                    ->where('users.gender', 'Laki-laki')
                    ->countAllResults();

                $femaleAttended = (int) $attendanceModel
                    ->join('event_registrations', 'event_registrations.id = event_attendance.registration_id')
                    ->join('users', 'users.id = event_registrations.user_id')
                    ->where('event_registrations.event_id', $eventId)
                    ->where('users.gender', 'Perempuan')
                    ->countAllResults();

                $totalAbsent = $totalRegistered - $totalAttended;
                if ($totalAbsent < 0) $totalAbsent = 0;

                $stats = [
                    'quota' => $quota,
                    'total_registered' => $totalRegistered,
                    'total_attended' => $totalAttended,
                    'total_absent' => $totalAbsent,
                    'male_attended' => $maleAttended,
                    'female_attended' => $femaleAttended,
                ];
            }
        }

        return view('attendance/attendance_list', [
            'attendances' => $attendances,
            'events' => $events,
            'selectedEventId' => $eventId,
            'stats' => $stats,
        ]);
    }
}
