<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Fresns Panel Tips Language Lines
    |--------------------------------------------------------------------------
    */

    'createSuccess' => 'Membuat Keberhasilan',
    'deleteSuccess' => 'Hapus Berhasil',
    'updateSuccess' => 'Perbarui Berhasil',
    'upgradeSuccess' => 'Tingkatkan Berhasil',
    'installSuccess' => 'Pasang Berhasil',
    'uninstallSuccess' => 'Copot Pemasangan Berhasil',

    'createFailure' => 'Buat Kegagalan',
    'deleteFailure' => 'Hapus Kegagalan',
    'updateFailure' => 'Kegagalan Pembaruan',
    'upgradeFailure' => 'Kegagalan Peningkatan',
    'installFailure' => 'Kegagalan Pemasangan',
    'downloadFailure' => 'Unduh Kegagalan',
    'uninstallFailure' => 'Kegagalan Penghapusan Instalasi',

    'copySuccess' => 'Salin kesuksesan',
    'viewLog' => 'Ada masalah dengan implementasi, silakan lihat log sistem Fresns untuk detailnya',
    // auth empty
    'auth_empty_title' => 'Harap gunakan portal yang benar untuk masuk ke panel',
    'auth_empty_description' => 'Anda telah keluar atau waktu login Anda telah habis, silakan kunjungi portal login untuk masuk kembali.',
    // request
    'request_in_progress' => 'permintaan sedang diproses...',
    'requestSuccess' => 'Permintaan Sukses',
    'requestFailure' => 'Permintaan Gagal',
    // install
    'install_not_entered_key' => 'Silakan masukkan kunci fresns',
    'install_not_entered_directory' => 'Silakan masukkan direktori',
    'install_not_upload_zip' => 'Silakan pilih paket instalasi',
    'install_in_progress' => 'Instal sedang berlangsung...',
    'install_end' => 'Akhir pemasangan',
    // upgrade
    'upgrade_none' => 'Tidak ada pembaruan',
    'upgrade_fresns' => 'Ada versi fresns baru yang tersedia untuk upgrade',
    'upgrade_fresns_tip' => 'Anda dapat meningkatkan ke',
    'upgrade_fresns_warning' => 'Harap buat cadangan database sebelum memutakhirkan untuk menghindari kehilangan data yang disebabkan oleh pemutakhiran yang tidak tepat.',
    'upgrade_confirm_tip' => 'Tentukan peningkatan?',
    'manual_upgrade_tip' => 'Upgrade ini tidak mendukung upgrade otomatis, silakan gunakan metode "upgrade fisik".',
    'manual_upgrade_version_guide' => 'Klik untuk membaca deskripsi pembaruan versi ini',
    'manual_upgrade_guide' => 'Panduan Peningkatan',
    'manual_upgrade_file_error' => 'Ketidakcocokan file peningkatan fisik',
    'manual_upgrade_confirm_tip' => 'Pastikan Anda telah membaca "Panduan Peningkatan" dan memproses file versi baru sesuai dengan panduan.',
    'upgrade_in_progress' => 'Peningkatan sedang berlangsung...',
    'auto_upgrade_step_1' => 'Verifikasi inisialisasi',
    'auto_upgrade_step_2' => 'Unduh Paket Aplikasi',
    'auto_upgrade_step_3' => 'Paket aplikasi unzip',
    'auto_upgrade_step_4' => 'Upgrade Aplikasi',
    'auto_upgrade_step_5' => 'Mengosongkan cache',
    'auto_upgrade_step_6' => 'Menyelesaikan',
    'manualUpgrade_step_1' => 'Verifikasi inisialisasi',
    'manualUpgrade_step_2' => 'Perbarui data',
    'manualUpgrade_step_3' => 'Instal semua paket ketergantungan plugin (langkah ini adalah proses yang lambat, harap bersabar)',
    'manualUpgrade_step_4' => 'Publikasikan dan kembalikan ekstensi aktif',
    'manualUpgrade_step_5' => 'Perbarui informasi versi Fresns',
    'manualUpgrade_step_6' => 'Mengosongkan cache',
    'manualUpgrade_step_7' => 'Menyelesaikan',
    // uninstall
    'uninstall_in_progress' => 'Pencopotan sedang berlangsung...',
    'uninstall_step_1' => 'Verifikasi inisialisasi',
    'uninstall_step_2' => 'Pengolahan data',
    'uninstall_step_3' => 'Hapus file',
    'uninstall_step_4' => 'Cure cache',
    'uninstall_step_5' => 'Selesai',
    // delete app
    'delete_app_warning' => 'Jika Anda tidak ingin menampilkan peringatan pembaruan untuk aplikasi, Anda dapat menghapus aplikasi tersebut. Setelah dihapus, Anda tidak akan lagi diberi peringatan ketika versi baru tersedia.',
    // website
    'website_path_empty_error' => 'Gagal menyimpan, parameter jalur tidak diperbolehkan kosong',
    'website_path_format_error' => 'Gagal disimpan, parameter jalur hanya didukung dalam huruf Inggris biasa',
    'website_path_reserved_error' => 'Simpan gagal, parameter jalur berisi nama parameter yang dicadangkan sistem',
    'website_path_unique_error' => 'Gagal menyimpan, parameter jalur duplikat, nama parameter jalur tidak diperbolehkan untuk saling mengulang',
    // others
    'account_not_found' => 'Akun tidak ada atau masukkan kesalahan',
    'account_login_limit' => 'Kesalahan telah melampaui batas sistem. Silakan masuk lagi 1 jam kemudian',
    'timezone_error' => 'Zona waktu basis data tidak cocok dengan zona waktu di file konfigurasi .env',
    'timezone_env_edit_tip' => 'Harap ubah item konfigurasi pengidentifikasi zona waktu di file .env',
    'secure_entry_route_conflicts' => 'Konflik perutean masuk keselamatan',
    'language_exists' => 'Bahasa sudah ada',
    'language_not_exists' => 'bahasa tidak ada',
    'plugin_not_exists' => 'plugin tidak ada',
    'map_exists' => 'Penyedia layanan peta telah digunakan dan tidak dapat dibuat ulang',
    'map_not_exists' => 'peta tidak ada',
    'required_user_role_name' => 'Silakan isi nama perannya',
    'required_sticker_category_name' => 'Silakan isi nama grup ekspresi',
    'required_group_category_name' => 'Silakan isi nama klasifikasi grup',
    'required_group_name' => 'Silakan isi nama grup',
    'delete_group_category_error' => 'Ada kelompok dalam klasifikasi, tidak memungkinkan penghapusan',
    'delete_default_language_error' => 'Bahasa default tidak dapat dihapus',
    'account_connect_services_error' => 'Dukungan interkoneksi pihak ketiga memiliki platform yang saling terhubung berulang',
    'post_datetime_select_error' => 'Rentang tanggal pengaturan pos tidak boleh kosong',
    'post_datetime_select_range_error' => 'Tanggal akhir pengaturan pos tidak boleh kurang dari tanggal mulai',
    'comment_datetime_select_error' => 'Rentang tanggal yang ditetapkan oleh komentar tidak boleh kosong',
    'comment_datetime_select_range_error' => 'Tanggal akhir pengaturan komentar tidak boleh kurang dari tanggal mulai',
];
