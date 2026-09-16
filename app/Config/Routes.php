<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ======================
// Rute Publik (Tidak Butuh Login)
// ======================
$routes->get('/', 'Auth::login');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::loginProcess');
$routes->get('/register-choice', 'Auth::registerChoice');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::registerProcess');
$routes->get('forgot-password', 'Auth::forgotPassword');
$routes->post('forgot-password', 'Auth::forgotPasswordProcess');
$routes->get('/logout', 'Auth::logout');


// ==========================
// Rute Pendaftaran Admin Dinas
// ==========================
$routes->get('/register-admindinas', 'Auth::registerAdmindinas');
$routes->post('/register-admindinas', 'Auth::registerAdmindinasProcess');
$routes->get('auth/registerAdmindinas', 'Auth::registerAdmindinas');
$routes->post('auth/saveAdmindinas', 'Auth::saveAdmindinas');
$routes->post('/auth/registerAdmindinasProcess', 'Auth::registerAdmindinasProcess');


// ======================
// Rute Grup yang Butuh Login & Filter Auth
// ======================
$routes->group('', ['filter' => 'auth'], function ($routes) {

  // Dashboard & Profil
  $routes->get('/dashboard', 'Dashboard::index');
  $routes->get('/profile', 'Dashboard::profile');
  $routes->post('/profile/update', 'Dashboard::updateProfile');

  // Admin Event Management (admin biasa)
  $routes->get('/admin/event/add', 'Event::add');
  $routes->post('/admin/event/save', 'Event::save');
  $routes->post('/admin/event/update', 'Event::update');
  $routes->post('/admin/event/delete', 'Event::delete');

  // Admin Participants & Attendance (admin biasa)
  $routes->get('/admin/participants', 'Event::participants');
  $routes->get('/admin/attendance', 'Attendance::attendanceList');

  // Admin Event Data & QR Scan (admin biasa)
  $routes->get('/admin/event/data', 'Event::dataEvent');
  $routes->get('/admin/scan', 'Attendance::scanPage');
  $routes->post('/admin/scan', 'Attendance::processScan');

  // Approval Admin Dinas (admin utama)
  $routes->get('/admin/approval', 'Admin::listAdmindinas');                   // menampilkan list admin dinas pending approval
  $routes->get('/admin/approval/approve/(:num)', 'Admin::approveAdmindinas/$1'); // approve admin dinas
  $routes->get('/admin/approval/reject/(:num)', 'Admin::rejectAdmindinas/$1');
  $routes->get('admin/approval/delete/(:num)', 'Admin::deleteAdmindinas/$1');

  // reject admin dinas

  // Event & User Actions
  $routes->get('/events', 'Event::list');
  $routes->get('/event/register/(:num)', 'Event::registerForm/$1');
  $routes->post('/event/register', 'Event::registerProcess');
  $routes->post('/event/register/submit', 'Event::registerSubmit');
  $routes->get('event/cetak_pdf/(:num)', 'Event::cetak_pdf/$1');


  // Event Scan & Participants
  $routes->get('/event/scan', 'Event::scanView');
  $routes->post('/event/scanQr', 'Event::scanQr');
  $routes->get('/event/participants', 'Event::participants');

  // User History
  $routes->get('/history', 'Dashboard::history');
});

// ======================
// Rute Khusus untuk Admin Dinas
// ======================
$routes->group('admindinas', ['filter' => ['auth', 'admindinas']], function ($routes) {
  $routes->get('dashboard', 'AdminDinas::dashboard');
  $routes->get('admindinas/dashboard', 'Admindinas::dashboard');
  $routes->get('event/add', 'AdminDinas::addEventForm');
  $routes->post('event/save', 'AdminDinas::saveEvent');
  $routes->post('event/update', 'AdminDinas::updateEvent');
  $routes->post('event/delete', 'AdminDinas::deleteEvent');

  $routes->get('participants', 'AdminDinas::participants');
  $routes->get('attendance', 'AdminDinas::attendanceList');

  $routes->get('event/data', 'AdminDinas::dataEvent');
  $routes->get('scan', 'AdminDinas::scanPage');
  $routes->post('scan', 'AdminDinas::processScan');
});
