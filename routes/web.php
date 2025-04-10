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
use App\Http\Middleware\AuthenticateRole;
use App\Http\Controllers\PDFController;


Route::get('/', function () {
    return view('welcome');
});

// Route::get('/insert-users', function() {
//     DB::table('user')->insert([
//         ['nama' => 'TU', 'email' => 'tu@example.com', 'password' => bcrypt('password123'), 'id_roles' => 3, 'created_at' => now(), 'updated_at' => now()],
//     ]);
//     return "Users inserted!";
// });

Route::post('/kaprodi/terima/{id}', [KaprodiController::class, 'acc'])->name('surat.acc');
Route::post('/kaprodi/tolak/{id}', [KaprodiController::class, 'tolakSurat'])->name('surat.tolak');



// Route to show the login form
Route::get('auth/login_karyawan', [LoginController::class, 'index_karyawan']);

// Route to handle the login process
Route::post('auth/login_karyawan', [LoginController::class, 'login_karyawan'])->name('login_karyawan');

// login mahasiswa
Route::get('login_mahasiswa', [LoginController::class, 'index_mahasiswa']);
Route::post('login_mahasiswa', [LoginController::class, 'login_mahasiswa'])->name('login_mahasiswa');
Route::get('/login_mahasiswa', function () {
    return view('auth/login_mahasiswa');
});


// Terapkan Middleware di Semua Route
Route::middleware([AuthenticateRole::class])->group(function () {
    
    //return view login
    Route::get('/kaprodi/index', [KaprodiController::class, 'index'])->name('kaprodi.index');
    Route::get('/tu/index', [TUController::class, 'index'])->name('tu.index');
    Route::get('/admin/index', [AdminController::class, 'index'])->name('admin.index');

    


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


    Route::prefix('admin')->group(function () {
        // admin
        // Insert mahasiswa IT
        Route::get('/admin/mahasiswaTI/index', [AdminController::class, 'DataMahasiswaTI'])->name('data.mahasiswaTI');
        Route::get('/admin/mahasiswaTI/create', [AdminController::class, 'createMahasiswaTI'])->name('mahasiswa.createMahasiswaTI');
        Route::post('/admin/mahasiswaTI/create', [AdminController::class, 'storeMahasiswaTI'])->name('mahasiswa.storeMahasiswaTI');

        // Edit mahasiswa IT
        Route::get('/admin/mahasiswaTI/edit/{id}', [AdminController::class, 'editMahasiswaTI'])->name('mahasiswa.editMahasiswaTI');
        Route::post('/admin/mahasiswaTI/update/{id}', [AdminController::class, 'updateMahasiswaTI'])->name('mahasiswa.updateMahasiswaTI');
        Route::delete('/admin/mahasiswaTI/delete/{id}', [AdminController::class, 'deleteMahasiswaTI'])->name('mahasiswa.deleteMahasiswaTI');

        // Insert mahasiswa SI
        Route::get('/admin/mahasiswaSI/index', [AdminController::class, 'DataMahasiswaSI'])->name('data.mahasiswaSI');
        Route::get('/admin/mahasiswaSI/create', [AdminController::class, 'createMahasiswaSI'])->name('mahasiswa.createMahasiswaSI');
        Route::post('/admin/mahasiswaSI/create', [AdminController::class, 'storeMahasiswaSI'])->name('mahasiswa.storeMahasiswaSI');

        // Edit mahasiswa SI
        Route::get('/admin/mahasiswaSI/edit/{id}', [AdminController::class, 'editMahasiswaSI'])->name('mahasiswa.editMahasiswaSI');
        Route::post('/admin/mahasiswaSI/update/{id}', [AdminController::class, 'updateMahasiswaSI'])->name('mahasiswa.updateMahasiswaSI');
        Route::delete('/admin/mahasiswaSI/delete/{id}', [AdminController::class, 'deleteMahasiswaSI'])->name('mahasiswa.deleteMahasiswaSI');

        // Insert mahasiswa IK
        Route::get('/admin/mahasiswaIK/index', [AdminController::class, 'DataMahasiswaIK'])->name('data.mahasiswaIK');
        Route::get('/admin/mahasiswaIK/create', [AdminController::class, 'createMahasiswaIK'])->name('mahasiswa.createMahasiswaIK');
        Route::post('/admin/mahasiswaIK/create', [AdminController::class, 'storeMahasiswaIK'])->name('mahasiswa.storeMahasiswaIK');

        // Edit mahasiswa IK
        Route::get('/admin/mahasiswaIK/edit/{id}', [AdminController::class, 'editMahasiswaIK'])->name('mahasiswa.editMahasiswaIK');
        Route::post('/admin/mahasiswaIK/update/{id}', [AdminController::class, 'updateMahasiswaIK'])->name('mahasiswa.updateMahasiswaIK');
        Route::delete('/admin/mahasiswaIK/delete/{id}', [AdminController::class, 'deleteMahasiswaIK'])->name('mahasiswa.deleteMahasiswaIK');

        

        // kaprodi
        // Insert KaprodiTI
        Route::get('/admin/KaprodiTI/index', [AdminController::class, 'DataKaprodiTI'])->name('data.kaprodiTI');
        Route::get('/admin/KaprodiTI/create', [AdminController::class, 'createKaprodiTI'])->name('kaprodi.createKaprodiTI');
        Route::post('/admin/KaprodiTI/create', [AdminController::class, 'storeKaprodiTI'])->name('kaprodi.storeKaprodiTI');


        // tu


        // logout
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });
});

Route::middleware(['auth', AuthenticateRole::class . ':4'])->group(function () {

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

        // logout
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });



    









Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
