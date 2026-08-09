<?php

Route::get('/', function () { return redirect('/login'); });
Route::get('/login', 'AuthController@showLogin')->name('login');
Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout')->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    // Modul Medis
    Route::get('/medis', 'MedisController@index');
    Route::get('/medis/create', 'MedisController@create');
    Route::post('/medis/store', 'MedisController@store');
    Route::get('/medis/{id}/edit', 'MedisController@edit');
    Route::post('/medis/{id}/update', 'MedisController@update');
    Route::post('/medis/{id}/delete', 'MedisController@destroy');

    // Modul SDM & Anggota
    Route::get('/anggota', 'SamaptaController@indexAnggota');
    Route::get('/anggota/tambah-personil', function() { return view('samapta.tambah_personil'); });
    Route::get('/anggota/edit-personil/{id}', 'SamaptaController@editPersonil');
    Route::get('/samapta', 'SamaptaController@index');
    Route::get('/samapta/create', 'SamaptaController@create');
    Route::post('/samapta/store', 'SamaptaController@store');
    Route::get('/samapta/{id}/edit', 'SamaptaController@edit');
    Route::post('/samapta/{id}/update', 'SamaptaController@update');
    Route::post('/samapta/{id}/delete', 'SamaptaController@destroy');

    // Modul Laporan & Riwayat
    Route::get('/laporan/rekap', 'LaporanController@rekap');
    Route::get('/anggota/{id}/riwayat', 'LaporanController@riwayatPersonil');

    // Modul Persetujuan
    Route::get('/pengajuan/persetujuan', 'PengajuanController@indexPersetujuan');
    Route::post('/pengajuan/ajukan', 'PengajuanController@ajukan');
    Route::post('/pengajuan/ajukan-edit/{id}', 'PengajuanController@ajukanEdit');
    Route::post('/pengajuan/ajukan-hapus/{id}', 'PengajuanController@ajukanHapus');
    Route::post('/pengajuan/setujui/{id}', 'PengajuanController@setujui');
    Route::post('/pengajuan/tolak/{id}', 'PengajuanController@tolak');
    Route::post('/pengajuan/setujui-semua/{satker}', 'PengajuanController@setujuiSemua');
});