# Panduan Lengkap Integrasi REST API (Frontend Developer Guide)
### Sistem Penjaminan Mutu Internal (SPMI) & Akreditasi Program Studi (LAM-INFOKOM 2.1)

Dokumentasi ini disusun khusus sebagai **panduan integrasi resmi bagi Pengembang Frontend (React, Vue, Next.js, Nuxt, atau mobile)**. Seluruh endpoint, parameter, tipe data TypeScript, dan contoh JSON di bawah ini **100% akurat dan terverifikasi sesuai rute aktif pada backend Laravel**.

---

## 1. Konfigurasi Lingkungan (Environment Setup)

Frontend dapat menghubungkan aplikasi ke backend menggunakan konfigurasi berikut:

* **Production Base URL:** `https://akreditasi.fayra.my.id/api/v1`
* **Local Development Base URL:** `http://127.0.0.1:8000/api/v1`
* **SSO Auth Base URL:** `https://akademik.fayra.my.id/api/auth`
* **Format Data:** JSON (`Accept: application/json`, `Content-Type: application/json`)
* **Metode Autentikasi:** JWT Bearer Token (`Authorization: Bearer <access_token>`)
* **Masa Berlaku Token:** 3600 detik (1 Jam)

---

## 2. Alur Penggunaan Aplikasi di Frontend (User Flow)

Agar tim frontend memiliki gambaran jelas mengenai arsitektur sistem, berikut adalah alur utama interaksi aplikasi:

```text
[1. LOGIN SSO] ──► Dapatkan JWT Token & Role Pengguna (Admin, Kaprodi, Reviewer, Dosen)
       │
       ▼
[2. PILIH / BUAT PROJECT] ──► Gunakan 'Quick Create' (1-klik otomatis TRK) atau Form Kustom
       │
       ▼
[3. DASHBOARD METRICS] ──► Ambil progres persentase keterisian 9 Kriteria (0 - 100%)
       │
       ▼
[4. PLOTTING TIM] ──► Kaprodi menugaskan Dosen sebagai PJ & PIC per Butir Indikator
       │
       ├─────────────────────────────────┬─────────────────────────────────┐
       ▼                                 ▼                                 ▼
[5. INPUT BUKTI INDIKATOR]     [6. EVIDENCE SPMI 4 PILAR]     [7. PENILAIAN MANDIRI]
Dosen PIC mengunggah link      Kaprodi menginput link         Reviewer memilih skor (1-4).
bukti Google Drive per butir.  bukti mutu institusi.          Backend otomatis menghitung
                                                              'skor_terbobot' (skor * bobot).
       │                                 │                                 │
       └─────────────────────────────────┴─────────────────────────────────┘
       │
       ▼
[8. READINESS CHECK] ──► Validasi otomatis apakah ada butir yang belum ada PIC / Bukti / Nilai
       │
       ▼
[9. FINALISASI STATUS] ──► Update status project ke 'Selesai' (Wajib input Nomor SK & Tanggal Verif)
```

---

## 3. Matriks Hak Akses Peran Pengguna (Role-Based Access)

Setiap request ke backend wajib menyertakan token JWT pada header `Authorization: Bearer <token>`. Akses dibatasi berdasarkan role pengguna:

| Modul / Fitur | Administrator | Kaprodi | Reviewer | Dosen |
| :--- | :---: | :---: | :---: | :---: |
| **Master Data Instrumen & Kriteria** | Read / Write | Read Only | Read Only | Read Only |
| **Buat & Edit Project Akreditasi** | Full Access | Full Access | Read Only | Read Only |
| **Dashboard Progres & Readiness** | Full Access | Full Access | Full Access | Full Access |
| **Plotting Tim (PJ & PIC)** | Full Access | Full Access | Read Only | Read Only |
| **Upload Link Bukti per Butir** | Full Access | Full Access | Read Only | **Khusus Butir Tugasnya** |
| **Evidence SPMI 4 Pilar** | Full Access | Full Access | Read Only | Read Only |
| **Penilaian Mandiri (Skor 1 - 4)** | Full Access | Read Only | **Full Access** | Read Only |
| **Audit SPMI & Tindak Lanjut** | Full Access | Full Access | Read Only | Read Only |
| **Sarana & Prasarana Prodi** | Full Access | Full Access | Read Only | Read Only |

---

## 4. Standar Format Respons JSON (Response Envelope)

Seluruh respons dari server dibungkus secara seragam dalam format standar:

### A. Respons Berhasil (HTTP 200 / 201)
```json
{
  "success": true,
  "message": "Deskripsi aksi berhasil dilakukan",
  "data": { ... } // Berupa objek atau array data
}
```

### B. Respons Validasi Form Gagal (HTTP 422)
Frontend dapat langsung memetakan objek `errors` ke form input error message:
```json
{
  "success": false,
  "message": "Validasi gagal",
  "data": null,
  "errors": {
    "status_project": [
      "Status Selesai ditolak. Tanggal verifikasi akreditasi dan nomor SK akreditasi wajib diisi."
    ],
    "link_evidence": [
      "Kolom link evidence wajib diisi."
    ]
  }
}
```

### C. Respons Tidak Ditemukan (HTTP 404)
```json
{
  "success": false,
  "message": "Project akreditasi tidak ditemukan",
  "data": null
}
```

### D. Respons Tidak Memiliki Hak Akses (HTTP 401 / 403)
```json
{
  "success": false,
  "message": "Akses ditolak. Anda tidak memiliki izin untuk mengakses resource ini.",
  "data": null
}
```

---

## 5. Rincian Endpoint REST API Lengkap

### MODUL 0: AUTENTIKASI (SSO AKADEMIK)

#### 0.1 Login SSO Pengguna
Mengirim email dan password untuk mendapatkan token JWT.
* **URL:** `POST https://akademik.fayra.my.id/api/auth/login`
* **Headers:** `Accept: application/json`, `Content-Type: application/json`
* **Request Body:**
  ```json
  {
    "email": "user@polines.ac.id",
    "password": "password_rahasia"
  }
  ```
* **Respons Sukses (HTTP 200):**
  ```json
  {
    "success": true,
    "code": 200,
    "message": "Login berhasil",
    "data": {
      "user": {
        "id": 1,
        "nama": "Dr. Dosen Penguji, M.Kom.",
        "email": "user@polines.ac.id",
        "role": "DOSEN"
      },
      "authorization": {
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOi...",
        "token_type": "Bearer",
        "expires_in": 3600
      }
    }
  }
  ```

#### 0.2 Verifikasi Profil Lokal Akreditasi API
Mengecek identitas user yang saat ini sedang login pada sistem akreditasi.
* **URL:** `GET {{base_url}}/auth/me`
* **Headers:** `Authorization: Bearer <access_token>`
* **Respons Sukses (HTTP 200):**
  ```json
  {
    "success": true,
    "message": "Profil pengguna terautentikasi berhasil diambil.",
    "data": {
      "user": {
        "id": 1,
        "nama": "Dr. Dosen Penguji, M.Kom.",
        "email": "user@polines.ac.id",
        "role": "DOSEN"
      }
    }
  }
  ```

---

### MODUL 1: MASTER DATA INSTRUMEN & HIERARKI

Master data dapat diakses melalui dua cara:
1. Dengan prefix: `/api/v1/master/{endpoint}`
2. Direct alias tanpa prefix: `/api/v1/{endpoint}` (direkomendasikan untuk frontend)

#### 1.1 Ambil Hierarki Lengkap Instrumen (Full Tree)
**Endpoint paling penting untuk Frontend!** Mengembalikan seluruh struktur pohon akreditasi (Versi, Jenjang, Jenis, Kriteria, Subkriteria, Indikator, hingga Rubrik skor 1–4) dalam **satu kali pemanggilan** tanpa perlu request berulang.
* **URL:** `GET {{base_url}}/instrumen/{id_instrumen_uuid}/hierarchy`
* **Headers:** `Authorization: Bearer <access_token>`
* **Respons Sukses (HTTP 200):**
  ```json
  {
    "success": true,
    "message": "Struktur hierarki lengkap instrumen berhasil diambil",
    "data": {
      "id": "68d8ff1b-028f-410a-8bf7-814cb2a781b2",
      "versi_instrumen": {
        "id": 1,
        "nomor_versi": "2.1",
        "lembaga": {
          "id": 1,
          "nama_lembaga": "LAM INFOKOM"
        }
      },
      "jenjang": {
        "id": 1,
        "nama_jenjang": "Sarjana Terapan"
      },
      "jenis_instrumen": {
        "id": 1,
        "nama_jenis": "Instrumen APS untuk Status Terakreditasi Unggul"
      },
      "kriterias": [
        {
          "id": 1,
          "kode_kriteria": "A",
          "nama_kriteria": "Kondisi Eksternal",
          "subkriteria": [
            {
              "id": 1,
              "kode_subkriteria": "A.1",
              "nama_subkriteria": "Tren Industri TIK",
              "indikator": [
                {
                  "id": 1,
                  "kode_indikator": "IND-A.1.1",
                  "deskripsi_indikator": "Kesesuaian kurikulum dengan perkembangan teknologi Cloud & AI",
                  "bobot": 2.50,
                  "rubriks": [
                    { "id": 1, "skor": 4, "deskripsi_rubrik": "Sangat Sesuai dan kurikulum direview tiap tahun bersama industri" },
                    { "id": 2, "skor": 3, "deskripsi_rubrik": "Sesuai standar asosiasi profesi" },
                    { "id": 3, "skor": 2, "deskripsi_rubrik": "Cukup sesuai namun review belum berkala" },
                    { "id": 4, "skor": 1, "deskripsi_rubrik": "Kurang sesuai dengan kebutuhan industri" }
                  ]
                }
              ]
            }
          ]
        }
      ]
    }
  }
  ```

#### 1.2 Ambil Daftar Versi Instrumen
* **URL:** `GET {{base_url}}/versi-instrumen` (atau `GET {{base_url}}/master/versi-instrumen`)
* **Query Parameters (Opsional):**
  * `id_lembaga`: ID lembaga akreditasi (contoh: `1` untuk LAM-INFOKOM)
  * `id_jenjang`: ID jenjang (contoh: `1` untuk Sarjana Terapan)
  * `status_aktif`: Status keaktifan versi pada jenjang (`true` atau `false`)
* **Respons Sukses (HTTP 200):**
  ```json
  {
    "success": true,
    "message": "Data versi instrumen berhasil diambil",
    "data": [
      {
        "id": 1,
        "id_lembaga": 1,
        "nomor_versi": "2.1",
        "tanggal_berlaku": "2026-01-25",
        "lembaga": {
          "id": 1,
          "nama_lembaga": "LAM-INFOKOM"
        },
        "jenjangs": [
          {
            "id": 1,
            "nama_jenjang": "Sarjana Terapan",
            "pivot": {
              "id_versi_instrumen": 1,
              "id_jenjang": 1,
              "status_aktif": true
            }
          }
        ]
      }
    ]
  }
  ```

#### 1.3 Aktifkan Versi Instrumen (Khusus Admin)
Menjadikan versi tertentu aktif pada jenjang yang ditentukan sekaligus secara atomik menonaktifkan versi lain pada jenjang yang sama.
* **URL:** `PATCH {{base_url}}/master/versi-instrumen/{id}/aktifkan` (atau `PATCH {{base_url}}/versi-instrumen/{id}/aktifkan`)
* **Headers:** `Authorization: Bearer <admin_token>`
* **Request Body:**
  ```json
  {
    "id_jenjang": 1
  }
  ```
* **Respons Sukses (HTTP 200):**
  ```json
  {
    "success": true,
    "message": "Versi instrumen berhasil diaktifkan untuk jenjang tersebut",
    "data": {
      "id": 1,
      "nomor_versi": "2.1",
      "jenjangs": [
        {
          "id": 1,
          "nama_jenjang": "Sarjana Terapan",
          "pivot": {
            "status_aktif": true
          }
        }
      ]
    }
  }
  ```

---

### MODUL 2: PROJECT AKREDITASI & DASHBOARD

#### 2.1 Pembuatan Cepat Project TRK (Quick Create — Rekomendasi Frontend)
Membuat project akreditasi baru dengan 1-klik. Sistem otomatis memilih Versi 2.1 aktif, Jenjang Sarjana Terapan, dan Jenis Akreditasi Unggul.
* **URL:** `POST {{base_url}}/projects/quick-create`
* **Request Body:**
  ```json
  {
    "id_prodi": 101 // ID Prodi TRK
  }
  ```
* **Respons Sukses (HTTP 201):**
  ```json
  {
    "success": true,
    "message": "Project TRK berhasil dibuat",
    "data": {
      "id": 4,
      "id_prodi": 101,
      "id_versi_instrumen": 2,
      "id_jenjang": 1,
      "id_jenis_instrumen": 1,
      "nama_project": "Akreditasi Program Studi TRK 2026",
      "tahun_target_submit": 2026,
      "status_project": "Draft"
    }
  }
  ```

#### 2.2 Pembuatan Project Kustom
* **URL:** `POST {{base_url}}/projects`
* **Request Body:**
  ```json
  {
    "id_prodi": 101,
    "id_versi_instrumen": 2,
    "id_jenjang": 1,
    "id_jenis_instrumen": 1,
    "nama_project": "Akreditasi Sarjana Terapan TRK 2026",
    "tahun_target_submit": 2026,
    "status_project": "Draft"
  }
  ```

#### 2.3 Ambil Metrik Dasbor Keterisian 9 Kriteria (Dashboard Metrics)
Digunakan untuk merender grafik persentase keterisian data pada 9 kriteria akreditasi.
* **URL:** `GET {{base_url}}/projects/{id}/dashboard-progress`
* **Respons Sukses (HTTP 200):**
  ```json
  {
    "success": true,
    "message": "Metrik progres dashboard berhasil dihitung",
    "data": {
      "project_id": 4,
      "kriteria": [
        {
          "id": 1,
          "kode_kriteria": "A",
          "nama_kriteria": "Kondisi Eksternal",
          "total_indikator": 2,
          "indikator_terisi_bukti": 2,
          "progres_persen": 100
        },
        {
          "id": 2,
          "kode_kriteria": "C.2",
          "nama_kriteria": "Relevansi Pendidikan",
          "total_indikator": 10,
          "indikator_terisi_bukti": 7,
          "progres_persen": 70
        }
      ],
      "total_indikator": 53,
      "indikator_terisi_bukti": 35,
      "progres_total_persen": 66.04
    }
  }
  ```

#### 2.4 Pengecekan Kesiapan Submit (Readiness Check)
Digunakan saat Kaprodi ingin memeriksa apakah dokumen sudah lengkap sebelum diajukan.
* **URL:** `GET {{base_url}}/projects/{id}/readiness`
* **Respons Sukses (HTTP 200):**
  ```json
  {
    "success": true,
    "message": "Pengecekan kesiapan submit berhasil dilakukan",
    "data": {
      "project_id": 4,
      "total_indikator_kritis": 53,
      "jumlah_indikator_belum_siap": 2,
      "siap_submit": false,
      "indikator_belum_siap": [
        {
          "id_indikator": 12,
          "kode_indikator": "IND-C.2.3.1",
          "deskripsi_indikator": "Rasio komputer workstation di lab",
          "belum_terpenuhi": ["link_evidence", "skor_reviewer"]
        }
      ]
    }
  }
  ```

#### 2.5 Update Status Siklus Hidup Project
* **URL:** `PATCH {{base_url}}/projects/{id}/status`
* **Request Body:**
  ```json
  {
    "status_project": "On Progress" // Pilihan: 'Draft', 'On Progress', 'Pending', 'Cancel', 'Selesai'
  }
  ```
  *(Catatan: Jika memilih status `Selesai`, wajib mengirimkan `tanggal_verifikasi_akreditasi` dan `nomor_sk_akreditasi`)*:
  ```json
  {
    "status_project": "Selesai",
    "tanggal_verifikasi_akreditasi": "2026-12-10",
    "nomor_sk_akreditasi": "SK-BANPT-LAM-2026/01"
  }
  ```

---

### MODUL 3: PLOTTING TIM AKREDITASI (PJ & PIC)

#### 3.1 Penugasan Dosen per Butir Indikator (Batch Assignment)
* **URL:** `POST {{base_url}}/projects/{id}/mapping-tim`
* **Request Body:**
  ```json
  {
    "assignments": [
      {
        "id_user": 101, // ID Dosen dari SSO / API Kelompok 2
        "id_indikator": 1,
        "role": "PJ" // 'PJ' (Penanggung Jawab Kriteria) atau 'PIC' (Pelaksana Upload)
      },
      {
        "id_user": 102,
        "id_indikator": 1,
        "role": "PIC"
      }
    ]
  }
  ```

#### 3.2 Ambil Daftar Penugasan Tim
* **URL:** `GET {{base_url}}/projects/{id}/mapping-tim`
* **URL Alternatif:** `GET {{base_url}}/mapping-tim?id_project={id}&role=PIC`

#### 3.3 Hapus Penugasan Dosen
* **URL:** `DELETE {{base_url}}/mapping-tim/{id_mapping}`

---

### MODUL 4: PENGISIAN BUKTI INDIKATOR (DOSEN / PIC)

#### 4.1 Ambil Data Bukti pada Indikator Tertentu
* **URL:** `GET {{base_url}}/projects/{id}/indicators/{indicatorId}/evidence`
* **Respons Sukses (HTTP 200):**
  ```json
  {
    "success": true,
    "message": "Bukti indikator berhasil diambil",
    "data": {
      "id": 1,
      "id_project": 4,
      "id_indikator": 1,
      "link_evidence": "https://drive.google.com/drive/folders/link-folder-bukti-cpl"
    }
  }
  ```

#### 4.2 Simpan / Perbarui Link Bukti Indikator
Dosen PIC menautkan link Google Drive / cloud dokumen bukti pendukung.
* **URL:** `PUT {{base_url}}/projects/{id}/indicators/{indicatorId}/evidence`
* **Request Body:**
  ```json
  {
    "link_evidence": "https://drive.google.com/drive/folders/1A2B3C4D5E_bukti_cpl"
  }
  ```

---

### MODUL 5: EVIDENCE SPMI DOKUMEN MUTU (4 PILAR)

Model ini menyimpan rekapitulasi bukti mutu institusi untuk project akreditasi (*One-to-One*).

#### 5.1 Ambil Dokumen Evidence SPMI
* **URL:** `GET {{base_url}}/evidence-spmi?project_id={id}`
* **Respons Sukses (HTTP 200):**
  ```json
  {
    "success": true,
    "message": "Data evidence SPMI berhasil diambil",
    "data": {
      "id": 1,
      "project_id": 4,
      "link_bukti_evaluasi": "https://drive.google.com/drive/folders/evaluasi-ami-2026",
      "deskripsi_bukti_evaluasi": "Laporan Audit Mutu Internal Siklus 2025/2026",
      "link_bukti_pengendalian": "https://drive.google.com/drive/folders/rtm-rtl-2026",
      "deskripsi_bukti_pengendalian": "Notula Rapat Tinjauan Manajemen & Rencana Tindak Lanjut",
      "link_bukti_dampak": "https://drive.google.com/drive/folders/dampak-kepuasan-2026",
      "deskripsi_bukti_dampak": "Rekapitulasi IKU dan survei kepuasan mitra DUDI",
      "link_dokumen_implementasi": "https://drive.google.com/drive/folders/manual-spmi-2026",
      "deskripsi_dokumen_implementasi": "Buku Kebijakan SPMI, Manual Mutu, dan SOP PPEPP"
    }
  }
  ```

#### 5.2 Simpan / Perbarui Evidence SPMI
* **URL:** `POST {{base_url}}/evidence-spmi`
* **Request Body:**
  ```json
  {
    "project_id": 4,
    "link_bukti_evaluasi": "https://drive.google.com/drive/folders/evaluasi-ami-2026",
    "deskripsi_bukti_evaluasi": "Laporan AMI Siklus 2025/2026",
    "link_bukti_pengendalian": "https://drive.google.com/drive/folders/rtm-rtl-2026",
    "deskripsi_bukti_pengendalian": "Notula RTM",
    "link_bukti_dampak": "https://drive.google.com/drive/folders/dampak-kepuasan-2026",
    "deskripsi_bukti_dampak": "Survei Kepuasan",
    "link_dokumen_implementasi": "https://drive.google.com/drive/folders/manual-spmi-2026",
    "deskripsi_dokumen_implementasi": "Manual PPEPP"
  }
  ```

---

### MODUL 6: PENILAIAN MANDIRI (SELF ASSESSMENT / REVIEWER)

#### 6.1 Simpan Penilaian Mandiri (Skor Otomatis Terbobot)
Reviewer memilih salah satu ID Rubrik (skor 1, 2, 3, atau 4). **Backend secara otomatis menghitung `skor_terbobot = skor * bobot_indikator`**.
* **URL:** `POST {{base_url}}/self-assessment`
* **Request Body:**
  ```json
  {
    "id_project": 4,
    "id_indikator": 1,
    "id_rubrik": 1, // Rubrik skor 4
    "reviewer_id": 1,
    "catatan_reviewer": "Kurikulum telah berbasis OBE dan terverifikasi mitra industri.",
    "tanggal_penilaian": "2026-11-15"
  }
  ```
* **Respons Sukses (HTTP 200):**
  ```json
  {
    "success": true,
    "message": "Penilaian mandiri berhasil disimpan",
    "data": {
      "id": 1,
      "id_project": 4,
      "id_indikator": 1,
      "id_rubrik": 1,
      "skor_terbobot": 10.00, // Hasil otomatis: 4.0 * bobot 2.5
      "catatan_reviewer": "Kurikulum telah berbasis OBE dan terverifikasi mitra industri.",
      "reviewer_id": 1,
      "tanggal_penilaian": "2026-11-15"
    }
  }
  ```

#### 6.2 Ambil Daftar Penilaian Project
* **URL:** `GET {{base_url}}/self-assessment?id_project={id}`

---

### MODUL 7: AUDIT SPMI & TINDAK LANJUT TEMUAN

#### 7.1 Tambah Temuan Audit SPMI
* **URL:** `POST {{base_url}}/spmi-audit`
* **Request Body:**
  ```json
  {
    "id_project": 4,
    "id_indikator": 1,
    "jenis_kegiatan": "AMI", // 'PPEPP' | 'AMI' | 'RTM'
    "tanggal_pelaksanaan": "2026-11-10",
    "tahun_audit": 2026,
    "temuan": "Modul praktikum cloud computing belum mengadopsi platform AWS/GCP terbaru.",
    "tindak_lanjut": "Pengadaan workshop sertifikasi cloud untuk dosen pengampu.",
    "status_penyelesaian": "Open"
  }
  ```

#### 7.2 Update Khusus Tindak Lanjut oleh Kaprodi
Kaprodi memperbarui status penyelesaian perbaikan atas temuan auditor.
* **URL:** `PATCH {{base_url}}/spmi-audit/{id}/tindak-lanjut`
* **Request Body:**
  ```json
  {
    "tindak_lanjut": "Workshop cloud computing telah terlaksana pada 14 November 2026.",
    "status_penyelesaian": "Closed" // 'Open' | 'In Progress' | 'Closed'
  }
  ```

---

### MODUL 8: INTEGRASI EKSTERNAL (KELOMPOK 1 & KELOMPOK 2)

Endpoint ini digunakan oleh frontend untuk mengisi pilihan dropdown Program Studi dan Dosen tanpa takut server kelompok lain down (backend memiliki fallback data cerdas).

#### 8.1 Daftar Program Studi Resmi (Kelompok 1)
* **URL:** `GET {{base_url}}/external/prodi`
* **Respons:** Daftar prodi (ID, Nama, Jenjang).

#### 8.2 Program Studi Default TRK (Kelompok 1)
* **URL:** `GET {{base_url}}/external/prodi/default`
* **Respons:** Mengembalikan detail program studi TRK (*Teknologi Rekayasa Komputer*).

#### 8.3 Daftar Dosen Resmi untuk Plotting Tim (Kelompok 2)
* **URL:** `GET {{base_url}}/external/dosen`
* **Respons Sukses (HTTP 200):**
  ```json
  {
    "success": true,
    "message": "Daftar dosen berhasil diambil",
    "data": [
      {
        "id": 101,
        "nidn": "0012058501",
        "nama": "Budi Santoso, M.Kom.",
        "email": "budi.santoso@polines.ac.id",
        "bidang_minat": "Software Engineering & Cloud"
      }
    ]
  }
  ```

---

## 6. TypeScript Interfaces (Siap Pakai untuk Frontend)

Frontend developer dapat menyalin langsung interface TypeScript di bawah ini ke dalam proyek frontend (`src/types/akreditasi.ts`):

```typescript
// Envelope Standar API
export interface ApiResponse<T> {
  success: boolean;
  message: string;
  data: T;
  errors?: Record<string, string[]>;
}

// User & Auth
export interface UserProfile {
  id: number;
  nama: string;
  email: string;
  role: 'ADMINISTRATOR' | 'KAPRODI' | 'REVIEWER' | 'DOSEN';
}

// Hierarki Master Data
export interface LembagaAkreditasi {
  id: number;
  nama_lembaga: string;
  keterangan?: string;
}

export interface Jenjang {
  id: number;
  nama_jenjang: string;
}

export interface VersiInstrumenJenjang extends Jenjang {
  pivot?: {
    id_versi_instrumen: number;
    id_jenjang: number;
    status_aktif: boolean;
  };
}

export interface VersiInstrumen {
  id: number;
  id_lembaga: number;
  nomor_versi: string;
  tanggal_berlaku: string;
  status_aktif?: boolean;
  lembaga?: LembagaAkreditasi;
  jenjangs?: VersiInstrumenJenjang[];
}

export interface JenisInstrumen {
  id: number;
  nama_jenis: string;
}

export interface Rubrik {
  id: number;
  id_indikator: number;
  skor: number; // 1 | 2 | 3 | 4
  deskripsi_rubrik: string;
}

export interface Indikator {
  id: number;
  id_subkriteria: number;
  kode_indikator: string;
  deskripsi_indikator: string;
  bobot: number;
  rubriks?: Rubrik[];
}

export interface Subkriteria {
  id: number;
  id_kriteria: number;
  kode_subkriteria: string;
  nama_subkriteria: string;
  indikator?: Indikator[];
}

export interface Kriteria {
  id: number;
  id_instrumen: string;
  kode_kriteria: string;
  nama_kriteria: string;
  subkriteria?: Subkriteria[];
}

export interface InstrumenHierarchy {
  id: string; // UUID
  versi_instrumen: VersiInstrumen;
  jenjang: Jenjang;
  jenis_instrumen: JenisInstrumen;
  kriterias: Kriteria[];
}

// Project & Dashboard
export interface ProjectAkreditasi {
  id: number;
  id_prodi: number;
  id_versi_instrumen: number;
  id_jenjang: number;
  id_jenis_instrumen: number;
  nama_project: string;
  tahun_target_submit: number;
  status_project: 'Draft' | 'On Progress' | 'Pending' | 'Cancel' | 'Selesai';
  tanggal_verifikasi_akreditasi?: string | null;
  nomor_sk_akreditasi?: string | null;
}

export interface CriteriaProgress {
  id: number;
  kode_kriteria: string;
  nama_kriteria: string;
  total_indikator: number;
  indikator_terisi_bukti: number;
  progres_persen: number;
}

export interface DashboardProgressData {
  project_id: number;
  kriteria: CriteriaProgress[];
  total_indikator: number;
  indikator_terisi_bukti: number;
  progres_total_persen: number;
}

export interface ProjectReadinessData {
  project_id: number;
  total_indikator_kritis: number;
  jumlah_indikator_belum_siap: number;
  siap_submit: boolean;
  indikator_belum_siap: Array<{
    id_indikator: number;
    kode_indikator: string;
    deskripsi_indikator: string;
    belum_terpenuhi: ('pic' | 'link_evidence' | 'skor_reviewer')[];
  }>;
}

// Plotting Tim
export interface MappingTimAkreditasi {
  id: number;
  id_project: number;
  id_user: number;
  id_indikator: number;
  role: 'PJ' | 'PIC';
  user?: {
    id: number;
    nama: string;
    email: string;
  };
}

// Evidence per Indikator
export interface IndicatorEvidence {
  id: number;
  id_project: number;
  id_indikator: number;
  link_evidence: string;
}

// Evidence SPMI 4 Pilar
export interface EvidenceSpmi {
  id: number;
  project_id: number;
  link_bukti_evaluasi?: string;
  deskripsi_bukti_evaluasi?: string;
  link_bukti_pengendalian?: string;
  deskripsi_bukti_pengendalian?: string;
  link_bukti_dampak?: string;
  deskripsi_bukti_dampak?: string;
  link_dokumen_implementasi?: string;
  deskripsi_dokumen_implementasi?: string;
}

// Self Assessment
export interface SelfAssessment {
  id: number;
  id_project: number;
  id_indikator: number;
  id_rubrik: number;
  skor_terbobot: number;
  catatan_reviewer?: string;
  reviewer_id?: number;
  tanggal_penilaian?: string;
}

// SPMI Audit
export interface SpmiAudit {
  id: number;
  id_project: number;
  id_indikator?: number | null;
  jenis_kegiatan: 'PPEPP' | 'AMI' | 'RTM';
  tanggal_pelaksanaan: string;
  tahun_audit: number;
  temuan?: string;
  tindak_lanjut?: string;
  status_penyelesaian: 'Open' | 'In Progress' | 'Closed';
}
```

---

## 7. Contoh Template Klien API di Frontend (Axios Service)

Frontend dapat menggunakan boilerplate Axios ini (`src/services/api.ts`) untuk langsung berkomunikasi dengan backend:

```typescript
import axios from 'axios';

const api = axios.create({
  baseURL: process.env.NEXT_PUBLIC_API_URL || 'https://akreditasi.fayra.my.id/api/v1',
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
  },
  timeout: 10000,
});

// Interceptor: Otomatis lampirkan Token JWT di setiap request
api.interceptors.request.use((config) => {
  const token = typeof window !== 'undefined' ? localStorage.getItem('jwt_token') : null;
  if (token && config.headers) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

// Interceptor: Tangani 401 Unauthorized otomatis (redirect login)
api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      if (typeof window !== 'undefined') {
        localStorage.removeItem('jwt_token');
        window.location.href = '/login';
      }
    }
    return Promise.reject(error);
  }
);

export default api;
```

---

## 8. Panduan Praktis & Tips Implementasi UI/UX Frontend

Untuk mempermudah dan mempercepat pengerjaan antarmuka pengguna, berikut adalah panduan praktis implementasi setiap alur:

### 8.1 Pembuatan Project (Quick Create vs Kustom)
* **Rekomendasi UI:** Sediakan tombol utama bertuliskan **"Buat Cepat Project TRK 2026"** di samping tombol "Buat Project Manual".
* Tombol cepat langsung menembak `POST /projects/quick-create` dengan payload `{ id_prodi: 101 }`. Pengguna tidak perlu dipusingkan dengan memilih versi instrumen 2.1, jenjang Sarjana Terapan, maupun jenis instrumen APS Unggul secara manual.

### 8.2 Dashboard Progres 9 Kriteria LAM-INFOKOM
* Panggil `GET /projects/{id}/dashboard-progress` saat halaman dashboard dibuka.
* Backend sudah menyediakan metrik siap pakai:
  * `progres_total_persen`: Persentase akumulasi seluruh butir indikator yang memiliki link evidence valid.
  * Array `kriteria`: Menampung progres masing-masing kriteria (Kriteria 1 sampai Kriteria 9).
* **Rekomendasi Warna Progress Bar:**
  * `0%`: Badge abu-abu (`Belum Dimulai`)
  * `1%` – `49%`: Bar merah/kuning (`Tahap Pengumpulan`)
  * `50%` – `99%`: Bar biru (`Hampir Selesai`)
  * `100%`: Bar hijau dengan ikon centang (`Lengkap`)

### 8.3 Pengisian Bukti per Butir Indikator (Role Dosen PIC)
* Panggil `GET /projects/{id}/indicators/{indicatorId}/evidence` untuk mengecek apakah bukti sudah pernah diisi.
* Saat Dosen PIC memasukkan tautan Google Drive/Cloud, kirimkan `PUT /projects/{id}/indicators/{indicatorId}/evidence` dengan body `{ "link_evidence": "https://..." }`.
* Sistem secara otomatis melacak butir mana saja yang telah terpenuhi buktinya.

### 8.4 Penilaian Mandiri oleh Reviewer Internal
* Reviewer membuka hierarki instrumen `GET /master/instrumen/{id}/hierarchy`.
* Setiap indikator memiliki daftar rubrik (skor 1, 2, 3, 4) beserta deskripsinya.
* Saat Reviewer memilih skor rubrik, kirimkan `POST /self-assessment` dengan body `{ id_project, id_indikator, id_rubrik, catatan_reviewer }`.
* **Catatan Penting:** Frontend **TIDAK PERLU** menghitung perkalian bobot manual. Backend secara otomatis menghitung `skor_terbobot = skor_rubrik * bobot_indikator`.

### 8.5 Pemeriksaan Kesiapan Submit (Readiness Checklist)
* Sebelum tombol **"Finalisasi / Ajukan Akreditasi"** dapat diklik, frontend wajib memanggil `GET /projects/{id}/readiness`.
* Jika `siap_submit: false`:
  * Nonaktifkan (disable) tombol submit.
  * Tampilkan modal / drawer berisikan daftar butir indikator yang belum siap (`indikator_belum_siap`).
  * Tampilkan tag merah untuk komponen yang belum lengkap: `Belum ada PIC`, `Bukti Belum Diunggah`, atau `Belum Dinilai Reviewer`.

### 8.6 Penanganan Error & Notifikasi Proteksi Hapus
* Jika user mencoba menghapus Versi Instrumen atau Kriteria yang masih dipakai oleh project, backend mengembalikan status `HTTP 422` dengan pesan edukatif.
* Pastikan frontend menangkap pesan `error.response.data.message` dan menampilkannya dalam SweetAlert/Toast notifikasi agar pengguna memahami alasan kegagalan tersebut.

