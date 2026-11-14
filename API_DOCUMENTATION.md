# REST API Documentation — Sistem Akreditasi & SPMI (LAM INFOKOM 2.1)

Dokumentasi ini dirancang khusus sebagai panduan integrasi bagi **Agent AI / Pengembang Frontend**. Seluruh endpoint diproteksi menggunakan **JWT Bearer Token** yang diterbitkan oleh layanan SSO Akademik.

---

## 1. Layanan Autentikasi Terpusat (SSO Akademik)

Sistem Akreditasi menggunakan autentikasi SSO terpusat dari server Akademik:
* **Host SSO Auth:** `https://akademik.fayra.my.id/api/auth`
* **Metode Otentikasi:** JWT Bearer Token (`Authorization: Bearer <access_token>`)
* **Masa Berlaku Token:** 3600 detik (1 Jam)

### Kredensial Pengguna (SSO Polines)
Untuk keamanan sistem dan pencegahan akses tidak sah (*unauthorized access/hack*), **email dan password akun pengguna tidak di-prefill secara otomatis** di Swagger UI (`/documentation`). Setiap pengguna wajib mengetikkan alamat email dan password akun terdaftar mereka secara manual.

* **Format Email:** `email_anda@polines.ac.id` (contoh: akun dosen, kaprodi, reviewer, atau administrator)
* **Password:** Kata sandi akun pengguna SSO
* **Role Tersedia:** `ADMINISTRATOR`, `KAPRODI`, `REVIEWER`, `DOSEN`

---

### A. Endpoint Login SSO
Mengirim kredensial pengguna untuk mendapatkan token JWT akses.

* **URL:** `POST https://akademik.fayra.my.id/api/auth/login`
* **Headers:**
  ```http
  Accept: application/json
  Content-Type: application/json
  ```
* **Request Body:**
  ```json
  {
    "email": "user@polines.ac.id", // Ketikkan email pengguna SSO Anda
    "password": "kata_sandi_anda"   // Ketikkan password akun SSO Anda
  }
  ```
* **Respons Berhasil (HTTP 200):**
  ```json
  {
    "success": true,
    "code": 200,
    "message": "Login berhasil",
    "data": {
      "user": {
        "id": 1,
        "nama": "User Terdaftar",
        "email": "user@polines.ac.id",
        "role": "ADMINISTRATOR"
      },
      "authorization": {
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2FrYWRlbWlrLmZheXJhLm15LmlkL2FwaS9hdXRoL2xvZ2luIiwiaWF0IjoxNzkyOTMxMTA4LCJleHAiOjE3OTI5MzQ3MDgsIm5iZiI6MTc5MjkzMTEwOCwianRpIjoicE84aVl0c1Jxamt6c2x2NiIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3IiwiZW1haWwiOiJhZG1pbmlzdHJhdG9yQHBvbGluZXMuYWMuaWQiLCJuYW1hIjoiQWRtaW5pc3RyYXRvciBTaXN0ZW0iLCJyb2xlIjoiQURNSU5JU1RSQVRPUiIsInBlcm1pc3Npb25zIjpbIioiXX0...",
        "token_type": "Bearer",
        "expires_in": 3600,
        "permissions": []
      }
    }
  }
  ```

---

### B. Endpoint Logout SSO
Mencabut dan mengakhiri sesi token yang aktif.

* **URL:** `POST https://akademik.fayra.my.id/api/auth/logout`
* **Headers:**
  ```http
  Accept: application/json
  Authorization: Bearer <access_token>
  ```
* **Respons Berhasil (HTTP 200):**
  ```json
  {
    "success": true,
    "code": 200,
    "message": "Logout berhasil",
    "data": null
  }
  ```

---

### C. Endpoint Profil Pengguna SSO (Akademik)
Mendapatkan data identitas akun langsung dari server SSO Akademik.

* **URL:** `GET https://akademik.fayra.my.id/api/auth/me`
* **Headers:**
  ```http
  Accept: application/json
  Authorization: Bearer <access_token>
  ```
* **Respons Berhasil (HTTP 200):**
  ```json
  {
    "success": true,
    "code": 200,
    "message": "Data profil berhasil diambil",
    "data": {
      "id": 1,
      "nama": "User Terdaftar",
      "email": "user@polines.ac.id",
      "role": "ADMINISTRATOR"
    }
  }
  ```

---

### D. Endpoint Verifikasi Profil (Sistem Akreditasi)
Memverifikasi klaim token JWT pengguna lokal di subsistem Akreditasi & SPMI.

* **URL:** `GET https://akreditasi.fayra.my.id/api/v1/auth/me`
* **Headers:**
  ```http
  Accept: application/json
  Authorization: Bearer <access_token>
  ```
* **Respons Berhasil (HTTP 200):**
  ```json
  {
    "success": true,
    "message": "Profil pengguna terautentikasi berhasil diambil.",
    "data": {
      "user": {
        "id": "1",
        "nama": "User Terdaftar",
        "email": "user@polines.ac.id",
        "role": "ADMINISTRATOR",
        "permissions": ["*"]
      }
    },
    "errors": null
  }
  ```

---

## 2. Konfigurasi Dasar API Akreditasi (Base Configuration)

* **Base URL Production:** `https://akreditasi.fayra.my.id/api/v1`
* **Base URL Lokal:** `http://127.0.0.1:8000/api/v1`
* **Swagger UI Interaktif:** `https://akreditasi.fayra.my.id/documentation`
* **Default Request Headers:**
  ```http
  Accept: application/json
  Content-Type: application/json
  Authorization: Bearer <access_token>
  ```

## 2. Struktur Standar Respons JSON (Response Envelope)

Seluruh respons dari server selalu dibungkus dalam format standar seragam:

### Respons Sukses (HTTP 200 / 201)
```json
{
  "success": true,
  "message": "Data berhasil dimuat / ditambahkan / diperbarui",
  "data": { ... } // Objek tunggal atau Array data
}
```

### Respons Validasi Gagal (HTTP 422)
```json
{
  "success": false,
  "message": "Validasi gagal, silakan periksa data input Anda",
  "data": null,
  "errors": {
    "nama_field": [
      "Pesan error validasi"
    ]
  }
}
```

### Respons Not Found (HTTP 404)
```json
{
  "success": false,
  "message": "Data tidak ditemukan",
  "data": null
}
```

---

## 3. TypeScript Interfaces (Copy-Paste Ready untuk Frontend)

```typescript
// Envelope API
export interface ApiResponse<T> {
  success: boolean;
  message: string;
  data: T;
  errors?: Record<string, string[]> | null;
}

// Master Data
export interface LembagaAkreditasi {
  id: number;
  nama_lembaga: string;
  keterangan: string | null;
  created_at: string;
  updated_at: string;
}

export interface Jenjang {
  id: number;
  nama_jenjang: string;
  kode_jenjang: string;
}

export interface VersiInstrumen {
  id: number;
  id_lembaga: number;
  nomor_versi: string;
  tanggal_berlaku: string;
  status_aktif: boolean;
  lembaga?: LembagaAkreditasi;
}

export interface Instrumen {
  id: string; // UUID
  id_versi_instrumen: number;
  id_jenjang: number;
  id_jenis_instrumen: number;
  kriterias_count: number; // Jumlah kriteria di bawah instrumen ini
  kriteria_count: number;  // Alias count kriteria
  versi_instrumen?: VersiInstrumen;
  jenjang?: { id: number; nama_jenjang: string; kode_jenjang: string };
  jenis_instrumen?: { id: number; nama_jenis: string };
  jenis_akreditasi?: { id: number; nama_jenis: string };
  kriterias?: Kriteria[]; // Tersedia saat GET /instrumen/{id}
}

export interface Kriteria {
  id: number;
  id_instrumen: string; // UUID
  kode_kriteria: string;
  nama_kriteria: string;
  subkriteria_count: number; // Jumlah subkriteria di bawah kriteria ini
  subkriterias_count: number; // Alias count subkriteria
  instrumen?: Instrumen;
  subkriteria?: Subkriteria[]; // Tersedia saat GET /kriteria/{id}
}

export interface Subkriteria {
  id: number;
  id_kriteria: number;
  kode_subkriteria: string;
  nama_subkriteria: string;
  indikator_count: number; // Jumlah indikator di bawah subkriteria ini
  indikators_count: number; // Alias count indikator
  kriteria?: Kriteria;
  indikator?: Indikator[]; // Tersedia saat GET /subkriteria/{id}
}

export interface Indikator {
  id: number;
  id_subkriteria: number;
  kode_indikator: string;
  deskripsi_indikator: string;
  bobot: number;
  rubriks_count: number; // Jumlah opsi rubrik skor di bawah indikator ini
  rubrik_count: number;  // Alias count rubrik
  subkriteria?: Subkriteria;
  rubriks?: Rubrik[]; // Tersedia saat GET /indikator/{id}
}

export interface Rubrik {
  id: number;
  id_indikator: number;
  skor: number;
  deskripsi_rubrik: string;
  indikator?: Indikator;
}

export interface StandarMutu {
  id: number;
  kode_standar: string;
  nama_standar: string;
  pernyataan_standar: string;
}

export interface JenisBukti {
  id: number;
  nama_jenis: string;
}

export interface JenisPembiayaan {
  id: number;
  nama_pembiayaan: string;
  kategori: string;
}

// Akreditasi
export interface ProjectAkreditasi {
  id: number;
  id_prodi: number;
  id_versi_instrumen: number;
  id_jenjang: number;
  id_jenis_instrumen: number;
  nama_project: string;
  tahun_target_submit: number;
  status_project: 'Draft' | 'On Progress' | 'Pending' | 'Cancel' | 'Selesai';
  tanggal_verifikasi_akreditasi: string | null;
  nomor_sk_akreditasi: string | null;
  created_at?: string;
  updated_at?: string;
}

export interface UpdateStatusProjectRequest {
  status_project: 'Draft' | 'On Progress' | 'Pending' | 'Cancel' | 'Selesai';
  tanggal_verifikasi_akreditasi?: string | null;
  nomor_sk_akreditasi?: string | null;
}

// Integrasi Eksternal (Kelompok 1 & Kelompok 2)
export interface ExternalProdi {
  id: number;
  kode_prodi: string;
  nama_prodi: string;
  jenjang?: string;
}

export interface ExternalDosen {
  nidn: string;
  nama: string;
  email: string;
  bidang_minat: string;
}

export interface MappingTimAkreditasi {
  id: number;
  id_project: number;
  id_user: number;
  id_indikator: number;
  role: 'PJ' | 'PIC' | string; // 'PJ' (Penanggung Jawab) atau 'PIC' (Pelaksana)
}

export interface LembarProdi {
  id: number;
  id_project: number;
  id_indikator: number;
  penjelasan_prodi: string;
  bukti?: Bukti[];
}

export interface Bukti {
  id: number;
  id_lembar_prodi: number;
  id_jenis_bukti: number;
  nama_bukti: string;
  file_url: string | null;
  tautan_eksternal: string | null;
  status_validasi: 'Menunggu' | 'Disetujui' | 'Ditolak' | 'Perlu Revisi';
  catatan_validasi: string | null;
  uploaded_by: number;
  validated_by: number | null;
}

export interface SelfAssessment {
  id: number;
  id_project: number;
  id_indikator: number;
  id_rubrik: number;
  skor_terbobot: number;
  catatan_reviewer: string | null;
  id_reviewer: number;
}

// SPMI & Sarpras
export interface SpmiAudit {
  id: number;
  id_prodi: number;
  id_standar_mutu: number;
  id_auditor: number;
  tahun: number;
  hasil_audit: 'Kesesuaian' | 'Ketidaksesuaian Mayor' | 'Ketidaksesuaian Minor' | 'Observasi';
  kondisi_temuan: string;
  akar_masalah: string | null;
  rekomendasi: string | null;
  status_audit: 'Open' | 'Closed' | 'In Progress';
  rencana_tindak_lanjut: string | null;
  status_tindak_lanjut: string | null;
  evaluasi_efektivitas: string | null;
  tanggal_audit: string;
  tanggal_efektif: string | null;
}

export interface EvidenceSpmi {
  id: number;
  project_id: number;
  link_bukti_evaluasi: string | null;
  deskripsi_bukti_evaluasi: string | null;
  link_bukti_pengendalian: string | null;
  deskripsi_bukti_pengendalian: string | null;
  link_bukti_dampak: string | null;
  deskripsi_bukti_dampak: string | null;
  link_dokumen_implementasi: string | null;
  deskripsi_dokumen_implementasi: string | null;
  created_at?: string;
  updated_at?: string;
  project?: ProjectAkreditasi;
}

export interface DataSarprasProdi {
  id: number;
  id_project: number;
  kapasitas: number | null;
  keterangan: string | null;
  sarana?: DataSaranaProdi[];
}

export interface DataSaranaProdi {
  id: number;
  id_prasarana: number;
  nama_sarana: string;
  jumlah: number | null;
  kondisi: string | null;
}
```

---

## 4. Daftar Lengkap Endpoint REST API

### A. Modul Master Data (`/master/` atau direct alias `/`)

> [!TIP]
> Seluruh endpoint master instrumen dapat diakses melalui prefix `/master/*` (misal `/master/instrumen`) maupun direct alias tanpa prefix (misal `/instrumen`).

| Method | Endpoint | Query Param / Body | Deskripsi |
|:---|:---|:---|:---|
| `GET` | `/master/lembaga-akreditasi` | - | Mengambil semua lembaga akreditasi (LAM INFOKOM, BAN-PT, dll) |
| `POST` | `/master/lembaga-akreditasi` | `{ nama_lembaga, keterangan? }` | Tambah lembaga baru |
| `GET` | `/master/lembaga-akreditasi/{id}` | - | Detail lembaga beserta versi instrumennya |
| `PUT` | `/master/lembaga-akreditasi/{id}` | `{ nama_lembaga?, keterangan? }` | Update lembaga |
| `DELETE` | `/master/lembaga-akreditasi/{id}` | - | Hapus lembaga |
| `GET` | `/master/versi-instrumen` | `?id_lembaga=&status_aktif=` | Mengambil semua versi instrumen |
| `POST` | `/master/versi-instrumen` | `{ id_lembaga, nomor_versi, tanggal_berlaku, status_aktif? }` | Tambah versi instrumen baru |
| `GET` | `/master/versi-instrumen/{id}` | - | Detail versi instrumen beserta hierarki kriteria |
| `PUT` | `/master/versi-instrumen/{id}` | `{ id_lembaga?, nomor_versi?, tanggal_berlaku?, status_aktif? }` | Update versi instrumen |
| `DELETE` | `/master/versi-instrumen/{id}` | - | Hapus versi instrumen |
| `GET` | `/master/instrumen` atau `/instrumen` | `?id_jenjang=&id_versi_instrumen=&id_jenis_instrumen=` | Mengambil daftar instrumen akreditasi dengan relasi `jenis_akreditasi` (jenis_instrumen) dan `jenjang` (tanpa load kriteria untuk efisiensi) |
| `POST` | `/master/instrumen` atau `/instrumen` | `{ id_versi_instrumen, id_jenjang, id_jenis_instrumen }` | Tambah instrumen baru (menghasilkan UUID) |
| `GET` | `/master/instrumen/{id}` atau `/instrumen/{id}` | - | **Hierarki L1:** Detail instrumen (UUID) beserta seluruh kriteria (`kriterias`) di bawahnya |
| `DELETE` | `/master/instrumen/{id}` atau `/instrumen/{id}` | - | Hapus instrumen |
| `GET` | `/master/kriteria` atau `/kriteria` | `?id_instrumen=` | Mengambil daftar kriteria (opsional filter UUID instrumen) |
| `POST` | `/master/kriteria` atau `/kriteria` | `{ id_instrumen, kode_kriteria, nama_kriteria }` | Tambah kriteria baru (`id_instrumen` UUID) |
| `GET` | `/master/kriteria/{id}` atau `/kriteria/{id}` | - | **Hierarki L2:** Detail kriteria beserta seluruh subkriteria (`subkriteria`) di bawahnya |
| `PUT` | `/master/kriteria/{id}` atau `/kriteria/{id}` | `{ kode_kriteria?, nama_kriteria? }` | Update kriteria |
| `DELETE` | `/master/kriteria/{id}` atau `/kriteria/{id}` | - | Hapus kriteria |
| `GET` | `/master/subkriteria` atau `/subkriteria` | `?id_kriteria=` | Mengambil daftar subkriteria (opsional filter id_kriteria) |
| `POST` | `/master/subkriteria` atau `/subkriteria` | `{ id_kriteria, kode_subkriteria, nama_subkriteria }` | Tambah subkriteria baru |
| `GET` | `/master/subkriteria/{id}` atau `/subkriteria/{id}` | - | **Hierarki L3:** Detail subkriteria beserta seluruh butir indikator (`indikator`) di bawahnya |
| `PUT` | `/master/subkriteria/{id}` atau `/subkriteria/{id}` | `{ kode_subkriteria?, nama_subkriteria? }` | Update subkriteria |
| `DELETE` | `/master/subkriteria/{id}` atau `/subkriteria/{id}` | - | Hapus subkriteria |
| `GET` | `/master/indikator` atau `/indikator` | `?id_subkriteria=` | Mengambil daftar indikator / butir penilaian |
| `POST` | `/master/indikator` atau `/indikator` | `{ id_subkriteria, kode_indikator, deskripsi_indikator, bobot }` | Tambah butir indikator baru |
| `GET` | `/master/indikator/{id}` atau `/indikator/{id}` | - | **Hierarki L4:** Detail indikator beserta seluruh opsi butir skor (`rubriks`) di bawahnya |
| `PUT` | `/master/indikator/{id}` atau `/indikator/{id}` | `{ id_subkriteria?, kode_indikator?, deskripsi_indikator?, bobot? }` | Update butir indikator |
| `DELETE` | `/master/indikator/{id}` atau `/indikator/{id}` | - | Hapus butir indikator |
| `GET` | `/master/rubrik` atau `/rubrik` | `?id_indikator=` | Mengambil opsi rubrik skor penilaian (terurut berdasarkan skor ascending) |
| `POST` | `/master/rubrik` atau `/rubrik` | `{ id_indikator, skor, deskripsi_rubrik }` | Tambah opsi rubrik skor (1-4) |
| `GET` | `/master/rubrik/{id}` atau `/rubrik/{id}` | - | Detail butir rubrik skor |
| `PUT` | `/master/rubrik/{id}` atau `/rubrik/{id}` | `{ id_indikator?, skor?, deskripsi_rubrik? }` | Update rubrik skor |
| `DELETE` | `/master/rubrik/{id}` atau `/rubrik/{id}` | - | Hapus rubrik skor |
| `GET` | `/master/jenjang` | - | Mengambil daftar jenjang pendidikan (D3, D4/S1, dll) |
| `GET` | `/master/jenjang/{id}` | - | Detail jenjang pendidikan |
| `GET` | `/master/jenis-bukti` | - | Mengambil opsi jenis dokumen bukti |
| `POST` | `/master/jenis-bukti` | `{ nama_jenis }` | Tambah jenis bukti |
| `GET` | `/master/jenis-bukti/{id}` | - | Detail jenis bukti |
| `PUT` | `/master/jenis-bukti/{id}` | `{ nama_jenis }` | Update jenis bukti |
| `DELETE` | `/master/jenis-bukti/{id}` | - | Hapus jenis bukti |
| `GET` | `/master/jenis-pembiayaan` | - | Mengambil opsi pembiayaan |
| `POST` | `/master/jenis-pembiayaan` | `{ nama_pembiayaan, kategori }` | Tambah jenis pembiayaan |
| `GET` | `/master/jenis-pembiayaan/{id}` | - | Detail jenis pembiayaan |
| `PUT` | `/master/jenis-pembiayaan/{id}` | `{ nama_pembiayaan, kategori }` | Update jenis pembiayaan |
| `DELETE` | `/master/jenis-pembiayaan/{id}` | - | Hapus jenis pembiayaan |

---

### Alur Drill-Down Hierarki Master Instrumen Akreditasi

Hierarki drill-down dirancang bertingkat untuk efisiensi payload data dan integrasi frontend navigasi bertingkat (Lembaga -> Instrumen -> Kriteria -> Subkriteria -> Indikator -> Rubrik). Setiap level secara otomatis menyertakan **jumlah child (`*_count`)**:

```
[Instrumen]
   │  GET /instrumen
   │  • data: list instrumen + jenis_akreditasi + jenjang
   │  • count child: `kriterias_count` (dan alias `kriteria_count`)
   ▼
[Instrumen Detail]
   │  GET /instrumen/{id}
   │  • data: detail instrumen + relasi `kriterias`
   │  • count child: `kriterias_count`, dan setiap item kriteria menyertakan `subkriteria_count`
   ▼
[Kriteria]
   │  GET /kriteria?id_instrumen={uuid}  /  GET /kriteria/{id}
   │  • data: list / detail kriteria + relasi `subkriteria`
   │  • count child: `subkriteria_count`, dan setiap item subkriteria menyertakan `indikator_count`
   ▼
[Subkriteria]
   │  GET /subkriteria?id_kriteria={id}  /  GET /subkriteria/{id}
   │  • data: list / detail subkriteria + relasi `indikator`
   │  • count child: `indikator_count`, dan setiap item indikator menyertakan `rubriks_count`
   ▼
[Indikator]
   │  GET /indikator?id_subkriteria={id}  /  GET /indikator/{id}
   │  • data: list / detail indikator + relasi `rubriks`
   │  • count child: `rubriks_count` (dan alias `rubrik_count`)
   ▼
[Rubrik]
      GET /rubrik?id_indikator={id}
      • data: list butir rubrik skor (1-4) terurut skor ascending
```

---

### B. Modul Akreditasi

#### 1. Project Akreditasi (`/projects`)
* **`GET /projects`** (`?id_prodi=&id_jenjang=&status_project=`): List project akreditasi prodi (mendukung filter `id_prodi`, `id_jenjang`, dan `status_project`).
* **`POST /projects`**: Membuat project akreditasi baru (Role: `ADMINISTRATOR`, `KAPRODI`).
  ```json
  {
    "id_prodi": 1,
    "id_versi_instrumen": 1,
    "id_jenjang": 1,
    "id_jenis_instrumen": 1,
    "nama_project": "Akreditasi D4 TRK 2026",
    "tahun_target_submit": 2026,
    "status_project": "Draft",
    "tanggal_verifikasi_akreditasi": null,
    "nomor_sk_akreditasi": null
  }
  ```
* **`GET /projects/{id}`**: Detail project lengkap dengan relasi `versiInstrumen`, `jenjang`, `jenisInstrumen`, `mappingTim.indikator`, `lembarProdi.buktis`, dan `selfAssessments.rubrik`.
* **`PUT /projects/{id}`** atau **`PATCH /projects/{id}`**: Update data project akreditasi (Role: `ADMINISTRATOR`, `KAPRODI`).
  > [!NOTE]
  > Aturan validasi: Jika `status_project` diubah menjadi `Selesai`, maka `tanggal_verifikasi_akreditasi` dan `nomor_sk_akreditasi` wajib disertakan.
* **`PATCH /projects/{id}/status`**: **Pembaruan Siklus Hidup Status Project Akreditasi (Lifecycle Status Update)**.
  Endpoint khusus untuk mengelola transisi siklus status project akreditasi (`Draft` -> `On Progress` -> `Pending` -> `Cancel` -> `Selesai`).
  * **Role yang diizinkan:** `ADMINISTRATOR`, `KAPRODI`
  * **Aturan Bisnis & Validasi:**
    1. Nilai `status_project` wajib salah satu dari: `Draft`, `On Progress`, `Pending`, `Cancel`, `Selesai`.
    2. **Tolak Status Selesai Tanpa SK/Verifikasi:** Sistem secara otomatis menolak (HTTP 422 Unprocessable Entity) jika status diubah ke `Selesai` tetapi `tanggal_verifikasi_akreditasi` atau `nomor_sk_akreditasi` belum terisi (baik di request payload maupun yang sudah tersimpan di database).
    3. Jika status selain `Selesai`, kolom tanggal verifikasi dan nomor SK bersifat opsional/nullable.
  * **Request Body (Contoh Menyelesaikan Project):**
    ```json
    {
      "status_project": "Selesai",
      "tanggal_verifikasi_akreditasi": "2026-11-13",
      "nomor_sk_akreditasi": "SK/LAM-INFOKOM/2026/099"
    }
    ```
  * **Respons Berhasil (HTTP 200):**
    ```json
    {
      "success": true,
      "message": "Status project akreditasi berhasil diperbarui",
      "data": {
        "id": 1,
        "id_prodi": 1,
        "id_versi_instrumen": 1,
        "id_jenjang": 1,
        "id_jenis_instrumen": 1,
        "nama_project": "Akreditasi D4 TRK 2026",
        "tahun_target_submit": 2026,
        "status_project": "Selesai",
        "tanggal_verifikasi_akreditasi": "2026-11-13",
        "nomor_sk_akreditasi": "SK/LAM-INFOKOM/2026/099",
        "created_at": "2026-11-14T00:00:00.000000Z",
        "updated_at": "2026-11-14T05:00:00.000000Z"
      },
      "errors": null
    }
    ```
  * **Respons Validasi Ditolak (HTTP 422) jika SK / Tanggal Verifikasi Belum Terisi:**
    ```json
    {
      "success": false,
      "message": "Status Selesai ditolak. Tanggal verifikasi akreditasi dan nomor SK akreditasi wajib diisi.",
      "data": null,
      "errors": {
        "status_project": [
          "Tanggal verifikasi akreditasi dan nomor SK akreditasi wajib terisi untuk menyelesaikan project."
        ]
      }
    }
    ```
* **`DELETE /projects/{id}`**: Hapus project akreditasi (Role: `ADMINISTRATOR`, `KAPRODI`).
* **`GET /projects/{id}/mapping-tim`**: Mengambil daftar penugasan tim per indikator untuk project tertentu.
* **`POST /projects/{id}/mapping-tim`**: Menugaskan dosen/PIC/PJ per indikator via project.
  ```json
  {
    "id_user": 101,
    "id_indikator": 1,
    "role": "PJ" // 'PJ' (Penanggung Jawab) atau 'PIC' (Pelaksana)
  }
  ```

#### 2. Penugasan Tim Akreditasi (`/mapping-tim`)
* **`GET /mapping-tim`** (`?id_project=1&role=PJ`): Mengambil daftar penugasan tim akreditasi. Filter `id_project` dan `role` dikirimkan melalui **Query Parameter** (bukan Request Body).
* **`POST /mapping-tim`** (Single Assignment):
  ```json
  {
    "id_project": 1,
    "id_user": 101,
    "id_indikator": 1,
    "role": "PJ"
  }
  ```
* **`POST /mapping-tim`** (Batch Assignments):
  ```json
  {
    "id_project": 1,
    "assignments": [
      {
        "id_user": 101,
        "id_indikator": 1,
        "role": "PJ"
      },
      {
        "id_user": 102,
        "id_indikator": 2,
        "role": "PIC"
      }
    ]
  }
  ```
* **`DELETE /mapping-tim/{id}`**: Menghapus penugasan tim berdasarkan ID.

#### 3. Lembar Kerja Prodi (`/lembar-prodi`)
* **`GET /lembar-prodi`** (`?id_project=1&id_indikator=1`): Mengambil narasi penjelasan prodi untuk indikator tertentu.
* **`POST /lembar-prodi`** (atau `PUT /lembar-prodi`): Simpan / Update narasi prodi.
  ```json
  {
    "id_project": 1,
    "id_indikator": 1,
    "penjelasan_prodi": "Program studi telah menyusun visi keilmuan yang selaras dengan Renstra institusi..."
  }
  ```
* **`GET /lembar-prodi/{id}`**: Mengambil detail lembar prodi berdasarkan ID beserta lampiran bukti dukungnya.
* **`DELETE /lembar-prodi/{id}`**: Menghapus data lembar prodi.

#### 4. Upload & Validasi Berkas Bukti (`/bukti`)
* **`GET /bukti`** (`?id_lembar_prodi=1`): List berkas bukti dukung.
* **`POST /bukti`** (*Multipart Form-Data*): Upload berkas fisik atau sertakan tautan eksternal.
  * `id_lembar_prodi`: integer (wajib)
  * `id_jenis_bukti`: integer (wajib)
  * `nama_bukti`: string (wajib, max 255)
  * `file_dokumen`: file (opsional, tipe: pdf, doc, docx, xlsx, zip, jpg, png max 20MB)
  * `tautan_eksternal`: string url (opsional)
  * `uploaded_by`: integer (wajib, ID user pengunggah)
* **`GET /bukti/{id}`**: Detail berkas bukti (mengembalikan field `file_url` yang siap dibuka/didownload).
* **`PUT /bukti/{id}/status`** (atau `PATCH /bukti/{id}/status`): Validasi reviewer/asesor.
  ```json
  {
    "status_validasi": "Disetujui", // 'Menunggu' | 'Disetujui' | 'Ditolak' | 'Perlu Revisi'
    "catatan_validasi": "Dokumen SK telah lengkap dan sesuai standar.",
    "validated_by": 201
  }
  ```
* **`DELETE /bukti/{id}`**: Hapus berkas bukti dari database dan storage fisik.

#### 5. Self Assessment / Penilaian Mandiri (`/self-assessment`)
* **`GET /self-assessment`** (`?id_project=1`): List penilaian mandiri.
* **`POST /self-assessment`**: Reviewer memilih rubrik. **Sistem otomatis menghitung `skor_terbobot = skor * nilai_bobot`**.
  ```json
  {
    "id_project": 1,
    "id_indikator": 1,
    "id_rubrik": 1,
    "id_reviewer": 301,
    "catatan_reviewer": "Bukti dukung sangat komprehensif dan implementasi terlaksana dengan baik."
  }
  ```
* **`GET /self-assessment/rekap/{projectId}`**: **Rekapitulasi total skor terbobot seluruh indikator** untuk project akreditasi (sangat berguna untuk tampilan progress bar / skor akhir dashboard).
* **`GET /self-assessment/{id}`**: Detail penilaian mandiri.
* **`DELETE /self-assessment/{id}`**: Hapus penilaian mandiri.

---

### C. Modul SPMI & Audit Mutu

#### 1. Audit Mutu Internal (`/spmi-audit`)
* **`GET /spmi-audit`** (`?id_project=1&jenis_kegiatan=AMI&tahun_audit=2026&status_penyelesaian=Open`): List temuan audit mutu dengan filter opsional.
* **`POST /spmi-audit`**: Tambah temuan audit baru.
  ```json
  {
    "id_project": 1,
    "id_standar": 1,
    "id_indikator": 1,
    "jenis_kegiatan": "AMI", // 'PPEPP' | 'AMI' | 'RTM'
    "tanggal_pelaksanaan": "2026-10-15",
    "tahun_audit": 2026,
    "temuan": "Dokumen SOP pelaksanaan RPS belum diperbarui sesuai kurikulum OBE terbaru.",
    "tindak_lanjut": "Workshop review SOP pembelajaran.",
    "status_penyelesaian": "Open"
  }
  ```
* **`GET /spmi-audit/{id}`**: Detail temuan audit.
* **`PUT /spmi-audit/{id}`**: Update data audit.
* **`DELETE /spmi-audit/{id}`**: Hapus temuan audit.
* **`PUT /spmi-audit/{id}/tindak-lanjut`** (atau `PATCH`): Auditee mengisi rencana tindak lanjut perbaikan temuan audit.
  ```json
  {
    "tindak_lanjut": "Mengadakan rapat konsinyasi penyelarasan RPS dan pembaruan SOP pembelajaran.",
    "status_penyelesaian": "Selesai"
  }
  ```

#### 2. Evidence SPMI Project Akreditasi (`/evidence-spmi`)
Modul ini mengelola 4 pilar bukti pelaksanaan SPMI (Siklus PPEPP) tingkat Program Studi yang terikat secara relasional (One-to-One) dengan Project Akreditasi.
* **`GET /evidence-spmi?project_id={id}`**: Mengambil data bukti SPMI 4 pilar untuk project akreditasi terkait. Jika belum pernah diisi, mengembalikan `data: null` dengan kode 200 OK.
* **`POST /evidence-spmi`**: Menyimpan atau memperbarui data bukti SPMI (*updateOrCreate* berdasarkan `project_id`).
  ```json
  {
    "project_id": 1,
    "link_bukti_evaluasi": "https://drive.google.com/drive/folders/evaluasi-spmi-link",
    "deskripsi_bukti_evaluasi": "Laporan Audit Mutu Internal (AMI) Siklus 2025/2026 dan Monev Berkala.",
    "link_bukti_pengendalian": "https://drive.google.com/drive/folders/pengendalian-spmi-link",
    "deskripsi_bukti_pengendalian": "Notula Rapat Tinjauan Manajemen (RTM) dan Lembar Tindak Lanjut Temuan AMI.",
    "link_bukti_dampak": "https://drive.google.com/drive/folders/dampak-spmi-link",
    "deskripsi_bukti_dampak": "Rekapitulasi ketercapaian Indikator Kinerja Utama (IKU) dan kepuasan stakeholder.",
    "link_dokumen_implementasi": "https://drive.google.com/drive/folders/implementasi-spmi-link",
    "deskripsi_dokumen_implementasi": "Manual Mutu, Standar SPMI, serta formulir implementasi penjaminan mutu program studi."
  }
  ```

---

### D. Modul Sarana & Prasarana

#### 1. Prasarana Prodi (`/sarpras-prodi`)
* **`GET /sarpras-prodi`** (`?id_project=1`): List prasarana prodi (Gedung, Lab, Ruang Kelas).
* **`POST /sarpras-prodi`**: Tambah prasarana.
  ```json
  {
    "id_project": 1,
    "kapasitas": 40,
    "keterangan": "Laboratorium Rekayasa Komputer Gedung B"
  }
  ```
* **`GET /sarpras-prodi/{id}`**: Detail prasarana beserta daftar sarananya.
* **`PUT /sarpras-prodi/{id}`**: Update prasarana.
* **`DELETE /sarpras-prodi/{id}`**: Hapus prasarana.

#### 2. Sarana Prodi (`/sarana-prodi`)
* **`GET /sarana-prodi`** (`?id_prasarana=1`): List sarana per prasarana (PC, Switch, Proyektor, dll).
* **`POST /sarana-prodi`**: Tambah sarana prodi.
  ```json
  {
    "id_prasarana": 1,
    "jumlah_unit": 30,
    "kondisi": "Baik",
    "keterangan": "PC Workstation Core i7 32GB RAM di Lab RPL"
  }
  ```
* **`GET /sarana-prodi/{id}`**: Detail sarana.
* **`PUT /sarana-prodi/{id}`**: Update sarana.
* **`DELETE /sarana-prodi/{id}`**: Hapus sarana.

---

### E. Modul Integrasi Eksternal (Kelompok 1 & Kelompok 2)

Modul ini diimplementasikan menggunakan arsitektur *Service Adapter* (`App\Services\External\ProdiApiService` dan `App\Services\External\DosenApiService`) untuk menjembatani Sistem Akreditasi dengan server Kelompok 1 (Akademik) dan Kelompok 2 (Tri Dharma & SDM Dosen). Modul ini dilengkapi mekanisme *graceful fallback* otomatis agar proses bisnis akreditasi tetap dapat berjalan normal meskipun server eksternal sedang *offline*, *timeout*, atau tidak dapat dijangkau (*unreachable*).

* **Autentikasi & Otorisasi:** Dilindungi `jwt.auth` dan middleware role `role:administrator,kaprodi,reviewer,dosen`.

#### 1. Daftar Program Studi Resmi (`GET /external/prodi`)
* **Endpoint:** `GET /external/prodi`
* **Adapter Class:** `App\Services\External\ProdiApiService::getAllProdi()`
* **Sumber Data Eksternal:** API Kelompok 1 (`https://akademik.fayra.my.id/api/prodi`) via `Illuminate\Support\Facades\Http`.
* **Deskripsi:** Mengambil daftar seluruh program studi resmi. Jika server Kelompok 1 tidak dapat dijangkau (*unreachable* / timeout), sistem otomatis mengembalikan fallback data Program Studi TRK default.
* **Headers:**
  ```http
  Accept: application/json
  Authorization: Bearer <access_token>
  ```
* **Respons Berhasil (HTTP 200):**
  ```json
  {
    "success": true,
    "message": "Daftar program studi berhasil diambil.",
    "data": [
      {
        "id": 1,
        "kode_prodi": "TRK",
        "nama_prodi": "Teknologi Rekayasa Komputer",
        "jenjang": "D4"
      }
    ],
    "errors": null
  }
  ```

#### 2. Program Studi Default TRK (`GET /external/prodi/default`)
* **Endpoint:** `GET /external/prodi/default`
* **Adapter Class:** `App\Services\External\ProdiApiService::getDefaultProdi()`
* **Deskripsi:** Helper praktis untuk frontend / sistem saat inisialisasi awal. Secara default selalu mengembalikan data resmi **Program Studi TRK (Teknologi Rekayasa Komputer)**. Helper ini memprioritaskan pencarian data TRK dari API Kelompok 1 secara otomatis saat instansiasi, dan menyajikan data fallback TRK bawaan jika API eksternal belum siap.
* **Headers:**
  ```http
  Accept: application/json
  Authorization: Bearer <access_token>
  ```
* **Respons Berhasil (HTTP 200):**
  ```json
  {
    "success": true,
    "message": "Program studi default (TRK) berhasil diambil.",
    "data": {
      "id": 1,
      "kode_prodi": "TRK",
      "nama_prodi": "Teknologi Rekayasa Komputer",
      "jenjang": "D4"
    },
    "errors": null
  }
  ```

#### 3. Daftar Dosen & Pengguna Internal (`GET /external/dosen`)
* **Endpoint:** `GET /external/dosen`
* **Adapter Class:** `App\Services\External\DosenApiService::getAllDosen()`
* **Sumber Data Eksternal:** API Kelompok 2 (`https://tridharma.fayra.my.id/api/dosen`) via `Illuminate\Support\Facades\Http`.
* **Deskripsi:** Mengambil daftar dosen resmi (NIDN, Nama, Email, Bidang Minat) dari Kelompok 2 untuk kebutuhan penugasan tim akreditasi (`/mapping-tim`).
* **Mekanisme Fallback Otomatis:**
  Jika server Kelompok 2 *unreachable*, *timeout*, atau mengalami *error* HTTP (5xx), adapter secara otomatis mengembalikan daftar dosen dummy/seeder fallback dengan atribut lengkap sehingga alur penugasan tim akreditasi tidak terganggu.
* **Headers:**
  ```http
  Accept: application/json
  Authorization: Bearer <access_token>
  ```
* **Respons Berhasil (HTTP 200):**
  ```json
  {
    "success": true,
    "message": "Daftar dosen berhasil diambil.",
    "data": [
      {
        "nidn": "0012048801",
        "nama": "Dr. Andi Wijaya, S.Kom., M.T.",
        "email": "andi.wijaya@kampus.ac.id",
        "bidang_minat": "Rekayasa Perangkat Lunak & Sistem Informasi"
      },
      {
        "nidn": "0023089002",
        "nama": "Siti Rahmawati, S.T., M.Kom.",
        "email": "siti.rahmawati@kampus.ac.id",
        "bidang_minat": "Jaringan Komputer & Keamanan Siber"
      },
      {
        "nidn": "0015118503",
        "nama": "Budi Santoso, S.Kom., M.Cs.",
        "email": "budi.santoso@kampus.ac.id",
        "bidang_minat": "Internet of Things (IoT) & Sistem Tertanam"
      }
    ],
    "errors": null
  }
  ```

---

## 5. Contoh Implementasi Fetch / Axios di Frontend

```javascript
import axios from 'axios';

const api = axios.create({
  baseURL: 'http://127.0.0.1:8000/api/v1',
  headers: {
    Accept: 'application/json',
    'Content-Type': 'application/json'
  }
});

// Interceptor untuk inject JWT Token
api.interceptors.request.use((config) => {
  const token = localStorage.getItem('access_token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

// Contoh 1: Ambil Rekap Skor Akreditasi
export const getRekapSkor = async (projectId) => {
  const response = await api.get(`/self-assessment/rekap/${projectId}`);
  return response.data.data;
};

// Contoh 2: Upload File Bukti Fisik
export const uploadBukti = async (formData) => {
  const response = await api.post('/bukti', formData, {
    headers: {
      'Content-Type': 'multipart/form-data'
    }
  });
  return response.data.data;
};

// Contoh 3: Ambil Daftar Program Studi & Prodi Default TRK (Integrasi Kelompok 1)
export const getExternalProdi = async () => {
  const response = await api.get('/external/prodi');
  return response.data.data; // Array of ExternalProdi
};

export const getDefaultTrkProdi = async () => {
  const response = await api.get('/external/prodi/default');
  return response.data.data; // Single ExternalProdi (TRK)
};

// Contoh 4: Ambil Daftar Dosen untuk Penugasan Tim (Integrasi Kelompok 2)
export const getExternalDosen = async () => {
  const response = await api.get('/external/dosen');
  return response.data.data; // Array of ExternalDosen (NIDN, Nama, Email, Bidang Minat)
};

// Contoh 5: Pembaruan Siklus Status Project Akreditasi (Lifecycle Status)
export const updateProjectStatus = async (projectId, status, verificationDate = null, skNumber = null) => {
  try {
    const payload = {
      status_project: status,
      tanggal_verifikasi_akreditasi: verificationDate,
      nomor_sk_akreditasi: skNumber
    };

    const response = await api.patch(`/projects/${projectId}/status`, payload);
    return response.data.data;
  } catch (error) {
    if (error.response && error.response.status === 422) {
      // Menangani penolakan status Selesai jika tanggal verifikasi atau nomor SK belum diisi
      console.error('Pembaruan status ditolak:', error.response.data.message);
      throw error.response.data;
    }
    throw error;
  }
};
```
