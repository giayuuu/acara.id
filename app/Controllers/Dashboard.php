<?php

namespace App\Controllers;

use App\Models\RegistrationModel;
use App\Models\UserModel;
use App\Models\EventModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $role = session()->get('role');
        $userId = session()->get('user_id');

        $eventModel = new EventModel();
        $userModel = new UserModel();

        $today = date('Y-m-d');
        $totalAcara = $eventModel->countAll();

        $acaraBerlangsung = $eventModel->where('date', $today)->countAllResults();
        $eventModel = new EventModel(); // Reset builder
        $acaraSelesai = $eventModel->where('date <', $today)->countAllResults();

        // Ambil data user lengkap termasuk dinas
        $user = $userModel->find($userId);
        $dinas = $user['dinas'] ?? 'Admin'; // fallback jika kosong

        if ($role == 'admin') {
            // Hitung semua admin dan admindinas (aktif & non-aktif)
            $totalAdmin = $userModel
                ->whereIn('role', ['admin', 'admindinas'])
                ->countAllResults();

            // Reset model agar query tidak tercampur
            $userModel = new UserModel();

            // Hitung admin dinas yang belum aktif (pending approval)
            $pendingAdmins = (new UserModel())
                ->where('role', 'admindinas')
                ->where('is_active', 0)
                ->findAll();
            $totalPendingAdmin = count($pendingAdmins);

            $data = [
                'totalAcara' => $totalAcara,
                'totalAdmin' => $totalAdmin,
                'acaraBerlangsung' => $acaraBerlangsung,
                'acaraSelesai' => $acaraSelesai,
                'totalPendingAdmin' => $totalPendingAdmin,
                'dinas' => $dinas,
            ];

            return view('dashboard/admin_dashboard', $data);
        } elseif ($role == 'admindinas') {
            // Hitung semua admin dan admindinas
            $totalAdmin = $userModel
                ->whereIn('role', ['admin', 'admindinas'])
                ->countAllResults();

            $data = [
                'totalAcara' => $totalAcara,
                'totalAdmin' => $totalAdmin,
                'acaraBerlangsung' => $acaraBerlangsung,
                'acaraSelesai' => $acaraSelesai,
                'dinas' => $dinas,
            ];

            return view('dashboard/admindinas_dashboard', $data);
        } else {
            return view('dashboard/user_dashboard');
        }
    }


    public function profile()
    {
        $userId = session()->get('user_id');
        $role = session()->get('role');

        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($userId);

        if ($role == 'admin') {
            return view('profile/profile_admin', ['user' => $user]);
        } elseif ($role == 'admindinas') {
            return view('profile/profile_admindinas', ['user' => $user]);
        } else {
            return view('profile/profile_user', ['user' => $user]);
        }
    }

    public function history()
    {
        $userId = session()->get('user_id');
        $registrationModel = new RegistrationModel();

        $history = $registrationModel->getHistoryByUserId($userId);

        return view('dashboard/history', ['history' => $history]);
    }

    public function updateProfile()
    {
        $userId = session()->get('user_id');
        $role = session()->get('role');

        $userModel = new \App\Models\UserModel();
        $currentUser = $userModel->find($userId);

        $validation = \Config\Services::validation();
        $validation->setRules([
            'full_name'   => 'required|min_length[3]',
            'gender'      => 'required|in_list[Laki-laki,Perempuan]',
            'nip'         => 'required',
            'phone'       => 'required',
            'institution' => 'required',
            'position'    => 'required',
            'dinas'       => 'required',
            'email'       => "required|valid_email|is_unique[users.email,id,{$userId}]"
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $newEmail = $this->request->getPost('email');

        $data = [
            'full_name'   => $this->request->getPost('full_name'),
            'gender'      => $this->request->getPost('gender'),
            'nip'         => $this->request->getPost('nip'),
            'phone'       => $this->request->getPost('phone'),
            'institution' => $this->request->getPost('institution'),
            'position'    => $this->request->getPost('position'),
            'dinas'       => $this->request->getPost('dinas'),
            'email'       => $newEmail,
        ];

        $userModel->update($userId, $data);

        if ($newEmail !== $currentUser['email']) {
            session()->destroy();
            return redirect()->to('/login')->with('success', 'Email berhasil diubah. Silakan login dengan email baru.');
        } else {
            session()->set($data);
            return redirect()->to('/profile')->with('success', 'Profil berhasil diperbarui.');
        }
    }
}
