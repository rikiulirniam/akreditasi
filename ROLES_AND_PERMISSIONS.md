# Dokumentasi Standar Role & Permission API (Laravel 13)

Dokumen ini merupakan panduan implementasi otentikasi (**Authentication**) dan otorisasi (**Authorization**) untuk programmer yang bertanggung jawab mengimplementasikan autentikasi (Auth) pada REST API Sistem Akreditasi & SPMI.

---

## 1. Arsitektur & Standar Otorisasi Laravel

1. **Authentication Engine**: [Laravel Sanctum](https://laravel.com/docs/sanctum) menggunakan Bearer Token (`Authorization: Bearer <token>`).
2. **Authorization Engine**: Disarankan menggunakan library standar industri [Spatie Laravel-Permission](https://spatie.be/docs/laravel-permission) atau kombinasi **Middleware + Laravel Gates/Policies**.
3. **Format Naming Permission**: Menggunakan format dot notation terstandar: `<modul>.<submodul/fitur>.<aksi>` (contoh: `project.create`, `self_assessment.evaluate`, `spmi.tindak_lanjut`).

---

## 2. Definisi Role (4 Role Utama)

| No | Nama Role | Identifier Code | Deskripsi & Lingkup Wewenang |
|:--:|:---|:---|:---|
| 1 | **Admin** | `admin` | Administrator sistem institusi / SPMI pusat. Memiliki akses penuh terhadap seluruh master data, audit log, konfigurasi instrumen, dan pengawasan seluruh proyek akreditasi. |
| 2 | **Kaprodi** | `kaprodi` | Kepala Program Studi. Bertanggung jawab atas proyek akreditasi prodi miliknya, membagi penugasan tim (`mapping-tim`), mengelola data sarana & prasarana prodi, serta mengisi/mengupdate tindak lanjut temuan audit SPMI. |
| 3 | **Dosen** | `dosen` | Dosen / Tim Penyusun Akreditasi (PIC Indikator). Bertugas melihat indikator penugasan akreditasi, melengkapi data sarpras, dan memantau status evaluasi. |
| 4 | **Reviewer** | `reviewer` | Reviewer / Asesor Internal / Auditor Mutu. Bertugas melakukan pengisian nilai mandiri (**Self Assessment**), memilih rubrik penilaian skor terbobot, serta menginput dan mencatat temuan audit SPMI. |

---

## 3. Matriks Hak Akses Endpoint API

Berikut adalah matriks otorisasi per endpoint API yang telah terdaftar pada `routes/api.php`:

### A. Modul Master Data (`/api/v1/master/*`)

| Endpoint | Method | Permission Name | Admin | Kaprodi | Dosen | Reviewer |
|:---|:---:|:---|:---:|:---:|:---:|:---:|
| `/master/lembaga-akreditasi` | GET | `master.lembaga.view` | ✅ | ✅ | ✅ | ✅ |
| `/master/lembaga-akreditasi` | POST | `master.lembaga.manage` | ✅ | ❌ | ❌ | ❌ |
| `/master/lembaga-akreditasi/{id}` | GET | `master.lembaga.view` | ✅ | ✅ | ✅ | ✅ |
| `/master/lembaga-akreditasi/{id}` | PUT/PATCH | `master.lembaga.manage` | ✅ | ❌ | ❌ | ❌ |
| `/master/lembaga-akreditasi/{id}` | DELETE | `master.lembaga.manage` | ✅ | ❌ | ❌ | ❌ |
| `/master/versi-instrumen` | GET | `master.versi.view` | ✅ | ✅ | ✅ | ✅ |
| `/master/versi-instrumen` | POST | `master.versi.manage` | ✅ | ❌ | ❌ | ❌ |
| `/master/versi-instrumen/{id}` | GET | `master.versi.view` | ✅ | ✅ | ✅ | ✅ |
| `/master/versi-instrumen/{id}` | PUT/PATCH | `master.versi.manage` | ✅ | ❌ | ❌ | ❌ |
| `/master/versi-instrumen/{id}` | DELETE | `master.versi.manage` | ✅ | ❌ | ❌ | ❌ |
| `/master/instrumen` | GET | `master.instrumen.view` | ✅ | ✅ | ✅ | ✅ |
| `/master/instrumen` | POST | `master.instrumen.manage` | ✅ | ❌ | ❌ | ❌ |
| `/master/instrumen/{id}` | GET | `master.instrumen.view` | ✅ | ✅ | ✅ | ✅ |
| `/master/instrumen/{id}` | DELETE | `master.instrumen.manage` | ✅ | ❌ | ❌ | ❌ |
| `/master/kriteria` | GET | `master.kriteria.view` | ✅ | ✅ | ✅ | ✅ |
| `/master/kriteria` | POST | `master.kriteria.manage` | ✅ | ❌ | ❌ | ❌ |
| `/master/kriteria/{id}` | GET | `master.kriteria.view` | ✅ | ✅ | ✅ | ✅ |
| `/master/kriteria/{id}` | PUT/PATCH | `master.kriteria.manage` | ✅ | ❌ | ❌ | ❌ |
| `/master/kriteria/{id}` | DELETE | `master.kriteria.manage` | ✅ | ❌ | ❌ | ❌ |
| `/master/indikator` | GET | `master.indikator.view` | ✅ | ✅ | ✅ | ✅ |
| `/master/indikator` | POST | `master.indikator.manage` | ✅ | ❌ | ❌ | ❌ |
| `/master/indikator/{id}` | GET | `master.indikator.view` | ✅ | ✅ | ✅ | ✅ |
| `/master/indikator/{id}` | PUT/PATCH | `master.indikator.manage` | ✅ | ❌ | ❌ | ❌ |
| `/master/indikator/{id}` | DELETE | `master.indikator.manage` | ✅ | ❌ | ❌ | ❌ |
| `/master/rubrik` | GET | `master.rubrik.view` | ✅ | ✅ | ✅ | ✅ |
| `/master/rubrik` | POST | `master.rubrik.manage` | ✅ | ❌ | ❌ | ❌ |
| `/master/rubrik/{id}` | GET | `master.rubrik.view` | ✅ | ✅ | ✅ | ✅ |
| `/master/rubrik/{id}` | PUT/PATCH | `master.rubrik.manage` | ✅ | ❌ | ❌ | ❌ |
| `/master/rubrik/{id}` | DELETE | `master.rubrik.manage` | ✅ | ❌ | ❌ | ❌ |
| `/master/standar-mutu` | GET | `master.standar.view` | ✅ | ✅ | ✅ | ✅ |
| `/master/standar-mutu` | POST | `master.standar.manage` | ✅ | ❌ | ❌ | ❌ |
| `/master/standar-mutu/{id}` | GET | `master.standar.view` | ✅ | ✅ | ✅ | ✅ |
| `/master/standar-mutu/{id}` | PUT/PATCH | `master.standar.manage` | ✅ | ❌ | ❌ | ❌ |
| `/master/standar-mutu/{id}` | DELETE | `master.standar.manage` | ✅ | ❌ | ❌ | ❌ |
| `/master/jenis-pembiayaan` | GET | `master.pembiayaan.view` | ✅ | ✅ | ✅ | ✅ |
| `/master/jenis-pembiayaan` | POST | `master.pembiayaan.manage` | ✅ | ❌ | ❌ | ❌ |
| `/master/jenis-pembiayaan/{id}` | GET | `master.pembiayaan.view` | ✅ | ✅ | ✅ | ✅ |
| `/master/jenis-pembiayaan/{id}` | PUT/PATCH | `master.pembiayaan.manage` | ✅ | ❌ | ❌ | ❌ |
| `/master/jenis-pembiayaan/{id}` | DELETE | `master.pembiayaan.manage` | ✅ | ❌ | ❌ | ❌ |

---

### B. Modul Akreditasi (`/api/v1/projects`, `/api/v1/mapping-tim`, `/api/v1/self-assessment`)

| Endpoint | Method | Permission Name | Admin | Kaprodi | Dosen | Reviewer |
|:---|:---:|:---|:---:|:---:|:---:|:---:|
| `/projects` | GET | `project.view` | ✅ | ✅ | ✅ | ✅ |
| `/projects` | POST | `project.create` | ✅ | ✅ | ❌ | ❌ |
| `/projects/{id}` | GET | `project.view` | ✅ | ✅ | ✅ | ✅ |
| `/projects/{id}` | PUT/PATCH | `project.update` | ✅ | ✅ | ❌ | ❌ |
| `/projects/{id}` | DELETE | `project.delete` | ✅ | ❌ | ❌ | ❌ |
| `/projects/{id}/mapping-tim` | POST | `mapping_tim.manage` | ✅ | ✅ | ❌ | ❌ |
| `/mapping-tim` | GET | `mapping_tim.view` | ✅ | ✅ | ✅ | ✅ |
| `/mapping-tim` | POST | `mapping_tim.manage` | ✅ | ✅ | ❌ | ❌ |
| `/mapping-tim/{id}` | DELETE | `mapping_tim.manage` | ✅ | ✅ | ❌ | ❌ |
| `/self-assessment` | GET | `self_assessment.view` | ✅ | ✅ | ✅ | ✅ |
| `/self-assessment` | POST | `self_assessment.evaluate` | ✅ | ❌ | ❌ | ✅ |
| `/self-assessment/{id}` | GET | `self_assessment.view` | ✅ | ✅ | ✅ | ✅ |
| `/self-assessment/{id}` | DELETE | `self_assessment.evaluate` | ✅ | ❌ | ❌ | ✅ |

> **Catatan Otorisasi Proyek**:
> Untuk role `kaprodi`, `dosen`, dan `reviewer`, controller/policy harus memastikan data project dibatasi berdasarkan keterkaitan (contoh: kaprodi hanya untuk prodi terkait, dosen hanya jika terdaftar pada `mapping-tim`, reviewer jika ditugaskan).

---

### C. Modul SPMI & Audit Mutu (`/api/v1/spmi-audit/*`)

| Endpoint | Method | Permission Name | Admin | Kaprodi | Dosen | Reviewer |
|:---|:---:|:---|:---:|:---:|:---:|:---:|
| `/spmi-audit` | GET | `spmi.audit.view` | ✅ | ✅ | ✅ | ✅ |
| `/spmi-audit` | POST | `spmi.audit.create_finding` | ✅ | ❌ | ❌ | ✅ |
| `/spmi-audit/{id}` | GET | `spmi.audit.view` | ✅ | ✅ | ✅ | ✅ |
| `/spmi-audit/{id}` | PUT/PATCH | `spmi.audit.update_finding` | ✅ | ❌ | ❌ | ✅ |
| `/spmi-audit/{id}/tindak-lanjut` | PUT/PATCH | `spmi.audit.tindak_lanjut` | ✅ | ✅ | ❌ | ❌ |
| `/spmi-audit/{id}` | DELETE | `spmi.audit.delete_finding` | ✅ | ❌ | ❌ | ❌ |

---

### D. Modul Sarana & Prasarana (`/api/v1/sarpras-prodi/*`, `/api/v1/sarana-prodi/*`)

| Endpoint | Method | Permission Name | Admin | Kaprodi | Dosen | Reviewer |
|:---|:---:|:---|:---:|:---:|:---:|:---:|
| `/sarpras-prodi` | GET | `sarpras.view` | ✅ | ✅ | ✅ | ✅ |
| `/sarpras-prodi` | POST | `sarpras.manage` | ✅ | ✅ | ❌ | ❌ |
| `/sarpras-prodi/{id}` | GET | `sarpras.view` | ✅ | ✅ | ✅ | ✅ |
| `/sarpras-prodi/{id}` | PUT/PATCH | `sarpras.manage` | ✅ | ✅ | ❌ | ❌ |
| `/sarpras-prodi/{id}` | DELETE | `sarpras.manage` | ✅ | ✅ | ❌ | ❌ |
| `/sarana-prodi` | GET | `sarana.view` | ✅ | ✅ | ✅ | ✅ |
| `/sarana-prodi` | POST | `sarana.manage` | ✅ | ✅ | ❌ | ❌ |
| `/sarana-prodi/{id}` | GET | `sarana.view` | ✅ | ✅ | ✅ | ✅ |
| `/sarana-prodi/{id}` | PUT/PATCH | `sarana.manage` | ✅ | ✅ | ❌ | ❌ |
| `/sarana-prodi/{id}` | DELETE | `sarana.manage` | ✅ | ✅ | ❌ | ❌ |

---

## 4. Panduan Implementasi Teknis (Untuk Programmer Auth)

### 1. Instalasi Spatie Permission (Opsional tapi Direkomendasikan)
```bash
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

### 2. Model `User`
Tambahkan trait `HasApiTokens` (Sanctum) dan `HasRoles`:
```php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'id_prodi', // Relasi ke prodi bagi kaprodi & dosen
    ];
}
```

### 3. Pendaftaran Middleware di `bootstrap/app.php` (Laravel 11 / 13)
```php
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->create();
```

### 4. Contoh Seeder Role & Permission (`RoleAndPermissionSeeder.php`)
```php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Inisialisasi Permissions
        $permissions = [
            // Master Data
            'master.view',
            'master.manage',
            
            // Project
            'project.view',
            'project.create',
            'project.update',
            'project.delete',
            
            // Mapping Tim
            'mapping_tim.view',
            'mapping_tim.manage',
            
            // Self Assessment
            'self_assessment.view',
            'self_assessment.evaluate',
            
            // SPMI & Audit
            'spmi.audit.view',
            'spmi.audit.create_finding',
            'spmi.audit.update_finding',
            'spmi.audit.tindak_lanjut',
            'spmi.audit.delete_finding',
            
            // Sarpras
            'sarpras.view',
            'sarpras.manage',
            'sarana.view',
            'sarana.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'sanctum']);
        }

        // 2. Inisialisasi Roles & Mapping
        // Role: Admin (Superuser)
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'sanctum']);
        $adminRole->givePermissionTo(Permission::all());

        // Role: Kaprodi
        $kaprodiRole = Role::firstOrCreate(['name' => 'kaprodi', 'guard_name' => 'sanctum']);
        $kaprodiRole->givePermissionTo([
            'master.view',
            'project.view',
            'project.create',
            'project.update',
            'mapping_tim.view',
            'mapping_tim.manage',
            'self_assessment.view',
            'spmi.audit.view',
            'spmi.audit.tindak_lanjut',
            'sarpras.view',
            'sarpras.manage',
            'sarana.view',
            'sarana.manage',
        ]);

        // Role: Reviewer
        $reviewerRole = Role::firstOrCreate(['name' => 'reviewer', 'guard_name' => 'sanctum']);
        $reviewerRole->givePermissionTo([
            'master.view',
            'project.view',
            'mapping_tim.view',
            'self_assessment.view',
            'self_assessment.evaluate',
            'spmi.audit.view',
            'spmi.audit.create_finding',
            'spmi.audit.update_finding',
            'sarpras.view',
            'sarana.view',
        ]);

        // Role: Dosen
        $dosenRole = Role::firstOrCreate(['name' => 'dosen', 'guard_name' => 'sanctum']);
        $dosenRole->givePermissionTo([
            'master.view',
            'project.view',
            'mapping_tim.view',
            'self_assessment.view',
            'spmi.audit.view',
            'sarpras.view',
            'sarana.view',
        ]);
    }
}
```

### 5. Rekomendasi Penerapan di `routes/api.php`
Saat modul auth telah siap, bungkus seluruh grup versi `/v1` dengan middleware `auth:sanctum`:
```php
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {

    // Master Data (Hanya admin yang boleh memodifikasi)
    Route::prefix('master')->group(function () {
        Route::apiResource('lembaga-akreditasi', LembagaAkreditasiController::class)
            ->middleware('role:admin');
        // ... rute lainnya
    });

    // Project Akreditasi
    Route::apiResource('projects', ProjectAkreditasiController::class);
    Route::post('projects/{id}/mapping-tim', [ProjectAkreditasiController::class, 'storeMappingTim'])
        ->middleware('role:admin|kaprodi');

    // Self Assessment (Khusus Reviewer dan Admin)
    Route::post('self-assessment', [SelfAssessmentController::class, 'storeOrUpdate'])
        ->middleware('role:admin|reviewer');
    Route::delete('self-assessment/{id}', [SelfAssessmentController::class, 'destroy'])
        ->middleware('role:admin|reviewer');

    // SPMI Tindak Lanjut (Khusus Kaprodi dan Admin)
    Route::match(['put', 'patch'], 'spmi-audit/{id}/tindak-lanjut', [SpmiAuditController::class, 'updateTindakLanjut'])
        ->middleware('role:admin|kaprodi');
});
```

---

## 5. Standar Format JSON Response Error Auth

Sesuai format `ApiResponseTrait` aplikasi:

### A. 401 Unauthorized (Token Tidak Valid / Kosong)
```json
{
  "success": false,
  "message": "Unauthenticated. Silakan login terlebih dahulu.",
  "data": null,
  "errors": null
}
```

### B. 403 Forbidden (Role / Permission Tidak Sesuai)
```json
{
  "success": false,
  "message": "Forbidden. Anda tidak memiliki hak akses (role/permission) untuk aksi ini.",
  "data": null,
  "errors": null
}
```
