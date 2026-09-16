<?php

namespace App\Controllers;



use App\Models\EventModel;
use App\Models\RegistrationModel;
use CodeIgniter\Debug\Toolbar\Collectors\Views;
use Dompdf\Dompdf;
use Dompdf\Options;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use App\Models\AttendanceModel;
use App\Models\UserModel;




class Event extends BaseController
{

    private function checkAdminOrAdminDinas()
    {
        $role = session()->get('role');
        return ($role === 'admin' || $role === 'admindinas');
    }

    public function add()
    {
        if (!$this->checkAdminOrAdminDinas()) {
            return redirect()->to('/dashboard');
        }

        $eventModel = new EventModel();
        $data['events'] = $eventModel->findAll();

        return view('event/add_event', $data);
    }
    //menyimpan data acara
    public function save()
    {
        if (!$this->checkAdminOrAdminDinas()) {
            return redirect()->to('/dashboard');
        }

        $eventModel = new EventModel();

        $name = $this->request->getPost('name');
        $date = $this->request->getPost('date');
        $time = $this->request->getPost('time');

        if (!$name || !$date || !$time) {
            return redirect()->to('/admin/event/add')->with('modal_type', 'invalid_input');
        }

        $existingEvent = $eventModel
            ->where('name', $name)
            ->where('date', $date)
            ->where('time', $time)
            ->first();

        if ($existingEvent) {
            return redirect()->to('/admin/event/add')->with('modal_type', 'duplicate');
        }

        $quota = (int) $this->request->getPost('quota');
        if ($quota <= 0) {
            return redirect()->to('/admin/event/add')->with('modal_type', 'invalid_quota');
        }

        $eventData = [
            'name'            => $name,
            'date'            => $date,
            'time'            => $time,
            'location'        => $this->request->getPost('location'),
            'quota'           => $quota,
            'quota_remaining' => $quota,
            'material_link'   => $this->request->getPost('material_link'),
            'qr_code'         => uniqid('event_'),
            'created_by'      => session()->get('user_id'),
        ];

        $eventModel->save($eventData);

        return redirect()->to('/admin/event/add')->with('modal_type', 'success');
    }

    public function list()
    {
        $eventModel = new EventModel();
        $userModel = new UserModel();

        $dinas = $this->request->getGet('dinas');

        $query = $eventModel
            ->select('events.*, users.dinas AS creator_name')
            ->join('users', 'users.id = events.created_by', 'left');

        if (!empty($dinas)) {
            $query->where('users.dinas', $dinas);
        }

        $events = $query->findAll();

        // Array mapping hari dan bulan bahasa Indonesia
        $days = [
            'Sunday'    => 'Minggu',
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
        ];

        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        // Format tanggal dan waktu setiap event
        foreach ($events as &$event) {
            $timestamp = strtotime($event['date']);
            $dayName = $days[date('l', $timestamp)];
            $day = date('j', $timestamp);
            $monthNum = (int)date('n', $timestamp);
            $monthName = $months[$monthNum];
            $year = date('Y', $timestamp);

            $event['formatted_date'] = "{$dayName}, {$day} {$monthName} {$year}";


            $tt = \DateTime::createFromFormat('H:i:s', $event['time']);
            if (!$tt) {
                $tt = \DateTime::createFromFormat('H:i', $event['time']);
            }
            $event['formatted_time'] = $tt ? $tt->format('H:i') : $event['time'];
        }
        unset($event);

        $dinasList = $userModel->distinct()->select('dinas')->orderBy('dinas')->findColumn('dinas');
        $data['dinasList'] = array_filter($dinasList);
        $data['selectedDinas'] = $dinas;
        $data['events'] = $events;

        return view('event/event_list', $data);
    }




    //menampilkan data acara
    public function dataEvent()
    {
        $role = session()->get('role');
        $userId = session()->get('user_id');

        $eventModel = new EventModel();

        if ($role === 'admin') {
            $data['events'] = $eventModel->findAll();
        } elseif ($role === 'admindinas') {
            $data['events'] = $eventModel
                ->select('events.*, users.dinas AS creator_name')
                ->join('users', 'users.id = events.created_by')
                ->where('events.created_by', $userId)
                ->findAll();
        } else {
            return redirect()->to('/dashboard');
        }

        return view('event/data_event', $data);
    }





    //menampilkan data peserta
    public function participants()
    {
        $session = session();
        $role = $session->get('role');
        $userId = $session->get('user_id');

        if (!in_array($role, ['admin', 'admindinas'])) {
            return redirect()->to('/dashboard');
        }

        $registrationModel = new RegistrationModel();
        $eventModel = new EventModel();
        $attendanceModel = new AttendanceModel();

        $events = ($role === 'admin')
            ? $eventModel->findAll()
            : $eventModel->where('created_by', $userId)->findAll();

        $selectedEventId = $this->request->getGet('event_id');
        $searchName = $this->request->getGet('name');

        $participants = [];
        $stats = [
            'quota' => '-',
            'total_registered' => '-',
            'male_registered' => '-',
            'female_registered' => '-',
        ];

        if (!empty($selectedEventId)) {
            $event = $eventModel->find($selectedEventId);

            if (!$event || ($role === 'admindinas' && $event['created_by'] != $userId)) {
                return redirect()->to('/event/participants')->with('error', 'Anda tidak memiliki akses ke acara ini.');
            }

            $attendedIds = $attendanceModel
                ->select('registration_id')
                ->where('registration_id IS NOT NULL', null, false)
                ->findAll();

            $attendedIdList = array_column($attendedIds, 'registration_id');


            $query = $registrationModel
                ->join('users', 'users.id = event_registrations.user_id')
                ->join('events', 'events.id = event_registrations.event_id')
                ->where('event_registrations.event_id', $selectedEventId)
                ->select('event_registrations.*, users.full_name, users.gender, users.nip, users.position, users.phone,users.dinas, events.name as event_name');


            if (!empty($attendedIdList)) {
                $query->whereNotIn('event_registrations.id', $attendedIdList);
            }

            if (!empty($searchName)) {
                $query->like('users.full_name', $searchName);
            }

            $participants = $query->findAll();

            // Gather stats
            $allRegistrations = $registrationModel
                ->join('users', 'users.id = event_registrations.user_id')
                ->where('event_registrations.event_id', $selectedEventId)
                ->select('users.gender')
                ->findAll();

            $totalRegistered = count($allRegistrations);
            $maleCount = count(array_filter($allRegistrations, fn($p) => $p['gender'] === 'Laki-laki'));
            $femaleCount = count(array_filter($allRegistrations, fn($p) => $p['gender'] === 'Perempuan'));

            $stats = [
                'quota' => $event['quota'],
                'total_registered' => $totalRegistered,
                'male_registered' => $maleCount,
                'female_registered' => $femaleCount,
            ];
        }

        return view('event/data_peserta', [
            'participants' => $participants,
            'events' => $events,
            'selectedEventId' => $selectedEventId,
            'searchName' => $searchName,
            'stats' => $stats,
        ]);
    }



    //registrasi acara
    public function registerForm($eventId)
    {
        $eventModel = new EventModel();
        $data['event'] = $eventModel->find($eventId);

        $data['user'] = [
            'full_name' => session()->get('full_name'),
            'nip' => session()->get('nip'),
            'phone' => session()->get('phone'),
            'institution' => session()->get('institution'),
            'position' => session()->get('position'),
            'dinas' => session()->get('dinas'),
        ];

        return view('event/register_event', $data);
    }

    //submit acara registrasi
    public function registerSubmit()
    {
        $registrationModel = new RegistrationModel();
        $eventModel = new EventModel();

        $eventId = $this->request->getPost('event_id');
        $userId = session()->get('user_id');

        $existingRegistration = $registrationModel->where('event_id', $eventId)
            ->where('user_id', $userId)
            ->first();

        if ($existingRegistration) {
            $data['error'] = 'Anda sudah terdaftar di acara ini.';
            $data['event'] = $eventModel->find($eventId);
            $data['user'] = [
                'full_name' => session()->get('full_name'),
                'nip' => session()->get('nip'),
                'phone' => session()->get('phone'),
                'institution' => session()->get('institution'),
                'position' => session()->get('position'),
                'dinas' => session()->get('dinas'),
            ];

            return view('event/register_event', $data);
        }

        $event = $eventModel->find($eventId);

        if ($event && $event['quota_remaining'] > 0) {
            $data = [
                'event_id'      => $eventId,
                'user_id'       => $userId,
                'position'      => $this->request->getPost('jabatan'),
                'dinas'         => $this->request->getPost('dinas'),
                'signature'     => $this->request->getPost('signature'),
                'registered_at' => date('Y-m-d H:i:s'),
            ];

            $registrationModel->insert($data);
            $eventModel->update($eventId, [
                'quota_remaining' => $event['quota_remaining'] - 1
            ]);
            return redirect()->to('/dashboard');
        } else {
            return redirect()->back()->with('error', 'Kuota acara sudah penuh.');
        }
    }


    public function cetak_pdf($registrationId)
    {
        $tanggal_indo = function ($tanggal) {
            $hari = [
                'Sunday' => 'Minggu',
                'Monday' => 'Senin',
                'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis',
                'Friday' => 'Jumat',
                'Saturday' => 'Sabtu'
            ];

            $bulan = [
                1 => 'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            ];

            $tgl = date('d', strtotime($tanggal));
            $bln = date('n', strtotime($tanggal));
            $thn = date('Y', strtotime($tanggal));
            $hariIndo = $hari[date('l', strtotime($tanggal))];

            return $hariIndo . ', ' . $tgl . ' ' . $bulan[$bln] . ' ' . $thn;
        };

        $registrationModel = new \App\Models\RegistrationModel();
        $eventModel = new \App\Models\EventModel();
        $userModel = new \App\Models\UserModel();

        $data = $registrationModel
            ->select('event_registrations.*, events.*, users.full_name, users.nip, users.phone, users.position, users.dinas, users.institution')
            ->join('events', 'events.id = event_registrations.event_id')
            ->join('users', 'users.id = event_registrations.user_id')
            ->where('event_registrations.id', $registrationId)
            ->first();

        if (!$data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        $tanggalFormatted = $tanggal_indo($data['date']);

        $qrData = json_encode([
            'event' => $data['name'],
            'date' => $tanggalFormatted,
            'user' => $data['full_name'],
            'nip' => $data['nip'],
            'institution' => $data['institution'],
            'dinas' => $data['dinas'],
        ], JSON_UNESCAPED_UNICODE);

        $qrCode = new \Endroid\QrCode\QrCode($qrData);
        $qrCode->setSize(115)->setMargin(0);
        $writer = new \Endroid\QrCode\Writer\PngWriter();
        $qrCodeBase64 = base64_encode($writer->write($qrCode)->getString());

        $logoPath = FCPATH . 'template/assets/images/malkab.png';
        $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));

        $options = new \Dompdf\Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new \Dompdf\Dompdf($options);


        $html = view('event/pdf_ticket', [
            'event' => $data,
            'user' => $data,
            'registered_at' => $data['registered_at'],
            'qr_code_path' => $qrCodeBase64,
            'logo_path' => $logoBase64,
            'date' => $tanggalFormatted,
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('Tiket_Acara_' . $data['name'] . '.pdf', ['Attachment' => true]);

        exit;
    }


    //update acara
    public function update()
    {
        $role = session()->get('role');
        $userId = session()->get('user_id');

        if (!$this->checkAdminOrAdminDinas()) {
            return redirect()->to('/dashboard');
        }

        $eventModel = new EventModel();
        $eventId = $this->request->getPost('id');

        $event = $eventModel->find($eventId);

        if (!$event) {
            return redirect()->to('/admin/event/data')->with('error', 'Acara tidak ditemukan.');
        }

        // Cek apakah admindinas mencoba mengedit acara yang bukan miliknya
        if ($role === 'admindinas' && $event['created_by'] != $userId) {
            return redirect()->to('/admin/event/data')->with('error', 'Anda tidak memiliki izin untuk mengedit acara ini.');
        }

        $updateData = [
            'name'          => $this->request->getPost('name'),
            'date'          => $this->request->getPost('date'),
            'time'          => $this->request->getPost('time'),
            'location'      => $this->request->getPost('location'),
            'quota'         => $this->request->getPost('quota'),
            'material_link' => $this->request->getPost('material_link'),
        ];

        // Jika quota berubah, update juga quota_remaining (untuk admin)
        if ($role === 'admin' || $role === 'admindinas') {
            $newQuota = (int) $this->request->getPost('quota');
            $usedQuota = $event['quota'] - $event['quota_remaining'];
            $updateData['quota_remaining'] = max($newQuota - $usedQuota, 0);
        }

        $eventModel->update($eventId, $updateData);

        return redirect()->to('/admin/event/data')->with('success', 'Data acara berhasil diperbarui.');
    }

    //hapus acara
    public function delete()
    {
        if (session()->get('role') !== 'admin' && session()->get('role') !== 'admindinas') {
            return redirect()->to('/dashboard');
        }

        $eventModel = new EventModel();
        $eventId = $this->request->getPost('id');

        $eventModel->delete($eventId);

        return redirect()->to('/admin/event/data')->with('success', 'Data acara berhasil dihapus.');
    }

    public function scanQr()
    {
        if ($this->request->isAJAX()) {
            $json = $this->request->getJSON(true);
            $qrData = $json['qr_data'] ?? null;

            if (!$qrData) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Data QR tidak ditemukan.'
                ]);
            }

            $decoded = json_decode($qrData, true);

            if (!$decoded || !isset($decoded['nip'], $decoded['event'])) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Format QR tidak valid.'
                ]);
            }

            $nip = $decoded['nip'];
            $eventName = $decoded['event'];

            // Cek apakah peserta terdaftar
            $registrationModel = new RegistrationModel();
            $registration = $registrationModel
                ->join('users', 'users.id = event_registrations.user_id')
                ->join('events', 'events.id = event_registrations.event_id')
                ->where('users.nip', $nip)
                ->where('events.name', $eventName)
                ->select('event_registrations.id as registration_id')
                ->first();

            if (!$registration) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Peserta tidak ditemukan dalam registrasi acara.'
                ]);
            }

            // Cek apakah sudah absen sebelumnya
            $attendanceModel = new AttendanceModel();
            $existing = $attendanceModel
                ->where('registration_id', $registration['registration_id'])
                ->first();

            if ($existing) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Peserta sudah absen sebelumnya.'
                ]);
            }

            // Simpan data kehadiran
            $attendanceModel->insert([
                'registration_id' => $registration['registration_id']
            ]);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Kehadiran berhasil dicatat.'
            ]);
        }

        return $this->response->setStatusCode(405);
    }

    public function scanView()
    {
        return view('event/scan');
    }
}
