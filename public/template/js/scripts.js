$(document).ready(function () {
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector('#adminRegisterForm');

    form.addEventListener('submit', function (e) {
        const fullName = form.full_name.value.trim();
        const gender = form.gender.value;
        const nip = form.nip.value.trim();
        const phone = form.phone.value.trim();
        const institution = form.institution.value.trim();
        const dinas = form.dinas.value;
        const position = form.position.value;
        const email = form.email.value.trim();
        const password = form.password.value;
        const repeatPassword = form.repeat_password.value;
        const recaptchaResponse = grecaptcha.getResponse();

        function isValidEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }

        function isValidNIP(nip) {
            return /^\d{8,18}$/.test(nip);
        }

        function isValidPhone(phone) {
            return /^\d{9,15}$/.test(phone);
        }

        if (fullName === '') {
            alert('Nama Lengkap harus diisi.');
            form.full_name.focus();
            e.preventDefault();
            return false;
        }
        if (gender === '') {
            alert('Jenis Kelamin harus dipilih.');
            form.gender.focus();
            e.preventDefault();
            return false;
        }
        if (!isValidNIP(nip)) {
            alert('NIP harus berupa angka dengan panjang 8-18 digit.');
            form.nip.focus();
            e.preventDefault();
            return false;
        }
        if (!isValidPhone(phone)) {
            alert('No. Telepon harus berupa angka dengan panjang 9-15 digit.');
            form.phone.focus();
            e.preventDefault();
            return false;
        }
        if (institution === '') {
            alert('Instansi harus diisi.');
            form.institution.focus();
            e.preventDefault();
            return false;
        }
        if (dinas === '') {
            alert('Dinas harus dipilih.');
            form.dinas.focus();
            e.preventDefault();
            return false;
        }
        if (position === '') {
            alert('Jabatan harus dipilih.');
            form.position.focus();
            e.preventDefault();
            return false;
        }
        if (!isValidEmail(email)) {
            alert('Format email tidak valid.');
            form.email.focus();
            e.preventDefault();
            return false;
        }
        if (password.length < 6) {
            alert('Password minimal 6 karakter.');
            form.password.focus();
            e.preventDefault();
            return false;
        }
        if (password !== repeatPassword) {
            alert('Password dan Ulangi Password tidak cocok.');
            form.repeat_password.focus();
            e.preventDefault();
            return false;
        }
        if (recaptchaResponse.length === 0) {
            alert('Mohon centang reCAPTCHA.');
            e.preventDefault();
            return false;
        }
    });
});
