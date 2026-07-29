<?php

// 1. Jalur Utama & Autentikasi
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', 'AuthController@showLogin')->name('login');
Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout')->name('logout');

// 2. Jalur yang Harus Login (Auth)
Route::group(['middleware' => 'auth'], function () {
    
    // Dashboard Utama
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    // --- MODUL MEDIS ---
    Route::get('/medis', 'MedisController@index'); 
    Route::get('/medis/create', 'MedisController@create');
    Route::post('/medis/store', 'MedisController@store');
    Route::get('/medis/{id}/edit', 'MedisController@edit');
    Route::post('/medis/{id}/update', 'MedisController@update');
    Route::post('/medis/{id}/delete', 'MedisController@destroy');

    // Ganti bagian MODUL SAMAPTA kamu menjadi seperti ini:
    Route::get('/samapta', 'SamaptaController@index');         // <--- TAMBAHKAN INI (Pintu Utama)
    Route::get('/samapta/create', 'SamaptaController@create');   // (Pintu masuk ke Form)
    Route::post('/samapta/store', 'SamaptaController@store');    // (Proses simpan data)
    Route::post('/samapta/{id}/delete', 'SamaptaController@destroy'); // (Proses hapus data)

    // --- MODUL LAPORAN ---
    Route::get('/laporan/rekap', 'LaporanController@rekap');

});