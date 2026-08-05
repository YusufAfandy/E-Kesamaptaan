<?php

// =========================================================================
// 1. JALUR UTAMA & SISTEM AUTENTIKASI (LOGIN/LOGOUT)
// =========================================================================
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', 'AuthController@showLogin')->name('login');
Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout')->name('logout');


// =========================================================================
// 2. AREA TERPROTEKSI (SELURUH USER HARUS LOGIN)
// =========================================================================
Route::group(['middleware' => 'auth'], function () {
    
    // DASHBOARD UTAMA
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');


    // ---------------------------------------------------------------------
    // MODUL MEDIS (KHUSUS URKES)
    // ---------------------------------------------------------------------
    Route::get('/medis', 'MedisController@index');             
    Route::get('/medis/create', 'MedisController@create');     
    Route::post('/medis/store', 'MedisController@store');       
    Route::get('/medis/{id}/edit', 'MedisController@edit');     
    Route::post('/medis/{id}/update', 'MedisController@update'); 
    Route::post('/medis/{id}/delete', 'MedisController@destroy');


    // ---------------------------------------------------------------------
    // MODUL DATABASE ANGGOTA (SISI IDENTITAS - SDM)
    // ---------------------------------------------------------------------
    Route::get('/anggota', 'SamaptaController@indexAnggota'); 
    Route::get('/anggota/tambah-personil', function() { 
        return view('samapta.tambah_personil'); 
    });
    Route::get('/anggota/edit-personil/{id}', 'SamaptaController@editPersonil');


    // ---------------------------------------------------------------------
    // MODUL NILAI SAMAPTA (SISI SKOR/ANGKA - SDM)
    // ---------------------------------------------------------------------
    Route::get('/samapta', 'SamaptaController@index');           // Daftar Nilai
    Route::get('/samapta/create', 'SamaptaController@create');   // Form Input Baru
    Route::post('/samapta/store', 'SamaptaController@store');     // Proses Simpan

    // REVISI: TAMBAHKAN RUTE EDIT & UPDATE NILAI DI SINI
    Route::get('/samapta/{id}/edit', 'SamaptaController@edit');     // Form Edit Nilai
    Route::post('/samapta/{id}/update', 'SamaptaController@update'); // Proses Simpan Perubahan

    Route::post('/samapta/{id}/delete', 'SamaptaController@destroy'); // Proses Hapus Nilai


    // ---------------------------------------------------------------------
    // MODUL PENGAJUAN & PERSETUJUAN (LOGIKA PROSES BIROKRASI)
    // ---------------------------------------------------------------------
    Route::post('/pengajuan/ajukan', 'PengajuanController@ajukan');           
    Route::post('/pengajuan/ajukan-edit/{id}', 'PengajuanController@ajukanEdit'); 
    Route::post('/pengajuan/ajukan-hapus/{id}', 'PengajuanController@ajukanHapus');

    Route::get('/pengajuan/persetujuan', 'PengajuanController@indexPersetujuan'); 
    Route::post('/pengajuan/setujui/{id}', 'PengajuanController@setujui');       
    Route::post('/pengajuan/tolak/{id}', 'PengajuanController@tolak');           
    Route::post('/pengajuan/setujui-semua/{satker}', 'PengajuanController@setujuiSemua'); 


    // ---------------------------------------------------------------------
    // MODUL LAPORAN GLOBAL
    // ---------------------------------------------------------------------
    Route::get('/laporan/rekap', 'LaporanController@rekap');

});