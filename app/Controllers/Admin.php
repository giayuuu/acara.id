<?php

namespace App\Controllers;
use App\Models\EventModel;
use App\Models\UserModel;

class Admin extends BaseController
{
    public function addEventForm()
    {
        return view('event/form_add');
    }

    public function saveEvent()
    {
        $eventModel = new EventModel();

        $data = [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'date'        => $this->request->getPost('date'),
            'quota'       => $this->request->getPost('quota'),
        ];

        $eventModel->save($data);
        return redirect()->to('/admin/events')->with('success', 'Acara berhasil ditambahkan.');
    }

    public function participants()
    {
        return view('admin/participants');
    }

    public function listAdmindinas()
    {
        $userModel = new UserModel();

        // Admin dinas yang belum disetujui
        $pendingAdmins = $userModel
            ->where('role', 'admindinas')
            ->where('is_approved', 0)
            ->findAll();

        // Admin dinas yang sudah disetujui
        $approvedAdmins = $userModel
            ->where('role', 'admindinas')
            ->where('is_approved', 1)
            ->findAll();

        return view('admin/daftar_admindinas', [
            'admindinas' => $pendingAdmins,
            'approvedAdmins' => $approvedAdmins
        ]);
    }

    public function approveAdmindinas($id)
    {
        $userModel = new UserModel();
        $userModel->update($id, ['is_approved' => 1]);

        return redirect()->to('/admin/approval')->with('success', 'Akun admindinas disetujui.');
    }

    public function rejectAdmindinas($id)
    {
        $userModel = new UserModel();
        $admin = $userModel->find($id);

        if (!$admin) {
            return redirect()->to('/admin/approval')->with('error', 'Admin tidak ditemukan.');
        }

        if ($admin['role'] !== 'admindinas') {
            return redirect()->to('/admin/approval')->with('error', 'Hanya akun admindinas yang bisa dihapus lewat fitur ini.');
        }

        $userModel->delete($id);

        return redirect()->to('/admin/approval')->with('success', 'Akun admindinas ditolak dan dihapus.');
    }

    public function deleteAdmindinas($id)
{
    $userModel = new UserModel();
    $admin = $userModel->find($id);

    if (!$admin) {
        return redirect()->to('/admin/approval')->with('error', 'Admin tidak ditemukan.');
    }

    if ($admin['role'] !== 'admindinas') {
        return redirect()->to('/admin/approval')->with('error', 'Hanya akun admindinas yang bisa dihapus lewat fitur ini.');
    }

    $userModel->delete($id);

    return redirect()->to('/admin/approval')->with('success', 'Akun admindinas berhasil dihapus.');
}

}
