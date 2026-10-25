# REST API Documentation — Sistem Akreditasi & SPMI (LAM INFOKOM 2.1)

Dokumentasi ini dirancang khusus sebagai panduan integrasi bagi **Agent AI / Pengembang Frontend**. Seluruh endpoint diproteksi menggunakan **JWT Bearer Token** yang diterbitkan oleh layanan SSO Akademik.

---

## 1. Layanan Autentikasi Terpusat (SSO Akademik)

Sistem Akreditasi menggunakan autentikasi SSO terpusat dari server Akademik:
* **Host SSO Auth:** `https://akademik.fayra.my.id/api/auth`
* **Metode Otentikasi:** JWT Bearer Token (`Authorization: Bearer <access_token>`)
* **Masa Berlaku Token:** 3600 detik (1 Jam)

### Kredensial Pengujian (Demo Akun)
* **Email:** `administrator@polines.ac.id`
* **Password:** `password`
* **Role:** `ADMINISTRATOR` *(Dukungan Role: ADMINISTRATOR, KAPRODI, REVIEWER, DOSEN)*

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
    "email": "administrator@polines.ac.id",
    "password": "password"
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
        "nama": "Administrator Sistem",
        "email": "administrator@polines.ac.id",
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
      "nama": "Administrator Sistem",
      "email": "administrator@polines.ac.id",
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
        "nama": "Administrator Sistem",
        "email": "administrator@polines.ac.id",
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

export interface VersiInstrumen {
  id: number;
  id_lembaga: number;
  nomor_versi: string;
  tanggal_berlaku: string;
  status_aktif: boolean;
  lembaga?: LembagaAkreditasi;
}

export interface Kriteria {
  id: number;
  id_versi_instrumen: number;
  kode_kriteria: string;
  nama_kriteria: string;
}

export interface Subkriteria {
  id: number;
  id_kriteria: number;
  kode_subkriteria: string;
  nama_subkriteria: string;
}

export interface Indikator {
  id: number;
  id_subkriteria: number;
  kode_indikator: string;
  nama_indikator: string;
  deskripsi: string | null;
  standar_minimum: number | null;
}

export interface Rubrik {
  id: number;
  id_indikator: number;
  skor: number;
  deskripsi_kondisi: string;
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
  tahun_akreditasi: string;
  status: 'draft' | 'pengisian' | 'review' | 'selesai';
  target_peringkat: string | null;
}

export interface MappingTimAkreditasi {
  id: number;
  id_project: number;
  id_user: number;
  id_indikator: number;
  role: 'ADMINISTRATOR' | 'REVIEWER' | 'DOSEN' | 'KAPRODI'; // Selalu 'DOSEN' untuk anggota tim akreditasi
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

### A. Modul Master Data (`/master/`)

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
| `GET` | `/master/kriteria` | `?id_versi_instrumen=` | Mengambil daftar kriteria (opsional filter versi) |
| `POST` | `/master/kriteria` | `{ id_versi_instrumen, kode_kriteria, nama_kriteria }` | Tambah kriteria baru |
| `GET` | `/master/kriteria/{id}` | - | Detail kriteria |
| `PUT` | `/master/kriteria/{id}` | `{ id_versi_instrumen, kode_kriteria, nama_kriteria }` | Update kriteria |
| `DELETE` | `/master/kriteria/{id}` | - | Hapus kriteria |
| `GET` | `/master/indikator` | `?id_subkriteria=` | Mengambil daftar indikator / butir penilaian |
| `POST` | `/master/indikator` | `{ id_subkriteria, kode_indikator, nama_indikator, deskripsi?, standar_minimum? }` | Tambah indikator |
| `GET` | `/master/indikator/{id}` | - | Detail indikator beserta rubrik |
| `PUT` | `/master/indikator/{id}` | `{ id_subkriteria, kode_indikator, nama_indikator, deskripsi?, standar_minimum? }` | Update indikator |
| `DELETE` | `/master/indikator/{id}` | - | Hapus indikator |
| `GET` | `/master/rubrik` | `?id_indikator=` | Mengambil opsi rubrik skor (1-4) |
| `POST` | `/master/rubrik` | `{ id_indikator, skor, deskripsi_kondisi }` | Tambah opsi rubrik skor |
| `GET` | `/master/rubrik/{id}` | - | Detail rubrik |
| `PUT` | `/master/rubrik/{id}` | `{ id_indikator, skor, deskripsi_kondisi }` | Update rubrik |
| `DELETE` | `/master/rubrik/{id}` | - | Hapus rubrik |
| `GET` | `/master/standar-mutu` | - | Mengambil daftar standar mutu SPMI |
| `POST` | `/master/standar-mutu` | `{ kode_standar, nama_standar, pernyataan_standar }` | Tambah standar mutu baru |
| `GET` | `/master/standar-mutu/{id}` | - | Detail standar mutu |
| `PUT` | `/master/standar-mutu/{id}` | `{ kode_standar, nama_standar, pernyataan_standar }` | Update standar mutu |
| `DELETE` | `/master/standar-mutu/{id}` | - | Hapus standar mutu |
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

### B. Modul Akreditasi

#### 1. Project Akreditasi (`/projects`)
* **`GET /projects`** (`?id_prodi=&status=`): List project akreditasi prodi.
* **`POST /projects`**: Membuat project akreditasi baru.
  ```json
  {
    "id_prodi": 1,
    "id_versi_instrumen": 1,
    "id_jenjang": 1,
    "id_jenis_instrumen": 1,
    "tahun_akreditasi": "2026/2027",
    "status": "draft",
    "target_peringkat": "Unggul"
  }
  ```
* **`GET /projects/{id}`**: Detail project lengkap dengan relasi prodi, versi, jenjang, lembar prodi, dll.
* **`PUT /projects/{id}`**: Update project akreditasi.
* **`DELETE /projects/{id}`**: Hapus project akreditasi.
* **`POST /projects/{id}/mapping-tim`**: Menugaskan dosen/PIC per indikator.
  ```json
  {
    "id_user": 101,
    "id_indikator": 1,
    "role": "Penyusun"
  }
  ```

#### 2. Lembar Kerja Prodi (`/lembar-prodi`)
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

#### 3. Upload & Validasi Berkas Bukti (`/bukti`)
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

#### 4. Self Assessment / Penilaian Mandiri (`/self-assessment`)
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

### C. Modul SPMI & Audit Mutu (`/spmi-audit`)

* **`GET /spmi-audit`** (`?id_prodi=&tahun=&status_audit=`): List temuan audit mutu.
* **`POST /spmi-audit`**: Tambah temuan audit baru.
  ```json
  {
    "id_prodi": 1,
    "id_standar_mutu": 1,
    "id_auditor": 401,
    "tahun": 2026,
    "hasil_audit": "Observasi", // 'Kesesuaian' | 'Ketidaksesuaian Mayor' | 'Ketidaksesuaian Minor' | 'Observasi'
    "kondisi_temuan": "Dokumen SOP pelaksanaan RPS belum diperbarui.",
    "akar_masalah": "Keterbatasan waktu koordinasi tim kurikulum.",
    "rekomendasi": "Lakukan workshop review SOP pembelajaran.",
    "status_audit": "Open",
    "tanggal_audit": "2026-10-15"
  }
  ```
* **`GET /spmi-audit/{id}`**: Detail temuan audit.
* **`PUT /spmi-audit/{id}`**: Update data audit.
* **`DELETE /spmi-audit/{id}`**: Hapus temuan audit.
* **`PUT /spmi-audit/{id}/tindak-lanjut`** (atau `PATCH`): Auditee mengisi rencana tindak lanjut perbaikan temuan audit.
  ```json
  {
    "rencana_tindak_lanjut": "Mengadakan rapat konsinyasi penyelarasan RPS.",
    "status_tindak_lanjut": "Selesai", // 'Belum Dilaksanakan' | 'Sedang Berjalan' | 'Selesai' | 'Efektif'
    "tanggal_efektif": "2026-11-01",
    "evaluasi_efektivitas": "Seluruh RPS telah sesuai kurikulum terbaru."
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
* **`POST /sarana-prodi`**: Tambah sarana.
  ```json
  {
    "id_prasarana": 1,
    "nama_sarana": "PC Workstation Core i7 32GB RAM",
    "jumlah": 30,
    "kondisi": "Baik"
  }
  ```
* **`GET /sarana-prodi/{id}`**: Detail sarana.
* **`PUT /sarana-prodi/{id}`**: Update sarana.
* **`DELETE /sarana-prodi/{id}`**: Hapus sarana.

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
```
