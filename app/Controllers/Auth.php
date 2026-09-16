<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function loginProcess()
    {
        $recaptcha = $this->request->getPost('g-recaptcha-response');
        $secret = config('Recaptcha')->secretKey;
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$recaptcha");
        $responseKeys = json_decode($response, true);

        if (!$responseKeys["success"]) {
            return redirect()->back()->with('error', 'Captcha tidak valid.');
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak ditemukan.');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Password salah.');
        }

        // Pastikan email ini yang terbaru
        if ($email !== $user['email']) {
            return redirect()->back()->with('error', 'Email tidak valid.');
        }

        // Admin dinas belum disetujui
        if ($user['role'] === 'admindinas' && $user['is_approved'] != 1) {
            return redirect()->to('/login')->with('error', 'Akun Anda belum disetujui.');
        }

        session()->set([
            'user_id'     => $user['id'],
            'role'        => $user['role'],
            'email'       => $user['email'],
            'full_name'   => $user['full_name'],
            'gender'      => $user['gender'],
            'nip'         => $user['nip'],
            'phone'       => $user['phone'],
            'institution' => $user['institution'],
            'position'    => $user['position'],
            'dinas'       => $user['dinas'] ?? null,
            'logged_in'   => true
        ]);

        return redirect()->to('/dashboard');
    }



    public function registerChoice()
    {
        return view('auth/registerChoice');
    }


    public function register()
    {
        return view('auth/register');
    }

    public function registerProcess()
    {
        // Validasi Captcha
        $recaptcha = $this->request->getPost('g-recaptcha-response');
        $secret = config('Recaptcha')->secretKey;
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$recaptcha");
        $responseKeys = json_decode($response, true);

        if (!$responseKeys["success"]) {
            return redirect()->back()->withInput()->with('error', 'Captcha tidak valid.');
        }

        $pass = $this->request->getPost('password');
        $repass = $this->request->getPost('repeat_password');
        if ($pass !== $repass) {
            return redirect()->back()->withInput()->with('error', 'Password tidak sama.');
        }

        $userModel = new UserModel();
        $userModel->insert([
            'full_name'   => $this->request->getPost('full_name'),
            'gender'      => $this->request->getPost('gender'),
            'nip'         => $this->request->getPost('nip'),
            'phone'       => $this->request->getPost('phone'),
            'institution' => $this->request->getPost('institution'),
            'position'    => $this->request->getPost('position'),
            'dinas'       => $this->request->getPost('dinas'),
            'email'       => $this->request->getPost('email'),
            'password'    => password_hash($pass, PASSWORD_DEFAULT),
            'role'        => 'user'
        ]);

        return redirect()->to('/login')->with('success', 'Pendaftaran berhasil. Silakan login.');
    }

    // --- Registrasi khusus admindinas ---
    public function registerAdmindinas()
    {
        return view('auth/register_admindinas');
    }

    public function registerAdmindinasProcess()
    {
        $pass = $this->request->getPost('password');
        $repass = $this->request->getPost('repeat_password');

        if ($pass !== $repass) {
            return redirect()->back()->withInput()->with('error', 'Password tidak sama.');
        }

        $userModel = new UserModel();

        // Validasi email sudah ada atau belum
        $email = $this->request->getPost('email');
        if ($userModel->where('email', $email)->first()) {
            return redirect()->back()->withInput()->with('error', 'Email sudah terdaftar.');
        }

        // Validasi dinas sudah terdaftar untuk role admindinas
        $dinas = $this->request->getPost('dinas');
        $existingDinas = $userModel->where('dinas', $dinas)
            ->where('role', 'admindinas')
            ->first();
        if ($existingDinas) {
            return redirect()->back()->withInput()->with('error', 'Dinas ini sudah terdaftar.');
        }

        $userModel->insert([
            'full_name'   => $this->request->getPost('full_name'),
            'gender'      => $this->request->getPost('gender'),
            'nip'         => $this->request->getPost('nip'),
            'phone'       => $this->request->getPost('phone'),
            'institution' => $this->request->getPost('institution'),
            'dinas'       => $dinas,
            'position'    => $this->request->getPost('position'),
            'email'       => $email,
            'password'    => password_hash($pass, PASSWORD_DEFAULT),
            'role'        => 'admindinas',
            'is_approved' => 0
        ]);

        return redirect()->to('/login')->with('success', 'Pendaftaran berhasil. Tunggu persetujuan admin.');
    }

    public function saveAdmindinas()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'name'     => 'required',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'username' => 'required|is_unique[users.username]',
            'password' => 'required|min_length[6]',
            'dinas'    => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $userModel = new \App\Models\UserModel();
        $userModel->save([
            'name'        => $this->request->getPost('name'),
            'email'       => $this->request->getPost('email'),
            'username'    => $this->request->getPost('username'),
            'password'    => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'dinas'       => $this->request->getPost('dinas'),
            'role'        => 'dinas',
            'is_approved' => 0,
        ]);

        return redirect()->to('/login')->with('message', 'Registrasi berhasil! Tunggu persetujuan dari admin utama.');
    }
    public function forgotPassword()
    {
        return view('auth/forgot_password');
    }

    public function forgotPasswordProcess()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $repass   = $this->request->getPost('repeat_password');

        if ($password !== $repass) {
            return redirect()->back()->withInput()->with('error', 'Password tidak sama.');
        }

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Email tidak ditemukan.');
        }

        $userModel->update($user['id'], [
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);

        return redirect()->to('/login')->with('success', 'Password berhasil direset. Silakan login kembali.');
    }




    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
