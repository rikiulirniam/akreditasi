# Dokumentasi REST API Sistem Informasi Tridharma PBL (Kelompok 2)
### Manajemen SDM Dosen, Penelitian, Pengabdian kepada Masyarakat (PkM), & Kerja Sama (LAM-INFOKOM 2.1)

> Dokumen ini diekstraksi dan distrukturkan secara otomatis langsung dari spesifikasi OpenAPI 3.0 resmi pada server live: `https://tridharma.fayra.my.id/api/documentation`.

---

## 1. Konfigurasi Lingkungan & Autentikasi
* **Base URL:** `https://tridharma.fayra.my.id`
* **API Prefix:** `https://tridharma.fayra.my.id/api`
* **Format Pertukaran Data:** `application/json`
* **Autentikasi Terpusat:** Menggunakan SSO Kelompok 1 (`https://akademik.fayra.my.id/api/auth/login`) atau login lokal `POST /api/login`.
* **Metode Autentikasi:** JWT Bearer Token (`Authorization: Bearer <access_token>`)
* **Swagger Dev Mode:** Pada lingkungan development/staging, request dengan header `X-Swagger-Request: true` dapat melewati autentikasi langsung sebagai role `ADMINISTRATOR`.
* **Verifikasi Token:** Endpoint `GET /api/me` digunakan untuk mendapatkan profil pengguna yang sedang login beserta role dan permission.

### Format Envelope Standar JSON
#### Respons Berhasil (HTTP 200 / 201):
```json
{
  "success": true,
  "code": 200,
  "message": "Operasi berhasil dilakukan.",
  "data": { ... }
}
```
#### Respons Validasi Gagal (HTTP 422):
```json
{
  "success": false,
  "code": 422,
  "message": "Validasi gagal.",
  "errors": {
    "field_name": ["Pesan kesalahan validasi"]
  }
}
```

---

## 2. Ringkasan Modul & Daftar Endpoint

Total Endpoint Tersedia: **107 Endpoint** yang terbagi dalam **21 Modul Tridharma & SDM**:

### [Jabatan Akademik](#jabatan-akademik) (5 endpoint)
| Method | Endpoint | Ringkasan / Deskripsi |
| :---: | :--- | :--- |
| `GET` | `/api/jabatan-akademik` | Semua Jabatan Akademik |
| `POST` | `/api/jabatan-akademik` | Tambah Jabatan Akademik |
| `GET` | `/api/jabatan-akademik/{id}` | Detail Jabatan Akademik |
| `PUT` | `/api/jabatan-akademik/{id}` | Update Jabatan Akademik |
| `DELETE` | `/api/jabatan-akademik/{id}` | Hapus Jabatan Akademik |

### [Pendidikan](#pendidikan) (5 endpoint)
| Method | Endpoint | Ringkasan / Deskripsi |
| :---: | :--- | :--- |
| `GET` | `/api/pendidikan` | Semua Jenjang Pendidikan |
| `POST` | `/api/pendidikan` | Tambah Jenjang Pendidikan |
| `GET` | `/api/pendidikan/{id}` | Detail Jenjang Pendidikan |
| `PUT` | `/api/pendidikan/{id}` | Update Jenjang Pendidikan |
| `DELETE` | `/api/pendidikan/{id}` | Hapus Jenjang Pendidikan |

### [Bidang Keahlian](#bidang-keahlian) (5 endpoint)
| Method | Endpoint | Ringkasan / Deskripsi |
| :---: | :--- | :--- |
| `GET` | `/api/bidang-keahlian` | Semua Bidang Keahlian |
| `POST` | `/api/bidang-keahlian` | Tambah Bidang Keahlian |
| `GET` | `/api/bidang-keahlian/{id}` | Detail Bidang Keahlian |
| `PUT` | `/api/bidang-keahlian/{id}` | Update Bidang Keahlian |
| `DELETE` | `/api/bidang-keahlian/{id}` | Hapus Bidang Keahlian |

### [Mitra](#mitra) (5 endpoint)
| Method | Endpoint | Ringkasan / Deskripsi |
| :---: | :--- | :--- |
| `GET` | `/api/mitra` | Semua Mitra |
| `POST` | `/api/mitra` | Tambah Mitra |
| `GET` | `/api/mitra/{id}` | Detail Mitra |
| `PUT` | `/api/mitra/{id}` | Update Mitra |
| `DELETE` | `/api/mitra/{id}` | Hapus Mitra |

### [Jenis Kegiatan](#jenis-kegiatan) (5 endpoint)
| Method | Endpoint | Ringkasan / Deskripsi |
| :---: | :--- | :--- |
| `GET` | `/api/jenis-kegiatan` | Semua Jenis Kegiatan |
| `POST` | `/api/jenis-kegiatan` | Tambah Jenis Kegiatan |
| `GET` | `/api/jenis-kegiatan/{id}` | Detail Jenis Kegiatan |
| `PUT` | `/api/jenis-kegiatan/{id}` | Update Jenis Kegiatan |
| `DELETE` | `/api/jenis-kegiatan/{id}` | Hapus Jenis Kegiatan |

### [Jenis Luaran](#jenis-luaran) (5 endpoint)
| Method | Endpoint | Ringkasan / Deskripsi |
| :---: | :--- | :--- |
| `GET` | `/api/jenis-luaran` | Semua Jenis Luaran |
| `POST` | `/api/jenis-luaran` | Tambah Jenis Luaran |
| `GET` | `/api/jenis-luaran/{id}` | Detail Jenis Luaran |
| `PUT` | `/api/jenis-luaran/{id}` | Update Jenis Luaran |
| `DELETE` | `/api/jenis-luaran/{id}` | Hapus Jenis Luaran |

### [Jenis Kerja Sama](#jenis-kerja-sama) (5 endpoint)
| Method | Endpoint | Ringkasan / Deskripsi |
| :---: | :--- | :--- |
| `GET` | `/api/jenis-kerja-sama` | Semua Jenis Kerja Sama |
| `POST` | `/api/jenis-kerja-sama` | Tambah Jenis Kerja Sama |
| `GET` | `/api/jenis-kerja-sama/{id}` | Detail Jenis Kerja Sama |
| `PUT` | `/api/jenis-kerja-sama/{id}` | Update Jenis Kerja Sama |
| `DELETE` | `/api/jenis-kerja-sama/{id}` | Hapus Jenis Kerja Sama |

### [Dosen](#dosen) (7 endpoint)
| Method | Endpoint | Ringkasan / Deskripsi |
| :---: | :--- | :--- |
| `GET` | `/api/dosen` | Semua Data Dosen |
| `POST` | `/api/dosen` | Tambah Data Dosen |
| `GET` | `/api/dosen/{id}` | Detail Dosen |
| `PUT` | `/api/dosen/{id}` | Update Data Dosen |
| `DELETE` | `/api/dosen/{id}` | Hapus Dosen |
| `POST` | `/api/dosen/import` | Import Excel Dosen |
| `POST` | `/api/dosen/{id}/restore` | Restore Dosen |

### [Tenaga Kependidikan](#tenaga-kependidikan) (5 endpoint)
| Method | Endpoint | Ringkasan / Deskripsi |
| :---: | :--- | :--- |
| `GET` | `/api/tendik` | Semua Tenaga Kependidikan |
| `POST` | `/api/tendik` | Tambah Tenaga Kependidikan |
| `GET` | `/api/tendik/{id}` | Detail Tenaga Kependidikan |
| `PUT` | `/api/tendik/{id}` | Update Tenaga Kependidikan |
| `DELETE` | `/api/tendik/{id}` | Hapus Tenaga Kependidikan |

### [Kegiatan](#kegiatan) (5 endpoint)
| Method | Endpoint | Ringkasan / Deskripsi |
| :---: | :--- | :--- |
| `GET` | `/api/kegiatan` | Semua Kegiatan |
| `POST` | `/api/kegiatan` | Tambah Kegiatan |
| `GET` | `/api/kegiatan/{id}` | Detail Kegiatan |
| `PUT` | `/api/kegiatan/{id}` | Update Kegiatan |
| `DELETE` | `/api/kegiatan/{id}` | Kegiatan |

### [Luaran](#luaran) (5 endpoint)
| Method | Endpoint | Ringkasan / Deskripsi |
| :---: | :--- | :--- |
| `GET` | `/api/luaran` | Semua Luaran |
| `POST` | `/api/luaran` | Tambah Luaran |
| `GET` | `/api/luaran/{id}` | Detail Luaran |
| `PUT` | `/api/luaran/{id}` | Update Luaran |
| `DELETE` | `/api/luaran/{id}` | Luaran |

### [Kerja Sama](#kerja-sama) (10 endpoint)
| Method | Endpoint | Ringkasan / Deskripsi |
| :---: | :--- | :--- |
| `GET` | `/api/kerja-sama` | Semua Kerja Sama |
| `POST` | `/api/kerja-sama` | Tambah Dokumen Kerja Sama |
| `GET` | `/api/kerja-sama/{id}` | Detail Kerja Sama |
| `PUT` | `/api/kerja-sama/{id}` | Update Kerja Sama |
| `DELETE` | `/api/kerja-sama/{id}` | Kerja Sama |
| `POST` | `/api/kerja-sama/{id}/perpanjang` | Perpanjang Kerja Sama |
| `GET` | `/api/kerja-sama/{id}/aktivitas` | Aktivitas Kerja Sama |
| `POST` | `/api/kerja-sama/{id}/aktivitas` | Tambah Aktivitas Kerja Sama |
| `GET` | `/api/kerja-sama/reminder-kedaluwarsa` | Monitoring Reminder Kedaluwarsa Kerja Sama |
| `POST` | `/api/kerja-sama/check-kedaluwarsa` | Trigger Sinkronisasi Status Kedaluwarsa & Notifikasi Otomatis |

### [Aktivitas Kerja Sama](#aktivitas-kerja-sama) (5 endpoint)
| Method | Endpoint | Ringkasan / Deskripsi |
| :---: | :--- | :--- |
| `GET` | `/api/aktivitas-kerja-sama` | Semua Aktivitas Kerja Sama |
| `POST` | `/api/aktivitas-kerja-sama` | Tambah Aktivitas Standalone |
| `GET` | `/api/aktivitas-kerja-sama/{id}` | Detail Aktivitas Standalone |
| `PUT` | `/api/aktivitas-kerja-sama/{id}` | Update Aktivitas Standalone |
| `DELETE` | `/api/aktivitas-kerja-sama/{id}` | Hapus Aktivitas Standalone |

### [Evidence](#evidence) (7 endpoint)
| Method | Endpoint | Ringkasan / Deskripsi |
| :---: | :--- | :--- |
| `GET` | `/api/evidence` | Semua Evidence |
| `POST` | `/api/evidence` | Upload Berkas Fisik Evidence |
| `GET` | `/api/evidence/{id}` | Detail Evidence |
| `DELETE` | `/api/evidence/{id}` | Evidence |
| `GET` | `/api/evidence/{id}/download` | Unduh Berkas Fisik |
| `POST` | `/api/evidence/{id}/validasi` | Review Validasi Kaprodi |
| `POST` | `/api/evidence/{id}/ganti-link` | Ganti Link Drive |

### [Validasi Mahasiswa](#validasi-mahasiswa) (1 endpoint)
| Method | Endpoint | Ringkasan / Deskripsi |
| :---: | :--- | :--- |
| `POST` | `/api/k1/validasi-nim` | Validasi NIM Mahasiswa K1 |

### [Statistik](#statistik) (7 endpoint)
| Method | Endpoint | Ringkasan / Deskripsi |
| :---: | :--- | :--- |
| `GET` | `/api/v1/dashboard` | Dashboard Analitik |
| `GET` | `/api/v1/dosen/statistik` | Statistik Dosen |
| `GET` | `/api/v1/dosen/rasio` | Rasio Dosen : Mahasiswa |
| `GET` | `/api/v1/dosen/produktivitas` | Produktivitas Dosen |
| `GET` | `/api/v1/tridharma/summary` | Summary Tridharma |
| `GET` | `/api/v1/tridharma/tren` | Tren Tri Dharma |
| `GET` | `/api/v1/kerjasama/aktif` | Kerja Sama Aktif |

### [Sertifikasi](#sertifikasi) (6 endpoint)
| Method | Endpoint | Ringkasan / Deskripsi |
| :---: | :--- | :--- |
| `GET` | `/api/sertifikasi` | Daftar Sertifikasi (Dosen & Tendik) |
| `POST` | `/api/sertifikasi` | Tambah Data Sertifikasi Baru |
| `GET` | `/api/sertifikasi/{id}` | Detail Sertifikasi |
| `PUT` | `/api/sertifikasi/{id}` | Perbarui Data Sertifikasi |
| `DELETE` | `/api/sertifikasi/{id}` | Hapus Data Sertifikasi |
| `POST` | `/api/sertifikasi/sync-profil` | Sinkronisasi Massal Sertifikasi ke Profil Dosen & Tendik |

### [Auth](#auth) (3 endpoint)
| Method | Endpoint | Ringkasan / Deskripsi |
| :---: | :--- | :--- |
| `POST` | `/api/auth/login` | Login SSO Terpusat (http://akademik.fayra.my.id/api/auth/login) |
| `GET` | `/api/me` | Introspeksi Profil & Hak Akses Pengguna Aktif |
| `POST` | `/api/logout` | Logout Sesi Pengguna |

### [Assessment & Gap Analysis](#assessment-gap-analysis) (2 endpoint)
| Method | Endpoint | Ringkasan / Deskripsi |
| :---: | :--- | :--- |
| `POST` | `/api/assessment/run` | Jalankan Engine Assessment SDM & Gap Analysis K3 |
| `GET` | `/api/assessment/hasil` | Daftar Riwayat Hasil Assessment & Rekomendasi |

### [Konfigurasi Metrik](#konfigurasi-metrik) (3 endpoint)
| Method | Endpoint | Ringkasan / Deskripsi |
| :---: | :--- | :--- |
| `GET` | `/api/konfigurasi-metrik/indikator-k3` | Sinkronisasi Indikator Standar LAM INFOKOM dari K3 |
| `GET` | `/api/konfigurasi-metrik` | Daftar Konfigurasi Metrik Akreditasi |
| `POST` | `/api/konfigurasi-metrik` | Tambah Konfigurasi Metrik |

### [Notifikasi & Audit Log](#notifikasi-audit-log) (6 endpoint)
| Method | Endpoint | Ringkasan / Deskripsi |
| :---: | :--- | :--- |
| `GET` | `/api/notifikasi` | Daftar Notifikasi In-App Pengguna |
| `POST` | `/api/notifikasi` | Kirim Notifikasi In-App Baru |
| `POST` | `/api/notifikasi/{id}/baca` | Tandai Notifikasi Telah Dibaca |
| `POST` | `/api/notifikasi/baca-semua` | Tandai Seluruh Notifikasi Telah Dibaca |
| `GET` | `/api/audit-logs` | Riwayat Audit Trail Log |
| `GET` | `/api/audit-logs/{id}` | Detail Forensik Audit Log |

---

## 3. Rincian Teknis Endpoint per Modul

## Jabatan Akademik
> Modul: **Jabatan Akademik** | Jumlah: 5 endpoint

### `GET` /api/jabatan-akademik
**Ringkasan:** Semua Jabatan Akademik
**Deskripsi:** Endpoint API untuk Semua Jabatan Akademik.

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `POST` /api/jabatan-akademik
**Ringkasan:** Tambah Jabatan Akademik
**Deskripsi:** Endpoint API untuk Tambah Jabatan Akademik.

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `nama_jabatan` | `string` | Tidak | - | `Profesor Kehormatan` |

##### Contoh Payload Request:
```json
{
  "nama_jabatan": "Profesor Kehormatan"
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat / diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |
| `422` | Validasi gagal: format data input tidak sesuai ketentuan. |

---

### `GET` /api/jabatan-akademik/{id}
**Ringkasan:** Detail Jabatan Akademik
**Deskripsi:** Endpoint API untuk Detail Jabatan Akademik.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `PUT` /api/jabatan-akademik/{id}
**Ringkasan:** Update Jabatan Akademik
**Deskripsi:** Endpoint API untuk Update Jabatan Akademik.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `nama_jabatan` | `string` | Tidak | - | `Guru Besar / Profesor Terhormat` |

##### Contoh Payload Request:
```json
{
  "nama_jabatan": "Guru Besar / Profesor Terhormat"
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |
| `422` | Validasi gagal: format data input tidak sesuai ketentuan. |

---

### `DELETE` /api/jabatan-akademik/{id}
**Ringkasan:** Hapus Jabatan Akademik
**Deskripsi:** Endpoint API untuk Hapus Jabatan Akademik.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

## Pendidikan
> Modul: **Pendidikan** | Jumlah: 5 endpoint

### `GET` /api/pendidikan
**Ringkasan:** Semua Jenjang Pendidikan
**Deskripsi:** Endpoint API untuk Semua Jenjang Pendidikan.

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `POST` /api/pendidikan
**Ringkasan:** Tambah Jenjang Pendidikan
**Deskripsi:** Endpoint API untuk Tambah Jenjang Pendidikan.

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `jenjang` | `string` | Tidak | - | `Spesialis 1 (Sp-1)` |

##### Contoh Payload Request:
```json
{
  "jenjang": "Spesialis 1 (Sp-1)"
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat / diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |
| `422` | Validasi gagal: format data input tidak sesuai ketentuan. |

---

### `GET` /api/pendidikan/{id}
**Ringkasan:** Detail Jenjang Pendidikan
**Deskripsi:** Endpoint API untuk Detail Jenjang Pendidikan.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `PUT` /api/pendidikan/{id}
**Ringkasan:** Update Jenjang Pendidikan
**Deskripsi:** Endpoint API untuk Update Jenjang Pendidikan.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `jenjang` | `string` | Tidak | - | `Doktor Terapan (S3 Terapan)` |

##### Contoh Payload Request:
```json
{
  "jenjang": "Doktor Terapan (S3 Terapan)"
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |
| `422` | Validasi gagal: format data input tidak sesuai ketentuan. |

---

### `DELETE` /api/pendidikan/{id}
**Ringkasan:** Hapus Jenjang Pendidikan
**Deskripsi:** Endpoint API untuk Hapus Jenjang Pendidikan.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

## Bidang Keahlian
> Modul: **Bidang Keahlian** | Jumlah: 5 endpoint

### `GET` /api/bidang-keahlian
**Ringkasan:** Semua Bidang Keahlian
**Deskripsi:** Endpoint API untuk Semua Bidang Keahlian.

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `POST` /api/bidang-keahlian
**Ringkasan:** Tambah Bidang Keahlian
**Deskripsi:** Endpoint API untuk Tambah Bidang Keahlian.

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `nama_bidang` | `string` | Tidak | - | `DevOps & Site Reliability Engineering` |

##### Contoh Payload Request:
```json
{
  "nama_bidang": "DevOps & Site Reliability Engineering"
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat / diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |
| `422` | Validasi gagal: format data input tidak sesuai ketentuan. |

---

### `GET` /api/bidang-keahlian/{id}
**Ringkasan:** Detail Bidang Keahlian
**Deskripsi:** Endpoint API untuk Detail Bidang Keahlian.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `PUT` /api/bidang-keahlian/{id}
**Ringkasan:** Update Bidang Keahlian
**Deskripsi:** Endpoint API untuk Update Bidang Keahlian.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `nama_bidang` | `string` | Tidak | - | `Cloud Computing & Distributed Systems` |

##### Contoh Payload Request:
```json
{
  "nama_bidang": "Cloud Computing & Distributed Systems"
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |
| `422` | Validasi gagal: format data input tidak sesuai ketentuan. |

---

### `DELETE` /api/bidang-keahlian/{id}
**Ringkasan:** Hapus Bidang Keahlian
**Deskripsi:** Endpoint API untuk Hapus Bidang Keahlian.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

## Mitra
> Modul: **Mitra** | Jumlah: 5 endpoint

### `GET` /api/mitra
**Ringkasan:** Semua Mitra
**Deskripsi:** Endpoint API untuk Semua Mitra.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `search` | `query` | `string` | Tidak | Filter query parameter: search |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `POST` /api/mitra
**Ringkasan:** Tambah Mitra
**Deskripsi:** Endpoint API untuk Tambah Mitra.

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `nama_instansi` | `string` | Tidak | - | `PT Telekomunikasi Selular (Telkomsel)` |
| `alamat` | `string` | Tidak | - | `Telkom Landmark Tower, Jl. Jend. Gatot Subroto Kav. 52 Jakarta` |
| `email` | `string` | Tidak | - | `partnership@telkomsel.co.id` |
| `telepon` | `string` | Tidak | - | `021-5240811` |

##### Contoh Payload Request:
```json
{
  "nama_instansi": "PT Telekomunikasi Selular (Telkomsel)",
  "alamat": "Telkom Landmark Tower, Jl. Jend. Gatot Subroto Kav. 52 Jakarta",
  "email": "partnership@telkomsel.co.id",
  "telepon": "021-5240811"
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat / diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |
| `422` | Validasi gagal: format data input tidak sesuai ketentuan. |

---

### `GET` /api/mitra/{id}
**Ringkasan:** Detail Mitra
**Deskripsi:** Endpoint API untuk Detail Mitra.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `PUT` /api/mitra/{id}
**Ringkasan:** Update Mitra
**Deskripsi:** Endpoint API untuk Update Mitra.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `nama_instansi` | `string` | Tidak | - | `PT Telkomsel Indonesia Tbk` |
| `alamat` | `string` | Tidak | - | `The Telkom Hub, Jl. Gatot Subroto No. 52 Jakarta Selatan` |
| `email` | `string` | Tidak | - | `academic-relation@telkomsel.co.id` |
| `telepon` | `string` | Tidak | - | `021-5240812` |

##### Contoh Payload Request:
```json
{
  "nama_instansi": "PT Telkomsel Indonesia Tbk",
  "alamat": "The Telkom Hub, Jl. Gatot Subroto No. 52 Jakarta Selatan",
  "email": "academic-relation@telkomsel.co.id",
  "telepon": "021-5240812"
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |
| `422` | Validasi gagal: format data input tidak sesuai ketentuan. |

---

### `DELETE` /api/mitra/{id}
**Ringkasan:** Hapus Mitra
**Deskripsi:** Endpoint API untuk Hapus Mitra.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

## Jenis Kegiatan
> Modul: **Jenis Kegiatan** | Jumlah: 5 endpoint

### `GET` /api/jenis-kegiatan
**Ringkasan:** Semua Jenis Kegiatan
**Deskripsi:** Endpoint API untuk Semua Jenis Kegiatan.

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `POST` /api/jenis-kegiatan
**Ringkasan:** Tambah Jenis Kegiatan
**Deskripsi:** Endpoint API untuk Tambah Jenis Kegiatan.

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `nama_jenis_kegiatan` | `string` | Tidak | - | `Penelitian Terapan Industri` |
| `deskripsi` | `string` | Tidak | - | `Riset terapan berorientasi produk industri dan komersialisasi` |

##### Contoh Payload Request:
```json
{
  "nama_jenis_kegiatan": "Penelitian Terapan Industri",
  "deskripsi": "Riset terapan berorientasi produk industri dan komersialisasi"
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat / diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |
| `422` | Validasi gagal: format data input tidak sesuai ketentuan. |

---

### `GET` /api/jenis-kegiatan/{id}
**Ringkasan:** Detail Jenis Kegiatan
**Deskripsi:** Endpoint API untuk Detail Jenis Kegiatan.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `PUT` /api/jenis-kegiatan/{id}
**Ringkasan:** Update Jenis Kegiatan
**Deskripsi:** Endpoint API untuk Update Jenis Kegiatan.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `nama_jenis_kegiatan` | `string` | Tidak | - | `Penelitian Fundamental & Keilmuan` |
| `deskripsi` | `string` | Tidak | - | `Pengembangan konsep teori dan metodologi baru` |

##### Contoh Payload Request:
```json
{
  "nama_jenis_kegiatan": "Penelitian Fundamental & Keilmuan",
  "deskripsi": "Pengembangan konsep teori dan metodologi baru"
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |
| `422` | Validasi gagal: format data input tidak sesuai ketentuan. |

---

### `DELETE` /api/jenis-kegiatan/{id}
**Ringkasan:** Hapus Jenis Kegiatan
**Deskripsi:** Endpoint API untuk Hapus Jenis Kegiatan.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

## Jenis Luaran
> Modul: **Jenis Luaran** | Jumlah: 5 endpoint

### `GET` /api/jenis-luaran
**Ringkasan:** Semua Jenis Luaran
**Deskripsi:** Endpoint API untuk Semua Jenis Luaran.

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `POST` /api/jenis-luaran
**Ringkasan:** Tambah Jenis Luaran
**Deskripsi:** Endpoint API untuk Tambah Jenis Luaran.

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `nama_jenis_luaran` | `string` | Tidak | - | `Jurnal` |
| `indeks` | `string` | Tidak | - | `Scopus Q1` |

##### Contoh Payload Request:
```json
{
  "nama_jenis_luaran": "Jurnal",
  "indeks": "Scopus Q1"
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat / diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |
| `422` | Validasi gagal: format data input tidak sesuai ketentuan. |

---

### `GET` /api/jenis-luaran/{id}
**Ringkasan:** Detail Jenis Luaran
**Deskripsi:** Endpoint API untuk Detail Jenis Luaran.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `PUT` /api/jenis-luaran/{id}
**Ringkasan:** Update Jenis Luaran
**Deskripsi:** Endpoint API untuk Update Jenis Luaran.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `nama_jenis_luaran` | `string` | Tidak | - | `Jurnal` |
| `indeks` | `string` | Tidak | - | `Sinta 1` |

##### Contoh Payload Request:
```json
{
  "nama_jenis_luaran": "Jurnal",
  "indeks": "Sinta 1"
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |
| `422` | Validasi gagal: format data input tidak sesuai ketentuan. |

---

### `DELETE` /api/jenis-luaran/{id}
**Ringkasan:** Hapus Jenis Luaran
**Deskripsi:** Endpoint API untuk Hapus Jenis Luaran.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

## Jenis Kerja Sama
> Modul: **Jenis Kerja Sama** | Jumlah: 5 endpoint

### `GET` /api/jenis-kerja-sama
**Ringkasan:** Semua Jenis Kerja Sama
**Deskripsi:** Endpoint API untuk Semua Jenis Kerja Sama.

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `POST` /api/jenis-kerja-sama
**Ringkasan:** Tambah Jenis Kerja Sama
**Deskripsi:** Endpoint API untuk Tambah Jenis Kerja Sama.

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `nama_jenis_kerjasama` | `string` | Tidak | - | `Letter of Intent (LoI)` |

##### Contoh Payload Request:
```json
{
  "nama_jenis_kerjasama": "Letter of Intent (LoI)"
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat / diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |
| `422` | Validasi gagal: format data input tidak sesuai ketentuan. |

---

### `GET` /api/jenis-kerja-sama/{id}
**Ringkasan:** Detail Jenis Kerja Sama
**Deskripsi:** Endpoint API untuk Detail Jenis Kerja Sama.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `PUT` /api/jenis-kerja-sama/{id}
**Ringkasan:** Update Jenis Kerja Sama
**Deskripsi:** Endpoint API untuk Update Jenis Kerja Sama.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `nama_jenis_kerjasama` | `string` | Tidak | - | `MoU (Memorandum of Understanding) Multilateral` |

##### Contoh Payload Request:
```json
{
  "nama_jenis_kerjasama": "MoU (Memorandum of Understanding) Multilateral"
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |
| `422` | Validasi gagal: format data input tidak sesuai ketentuan. |

---

### `DELETE` /api/jenis-kerja-sama/{id}
**Ringkasan:** Hapus Jenis Kerja Sama
**Deskripsi:** Endpoint API untuk Hapus Jenis Kerja Sama.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

## Dosen
> Modul: **Dosen** | Jumlah: 7 endpoint

### `GET` /api/dosen
**Ringkasan:** Semua Data Dosen
**Deskripsi:** Endpoint API untuk Semua Data Dosen.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `search` | `query` | `string` | Tidak | Filter query parameter: search |
| `status` | `query` | `string` | Tidak | Filter query parameter: status |
| `per_page` | `query` | `string` | Tidak | Filter query parameter: per_page |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `POST` /api/dosen
**Ringkasan:** Tambah Data Dosen
**Deskripsi:** Endpoint API untuk Tambah Data Dosen.

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `id_jabatan` | `integer` | Tidak | - | `1` |
| `id_pendidikan` | `integer` | Tidak | - | `1` |
| `nidn` | `string` | Tidak | - | `0015088501` |
| `nama_dosen` | `string` | Tidak | - | `Dr. Ir. Ahmad Dahlan, M.T.` |
| `email` | `string` | Tidak | - | `ahmad.dahlan@polines.ac.id` |
| `status_dosen` | `string` | Tidak | - | `DTPS` |
| `sertifikasi` | `string` | Tidak | - | `Pendidik Profesional (Kemenristekdikti)` |
| `bidang_keahlian_ids` | `array` | Tidak | - | - |

##### Contoh Payload Request:
```json
{
  "id_jabatan": 1,
  "id_pendidikan": 1,
  "nidn": "0015088501",
  "nama_dosen": "Dr. Ir. Ahmad Dahlan, M.T.",
  "email": "ahmad.dahlan@polines.ac.id",
  "status_dosen": "DTPS",
  "sertifikasi": "Pendidik Profesional (Kemenristekdikti)",
  "bidang_keahlian_ids": []
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat / diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |
| `422` | Validasi gagal: format data input tidak sesuai ketentuan. |

---

### `GET` /api/dosen/{id}
**Ringkasan:** Detail Dosen
**Deskripsi:** Endpoint API untuk Detail Dosen.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `PUT` /api/dosen/{id}
**Ringkasan:** Update Data Dosen
**Deskripsi:** Endpoint API untuk Update Data Dosen.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `id_jabatan` | `integer` | Tidak | - | `2` |
| `id_pendidikan` | `integer` | Tidak | - | `3` |
| `nidn` | `string` | Tidak | - | `0015088501` |
| `nama_dosen` | `string` | Tidak | - | `Prof. Dr. Ir. Ahmad Dahlan, M.T., IPU` |
| `email` | `string` | Tidak | - | `ahmad.dahlan@polines.ac.id` |
| `status_dosen` | `string` | Tidak | - | `DTPS` |
| `sertifikasi` | `string` | Tidak | - | `Sertifikasi Asesor Kompetensi BNSP & Pendidik` |
| `bidang_keahlian_ids` | `array` | Tidak | - | - |

##### Contoh Payload Request:
```json
{
  "id_jabatan": 2,
  "id_pendidikan": 3,
  "nidn": "0015088501",
  "nama_dosen": "Prof. Dr. Ir. Ahmad Dahlan, M.T., IPU",
  "email": "ahmad.dahlan@polines.ac.id",
  "status_dosen": "DTPS",
  "sertifikasi": "Sertifikasi Asesor Kompetensi BNSP & Pendidik",
  "bidang_keahlian_ids": []
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |
| `422` | Validasi gagal: format data input tidak sesuai ketentuan. |

---

### `DELETE` /api/dosen/{id}
**Ringkasan:** Hapus Dosen
**Deskripsi:** Endpoint API untuk Hapus Dosen.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `POST` /api/dosen/import
**Ringkasan:** Import Excel Dosen
**Deskripsi:** Endpoint API untuk Import Excel Dosen.

#### Request Body (`application/json`)
#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat / diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |
| `422` | Validasi gagal: format data input tidak sesuai ketentuan. |

---

### `POST` /api/dosen/{id}/restore
**Ringkasan:** Restore Dosen
**Deskripsi:** Endpoint API untuk Restore Dosen.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat / diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |
| `422` | Validasi gagal: format data input tidak sesuai ketentuan. |

---

## Tenaga Kependidikan
> Modul: **Tenaga Kependidikan** | Jumlah: 5 endpoint

### `GET` /api/tendik
**Ringkasan:** Semua Tenaga Kependidikan
**Deskripsi:** Endpoint API untuk Semua Tenaga Kependidikan.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `search` | `query` | `string` | Tidak | Filter query parameter: search |
| `per_page` | `query` | `string` | Tidak | Filter query parameter: per_page |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `POST` /api/tendik
**Ringkasan:** Tambah Tenaga Kependidikan
**Deskripsi:** Endpoint API untuk Tambah Tenaga Kependidikan.

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `id_pendidikan` | `integer` | Tidak | - | `4` |
| `nama_tendik` | `string` | Tidak | - | `Budi Santoso, S.Kom.` |
| `jabatan_tendik` | `string` | Tidak | - | `Pranata Laboratorium Pendidikan (PLP)` |
| `nip` | `string` | Tidak | - | `199208152018031002` |

##### Contoh Payload Request:
```json
{
  "id_pendidikan": 4,
  "nama_tendik": "Budi Santoso, S.Kom.",
  "jabatan_tendik": "Pranata Laboratorium Pendidikan (PLP)",
  "nip": "199208152018031002"
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat / diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |
| `422` | Validasi gagal: format data input tidak sesuai ketentuan. |

---

### `GET` /api/tendik/{id}
**Ringkasan:** Detail Tenaga Kependidikan
**Deskripsi:** Endpoint API untuk Detail Tenaga Kependidikan.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `PUT` /api/tendik/{id}
**Ringkasan:** Update Tenaga Kependidikan
**Deskripsi:** Endpoint API untuk Update Tenaga Kependidikan.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `id_pendidikan` | `integer` | Tidak | - | `1` |
| `nama_tendik` | `string` | Tidak | - | `Budi Santoso, M.Kom.` |
| `jabatan_tendik` | `string` | Tidak | - | `Kepala Laboratorium Rekayasa Perangkat Lunak` |
| `nip` | `string` | Tidak | - | `199208152018031002` |

##### Contoh Payload Request:
```json
{
  "id_pendidikan": 1,
  "nama_tendik": "Budi Santoso, M.Kom.",
  "jabatan_tendik": "Kepala Laboratorium Rekayasa Perangkat Lunak",
  "nip": "199208152018031002"
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |
| `422` | Validasi gagal: format data input tidak sesuai ketentuan. |

---

### `DELETE` /api/tendik/{id}
**Ringkasan:** Hapus Tenaga Kependidikan
**Deskripsi:** Endpoint API untuk Hapus Tenaga Kependidikan.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

## Kegiatan
> Modul: **Kegiatan** | Jumlah: 5 endpoint

### `GET` /api/kegiatan
**Ringkasan:** Semua Kegiatan
**Deskripsi:** Endpoint API untuk Semua Kegiatan.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `search` | `query` | `string` | Tidak | Filter query parameter: search |
| `id_jenis_kegiatan` | `query` | `string` | Tidak | Filter query parameter: id_jenis_kegiatan |
| `tahun_kegiatan` | `query` | `string` | Tidak | Filter query parameter: tahun_kegiatan |
| `status_kegiatan` | `query` | `string` | Tidak | Filter query parameter: status_kegiatan |
| `per_page` | `query` | `string` | Tidak | Filter query parameter: per_page |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `POST` /api/kegiatan
**Ringkasan:** Tambah Kegiatan
**Deskripsi:** Endpoint API untuk Tambah Kegiatan.

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `id_jenis_kegiatan` | `integer` | Tidak | - | `1` |
| `judul_kegiatan` | `string` | Tidak | - | `Pengembangan Sistem Deteksi Intrusi Jaringan Berbasis Deep Learning pada Infrastruktur IoT Kampus` |
| `lokasi_kegiatan` | `string` | Tidak | - | `Laboratorium Jaringan Politeknik Negeri Semarang` |
| `tahun_usulan` | `integer` | Tidak | - | `2024` |
| `tahun_kegiatan` | `integer` | Tidak | - | `2025` |
| `tahun_pelaksanaan` | `integer` | Tidak | - | `2025` |
| `lama_kegiatan` | `string` | Tidak | - | `12 Bulan` |
| `status_kegiatan` | `string` | Tidak | - | `Berjalan` |
| `in_kind` | `string` | Tidak | - | `Penggunaan Fasilitas Server GPU & Cluster HPC Laboratorium TRPL` |
| `anggota` | `array` | Tidak | - | - |
| `pendanaan` | `array` | Tidak | - | - |

##### Contoh Payload Request:
```json
{
  "id_jenis_kegiatan": 1,
  "judul_kegiatan": "Pengembangan Sistem Deteksi Intrusi Jaringan Berbasis Deep Learning pada Infrastruktur IoT Kampus",
  "lokasi_kegiatan": "Laboratorium Jaringan Politeknik Negeri Semarang",
  "tahun_usulan": 2024,
  "tahun_kegiatan": 2025,
  "tahun_pelaksanaan": 2025,
  "lama_kegiatan": "12 Bulan",
  "status_kegiatan": "Berjalan",
  "in_kind": "Penggunaan Fasilitas Server GPU & Cluster HPC Laboratorium TRPL",
  "anggota": [],
  "pendanaan": []
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat / diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |
| `422` | Validasi gagal: format data input tidak sesuai ketentuan. |

---

### `GET` /api/kegiatan/{id}
**Ringkasan:** Detail Kegiatan
**Deskripsi:** Endpoint API untuk Detail Kegiatan.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `PUT` /api/kegiatan/{id}
**Ringkasan:** Update Kegiatan
**Deskripsi:** Endpoint API untuk Update Kegiatan.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `id_jenis_kegiatan` | `integer` | Tidak | - | `1` |
| `judul_kegiatan` | `string` | Tidak | - | `Pengembangan dan Implementasi Model Deep Learning untuk Proteksi Jaringan Kampus` |
| `lokasi_kegiatan` | `string` | Tidak | - | `Data Center Politeknik Negeri Semarang` |
| `tahun_kegiatan` | `integer` | Tidak | - | `2025` |
| `tahun_pelaksanaan` | `integer` | Tidak | - | `2025` |
| `lama_kegiatan` | `string` | Tidak | - | `12 Bulan` |
| `status_kegiatan` | `string` | Tidak | - | `Selesai` |
| `in_kind` | `string` | Tidak | - | `Lisensi Dataset Trafik & Akses Cloud Storage` |
| `anggota` | `array` | Tidak | - | - |
| `pendanaan` | `array` | Tidak | - | - |

##### Contoh Payload Request:
```json
{
  "id_jenis_kegiatan": 1,
  "judul_kegiatan": "Pengembangan dan Implementasi Model Deep Learning untuk Proteksi Jaringan Kampus",
  "lokasi_kegiatan": "Data Center Politeknik Negeri Semarang",
  "tahun_kegiatan": 2025,
  "tahun_pelaksanaan": 2025,
  "lama_kegiatan": "12 Bulan",
  "status_kegiatan": "Selesai",
  "in_kind": "Lisensi Dataset Trafik & Akses Cloud Storage",
  "anggota": [],
  "pendanaan": []
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |
| `422` | Validasi gagal: format data input tidak sesuai ketentuan. |

---

### `DELETE` /api/kegiatan/{id}
**Ringkasan:** Kegiatan
**Deskripsi:** Endpoint API untuk Kegiatan.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

## Luaran
> Modul: **Luaran** | Jumlah: 5 endpoint

### `GET` /api/luaran
**Ringkasan:** Semua Luaran
**Deskripsi:** Endpoint API untuk Semua Luaran.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `search` | `query` | `string` | Tidak | Filter query parameter: search |
| `id_jenis_luaran` | `query` | `string` | Tidak | Filter query parameter: id_jenis_luaran |
| `tahun_terbit` | `query` | `string` | Tidak | Filter query parameter: tahun_terbit |
| `per_page` | `query` | `string` | Tidak | Filter query parameter: per_page |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `POST` /api/luaran
**Ringkasan:** Tambah Luaran
**Deskripsi:** Endpoint API untuk Tambah Luaran - Jurnal Ilmiah.
- Tambah Luaran - Buku Ajar / Monograf
- Tambah Luaran - HKI / Hak Cipta
- Tambah Luaran - Prosiding Seminar
- Tambah Luaran - Produk / Prototipe Teknologi

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `id_jenis_luaran` | `integer` | Tidak | - | `1` |
| `id_kegiatan` | `integer` | Tidak | - | `1` |
| `id_dosen` | `integer` | Tidak | - | `1` |
| `nama_jurnal` | `string` | Tidak | - | `IEEE Transactions on Network and Service Management` |
| `issn` | `string` | Tidak | - | `1932-4537` |
| `volume` | `string` | Tidak | - | `22` |
| `nomor_edisi` | `string` | Tidak | - | `2` |
| `halaman_jurnal` | `string` | Tidak | - | `210-224` |
| `tanggal_terbit` | `string` | Tidak | - | `2025-06-18` |
| `doi` | `string` | Tidak | - | `10.1109/TNSM.2025.3214567` |
| `indeksasi` | `string` | Tidak | - | `Scopus Q1 / SJR 1.25` |
| `tautan_jurnal` | `string` | Tidak | - | `https://drive.google.com/file/d/xxx/view` |

##### Contoh Payload Request:
```json
{
  "id_jenis_luaran": 1,
  "id_kegiatan": 1,
  "id_dosen": 1,
  "nama_jurnal": "IEEE Transactions on Network and Service Management",
  "issn": "1932-4537",
  "volume": "22",
  "nomor_edisi": "2",
  "halaman_jurnal": "210-224",
  "tanggal_terbit": "2025-06-18",
  "doi": "10.1109/TNSM.2025.3214567",
  "indeksasi": "Scopus Q1 / SJR 1.25",
  "tautan_jurnal": "https://drive.google.com/file/d/xxx/view"
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat / diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |
| `422` | Validasi gagal: format data input tidak sesuai ketentuan. |

---

### `GET` /api/luaran/{id}
**Ringkasan:** Detail Luaran
**Deskripsi:** Endpoint API untuk Detail Luaran.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `PUT` /api/luaran/{id}
**Ringkasan:** Update Luaran
**Deskripsi:** Endpoint API untuk Update Luaran.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `id_jenis_luaran` | `integer` | Tidak | - | `1` |
| `id_kegiatan` | `integer` | Tidak | - | `1` |
| `id_dosen` | `integer` | Tidak | - | `1` |
| `nama_jurnal` | `string` | Tidak | - | `IEEE Transactions on Network and Service Management (Final Published)` |
| `issn` | `string` | Tidak | - | `1932-4537` |
| `volume` | `string` | Tidak | - | `22` |
| `nomor_edisi` | `string` | Tidak | - | `3` |
| `halaman_jurnal` | `string` | Tidak | - | `301-315` |
| `tanggal_terbit` | `string` | Tidak | - | `2025-09-01` |
| `doi` | `string` | Tidak | - | `10.1109/TNSM.2025.3214999` |
| `indeksasi` | `string` | Tidak | - | `Scopus Q1` |

##### Contoh Payload Request:
```json
{
  "id_jenis_luaran": 1,
  "id_kegiatan": 1,
  "id_dosen": 1,
  "nama_jurnal": "IEEE Transactions on Network and Service Management (Final Published)",
  "issn": "1932-4537",
  "volume": "22",
  "nomor_edisi": "3",
  "halaman_jurnal": "301-315",
  "tanggal_terbit": "2025-09-01",
  "doi": "10.1109/TNSM.2025.3214999",
  "indeksasi": "Scopus Q1"
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |
| `422` | Validasi gagal: format data input tidak sesuai ketentuan. |

---

### `DELETE` /api/luaran/{id}
**Ringkasan:** Luaran
**Deskripsi:** Endpoint API untuk Luaran.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

## Kerja Sama
> Modul: **Kerja Sama** | Jumlah: 10 endpoint

### `GET` /api/kerja-sama
**Ringkasan:** Semua Kerja Sama
**Deskripsi:** Endpoint API untuk Semua Kerja Sama.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `search` | `query` | `string` | Tidak | Filter query parameter: search |
| `status` | `query` | `string` | Tidak | Filter query parameter: status |
| `tingkat` | `query` | `string` | Tidak | Filter query parameter: tingkat |
| `per_page` | `query` | `string` | Tidak | Filter query parameter: per_page |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `POST` /api/kerja-sama
**Ringkasan:** Tambah Dokumen Kerja Sama
**Deskripsi:** Endpoint API untuk Tambah Dokumen Kerja Sama.

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `id_mitra` | `integer` | Tidak | - | `1` |
| `id_jenis_kerjasama` | `integer` | Tidak | - | `1` |
| `id_dosen` | `integer` | Tidak | - | `1` |
| `judul_kerja_sama` | `string` | Tidak | - | `Kerja Sama Penyelenggaraan Kelas Industri dan Riset Terapan Smart City dengan PT Telkomsel` |
| `tingkat` | `string` | Tidak | - | `Nasional` |
| `bentuk_kegiatan` | `string` | Tidak | - | `Penyusunan Kurikulum Bersama, Dosen Praktisi Industri, dan Sertifikasi Kompetensi` |
| `tanggal_mulai` | `string` | Tidak | - | `2025-01-01` |
| `tanggal_selesai` | `string` | Tidak | - | `2027-12-31` |
| `bukti_dokumen` | `string` | Tidak | - | `https://drive.google.com/file/d/1MoU-Telkomsel-2025/view` |
| `nomor_dokumen` | `string` | Tidak | - | `045/KS/POLINES-TELKOMSEL/I/2025` |
| `jenis_dokumen` | `string` | Tidak | - | `MoU (Memorandum of Understanding)` |
| `status` | `string` | Tidak | - | `Aktif` |

##### Contoh Payload Request:
```json
{
  "id_mitra": 1,
  "id_jenis_kerjasama": 1,
  "id_dosen": 1,
  "judul_kerja_sama": "Kerja Sama Penyelenggaraan Kelas Industri dan Riset Terapan Smart City dengan PT Telkomsel",
  "tingkat": "Nasional",
  "bentuk_kegiatan": "Penyusunan Kurikulum Bersama, Dosen Praktisi Industri, dan Sertifikasi Kompetensi",
  "tanggal_mulai": "2025-01-01",
  "tanggal_selesai": "2027-12-31",
  "bukti_dokumen": "https://drive.google.com/file/d/1MoU-Telkomsel-2025/view",
  "nomor_dokumen": "045/KS/POLINES-TELKOMSEL/I/2025",
  "jenis_dokumen": "MoU (Memorandum of Understanding)",
  "status": "Aktif"
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat / diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |
| `422` | Validasi gagal: format data input tidak sesuai ketentuan. |

---

### `GET` /api/kerja-sama/{id}
**Ringkasan:** Detail Kerja Sama
**Deskripsi:** Endpoint API untuk Detail Kerja Sama.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `PUT` /api/kerja-sama/{id}
**Ringkasan:** Update Kerja Sama
**Deskripsi:** Endpoint API untuk Update Kerja Sama.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `id_mitra` | `integer` | Tidak | - | `1` |
| `id_jenis_kerjasama` | `integer` | Tidak | - | `1` |
| `id_dosen` | `integer` | Tidak | - | `1` |
| `judul_kerja_sama` | `string` | Tidak | - | `Kerja Sama Kelas Industri, Riset Terapan Smart City, dan Magang Bersertifikat Industri PT Telkomsel` |
| `tingkat` | `string` | Tidak | - | `Nasional` |
| `bentuk_kegiatan` | `string` | Tidak | - | `Penyusunan Kurikulum, Magang Kampus Merdeka, dan Riset Bersama` |
| `tanggal_mulai` | `string` | Tidak | - | `2025-01-01` |
| `tanggal_selesai` | `string` | Tidak | - | `2028-12-31` |
| `nomor_dokumen` | `string` | Tidak | - | `045/KS/POLINES-TELKOMSEL/I/2025-Rev1` |
| `status` | `string` | Tidak | - | `Aktif` |

##### Contoh Payload Request:
```json
{
  "id_mitra": 1,
  "id_jenis_kerjasama": 1,
  "id_dosen": 1,
  "judul_kerja_sama": "Kerja Sama Kelas Industri, Riset Terapan Smart City, dan Magang Bersertifikat Industri PT Telkomsel",
  "tingkat": "Nasional",
  "bentuk_kegiatan": "Penyusunan Kurikulum, Magang Kampus Merdeka, dan Riset Bersama",
  "tanggal_mulai": "2025-01-01",
  "tanggal_selesai": "2028-12-31",
  "nomor_dokumen": "045/KS/POLINES-TELKOMSEL/I/2025-Rev1",
  "status": "Aktif"
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |
| `422` | Validasi gagal: format data input tidak sesuai ketentuan. |

---

### `DELETE` /api/kerja-sama/{id}
**Ringkasan:** Kerja Sama
**Deskripsi:** Endpoint API untuk Kerja Sama.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `POST` /api/kerja-sama/{id}/perpanjang
**Ringkasan:** Perpanjang Kerja Sama
**Deskripsi:** Endpoint API untuk Perpanjang Kerja Sama.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `tanggal_selesai_baru` | `string` | Tidak | - | `2030-12-31` |
| `keterangan` | `string` | Tidak | - | `Perpanjangan Adendum Periode II berdasarkan hasil evaluasi kepuasan mitra industri` |

##### Contoh Payload Request:
```json
{
  "tanggal_selesai_baru": "2030-12-31",
  "keterangan": "Perpanjangan Adendum Periode II berdasarkan hasil evaluasi kepuasan mitra industri"
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat / diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |
| `422` | Validasi gagal: format data input tidak sesuai ketentuan. |

---

### `GET` /api/kerja-sama/{id}/aktivitas
**Ringkasan:** Aktivitas Kerja Sama
**Deskripsi:** Endpoint API untuk Aktivitas Kerja Sama.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `POST` /api/kerja-sama/{id}/aktivitas
**Ringkasan:** Tambah Aktivitas Kerja Sama
**Deskripsi:** Endpoint API untuk Tambah Aktivitas Kerja Sama.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `judul_aktivitas` | `string` | Tidak | - | `Workshop Dosen Praktisi Industri: Cloud Native Architecture & Microservices` |
| `tanggal_pelaksanaan` | `string` | Tidak | - | `2025-04-20` |
| `deskripsi` | `string` | Tidak | - | `Pelatihan intensif 3 hari bersama Principal Architect Telkomsel untuk 25 dosen jurusan Teknik Komputer` |
| `bukti_dokumen` | `string` | Tidak | - | `https://drive.google.com/file/d/1Bukti-Workshop-Telkomsel/view` |

##### Contoh Payload Request:
```json
{
  "judul_aktivitas": "Workshop Dosen Praktisi Industri: Cloud Native Architecture & Microservices",
  "tanggal_pelaksanaan": "2025-04-20",
  "deskripsi": "Pelatihan intensif 3 hari bersama Principal Architect Telkomsel untuk 25 dosen jurusan Teknik Komputer",
  "bukti_dokumen": "https://drive.google.com/file/d/1Bukti-Workshop-Telkomsel/view"
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat / diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |
| `422` | Validasi gagal: format data input tidak sesuai ketentuan. |

---

### `GET` /api/kerja-sama/reminder-kedaluwarsa
**Ringkasan:** Monitoring Reminder Kedaluwarsa Kerja Sama
**Deskripsi:** Mengambil daftar dokumen kerja sama yang telah kedaluwarsa atau akan kedaluwarsa dalam 30 hari ke depan.

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Daftar reminder masa berlaku kerja sama berhasil diambil. |

---

### `POST` /api/kerja-sama/check-kedaluwarsa
**Ringkasan:** Trigger Sinkronisasi Status Kedaluwarsa & Notifikasi Otomatis
**Deskripsi:** Memperbarui status dokumen kerja sama yang lewat masa berlaku menjadi "Kedaluwarsa" dan mengirimkan notifikasi in-app otomatis kepada Administrator dan Kaprodi.

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Pemeriksaan status kedaluwarsa dan notifikasi berhasil. |

---

## Aktivitas Kerja Sama
> Modul: **Aktivitas Kerja Sama** | Jumlah: 5 endpoint

### `GET` /api/aktivitas-kerja-sama
**Ringkasan:** Semua Aktivitas Kerja Sama
**Deskripsi:** Endpoint API untuk Semua Aktivitas Kerja Sama.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `search` | `query` | `string` | Tidak | Filter query parameter: search |
| `id_kerja_sama` | `query` | `string` | Tidak | Filter query parameter: id_kerja_sama |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `POST` /api/aktivitas-kerja-sama
**Ringkasan:** Tambah Aktivitas Standalone
**Deskripsi:** Endpoint API untuk Tambah Aktivitas Standalone.

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `id_kerja_sama` | `integer` | Tidak | - | `1` |
| `judul_aktivitas` | `string` | Tidak | - | `Kuliah Umum Kemitraan: Peluang Karir Network Engineer 5G` |
| `tanggal_pelaksanaan` | `string` | Tidak | - | `2025-05-15` |
| `deskripsi` | `string` | Tidak | - | `Kuliah umum dihadiri oleh 150 mahasiswa tingkat akhir TRPL dan Teknik Komputer` |
| `bukti_dokumen` | `string` | Tidak | - | `https://drive.google.com/file/d/1Absensi-Foto-KuliahUmum/view` |

##### Contoh Payload Request:
```json
{
  "id_kerja_sama": 1,
  "judul_aktivitas": "Kuliah Umum Kemitraan: Peluang Karir Network Engineer 5G",
  "tanggal_pelaksanaan": "2025-05-15",
  "deskripsi": "Kuliah umum dihadiri oleh 150 mahasiswa tingkat akhir TRPL dan Teknik Komputer",
  "bukti_dokumen": "https://drive.google.com/file/d/1Absensi-Foto-KuliahUmum/view"
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat / diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |
| `422` | Validasi gagal: format data input tidak sesuai ketentuan. |

---

### `GET` /api/aktivitas-kerja-sama/{id}
**Ringkasan:** Detail Aktivitas Standalone
**Deskripsi:** Endpoint API untuk Detail Aktivitas Standalone.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `PUT` /api/aktivitas-kerja-sama/{id}
**Ringkasan:** Update Aktivitas Standalone
**Deskripsi:** Endpoint API untuk Update Aktivitas Standalone.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `judul_aktivitas` | `string` | Tidak | - | `Kuliah Umum Kemitraan: Peluang Karir Network & DevOps Engineer 5G` |
| `tanggal_pelaksanaan` | `string` | Tidak | - | `2025-05-15` |
| `deskripsi` | `string` | Tidak | - | `Kuliah umum sukses dilaksanakan dengan sertifikat kehadiran berstandar industri` |

##### Contoh Payload Request:
```json
{
  "judul_aktivitas": "Kuliah Umum Kemitraan: Peluang Karir Network & DevOps Engineer 5G",
  "tanggal_pelaksanaan": "2025-05-15",
  "deskripsi": "Kuliah umum sukses dilaksanakan dengan sertifikat kehadiran berstandar industri"
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |
| `422` | Validasi gagal: format data input tidak sesuai ketentuan. |

---

### `DELETE` /api/aktivitas-kerja-sama/{id}
**Ringkasan:** Hapus Aktivitas Standalone
**Deskripsi:** Endpoint API untuk Hapus Aktivitas Standalone.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

## Evidence
> Modul: **Evidence** | Jumlah: 7 endpoint

### `GET` /api/evidence
**Ringkasan:** Semua Evidence
**Deskripsi:** Endpoint API untuk Semua Evidence.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `search` | `query` | `string` | Tidak | Filter query parameter: search |
| `jenis_dokumen` | `query` | `string` | Tidak | Filter query parameter: jenis_dokumen |
| `status_validasi` | `query` | `string` | Tidak | Filter query parameter: status_validasi |
| `id_kegiatan` | `query` | `string` | Tidak | Filter query parameter: id_kegiatan |
| `per_page` | `query` | `string` | Tidak | Filter query parameter: per_page |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `POST` /api/evidence
**Ringkasan:** Upload Berkas Fisik Evidence
**Deskripsi:** Endpoint API untuk Upload Berkas Fisik Evidence.
- Simpan Tautan Google Drive Evidence

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `nama_file` | `string` | Tidak | - | `https://drive.google.com/file/d/1xYz89AbCdEfGhIjKlMn/view?usp=sharing` |
| `jenis_dokumen` | `string` | Tidak | - | `Laporan Kemajuan Penelitian & Logbook 70%` |
| `id_kegiatan` | `integer` | Tidak | - | `1` |
| `status_validasi` | `string` | Tidak | - | `Menunggu Validasi` |
| `konfirmasi_lanjut` | `boolean` | Tidak | - | `True` |

##### Contoh Payload Request:
```json
{
  "nama_file": "https://drive.google.com/file/d/1xYz89AbCdEfGhIjKlMn/view?usp=sharing",
  "jenis_dokumen": "Laporan Kemajuan Penelitian & Logbook 70%",
  "id_kegiatan": 1,
  "status_validasi": "Menunggu Validasi",
  "konfirmasi_lanjut": true
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat / diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |
| `422` | Validasi gagal: format data input tidak sesuai ketentuan. |

---

### `GET` /api/evidence/{id}
**Ringkasan:** Detail Evidence
**Deskripsi:** Endpoint API untuk Detail Evidence.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `DELETE` /api/evidence/{id}
**Ringkasan:** Evidence
**Deskripsi:** Endpoint API untuk Evidence.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `GET` /api/evidence/{id}/download
**Ringkasan:** Unduh Berkas Fisik
**Deskripsi:** Endpoint API untuk Unduh Berkas Fisik.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `POST` /api/evidence/{id}/validasi
**Ringkasan:** Review Validasi Kaprodi
**Deskripsi:** Endpoint API untuk Review Validasi Kaprodi.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `status_validasi` | `string` | Tidak | - | `Valid` |
| `catatan_validasi` | `string` | Tidak | - | `Dokumen proposal lengkap, tanda tangan mitra dan ketua peneliti sah, memenuhi syarat instrumen akreditasi LAM.` |

##### Contoh Payload Request:
```json
{
  "status_validasi": "Valid",
  "catatan_validasi": "Dokumen proposal lengkap, tanda tangan mitra dan ketua peneliti sah, memenuhi syarat instrumen akreditasi LAM."
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat / diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |
| `422` | Validasi gagal: format data input tidak sesuai ketentuan. |

---

### `POST` /api/evidence/{id}/ganti-link
**Ringkasan:** Ganti Link Drive
**Deskripsi:** Endpoint API untuk Ganti Link Drive.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID entitas data |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `url_drive_baru` | `string` | Tidak | - | `https://drive.google.com/file/d/1NewLinkUpdatedRevisi2025/view?usp=sharing` |
| `alasan_perubahan` | `string` | Tidak | - | `Pembaruan berkas perbaikan stempel basah kemitraan dan lembar pengesahan` |

##### Contoh Payload Request:
```json
{
  "url_drive_baru": "https://drive.google.com/file/d/1NewLinkUpdatedRevisi2025/view?usp=sharing",
  "alasan_perubahan": "Pembaruan berkas perbaikan stempel basah kemitraan dan lembar pengesahan"
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat / diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |
| `422` | Validasi gagal: format data input tidak sesuai ketentuan. |

---

## Validasi Mahasiswa
> Modul: **Validasi Mahasiswa** | Jumlah: 1 endpoint

### `POST` /api/k1/validasi-nim
**Ringkasan:** Validasi NIM Mahasiswa K1
**Deskripsi:** Endpoint API untuk Validasi NIM Mahasiswa K1.

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `nim` | `string` | Tidak | - | `3.34.21.0.01` |

##### Contoh Payload Request:
```json
{
  "nim": "3.34.21.0.01"
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data berhasil dibuat / diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |
| `422` | Validasi gagal: format data input tidak sesuai ketentuan. |

---

## Statistik
> Modul: **Statistik** | Jumlah: 7 endpoint

### `GET` /api/v1/dashboard
**Ringkasan:** Dashboard Analitik
**Deskripsi:** Endpoint API untuk Dashboard Analitik.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `tab` | `query` | `string` | Tidak | Filter query parameter: tab |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `GET` /api/v1/dosen/statistik
**Ringkasan:** Statistik Dosen
**Deskripsi:** Endpoint API untuk Statistik Dosen.

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `GET` /api/v1/dosen/rasio
**Ringkasan:** Rasio Dosen : Mahasiswa
**Deskripsi:** Endpoint API untuk Rasio Dosen : Mahasiswa.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `tahun` | `query` | `string` | Tidak | Filter query parameter: tahun |
| `prodi` | `query` | `string` | Tidak | Filter query parameter: prodi |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `GET` /api/v1/dosen/produktivitas
**Ringkasan:** Produktivitas Dosen
**Deskripsi:** Endpoint API untuk Produktivitas Dosen.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `tahun` | `query` | `string` | Tidak | Filter query parameter: tahun |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `GET` /api/v1/tridharma/summary
**Ringkasan:** Summary Tridharma
**Deskripsi:** Endpoint API untuk Summary Tridharma.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `tahun` | `query` | `string` | Tidak | Filter query parameter: tahun |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `GET` /api/v1/tridharma/tren
**Ringkasan:** Tren Tri Dharma
**Deskripsi:** Endpoint API untuk Tren Tri Dharma.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `ts` | `query` | `string` | Tidak | Filter query parameter: ts |
| `rentang` | `query` | `string` | Tidak | Filter query parameter: rentang |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

### `GET` /api/v1/kerjasama/aktif
**Ringkasan:** Kerja Sama Aktif
**Deskripsi:** Endpoint API untuk Kerja Sama Aktif.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `per_page` | `query` | `string` | Tidak | Filter query parameter: per_page |
| `search` | `query` | `string` | Tidak | Filter query parameter: search |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Operasi berhasil diproses. |
| `400` | Permintaan tidak valid / Bad Request. |
| `401` | Unauthenticated: Token JWT tidak valid atau sesi berakhir. |
| `404` | Data tidak ditemukan. |

---

## Sertifikasi
> Modul: **Sertifikasi** | Jumlah: 6 endpoint

### `GET` /api/sertifikasi
**Ringkasan:** Daftar Sertifikasi (Dosen & Tendik)
**Deskripsi:** Mengambil daftar data sertifikasi dengan paginasi dan filter lengkap (tipe pemilik dosen vs tendik, status masa berlaku aktif/kedaluwarsa/segera berakhir, tahun, dan pencarian teks luas).

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `search` | `query` | `string` | Tidak | Pencarian jenis sertifikasi, no. sertifikat, no. sk, penerbit, atau nama/NIDN/NIP pemilik |
| `tipe_pemilik` | `query` | `string` | Tidak | Filter berdasarkan pemilik sertifikasi: "dosen" atau "tendik" |
| `status_masa_berlaku` | `query` | `string` | Tidak | Filter status masa berlaku: "aktif", "kedaluwarsa", atau "segera_berakhir" |
| `hari_kedaluwarsa` | `query` | `integer` | Tidak | Ambang batas hari untuk filter segera_berakhir (default: 30 hari) |
| `tahun_sertifikasi` | `query` | `integer` | Tidak | Filter tahun spesifik penerbitan sertifikasi |
| `tahun_mulai` | `query` | `integer` | Tidak | Rentang tahun mulai penerbitan |
| `tahun_selesai` | `query` | `integer` | Tidak | Rentang tahun selesai penerbitan |
| `id_dosen` | `query` | `integer` | Tidak | Filter ID dosen tertentu |
| `id_tendik` | `query` | `integer` | Tidak | Filter ID tendik tertentu |
| `status_sertifikasi` | `query` | `string` | Tidak | Filter status sertifikasi eksplisit (misal: "Aktif", "Kedaluwarsa") |
| `per_page` | `query` | `integer` | Tidak | Jumlah data per halaman |
| `page` | `query` | `integer` | Tidak | Nomor halaman |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Data sertifikasi berhasil diambil. |

---

### `POST` /api/sertifikasi
**Ringkasan:** Tambah Data Sertifikasi Baru
**Deskripsi:** Menambahkan data sertifikasi baru (Dosen atau Tendik) dengan menyertakan tautan url_sertifikasi atau mengunggah berkas sertifikat, dan secara otomatis menyinkronkan ke profil Dosen/Tendik bersangkutan.

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `id_dosen` | `integer` | Tidak | ID Dosen jika sertifikasi milik dosen | `1` |
| `id_tendik` | `integer` | Tidak | ID Tendik jika sertifikasi milik tendik | - |
| `jenis_sertifikasi` | `string` | **Ya** | - | `Sertifikat Pendidik (Serdos)` |
| `bidang_studi` | `string` | Tidak | - | `Teknik Informatika / Rekayasa Perangkat Lunak` |
| `nomor_registrasi_pendidik` | `string` | Tidak | - | `REG-DIKTI-2023-8871` |
| `nomor_sk` | `string` | Tidak | - | `SK-SERTIF-2023-01` |
| `nomor_sertifikat` | `string` | Tidak | - | `CERT-KOMP-2023-45` |
| `lembaga_penerbit` | `string` | Tidak | - | `Kemendikbudristek / BNSP` |
| `tahun_sertifikasi` | `string` | **Ya** | Tanggal atau tahun sertifikasi (YYYY atau YYYY-MM-DD) | `2023-08-20` |
| `tanggal_kedaluwarsa` | `string (date)` | Tidak | - | `2028-12-31` |
| `status_sertifikasi` | `string` | Tidak | - | `Aktif` |
| `url_sertifikasi` | `string` | **Ya** | Tautan URL dokumen/berkas sertifikasi (Google Drive, Cloud Storage, dsb.) | `https://drive.google.com/file/d/1C-vDl0JDYJRJXnlhP4-onXRwUTBf6h1c/view?usp=sharing` |
| `url_drive` | `string` | Tidak | - | `https://drive.google.com/file/d/1C-vDl0JDYJRJXnlhP4-onXRwUTBf6h1c/view?usp=sharing` |

##### Contoh Payload Request:
```json
{
  "id_dosen": 1,
  "id_tendik": 1,
  "jenis_sertifikasi": "Sertifikat Pendidik (Serdos)",
  "bidang_studi": "Teknik Informatika / Rekayasa Perangkat Lunak",
  "nomor_registrasi_pendidik": "REG-DIKTI-2023-8871",
  "nomor_sk": "SK-SERTIF-2023-01",
  "nomor_sertifikat": "CERT-KOMP-2023-45",
  "lembaga_penerbit": "Kemendikbudristek / BNSP",
  "tahun_sertifikasi": "2023-08-20",
  "tanggal_kedaluwarsa": "2028-12-31",
  "status_sertifikasi": "Aktif",
  "url_sertifikasi": "https://drive.google.com/file/d/1C-vDl0JDYJRJXnlhP4-onXRwUTBf6h1c/view?usp=sharing",
  "url_drive": "https://drive.google.com/file/d/1C-vDl0JDYJRJXnlhP4-onXRwUTBf6h1c/view?usp=sharing"
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Data sertifikasi berhasil ditambahkan. |
| `422` | Validasi input gagal. |

---

### `GET` /api/sertifikasi/{id}
**Ringkasan:** Detail Sertifikasi
**Deskripsi:** Mengambil detail satu data sertifikasi beserta relasi pemilik (dosen/tendik) dan dokumen evidence pendukung.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID sertifikasi |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Detail sertifikasi berhasil diambil. |
| `404` | Data sertifikasi tidak ditemukan. |

---

### `PUT` /api/sertifikasi/{id}
**Ringkasan:** Perbarui Data Sertifikasi
**Deskripsi:** Memperbarui data sertifikasi dan secara otomatis menyinkronkan perubahan ke profil Dosen/Tendik bersangkutan.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID sertifikasi |

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `id_dosen` | `integer` | Tidak | - | - |
| `id_tendik` | `integer` | Tidak | - | - |
| `jenis_sertifikasi` | `string` | Tidak | - | - |
| `bidang_studi` | `string` | Tidak | - | - |
| `nomor_registrasi_pendidik` | `string` | Tidak | - | - |
| `nomor_sk` | `string` | Tidak | - | - |
| `nomor_sertifikat` | `string` | Tidak | - | - |
| `lembaga_penerbit` | `string` | Tidak | - | - |
| `tahun_sertifikasi` | `string` | Tidak | Tanggal atau tahun sertifikasi (YYYY atau YYYY-MM-DD) | `2023-08-20` |
| `tanggal_kedaluwarsa` | `string (date)` | Tidak | - | - |
| `status_sertifikasi` | `string` | Tidak | - | - |
| `url_sertifikasi` | `string` | Tidak | - | `https://drive.google.com/file/d/1C-vDl0JDYJRJXnlhP4-onXRwUTBf6h1c/view?usp=sharing` |

##### Contoh Payload Request:
```json
{
  "id_dosen": 1,
  "id_tendik": 1,
  "jenis_sertifikasi": "string",
  "bidang_studi": "string",
  "nomor_registrasi_pendidik": "string",
  "nomor_sk": "string",
  "nomor_sertifikat": "string",
  "lembaga_penerbit": "string",
  "tahun_sertifikasi": "2023-08-20",
  "tanggal_kedaluwarsa": "string",
  "status_sertifikasi": "string",
  "url_sertifikasi": "https://drive.google.com/file/d/1C-vDl0JDYJRJXnlhP4-onXRwUTBf6h1c/view?usp=sharing"
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Data sertifikasi berhasil diperbarui. |
| `422` | Validasi gagal. |

---

### `DELETE` /api/sertifikasi/{id}
**Ringkasan:** Hapus Data Sertifikasi
**Deskripsi:** Menghapus data sertifikasi dan otomatis menyinkronkan profil Dosen/Tendik. Ditolak jika sertifikasi masih terikat pada dokumen evidence.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | ID sertifikasi |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Data sertifikasi berhasil dihapus. |
| `422` | Luaran Masih Dipakai: Sertifikasi tidak dapat dihapus karena masih terkait dengan dokumen evidence. |

---

### `POST` /api/sertifikasi/sync-profil
**Ringkasan:** Sinkronisasi Massal Sertifikasi ke Profil Dosen & Tendik
**Deskripsi:** Memicu sinkronisasi menyeluruh daftar sertifikasi ke kolom `sertifikasi` pada profil master Dosen dan Tendik di database.

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Sinkronisasi sertifikasi ke profil Dosen & Tendik berhasil. |

---

## Auth
> Modul: **Auth** | Jumlah: 3 endpoint

### `POST` /api/auth/login
**Ringkasan:** Login SSO Terpusat (http://akademik.fayra.my.id/api/auth/login)
**Deskripsi:** Login akun terpusat via API SSO Kelompok 1 (http://akademik.fayra.my.id/api/auth/login).

Endpoint ini mengeksekusi request langsung ke server SSO Akademik K1 untuk memvalidasi kredensial dan menerbitkan access_token JWT.

Salin token dari `data.authorization.access_token` hasil respons, lalu klik tombol **Authorize 🔓** di pojok kanan atas Swagger UI untuk mulai menguji endpoint lainnya.

#### Request Body (`application/json`)
| Field | Tipe Data | Wajib | Keterangan | Contoh Nilai |
| :--- | :--- | :---: | :--- | :--- |
| `email` | `string` | **Ya** | Email terdaftar pada server akademik (K1) | `administrator@polines.ac.id` |
| `password` | `string` | **Ya** | Kata sandi akun SSO K1 | `password` |

##### Contoh Payload Request:
```json
{
  "email": "administrator@polines.ac.id",
  "password": "password"
}
```

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Login berhasil, token JWT SSO berhasil diperoleh. |
| `401` | Email atau password salah. |

---

### `GET` /api/me
**Ringkasan:** Introspeksi Profil & Hak Akses Pengguna Aktif
**Deskripsi:** Mengekstrak profil pengguna, peran (ADMINISTRATOR, KAPRODI, DOSEN, ASESOR), dan hak akses (permissions) dari Bearer Token JWT SSO K1.

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Profil dan hak akses berhasil diambil. |
| `401` | Unauthenticated / Token Bearer tidak disertakan atau kedaluwarsa. |

---

### `POST` /api/logout
**Ringkasan:** Logout Sesi Pengguna
**Deskripsi:** Menghapus sesi token JWT aktif di sisi klien dan mengembalikan tautan portal SSO.

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Logout berhasil diproses. |

---

## Assessment & Gap Analysis
> Modul: **Assessment & Gap Analysis** | Jumlah: 2 endpoint

### `POST` /api/assessment/run
**Ringkasan:** Jalankan Engine Assessment SDM & Gap Analysis K3
**Deskripsi:** Melakukan kalkulasi komputasi gap analysis per kriteria LAM INFOKOM K2 berdasarkan data riil vs target K3 dan menghasilkan rekomendasi taktis.

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Assessment dan kalkulasi gap analysis berhasil dieksekusi. |

---

### `GET` /api/assessment/hasil
**Ringkasan:** Daftar Riwayat Hasil Assessment & Rekomendasi
**Deskripsi:** Mengambil riwayat hasil komputasi assessment SDM dan rekomendasi perbaikan indikator.

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Riwayat hasil assessment berhasil diambil. |

---

## Konfigurasi Metrik
> Modul: **Konfigurasi Metrik** | Jumlah: 3 endpoint

### `GET` /api/konfigurasi-metrik/indikator-k3
**Ringkasan:** Sinkronisasi Indikator Standar LAM INFOKOM dari K3
**Deskripsi:** Mengambil daftar indikator dan kriteria akreditasi standar dari modul K3.

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Daftar indikator K3 berhasil diambil. |

---

### `GET` /api/konfigurasi-metrik
**Ringkasan:** Daftar Konfigurasi Metrik Akreditasi
**Deskripsi:** Mengambil seluruh konfigurasi metrik, bobot, dan ambang batas indikator akreditasi.

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Daftar konfigurasi metrik berhasil diambil. |

---

### `POST` /api/konfigurasi-metrik
**Ringkasan:** Tambah Konfigurasi Metrik
**Deskripsi:** Menyimpan konfigurasi indikator baru.

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Konfigurasi metrik berhasil disimpan. |

---

## Notifikasi & Audit Log
> Modul: **Notifikasi & Audit Log** | Jumlah: 6 endpoint

### `GET` /api/notifikasi
**Ringkasan:** Daftar Notifikasi In-App Pengguna
**Deskripsi:** Mengambil daftar notifikasi pengguna dengan filter unread_only.

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `unread_only` | `query` | `boolean` | Tidak | Filter hanya notifikasi yang belum dibaca |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Daftar notifikasi berhasil diambil. |

---

### `POST` /api/notifikasi
**Ringkasan:** Kirim Notifikasi In-App Baru
**Deskripsi:** Mengirim notifikasi ke user atau role tertentu.

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `201` | Notifikasi berhasil dikirim. |

---

### `POST` /api/notifikasi/{id}/baca
**Ringkasan:** Tandai Notifikasi Telah Dibaca

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | - |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Notifikasi ditandai telah dibaca. |

---

### `POST` /api/notifikasi/baca-semua
**Ringkasan:** Tandai Seluruh Notifikasi Telah Dibaca

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Seluruh notifikasi ditandai telah dibaca. |

---

### `GET` /api/audit-logs
**Ringkasan:** Riwayat Audit Trail Log
**Deskripsi:** Mengambil catatan audit log forensik aktivitas mutasi data.

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Daftar audit log berhasil diambil. |

---

### `GET` /api/audit-logs/{id}
**Ringkasan:** Detail Forensik Audit Log

#### Parameter URL / Query
| Nama | Lokasi | Tipe | Wajib | Keterangan |
| :--- | :---: | :---: | :---: | :--- |
| `id` | `path` | `integer` | **Ya** | - |

#### Status Respon HTTP
| Status Code | Keterangan |
| :---: | :--- |
| `200` | Detail audit log berhasil diambil. |

---
