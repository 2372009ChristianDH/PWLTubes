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
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;


Route::get('/', function () {
    return view('welcome');
});




Route::get('/lihat-surat/{filename}', function ($filename) {
    $path = storage_path('app/public/surat_pdf/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    return Response::download($path);
});



// Route::get('/insert-users', function() {
//     DB::table('user')->insert([
//         ['nama' => 'Admin', 'email' => '10000001@maranatha.ac.id', 'password' => bcrypt('password123'), 'id_roles' => 1, 'created_at' => now(), 'updated_at' => now()],
//     ]);
//     return "Users inserted!";
// });




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
Route::middleware([AuthenticateRole::class . ':1'])->group(function () {
    Route::get('/admin/index', [AdminController::class, 'index'])->name('admin.index');
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
    // Insert Kaprodi TI
    Route::get('/admin/KaprodiTI/index', [AdminController::class, 'DataKaprodiTI'])->name('data.kaprodiTI');
    Route::get('/admin/KaprodiTI/create', [AdminController::class, 'createKaprodiTI'])->name('kaprodi.createKaprodiTI');
    Route::post('/admin/KaprodiTI/create', [AdminController::class, 'storeKaprodiTI'])->name('kaprodi.storeKaprodiTI');
    // Edit Kaprodi TI
    Route::get('/admin/KaprodiTI/edit/{id}', [AdminController::class, 'editKaprodiTI'])->name('kaprodi.editKaprodiTI');
    Route::post('/admin/KaprodiTI/update/{id}', [AdminController::class, 'updateKaprodiTI'])->name('kaprodi.updateKaprodiTI');
    Route::delete('/admin/KaprodiTI/delete/{id}', [AdminController::class, 'deleteKaprodiTI'])->name('kaprodi.deleteKaprodiTI');

    // Insert Kaprodi SI
    Route::get('/admin/KaprodiSI/index', [AdminController::class, 'DataKaprodiSI'])->name('data.kaprodiSI');
    Route::get('/admin/KaprodiSI/create', [AdminController::class, 'createKaprodiSI'])->name('kaprodi.createKaprodiSI');
    Route::post('/admin/KaprodiSI/create', [AdminController::class, 'storeKaprodiSI'])->name('kaprodi.storeKaprodiSI');
    // Edit Kaprodi SI
    Route::get('/admin/KaprodiSI/edit/{id}', [AdminController::class, 'editKaprodiSI'])->name('kaprodi.editKaprodiSI');
    Route::post('/admin/KaprodiSI/update/{id}', [AdminController::class, 'updateKaprodiSI'])->name('kaprodi.updateKaprodiSI');
    Route::delete('/admin/KaprodiSI/delete/{id}', [AdminController::class, 'deleteKaprodiSI'])->name('kaprodi.deleteKaprodiSI');

    // Insert Kaprodi IK
    Route::get('/admin/KaprodiIK/index', [AdminController::class, 'DataKaprodiIK'])->name('data.kaprodiIK');
    Route::get('/admin/KaprodiIK/create', [AdminController::class, 'createKaprodiIK'])->name('kaprodi.createKaprodiIK');
    Route::post('/admin/KaprodiIK/create', [AdminController::class, 'storeKaprodiIK'])->name('kaprodi.storeKaprodiIK');
    // Edit Kaprodi IK
    Route::get('/admin/KaprodiIK/edit/{id}', [AdminController::class, 'editKaprodiIK'])->name('kaprodi.editKaprodiIK');
    Route::post('/admin/KaprodiIK/update/{id}', [AdminController::class, 'updateKaprodiIK'])->name('kaprodi.updateKaprodiIK');
    Route::delete('/admin/KaprodiIK/delete/{id}', [AdminController::class, 'deleteKaprodiIK'])->name('kaprodi.deleteKaprodiIK');




    // tu TI
    Route::get('/admin/tuTI/index', [AdminController::class, 'DatatuTI'])->name('data.tuTI');
    Route::get('/admin/tuTI/create', [AdminController::class, 'createtuTI'])->name('tu.createtuTI');
    Route::post('/admin/tuTI/create', [AdminController::class, 'storetuTI'])->name('tu.storetuTI');
    // Edit TU TI
    Route::get('/admin/tuTI/edit/{id}', [AdminController::class, 'edittuTI'])->name('tu.edittuTI');
    Route::post('/admin/tuTI/update/{id}', [AdminController::class, 'updatetuTI'])->name('tu.updatetuTI');
    Route::delete('/admin/tuTI/delete/{id}', [AdminController::class, 'deletetuTI'])->name('tu.deletetuTI');


    // tu SI
    Route::get('/admin/tuSI/index', [AdminController::class, 'DatatuSI'])->name('data.tuSI');
    Route::get('/admin/tuSI/create', [AdminController::class, 'createtuSI'])->name('tu.createtuSI');
    Route::post('/admin/tuSI/create', [AdminController::class, 'storetuSI'])->name('tu.storetuSI');
    // Edit TU SI
    Route::get('/admin/tuSI/edit/{id}', [AdminController::class, 'edittuSI'])->name('tu.edittuSI');
    Route::post('/admin/tuSI/update/{id}', [AdminController::class, 'updatetuSI'])->name('tu.updatetuSI');
    Route::delete('/admin/tuSI/delete/{id}', [AdminController::class, 'deletetuSI'])->name('tu.deletetuSI');


    // tu IK
    Route::get('/admin/tuIK/index', [AdminController::class, 'DatatuIK'])->name('data.tuIK');
    Route::get('/admin/tuIK/create', [AdminController::class, 'createtuIK'])->name('tu.createtuIK');
    Route::post('/admin/tuIK/create', [AdminController::class, 'storetuIK'])->name('tu.storetuIK');
    // Edit TU IK
    Route::get('/admin/tuIK/edit/{id}', [AdminController::class, 'edittuIK'])->name('tu.edittuIK');
    Route::post('/admin/tuIK/update/{id}', [AdminController::class, 'updatetuIK'])->name('tu.updatetuIK');
    Route::delete('/admin/tuIK/delete/{id}', [AdminController::class, 'deletetuIK'])->name('tu.deletetuIK');

    // logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Route Ketua Program Studi
Route::middleware([AuthenticateRole::class . ':2'])->group(function () {
    Route::get('/kaprodi/index', [KaprodiController::class, 'index'])->name('kaprodi.index');

    // Kelola Surat Kaprodi
    Route::get('/kaprodi/kelolaSurat/index', [KaprodiController::class, 'kelolaSurat'])->name('kaprodi.kelolaSurat');
    Route::post('/kaprodi/terima/{id}', [KaprodiController::class, 'kaprodi_acc'])->name('kaprodi.surat_acc');
    Route::post('/kaprodi/tolak/{id}', [KaprodiController::class, 'kaprodi_tolakSurat'])->name('kaprodi.surat_tolak');
});


// Route Tata Usaha
Route::middleware([AuthenticateRole::class . ':3'])->group(function () {
    Route::get('/tu/index', [TUController::class, 'index'])->name('tu.index');

    // Kelola Surat TU
    Route::get('/tu/kelolaSurat/index', [TuController::class, 'kelolaSurat'])->name('tu.kelolaSurat');
    // Form kirim PDF
    Route::get('/tu/create/{id}', [TUController::class, 'create'])->name('tu.form_kirim_pdf');
    // Aksi kirim PDF
    Route::post('/tu/surat/{id}/kirim', [TUController::class, 'store'])->name('tu.kirim_pdf');

});


Route::middleware([AuthenticateRole::class . ':4'])->group(function () {
    Route::get('/mahasiswa/index', [MahasiswaController::class, 'index'])->name('mahasiswaList');
    Route::get('/mahasiswa/histori/index', [MahasiswaController::class, 'histori']);
    // Store Form Mahasiswa
    Route::get('/mahasiswa/create_keaktifan', function () {
        return view('mahasiswa.create_keaktifan');
    })->name('form_surat_keaktifan');
    Route::post('/mahasiswa/create_keaktifan', [MahasiswaController::class, 'store_keaktifan'])->name('surat_keaktifan');
    Route::post('/mahasiswa/create_keaktifan/{id}', [MahasiswaController::class, 'update_keaktifan'])->name('update_keaktifan');

    Route::get('/mahasiswa/create_lhs', function () {
        return view('mahasiswa.create_lhs');
    })->name('form_surat_lhs');
    Route::post('/mahasiswa/create_lhs', [MahasiswaController::class, 'store_lhs'])->name('surat_lhs');
    Route::post('/mahasiswa/create_lhs/{id}', [MahasiswaController::class, 'update_lhs'])->name('update_lhs');

    Route::get('/mahasiswa/create_ptmk', function () {
        return view('mahasiswa.create_ptmk');
    })->name('form_surat_ptmk');
    Route::post('/mahasiswa/create_ptmk', [MahasiswaController::class, 'store_ptmk'])->name('surat_ptmk');
    Route::post('/mahasiswa/create_ptmk/{id}', [MahasiswaController::class, 'update_ptmk'])->name('update_ptmk');

    Route::get('/mahasiswa/create_lulus', function () {
        return view('mahasiswa.create_lulus');
    })->name('form_surat_lulus');
    Route::post('/mahasiswa/create_lulus', [MahasiswaController::class, 'store_lulus'])->name('surat_lulus');
    Route::post('/mahasiswa/create_lulus/{id}', [MahasiswaController::class, 'update_lulus'])->name('update_lulus');


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


    // Histori Pengajuan
    Route::get('/mahasiswa/histori/index', [MahasiswaController::class, 'histori'])->name('mahasiswa.histori/index');

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

require __DIR__ . '/auth.php';
