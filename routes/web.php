<?php

use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TUController;
use App\Http\Controllers\KaprodiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\LoginController;

// Route to show the login form
Route::get('login_karyawan', [LoginController::class, 'index_karyawan']);

// Route to handle the login process
Route::post('login_karyawan', [LoginController::class, 'login_karyawan'])->name('login_karyawan');
//return view login
Route::get('/kaprodi/index', [KaprodiController::class, 'index'])->name('kaprodi.index');
Route::get('/tu/index', [TUController::class, 'index'])->name('tu.index');
Route::get('/admin/index', [AdminController::class, 'index'])->name('admin.index');
// Route::get('/karyawan', function () {
//     return view('karyawan/index');
// });




Route::get('/', function () {
    return view('welcome');
});

Route::get('/login_karyawan', function () {
    return view('auth.login_karyawan');
});

Route::get('/insert-users', function() {
    DB::table('user')->insert([
        ['nama' => 'Antony', 'email' => 'anton@example.com', 'password' => bcrypt('password123'), 'id_roles' => 4, 'created_at' => now(), 'updated_at' => now()],
    ]);
    return "Users inserted!";
});


// Route::get('/insert-karyawan', function() {
//     DB::table('karyawan')->insert([
//         [
//             'nik' => '12345678',
//             'id_users' => 2, // Assuming this user ID exists in the users table
//             'created_at' => now(),
//             'updated_at' => now(),
//         ],
//         [
//             'nik' => '87654321',
//             'id_users' => 3, // Assuming this user ID exists in the users table
//             'created_at' => now(),
//             'updated_at' => now(),
//         ],
//     ]);

//     return "Dummy karyawan data inserted!";
// });


// login mahasiswa
Route::get('login_mahasiswa', [LoginController::class, 'index_mahasiswa']);
Route::post('login_mahasiswa', [LoginController::class, 'login_mahasiswa'])->name('login_mahasiswa');
Route::get('/login_mahasiswa', function () {
    return view('auth/login_mahasiswa');
});

// mahasiswa index
Route::get('/mahasiswa/index', [MahasiswaController::class, 'index'])->name('mahasiswaList');

// Store Form Mahasiswa
Route::get('/mahasiswa/create_keaktifan', function () {
    return view('mahasiswa.create_keaktifan');
})->name('form_surat_keaktifan');
Route::post('/mahasiswa/create_keaktifan', [MahasiswaController::class, 'store_keaktifan'])->name('surat_keaktifan');

Route::get('/mahasiswa/create_lhs', function () {
    return view('mahasiswa.create_lhs');
})->name('form_surat_lhs');
Route::post('/mahasiswa/create_lhs', [MahasiswaController::class, 'store_lhs'])->name('surat_lhs');

Route::get('/mahasiswa/create_ptmk', function () {
    return view('mahasiswa.create_ptmk');
})->name('form_surat_ptmk');
Route::post('/mahasiswa/create_ptmk', [MahasiswaController::class, 'store_ptmk'])->name('surat_ptmk');

Route::get('/mahasiswa/create_lulus', function () {
    return view('mahasiswa.create_lulus');
})->name('form_surat_lulus');
Route::post('/mahasiswa/create_lulus', [MahasiswaController::class, 'store_lulus'])->name('surat_lulus');


// return form surat
Route::get('/create_keaktifan', function () {
    return view('mahasiswa/create_keaktifan');
});

Route::get('/create_lhs', function () {
    return view('mahasiswa/create_lhs');
});

Route::get('/create_ptmk', function () {
    return view('mahasiswa/create_ptmk');
});

Route::get('/create_lulus', function () {
    return view('mahasiswa/create_lulus');
});

Route::get('/mahasiswa/dashboard', function () {
    return view('mahasiswa.index');
})->name('mahasiswa.dashboard');


// admin
Route::get('/admin/mahasiswaTI/index', [AdminController::class, 'DataMahasiswa'])->name('data.mahasiswaTI');
Route::get('/admin/mahasiswaTI/create', [AdminController::class, 'create'])->name('mahasiswa.create');
Route::post('/admin/mahasiswaTI/create', [AdminController::class, 'store'])->name('mahasiswa.store');
// kaprodi

// tu




// logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
