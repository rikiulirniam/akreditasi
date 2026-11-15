# Dokumentasi REST API Sistem Informasi Akademik (Kelompok 1)
### Basis Data Akademik, Autentikasi SSO, Mahasiswa, Dosen, Kurikulum & Institusi

> Dokumen ini diekstraksi dan distrukturkan secara otomatis langsung dari spesifikasi OpenAPI 3.0 resmi pada server live: `https://akademik.fayra.my.id/api/documentation`.

---

## 1. Konfigurasi Lingkungan & Autentikasi
* **Base URL:** `https://akademik.fayra.my.id`
* **API Prefix:** `https://akademik.fayra.my.id/api`
* **Format Pertukaran Data:** `application/json`
* **Metode Autentikasi:** JWT Bearer Token (`Authorization: Bearer <access_token>`)
* **Endpoint Login SSO:** `POST /api/auth/login`
* **Default Test Credentials:**
  * Email: `administrator@polines.ac.id`
  * Password: `password`
* **Masa Berlaku Token:** 3600 detik (1 Jam)

---

## 2. Ringkasan Modul & Daftar Endpoint

Total Endpoint Tersedia: **143 Endpoint** yang terbagi dalam **9 Modul Utama**:

### [Institusi & Program Studi](#institusi-program-studi) (20 endpoint)
| Method | Endpoint | Ringkasan / Deskripsi |
| :---: | :--- | :--- |
| `GET` | `/api/anggota-upps` | Daftar Semua Data Anggota UPPS |
| `POST` | `/api/anggota-upps` | Tambah Data Anggota UPPS Baru |
| `GET` | `/api/anggota-upps/{id}` | Detail Data Anggota UPPS |
| `PUT` | `/api/anggota-upps/{id}` | Perbarui Data Anggota UPPS |
| `DELETE` | `/api/anggota-upps/{id}` | Hapus Data Anggota UPPS |
| `GET` | `/api/perguruan-tinggi` | Daftar Semua Data Perguruan Tinggi |
| `POST` | `/api/perguruan-tinggi` | Tambah Data Perguruan Tinggi Baru |
| `GET` | `/api/perguruan-tinggi/{id}` | Detail Data Perguruan Tinggi |
| `PUT` | `/api/perguruan-tinggi/{id}` | Perbarui Data Perguruan Tinggi |
| `DELETE` | `/api/perguruan-tinggi/{id}` | Hapus Data Perguruan Tinggi |
| `GET` | `/api/prodi` | Daftar Semua Data Program Studi |
| `POST` | `/api/prodi` | Tambah Data Program Studi Baru |
| `GET` | `/api/prodi/{id}` | Detail Data Program Studi |
| `PUT` | `/api/prodi/{id}` | Perbarui Data Program Studi |
| `DELETE` | `/api/prodi/{id}` | Hapus Data Program Studi |
| `GET` | `/api/upps` | Daftar Semua Data UPPS |
| `POST` | `/api/upps` | Tambah Data UPPS Baru |
| `GET` | `/api/upps/{id}` | Detail Data UPPS |
| `PUT` | `/api/upps/{id}` | Perbarui Data UPPS |
| `DELETE` | `/api/upps/{id}` | Hapus Data UPPS |

### [Struktur Akademik & Kelas](#struktur-akademik-kelas) (25 endpoint)
| Method | Endpoint | Ringkasan / Deskripsi |
| :---: | :--- | :--- |
| `GET` | `/api/angkatan` | Daftar Semua Data Angkatan |
| `POST` | `/api/angkatan` | Tambah Data Angkatan Baru |
| `GET` | `/api/angkatan/{id}` | Detail Data Angkatan |
| `PUT` | `/api/angkatan/{id}` | Perbarui Data Angkatan |
| `DELETE` | `/api/angkatan/{id}` | Hapus Data Angkatan |
| `GET` | `/api/angkatan-kelas` | Daftar Semua Data Angkatan Kelas |
| `POST` | `/api/angkatan-kelas` | Tambah Data Angkatan Kelas Baru |
| `GET` | `/api/angkatan-kelas/{id}` | Detail Data Angkatan Kelas |
| `PUT` | `/api/angkatan-kelas/{id}` | Perbarui Data Angkatan Kelas |
| `DELETE` | `/api/angkatan-kelas/{id}` | Hapus Data Angkatan Kelas |
| `GET` | `/api/angkatan-kelas/{id}/mahasiswa` | Mahasiswa Angkatan Kelas |
| `GET` | `/api/angkatan-kelas/{id}/mata-kuliah` | Mata Kuliah Angkatan Kelas |
| `GET` | `/api/kelas` | Daftar Semua Data Kelas |
| `POST` | `/api/kelas` | Tambah Data Kelas Baru |
| `GET` | `/api/kelas/{id}` | Detail Data Kelas |
| `PUT` | `/api/kelas/{id}` | Perbarui Data Kelas |
| `DELETE` | `/api/kelas/{id}` | Hapus Data Kelas |
| `GET` | `/api/kelas/{id}/mahasiswa` | Mahasiswa Kelas |
| `GET` | `/api/kelas/{id}/mata-kuliah` | Mata Kuliah Kelas |
| `GET` | `/api/tahun-akademik` | Daftar Semua Data Tahun Akademik |
| `POST` | `/api/tahun-akademik` | Tambah Data Tahun Akademik Baru |
| `GET` | `/api/tahun-akademik/{id}` | Detail Data Tahun Akademik |
| `PUT` | `/api/tahun-akademik/{id}` | Perbarui Data Tahun Akademik |
| `DELETE` | `/api/tahun-akademik/{id}` | Hapus Data Tahun Akademik |
| `GET` | `/api/tahun-akademik/{id}/kelas` | Kelas Tahun Akademik |

### [Autentikasi](#autentikasi) (5 endpoint)
| Method | Endpoint | Ringkasan / Deskripsi |
| :---: | :--- | :--- |
| `POST` | `/api/auth/login` | Login Pengguna dan Dapatkan Token JWT |
| `POST` | `/api/auth/google` | Login Menggunakan Google ID Token |
| `GET` | `/api/auth/me` | Profil Pengguna Terautentikasi |
| `POST` | `/api/auth/logout` | Logout dan Invalidasi Token |
| `POST` | `/api/auth/refresh` | Perbarui Token Akses JWT |

### [Kurikulum & Standar CPL](#kurikulum-standar-cpl) (18 endpoint)
| Method | Endpoint | Ringkasan / Deskripsi |
| :---: | :--- | :--- |
| `GET` | `/api/cpl` | Daftar Semua Data Capaian Pembelajaran (CPL) |
| `POST` | `/api/cpl` | Tambah Data Capaian Pembelajaran (CPL) Baru |
| `GET` | `/api/cpl/{id}` | Detail Data Capaian Pembelajaran (CPL) |
| `PUT` | `/api/cpl/{id}` | Perbarui Data Capaian Pembelajaran (CPL) |
| `DELETE` | `/api/cpl/{id}` | Hapus Data Capaian Pembelajaran (CPL) |
| `GET` | `/api/kurikulum` | Daftar Semua Data Kurikulum |
| `POST` | `/api/kurikulum` | Tambah Data Kurikulum Baru |
| `GET` | `/api/kurikulum/{id}` | Detail Data Kurikulum |
| `PUT` | `/api/kurikulum/{id}` | Perbarui Data Kurikulum |
| `DELETE` | `/api/kurikulum/{id}` | Hapus Data Kurikulum |
| `GET` | `/api/kurikulum/{id}/mata-kuliah` | Mata Kuliah Kurikulum |
| `GET` | `/api/mata-kuliah/{mataKuliahId}/cpl` | Daftar Semua Data Mapping Mata Kuliah CPL |
| `POST` | `/api/mata-kuliah/{mataKuliahId}/cpl/sync` | Sinkronisasi Mapping Mata Kuliah CPL |
| `GET` | `/api/mata-kuliah` | Daftar Semua Data Mata Kuliah |
| `POST` | `/api/mata-kuliah` | Tambah Data Mata Kuliah Baru |
| `GET` | `/api/mata-kuliah/{id}` | Detail Data Mata Kuliah |
| `PUT` | `/api/mata-kuliah/{id}` | Perbarui Data Mata Kuliah |
| `DELETE` | `/api/mata-kuliah/{id}` | Hapus Data Mata Kuliah |

### [Dosen](#dosen) (1 endpoint)
| Method | Endpoint | Ringkasan / Deskripsi |
| :---: | :--- | :--- |
| `GET` | `/api/dosen` | Daftar Semua Data Dosen |

### [Data & Aktivitas Mahasiswa](#data-aktivitas-mahasiswa) (21 endpoint)
| Method | Endpoint | Ringkasan / Deskripsi |
| :---: | :--- | :--- |
| `GET` | `/api/enrollment-kelas` | Daftar Semua Data Enrollment Kelas |
| `POST` | `/api/enrollment-kelas` | Tambah Data Enrollment Kelas Baru |
| `GET` | `/api/enrollment-kelas/{id}` | Detail Data Enrollment Kelas |
| `PUT` | `/api/enrollment-kelas/{id}` | Perbarui Data Enrollment Kelas |
| `DELETE` | `/api/enrollment-kelas/{id}` | Hapus Data Enrollment Kelas |
| `GET` | `/api/kegiatan-mahasiswa` | Daftar Semua Data Kegiatan Mahasiswa |
| `POST` | `/api/kegiatan-mahasiswa` | Tambah Data Kegiatan Mahasiswa Baru |
| `GET` | `/api/kegiatan-mahasiswa/{id}` | Detail Data Kegiatan Mahasiswa |
| `PUT` | `/api/kegiatan-mahasiswa/{id}` | Perbarui Data Kegiatan Mahasiswa |
| `DELETE` | `/api/kegiatan-mahasiswa/{id}` | Hapus Data Kegiatan Mahasiswa |
| `GET` | `/api/mahasiswa/tren` | Tren Mahasiswa |
| `GET` | `/api/mahasiswa` | Daftar Semua Data Mahasiswa |
| `POST` | `/api/mahasiswa` | Tambah Data Mahasiswa Baru |
| `GET` | `/api/mahasiswa/{id}` | Detail Data Mahasiswa |
| `PUT` | `/api/mahasiswa/{id}` | Perbarui Data Mahasiswa |
| `DELETE` | `/api/mahasiswa/{id}` | Hapus Data Mahasiswa |
| `GET` | `/api/status-mahasiswa` | Daftar Semua Data Status Mahasiswa |
| `POST` | `/api/status-mahasiswa` | Tambah Data Status Mahasiswa Baru |
| `GET` | `/api/status-mahasiswa/{id}` | Detail Data Status Mahasiswa |
| `PUT` | `/api/status-mahasiswa/{id}` | Perbarui Data Status Mahasiswa |
| `DELETE` | `/api/status-mahasiswa/{id}` | Hapus Data Status Mahasiswa |

### [Perkuliahan & Penilaian](#perkuliahan-penilaian) (23 endpoint)
| Method | Endpoint | Ringkasan / Deskripsi |
| :---: | :--- | :--- |
| `GET` | `/api/enrollment-mata-kuliah` | Daftar Semua Data Enrollment Mata Kuliah |
| `POST` | `/api/enrollment-mata-kuliah` | Tambah Data Enrollment Mata Kuliah Baru |
| `GET` | `/api/enrollment-mata-kuliah/{id}` | Detail Data Enrollment Mata Kuliah |
| `PUT` | `/api/enrollment-mata-kuliah/{id}` | Perbarui Data Enrollment Mata Kuliah |
| `DELETE` | `/api/enrollment-mata-kuliah/{id}` | Hapus Data Enrollment Mata Kuliah |
| `GET` | `/api/mata-kuliah-angkatan-kelas` | Daftar Semua Data Mata Kuliah Angkatan Kelas |
| `POST` | `/api/mata-kuliah-angkatan-kelas` | Tambah Data Mata Kuliah Angkatan Kelas Baru |
| `GET` | `/api/mata-kuliah-angkatan-kelas/{id}` | Detail Data Mata Kuliah Angkatan Kelas |
| `PUT` | `/api/mata-kuliah-angkatan-kelas/{id}` | Perbarui Data Mata Kuliah Angkatan Kelas |
| `DELETE` | `/api/mata-kuliah-angkatan-kelas/{id}` | Hapus Data Mata Kuliah Angkatan Kelas |
| `GET` | `/api/nilai-mahasiswa` | Daftar Semua Data Nilai Mahasiswa |
| `POST` | `/api/nilai-mahasiswa` | Tambah Data Nilai Mahasiswa Baru |
| `GET` | `/api/nilai-mahasiswa/template` | Download Template Nilai Mahasiswa |
| `POST` | `/api/nilai-mahasiswa/import` | Import Excel Nilai Mahasiswa |
| `POST` | `/api/nilai-mahasiswa/batch` | Batch Store Nilai Mahasiswa |
| `GET` | `/api/nilai-mahasiswa/{id}` | Detail Data Nilai Mahasiswa |
| `PUT` | `/api/nilai-mahasiswa/{id}` | Perbarui Data Nilai Mahasiswa |
| `DELETE` | `/api/nilai-mahasiswa/{id}` | Hapus Data Nilai Mahasiswa |
| `PATCH` | `/api/nilai-mahasiswa/{id}/link-nilai` | Update Link Nilai Nilai Mahasiswa |
| `PATCH` | `/api/nilai-mahasiswa/{id}/link-evidence` | Update Link Evidence Nilai Mahasiswa |
| `GET` | `/api/mahasiswa/{id}/khs` | Khs Nilai Mahasiswa |
| `GET` | `/api/mahasiswa/{id}/transkrip` | Transkrip Nilai Mahasiswa |
| `GET` | `/api/mahasiswa/{id}/ringkasan-akademik` | Ringkasan Akademik Nilai Mahasiswa |

### [Prestasi & Portofolio Mahasiswa](#prestasi-portofolio-mahasiswa) (15 endpoint)
| Method | Endpoint | Ringkasan / Deskripsi |
| :---: | :--- | :--- |
| `GET` | `/api/evidence-prestasi-mahasiswa` | Daftar Semua Data Evidence Prestasi Mahasiswa |
| `POST` | `/api/evidence-prestasi-mahasiswa` | Tambah Data Evidence Prestasi Mahasiswa Baru |
| `GET` | `/api/evidence-prestasi-mahasiswa/{id}` | Detail Data Evidence Prestasi Mahasiswa |
| `PUT` | `/api/evidence-prestasi-mahasiswa/{id}` | Perbarui Data Evidence Prestasi Mahasiswa |
| `DELETE` | `/api/evidence-prestasi-mahasiswa/{id}` | Hapus Data Evidence Prestasi Mahasiswa |
| `GET` | `/api/jenis-prestasi` | Daftar Semua Data Jenis Prestasi |
| `POST` | `/api/jenis-prestasi` | Tambah Data Jenis Prestasi Baru |
| `GET` | `/api/jenis-prestasi/{id}` | Detail Data Jenis Prestasi |
| `PUT` | `/api/jenis-prestasi/{id}` | Perbarui Data Jenis Prestasi |
| `DELETE` | `/api/jenis-prestasi/{id}` | Hapus Data Jenis Prestasi |
| `GET` | `/api/prestasi-mahasiswa` | Daftar Semua Data Prestasi Mahasiswa |
| `POST` | `/api/prestasi-mahasiswa` | Tambah Data Prestasi Mahasiswa Baru |
| `GET` | `/api/prestasi-mahasiswa/{id}` | Detail Data Prestasi Mahasiswa |
| `PUT` | `/api/prestasi-mahasiswa/{id}` | Perbarui Data Prestasi Mahasiswa |
| `DELETE` | `/api/prestasi-mahasiswa/{id}` | Hapus Data Prestasi Mahasiswa |

### [Manajemen Pengguna & Hak Akses](#manajemen-pengguna-hak-akses) (15 endpoint)
| Method | Endpoint | Ringkasan / Deskripsi |
| :---: | :--- | :--- |
| `GET` | `/api/permissions` | Daftar Semua Data Permission |
| `POST` | `/api/permissions` | Tambah Data Permission Baru |
| `GET` | `/api/permissions/{permission}` | Detail Data Permission |
| `PUT` | `/api/permissions/{permission}` | Perbarui Data Permission |
| `DELETE` | `/api/permissions/{permission}` | Hapus Data Permission |
| `GET` | `/api/roles` | Daftar Semua Data Role |
| `POST` | `/api/roles` | Tambah Data Role Baru |
| `GET` | `/api/roles/{role}` | Detail Data Role |
| `PUT` | `/api/roles/{role}` | Perbarui Data Role |
| `DELETE` | `/api/roles/{role}` | Hapus Data Role |
| `GET` | `/api/users` | Daftar Semua Data User |
| `POST` | `/api/users` | Tambah Data User Baru |
| `GET` | `/api/users/{user}` | Detail Data User |
| `PUT` | `/api/users/{user}` | Perbarui Data User |
| `DELETE` | `/api/users/{user}` | Hapus Data User |

---

## 3. Rincian Teknis Endpoint per Modul

## Institusi & Program Studi
> Modul: **Institusi & Program Studi** | Jumlah: 20 endpoint

### `GET` /api/anggota-upps
**Ringkasan:** Daftar Semua Data Anggota UPPS

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📤 2. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `array[object]` | **Ya (Required)** | Koleksi daftar data entitas | `[ { ... } ]` |
| | `data[].id` | `integer` | **Ya (Required)** | Id | `6` |
| | `data[].id_upps` | `integer` | **Ya (Required)** | Id Upps | `1` |
| | `data[].nama` | `string` | **Ya (Required)** | Nama | `"Mardiyono, S.Kom., M.Sc., Ph.D."` |
| | `data[].jabatan` | `string` | **Ya (Required)** | Jabatan | `"Kepala Laboratorium Sistem Cerdas dan Rekayasa Perangkat Lunak"` |
| | `data[].created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:26"` |
| | `data[].updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:26"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `POST` /api/anggota-upps
**Ringkasan:** Tambah Data Anggota UPPS Baru

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `id_upps` | `integer` | **Ya** | ID referensi UPPS | `1` |
| `nama` | `string` | **Ya** | Nama lengkap pengurus atau anggota | `Mardiyono, S.Kom., M.Sc., Ph.D.` |
| `jabatan` | `string` | **Ya** | Nama jabatan struktural dalam organisasi | `Kepala Laboratorium Sistem Cerdas dan Rekayasa Perangkat Lunak` |

##### Contoh Payload Request:
```json
{
  "id_upps": 1,
  "nama": "Mardiyono, S.Kom., M.Sc., Ph.D.",
  "jabatan": "Kepala Laboratorium Sistem Cerdas dan Rekayasa Perangkat Lunak"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📥 2. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `id_upps` | `integer` | **Ya (Required)** | ID referensi UPPS | `1` |
| `nama` | `string` | **Ya (Required)** | Nama lengkap pengurus atau anggota | `Mardiyono, S.Kom., M.Sc., Ph.D.` |
| `jabatan` | `string` | **Ya (Required)** | Nama jabatan struktural dalam organisasi | `Kepala Laboratorium Sistem Cerdas dan Rekayasa Perangkat Lunak` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **201 Created** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (201) | `201` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dibuat" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `6` |
| | `data.id_upps` | `integer` | **Ya (Required)** | ID referensi UPPS | `1` |
| | `data.nama` | `string` | **Ya (Required)** | Nama lengkap pengurus atau anggota | `"Mardiyono, S.Kom., M.Sc., Ph.D."` |
| | `data.jabatan` | `string` | **Ya (Required)** | Nama jabatan struktural dalam organisasi | `"Kepala Laboratorium Sistem Cerdas dan Rekayasa Perangkat Lunak"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:26"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:26"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/anggota-upps/{id}
**Ringkasan:** Detail Data Anggota UPPS

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `6` |
| | `data.id_upps` | `integer` | **Ya (Required)** | Id Upps | `1` |
| | `data.nama` | `string` | **Ya (Required)** | Nama | `"Mardiyono, S.Kom., M.Sc., Ph.D."` |
| | `data.jabatan` | `string` | **Ya (Required)** | Jabatan | `"Kepala Laboratorium Sistem Cerdas dan Rekayasa Perangkat Lunak"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:26"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:26"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `PUT` /api/anggota-upps/{id}
**Ringkasan:** Perbarui Data Anggota UPPS

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `id_upps` | `integer` | **Ya** | ID referensi UPPS | `1` |
| `nama` | `string` | **Ya** | Nama lengkap pengurus atau anggota | `Mardiyono, S.Kom., M.Sc., Ph.D.` |
| `jabatan` | `string` | **Ya** | Nama jabatan struktural dalam organisasi | `Kepala Laboratorium Sistem Cerdas dan Rekayasa Perangkat Lunak` |

##### Contoh Payload Request:
```json
{
  "id_upps": 1,
  "nama": "Mardiyono, S.Kom., M.Sc., Ph.D.",
  "jabatan": "Kepala Laboratorium Sistem Cerdas dan Rekayasa Perangkat Lunak"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📥 3. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `id_upps` | `integer` | **Ya (Required)** | ID referensi UPPS | `1` |
| `nama` | `string` | **Ya (Required)** | Nama lengkap pengurus atau anggota | `Mardiyono, S.Kom., M.Sc., Ph.D.` |
| `jabatan` | `string` | **Ya (Required)** | Nama jabatan struktural dalam organisasi | `Kepala Laboratorium Sistem Cerdas dan Rekayasa Perangkat Lunak` |

### 📤 4. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `6` |
| | `data.id_upps` | `integer` | **Ya (Required)** | ID referensi UPPS | `1` |
| | `data.nama` | `string` | **Ya (Required)** | Nama lengkap pengurus atau anggota | `"Mardiyono, S.Kom., M.Sc., Ph.D."` |
| | `data.jabatan` | `string` | **Ya (Required)** | Nama jabatan struktural dalam organisasi | `"Kepala Laboratorium Sistem Cerdas dan Rekayasa Perangkat Lunak"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:26"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:26"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `DELETE` /api/anggota-upps/{id}
**Ringkasan:** Hapus Data Anggota UPPS

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dihapus" |
| | `data` | `null / object` | *Tidak (Opsional)* | Payload hasil operasi hapus | `null` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/perguruan-tinggi
**Ringkasan:** Daftar Semua Data Perguruan Tinggi

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📤 2. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `array[object]` | **Ya (Required)** | Koleksi daftar data entitas | `[ { ... } ]` |
| | `data[].id` | `integer` | **Ya (Required)** | Id | `5` |
| | `data[].kode_pt` | `string` | **Ya (Required)** | Kode Pt | `"PT002"` |
| | `data[].nama_pt` | `string` | **Ya (Required)** | Nama Pt | `"Institut Teknologi Bandung"` |
| | `data[].alamat` | `string` | **Ya (Required)** | Alamat | `"Jl. Ganesha No. 10, Lb. Siliwangi, Bandung"` |
| | `data[].pimpinan` | `string` | **Ya (Required)** | Pimpinan | `"Dr. Ir. Supriyadi, M.T."` |
| | `data[].visi` | `string` | **Ya (Required)** | Visi | `"Menjadi politeknik unggulan"` |
| | `data[].misi` | `string` | **Ya (Required)** | Misi | `"Menyelenggarakan pendidikan vokasi berkualitas"` |
| | `data[].sk_pendirian` | `string` | *Tidak (Opsional / Nullable)* | Sk Pendirian | `null` |
| | `data[].tanggal_sk_pendirian` | `string` | *Tidak (Opsional / Nullable)* | Tanggal Sk Pendirian | `null` |
| | `data[].created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-08 13:18:59"` |
| | `data[].updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-08 13:18:59"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `POST` /api/perguruan-tinggi
**Ringkasan:** Tambah Data Perguruan Tinggi Baru

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `kode_pt` | `string` | **Ya** | Kode unik identitas Perguruan Tinggi | `PT002` |
| `nama_pt` | `string` | **Ya** | Nama resmi Perguruan Tinggi | `Institut Teknologi Bandung` |
| `alamat` | `string` | Tidak | Alamat lengkap domisili kampus | `Jl. Ganesha No. 10, Lb. Siliwangi, Bandung` |
| `pimpinan` | `string` | Tidak | Nama pimpinan / Direktur Perguruan Tinggi | `Dr. Ir. Supriyadi, M.T.` |
| `visi` | `string` | Tidak | Pernyataan visi Perguruan Tinggi | `Menjadi politeknik unggulan` |
| `misi` | `string` | Tidak | Pernyataan misi Perguruan Tinggi | `Menyelenggarakan pendidikan vokasi berkualitas` |
| `sk_pendirian` | `string` | Tidak | Sk Pendirian | `Contoh Sk Pendirian` |
| `tanggal_sk_pendirian` | `string (date)` | Tidak | Tanggal Sk Pendirian | `Contoh Tanggal Sk Pendirian` |

##### Contoh Payload Request:
```json
{
  "kode_pt": "PT002",
  "nama_pt": "Institut Teknologi Bandung",
  "alamat": "Jl. Ganesha No. 10, Lb. Siliwangi, Bandung",
  "pimpinan": "Dr. Ir. Supriyadi, M.T.",
  "visi": "Menjadi politeknik unggulan",
  "misi": "Menyelenggarakan pendidikan vokasi berkualitas",
  "sk_pendirian": "Contoh Sk Pendirian",
  "tanggal_sk_pendirian": "Contoh Tanggal Sk Pendirian"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📥 2. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `kode_pt` | `string` | **Ya (Required)** | Kode unik identitas Perguruan Tinggi | `PT002` |
| `nama_pt` | `string` | **Ya (Required)** | Nama resmi Perguruan Tinggi | `Institut Teknologi Bandung` |
| `alamat` | `string` | *Tidak (Opsional / Nullable)* | Alamat lengkap domisili kampus | `Jl. Ganesha No. 10, Lb. Siliwangi, Bandung` |
| `pimpinan` | `string` | *Tidak (Opsional / Nullable)* | Nama pimpinan / Direktur Perguruan Tinggi | `Dr. Ir. Supriyadi, M.T.` |
| `visi` | `string` | *Tidak (Opsional / Nullable)* | Pernyataan visi Perguruan Tinggi | `Menjadi politeknik unggulan` |
| `misi` | `string` | *Tidak (Opsional / Nullable)* | Pernyataan misi Perguruan Tinggi | `Menyelenggarakan pendidikan vokasi berkualitas` |
| `sk_pendirian` | `string` | *Tidak (Opsional / Nullable)* | Sk Pendirian | `Contoh Sk Pendirian` |
| `tanggal_sk_pendirian` | `string (date)` | *Tidak (Opsional / Nullable)* | Tanggal Sk Pendirian | `Contoh Tanggal Sk Pendirian` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **201 Created** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (201) | `201` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dibuat" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `5` |
| | `data.kode_pt` | `string` | **Ya (Required)** | Kode unik identitas Perguruan Tinggi | `"PT002"` |
| | `data.nama_pt` | `string` | **Ya (Required)** | Nama resmi Perguruan Tinggi | `"Institut Teknologi Bandung"` |
| | `data.alamat` | `string` | *Tidak (Opsional / Nullable)* | Alamat lengkap domisili kampus | `"Jl. Ganesha No. 10, Lb. Siliwangi, Bandung"` |
| | `data.pimpinan` | `string` | *Tidak (Opsional / Nullable)* | Nama pimpinan / Direktur Perguruan Tinggi | `"Dr. Ir. Supriyadi, M.T."` |
| | `data.visi` | `string` | *Tidak (Opsional / Nullable)* | Pernyataan visi Perguruan Tinggi | `"Menjadi politeknik unggulan"` |
| | `data.misi` | `string` | *Tidak (Opsional / Nullable)* | Pernyataan misi Perguruan Tinggi | `"Menyelenggarakan pendidikan vokasi berkualitas"` |
| | `data.sk_pendirian` | `string` | *Tidak (Opsional / Nullable)* | Sk Pendirian | `null` |
| | `data.tanggal_sk_pendirian` | `string` | *Tidak (Opsional / Nullable)* | Tanggal Sk Pendirian | `null` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-08 13:18:59"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-08 13:18:59"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/perguruan-tinggi/{id}
**Ringkasan:** Detail Data Perguruan Tinggi

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `5` |
| | `data.kode_pt` | `string` | **Ya (Required)** | Kode Pt | `"PT002"` |
| | `data.nama_pt` | `string` | **Ya (Required)** | Nama Pt | `"Institut Teknologi Bandung"` |
| | `data.alamat` | `string` | **Ya (Required)** | Alamat | `"Jl. Ganesha No. 10, Lb. Siliwangi, Bandung"` |
| | `data.pimpinan` | `string` | **Ya (Required)** | Pimpinan | `"Dr. Ir. Supriyadi, M.T."` |
| | `data.visi` | `string` | **Ya (Required)** | Visi | `"Menjadi politeknik unggulan"` |
| | `data.misi` | `string` | **Ya (Required)** | Misi | `"Menyelenggarakan pendidikan vokasi berkualitas"` |
| | `data.sk_pendirian` | `string` | *Tidak (Opsional / Nullable)* | Sk Pendirian | `null` |
| | `data.tanggal_sk_pendirian` | `string` | *Tidak (Opsional / Nullable)* | Tanggal Sk Pendirian | `null` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-08 13:18:59"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-08 13:18:59"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `PUT` /api/perguruan-tinggi/{id}
**Ringkasan:** Perbarui Data Perguruan Tinggi

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `kode_pt` | `string` | **Ya** | Kode unik identitas Perguruan Tinggi | `PT002` |
| `nama_pt` | `string` | **Ya** | Nama resmi Perguruan Tinggi | `Institut Teknologi Bandung` |
| `alamat` | `string` | Tidak | Alamat lengkap domisili kampus | `Jl. Ganesha No. 10, Lb. Siliwangi, Bandung` |
| `pimpinan` | `string` | Tidak | Nama pimpinan / Direktur Perguruan Tinggi | `Dr. Ir. Supriyadi, M.T.` |
| `visi` | `string` | Tidak | Pernyataan visi Perguruan Tinggi | `Menjadi politeknik unggulan` |
| `misi` | `string` | Tidak | Pernyataan misi Perguruan Tinggi | `Menyelenggarakan pendidikan vokasi berkualitas` |
| `sk_pendirian` | `string` | Tidak | Sk Pendirian | `Contoh Sk Pendirian` |
| `tanggal_sk_pendirian` | `string (date)` | Tidak | Tanggal Sk Pendirian | `Contoh Tanggal Sk Pendirian` |

##### Contoh Payload Request:
```json
{
  "kode_pt": "PT002",
  "nama_pt": "Institut Teknologi Bandung",
  "alamat": "Jl. Ganesha No. 10, Lb. Siliwangi, Bandung",
  "pimpinan": "Dr. Ir. Supriyadi, M.T.",
  "visi": "Menjadi politeknik unggulan",
  "misi": "Menyelenggarakan pendidikan vokasi berkualitas",
  "sk_pendirian": "Contoh Sk Pendirian",
  "tanggal_sk_pendirian": "Contoh Tanggal Sk Pendirian"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📥 3. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `kode_pt` | `string` | **Ya (Required)** | Kode unik identitas Perguruan Tinggi | `PT002` |
| `nama_pt` | `string` | **Ya (Required)** | Nama resmi Perguruan Tinggi | `Institut Teknologi Bandung` |
| `alamat` | `string` | *Tidak (Opsional / Nullable)* | Alamat lengkap domisili kampus | `Jl. Ganesha No. 10, Lb. Siliwangi, Bandung` |
| `pimpinan` | `string` | *Tidak (Opsional / Nullable)* | Nama pimpinan / Direktur Perguruan Tinggi | `Dr. Ir. Supriyadi, M.T.` |
| `visi` | `string` | *Tidak (Opsional / Nullable)* | Pernyataan visi Perguruan Tinggi | `Menjadi politeknik unggulan` |
| `misi` | `string` | *Tidak (Opsional / Nullable)* | Pernyataan misi Perguruan Tinggi | `Menyelenggarakan pendidikan vokasi berkualitas` |
| `sk_pendirian` | `string` | *Tidak (Opsional / Nullable)* | Sk Pendirian | `Contoh Sk Pendirian` |
| `tanggal_sk_pendirian` | `string (date)` | *Tidak (Opsional / Nullable)* | Tanggal Sk Pendirian | `Contoh Tanggal Sk Pendirian` |

### 📤 4. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `5` |
| | `data.kode_pt` | `string` | **Ya (Required)** | Kode unik identitas Perguruan Tinggi | `"PT002"` |
| | `data.nama_pt` | `string` | **Ya (Required)** | Nama resmi Perguruan Tinggi | `"Institut Teknologi Bandung"` |
| | `data.alamat` | `string` | *Tidak (Opsional / Nullable)* | Alamat lengkap domisili kampus | `"Jl. Ganesha No. 10, Lb. Siliwangi, Bandung"` |
| | `data.pimpinan` | `string` | *Tidak (Opsional / Nullable)* | Nama pimpinan / Direktur Perguruan Tinggi | `"Dr. Ir. Supriyadi, M.T."` |
| | `data.visi` | `string` | *Tidak (Opsional / Nullable)* | Pernyataan visi Perguruan Tinggi | `"Menjadi politeknik unggulan"` |
| | `data.misi` | `string` | *Tidak (Opsional / Nullable)* | Pernyataan misi Perguruan Tinggi | `"Menyelenggarakan pendidikan vokasi berkualitas"` |
| | `data.sk_pendirian` | `string` | *Tidak (Opsional / Nullable)* | Sk Pendirian | `null` |
| | `data.tanggal_sk_pendirian` | `string` | *Tidak (Opsional / Nullable)* | Tanggal Sk Pendirian | `null` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-08 13:18:59"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-08 13:18:59"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `DELETE` /api/perguruan-tinggi/{id}
**Ringkasan:** Hapus Data Perguruan Tinggi

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dihapus" |
| | `data` | `null / object` | *Tidak (Opsional)* | Payload hasil operasi hapus | `null` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/prodi
**Ringkasan:** Daftar Semua Data Program Studi

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📤 2. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `array[object]` | **Ya (Required)** | Koleksi daftar data entitas | `[ { ... } ]` |
| | `data[].id` | `integer` | **Ya (Required)** | Id | `1` |
| | `data[].kode_prodi` | `string` | **Ya (Required)** | Kode Prodi | `"PR01"` |
| | `data[].nama_prodi` | `string` | **Ya (Required)** | Nama Prodi | `"Teknologi Rekayasa Komputer"` |
| | `data[].jenjang` | `string` | **Ya (Required)** | Jenjang | `"D4"` |
| | `data[].sk_pendirian` | `string` | *Tidak (Opsional / Nullable)* | Sk Pendirian | `null` |
| | `data[].tanggal_sk_pendirian` | `string` | *Tidak (Opsional / Nullable)* | Tanggal Sk Pendirian | `null` |
| | `data[].status_akreditasi` | `string` | **Ya (Required)** | Status Akreditasi | `"Terakreditasi Unggul"` |
| | `data[].masa_berlaku_akreditasi` | `string` | *Tidak (Opsional / Nullable)* | Masa Berlaku Akreditasi | `null` |
| | `data[].id_upps` | `string` | *Tidak (Opsional / Nullable)* | Id Upps | `null` |
| | `data[].akreditasi` | `string` | **Ya (Required)** | Akreditasi | `"Unggul"` |
| | `data[].created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:25"` |
| | `data[].updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:25"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `POST` /api/prodi
**Ringkasan:** Tambah Data Program Studi Baru

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `kode_prodi` | `string` | **Ya** | Kode unik Program Studi | `PR01` |
| `nama_prodi` | `string` | **Ya** | Nama Program Studi | `Teknologi Rekayasa Komputer` |
| `akreditasi` | `string` | Tidak | Peringkat akreditasi BAN-PT/LAM INFOKOM | `Unggul` |
| `jenjang` | `string` | **Ya** | Jenjang | `D4` |
| `sk_pendirian` | `string` | Tidak | Sk Pendirian | `Contoh Sk Pendirian` |
| `tanggal_sk_pendirian` | `string (date)` | Tidak | Tanggal Sk Pendirian | `Contoh Tanggal Sk Pendirian` |
| `status_akreditasi` | `string` | Tidak | Status Akreditasi | `Terakreditasi Unggul` |
| `masa_berlaku_akreditasi` | `string (date)` | Tidak | Masa Berlaku Akreditasi | `Contoh Masa Berlaku Akreditasi` |
| `id_upps` | `integer` | Tidak | ID referensi UPPS | `1` |

##### Contoh Payload Request:
```json
{
  "kode_prodi": "PR01",
  "nama_prodi": "Teknologi Rekayasa Komputer",
  "akreditasi": "Unggul",
  "jenjang": "D4",
  "sk_pendirian": "Contoh Sk Pendirian",
  "tanggal_sk_pendirian": "Contoh Tanggal Sk Pendirian",
  "status_akreditasi": "Terakreditasi Unggul",
  "masa_berlaku_akreditasi": "Contoh Masa Berlaku Akreditasi",
  "id_upps": 1
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📥 2. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `kode_prodi` | `string` | **Ya (Required)** | Kode unik Program Studi | `PR01` |
| `nama_prodi` | `string` | **Ya (Required)** | Nama Program Studi | `Teknologi Rekayasa Komputer` |
| `akreditasi` | `string` | *Tidak (Opsional / Nullable)* | Peringkat akreditasi BAN-PT/LAM INFOKOM | `Unggul` |
| `jenjang` | `string` | **Ya (Required)** | Jenjang | `D4` |
| `sk_pendirian` | `string` | *Tidak (Opsional / Nullable)* | Sk Pendirian | `Contoh Sk Pendirian` |
| `tanggal_sk_pendirian` | `string (date)` | *Tidak (Opsional / Nullable)* | Tanggal Sk Pendirian | `Contoh Tanggal Sk Pendirian` |
| `status_akreditasi` | `string` | *Tidak (Opsional / Nullable)* | Status Akreditasi | `Terakreditasi Unggul` |
| `masa_berlaku_akreditasi` | `string (date)` | *Tidak (Opsional / Nullable)* | Masa Berlaku Akreditasi | `Contoh Masa Berlaku Akreditasi` |
| `id_upps` | `integer` | *Tidak (Opsional / Nullable)* | ID referensi UPPS | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **201 Created** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (201) | `201` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dibuat" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `1` |
| | `data.kode_prodi` | `string` | **Ya (Required)** | Kode unik Program Studi | `"PR01"` |
| | `data.nama_prodi` | `string` | **Ya (Required)** | Nama Program Studi | `"Teknologi Rekayasa Komputer"` |
| | `data.jenjang` | `string` | **Ya (Required)** | Jenjang | `"D4"` |
| | `data.sk_pendirian` | `string` | *Tidak (Opsional / Nullable)* | Sk Pendirian | `null` |
| | `data.tanggal_sk_pendirian` | `string` | *Tidak (Opsional / Nullable)* | Tanggal Sk Pendirian | `null` |
| | `data.status_akreditasi` | `string` | *Tidak (Opsional / Nullable)* | Status Akreditasi | `"Terakreditasi Unggul"` |
| | `data.masa_berlaku_akreditasi` | `string` | *Tidak (Opsional / Nullable)* | Masa Berlaku Akreditasi | `null` |
| | `data.id_upps` | `string` | *Tidak (Opsional / Nullable)* | ID referensi UPPS | `null` |
| | `data.akreditasi` | `string` | *Tidak (Opsional / Nullable)* | Peringkat akreditasi BAN-PT/LAM INFOKOM | `"Unggul"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:25"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:25"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/prodi/{id}
**Ringkasan:** Detail Data Program Studi

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `1` |
| | `data.kode_prodi` | `string` | **Ya (Required)** | Kode Prodi | `"PR01"` |
| | `data.nama_prodi` | `string` | **Ya (Required)** | Nama Prodi | `"Teknologi Rekayasa Komputer"` |
| | `data.jenjang` | `string` | **Ya (Required)** | Jenjang | `"D4"` |
| | `data.sk_pendirian` | `string` | *Tidak (Opsional / Nullable)* | Sk Pendirian | `null` |
| | `data.tanggal_sk_pendirian` | `string` | *Tidak (Opsional / Nullable)* | Tanggal Sk Pendirian | `null` |
| | `data.status_akreditasi` | `string` | **Ya (Required)** | Status Akreditasi | `"Terakreditasi Unggul"` |
| | `data.masa_berlaku_akreditasi` | `string` | *Tidak (Opsional / Nullable)* | Masa Berlaku Akreditasi | `null` |
| | `data.id_upps` | `string` | *Tidak (Opsional / Nullable)* | Id Upps | `null` |
| | `data.akreditasi` | `string` | **Ya (Required)** | Akreditasi | `"Unggul"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:25"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:25"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `PUT` /api/prodi/{id}
**Ringkasan:** Perbarui Data Program Studi

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `kode_prodi` | `string` | **Ya** | Kode unik Program Studi | `PR01` |
| `nama_prodi` | `string` | **Ya** | Nama Program Studi | `Teknologi Rekayasa Komputer` |
| `akreditasi` | `string` | Tidak | Peringkat akreditasi BAN-PT/LAM INFOKOM | `Unggul` |
| `jenjang` | `string` | **Ya** | Jenjang | `D4` |
| `sk_pendirian` | `string` | Tidak | Sk Pendirian | `Contoh Sk Pendirian` |
| `tanggal_sk_pendirian` | `string (date)` | Tidak | Tanggal Sk Pendirian | `Contoh Tanggal Sk Pendirian` |
| `status_akreditasi` | `string` | Tidak | Status Akreditasi | `Terakreditasi Unggul` |
| `masa_berlaku_akreditasi` | `string (date)` | Tidak | Masa Berlaku Akreditasi | `Contoh Masa Berlaku Akreditasi` |
| `id_upps` | `integer` | Tidak | ID referensi UPPS | `1` |

##### Contoh Payload Request:
```json
{
  "kode_prodi": "PR01",
  "nama_prodi": "Teknologi Rekayasa Komputer",
  "akreditasi": "Unggul",
  "jenjang": "D4",
  "sk_pendirian": "Contoh Sk Pendirian",
  "tanggal_sk_pendirian": "Contoh Tanggal Sk Pendirian",
  "status_akreditasi": "Terakreditasi Unggul",
  "masa_berlaku_akreditasi": "Contoh Masa Berlaku Akreditasi",
  "id_upps": 1
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📥 3. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `kode_prodi` | `string` | **Ya (Required)** | Kode unik Program Studi | `PR01` |
| `nama_prodi` | `string` | **Ya (Required)** | Nama Program Studi | `Teknologi Rekayasa Komputer` |
| `akreditasi` | `string` | *Tidak (Opsional / Nullable)* | Peringkat akreditasi BAN-PT/LAM INFOKOM | `Unggul` |
| `jenjang` | `string` | **Ya (Required)** | Jenjang | `D4` |
| `sk_pendirian` | `string` | *Tidak (Opsional / Nullable)* | Sk Pendirian | `Contoh Sk Pendirian` |
| `tanggal_sk_pendirian` | `string (date)` | *Tidak (Opsional / Nullable)* | Tanggal Sk Pendirian | `Contoh Tanggal Sk Pendirian` |
| `status_akreditasi` | `string` | *Tidak (Opsional / Nullable)* | Status Akreditasi | `Terakreditasi Unggul` |
| `masa_berlaku_akreditasi` | `string (date)` | *Tidak (Opsional / Nullable)* | Masa Berlaku Akreditasi | `Contoh Masa Berlaku Akreditasi` |
| `id_upps` | `integer` | *Tidak (Opsional / Nullable)* | ID referensi UPPS | `1` |

### 📤 4. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `1` |
| | `data.kode_prodi` | `string` | **Ya (Required)** | Kode unik Program Studi | `"PR01"` |
| | `data.nama_prodi` | `string` | **Ya (Required)** | Nama Program Studi | `"Teknologi Rekayasa Komputer"` |
| | `data.jenjang` | `string` | **Ya (Required)** | Jenjang | `"D4"` |
| | `data.sk_pendirian` | `string` | *Tidak (Opsional / Nullable)* | Sk Pendirian | `null` |
| | `data.tanggal_sk_pendirian` | `string` | *Tidak (Opsional / Nullable)* | Tanggal Sk Pendirian | `null` |
| | `data.status_akreditasi` | `string` | *Tidak (Opsional / Nullable)* | Status Akreditasi | `"Terakreditasi Unggul"` |
| | `data.masa_berlaku_akreditasi` | `string` | *Tidak (Opsional / Nullable)* | Masa Berlaku Akreditasi | `null` |
| | `data.id_upps` | `string` | *Tidak (Opsional / Nullable)* | ID referensi UPPS | `null` |
| | `data.akreditasi` | `string` | *Tidak (Opsional / Nullable)* | Peringkat akreditasi BAN-PT/LAM INFOKOM | `"Unggul"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:25"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:25"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `DELETE` /api/prodi/{id}
**Ringkasan:** Hapus Data Program Studi

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dihapus" |
| | `data` | `null / object` | *Tidak (Opsional)* | Payload hasil operasi hapus | `null` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/upps
**Ringkasan:** Daftar Semua Data UPPS

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📤 2. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `array[object]` | **Ya (Required)** | Koleksi daftar data entitas | `[ { ... } ]` |
| | `data[].id` | `integer` | **Ya (Required)** | Id | `1` |
| | `data[].id_pt` | `integer` | **Ya (Required)** | Id Pt | `1` |
| | `data[].kode_upps` | `string` | **Ya (Required)** | Kode Upps | `"UPPS01"` |
| | `data[].nama_upps` | `string` | **Ya (Required)** | Nama Upps | `"UPPS TRK"` |
| | `data[].pimpinan_upps` | `string` | **Ya (Required)** | Pimpinan Upps | `"Dr. Amin Suharjono, S.T., M.T."` |
| | `data[].prodi_id` | `integer` | **Ya (Required)** | Prodi Id | `1` |
| | `data[].jenis` | `string` | **Ya (Required)** | Jenis | `"Jurusan"` |
| | `data[].created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:25"` |
| | `data[].updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:25"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `POST` /api/upps
**Ringkasan:** Tambah Data UPPS Baru

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `id_pt` | `integer` | **Ya** | ID referensi Perguruan Tinggi | `1` |
| `kode_upps` | `string` | **Ya** | Kode Unit Pengelola Program Studi (Fakultas/Jurusan) | `UPPS01` |
| `nama_upps` | `string` | **Ya** | Nama resmi Unit Pengelola Program Studi | `UPPS TRK` |
| `pimpinan_upps` | `string` | Tidak | Nama pimpinan UPPS (Ketua Jurusan / Dekan) | `Dr. Amin Suharjono, S.T., M.T.` |
| `prodi_id` | `integer` | **Ya** | ID referensi Program Studi | `1` |
| `jenis` | `string` | **Ya** | Jenis entitas unit pengelola (misal: Jurusan, Fakultas) | `Jurusan` |

##### Contoh Payload Request:
```json
{
  "id_pt": 1,
  "kode_upps": "UPPS01",
  "nama_upps": "UPPS TRK",
  "pimpinan_upps": "Dr. Amin Suharjono, S.T., M.T.",
  "prodi_id": 1,
  "jenis": "Jurusan"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📥 2. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `id_pt` | `integer` | **Ya (Required)** | ID referensi Perguruan Tinggi | `1` |
| `kode_upps` | `string` | **Ya (Required)** | Kode Unit Pengelola Program Studi (Fakultas/Jurusan) | `UPPS01` |
| `nama_upps` | `string` | **Ya (Required)** | Nama resmi Unit Pengelola Program Studi | `UPPS TRK` |
| `pimpinan_upps` | `string` | *Tidak (Opsional / Nullable)* | Nama pimpinan UPPS (Ketua Jurusan / Dekan) | `Dr. Amin Suharjono, S.T., M.T.` |
| `prodi_id` | `integer` | **Ya (Required)** | ID referensi Program Studi | `1` |
| `jenis` | `string` | **Ya (Required)** | Jenis entitas unit pengelola (misal: Jurusan, Fakultas) | `Jurusan` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **201 Created** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (201) | `201` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dibuat" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `1` |
| | `data.id_pt` | `integer` | **Ya (Required)** | ID referensi Perguruan Tinggi | `1` |
| | `data.kode_upps` | `string` | **Ya (Required)** | Kode Unit Pengelola Program Studi (Fakultas/Jurusan) | `"UPPS01"` |
| | `data.nama_upps` | `string` | **Ya (Required)** | Nama resmi Unit Pengelola Program Studi | `"UPPS TRK"` |
| | `data.pimpinan_upps` | `string` | *Tidak (Opsional / Nullable)* | Nama pimpinan UPPS (Ketua Jurusan / Dekan) | `"Dr. Amin Suharjono, S.T., M.T."` |
| | `data.prodi_id` | `integer` | **Ya (Required)** | ID referensi Program Studi | `1` |
| | `data.jenis` | `string` | **Ya (Required)** | Jenis entitas unit pengelola (misal: Jurusan, Fakultas) | `"Jurusan"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:25"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:25"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/upps/{id}
**Ringkasan:** Detail Data UPPS

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `1` |
| | `data.id_pt` | `integer` | **Ya (Required)** | Id Pt | `1` |
| | `data.kode_upps` | `string` | **Ya (Required)** | Kode Upps | `"UPPS01"` |
| | `data.nama_upps` | `string` | **Ya (Required)** | Nama Upps | `"UPPS TRK"` |
| | `data.pimpinan_upps` | `string` | **Ya (Required)** | Pimpinan Upps | `"Dr. Amin Suharjono, S.T., M.T."` |
| | `data.prodi_id` | `integer` | **Ya (Required)** | Prodi Id | `1` |
| | `data.jenis` | `string` | **Ya (Required)** | Jenis | `"Jurusan"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:25"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:25"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `PUT` /api/upps/{id}
**Ringkasan:** Perbarui Data UPPS

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `id_pt` | `integer` | **Ya** | ID referensi Perguruan Tinggi | `1` |
| `kode_upps` | `string` | **Ya** | Kode Unit Pengelola Program Studi (Fakultas/Jurusan) | `UPPS01` |
| `nama_upps` | `string` | **Ya** | Nama resmi Unit Pengelola Program Studi | `UPPS TRK` |
| `pimpinan_upps` | `string` | Tidak | Nama pimpinan UPPS (Ketua Jurusan / Dekan) | `Dr. Amin Suharjono, S.T., M.T.` |
| `prodi_id` | `integer` | **Ya** | ID referensi Program Studi | `1` |
| `jenis` | `string` | **Ya** | Jenis entitas unit pengelola (misal: Jurusan, Fakultas) | `Jurusan` |

##### Contoh Payload Request:
```json
{
  "id_pt": 1,
  "kode_upps": "UPPS01",
  "nama_upps": "UPPS TRK",
  "pimpinan_upps": "Dr. Amin Suharjono, S.T., M.T.",
  "prodi_id": 1,
  "jenis": "Jurusan"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📥 3. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `id_pt` | `integer` | **Ya (Required)** | ID referensi Perguruan Tinggi | `1` |
| `kode_upps` | `string` | **Ya (Required)** | Kode Unit Pengelola Program Studi (Fakultas/Jurusan) | `UPPS01` |
| `nama_upps` | `string` | **Ya (Required)** | Nama resmi Unit Pengelola Program Studi | `UPPS TRK` |
| `pimpinan_upps` | `string` | *Tidak (Opsional / Nullable)* | Nama pimpinan UPPS (Ketua Jurusan / Dekan) | `Dr. Amin Suharjono, S.T., M.T.` |
| `prodi_id` | `integer` | **Ya (Required)** | ID referensi Program Studi | `1` |
| `jenis` | `string` | **Ya (Required)** | Jenis entitas unit pengelola (misal: Jurusan, Fakultas) | `Jurusan` |

### 📤 4. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `1` |
| | `data.id_pt` | `integer` | **Ya (Required)** | ID referensi Perguruan Tinggi | `1` |
| | `data.kode_upps` | `string` | **Ya (Required)** | Kode Unit Pengelola Program Studi (Fakultas/Jurusan) | `"UPPS01"` |
| | `data.nama_upps` | `string` | **Ya (Required)** | Nama resmi Unit Pengelola Program Studi | `"UPPS TRK"` |
| | `data.pimpinan_upps` | `string` | *Tidak (Opsional / Nullable)* | Nama pimpinan UPPS (Ketua Jurusan / Dekan) | `"Dr. Amin Suharjono, S.T., M.T."` |
| | `data.prodi_id` | `integer` | **Ya (Required)** | ID referensi Program Studi | `1` |
| | `data.jenis` | `string` | **Ya (Required)** | Jenis entitas unit pengelola (misal: Jurusan, Fakultas) | `"Jurusan"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:25"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:25"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `DELETE` /api/upps/{id}
**Ringkasan:** Hapus Data UPPS

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dihapus" |
| | `data` | `null / object` | *Tidak (Opsional)* | Payload hasil operasi hapus | `null` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

## Struktur Akademik & Kelas
> Modul: **Struktur Akademik & Kelas** | Jumlah: 25 endpoint

### `GET` /api/angkatan
**Ringkasan:** Daftar Semua Data Angkatan

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📤 2. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `array[object]` | **Ya (Required)** | Koleksi daftar data entitas | `[ { ... } ]` |
| | `data[].id` | `integer` | **Ya (Required)** | Id | `9` |
| | `data[].angkatan` | `integer` | **Ya (Required)** | Angkatan | `2026` |
| | `data[].created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:42"` |
| | `data[].updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:42"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `POST` /api/angkatan
**Ringkasan:** Tambah Data Angkatan Baru

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `angkatan` | `integer` | **Ya** | Tahun angkatan mahasiswa | `2026` |
| `jumlah_pendaftar` | `integer` | Tidak | Jumlah Pendaftar | `1` |

##### Contoh Payload Request:
```json
{
  "angkatan": 2026,
  "jumlah_pendaftar": 1
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📥 2. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `angkatan` | `integer` | **Ya (Required)** | Tahun angkatan mahasiswa | `2026` |
| `jumlah_pendaftar` | `integer` | *Tidak (Opsional / Nullable)* | Jumlah Pendaftar | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **201 Created** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (201) | `201` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dibuat" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `9` |
| | `data.angkatan` | `integer` | **Ya (Required)** | Tahun angkatan mahasiswa | `2026` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:42"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:42"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/angkatan/{id}
**Ringkasan:** Detail Data Angkatan

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `9` |
| | `data.angkatan` | `integer` | **Ya (Required)** | Angkatan | `2026` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:42"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:42"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `PUT` /api/angkatan/{id}
**Ringkasan:** Perbarui Data Angkatan

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `angkatan` | `integer` | **Ya** | Tahun angkatan mahasiswa | `2026` |
| `jumlah_pendaftar` | `integer` | Tidak | Jumlah Pendaftar | `1` |

##### Contoh Payload Request:
```json
{
  "angkatan": 2026,
  "jumlah_pendaftar": 1
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📥 3. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `angkatan` | `integer` | **Ya (Required)** | Tahun angkatan mahasiswa | `2026` |
| `jumlah_pendaftar` | `integer` | *Tidak (Opsional / Nullable)* | Jumlah Pendaftar | `1` |

### 📤 4. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `9` |
| | `data.angkatan` | `integer` | **Ya (Required)** | Tahun angkatan mahasiswa | `2026` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:42"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:42"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `DELETE` /api/angkatan/{id}
**Ringkasan:** Hapus Data Angkatan

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dihapus" |
| | `data` | `null / object` | *Tidak (Opsional)* | Payload hasil operasi hapus | `null` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/angkatan-kelas
**Ringkasan:** Daftar Semua Data Angkatan Kelas

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📤 2. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `array[object]` | **Ya (Required)** | Koleksi daftar data entitas | `[ { ... } ]` |
| | `data[].id` | `integer` | **Ya (Required)** | Id | `120` |
| | `data[].kelas_id` | `integer` | **Ya (Required)** | Kelas Id | `12` |
| | `data[].angkatan_id` | `integer` | **Ya (Required)** | Angkatan Id | `6` |
| | `data[].prodi_id` | `integer` | **Ya (Required)** | Prodi Id | `1` |
| | `data[].tahun_akademik_id` | `integer` | **Ya (Required)** | Tahun Akademik Id | `10` |
| | `data[].created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:55"` |
| | `data[].updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:55"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `POST` /api/angkatan-kelas
**Ringkasan:** Tambah Data Angkatan Kelas Baru

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `kelas_id` | `integer` | **Ya** | ID referensi Kelas | `12` |
| `angkatan_id` | `integer` | **Ya** | ID referensi Angkatan | `6` |
| `prodi_id` | `integer` | **Ya** | ID referensi Program Studi | `1` |
| `tahun_akademik_id` | `integer` | **Ya** | ID referensi Tahun Akademik | `10` |

##### Contoh Payload Request:
```json
{
  "kelas_id": 12,
  "angkatan_id": 6,
  "prodi_id": 1,
  "tahun_akademik_id": 10
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📥 2. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `kelas_id` | `integer` | **Ya (Required)** | ID referensi Kelas | `12` |
| `angkatan_id` | `integer` | **Ya (Required)** | ID referensi Angkatan | `6` |
| `prodi_id` | `integer` | **Ya (Required)** | ID referensi Program Studi | `1` |
| `tahun_akademik_id` | `integer` | **Ya (Required)** | ID referensi Tahun Akademik | `10` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **201 Created** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (201) | `201` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dibuat" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `120` |
| | `data.kelas_id` | `integer` | **Ya (Required)** | ID referensi Kelas | `12` |
| | `data.angkatan_id` | `integer` | **Ya (Required)** | ID referensi Angkatan | `6` |
| | `data.prodi_id` | `integer` | **Ya (Required)** | ID referensi Program Studi | `1` |
| | `data.tahun_akademik_id` | `integer` | **Ya (Required)** | ID referensi Tahun Akademik | `10` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:55"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:55"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/angkatan-kelas/{id}
**Ringkasan:** Detail Data Angkatan Kelas

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `120` |
| | `data.kelas_id` | `integer` | **Ya (Required)** | Kelas Id | `12` |
| | `data.angkatan_id` | `integer` | **Ya (Required)** | Angkatan Id | `6` |
| | `data.prodi_id` | `integer` | **Ya (Required)** | Prodi Id | `1` |
| | `data.tahun_akademik_id` | `integer` | **Ya (Required)** | Tahun Akademik Id | `10` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:55"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:55"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `PUT` /api/angkatan-kelas/{id}
**Ringkasan:** Perbarui Data Angkatan Kelas

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `kelas_id` | `integer` | **Ya** | ID referensi Kelas | `12` |
| `angkatan_id` | `integer` | **Ya** | ID referensi Angkatan | `6` |
| `prodi_id` | `integer` | **Ya** | ID referensi Program Studi | `1` |
| `tahun_akademik_id` | `integer` | **Ya** | ID referensi Tahun Akademik | `10` |

##### Contoh Payload Request:
```json
{
  "kelas_id": 12,
  "angkatan_id": 6,
  "prodi_id": 1,
  "tahun_akademik_id": 10
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📥 3. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `kelas_id` | `integer` | **Ya (Required)** | ID referensi Kelas | `12` |
| `angkatan_id` | `integer` | **Ya (Required)** | ID referensi Angkatan | `6` |
| `prodi_id` | `integer` | **Ya (Required)** | ID referensi Program Studi | `1` |
| `tahun_akademik_id` | `integer` | **Ya (Required)** | ID referensi Tahun Akademik | `10` |

### 📤 4. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `120` |
| | `data.kelas_id` | `integer` | **Ya (Required)** | ID referensi Kelas | `12` |
| | `data.angkatan_id` | `integer` | **Ya (Required)** | ID referensi Angkatan | `6` |
| | `data.prodi_id` | `integer` | **Ya (Required)** | ID referensi Program Studi | `1` |
| | `data.tahun_akademik_id` | `integer` | **Ya (Required)** | ID referensi Tahun Akademik | `10` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:55"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:55"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `DELETE` /api/angkatan-kelas/{id}
**Ringkasan:** Hapus Data Angkatan Kelas

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dihapus" |
| | `data` | `null / object` | *Tidak (Opsional)* | Payload hasil operasi hapus | `null` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/angkatan-kelas/{id}/mahasiswa
**Ringkasan:** Mahasiswa Angkatan Kelas

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `120` |
| | `data.kelas_id` | `integer` | **Ya (Required)** | Kelas Id | `12` |
| | `data.angkatan_id` | `integer` | **Ya (Required)** | Angkatan Id | `6` |
| | `data.prodi_id` | `integer` | **Ya (Required)** | Prodi Id | `1` |
| | `data.tahun_akademik_id` | `integer` | **Ya (Required)** | Tahun Akademik Id | `10` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:55"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:55"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/angkatan-kelas/{id}/mata-kuliah
**Ringkasan:** Mata Kuliah Angkatan Kelas

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `120` |
| | `data.kelas_id` | `integer` | **Ya (Required)** | Kelas Id | `12` |
| | `data.angkatan_id` | `integer` | **Ya (Required)** | Angkatan Id | `6` |
| | `data.prodi_id` | `integer` | **Ya (Required)** | Prodi Id | `1` |
| | `data.tahun_akademik_id` | `integer` | **Ya (Required)** | Tahun Akademik Id | `10` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:55"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:55"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/kelas
**Ringkasan:** Daftar Semua Data Kelas

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📤 2. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `array[object]` | **Ya (Required)** | Koleksi daftar data entitas | `[ { ... } ]` |
| | `data[].id` | `integer` | **Ya (Required)** | Id | `12` |
| | `data[].kelas` | `string` | **Ya (Required)** | Kelas | `"TI-4C"` |
| | `data[].created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:43"` |
| | `data[].updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:43"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `POST` /api/kelas
**Ringkasan:** Tambah Data Kelas Baru

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `kelas` | `string` | **Ya** | Nama kode rombongan belajar / kelas (misal: TRK-1A) | `TI-4C` |

##### Contoh Payload Request:
```json
{
  "kelas": "TI-4C"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📥 2. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `kelas` | `string` | **Ya (Required)** | Nama kode rombongan belajar / kelas (misal: TRK-1A) | `TI-4C` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **201 Created** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (201) | `201` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dibuat" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `12` |
| | `data.kelas` | `string` | **Ya (Required)** | Nama kode rombongan belajar / kelas (misal: TRK-1A) | `"TI-4C"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:43"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:43"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/kelas/{id}
**Ringkasan:** Detail Data Kelas

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `12` |
| | `data.kelas` | `string` | **Ya (Required)** | Kelas | `"TI-4C"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:43"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:43"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `PUT` /api/kelas/{id}
**Ringkasan:** Perbarui Data Kelas

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `kelas` | `string` | **Ya** | Nama kode rombongan belajar / kelas (misal: TRK-1A) | `TI-4C` |

##### Contoh Payload Request:
```json
{
  "kelas": "TI-4C"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📥 3. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `kelas` | `string` | **Ya (Required)** | Nama kode rombongan belajar / kelas (misal: TRK-1A) | `TI-4C` |

### 📤 4. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `12` |
| | `data.kelas` | `string` | **Ya (Required)** | Nama kode rombongan belajar / kelas (misal: TRK-1A) | `"TI-4C"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:43"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:43"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `DELETE` /api/kelas/{id}
**Ringkasan:** Hapus Data Kelas

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dihapus" |
| | `data` | `null / object` | *Tidak (Opsional)* | Payload hasil operasi hapus | `null` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/kelas/{id}/mahasiswa
**Ringkasan:** Mahasiswa Kelas

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `12` |
| | `data.kelas` | `string` | **Ya (Required)** | Kelas | `"TI-4C"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:43"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:43"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/kelas/{id}/mata-kuliah
**Ringkasan:** Mata Kuliah Kelas

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `12` |
| | `data.kelas` | `string` | **Ya (Required)** | Kelas | `"TI-4C"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:43"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:43"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/tahun-akademik
**Ringkasan:** Daftar Semua Data Tahun Akademik

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📤 2. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `array[object]` | **Ya (Required)** | Koleksi daftar data entitas | `[ { ... } ]` |
| | `data[].id` | `integer` | **Ya (Required)** | Id | `10` |
| | `data[].tahun` | `string` | **Ya (Required)** | Tahun | `"2026/2027"` |
| | `data[].semester` | `string` | **Ya (Required)** | Semester | `"Genap"` |
| | `data[].is_active` | `integer` | **Ya (Required)** | Is Active | `0` |
| | `data[].created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:44"` |
| | `data[].updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:44"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `POST` /api/tahun-akademik
**Ringkasan:** Tambah Data Tahun Akademik Baru

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `tahun` | `integer` | **Ya** | Tahun kalender akademik | `2026` |
| `semester` | `string` | **Ya** | Semester | `Genap` |
| `is_active` | `string` | **Ya** | Is Active | `0` |

##### Contoh Payload Request:
```json
{
  "tahun": 2026,
  "semester": "Genap",
  "is_active": "0"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📥 2. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `tahun` | `integer` | **Ya (Required)** | Tahun kalender akademik | `2026` |
| `semester` | `string` | **Ya (Required)** | Semester | `Genap` |
| `is_active` | `string` | **Ya (Required)** | Is Active | `0` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **201 Created** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (201) | `201` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dibuat" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `10` |
| | `data.tahun` | `string` | **Ya (Required)** | Tahun kalender akademik | `"2026/2027"` |
| | `data.semester` | `string` | **Ya (Required)** | Semester | `"Genap"` |
| | `data.is_active` | `integer` | **Ya (Required)** | Is Active | `0` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:44"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:44"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/tahun-akademik/{id}
**Ringkasan:** Detail Data Tahun Akademik

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `10` |
| | `data.tahun` | `string` | **Ya (Required)** | Tahun | `"2026/2027"` |
| | `data.semester` | `string` | **Ya (Required)** | Semester | `"Genap"` |
| | `data.is_active` | `integer` | **Ya (Required)** | Is Active | `0` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:44"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:44"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `PUT` /api/tahun-akademik/{id}
**Ringkasan:** Perbarui Data Tahun Akademik

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `tahun` | `integer` | **Ya** | Tahun kalender akademik | `2026` |
| `semester` | `string` | **Ya** | Semester | `Genap` |
| `is_active` | `string` | **Ya** | Is Active | `0` |

##### Contoh Payload Request:
```json
{
  "tahun": 2026,
  "semester": "Genap",
  "is_active": "0"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📥 3. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `tahun` | `integer` | **Ya (Required)** | Tahun kalender akademik | `2026` |
| `semester` | `string` | **Ya (Required)** | Semester | `Genap` |
| `is_active` | `string` | **Ya (Required)** | Is Active | `0` |

### 📤 4. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `10` |
| | `data.tahun` | `string` | **Ya (Required)** | Tahun kalender akademik | `"2026/2027"` |
| | `data.semester` | `string` | **Ya (Required)** | Semester | `"Genap"` |
| | `data.is_active` | `integer` | **Ya (Required)** | Is Active | `0` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:44"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:44"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `DELETE` /api/tahun-akademik/{id}
**Ringkasan:** Hapus Data Tahun Akademik

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dihapus" |
| | `data` | `null / object` | *Tidak (Opsional)* | Payload hasil operasi hapus | `null` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/tahun-akademik/{id}/kelas
**Ringkasan:** Kelas Tahun Akademik

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `10` |
| | `data.tahun` | `string` | **Ya (Required)** | Tahun | `"2026/2027"` |
| | `data.semester` | `string` | **Ya (Required)** | Semester | `"Genap"` |
| | `data.is_active` | `integer` | **Ya (Required)** | Is Active | `0` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:44"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:44"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

## Autentikasi
> Modul: **Autentikasi** | Jumlah: 5 endpoint

### `POST` /api/auth/login
**Ringkasan:** Login Pengguna dan Dapatkan Token JWT

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `email` | `string (email)` | **Ya** | Email akun pengguna Polines | `administrator@polines.ac.id` |
| `password` | `string (password)` | **Ya** | Kata sandi akun pengguna | `password` |

##### Contoh Payload Request:
```json
{
  "email": "administrator@polines.ac.id",
  "password": "password"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📥 2. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `email` | `string (email)` | **Ya (Required)** | Email akun pengguna Polines | `administrator@polines.ac.id` |
| `password` | `string (password)` | **Ya (Required)** | Kata sandi akun pengguna | `password` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data autentikasi | `{ ... }` |
| | `data.user` | `object` | **Ya (Required)** | Informasi data akun pengguna login | `{ ... }` |
| | `data.user.id` | `integer` | **Ya (Required)** | ID unik pengguna | `1` |
| | `data.user.nama` | `string` | **Ya (Required)** | Nama lengkap pengguna | \"Administrator\" |
| | `data.user.email` | `string` | **Ya (Required)** | Alamat email terdaftar | \"admin@siakre.polines.ac.id\" |
| | `data.user.role` | `string` | **Ya (Required)** | Role hak akses sistem | \"ADMINISTRATOR\" |
| | `data.authorization` | `object` | **Ya (Required)** | Kredensial token akses JWT | `{ ... }` |
| | `data.authorization.access_token` | `string` | **Ya (Required)** | Token Bearer JWT untuk request berikutnya | \"eyJhbGci...\" |
| | `data.authorization.token_type` | `string` | **Ya (Required)** | Jenis token otentikasi | \"Bearer\" |
| | `data.authorization.expires_in` | `integer` | **Ya (Required)** | Masa berlaku token dalam detik | `3600` |
| | `data.authorization.permissions` | `array[string]` | **Ya (Required)** | Daftar permissions aktif pengguna | `[\"user-create\", ...]` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `POST` /api/auth/google
**Ringkasan:** Login Menggunakan Google ID Token

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `id_token` | `string` | **Ya** | Google OAuth2 ID Token kredensial | `eyJhbGciOiJSUzI1NiIsImtpZCI6IjEyMzQ1NiJ9.eyJpc3MiOiJodHRwczovL2FjY291bnRzLmdvb2dsZS5jb20iLCJlbWFpbCI6ImRhc2loYXl1QHBvbGluZXMuYWMuaWQifQ.signature` |

##### Contoh Payload Request:
```json
{
  "id_token": "eyJhbGciOiJSUzI1NiIsImtpZCI6IjEyMzQ1NiJ9.eyJpc3MiOiJodHRwczovL2FjY291bnRzLmdvb2dsZS5jb20iLCJlbWFpbCI6ImRhc2loYXl1QHBvbGluZXMuYWMuaWQifQ.signature"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📥 2. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `id_token` | `string` | **Ya (Required)** | Google OAuth2 ID Token kredensial | `eyJhbGciOiJSUzI1NiIsImtpZCI6IjEyMzQ1NiJ9.eyJpc3MiOiJodHRwczovL2FjY291bnRzLmdvb2dsZS5jb20iLCJlbWFpbCI6ImRhc2loYXl1QHBvbGluZXMuYWMuaWQifQ.signature` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data autentikasi | `{ ... }` |
| | `data.user` | `object` | **Ya (Required)** | Informasi data akun pengguna login | `{ ... }` |
| | `data.user.id` | `integer` | **Ya (Required)** | ID unik pengguna | `1` |
| | `data.user.nama` | `string` | **Ya (Required)** | Nama lengkap pengguna | \"Administrator\" |
| | `data.user.email` | `string` | **Ya (Required)** | Alamat email terdaftar | \"admin@siakre.polines.ac.id\" |
| | `data.user.role` | `string` | **Ya (Required)** | Role hak akses sistem | \"ADMINISTRATOR\" |
| | `data.authorization` | `object` | **Ya (Required)** | Kredensial token akses JWT | `{ ... }` |
| | `data.authorization.access_token` | `string` | **Ya (Required)** | Token Bearer JWT untuk request berikutnya | \"eyJhbGci...\" |
| | `data.authorization.token_type` | `string` | **Ya (Required)** | Jenis token otentikasi | \"Bearer\" |
| | `data.authorization.expires_in` | `integer` | **Ya (Required)** | Masa berlaku token dalam detik | `3600` |
| | `data.authorization.permissions` | `array[string]` | **Ya (Required)** | Daftar permissions aktif pengguna | `[\"user-create\", ...]` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/auth/me
**Ringkasan:** Profil Pengguna Terautentikasi

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📤 2. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Profil pengguna yang sedang login | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | ID unik pengguna | `1` |
| | `data.name` | `string` | **Ya (Required)** | Nama pengguna | \"Administrator\" |
| | `data.email` | `string` | **Ya (Required)** | Email pengguna | \"admin@siakre.polines.ac.id\" |
| | `data.role` | `string` | **Ya (Required)** | Role hak akses pengguna | \"ADMINISTRATOR\" |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `POST` /api/auth/logout
**Ringkasan:** Logout dan Invalidasi Token

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📤 2. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `POST` /api/auth/refresh
**Ringkasan:** Perbarui Token Akses JWT

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📤 2. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

## Kurikulum & Standar CPL
> Modul: **Kurikulum & Standar CPL** | Jumlah: 18 endpoint

### `GET` /api/cpl
**Ringkasan:** Daftar Semua Data Capaian Pembelajaran (CPL)

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📤 2. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `array[object]` | **Ya (Required)** | Koleksi daftar data entitas | `[ { ... } ]` |
| | `data[].id` | `integer` | **Ya (Required)** | Id | `8` |
| | `data[].id_kurikulum` | `integer` | **Ya (Required)** | Id Kurikulum | `1` |
| | `data[].kode_cpl` | `string` | **Ya (Required)** | Kode Cpl | `"CPL-08"` |
| | `data[].deskripsi_cpl` | `string` | **Ya (Required)** | Deskripsi Cpl | `"Mampu mengelola dan menganalisis data skala besar, teks, dan citra menggunakan teknik pembelajaran mesin serta kecerdasan buatan (Data Analysts & Scientists)."` |
| | `data[].kategori` | `string` | **Ya (Required)** | Kategori | `"Keterampilan Khusus"` |
| | `data[].created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:26"` |
| | `data[].updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:26"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `POST` /api/cpl
**Ringkasan:** Tambah Data Capaian Pembelajaran (CPL) Baru

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `id_kurikulum` | `integer` | **Ya** | ID referensi Kurikulum | `1` |
| `kode_cpl` | `string` | **Ya** | Kode unik Capaian Pembelajaran Lulusan (CPL) | `CPL-08` |
| `deskripsi_cpl` | `string` | **Ya** | Uraian kompetensi dan capaian pembelajaran | `Mampu mengelola dan menganalisis data skala besar, teks, dan citra menggunakan teknik pembelajaran mesin serta kecerdasan buatan (Data Analysts & Scientists).` |
| `kategori` | `string` | **Ya** | Kategori CPL (Sikap, Pengetahuan, Keterampilan Umum, Keterampilan Khusus) | `Keterampilan Khusus` |

##### Contoh Payload Request:
```json
{
  "id_kurikulum": 1,
  "kode_cpl": "CPL-08",
  "deskripsi_cpl": "Mampu mengelola dan menganalisis data skala besar, teks, dan citra menggunakan teknik pembelajaran mesin serta kecerdasan buatan (Data Analysts & Scientists).",
  "kategori": "Keterampilan Khusus"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📥 2. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `id_kurikulum` | `integer` | **Ya (Required)** | ID referensi Kurikulum | `1` |
| `kode_cpl` | `string` | **Ya (Required)** | Kode unik Capaian Pembelajaran Lulusan (CPL) | `CPL-08` |
| `deskripsi_cpl` | `string` | **Ya (Required)** | Uraian kompetensi dan capaian pembelajaran | `Mampu mengelola dan menganalisis data skala besar, teks, dan citra menggunakan teknik pembelajaran mesin serta kecerdasan buatan (Data Analysts & Scientists).` |
| `kategori` | `string` | **Ya (Required)** | Kategori CPL (Sikap, Pengetahuan, Keterampilan Umum, Keterampilan Khusus) | `Keterampilan Khusus` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **201 Created** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (201) | `201` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dibuat" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `8` |
| | `data.id_kurikulum` | `integer` | **Ya (Required)** | ID referensi Kurikulum | `1` |
| | `data.kode_cpl` | `string` | **Ya (Required)** | Kode unik Capaian Pembelajaran Lulusan (CPL) | `"CPL-08"` |
| | `data.deskripsi_cpl` | `string` | **Ya (Required)** | Uraian kompetensi dan capaian pembelajaran | `"Mampu mengelola dan menganalisis data skala besar, teks, dan citra menggunakan teknik pembelajaran mesin serta kecerdasan buatan (Data Analysts & Scientists)."` |
| | `data.kategori` | `string` | **Ya (Required)** | Kategori CPL (Sikap, Pengetahuan, Keterampilan Umum, Keterampilan Khusus) | `"Keterampilan Khusus"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:26"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:26"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/cpl/{id}
**Ringkasan:** Detail Data Capaian Pembelajaran (CPL)

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `8` |
| | `data.id_kurikulum` | `integer` | **Ya (Required)** | Id Kurikulum | `1` |
| | `data.kode_cpl` | `string` | **Ya (Required)** | Kode Cpl | `"CPL-08"` |
| | `data.deskripsi_cpl` | `string` | **Ya (Required)** | Deskripsi Cpl | `"Mampu mengelola dan menganalisis data skala besar, teks, dan citra menggunakan teknik pembelajaran mesin serta kecerdasan buatan (Data Analysts & Scientists)."` |
| | `data.kategori` | `string` | **Ya (Required)** | Kategori | `"Keterampilan Khusus"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:26"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:26"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `PUT` /api/cpl/{id}
**Ringkasan:** Perbarui Data Capaian Pembelajaran (CPL)

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `id_kurikulum` | `integer` | **Ya** | ID referensi Kurikulum | `1` |
| `kode_cpl` | `string` | **Ya** | Kode unik Capaian Pembelajaran Lulusan (CPL) | `CPL-08` |
| `deskripsi_cpl` | `string` | **Ya** | Uraian kompetensi dan capaian pembelajaran | `Mampu mengelola dan menganalisis data skala besar, teks, dan citra menggunakan teknik pembelajaran mesin serta kecerdasan buatan (Data Analysts & Scientists).` |
| `kategori` | `string` | **Ya** | Kategori CPL (Sikap, Pengetahuan, Keterampilan Umum, Keterampilan Khusus) | `Keterampilan Khusus` |

##### Contoh Payload Request:
```json
{
  "id_kurikulum": 1,
  "kode_cpl": "CPL-08",
  "deskripsi_cpl": "Mampu mengelola dan menganalisis data skala besar, teks, dan citra menggunakan teknik pembelajaran mesin serta kecerdasan buatan (Data Analysts & Scientists).",
  "kategori": "Keterampilan Khusus"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📥 3. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `id_kurikulum` | `integer` | **Ya (Required)** | ID referensi Kurikulum | `1` |
| `kode_cpl` | `string` | **Ya (Required)** | Kode unik Capaian Pembelajaran Lulusan (CPL) | `CPL-08` |
| `deskripsi_cpl` | `string` | **Ya (Required)** | Uraian kompetensi dan capaian pembelajaran | `Mampu mengelola dan menganalisis data skala besar, teks, dan citra menggunakan teknik pembelajaran mesin serta kecerdasan buatan (Data Analysts & Scientists).` |
| `kategori` | `string` | **Ya (Required)** | Kategori CPL (Sikap, Pengetahuan, Keterampilan Umum, Keterampilan Khusus) | `Keterampilan Khusus` |

### 📤 4. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `8` |
| | `data.id_kurikulum` | `integer` | **Ya (Required)** | ID referensi Kurikulum | `1` |
| | `data.kode_cpl` | `string` | **Ya (Required)** | Kode unik Capaian Pembelajaran Lulusan (CPL) | `"CPL-08"` |
| | `data.deskripsi_cpl` | `string` | **Ya (Required)** | Uraian kompetensi dan capaian pembelajaran | `"Mampu mengelola dan menganalisis data skala besar, teks, dan citra menggunakan teknik pembelajaran mesin serta kecerdasan buatan (Data Analysts & Scientists)."` |
| | `data.kategori` | `string` | **Ya (Required)** | Kategori CPL (Sikap, Pengetahuan, Keterampilan Umum, Keterampilan Khusus) | `"Keterampilan Khusus"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:26"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:26"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `DELETE` /api/cpl/{id}
**Ringkasan:** Hapus Data Capaian Pembelajaran (CPL)

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dihapus" |
| | `data` | `null / object` | *Tidak (Opsional)* | Payload hasil operasi hapus | `null` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/kurikulum
**Ringkasan:** Daftar Semua Data Kurikulum

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📤 2. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `array[object]` | **Ya (Required)** | Koleksi daftar data entitas | `[ { ... } ]` |
| | `data[].id` | `integer` | **Ya (Required)** | Id | `1` |
| | `data[].id_prodi` | `integer` | **Ya (Required)** | Id Prodi | `1` |
| | `data[].nama_kurikulum` | `string` | **Ya (Required)** | Nama Kurikulum | `"Kurikulum Sarjana Terapan Teknologi Rekayasa Komputer"` |
| | `data[].berlaku_sampai` | `integer` | **Ya (Required)** | Berlaku Sampai | `2028` |
| | `data[].sk_kurikulum` | `string` | **Ya (Required)** | Sk Kurikulum | `"SK/POLINES/433-RK/2022"` |
| | `data[].created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:26"` |
| | `data[].updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:26"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `POST` /api/kurikulum
**Ringkasan:** Tambah Data Kurikulum Baru

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `id_prodi` | `integer` | **Ya** | ID referensi Program Studi | `1` |
| `nama_kurikulum` | `string` | **Ya** | Nama kurikulum akademik | `Kurikulum Sarjana Terapan Teknologi Rekayasa Komputer` |
| `tahun_mulai` | `integer` | Tidak | Tahun mulai berlakunya kurikulum | `1` |
| `berlaku_sampai` | `integer` | **Ya** | Tahun masa berakhirnya kurikulum | `2028` |
| `status` | `string` | Tidak | Status keaktifan mahasiswa (Aktif, Cuti, Lulus) | `Aktif` |
| `dokumen_url` | `string` | Tidak | URL link berkas dokumen kurikulum | `Contoh Dokumen Url` |
| `profil_lulusan` | `string` | Tidak | Deskripsi profil lulusan sesuai kurikulum | `Contoh Profil Lulusan` |
| `sk_kurikulum` | `string` | Tidak | Nomor Surat Keputusan (SK) pemberlakuan kurikulum | `SK/POLINES/433-RK/2022` |

##### Contoh Payload Request:
```json
{
  "id_prodi": 1,
  "nama_kurikulum": "Kurikulum Sarjana Terapan Teknologi Rekayasa Komputer",
  "tahun_mulai": 1,
  "berlaku_sampai": 2028,
  "status": "Aktif",
  "dokumen_url": "Contoh Dokumen Url",
  "profil_lulusan": "Contoh Profil Lulusan",
  "sk_kurikulum": "SK/POLINES/433-RK/2022"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📥 2. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `id_prodi` | `integer` | **Ya (Required)** | ID referensi Program Studi | `1` |
| `nama_kurikulum` | `string` | **Ya (Required)** | Nama kurikulum akademik | `Kurikulum Sarjana Terapan Teknologi Rekayasa Komputer` |
| `tahun_mulai` | `integer` | *Tidak (Opsional / Nullable)* | Tahun mulai berlakunya kurikulum | `1` |
| `berlaku_sampai` | `integer` | **Ya (Required)** | Tahun masa berakhirnya kurikulum | `2028` |
| `status` | `string` | *Tidak (Opsional / Nullable)* | Status keaktifan mahasiswa (Aktif, Cuti, Lulus) | `Aktif` |
| `dokumen_url` | `string` | *Tidak (Opsional / Nullable)* | URL link berkas dokumen kurikulum | `Contoh Dokumen Url` |
| `profil_lulusan` | `string` | *Tidak (Opsional / Nullable)* | Deskripsi profil lulusan sesuai kurikulum | `Contoh Profil Lulusan` |
| `sk_kurikulum` | `string` | *Tidak (Opsional / Nullable)* | Nomor Surat Keputusan (SK) pemberlakuan kurikulum | `SK/POLINES/433-RK/2022` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **201 Created** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (201) | `201` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dibuat" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `1` |
| | `data.id_prodi` | `integer` | **Ya (Required)** | ID referensi Program Studi | `1` |
| | `data.nama_kurikulum` | `string` | **Ya (Required)** | Nama kurikulum akademik | `"Kurikulum Sarjana Terapan Teknologi Rekayasa Komputer"` |
| | `data.berlaku_sampai` | `integer` | **Ya (Required)** | Tahun masa berakhirnya kurikulum | `2028` |
| | `data.sk_kurikulum` | `string` | *Tidak (Opsional / Nullable)* | Nomor Surat Keputusan (SK) pemberlakuan kurikulum | `"SK/POLINES/433-RK/2022"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:26"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:26"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/kurikulum/{id}
**Ringkasan:** Detail Data Kurikulum

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `1` |
| | `data.id_prodi` | `integer` | **Ya (Required)** | Id Prodi | `1` |
| | `data.nama_kurikulum` | `string` | **Ya (Required)** | Nama Kurikulum | `"Kurikulum Sarjana Terapan Teknologi Rekayasa Komputer"` |
| | `data.berlaku_sampai` | `integer` | **Ya (Required)** | Berlaku Sampai | `2028` |
| | `data.sk_kurikulum` | `string` | **Ya (Required)** | Sk Kurikulum | `"SK/POLINES/433-RK/2022"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:26"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:26"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `PUT` /api/kurikulum/{id}
**Ringkasan:** Perbarui Data Kurikulum

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `id_prodi` | `integer` | **Ya** | ID referensi Program Studi | `1` |
| `nama_kurikulum` | `string` | **Ya** | Nama kurikulum akademik | `Kurikulum Sarjana Terapan Teknologi Rekayasa Komputer` |
| `tahun_mulai` | `integer` | Tidak | Tahun mulai berlakunya kurikulum | `1` |
| `berlaku_sampai` | `integer` | **Ya** | Tahun masa berakhirnya kurikulum | `2028` |
| `status` | `string` | Tidak | Status keaktifan mahasiswa (Aktif, Cuti, Lulus) | `Aktif` |
| `dokumen_url` | `string` | Tidak | URL link berkas dokumen kurikulum | `Contoh Dokumen Url` |
| `profil_lulusan` | `string` | Tidak | Deskripsi profil lulusan sesuai kurikulum | `Contoh Profil Lulusan` |
| `sk_kurikulum` | `string` | Tidak | Nomor Surat Keputusan (SK) pemberlakuan kurikulum | `SK/POLINES/433-RK/2022` |

##### Contoh Payload Request:
```json
{
  "id_prodi": 1,
  "nama_kurikulum": "Kurikulum Sarjana Terapan Teknologi Rekayasa Komputer",
  "tahun_mulai": 1,
  "berlaku_sampai": 2028,
  "status": "Aktif",
  "dokumen_url": "Contoh Dokumen Url",
  "profil_lulusan": "Contoh Profil Lulusan",
  "sk_kurikulum": "SK/POLINES/433-RK/2022"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📥 3. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `id_prodi` | `integer` | **Ya (Required)** | ID referensi Program Studi | `1` |
| `nama_kurikulum` | `string` | **Ya (Required)** | Nama kurikulum akademik | `Kurikulum Sarjana Terapan Teknologi Rekayasa Komputer` |
| `tahun_mulai` | `integer` | *Tidak (Opsional / Nullable)* | Tahun mulai berlakunya kurikulum | `1` |
| `berlaku_sampai` | `integer` | **Ya (Required)** | Tahun masa berakhirnya kurikulum | `2028` |
| `status` | `string` | *Tidak (Opsional / Nullable)* | Status keaktifan mahasiswa (Aktif, Cuti, Lulus) | `Aktif` |
| `dokumen_url` | `string` | *Tidak (Opsional / Nullable)* | URL link berkas dokumen kurikulum | `Contoh Dokumen Url` |
| `profil_lulusan` | `string` | *Tidak (Opsional / Nullable)* | Deskripsi profil lulusan sesuai kurikulum | `Contoh Profil Lulusan` |
| `sk_kurikulum` | `string` | *Tidak (Opsional / Nullable)* | Nomor Surat Keputusan (SK) pemberlakuan kurikulum | `SK/POLINES/433-RK/2022` |

### 📤 4. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `1` |
| | `data.id_prodi` | `integer` | **Ya (Required)** | ID referensi Program Studi | `1` |
| | `data.nama_kurikulum` | `string` | **Ya (Required)** | Nama kurikulum akademik | `"Kurikulum Sarjana Terapan Teknologi Rekayasa Komputer"` |
| | `data.berlaku_sampai` | `integer` | **Ya (Required)** | Tahun masa berakhirnya kurikulum | `2028` |
| | `data.sk_kurikulum` | `string` | *Tidak (Opsional / Nullable)* | Nomor Surat Keputusan (SK) pemberlakuan kurikulum | `"SK/POLINES/433-RK/2022"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:26"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:26"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `DELETE` /api/kurikulum/{id}
**Ringkasan:** Hapus Data Kurikulum

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dihapus" |
| | `data` | `null / object` | *Tidak (Opsional)* | Payload hasil operasi hapus | `null` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/kurikulum/{id}/mata-kuliah
**Ringkasan:** Mata Kuliah Kurikulum

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `1` |
| | `data.id_prodi` | `integer` | **Ya (Required)** | Id Prodi | `1` |
| | `data.nama_kurikulum` | `string` | **Ya (Required)** | Nama Kurikulum | `"Kurikulum Sarjana Terapan Teknologi Rekayasa Komputer"` |
| | `data.berlaku_sampai` | `integer` | **Ya (Required)** | Berlaku Sampai | `2028` |
| | `data.sk_kurikulum` | `string` | **Ya (Required)** | Sk Kurikulum | `"SK/POLINES/433-RK/2022"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:26"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:26"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/mata-kuliah/{mataKuliahId}/cpl
**Ringkasan:** Daftar Semua Data Mapping Mata Kuliah CPL

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `mataKuliahId` | `path` | `integer` | **Ya** | ID data mataKuliahId |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `mataKuliahId` | `integer` | **Ya (Required)** | Parameter ID unik mataKuliahId pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `array[object]` | **Ya (Required)** | Koleksi daftar data entitas | `[ { ... } ]` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `POST` /api/mata-kuliah/{mataKuliahId}/cpl/sync
**Ringkasan:** Sinkronisasi Mapping Mata Kuliah CPL

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `mataKuliahId` | `path` | `integer` | **Ya** | ID data mataKuliahId |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `cpl_ids` | `array` | **Ya** | Array ID CPL yang dipetakan ke mata kuliah | [1, 2, 3] |

##### Contoh Payload Request:
```json
{
  "cpl_ids": [
    1,
    2,
    3
  ]
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `mataKuliahId` | `integer` | **Ya (Required)** | Parameter ID unik mataKuliahId pada path URL | `1` |

### 📥 3. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `cpl_ids` | `array` | **Ya (Required)** | Array ID CPL yang dipetakan ke mata kuliah | `[1,2,3]` |

### 📤 4. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **201 Created** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (201) | `201` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dibuat" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/mata-kuliah
**Ringkasan:** Daftar Semua Data Mata Kuliah

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📤 2. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `array[object]` | **Ya (Required)** | Koleksi daftar data entitas | `[ { ... } ]` |
| | `data[].id` | `integer` | **Ya (Required)** | Id | `52` |
| | `data[].id_kurikulum` | `integer` | **Ya (Required)** | Id Kurikulum | `1` |
| | `data[].kode_mata_kuliah` | `string` | **Ya (Required)** | Kode Mata Kuliah | `"432-191-801"` |
| | `data[].nama_mata_kuliah` | `string` | **Ya (Required)** | Nama Mata Kuliah | `"Magang"` |
| | `data[].sks` | `integer` | **Ya (Required)** | Sks | `6` |
| | `data[].created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:31"` |
| | `data[].updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:31"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `POST` /api/mata-kuliah
**Ringkasan:** Tambah Data Mata Kuliah Baru

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `id_kurikulum` | `integer` | **Ya** | ID referensi Kurikulum | `1` |
| `kode_mata_kuliah` | `string` | **Ya** | Kode unik Mata Kuliah | `432-191-801` |
| `nama_mata_kuliah` | `string` | **Ya** | Nama resmi Mata Kuliah | `Magang` |
| `sks` | `integer` | **Ya** | Bobot satuan kredit semester (SKS) | `6` |
| `semester` | `integer` | Tidak | Semester | `1` |
| `jenis` | `string` | Tidak | Jenis entitas unit pengelola (misal: Jurusan, Fakultas) | `Jurusan` |
| `sks_teori` | `integer` | Tidak | Sks Teori | `1` |
| `sks_praktik` | `integer` | Tidak | Sks Praktik | `1` |

##### Contoh Payload Request:
```json
{
  "id_kurikulum": 1,
  "kode_mata_kuliah": "432-191-801",
  "nama_mata_kuliah": "Magang",
  "sks": 6,
  "semester": 1,
  "jenis": "Jurusan",
  "sks_teori": 1,
  "sks_praktik": 1
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📥 2. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `id_kurikulum` | `integer` | **Ya (Required)** | ID referensi Kurikulum | `1` |
| `kode_mata_kuliah` | `string` | **Ya (Required)** | Kode unik Mata Kuliah | `432-191-801` |
| `nama_mata_kuliah` | `string` | **Ya (Required)** | Nama resmi Mata Kuliah | `Magang` |
| `sks` | `integer` | **Ya (Required)** | Bobot satuan kredit semester (SKS) | `6` |
| `semester` | `integer` | *Tidak (Opsional / Nullable)* | Semester | `1` |
| `jenis` | `string` | *Tidak (Opsional / Nullable)* | Jenis entitas unit pengelola (misal: Jurusan, Fakultas) | `Jurusan` |
| `sks_teori` | `integer` | *Tidak (Opsional / Nullable)* | Sks Teori | `1` |
| `sks_praktik` | `integer` | *Tidak (Opsional / Nullable)* | Sks Praktik | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **201 Created** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (201) | `201` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dibuat" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `52` |
| | `data.id_kurikulum` | `integer` | **Ya (Required)** | ID referensi Kurikulum | `1` |
| | `data.kode_mata_kuliah` | `string` | **Ya (Required)** | Kode unik Mata Kuliah | `"432-191-801"` |
| | `data.nama_mata_kuliah` | `string` | **Ya (Required)** | Nama resmi Mata Kuliah | `"Magang"` |
| | `data.sks` | `integer` | **Ya (Required)** | Bobot satuan kredit semester (SKS) | `6` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:31"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:31"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/mata-kuliah/{id}
**Ringkasan:** Detail Data Mata Kuliah

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `52` |
| | `data.id_kurikulum` | `integer` | **Ya (Required)** | Id Kurikulum | `1` |
| | `data.kode_mata_kuliah` | `string` | **Ya (Required)** | Kode Mata Kuliah | `"432-191-801"` |
| | `data.nama_mata_kuliah` | `string` | **Ya (Required)** | Nama Mata Kuliah | `"Magang"` |
| | `data.sks` | `integer` | **Ya (Required)** | Sks | `6` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:31"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:31"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `PUT` /api/mata-kuliah/{id}
**Ringkasan:** Perbarui Data Mata Kuliah

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `id_kurikulum` | `integer` | **Ya** | ID referensi Kurikulum | `1` |
| `kode_mata_kuliah` | `string` | **Ya** | Kode unik Mata Kuliah | `432-191-801` |
| `nama_mata_kuliah` | `string` | **Ya** | Nama resmi Mata Kuliah | `Magang` |
| `sks` | `integer` | **Ya** | Bobot satuan kredit semester (SKS) | `6` |
| `semester` | `integer` | Tidak | Semester | `1` |
| `jenis` | `string` | Tidak | Jenis entitas unit pengelola (misal: Jurusan, Fakultas) | `Jurusan` |
| `sks_teori` | `integer` | Tidak | Sks Teori | `1` |
| `sks_praktik` | `integer` | Tidak | Sks Praktik | `1` |

##### Contoh Payload Request:
```json
{
  "id_kurikulum": 1,
  "kode_mata_kuliah": "432-191-801",
  "nama_mata_kuliah": "Magang",
  "sks": 6,
  "semester": 1,
  "jenis": "Jurusan",
  "sks_teori": 1,
  "sks_praktik": 1
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📥 3. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `id_kurikulum` | `integer` | **Ya (Required)** | ID referensi Kurikulum | `1` |
| `kode_mata_kuliah` | `string` | **Ya (Required)** | Kode unik Mata Kuliah | `432-191-801` |
| `nama_mata_kuliah` | `string` | **Ya (Required)** | Nama resmi Mata Kuliah | `Magang` |
| `sks` | `integer` | **Ya (Required)** | Bobot satuan kredit semester (SKS) | `6` |
| `semester` | `integer` | *Tidak (Opsional / Nullable)* | Semester | `1` |
| `jenis` | `string` | *Tidak (Opsional / Nullable)* | Jenis entitas unit pengelola (misal: Jurusan, Fakultas) | `Jurusan` |
| `sks_teori` | `integer` | *Tidak (Opsional / Nullable)* | Sks Teori | `1` |
| `sks_praktik` | `integer` | *Tidak (Opsional / Nullable)* | Sks Praktik | `1` |

### 📤 4. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `52` |
| | `data.id_kurikulum` | `integer` | **Ya (Required)** | ID referensi Kurikulum | `1` |
| | `data.kode_mata_kuliah` | `string` | **Ya (Required)** | Kode unik Mata Kuliah | `"432-191-801"` |
| | `data.nama_mata_kuliah` | `string` | **Ya (Required)** | Nama resmi Mata Kuliah | `"Magang"` |
| | `data.sks` | `integer` | **Ya (Required)** | Bobot satuan kredit semester (SKS) | `6` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:31"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:31"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `DELETE` /api/mata-kuliah/{id}
**Ringkasan:** Hapus Data Mata Kuliah

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dihapus" |
| | `data` | `null / object` | *Tidak (Opsional)* | Payload hasil operasi hapus | `null` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

## Dosen
> Modul: **Dosen** | Jumlah: 1 endpoint

### `GET` /api/dosen
**Ringkasan:** Daftar Semua Data Dosen

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📤 2. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `array[object]` | **Ya (Required)** | Koleksi daftar data entitas | `[ { ... } ]` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

## Data & Aktivitas Mahasiswa
> Modul: **Data & Aktivitas Mahasiswa** | Jumlah: 21 endpoint

### `GET` /api/enrollment-kelas
**Ringkasan:** Daftar Semua Data Enrollment Kelas

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📤 2. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `array[object]` | **Ya (Required)** | Koleksi daftar data entitas | `[ { ... } ]` |
| | `data[].id` | `integer` | **Ya (Required)** | Id | `3000` |
| | `data[].id_mahasiswa` | `integer` | **Ya (Required)** | Id Mahasiswa | `600` |
| | `data[].angkatan_kelas_id` | `integer` | **Ya (Required)** | Angkatan Kelas Id | `24` |
| | `data[].prodi_id` | `integer` | **Ya (Required)** | Prodi Id | `1` |
| | `data[].created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:57"` |
| | `data[].updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:57"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `POST` /api/enrollment-kelas
**Ringkasan:** Tambah Data Enrollment Kelas Baru

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `id_mahasiswa` | `integer` | **Ya** | ID referensi Mahasiswa | `600` |
| `angkatan_kelas_id` | `integer` | **Ya** | ID referensi Angkatan Kelas | `24` |
| `prodi_id` | `integer` | **Ya** | ID referensi Program Studi | `1` |

##### Contoh Payload Request:
```json
{
  "id_mahasiswa": 600,
  "angkatan_kelas_id": 24,
  "prodi_id": 1
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📥 2. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `id_mahasiswa` | `integer` | **Ya (Required)** | ID referensi Mahasiswa | `600` |
| `angkatan_kelas_id` | `integer` | **Ya (Required)** | ID referensi Angkatan Kelas | `24` |
| `prodi_id` | `integer` | **Ya (Required)** | ID referensi Program Studi | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **201 Created** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (201) | `201` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dibuat" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `3000` |
| | `data.id_mahasiswa` | `integer` | **Ya (Required)** | ID referensi Mahasiswa | `600` |
| | `data.angkatan_kelas_id` | `integer` | **Ya (Required)** | ID referensi Angkatan Kelas | `24` |
| | `data.prodi_id` | `integer` | **Ya (Required)** | ID referensi Program Studi | `1` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:57"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:57"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/enrollment-kelas/{id}
**Ringkasan:** Detail Data Enrollment Kelas

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `3000` |
| | `data.id_mahasiswa` | `integer` | **Ya (Required)** | Id Mahasiswa | `600` |
| | `data.angkatan_kelas_id` | `integer` | **Ya (Required)** | Angkatan Kelas Id | `24` |
| | `data.prodi_id` | `integer` | **Ya (Required)** | Prodi Id | `1` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:57"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:57"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `PUT` /api/enrollment-kelas/{id}
**Ringkasan:** Perbarui Data Enrollment Kelas

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `id_mahasiswa` | `integer` | **Ya** | ID referensi Mahasiswa | `600` |
| `angkatan_kelas_id` | `integer` | **Ya** | ID referensi Angkatan Kelas | `24` |
| `prodi_id` | `integer` | **Ya** | ID referensi Program Studi | `1` |

##### Contoh Payload Request:
```json
{
  "id_mahasiswa": 600,
  "angkatan_kelas_id": 24,
  "prodi_id": 1
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📥 3. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `id_mahasiswa` | `integer` | **Ya (Required)** | ID referensi Mahasiswa | `600` |
| `angkatan_kelas_id` | `integer` | **Ya (Required)** | ID referensi Angkatan Kelas | `24` |
| `prodi_id` | `integer` | **Ya (Required)** | ID referensi Program Studi | `1` |

### 📤 4. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `3000` |
| | `data.id_mahasiswa` | `integer` | **Ya (Required)** | ID referensi Mahasiswa | `600` |
| | `data.angkatan_kelas_id` | `integer` | **Ya (Required)** | ID referensi Angkatan Kelas | `24` |
| | `data.prodi_id` | `integer` | **Ya (Required)** | ID referensi Program Studi | `1` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:57"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:57"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `DELETE` /api/enrollment-kelas/{id}
**Ringkasan:** Hapus Data Enrollment Kelas

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dihapus" |
| | `data` | `null / object` | *Tidak (Opsional)* | Payload hasil operasi hapus | `null` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/kegiatan-mahasiswa
**Ringkasan:** Daftar Semua Data Kegiatan Mahasiswa

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📤 2. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `array[object]` | **Ya (Required)** | Koleksi daftar data entitas | `[ { ... } ]` |
| | `data[].id` | `integer` | **Ya (Required)** | Id | `8` |
| | `data[].mahasiswa_id` | `integer` | **Ya (Required)** | Mahasiswa Id | `226` |
| | `data[].tahun_akademik_id` | `integer` | **Ya (Required)** | Tahun Akademik Id | `7` |
| | `data[].nama_kegiatan` | `string` | **Ya (Required)** | Nama Kegiatan | `"Riset Terapan Sistem Cerdas Berbasis Edge Computing"` |
| | `data[].jenis_kegiatan` | `string` | **Ya (Required)** | Jenis Kegiatan | `"Penelitian"` |
| | `data[].peran` | `string` | **Ya (Required)** | Peran | `"Asisten Peneliti"` |
| | `data[].tingkat` | `string` | **Ya (Required)** | Tingkat | `"Nasional"` |
| | `data[].tanggal_mulai` | `string` | **Ya (Required)** | Tanggal Mulai | `"2025-08-01"` |
| | `data[].tanggal_selesai` | `string` | **Ya (Required)** | Tanggal Selesai | `"2026-01-15"` |
| | `data[].penyelenggara` | `string` | **Ya (Required)** | Penyelenggara | `"P3M Polines"` |
| | `data[].status_validasi` | `string` | **Ya (Required)** | Status Validasi | `"Disetujui"` |
| | `data[].created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:06"` |
| | `data[].updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:06"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `POST` /api/kegiatan-mahasiswa
**Ringkasan:** Tambah Data Kegiatan Mahasiswa Baru

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `mahasiswa_id` | `integer` | **Ya** | ID referensi Mahasiswa | `226` |
| `tahun_akademik_id` | `integer` | **Ya** | ID referensi Tahun Akademik | `7` |
| `nama_kegiatan` | `string` | **Ya** | Nama kegiatan kemahasiswaan atau lomba | `Riset Terapan Sistem Cerdas Berbasis Edge Computing` |
| `jenis_kegiatan` | `string` | **Ya** | Jenis kegiatan (Organisasi, Lomba, Seminar, Magang, UKM) | `Penelitian` |
| `peran` | `string` | **Ya** | Peran atau posisi mahasiswa dalam kegiatan | `Asisten Peneliti` |
| `tingkat` | `string` | **Ya** | Skala lingkup kegiatan (Jurusan, Polines, Regional, Nasional, Internasional) | `Nasional` |
| `tanggal_mulai` | `string (date)` | **Ya** | Tanggal pelaksanaan kegiatan dimulai | `2025-08-01` |
| `tanggal_selesai` | `string (date)` | Tidak | Tanggal pelaksanaan kegiatan selesai | `2026-01-15` |
| `penyelenggara` | `string` | **Ya** | Instansi atau organisasi penyelenggara kegiatan | `P3M Polines` |
| `status_validasi` | `string` | **Ya** | Status persetujuan validasi (Disetujui, Pending, Ditolak) | `Disetujui` |

##### Contoh Payload Request:
```json
{
  "mahasiswa_id": 226,
  "tahun_akademik_id": 7,
  "nama_kegiatan": "Riset Terapan Sistem Cerdas Berbasis Edge Computing",
  "jenis_kegiatan": "Penelitian",
  "peran": "Asisten Peneliti",
  "tingkat": "Nasional",
  "tanggal_mulai": "2025-08-01",
  "tanggal_selesai": "2026-01-15",
  "penyelenggara": "P3M Polines",
  "status_validasi": "Disetujui"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📥 2. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `mahasiswa_id` | `integer` | **Ya (Required)** | ID referensi Mahasiswa | `226` |
| `tahun_akademik_id` | `integer` | **Ya (Required)** | ID referensi Tahun Akademik | `7` |
| `nama_kegiatan` | `string` | **Ya (Required)** | Nama kegiatan kemahasiswaan atau lomba | `Riset Terapan Sistem Cerdas Berbasis Edge Computing` |
| `jenis_kegiatan` | `string` | **Ya (Required)** | Jenis kegiatan (Organisasi, Lomba, Seminar, Magang, UKM) | `Penelitian` |
| `peran` | `string` | **Ya (Required)** | Peran atau posisi mahasiswa dalam kegiatan | `Asisten Peneliti` |
| `tingkat` | `string` | **Ya (Required)** | Skala lingkup kegiatan (Jurusan, Polines, Regional, Nasional, Internasional) | `Nasional` |
| `tanggal_mulai` | `string (date)` | **Ya (Required)** | Tanggal pelaksanaan kegiatan dimulai | `2025-08-01` |
| `tanggal_selesai` | `string (date)` | *Tidak (Opsional / Nullable)* | Tanggal pelaksanaan kegiatan selesai | `2026-01-15` |
| `penyelenggara` | `string` | **Ya (Required)** | Instansi atau organisasi penyelenggara kegiatan | `P3M Polines` |
| `status_validasi` | `string` | **Ya (Required)** | Status persetujuan validasi (Disetujui, Pending, Ditolak) | `Disetujui` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **201 Created** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (201) | `201` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dibuat" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `8` |
| | `data.mahasiswa_id` | `integer` | **Ya (Required)** | ID referensi Mahasiswa | `226` |
| | `data.tahun_akademik_id` | `integer` | **Ya (Required)** | ID referensi Tahun Akademik | `7` |
| | `data.nama_kegiatan` | `string` | **Ya (Required)** | Nama kegiatan kemahasiswaan atau lomba | `"Riset Terapan Sistem Cerdas Berbasis Edge Computing"` |
| | `data.jenis_kegiatan` | `string` | **Ya (Required)** | Jenis kegiatan (Organisasi, Lomba, Seminar, Magang, UKM) | `"Penelitian"` |
| | `data.peran` | `string` | **Ya (Required)** | Peran atau posisi mahasiswa dalam kegiatan | `"Asisten Peneliti"` |
| | `data.tingkat` | `string` | **Ya (Required)** | Skala lingkup kegiatan (Jurusan, Polines, Regional, Nasional, Internasional) | `"Nasional"` |
| | `data.tanggal_mulai` | `string` | **Ya (Required)** | Tanggal pelaksanaan kegiatan dimulai | `"2025-08-01"` |
| | `data.tanggal_selesai` | `string` | *Tidak (Opsional / Nullable)* | Tanggal pelaksanaan kegiatan selesai | `"2026-01-15"` |
| | `data.penyelenggara` | `string` | **Ya (Required)** | Instansi atau organisasi penyelenggara kegiatan | `"P3M Polines"` |
| | `data.status_validasi` | `string` | **Ya (Required)** | Status persetujuan validasi (Disetujui, Pending, Ditolak) | `"Disetujui"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:06"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:06"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/kegiatan-mahasiswa/{id}
**Ringkasan:** Detail Data Kegiatan Mahasiswa

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `6` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `8` |
| | `data.mahasiswa_id` | `integer` | **Ya (Required)** | Mahasiswa Id | `226` |
| | `data.tahun_akademik_id` | `integer` | **Ya (Required)** | Tahun Akademik Id | `7` |
| | `data.nama_kegiatan` | `string` | **Ya (Required)** | Nama Kegiatan | `"Riset Terapan Sistem Cerdas Berbasis Edge Computing"` |
| | `data.jenis_kegiatan` | `string` | **Ya (Required)** | Jenis Kegiatan | `"Penelitian"` |
| | `data.peran` | `string` | **Ya (Required)** | Peran | `"Asisten Peneliti"` |
| | `data.tingkat` | `string` | **Ya (Required)** | Tingkat | `"Nasional"` |
| | `data.tanggal_mulai` | `string` | **Ya (Required)** | Tanggal Mulai | `"2025-08-01"` |
| | `data.tanggal_selesai` | `string` | **Ya (Required)** | Tanggal Selesai | `"2026-01-15"` |
| | `data.penyelenggara` | `string` | **Ya (Required)** | Penyelenggara | `"P3M Polines"` |
| | `data.status_validasi` | `string` | **Ya (Required)** | Status Validasi | `"Disetujui"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:06"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:06"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `PUT` /api/kegiatan-mahasiswa/{id}
**Ringkasan:** Perbarui Data Kegiatan Mahasiswa

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `mahasiswa_id` | `integer` | **Ya** | ID referensi Mahasiswa | `226` |
| `tahun_akademik_id` | `integer` | **Ya** | ID referensi Tahun Akademik | `7` |
| `nama_kegiatan` | `string` | **Ya** | Nama kegiatan kemahasiswaan atau lomba | `Riset Terapan Sistem Cerdas Berbasis Edge Computing` |
| `jenis_kegiatan` | `string` | **Ya** | Jenis kegiatan (Organisasi, Lomba, Seminar, Magang, UKM) | `Penelitian` |
| `peran` | `string` | **Ya** | Peran atau posisi mahasiswa dalam kegiatan | `Asisten Peneliti` |
| `tingkat` | `string` | **Ya** | Skala lingkup kegiatan (Jurusan, Polines, Regional, Nasional, Internasional) | `Nasional` |
| `tanggal_mulai` | `string (date)` | **Ya** | Tanggal pelaksanaan kegiatan dimulai | `2025-08-01` |
| `tanggal_selesai` | `string (date)` | Tidak | Tanggal pelaksanaan kegiatan selesai | `2026-01-15` |
| `penyelenggara` | `string` | **Ya** | Instansi atau organisasi penyelenggara kegiatan | `P3M Polines` |
| `status_validasi` | `string` | **Ya** | Status persetujuan validasi (Disetujui, Pending, Ditolak) | `Disetujui` |

##### Contoh Payload Request:
```json
{
  "mahasiswa_id": 226,
  "tahun_akademik_id": 7,
  "nama_kegiatan": "Riset Terapan Sistem Cerdas Berbasis Edge Computing",
  "jenis_kegiatan": "Penelitian",
  "peran": "Asisten Peneliti",
  "tingkat": "Nasional",
  "tanggal_mulai": "2025-08-01",
  "tanggal_selesai": "2026-01-15",
  "penyelenggara": "P3M Polines",
  "status_validasi": "Disetujui"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `6` |

### 📥 3. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `mahasiswa_id` | `integer` | **Ya (Required)** | ID referensi Mahasiswa | `226` |
| `tahun_akademik_id` | `integer` | **Ya (Required)** | ID referensi Tahun Akademik | `7` |
| `nama_kegiatan` | `string` | **Ya (Required)** | Nama kegiatan kemahasiswaan atau lomba | `Riset Terapan Sistem Cerdas Berbasis Edge Computing` |
| `jenis_kegiatan` | `string` | **Ya (Required)** | Jenis kegiatan (Organisasi, Lomba, Seminar, Magang, UKM) | `Penelitian` |
| `peran` | `string` | **Ya (Required)** | Peran atau posisi mahasiswa dalam kegiatan | `Asisten Peneliti` |
| `tingkat` | `string` | **Ya (Required)** | Skala lingkup kegiatan (Jurusan, Polines, Regional, Nasional, Internasional) | `Nasional` |
| `tanggal_mulai` | `string (date)` | **Ya (Required)** | Tanggal pelaksanaan kegiatan dimulai | `2025-08-01` |
| `tanggal_selesai` | `string (date)` | *Tidak (Opsional / Nullable)* | Tanggal pelaksanaan kegiatan selesai | `2026-01-15` |
| `penyelenggara` | `string` | **Ya (Required)** | Instansi atau organisasi penyelenggara kegiatan | `P3M Polines` |
| `status_validasi` | `string` | **Ya (Required)** | Status persetujuan validasi (Disetujui, Pending, Ditolak) | `Disetujui` |

### 📤 4. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `8` |
| | `data.mahasiswa_id` | `integer` | **Ya (Required)** | ID referensi Mahasiswa | `226` |
| | `data.tahun_akademik_id` | `integer` | **Ya (Required)** | ID referensi Tahun Akademik | `7` |
| | `data.nama_kegiatan` | `string` | **Ya (Required)** | Nama kegiatan kemahasiswaan atau lomba | `"Riset Terapan Sistem Cerdas Berbasis Edge Computing"` |
| | `data.jenis_kegiatan` | `string` | **Ya (Required)** | Jenis kegiatan (Organisasi, Lomba, Seminar, Magang, UKM) | `"Penelitian"` |
| | `data.peran` | `string` | **Ya (Required)** | Peran atau posisi mahasiswa dalam kegiatan | `"Asisten Peneliti"` |
| | `data.tingkat` | `string` | **Ya (Required)** | Skala lingkup kegiatan (Jurusan, Polines, Regional, Nasional, Internasional) | `"Nasional"` |
| | `data.tanggal_mulai` | `string` | **Ya (Required)** | Tanggal pelaksanaan kegiatan dimulai | `"2025-08-01"` |
| | `data.tanggal_selesai` | `string` | *Tidak (Opsional / Nullable)* | Tanggal pelaksanaan kegiatan selesai | `"2026-01-15"` |
| | `data.penyelenggara` | `string` | **Ya (Required)** | Instansi atau organisasi penyelenggara kegiatan | `"P3M Polines"` |
| | `data.status_validasi` | `string` | **Ya (Required)** | Status persetujuan validasi (Disetujui, Pending, Ditolak) | `"Disetujui"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:06"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:06"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `DELETE` /api/kegiatan-mahasiswa/{id}
**Ringkasan:** Hapus Data Kegiatan Mahasiswa

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `6` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dihapus" |
| | `data` | `null / object` | *Tidak (Opsional)* | Payload hasil operasi hapus | `null` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/mahasiswa/tren
**Ringkasan:** Tren Mahasiswa

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📤 2. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `675` |
| | `data.nim` | `integer` | **Ya (Required)** | Nim | `43318225` |
| | `data.nama_mahasiswa` | `string` | **Ya (Required)** | Nama Mahasiswa | `"Ibrahim Wijaya Halim"` |
| | `data.tahun_masuk` | `integer` | **Ya (Required)** | Tahun Masuk | `2018` |
| | `data.jenis_pendaftaran` | `string` | **Ya (Required)** | Jenis Pendaftaran | `"Mandiri"` |
| | `data.tanggal_kelulusan` | `string` | *Tidak (Opsional / Nullable)* | Tanggal Kelulusan | `null` |
| | `data.masa_studi_bulan` | `integer` | **Ya (Required)** | Masa Studi Bulan | `0` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:55"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:55"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/mahasiswa
**Ringkasan:** Daftar Semua Data Mahasiswa

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📤 2. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `array[object]` | **Ya (Required)** | Koleksi daftar data entitas | `[ { ... } ]` |
| | `data[].id` | `integer` | **Ya (Required)** | Id | `675` |
| | `data[].nim` | `integer` | **Ya (Required)** | Nim | `43318225` |
| | `data[].nama_mahasiswa` | `string` | **Ya (Required)** | Nama Mahasiswa | `"Ibrahim Wijaya Halim"` |
| | `data[].tahun_masuk` | `integer` | **Ya (Required)** | Tahun Masuk | `2018` |
| | `data[].jenis_pendaftaran` | `string` | **Ya (Required)** | Jenis Pendaftaran | `"Mandiri"` |
| | `data[].tanggal_kelulusan` | `string` | *Tidak (Opsional / Nullable)* | Tanggal Kelulusan | `null` |
| | `data[].masa_studi_bulan` | `integer` | **Ya (Required)** | Masa Studi Bulan | `0` |
| | `data[].created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:55"` |
| | `data[].updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:55"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `POST` /api/mahasiswa
**Ringkasan:** Tambah Data Mahasiswa Baru

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `nim` | `integer` | **Ya** | Nomor Induk Mahasiswa (unik int) | `43318225` |
| `nama_mahasiswa` | `string` | **Ya** | Nama lengkap mahasiswa terdaftar | `Ibrahim Wijaya Halim` |
| `tahun_masuk` | `integer` | **Ya** | Tahun kalender mahasiswa pertama kali terdaftar | `2018` |
| `jenis_pendaftaran` | `string` | **Ya** | Jalur penerimaan mahasiswa (Reguler, SNBP, SNBT, Mandiri) | `Mandiri` |
| `tanggal_kelulusan` | `string (date)` | Tidak | Tanggal kelulusan resmi yudisium mahasiswa | `2028-09-13` |
| `masa_studi_bulan` | `integer` | **Ya** | Lama masa studi mahasiswa dalam satuan bulan | `0` |

##### Contoh Payload Request:
```json
{
  "nim": 43318225,
  "nama_mahasiswa": "Ibrahim Wijaya Halim",
  "tahun_masuk": 2018,
  "jenis_pendaftaran": "Mandiri",
  "tanggal_kelulusan": "2028-09-13",
  "masa_studi_bulan": 0
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📥 2. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `nim` | `integer` | **Ya (Required)** | Nomor Induk Mahasiswa (unik int) | `43318225` |
| `nama_mahasiswa` | `string` | **Ya (Required)** | Nama lengkap mahasiswa terdaftar | `Ibrahim Wijaya Halim` |
| `tahun_masuk` | `integer` | **Ya (Required)** | Tahun kalender mahasiswa pertama kali terdaftar | `2018` |
| `jenis_pendaftaran` | `string` | **Ya (Required)** | Jalur penerimaan mahasiswa (Reguler, SNBP, SNBT, Mandiri) | `Mandiri` |
| `tanggal_kelulusan` | `string (date)` | *Tidak (Opsional / Nullable)* | Tanggal kelulusan resmi yudisium mahasiswa | `2028-09-13` |
| `masa_studi_bulan` | `integer` | **Ya (Required)** | Lama masa studi mahasiswa dalam satuan bulan | `0` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **201 Created** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (201) | `201` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dibuat" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `675` |
| | `data.nim` | `integer` | **Ya (Required)** | Nomor Induk Mahasiswa (unik int) | `43318225` |
| | `data.nama_mahasiswa` | `string` | **Ya (Required)** | Nama lengkap mahasiswa terdaftar | `"Ibrahim Wijaya Halim"` |
| | `data.tahun_masuk` | `integer` | **Ya (Required)** | Tahun kalender mahasiswa pertama kali terdaftar | `2018` |
| | `data.jenis_pendaftaran` | `string` | **Ya (Required)** | Jalur penerimaan mahasiswa (Reguler, SNBP, SNBT, Mandiri) | `"Mandiri"` |
| | `data.tanggal_kelulusan` | `string` | *Tidak (Opsional / Nullable)* | Tanggal kelulusan resmi yudisium mahasiswa | `null` |
| | `data.masa_studi_bulan` | `integer` | **Ya (Required)** | Lama masa studi mahasiswa dalam satuan bulan | `0` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:55"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:55"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/mahasiswa/{id}
**Ringkasan:** Detail Data Mahasiswa

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `601` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `675` |
| | `data.nim` | `integer` | **Ya (Required)** | Nim | `43318225` |
| | `data.nama_mahasiswa` | `string` | **Ya (Required)** | Nama Mahasiswa | `"Ibrahim Wijaya Halim"` |
| | `data.tahun_masuk` | `integer` | **Ya (Required)** | Tahun Masuk | `2018` |
| | `data.jenis_pendaftaran` | `string` | **Ya (Required)** | Jenis Pendaftaran | `"Mandiri"` |
| | `data.tanggal_kelulusan` | `string` | *Tidak (Opsional / Nullable)* | Tanggal Kelulusan | `null` |
| | `data.masa_studi_bulan` | `integer` | **Ya (Required)** | Masa Studi Bulan | `0` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:55"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:55"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `PUT` /api/mahasiswa/{id}
**Ringkasan:** Perbarui Data Mahasiswa

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `nim` | `integer` | **Ya** | Nomor Induk Mahasiswa (unik int) | `43318225` |
| `nama_mahasiswa` | `string` | **Ya** | Nama lengkap mahasiswa terdaftar | `Ibrahim Wijaya Halim` |
| `tahun_masuk` | `integer` | **Ya** | Tahun kalender mahasiswa pertama kali terdaftar | `2018` |
| `jenis_pendaftaran` | `string` | **Ya** | Jalur penerimaan mahasiswa (Reguler, SNBP, SNBT, Mandiri) | `Mandiri` |
| `tanggal_kelulusan` | `string (date)` | Tidak | Tanggal kelulusan resmi yudisium mahasiswa | `2028-09-13` |
| `masa_studi_bulan` | `integer` | **Ya** | Lama masa studi mahasiswa dalam satuan bulan | `0` |

##### Contoh Payload Request:
```json
{
  "nim": 43318225,
  "nama_mahasiswa": "Ibrahim Wijaya Halim",
  "tahun_masuk": 2018,
  "jenis_pendaftaran": "Mandiri",
  "tanggal_kelulusan": "2028-09-13",
  "masa_studi_bulan": 0
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `601` |

### 📥 3. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `nim` | `integer` | **Ya (Required)** | Nomor Induk Mahasiswa (unik int) | `43318225` |
| `nama_mahasiswa` | `string` | **Ya (Required)** | Nama lengkap mahasiswa terdaftar | `Ibrahim Wijaya Halim` |
| `tahun_masuk` | `integer` | **Ya (Required)** | Tahun kalender mahasiswa pertama kali terdaftar | `2018` |
| `jenis_pendaftaran` | `string` | **Ya (Required)** | Jalur penerimaan mahasiswa (Reguler, SNBP, SNBT, Mandiri) | `Mandiri` |
| `tanggal_kelulusan` | `string (date)` | *Tidak (Opsional / Nullable)* | Tanggal kelulusan resmi yudisium mahasiswa | `2028-09-13` |
| `masa_studi_bulan` | `integer` | **Ya (Required)** | Lama masa studi mahasiswa dalam satuan bulan | `0` |

### 📤 4. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `675` |
| | `data.nim` | `integer` | **Ya (Required)** | Nomor Induk Mahasiswa (unik int) | `43318225` |
| | `data.nama_mahasiswa` | `string` | **Ya (Required)** | Nama lengkap mahasiswa terdaftar | `"Ibrahim Wijaya Halim"` |
| | `data.tahun_masuk` | `integer` | **Ya (Required)** | Tahun kalender mahasiswa pertama kali terdaftar | `2018` |
| | `data.jenis_pendaftaran` | `string` | **Ya (Required)** | Jalur penerimaan mahasiswa (Reguler, SNBP, SNBT, Mandiri) | `"Mandiri"` |
| | `data.tanggal_kelulusan` | `string` | *Tidak (Opsional / Nullable)* | Tanggal kelulusan resmi yudisium mahasiswa | `null` |
| | `data.masa_studi_bulan` | `integer` | **Ya (Required)** | Lama masa studi mahasiswa dalam satuan bulan | `0` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:55"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:55"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `DELETE` /api/mahasiswa/{id}
**Ringkasan:** Hapus Data Mahasiswa

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `601` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dihapus" |
| | `data` | `null / object` | *Tidak (Opsional)* | Payload hasil operasi hapus | `null` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/status-mahasiswa
**Ringkasan:** Daftar Semua Data Status Mahasiswa

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📤 2. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `array[object]` | **Ya (Required)** | Koleksi daftar data entitas | `[ { ... } ]` |
| | `data[].id` | `integer` | **Ya (Required)** | Id | `3000` |
| | `data[].id_enrollment_mahasiswa_angkatan_kelas` | `integer` | **Ya (Required)** | Id Enrollment Mahasiswa Angkatan Kelas | `3000` |
| | `data[].status` | `string` | **Ya (Required)** | Status | `"Drop Out"` |
| | `data[].created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:02"` |
| | `data[].updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:02"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `POST` /api/status-mahasiswa
**Ringkasan:** Tambah Data Status Mahasiswa Baru

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `id_enrollment_mahasiswa_angkatan_kelas` | `integer` | **Ya** | ID referensi Enrollment Mahasiswa Angkatan Kelas | `3000` |
| `status` | `string` | **Ya** | Status keaktifan mahasiswa (Aktif, Cuti, Lulus) | `Drop Out` |

##### Contoh Payload Request:
```json
{
  "id_enrollment_mahasiswa_angkatan_kelas": 3000,
  "status": "Drop Out"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📥 2. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `id_enrollment_mahasiswa_angkatan_kelas` | `integer` | **Ya (Required)** | ID referensi Enrollment Mahasiswa Angkatan Kelas | `3000` |
| `status` | `string` | **Ya (Required)** | Status keaktifan mahasiswa (Aktif, Cuti, Lulus) | `Drop Out` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **201 Created** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (201) | `201` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dibuat" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `3000` |
| | `data.id_enrollment_mahasiswa_angkatan_kelas` | `integer` | **Ya (Required)** | ID referensi Enrollment Mahasiswa Angkatan Kelas | `3000` |
| | `data.status` | `string` | **Ya (Required)** | Status keaktifan mahasiswa (Aktif, Cuti, Lulus) | `"Drop Out"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:02"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:02"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/status-mahasiswa/{id}
**Ringkasan:** Detail Data Status Mahasiswa

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `3000` |
| | `data.id_enrollment_mahasiswa_angkatan_kelas` | `integer` | **Ya (Required)** | Id Enrollment Mahasiswa Angkatan Kelas | `3000` |
| | `data.status` | `string` | **Ya (Required)** | Status | `"Drop Out"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:02"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:02"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `PUT` /api/status-mahasiswa/{id}
**Ringkasan:** Perbarui Data Status Mahasiswa

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `id_enrollment_mahasiswa_angkatan_kelas` | `integer` | **Ya** | ID referensi Enrollment Mahasiswa Angkatan Kelas | `3000` |
| `status` | `string` | **Ya** | Status keaktifan mahasiswa (Aktif, Cuti, Lulus) | `Drop Out` |

##### Contoh Payload Request:
```json
{
  "id_enrollment_mahasiswa_angkatan_kelas": 3000,
  "status": "Drop Out"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📥 3. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `id_enrollment_mahasiswa_angkatan_kelas` | `integer` | **Ya (Required)** | ID referensi Enrollment Mahasiswa Angkatan Kelas | `3000` |
| `status` | `string` | **Ya (Required)** | Status keaktifan mahasiswa (Aktif, Cuti, Lulus) | `Drop Out` |

### 📤 4. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `3000` |
| | `data.id_enrollment_mahasiswa_angkatan_kelas` | `integer` | **Ya (Required)** | ID referensi Enrollment Mahasiswa Angkatan Kelas | `3000` |
| | `data.status` | `string` | **Ya (Required)** | Status keaktifan mahasiswa (Aktif, Cuti, Lulus) | `"Drop Out"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:02"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:02"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `DELETE` /api/status-mahasiswa/{id}
**Ringkasan:** Hapus Data Status Mahasiswa

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dihapus" |
| | `data` | `null / object` | *Tidak (Opsional)* | Payload hasil operasi hapus | `null` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

## Perkuliahan & Penilaian
> Modul: **Perkuliahan & Penilaian** | Jumlah: 23 endpoint

### `GET` /api/enrollment-mata-kuliah
**Ringkasan:** Daftar Semua Data Enrollment Mata Kuliah

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📤 2. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `array[object]` | **Ya (Required)** | Koleksi daftar data entitas | `[ { ... } ]` |
| | `data[].id` | `integer` | **Ya (Required)** | Id | `260` |
| | `data[].tahun_akademik_id` | `integer` | **Ya (Required)** | Tahun Akademik Id | `10` |
| | `data[].mata_kuliah_id` | `integer` | **Ya (Required)** | Mata Kuliah Id | `52` |
| | `data[].dosen_id` | `integer` | **Ya (Required)** | Dosen Id | `10` |
| | `data[].evidence` | `integer` | **Ya (Required)** | Evidence | `1` |
| | `data[].mata_kuliah_angkatan_kelas_id` | `string` | *Tidak (Opsional / Nullable)* | Mata Kuliah Angkatan Kelas Id | `null` |
| | `data[].created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:32"` |
| | `data[].updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:32"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `POST` /api/enrollment-mata-kuliah
**Ringkasan:** Tambah Data Enrollment Mata Kuliah Baru

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `tahun_akademik_id` | `integer` | **Ya** | ID referensi Tahun Akademik | `10` |
| `mata_kuliah_id` | `integer` | **Ya** | ID referensi Mata Kuliah | `52` |
| `dosen_id` | `integer` | Tidak | ID referensi Dosen pengampu (User) | `10` |
| `evidence` | `string` | Tidak | Nama file atau link berkas bukti sertifikat pendukung | `1` |
| `mata_kuliah_angkatan_kelas_id` | `integer` | Tidak | ID referensi penawaran mata kuliah pada angkatan kelas | `10` |

##### Contoh Payload Request:
```json
{
  "tahun_akademik_id": 10,
  "mata_kuliah_id": 52,
  "dosen_id": 10,
  "evidence": "1",
  "mata_kuliah_angkatan_kelas_id": 10
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📥 2. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `tahun_akademik_id` | `integer` | **Ya (Required)** | ID referensi Tahun Akademik | `10` |
| `mata_kuliah_id` | `integer` | **Ya (Required)** | ID referensi Mata Kuliah | `52` |
| `dosen_id` | `integer` | *Tidak (Opsional / Nullable)* | ID referensi Dosen pengampu (User) | `10` |
| `evidence` | `string` | *Tidak (Opsional / Nullable)* | Nama file atau link berkas bukti sertifikat pendukung | `1` |
| `mata_kuliah_angkatan_kelas_id` | `integer` | *Tidak (Opsional / Nullable)* | ID referensi penawaran mata kuliah pada angkatan kelas | `10` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **201 Created** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (201) | `201` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dibuat" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `260` |
| | `data.tahun_akademik_id` | `integer` | **Ya (Required)** | ID referensi Tahun Akademik | `10` |
| | `data.mata_kuliah_id` | `integer` | **Ya (Required)** | ID referensi Mata Kuliah | `52` |
| | `data.dosen_id` | `integer` | *Tidak (Opsional / Nullable)* | ID referensi Dosen pengampu (User) | `10` |
| | `data.evidence` | `integer` | *Tidak (Opsional / Nullable)* | Nama file atau link berkas bukti sertifikat pendukung | `1` |
| | `data.mata_kuliah_angkatan_kelas_id` | `string` | *Tidak (Opsional / Nullable)* | ID referensi penawaran mata kuliah pada angkatan kelas | `null` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:32"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:32"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/enrollment-mata-kuliah/{id}
**Ringkasan:** Detail Data Enrollment Mata Kuliah

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `260` |
| | `data.tahun_akademik_id` | `integer` | **Ya (Required)** | Tahun Akademik Id | `10` |
| | `data.mata_kuliah_id` | `integer` | **Ya (Required)** | Mata Kuliah Id | `52` |
| | `data.dosen_id` | `integer` | **Ya (Required)** | Dosen Id | `10` |
| | `data.evidence` | `integer` | **Ya (Required)** | Evidence | `1` |
| | `data.mata_kuliah_angkatan_kelas_id` | `string` | *Tidak (Opsional / Nullable)* | Mata Kuliah Angkatan Kelas Id | `null` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:32"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:32"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `PUT` /api/enrollment-mata-kuliah/{id}
**Ringkasan:** Perbarui Data Enrollment Mata Kuliah

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `tahun_akademik_id` | `integer` | **Ya** | ID referensi Tahun Akademik | `10` |
| `mata_kuliah_id` | `integer` | **Ya** | ID referensi Mata Kuliah | `52` |
| `dosen_id` | `integer` | Tidak | ID referensi Dosen pengampu (User) | `10` |
| `evidence` | `string` | Tidak | Nama file atau link berkas bukti sertifikat pendukung | `1` |
| `mata_kuliah_angkatan_kelas_id` | `integer` | Tidak | ID referensi penawaran mata kuliah pada angkatan kelas | `10` |

##### Contoh Payload Request:
```json
{
  "tahun_akademik_id": 10,
  "mata_kuliah_id": 52,
  "dosen_id": 10,
  "evidence": "1",
  "mata_kuliah_angkatan_kelas_id": 10
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📥 3. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `tahun_akademik_id` | `integer` | **Ya (Required)** | ID referensi Tahun Akademik | `10` |
| `mata_kuliah_id` | `integer` | **Ya (Required)** | ID referensi Mata Kuliah | `52` |
| `dosen_id` | `integer` | *Tidak (Opsional / Nullable)* | ID referensi Dosen pengampu (User) | `10` |
| `evidence` | `string` | *Tidak (Opsional / Nullable)* | Nama file atau link berkas bukti sertifikat pendukung | `1` |
| `mata_kuliah_angkatan_kelas_id` | `integer` | *Tidak (Opsional / Nullable)* | ID referensi penawaran mata kuliah pada angkatan kelas | `10` |

### 📤 4. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `260` |
| | `data.tahun_akademik_id` | `integer` | **Ya (Required)** | ID referensi Tahun Akademik | `10` |
| | `data.mata_kuliah_id` | `integer` | **Ya (Required)** | ID referensi Mata Kuliah | `52` |
| | `data.dosen_id` | `integer` | *Tidak (Opsional / Nullable)* | ID referensi Dosen pengampu (User) | `10` |
| | `data.evidence` | `integer` | *Tidak (Opsional / Nullable)* | Nama file atau link berkas bukti sertifikat pendukung | `1` |
| | `data.mata_kuliah_angkatan_kelas_id` | `string` | *Tidak (Opsional / Nullable)* | ID referensi penawaran mata kuliah pada angkatan kelas | `null` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:32"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:32"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `DELETE` /api/enrollment-mata-kuliah/{id}
**Ringkasan:** Hapus Data Enrollment Mata Kuliah

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dihapus" |
| | `data` | `null / object` | *Tidak (Opsional)* | Payload hasil operasi hapus | `null` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/mata-kuliah-angkatan-kelas
**Ringkasan:** Daftar Semua Data Mata Kuliah Angkatan Kelas

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📤 2. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `array[object]` | **Ya (Required)** | Koleksi daftar data entitas | `[ { ... } ]` |
| | `data[].id` | `integer` | **Ya (Required)** | Id | `354` |
| | `data[].enrollment_mata_kuliah_id` | `integer` | **Ya (Required)** | Enrollment Mata Kuliah Id | `255` |
| | `data[].angkatan_kelas_id` | `integer` | **Ya (Required)** | Angkatan Kelas Id | `108` |
| | `data[].created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:32"` |
| | `data[].updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:32"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `POST` /api/mata-kuliah-angkatan-kelas
**Ringkasan:** Tambah Data Mata Kuliah Angkatan Kelas Baru

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `enrollment_mata_kuliah_id` | `integer` | **Ya** | ID referensi Penawaran Enrollment Mata Kuliah | `255` |
| `angkatan_kelas_id` | `integer` | **Ya** | ID referensi Angkatan Kelas | `108` |

##### Contoh Payload Request:
```json
{
  "enrollment_mata_kuliah_id": 255,
  "angkatan_kelas_id": 108
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📥 2. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `enrollment_mata_kuliah_id` | `integer` | **Ya (Required)** | ID referensi Penawaran Enrollment Mata Kuliah | `255` |
| `angkatan_kelas_id` | `integer` | **Ya (Required)** | ID referensi Angkatan Kelas | `108` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **201 Created** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (201) | `201` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dibuat" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `354` |
| | `data.enrollment_mata_kuliah_id` | `integer` | **Ya (Required)** | ID referensi Penawaran Enrollment Mata Kuliah | `255` |
| | `data.angkatan_kelas_id` | `integer` | **Ya (Required)** | ID referensi Angkatan Kelas | `108` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:32"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:32"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/mata-kuliah-angkatan-kelas/{id}
**Ringkasan:** Detail Data Mata Kuliah Angkatan Kelas

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `10` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `354` |
| | `data.enrollment_mata_kuliah_id` | `integer` | **Ya (Required)** | Enrollment Mata Kuliah Id | `255` |
| | `data.angkatan_kelas_id` | `integer` | **Ya (Required)** | Angkatan Kelas Id | `108` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:32"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:32"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `PUT` /api/mata-kuliah-angkatan-kelas/{id}
**Ringkasan:** Perbarui Data Mata Kuliah Angkatan Kelas

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `enrollment_mata_kuliah_id` | `integer` | **Ya** | ID referensi Penawaran Enrollment Mata Kuliah | `255` |
| `angkatan_kelas_id` | `integer` | **Ya** | ID referensi Angkatan Kelas | `108` |

##### Contoh Payload Request:
```json
{
  "enrollment_mata_kuliah_id": 255,
  "angkatan_kelas_id": 108
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `10` |

### 📥 3. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `enrollment_mata_kuliah_id` | `integer` | **Ya (Required)** | ID referensi Penawaran Enrollment Mata Kuliah | `255` |
| `angkatan_kelas_id` | `integer` | **Ya (Required)** | ID referensi Angkatan Kelas | `108` |

### 📤 4. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `354` |
| | `data.enrollment_mata_kuliah_id` | `integer` | **Ya (Required)** | ID referensi Penawaran Enrollment Mata Kuliah | `255` |
| | `data.angkatan_kelas_id` | `integer` | **Ya (Required)** | ID referensi Angkatan Kelas | `108` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:32"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:32"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `DELETE` /api/mata-kuliah-angkatan-kelas/{id}
**Ringkasan:** Hapus Data Mata Kuliah Angkatan Kelas

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `10` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dihapus" |
| | `data` | `null / object` | *Tidak (Opsional)* | Payload hasil operasi hapus | `null` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/nilai-mahasiswa
**Ringkasan:** Daftar Semua Data Nilai Mahasiswa

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📤 2. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `array[object]` | **Ya (Required)** | Koleksi daftar data entitas | `[ { ... } ]` |
| | `data[].id` | `integer` | **Ya (Required)** | Id | `6825` |
| | `data[].mata_kuliah_angkatan_kelas_id` | `integer` | **Ya (Required)** | Mata Kuliah Angkatan Kelas Id | `336` |
| | `data[].mahasiswa_id` | `integer` | **Ya (Required)** | Mahasiswa Id | `300` |
| | `data[].tahun_akademik_id` | `integer` | **Ya (Required)** | Tahun Akademik Id | `8` |
| | `data[].nilai_angka` | `string` | **Ya (Required)** | Nilai Angka | `"80.52"` |
| | `data[].nilai_huruf` | `string` | **Ya (Required)** | Nilai Huruf | `"A"` |
| | `data[].bobot` | `string` | **Ya (Required)** | Bobot | `"4.00"` |
| | `data[].link_nilai` | `string` | *Tidak (Opsional / Nullable)* | Link Nilai | `null` |
| | `data[].link_evidence` | `string` | *Tidak (Opsional / Nullable)* | Link Evidence | `null` |
| | `data[].created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:33"` |
| | `data[].updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:33"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `POST` /api/nilai-mahasiswa
**Ringkasan:** Tambah Data Nilai Mahasiswa Baru

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `mata_kuliah_angkatan_kelas_id` | `integer` | **Ya** | ID referensi penawaran mata kuliah pada angkatan kelas | `336` |
| `mahasiswa_id` | `integer` | **Ya** | ID referensi Mahasiswa | `300` |
| `tahun_akademik_id` | `integer` | Tidak | ID referensi Tahun Akademik | `8` |
| `nilai_angka` | `number` | Tidak | Nilai capaian akademik mahasiswa dalam format angka (0.00 - 100.00) | `80.52` |
| `nilai_huruf` | `string` | Tidak | Indeks prestasi huruf mutu (A, AB, B, BC, C, D, E) | `A` |
| `bobot` | `integer` | Tidak | Bobot | `4` |
| `link_nilai` | `string` | Tidak | Link Nilai | `Contoh Link Nilai` |
| `link_evidence` | `string` | Tidak | Link Evidence | `Contoh Link Evidence` |

##### Contoh Payload Request:
```json
{
  "mata_kuliah_angkatan_kelas_id": 336,
  "mahasiswa_id": 300,
  "tahun_akademik_id": 8,
  "nilai_angka": 80.52,
  "nilai_huruf": "A",
  "bobot": 4,
  "link_nilai": "Contoh Link Nilai",
  "link_evidence": "Contoh Link Evidence"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📥 2. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `mata_kuliah_angkatan_kelas_id` | `integer` | **Ya (Required)** | ID referensi penawaran mata kuliah pada angkatan kelas | `336` |
| `mahasiswa_id` | `integer` | **Ya (Required)** | ID referensi Mahasiswa | `300` |
| `tahun_akademik_id` | `integer` | *Tidak (Opsional / Nullable)* | ID referensi Tahun Akademik | `8` |
| `nilai_angka` | `number` | *Tidak (Opsional / Nullable)* | Nilai capaian akademik mahasiswa dalam format angka (0.00 - 100.00) | `80.52` |
| `nilai_huruf` | `string` | *Tidak (Opsional / Nullable)* | Indeks prestasi huruf mutu (A, AB, B, BC, C, D, E) | `A` |
| `bobot` | `integer` | *Tidak (Opsional / Nullable)* | Bobot | `4` |
| `link_nilai` | `string` | *Tidak (Opsional / Nullable)* | Link Nilai | `Contoh Link Nilai` |
| `link_evidence` | `string` | *Tidak (Opsional / Nullable)* | Link Evidence | `Contoh Link Evidence` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **201 Created** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (201) | `201` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dibuat" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `6825` |
| | `data.mata_kuliah_angkatan_kelas_id` | `integer` | **Ya (Required)** | ID referensi penawaran mata kuliah pada angkatan kelas | `336` |
| | `data.mahasiswa_id` | `integer` | **Ya (Required)** | ID referensi Mahasiswa | `300` |
| | `data.tahun_akademik_id` | `integer` | *Tidak (Opsional / Nullable)* | ID referensi Tahun Akademik | `8` |
| | `data.nilai_angka` | `string` | *Tidak (Opsional / Nullable)* | Nilai capaian akademik mahasiswa dalam format angka (0.00 - 100.00) | `"80.52"` |
| | `data.nilai_huruf` | `string` | *Tidak (Opsional / Nullable)* | Indeks prestasi huruf mutu (A, AB, B, BC, C, D, E) | `"A"` |
| | `data.bobot` | `string` | *Tidak (Opsional / Nullable)* | Bobot | `"4.00"` |
| | `data.link_nilai` | `string` | *Tidak (Opsional / Nullable)* | Link Nilai | `null` |
| | `data.link_evidence` | `string` | *Tidak (Opsional / Nullable)* | Link Evidence | `null` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:33"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:33"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/nilai-mahasiswa/template
**Ringkasan:** Download Template Nilai Mahasiswa

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📤 2. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `6825` |
| | `data.mata_kuliah_angkatan_kelas_id` | `integer` | **Ya (Required)** | Mata Kuliah Angkatan Kelas Id | `336` |
| | `data.mahasiswa_id` | `integer` | **Ya (Required)** | Mahasiswa Id | `300` |
| | `data.tahun_akademik_id` | `integer` | **Ya (Required)** | Tahun Akademik Id | `8` |
| | `data.nilai_angka` | `string` | **Ya (Required)** | Nilai Angka | `"80.52"` |
| | `data.nilai_huruf` | `string` | **Ya (Required)** | Nilai Huruf | `"A"` |
| | `data.bobot` | `string` | **Ya (Required)** | Bobot | `"4.00"` |
| | `data.link_nilai` | `string` | *Tidak (Opsional / Nullable)* | Link Nilai | `null` |
| | `data.link_evidence` | `string` | *Tidak (Opsional / Nullable)* | Link Evidence | `null` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:33"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:33"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `POST` /api/nilai-mahasiswa/import
**Ringkasan:** Import Excel Nilai Mahasiswa

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `file` | `string` | **Ya** | File | `Contoh File` |
| `mata_kuliah_angkatan_kelas_id` | `integer` | Tidak | ID referensi penawaran mata kuliah pada angkatan kelas | `336` |
| `tahun_akademik_id` | `integer` | Tidak | ID referensi Tahun Akademik | `8` |
| `duplicate_action` | `string (date)` | Tidak | Duplicate Action | `Contoh Duplicate Action` |
| `mahasiswa_id` | `integer` | **Ya** | ID referensi Mahasiswa | `300` |
| `nilai_angka` | `number` | **Ya** | Nilai capaian akademik mahasiswa dalam format angka (0.00 - 100.00) | `80.52` |
| `nilai_huruf` | `string` | **Ya** | Indeks prestasi huruf mutu (A, AB, B, BC, C, D, E) | `A` |
| `bobot` | `string` | **Ya** | Bobot | `4.00` |
| `link_nilai` | `string` | **Ya** | Link Nilai | `Contoh Link Nilai` |
| `link_evidence` | `string` | **Ya** | Link Evidence | `Contoh Link Evidence` |

##### Contoh Payload Request:
```json
{
  "file": "Contoh File",
  "mata_kuliah_angkatan_kelas_id": 336,
  "tahun_akademik_id": 8,
  "duplicate_action": "Contoh Duplicate Action",
  "mahasiswa_id": 300,
  "nilai_angka": 80.52,
  "nilai_huruf": "A",
  "bobot": "4.00",
  "link_nilai": "Contoh Link Nilai",
  "link_evidence": "Contoh Link Evidence"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📥 2. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `file` | `string` | **Ya (Required)** | File | `Contoh File` |
| `mata_kuliah_angkatan_kelas_id` | `integer` | *Tidak (Opsional / Nullable)* | ID referensi penawaran mata kuliah pada angkatan kelas | `336` |
| `tahun_akademik_id` | `integer` | *Tidak (Opsional / Nullable)* | ID referensi Tahun Akademik | `8` |
| `duplicate_action` | `string (date)` | *Tidak (Opsional / Nullable)* | Duplicate Action | `Contoh Duplicate Action` |
| `mahasiswa_id` | `integer` | **Ya (Required)** | ID referensi Mahasiswa | `300` |
| `nilai_angka` | `number` | **Ya (Required)** | Nilai capaian akademik mahasiswa dalam format angka (0.00 - 100.00) | `80.52` |
| `nilai_huruf` | `string` | **Ya (Required)** | Indeks prestasi huruf mutu (A, AB, B, BC, C, D, E) | `A` |
| `bobot` | `string` | **Ya (Required)** | Bobot | `4.00` |
| `link_nilai` | `string` | **Ya (Required)** | Link Nilai | `Contoh Link Nilai` |
| `link_evidence` | `string` | **Ya (Required)** | Link Evidence | `Contoh Link Evidence` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **201 Created** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (201) | `201` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dibuat" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `6825` |
| | `data.mata_kuliah_angkatan_kelas_id` | `integer` | *Tidak (Opsional / Nullable)* | ID referensi penawaran mata kuliah pada angkatan kelas | `336` |
| | `data.mahasiswa_id` | `integer` | **Ya (Required)** | ID referensi Mahasiswa | `300` |
| | `data.tahun_akademik_id` | `integer` | *Tidak (Opsional / Nullable)* | ID referensi Tahun Akademik | `8` |
| | `data.nilai_angka` | `string` | **Ya (Required)** | Nilai capaian akademik mahasiswa dalam format angka (0.00 - 100.00) | `"80.52"` |
| | `data.nilai_huruf` | `string` | **Ya (Required)** | Indeks prestasi huruf mutu (A, AB, B, BC, C, D, E) | `"A"` |
| | `data.bobot` | `string` | **Ya (Required)** | Bobot | `"4.00"` |
| | `data.link_nilai` | `string` | *Tidak (Opsional / Nullable)* | Link Nilai | `null` |
| | `data.link_evidence` | `string` | *Tidak (Opsional / Nullable)* | Link Evidence | `null` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:33"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:33"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `POST` /api/nilai-mahasiswa/batch
**Ringkasan:** Batch Store Nilai Mahasiswa

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `mata_kuliah_angkatan_kelas_id` | `integer` | **Ya** | ID referensi penawaran mata kuliah pada angkatan kelas | `336` |
| `tahun_akademik_id` | `integer` | Tidak | ID referensi Tahun Akademik | `8` |
| `nilai` | `string` | **Ya** | Nilai | `Contoh Nilai` |
| `mahasiswa_id` | `integer` | **Ya** | ID referensi Mahasiswa | `300` |
| `nilai_angka` | `number` | **Ya** | Nilai capaian akademik mahasiswa dalam format angka (0.00 - 100.00) | `80.52` |
| `nilai_huruf` | `string` | **Ya** | Indeks prestasi huruf mutu (A, AB, B, BC, C, D, E) | `A` |
| `bobot` | `string` | **Ya** | Bobot | `4.00` |
| `link_nilai` | `string` | **Ya** | Link Nilai | `Contoh Link Nilai` |
| `link_evidence` | `string` | **Ya** | Link Evidence | `Contoh Link Evidence` |

##### Contoh Payload Request:
```json
{
  "mata_kuliah_angkatan_kelas_id": 336,
  "tahun_akademik_id": 8,
  "nilai": "Contoh Nilai",
  "mahasiswa_id": 300,
  "nilai_angka": 80.52,
  "nilai_huruf": "A",
  "bobot": "4.00",
  "link_nilai": "Contoh Link Nilai",
  "link_evidence": "Contoh Link Evidence"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📥 2. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `mata_kuliah_angkatan_kelas_id` | `integer` | **Ya (Required)** | ID referensi penawaran mata kuliah pada angkatan kelas | `336` |
| `tahun_akademik_id` | `integer` | *Tidak (Opsional / Nullable)* | ID referensi Tahun Akademik | `8` |
| `nilai` | `string` | **Ya (Required)** | Nilai | `Contoh Nilai` |
| `mahasiswa_id` | `integer` | **Ya (Required)** | ID referensi Mahasiswa | `300` |
| `nilai_angka` | `number` | **Ya (Required)** | Nilai capaian akademik mahasiswa dalam format angka (0.00 - 100.00) | `80.52` |
| `nilai_huruf` | `string` | **Ya (Required)** | Indeks prestasi huruf mutu (A, AB, B, BC, C, D, E) | `A` |
| `bobot` | `string` | **Ya (Required)** | Bobot | `4.00` |
| `link_nilai` | `string` | **Ya (Required)** | Link Nilai | `Contoh Link Nilai` |
| `link_evidence` | `string` | **Ya (Required)** | Link Evidence | `Contoh Link Evidence` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **201 Created** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (201) | `201` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dibuat" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `6825` |
| | `data.mata_kuliah_angkatan_kelas_id` | `integer` | **Ya (Required)** | ID referensi penawaran mata kuliah pada angkatan kelas | `336` |
| | `data.mahasiswa_id` | `integer` | **Ya (Required)** | ID referensi Mahasiswa | `300` |
| | `data.tahun_akademik_id` | `integer` | *Tidak (Opsional / Nullable)* | ID referensi Tahun Akademik | `8` |
| | `data.nilai_angka` | `string` | **Ya (Required)** | Nilai capaian akademik mahasiswa dalam format angka (0.00 - 100.00) | `"80.52"` |
| | `data.nilai_huruf` | `string` | **Ya (Required)** | Indeks prestasi huruf mutu (A, AB, B, BC, C, D, E) | `"A"` |
| | `data.bobot` | `string` | **Ya (Required)** | Bobot | `"4.00"` |
| | `data.link_nilai` | `string` | *Tidak (Opsional / Nullable)* | Link Nilai | `null` |
| | `data.link_evidence` | `string` | *Tidak (Opsional / Nullable)* | Link Evidence | `null` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:33"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:33"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/nilai-mahasiswa/{id}
**Ringkasan:** Detail Data Nilai Mahasiswa

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `6825` |
| | `data.mata_kuliah_angkatan_kelas_id` | `integer` | **Ya (Required)** | Mata Kuliah Angkatan Kelas Id | `336` |
| | `data.mahasiswa_id` | `integer` | **Ya (Required)** | Mahasiswa Id | `300` |
| | `data.tahun_akademik_id` | `integer` | **Ya (Required)** | Tahun Akademik Id | `8` |
| | `data.nilai_angka` | `string` | **Ya (Required)** | Nilai Angka | `"80.52"` |
| | `data.nilai_huruf` | `string` | **Ya (Required)** | Nilai Huruf | `"A"` |
| | `data.bobot` | `string` | **Ya (Required)** | Bobot | `"4.00"` |
| | `data.link_nilai` | `string` | *Tidak (Opsional / Nullable)* | Link Nilai | `null` |
| | `data.link_evidence` | `string` | *Tidak (Opsional / Nullable)* | Link Evidence | `null` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:33"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:33"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `PUT` /api/nilai-mahasiswa/{id}
**Ringkasan:** Perbarui Data Nilai Mahasiswa

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `mata_kuliah_angkatan_kelas_id` | `integer` | **Ya** | ID referensi penawaran mata kuliah pada angkatan kelas | `336` |
| `mahasiswa_id` | `integer` | **Ya** | ID referensi Mahasiswa | `300` |
| `tahun_akademik_id` | `integer` | **Ya** | ID referensi Tahun Akademik | `8` |
| `nilai_angka` | `number` | Tidak | Nilai capaian akademik mahasiswa dalam format angka (0.00 - 100.00) | `80.52` |
| `nilai_huruf` | `string` | Tidak | Indeks prestasi huruf mutu (A, AB, B, BC, C, D, E) | `A` |
| `bobot` | `integer` | Tidak | Bobot | `4` |
| `link_nilai` | `string` | Tidak | Link Nilai | `Contoh Link Nilai` |
| `link_evidence` | `string` | Tidak | Link Evidence | `Contoh Link Evidence` |

##### Contoh Payload Request:
```json
{
  "mata_kuliah_angkatan_kelas_id": 336,
  "mahasiswa_id": 300,
  "tahun_akademik_id": 8,
  "nilai_angka": 80.52,
  "nilai_huruf": "A",
  "bobot": 4,
  "link_nilai": "Contoh Link Nilai",
  "link_evidence": "Contoh Link Evidence"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📥 3. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `mata_kuliah_angkatan_kelas_id` | `integer` | **Ya (Required)** | ID referensi penawaran mata kuliah pada angkatan kelas | `336` |
| `mahasiswa_id` | `integer` | **Ya (Required)** | ID referensi Mahasiswa | `300` |
| `tahun_akademik_id` | `integer` | **Ya (Required)** | ID referensi Tahun Akademik | `8` |
| `nilai_angka` | `number` | *Tidak (Opsional / Nullable)* | Nilai capaian akademik mahasiswa dalam format angka (0.00 - 100.00) | `80.52` |
| `nilai_huruf` | `string` | *Tidak (Opsional / Nullable)* | Indeks prestasi huruf mutu (A, AB, B, BC, C, D, E) | `A` |
| `bobot` | `integer` | *Tidak (Opsional / Nullable)* | Bobot | `4` |
| `link_nilai` | `string` | *Tidak (Opsional / Nullable)* | Link Nilai | `Contoh Link Nilai` |
| `link_evidence` | `string` | *Tidak (Opsional / Nullable)* | Link Evidence | `Contoh Link Evidence` |

### 📤 4. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `6825` |
| | `data.mata_kuliah_angkatan_kelas_id` | `integer` | **Ya (Required)** | ID referensi penawaran mata kuliah pada angkatan kelas | `336` |
| | `data.mahasiswa_id` | `integer` | **Ya (Required)** | ID referensi Mahasiswa | `300` |
| | `data.tahun_akademik_id` | `integer` | **Ya (Required)** | ID referensi Tahun Akademik | `8` |
| | `data.nilai_angka` | `string` | *Tidak (Opsional / Nullable)* | Nilai capaian akademik mahasiswa dalam format angka (0.00 - 100.00) | `"80.52"` |
| | `data.nilai_huruf` | `string` | *Tidak (Opsional / Nullable)* | Indeks prestasi huruf mutu (A, AB, B, BC, C, D, E) | `"A"` |
| | `data.bobot` | `string` | *Tidak (Opsional / Nullable)* | Bobot | `"4.00"` |
| | `data.link_nilai` | `string` | *Tidak (Opsional / Nullable)* | Link Nilai | `null` |
| | `data.link_evidence` | `string` | *Tidak (Opsional / Nullable)* | Link Evidence | `null` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:33"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:33"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `DELETE` /api/nilai-mahasiswa/{id}
**Ringkasan:** Hapus Data Nilai Mahasiswa

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dihapus" |
| | `data` | `null / object` | *Tidak (Opsional)* | Payload hasil operasi hapus | `null` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `PATCH` /api/nilai-mahasiswa/{id}/link-nilai
**Ringkasan:** Update Link Nilai Nilai Mahasiswa

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `link_nilai` | `string` | **Ya** | Link Nilai | `Contoh Link Nilai` |
| `mata_kuliah_angkatan_kelas_id` | `integer` | Tidak | ID referensi penawaran mata kuliah pada angkatan kelas | `336` |
| `mahasiswa_id` | `integer` | **Ya** | ID referensi Mahasiswa | `300` |
| `tahun_akademik_id` | `integer` | **Ya** | ID referensi Tahun Akademik | `8` |
| `nilai_angka` | `number` | **Ya** | Nilai capaian akademik mahasiswa dalam format angka (0.00 - 100.00) | `80.52` |
| `nilai_huruf` | `string` | **Ya** | Indeks prestasi huruf mutu (A, AB, B, BC, C, D, E) | `A` |
| `bobot` | `string` | **Ya** | Bobot | `4.00` |
| `link_evidence` | `string` | **Ya** | Link Evidence | `Contoh Link Evidence` |

##### Contoh Payload Request:
```json
{
  "link_nilai": "Contoh Link Nilai",
  "mata_kuliah_angkatan_kelas_id": 336,
  "mahasiswa_id": 300,
  "tahun_akademik_id": 8,
  "nilai_angka": 80.52,
  "nilai_huruf": "A",
  "bobot": "4.00",
  "link_evidence": "Contoh Link Evidence"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📥 3. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `link_nilai` | `string` | **Ya (Required)** | Link Nilai | `Contoh Link Nilai` |
| `mata_kuliah_angkatan_kelas_id` | `integer` | *Tidak (Opsional / Nullable)* | ID referensi penawaran mata kuliah pada angkatan kelas | `336` |
| `mahasiswa_id` | `integer` | **Ya (Required)** | ID referensi Mahasiswa | `300` |
| `tahun_akademik_id` | `integer` | **Ya (Required)** | ID referensi Tahun Akademik | `8` |
| `nilai_angka` | `number` | **Ya (Required)** | Nilai capaian akademik mahasiswa dalam format angka (0.00 - 100.00) | `80.52` |
| `nilai_huruf` | `string` | **Ya (Required)** | Indeks prestasi huruf mutu (A, AB, B, BC, C, D, E) | `A` |
| `bobot` | `string` | **Ya (Required)** | Bobot | `4.00` |
| `link_evidence` | `string` | **Ya (Required)** | Link Evidence | `Contoh Link Evidence` |

### 📤 4. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `6825` |
| | `data.mata_kuliah_angkatan_kelas_id` | `integer` | *Tidak (Opsional / Nullable)* | ID referensi penawaran mata kuliah pada angkatan kelas | `336` |
| | `data.mahasiswa_id` | `integer` | **Ya (Required)** | ID referensi Mahasiswa | `300` |
| | `data.tahun_akademik_id` | `integer` | **Ya (Required)** | ID referensi Tahun Akademik | `8` |
| | `data.nilai_angka` | `string` | **Ya (Required)** | Nilai capaian akademik mahasiswa dalam format angka (0.00 - 100.00) | `"80.52"` |
| | `data.nilai_huruf` | `string` | **Ya (Required)** | Indeks prestasi huruf mutu (A, AB, B, BC, C, D, E) | `"A"` |
| | `data.bobot` | `string` | **Ya (Required)** | Bobot | `"4.00"` |
| | `data.link_nilai` | `string` | *Tidak (Opsional / Nullable)* | Link Nilai | `null` |
| | `data.link_evidence` | `string` | *Tidak (Opsional / Nullable)* | Link Evidence | `null` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:33"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:33"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `PATCH` /api/nilai-mahasiswa/{id}/link-evidence
**Ringkasan:** Update Link Evidence Nilai Mahasiswa

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `link_evidence` | `string` | **Ya** | Link Evidence | `Contoh Link Evidence` |
| `mata_kuliah_angkatan_kelas_id` | `integer` | Tidak | ID referensi penawaran mata kuliah pada angkatan kelas | `336` |
| `mahasiswa_id` | `integer` | **Ya** | ID referensi Mahasiswa | `300` |
| `tahun_akademik_id` | `integer` | **Ya** | ID referensi Tahun Akademik | `8` |
| `nilai_angka` | `number` | **Ya** | Nilai capaian akademik mahasiswa dalam format angka (0.00 - 100.00) | `80.52` |
| `nilai_huruf` | `string` | **Ya** | Indeks prestasi huruf mutu (A, AB, B, BC, C, D, E) | `A` |
| `bobot` | `string` | **Ya** | Bobot | `4.00` |
| `link_nilai` | `string` | **Ya** | Link Nilai | `Contoh Link Nilai` |

##### Contoh Payload Request:
```json
{
  "link_evidence": "Contoh Link Evidence",
  "mata_kuliah_angkatan_kelas_id": 336,
  "mahasiswa_id": 300,
  "tahun_akademik_id": 8,
  "nilai_angka": 80.52,
  "nilai_huruf": "A",
  "bobot": "4.00",
  "link_nilai": "Contoh Link Nilai"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📥 3. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `link_evidence` | `string` | **Ya (Required)** | Link Evidence | `Contoh Link Evidence` |
| `mata_kuliah_angkatan_kelas_id` | `integer` | *Tidak (Opsional / Nullable)* | ID referensi penawaran mata kuliah pada angkatan kelas | `336` |
| `mahasiswa_id` | `integer` | **Ya (Required)** | ID referensi Mahasiswa | `300` |
| `tahun_akademik_id` | `integer` | **Ya (Required)** | ID referensi Tahun Akademik | `8` |
| `nilai_angka` | `number` | **Ya (Required)** | Nilai capaian akademik mahasiswa dalam format angka (0.00 - 100.00) | `80.52` |
| `nilai_huruf` | `string` | **Ya (Required)** | Indeks prestasi huruf mutu (A, AB, B, BC, C, D, E) | `A` |
| `bobot` | `string` | **Ya (Required)** | Bobot | `4.00` |
| `link_nilai` | `string` | **Ya (Required)** | Link Nilai | `Contoh Link Nilai` |

### 📤 4. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `6825` |
| | `data.mata_kuliah_angkatan_kelas_id` | `integer` | *Tidak (Opsional / Nullable)* | ID referensi penawaran mata kuliah pada angkatan kelas | `336` |
| | `data.mahasiswa_id` | `integer` | **Ya (Required)** | ID referensi Mahasiswa | `300` |
| | `data.tahun_akademik_id` | `integer` | **Ya (Required)** | ID referensi Tahun Akademik | `8` |
| | `data.nilai_angka` | `string` | **Ya (Required)** | Nilai capaian akademik mahasiswa dalam format angka (0.00 - 100.00) | `"80.52"` |
| | `data.nilai_huruf` | `string` | **Ya (Required)** | Indeks prestasi huruf mutu (A, AB, B, BC, C, D, E) | `"A"` |
| | `data.bobot` | `string` | **Ya (Required)** | Bobot | `"4.00"` |
| | `data.link_nilai` | `string` | *Tidak (Opsional / Nullable)* | Link Nilai | `null` |
| | `data.link_evidence` | `string` | *Tidak (Opsional / Nullable)* | Link Evidence | `null` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:33"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:33"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/mahasiswa/{id}/khs
**Ringkasan:** Khs Nilai Mahasiswa

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `6825` |
| | `data.mata_kuliah_angkatan_kelas_id` | `integer` | **Ya (Required)** | Mata Kuliah Angkatan Kelas Id | `336` |
| | `data.mahasiswa_id` | `integer` | **Ya (Required)** | Mahasiswa Id | `300` |
| | `data.tahun_akademik_id` | `integer` | **Ya (Required)** | Tahun Akademik Id | `8` |
| | `data.nilai_angka` | `string` | **Ya (Required)** | Nilai Angka | `"80.52"` |
| | `data.nilai_huruf` | `string` | **Ya (Required)** | Nilai Huruf | `"A"` |
| | `data.bobot` | `string` | **Ya (Required)** | Bobot | `"4.00"` |
| | `data.link_nilai` | `string` | *Tidak (Opsional / Nullable)* | Link Nilai | `null` |
| | `data.link_evidence` | `string` | *Tidak (Opsional / Nullable)* | Link Evidence | `null` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:33"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:33"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/mahasiswa/{id}/transkrip
**Ringkasan:** Transkrip Nilai Mahasiswa

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `6825` |
| | `data.mata_kuliah_angkatan_kelas_id` | `integer` | **Ya (Required)** | Mata Kuliah Angkatan Kelas Id | `336` |
| | `data.mahasiswa_id` | `integer` | **Ya (Required)** | Mahasiswa Id | `300` |
| | `data.tahun_akademik_id` | `integer` | **Ya (Required)** | Tahun Akademik Id | `8` |
| | `data.nilai_angka` | `string` | **Ya (Required)** | Nilai Angka | `"80.52"` |
| | `data.nilai_huruf` | `string` | **Ya (Required)** | Nilai Huruf | `"A"` |
| | `data.bobot` | `string` | **Ya (Required)** | Bobot | `"4.00"` |
| | `data.link_nilai` | `string` | *Tidak (Opsional / Nullable)* | Link Nilai | `null` |
| | `data.link_evidence` | `string` | *Tidak (Opsional / Nullable)* | Link Evidence | `null` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:33"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:33"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/mahasiswa/{id}/ringkasan-akademik
**Ringkasan:** Ringkasan Akademik Nilai Mahasiswa

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `6825` |
| | `data.mata_kuliah_angkatan_kelas_id` | `integer` | **Ya (Required)** | Mata Kuliah Angkatan Kelas Id | `336` |
| | `data.mahasiswa_id` | `integer` | **Ya (Required)** | Mahasiswa Id | `300` |
| | `data.tahun_akademik_id` | `integer` | **Ya (Required)** | Tahun Akademik Id | `8` |
| | `data.nilai_angka` | `string` | **Ya (Required)** | Nilai Angka | `"80.52"` |
| | `data.nilai_huruf` | `string` | **Ya (Required)** | Nilai Huruf | `"A"` |
| | `data.bobot` | `string` | **Ya (Required)** | Bobot | `"4.00"` |
| | `data.link_nilai` | `string` | *Tidak (Opsional / Nullable)* | Link Nilai | `null` |
| | `data.link_evidence` | `string` | *Tidak (Opsional / Nullable)* | Link Evidence | `null` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:33"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:33"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

## Prestasi & Portofolio Mahasiswa
> Modul: **Prestasi & Portofolio Mahasiswa** | Jumlah: 15 endpoint

### `GET` /api/evidence-prestasi-mahasiswa
**Ringkasan:** Daftar Semua Data Evidence Prestasi Mahasiswa

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📤 2. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `array[object]` | **Ya (Required)** | Koleksi daftar data entitas | `[ { ... } ]` |
| | `data[].id` | `integer` | **Ya (Required)** | Id | `7` |
| | `data[].id_prestasi_mahasiswa` | `integer` | **Ya (Required)** | Id Prestasi Mahasiswa | `7` |
| | `data[].evidence` | `string` | **Ya (Required)** | Evidence | `"sertifikat_juara_1_kontes_robot_indonesia_kri_tingkat_wilayah_2025.pdf"` |
| | `data[].created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:08"` |
| | `data[].updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:08"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `POST` /api/evidence-prestasi-mahasiswa
**Ringkasan:** Tambah Data Evidence Prestasi Mahasiswa Baru

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `id_prestasi_mahasiswa` | `integer` | **Ya** | Id Prestasi Mahasiswa | `7` |
| `url` | `string` | **Ya** | Tautan URL berkas bukti prestasi (maksimal 2048 karakter) | `https://storage.polines.ac.id/prestasi/sertifikat_hackathon.pdf` |
| `jenis_evidence` | `string` | **Ya** | Jenis bukti prestasi (Sertifikat, Piagam, Surat Tugas, Foto Kegiatan, Publikasi, Link Lomba, Lainnya) | `Sertifikat` |
| `judul` | `string` | Tidak | Judul atau keterangan berkas bukti prestasi | `Sertifikat Juara 1 Hackathon IoT` |
| `evidence` | `string` | Tidak | Nama file atau link berkas bukti sertifikat pendukung | `sertifikat_juara_1_kontes_robot_indonesia_kri_tingkat_wilayah_2025.pdf` |

##### Contoh Payload Request:
```json
{
  "id_prestasi_mahasiswa": 7,
  "url": "https://storage.polines.ac.id/prestasi/sertifikat_hackathon.pdf",
  "jenis_evidence": "Sertifikat",
  "judul": "Sertifikat Juara 1 Hackathon IoT",
  "evidence": "sertifikat_juara_1_kontes_robot_indonesia_kri_tingkat_wilayah_2025.pdf"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📥 2. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `id_prestasi_mahasiswa` | `integer` | **Ya (Required)** | Id Prestasi Mahasiswa | `7` |
| `url` | `string` | **Ya (Required)** | Tautan URL berkas bukti prestasi (maksimal 2048 karakter) | `https://storage.polines.ac.id/prestasi/sertifikat_hackathon.pdf` |
| `jenis_evidence` | `string` | **Ya (Required)** | Jenis bukti prestasi (Sertifikat, Piagam, Surat Tugas, Foto Kegiatan, Publikasi, Link Lomba, Lainnya) | `Sertifikat` |
| `judul` | `string` | *Tidak (Opsional / Nullable)* | Judul atau keterangan berkas bukti prestasi | `Sertifikat Juara 1 Hackathon IoT` |
| `evidence` | `string` | *Tidak (Opsional / Nullable)* | Nama file atau link berkas bukti sertifikat pendukung | `sertifikat_juara_1_kontes_robot_indonesia_kri_tingkat_wilayah_2025.pdf` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **201 Created** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (201) | `201` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dibuat" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `7` |
| | `data.id_prestasi_mahasiswa` | `integer` | **Ya (Required)** | Id Prestasi Mahasiswa | `7` |
| | `data.evidence` | `string` | *Tidak (Opsional / Nullable)* | Nama file atau link berkas bukti sertifikat pendukung | `"sertifikat_juara_1_kontes_robot_indonesia_kri_tingkat_wilayah_2025.pdf"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:08"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:08"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/evidence-prestasi-mahasiswa/{id}
**Ringkasan:** Detail Data Evidence Prestasi Mahasiswa

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `7` |
| | `data.id_prestasi_mahasiswa` | `integer` | **Ya (Required)** | Id Prestasi Mahasiswa | `7` |
| | `data.evidence` | `string` | **Ya (Required)** | Evidence | `"sertifikat_juara_1_kontes_robot_indonesia_kri_tingkat_wilayah_2025.pdf"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:08"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:08"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `PUT` /api/evidence-prestasi-mahasiswa/{id}
**Ringkasan:** Perbarui Data Evidence Prestasi Mahasiswa

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `id_prestasi_mahasiswa` | `integer` | **Ya** | Id Prestasi Mahasiswa | `7` |
| `url` | `string` | **Ya** | Tautan URL berkas bukti prestasi (maksimal 2048 karakter) | `https://storage.polines.ac.id/prestasi/sertifikat_hackathon.pdf` |
| `jenis_evidence` | `string` | **Ya** | Jenis bukti prestasi (Sertifikat, Piagam, Surat Tugas, Foto Kegiatan, Publikasi, Link Lomba, Lainnya) | `Sertifikat` |
| `judul` | `string` | Tidak | Judul atau keterangan berkas bukti prestasi | `Sertifikat Juara 1 Hackathon IoT` |
| `evidence` | `string` | Tidak | Nama file atau link berkas bukti sertifikat pendukung | `sertifikat_juara_1_kontes_robot_indonesia_kri_tingkat_wilayah_2025.pdf` |

##### Contoh Payload Request:
```json
{
  "id_prestasi_mahasiswa": 7,
  "url": "https://storage.polines.ac.id/prestasi/sertifikat_hackathon.pdf",
  "jenis_evidence": "Sertifikat",
  "judul": "Sertifikat Juara 1 Hackathon IoT",
  "evidence": "sertifikat_juara_1_kontes_robot_indonesia_kri_tingkat_wilayah_2025.pdf"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📥 3. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `id_prestasi_mahasiswa` | `integer` | **Ya (Required)** | Id Prestasi Mahasiswa | `7` |
| `url` | `string` | **Ya (Required)** | Tautan URL berkas bukti prestasi (maksimal 2048 karakter) | `https://storage.polines.ac.id/prestasi/sertifikat_hackathon.pdf` |
| `jenis_evidence` | `string` | **Ya (Required)** | Jenis bukti prestasi (Sertifikat, Piagam, Surat Tugas, Foto Kegiatan, Publikasi, Link Lomba, Lainnya) | `Sertifikat` |
| `judul` | `string` | *Tidak (Opsional / Nullable)* | Judul atau keterangan berkas bukti prestasi | `Sertifikat Juara 1 Hackathon IoT` |
| `evidence` | `string` | *Tidak (Opsional / Nullable)* | Nama file atau link berkas bukti sertifikat pendukung | `sertifikat_juara_1_kontes_robot_indonesia_kri_tingkat_wilayah_2025.pdf` |

### 📤 4. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `7` |
| | `data.id_prestasi_mahasiswa` | `integer` | **Ya (Required)** | Id Prestasi Mahasiswa | `7` |
| | `data.evidence` | `string` | *Tidak (Opsional / Nullable)* | Nama file atau link berkas bukti sertifikat pendukung | `"sertifikat_juara_1_kontes_robot_indonesia_kri_tingkat_wilayah_2025.pdf"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:08"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:08"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `DELETE` /api/evidence-prestasi-mahasiswa/{id}
**Ringkasan:** Hapus Data Evidence Prestasi Mahasiswa

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dihapus" |
| | `data` | `null / object` | *Tidak (Opsional)* | Payload hasil operasi hapus | `null` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/jenis-prestasi
**Ringkasan:** Daftar Semua Data Jenis Prestasi

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📤 2. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `array[object]` | **Ya (Required)** | Koleksi daftar data entitas | `[ { ... } ]` |
| | `data[].id` | `integer` | **Ya (Required)** | Id | `7` |
| | `data[].id_prestasi_mahasiswa` | `integer` | **Ya (Required)** | Id Prestasi Mahasiswa | `7` |
| | `data[].jenis` | `string` | **Ya (Required)** | Jenis | `"Akademik"` |
| | `data[].created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:09"` |
| | `data[].updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:09"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `POST` /api/jenis-prestasi
**Ringkasan:** Tambah Data Jenis Prestasi Baru

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `id_prestasi_mahasiswa` | `integer` | **Ya** | Id Prestasi Mahasiswa | `7` |
| `jenis` | `string` | **Ya** | Jenis entitas unit pengelola (misal: Jurusan, Fakultas) | `Akademik` |

##### Contoh Payload Request:
```json
{
  "id_prestasi_mahasiswa": 7,
  "jenis": "Akademik"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📥 2. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `id_prestasi_mahasiswa` | `integer` | **Ya (Required)** | Id Prestasi Mahasiswa | `7` |
| `jenis` | `string` | **Ya (Required)** | Jenis entitas unit pengelola (misal: Jurusan, Fakultas) | `Akademik` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **201 Created** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (201) | `201` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dibuat" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `7` |
| | `data.id_prestasi_mahasiswa` | `integer` | **Ya (Required)** | Id Prestasi Mahasiswa | `7` |
| | `data.jenis` | `string` | **Ya (Required)** | Jenis entitas unit pengelola (misal: Jurusan, Fakultas) | `"Akademik"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:09"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:09"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/jenis-prestasi/{id}
**Ringkasan:** Detail Data Jenis Prestasi

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `7` |
| | `data.id_prestasi_mahasiswa` | `integer` | **Ya (Required)** | Id Prestasi Mahasiswa | `7` |
| | `data.jenis` | `string` | **Ya (Required)** | Jenis | `"Akademik"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:09"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:09"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `PUT` /api/jenis-prestasi/{id}
**Ringkasan:** Perbarui Data Jenis Prestasi

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `id_prestasi_mahasiswa` | `integer` | **Ya** | Id Prestasi Mahasiswa | `7` |
| `jenis` | `string` | **Ya** | Jenis entitas unit pengelola (misal: Jurusan, Fakultas) | `Akademik` |

##### Contoh Payload Request:
```json
{
  "id_prestasi_mahasiswa": 7,
  "jenis": "Akademik"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📥 3. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `id_prestasi_mahasiswa` | `integer` | **Ya (Required)** | Id Prestasi Mahasiswa | `7` |
| `jenis` | `string` | **Ya (Required)** | Jenis entitas unit pengelola (misal: Jurusan, Fakultas) | `Akademik` |

### 📤 4. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `7` |
| | `data.id_prestasi_mahasiswa` | `integer` | **Ya (Required)** | Id Prestasi Mahasiswa | `7` |
| | `data.jenis` | `string` | **Ya (Required)** | Jenis entitas unit pengelola (misal: Jurusan, Fakultas) | `"Akademik"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:09"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:09"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `DELETE` /api/jenis-prestasi/{id}
**Ringkasan:** Hapus Data Jenis Prestasi

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dihapus" |
| | `data` | `null / object` | *Tidak (Opsional)* | Payload hasil operasi hapus | `null` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/prestasi-mahasiswa
**Ringkasan:** Daftar Semua Data Prestasi Mahasiswa

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📤 2. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `array[object]` | **Ya (Required)** | Koleksi daftar data entitas | `[ { ... } ]` |
| | `data[].id` | `integer` | **Ya (Required)** | Id | `7` |
| | `data[].id_mahasiswa` | `integer` | **Ya (Required)** | Id Mahasiswa | `226` |
| | `data[].nama_aktivitas` | `string` | **Ya (Required)** | Nama Aktivitas | `"Juara 1 Kontes Robot Indonesia (KRI) Tingkat Wilayah"` |
| | `data[].tahun` | `integer` | **Ya (Required)** | Tahun | `2025` |
| | `data[].created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:07"` |
| | `data[].updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:07"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `POST` /api/prestasi-mahasiswa
**Ringkasan:** Tambah Data Prestasi Mahasiswa Baru

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `id_mahasiswa` | `integer` | **Ya** | ID referensi Mahasiswa | `226` |
| `nama_aktivitas` | `string` | **Ya** | Nama prestasi kejuaraan atau kompetisi | `Juara 1 Kontes Robot Indonesia (KRI) Tingkat Wilayah` |
| `tahun` | `integer` | **Ya** | Tahun kalender akademik | `2025` |
| `evidence` | `string` | Tidak | Nama file atau link berkas bukti sertifikat pendukung | `https://storage.polines.ac.id/prestasi/sertifikat_hackathon.pdf` |

##### Contoh Payload Request:
```json
{
  "id_mahasiswa": 226,
  "nama_aktivitas": "Juara 1 Kontes Robot Indonesia (KRI) Tingkat Wilayah",
  "tahun": 2025,
  "evidence": "https://storage.polines.ac.id/prestasi/sertifikat_hackathon.pdf"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📥 2. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `id_mahasiswa` | `integer` | **Ya (Required)** | ID referensi Mahasiswa | `226` |
| `nama_aktivitas` | `string` | **Ya (Required)** | Nama prestasi kejuaraan atau kompetisi | `Juara 1 Kontes Robot Indonesia (KRI) Tingkat Wilayah` |
| `tahun` | `integer` | **Ya (Required)** | Tahun kalender akademik | `2025` |
| `evidence` | `string` | *Tidak (Opsional / Nullable)* | Nama file atau link berkas bukti sertifikat pendukung | `https://storage.polines.ac.id/prestasi/sertifikat_hackathon.pdf` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **201 Created** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (201) | `201` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dibuat" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `7` |
| | `data.id_mahasiswa` | `integer` | **Ya (Required)** | ID referensi Mahasiswa | `226` |
| | `data.nama_aktivitas` | `string` | **Ya (Required)** | Nama prestasi kejuaraan atau kompetisi | `"Juara 1 Kontes Robot Indonesia (KRI) Tingkat Wilayah"` |
| | `data.tahun` | `integer` | **Ya (Required)** | Tahun kalender akademik | `2025` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:07"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:07"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/prestasi-mahasiswa/{id}
**Ringkasan:** Detail Data Prestasi Mahasiswa

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `2` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `7` |
| | `data.id_mahasiswa` | `integer` | **Ya (Required)** | Id Mahasiswa | `226` |
| | `data.nama_aktivitas` | `string` | **Ya (Required)** | Nama Aktivitas | `"Juara 1 Kontes Robot Indonesia (KRI) Tingkat Wilayah"` |
| | `data.tahun` | `integer` | **Ya (Required)** | Tahun | `2025` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:07"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:07"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `PUT` /api/prestasi-mahasiswa/{id}
**Ringkasan:** Perbarui Data Prestasi Mahasiswa

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `id_mahasiswa` | `integer` | **Ya** | ID referensi Mahasiswa | `226` |
| `nama_aktivitas` | `string` | **Ya** | Nama prestasi kejuaraan atau kompetisi | `Juara 1 Kontes Robot Indonesia (KRI) Tingkat Wilayah` |
| `tahun` | `integer` | **Ya** | Tahun kalender akademik | `2025` |
| `evidence` | `string` | Tidak | Nama file atau link berkas bukti sertifikat pendukung | `https://storage.polines.ac.id/prestasi/sertifikat_hackathon.pdf` |

##### Contoh Payload Request:
```json
{
  "id_mahasiswa": 226,
  "nama_aktivitas": "Juara 1 Kontes Robot Indonesia (KRI) Tingkat Wilayah",
  "tahun": 2025,
  "evidence": "https://storage.polines.ac.id/prestasi/sertifikat_hackathon.pdf"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `2` |

### 📥 3. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `id_mahasiswa` | `integer` | **Ya (Required)** | ID referensi Mahasiswa | `226` |
| `nama_aktivitas` | `string` | **Ya (Required)** | Nama prestasi kejuaraan atau kompetisi | `Juara 1 Kontes Robot Indonesia (KRI) Tingkat Wilayah` |
| `tahun` | `integer` | **Ya (Required)** | Tahun kalender akademik | `2025` |
| `evidence` | `string` | *Tidak (Opsional / Nullable)* | Nama file atau link berkas bukti sertifikat pendukung | `https://storage.polines.ac.id/prestasi/sertifikat_hackathon.pdf` |

### 📤 4. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `7` |
| | `data.id_mahasiswa` | `integer` | **Ya (Required)** | ID referensi Mahasiswa | `226` |
| | `data.nama_aktivitas` | `string` | **Ya (Required)** | Nama prestasi kejuaraan atau kompetisi | `"Juara 1 Kontes Robot Indonesia (KRI) Tingkat Wilayah"` |
| | `data.tahun` | `integer` | **Ya (Required)** | Tahun kalender akademik | `2025` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:12:07"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:12:07"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `DELETE` /api/prestasi-mahasiswa/{id}
**Ringkasan:** Hapus Data Prestasi Mahasiswa

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID data id |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `integer` | **Ya (Required)** | Parameter ID unik id pada path URL | `2` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dihapus" |
| | `data` | `null / object` | *Tidak (Opsional)* | Payload hasil operasi hapus | `null` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

## Manajemen Pengguna & Hak Akses
> Modul: **Manajemen Pengguna & Hak Akses** | Jumlah: 15 endpoint

### `GET` /api/permissions
**Ringkasan:** Daftar Semua Data Permission

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📤 2. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `array[object]` | **Ya (Required)** | Koleksi daftar data entitas | `[ { ... } ]` |
| | `data[].id` | `integer` | **Ya (Required)** | Id | `163` |
| | `data[].name` | `string` | **Ya (Required)** | Name | `"lkps.read"` |
| | `data[].guard_name` | `string` | **Ya (Required)** | Guard Name | `"api"` |
| | `data[].created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:18"` |
| | `data[].updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:18"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `POST` /api/permissions
**Ringkasan:** Tambah Data Permission Baru

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `name` | `string` | **Ya** | Name | `lkps.read` |
| `guard_name` | `string` | **Ya** | Guard Name | `api` |

##### Contoh Payload Request:
```json
{
  "name": "lkps.read",
  "guard_name": "api"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📥 2. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `name` | `string` | **Ya (Required)** | Name | `lkps.read` |
| `guard_name` | `string` | **Ya (Required)** | Guard Name | `api` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **201 Created** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (201) | `201` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dibuat" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `163` |
| | `data.name` | `string` | **Ya (Required)** | Name | `"lkps.read"` |
| | `data.guard_name` | `string` | **Ya (Required)** | Guard Name | `"api"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:18"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:18"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/permissions/{permission}
**Ringkasan:** Detail Data Permission

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `permission` | `path` | `integer` | **Ya** | ID data permission |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `permission` | `integer` | **Ya (Required)** | Parameter ID unik permission pada path URL | `156` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `163` |
| | `data.name` | `string` | **Ya (Required)** | Name | `"lkps.read"` |
| | `data.guard_name` | `string` | **Ya (Required)** | Guard Name | `"api"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:18"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:18"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `PUT` /api/permissions/{permission}
**Ringkasan:** Perbarui Data Permission

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `permission` | `path` | `integer` | **Ya** | ID data permission |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `name` | `string` | **Ya** | Name | `lkps.read` |
| `guard_name` | `string` | **Ya** | Guard Name | `api` |

##### Contoh Payload Request:
```json
{
  "name": "lkps.read",
  "guard_name": "api"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `permission` | `integer` | **Ya (Required)** | Parameter ID unik permission pada path URL | `156` |

### 📥 3. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `name` | `string` | **Ya (Required)** | Name | `lkps.read` |
| `guard_name` | `string` | **Ya (Required)** | Guard Name | `api` |

### 📤 4. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `163` |
| | `data.name` | `string` | **Ya (Required)** | Name | `"lkps.read"` |
| | `data.guard_name` | `string` | **Ya (Required)** | Guard Name | `"api"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:18"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:18"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `DELETE` /api/permissions/{permission}
**Ringkasan:** Hapus Data Permission

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `permission` | `path` | `integer` | **Ya** | ID data permission |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `permission` | `integer` | **Ya (Required)** | Parameter ID unik permission pada path URL | `156` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dihapus" |
| | `data` | `null / object` | *Tidak (Opsional)* | Payload hasil operasi hapus | `null` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/roles
**Ringkasan:** Daftar Semua Data Role

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📤 2. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `array[object]` | **Ya (Required)** | Koleksi daftar data entitas | `[ { ... } ]` |
| | `data[].id` | `integer` | **Ya (Required)** | Id | `4` |
| | `data[].name` | `string` | **Ya (Required)** | Name | `"REVIEWER"` |
| | `data[].guard_name` | `string` | **Ya (Required)** | Guard Name | `"api"` |
| | `data[].created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:19"` |
| | `data[].updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:19"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `POST` /api/roles
**Ringkasan:** Tambah Data Role Baru

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `name` | `string` | **Ya** | Nama Role sistem akreditasi | `SUPERVISOR` |
| `permissions` | `array` | **Ya** | Daftar nama permission yang ditugaskan ke role | ["*", "anggota_upps.create", "anggota_upps.delete"] |

##### Contoh Payload Request:
```json
{
  "name": "SUPERVISOR",
  "permissions": [
    "*",
    "anggota_upps.create",
    "anggota_upps.delete"
  ]
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📥 2. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `name` | `string` | **Ya (Required)** | Nama Role sistem akreditasi | `SUPERVISOR` |
| `permissions` | `array` | **Ya (Required)** | Daftar nama permission yang ditugaskan ke role | `["*","anggota_upps.create","anggota_upps.delete"]` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **201 Created** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (201) | `201` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dibuat" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `4` |
| | `data.name` | `string` | **Ya (Required)** | Nama Role sistem akreditasi | `"REVIEWER"` |
| | `data.guard_name` | `string` | **Ya (Required)** | Guard Name | `"api"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:19"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:19"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/roles/{role}
**Ringkasan:** Detail Data Role

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `role` | `path` | `integer` | **Ya** | ID data role |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `role` | `integer` | **Ya (Required)** | Parameter ID unik role pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `4` |
| | `data.name` | `string` | **Ya (Required)** | Name | `"REVIEWER"` |
| | `data.guard_name` | `string` | **Ya (Required)** | Guard Name | `"api"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:19"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:19"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `PUT` /api/roles/{role}
**Ringkasan:** Perbarui Data Role

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `role` | `path` | `integer` | **Ya** | ID data role |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `name` | `string` | **Ya** | Nama Role sistem akreditasi | `SUPERVISOR` |
| `permissions` | `array` | **Ya** | Daftar nama permission yang ditugaskan ke role | ["*", "anggota_upps.create", "anggota_upps.delete"] |

##### Contoh Payload Request:
```json
{
  "name": "SUPERVISOR",
  "permissions": [
    "*",
    "anggota_upps.create",
    "anggota_upps.delete"
  ]
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `role` | `integer` | **Ya (Required)** | Parameter ID unik role pada path URL | `1` |

### 📥 3. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `name` | `string` | **Ya (Required)** | Nama Role sistem akreditasi | `SUPERVISOR` |
| `permissions` | `array` | **Ya (Required)** | Daftar nama permission yang ditugaskan ke role | `["*","anggota_upps.create","anggota_upps.delete"]` |

### 📤 4. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `4` |
| | `data.name` | `string` | **Ya (Required)** | Nama Role sistem akreditasi | `"REVIEWER"` |
| | `data.guard_name` | `string` | **Ya (Required)** | Guard Name | `"api"` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-04 09:11:19"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-04 09:11:19"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `DELETE` /api/roles/{role}
**Ringkasan:** Hapus Data Role

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `role` | `path` | `integer` | **Ya** | ID data role |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `role` | `integer` | **Ya (Required)** | Parameter ID unik role pada path URL | `1` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dihapus" |
| | `data` | `null / object` | *Tidak (Opsional)* | Payload hasil operasi hapus | `null` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/users
**Ringkasan:** Daftar Semua Data User

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📤 2. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `array[object]` | **Ya (Required)** | Koleksi daftar data entitas | `[ { ... } ]` |
| | `data[].id` | `integer` | **Ya (Required)** | Id | `15` |
| | `data[].name` | `string` | **Ya (Required)** | Name | `"DASI HAYU PERMANA [TI]"` |
| | `data[].email` | `string` | **Ya (Required)** | Email | `"dasi.43325006@mhs.polines.ac.id"` |
| | `data[].google_id` | `string` | **Ya (Required)** | Google Id | `"117724674384796029682"` |
| | `data[].avatar` | `string` | **Ya (Required)** | Avatar | `"https://lh3.googleusercontent.com/a/ACg8ocL0wrxy-7vTkONK0Rhb6PPm_SbGvRLEy8AwEy1dioCIrsaBrg=s96-c"` |
| | `data[].role` | `string` | **Ya (Required)** | Role | `"DOSEN"` |
| | `data[].email_verified_at` | `string` | *Tidak (Opsional / Nullable)* | Email Verified At | `null` |
| | `data[].created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-06 04:24:47"` |
| | `data[].updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-06 04:24:47"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `POST` /api/users
**Ringkasan:** Tambah Data User Baru

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `nama` | `string` | **Ya** | Nama lengkap pengguna | `Dr. Andi Wijaya, S.T., M.Kom.` |
| `email` | `string (email)` | **Ya** | Email resmi institusi Polines (@polines.ac.id) | `andi@polines.ac.id` |
| `password` | `string (password)` | **Ya** | Kata sandi pengguna (min 8 karakter) | `password123` |
| `role` | `string` | **Ya** | Role pengguna (ADMINISTRATOR, DOSEN, KAPRODI, REVIEWER) | `DOSEN` |

##### Contoh Payload Request:
```json
{
  "nama": "Dr. Andi Wijaya, S.T., M.Kom.",
  "email": "andi@polines.ac.id",
  "password": "password123",
  "role": "DOSEN"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 📥 2. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `nama` | `string` | **Ya (Required)** | Nama lengkap pengguna | `Dr. Andi Wijaya, S.T., M.Kom.` |
| `email` | `string (email)` | **Ya (Required)** | Email resmi institusi Polines (@polines.ac.id) | `andi@polines.ac.id` |
| `password` | `string (password)` | **Ya (Required)** | Kata sandi pengguna (min 8 karakter) | `password123` |
| `role` | `string` | **Ya (Required)** | Role pengguna (ADMINISTRATOR, DOSEN, KAPRODI, REVIEWER) | `DOSEN` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **201 Created** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (201) | `201` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dibuat" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `15` |
| | `data.name` | `string` | **Ya (Required)** | Name | `"DASI HAYU PERMANA [TI]"` |
| | `data.email` | `string` | **Ya (Required)** | Email resmi institusi Polines (@polines.ac.id) | `"dasi.43325006@mhs.polines.ac.id"` |
| | `data.google_id` | `string` | **Ya (Required)** | Google Id | `"117724674384796029682"` |
| | `data.avatar` | `string` | **Ya (Required)** | Avatar | `"https://lh3.googleusercontent.com/a/ACg8ocL0wrxy-7vTkONK0Rhb6PPm_SbGvRLEy8AwEy1dioCIrsaBrg=s96-c"` |
| | `data.role` | `string` | **Ya (Required)** | Role pengguna (ADMINISTRATOR, DOSEN, KAPRODI, REVIEWER) | `"DOSEN"` |
| | `data.email_verified_at` | `string` | *Tidak (Opsional / Nullable)* | Email Verified At | `null` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-06 04:24:47"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-06 04:24:47"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `GET` /api/users/{user}
**Ringkasan:** Detail Data User

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `user` | `path` | `integer` | **Ya** | ID data user |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `user` | `integer` | **Ya (Required)** | Parameter ID unik user pada path URL | `2` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `15` |
| | `data.name` | `string` | **Ya (Required)** | Name | `"DASI HAYU PERMANA [TI]"` |
| | `data.email` | `string` | **Ya (Required)** | Email | `"dasi.43325006@mhs.polines.ac.id"` |
| | `data.google_id` | `string` | **Ya (Required)** | Google Id | `"117724674384796029682"` |
| | `data.avatar` | `string` | **Ya (Required)** | Avatar | `"https://lh3.googleusercontent.com/a/ACg8ocL0wrxy-7vTkONK0Rhb6PPm_SbGvRLEy8AwEy1dioCIrsaBrg=s96-c"` |
| | `data.role` | `string` | **Ya (Required)** | Role | `"DOSEN"` |
| | `data.email_verified_at` | `string` | *Tidak (Opsional / Nullable)* | Email Verified At | `null` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-06 04:24:47"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-06 04:24:47"` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `PUT` /api/users/{user}
**Ringkasan:** Perbarui Data User

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `user` | `path` | `integer` | **Ya** | ID data user |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `nama` | `string` | **Ya** | Nama lengkap pengguna | `Dr. Andi Wijaya, S.T., M.Kom.` |
| `email` | `string (email)` | **Ya** | Email resmi institusi Polines (@polines.ac.id) | `andi@polines.ac.id` |
| `password` | `string (password)` | **Ya** | Kata sandi pengguna (min 8 karakter) | `password123` |
| `role` | `string` | **Ya** | Role pengguna (ADMINISTRATOR, DOSEN, KAPRODI, REVIEWER) | `DOSEN` |

##### Contoh Payload Request:
```json
{
  "nama": "Dr. Andi Wijaya, S.T., M.Kom.",
  "email": "andi@polines.ac.id",
  "password": "password123",
  "role": "DOSEN"
}
```

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Content-Type` | `string` | **Ya (Required)** | Tipe konten payload body permintaan | `application/json` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `user` | `integer` | **Ya (Required)** | Parameter ID unik user pada path URL | `2` |

### 📥 3. Request Body
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Riil |
| :--- | :--- | :--- | :--- | :--- |
| `nama` | `string` | **Ya (Required)** | Nama lengkap pengguna | `Dr. Andi Wijaya, S.T., M.Kom.` |
| `email` | `string (email)` | **Ya (Required)** | Email resmi institusi Polines (@polines.ac.id) | `andi@polines.ac.id` |
| `password` | `string (password)` | **Ya (Required)** | Kata sandi pengguna (min 8 karakter) | `password123` |
| `role` | `string` | **Ya (Required)** | Role pengguna (ADMINISTRATOR, DOSEN, KAPRODI, REVIEWER) | `DOSEN` |

### 📤 4. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Operasi berhasil" |
| | `data` | `object` | **Ya (Required)** | Objek data entitas hasil operasi | `{ ... }` |
| | `data.id` | `integer` | **Ya (Required)** | Id | `15` |
| | `data.name` | `string` | **Ya (Required)** | Name | `"DASI HAYU PERMANA [TI]"` |
| | `data.email` | `string` | **Ya (Required)** | Email resmi institusi Polines (@polines.ac.id) | `"dasi.43325006@mhs.polines.ac.id"` |
| | `data.google_id` | `string` | **Ya (Required)** | Google Id | `"117724674384796029682"` |
| | `data.avatar` | `string` | **Ya (Required)** | Avatar | `"https://lh3.googleusercontent.com/a/ACg8ocL0wrxy-7vTkONK0Rhb6PPm_SbGvRLEy8AwEy1dioCIrsaBrg=s96-c"` |
| | `data.role` | `string` | **Ya (Required)** | Role pengguna (ADMINISTRATOR, DOSEN, KAPRODI, REVIEWER) | `"DOSEN"` |
| | `data.email_verified_at` | `string` | *Tidak (Opsional / Nullable)* | Email Verified At | `null` |
| | `data.created_at` | `string` | **Ya (Required)** | Created At | `"2026-11-06 04:24:47"` |
| | `data.updated_at` | `string` | **Ya (Required)** | Updated At | `"2026-11-06 04:24:47"` |
| **422 Unprocessable** | `success` | `boolean` | **Ya (Required)** | Indikator kegagalan validasi (`false`) | `false` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (422) | `422` |
| | `message` | `string` | **Ya (Required)** | Ringkasan pesan kegagalan validasi | \"The given data was invalid.\" |
| | `errors` | `object` | **Ya (Required)** | Kamus pesan kesalahan validasi per field input | `{\"field\": [\"Pesan error\"]}` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---

### `DELETE` /api/users/{user}
**Ringkasan:** Hapus Data User

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `user` | `path` | `integer` | **Ya** | ID data user |

#### Spesifikasi Permintaan & Respon (Detail Dokumentasi)
### 📋 1. Request Headers
| Header | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `Authorization` | `string` | **Ya (Required)** | Token Bearer JWT hasil otentikasi login | `Bearer eyJhbGci...` |
| `Accept` | `string` | **Ya (Required)** | Tipe konten respon server yang diharapkan | `application/json` |

### 🔍 2. Path Parameters
| Parameter | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- |
| `user` | `integer` | **Ya (Required)** | Parameter ID unik user pada path URL | `2` |

### 📤 3. Struktur Response
| Status HTTP | Field / Properti | Tipe Data | Wajib / Required | Keterangan | Contoh Nilai |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **200 OK** | `success` | `boolean` | **Ya (Required)** | Indikator status keberhasilan (`true`) | `true` |
| | `code` | `integer` | **Ya (Required)** | HTTP Status Code (200) | `200` |
| | `message` | `string` | **Ya (Required)** | Pesan informasi respon server | "Data berhasil dihapus" |
| | `data` | `null / object` | *Tidak (Opsional)* | Payload hasil operasi hapus | `null` |
| **401 Unauthorized** | `message` | `string` | **Ya (Required)** | Pesan otentikasi gagal saat token kosong atau kedaluwarsa | \"Unauthenticated.\" |
| **403 Forbidden** | `message` | `string` | **Ya (Required)** | Pesan penolakan izin akses Role/Permission | \"User does not have the right permissions.\" |
| **404 Not Found** | `message` | `string` | **Ya (Required)** | Data referensi dengan ID yang diminta tidak ditemukan di database | \"Data tidak ditemukan\" |
| **400 Bad Request** | `message` | `string` | **Ya (Required)** | Permintaan tidak valid atau data berelasi masih terikat | \"Permintaan tidak valid\" |

#### Daftar Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil |
| `400` | Permintaan tidak valid / Data terkait masih digunakan |
| `401` | Unauthenticated / Token tidak valid |
| `403` | Forbidden / Tidak memiliki hak akses |
| `404` | Data tidak ditemukan |
| `422` | Validasi entitas gagal |

---
