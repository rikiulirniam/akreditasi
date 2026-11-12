# Breakdown Pekerjaan Antar-Branch (Selain Branch `main`)

Dokumen ini menyajikan rincian lengkap mengenai kontribusi, cakupan pekerjaan, perubahan skema database, logika bisnis, serta commit yang dilakukan pada masing-masing branch kerja di luar branch `main` pada repositori **API Akreditasi & SPMI (Laravel 13 / PHP 8.4)**.

---

## 1. Ringkasan Eksekutif & Matriks Kontribusi

| Nama Branch | Author / Kontributor | Fokus Utama / Domain Pekerjaan | Status Merge ke `main` |
| :--- | :--- | :--- | :--- |
| **`riki`** | Riki Ulir Niam | Arsitektur Inti, Autentikasi JWT & RBAC, Hierarki Drilldown Instrumen, Self Assessment Otomatis, Seeder LAM-INFOKOM 2.1 Sarjana Terapan, Integrasi OpenAPI / Swagger & CI/CD | **Merged (PR #17, #20–#27, #30, #32)** |
| **`sean`** | Sean Irma | Master Data Controllers & Requests, Bridge Instrumen (UUID), Integrasi Kolom `bobot` ke `Indikator`, Pemisahan Sarpras/Sarana, Pembersihan Tabel Legacy | **Merged (PR #18, #19)** |
| **`faqih`** | Faqih Ramadhan | Modul Evidence SPMI (Migrasi alur dari Standar Mutu ke Project Akreditasi), 4 Pilar Bukti Mutu, Unit/Feature Tests Evidence SPMI | **Merged (PR #29)** |
| **`abi`** | Fabiano Christyan | Modul Plotting Tim / Mapping Tim Akreditasi (Dukungan role PJ & PIC, Batch & Single Assignment, Filter Fleksibel) | **Merged (PR #28)** |
| **`aini`** | Aini | Refaktorisasi & Penghapusan Entitas `StandarMutu` beserta kolom relasi `id_standar` pada SPMI Audit | **Merged (PR #31)** |
| **`master`** | Riki Ulir Niam (Initial) | Inisialisasi awal repositori Laravel (Scaffolding, konfigurasi awal, dependencies) | **Historical Base Commit** |

---

## 2. Rincian Detail Masing-Masing Branch

### A. Branch `riki` (Author: Riki Ulir Niam)
Branch `riki` berfungsi sebagai branch utama pengembangan fitur inti, integrasi arsitektur modul, keamanan sistem, dokumentasi API, serta sinkronisasi akhir sebelum rilis ke branch `main`.
- **Autentikasi Terpusat & RBAC:** Implementasi middleware JWT SSO (`jwt.auth`) dan pembatasan hak akses berbasis peran (`role:administrator,reviewer,kaprodi,dosen`).
- **Hierarki Drilldown Master Instrumen:** Menghubungkan hierarki `Instrumen` ➔ `Kriteria` ➔ `Subkriteria` ➔ `Indikator` ➔ `Rubrik` dengan agregasi otomatis jumlah anak (*child count*).
- **Direct Alias Endpoints:** Menyediakan rute langsung tanpa prefix `/master/` untuk kemudahan konsumsi frontend (contoh: `/api/v1/instrumen`, `/api/v1/kriteria`).
- **Self Assessment Reviewer:** Perhitungan otomatis skor terbobot (`skor * bobot`) saat reviewer melakukan penilaian.
- **Seeder Komprehensif LAM-INFOKOM 2.1 Sarjana Terapan:** Penyusunan seeder akurat spesifik vokasi (OBE, PBL, magang industri 1-2 semester, dosen praktisi, workstation Core i9/server AI, sertifikasi internasional/BNSP, keuangan 3 tahun).
- **Dokumentasi & Swagger:** Pembuatan seluruh anotasi Swagger OpenApi (`app/Docs/*`), sinkronisasi `openapi.json`, serta pengamanan prefill auth.
- **CI/CD Pipeline:** Konfigurasi GitHub Actions (`.github/workflows/deploy.yml`) untuk pengujian dan deployment otomatis.

### B. Branch `sean` (Author: Sean Irma)
Branch `sean` berfokus pada refaktorisasi master data, pembersihan entitas database yang usang (*legacy cleanup*), perbaikan ERD, serta pembagian entitas sarana dan prasarana.
- **Pembangunan Master Controllers & FormRequests:** Mengimplementasikan CRUD lengkap untuk `JenisInstrumen`, `Jenjang`, `LembagaAkreditasi`, `Subkriteria`, dan `VersiInstrumen`.
- **Entitas Bridge `Instrumen` (UUID):** Mengubah relasi instrumen menjadi tabel penghubung (*bridge*) antara versi instrumen, jenjang, dan jenis instrumen dengan primary key UUID.
- **Integrasi Kolom `bobot` ke `Indikator`:** Menghapus tabel dan model `Bobot` terpisah, lalu memindahkan nilai bobot langsung sebagai kolom `decimal(8,2)` pada tabel `indikator`.
- **Pemisahan Sarana dan Prasarana:** Memisahkan data prasarana ruangan ke dalam `data_sarpras_prodi` dan unit inventaris ke `data_sarana_prodi`.
- **Eliminasi Tabel Usang (*Cleanup*):** Menghapus tabel `prodi` lokal, `lembar_prodi`, `bukti`, dan `jenis_bukti`.

### C. Branch `faqih` (Author: Faqih Ramadhan)
Branch `faqih` bertanggung jawab atas perancangan ulang modul pembuktian mutu SPMI (*Evidence SPMI*).
- **Penyederhanaan Alur Bukti SPMI:** Mengubah relasi dokumen bukti mutu yang sebelumnya terfragmentasi di standar mutu menjadi terpusat pada satu project akreditasi (*One-to-One*).
- **4 Pilar Dokumen Mutu Pendidikan Tinggi:** Menyediakan penyimpanan terstruktur untuk tautan (link cloud/Drive) dan deskripsi dokumen: Evaluasi Mutu (AMI), Pengendalian Mutu (RTM), Dampak Mutu (IKU/Kepuasan), dan Dokumen Implementasi (SOP/PPEPP).
- **Automated Testing Menyeluruh:** Menyediakan 13 pengujian fitur (*feature tests*) yang menguji validasi, otorisasi role, operasi Create/Update (*upsert*), serta format output JSON (`tests/Feature/EvidenceSpmiTest.php`).

### D. Branch `abi` (Author: Fabiano Christyan / Abi)
Branch `abi` berfokus pada penyempurnaan fitur pembagian tugas dan penugasan dosen penyusun instrumen (*Plotting Tim Akreditasi*).
- **Peran Penugasan Fleksibel (PJ & PIC):** Memperbarui tabel `mapping_tim_akreditasi` agar mendukung penetapan peran anggota tim sebagai **`PJ`** (*Penanggung Jawab*) atau **`PIC`** (*Pelaksana Teknis*) per butir/indikator.
- **Dukungan Penugasan Batch (*Batch Assignment*):** Mengizinkan pengiriman array penugasan (`assignments: [{ id_user, id_indikator, role }]`) dalam satu request `POST`.
- **Operasi Aman Menggunakan `updateOrCreate`:** Mencegah duplikasi data penugasan saat dosen yang sama ditugaskan ulang pada butir yang sama.
- **Filter Dinamis pada List Penugasan:** Menambahkan kemampuan filtering `GET /mapping-tim` berdasarkan `id_project` (atau `project_id`) serta berdasarkan `role`.

### E. Branch `aini` (Author: Aini)
Branch `aini` berfokus pada penyederhanaan skema penjaminan mutu melalui penghapusan modul *Standar Mutu* yang redundan terhadap instrumen akreditasi.
- **Eliminasi Standar Mutu:** Menghapus tabel `standar_mutu` dari database dan mencabut ketergantungan model `StandarMutu`.
- **Refaktorisasi Audit Mutu SPMI:** Menghapus kolom foreign key `id_standar` dari tabel `data_spmi_audit`, sehingga kegiatan audit mutu internal langsung terhubung ke `id_project` dan `id_indikator`.
- **Pembersihan Kontroller, FormRequest, dan Seeder:** Menghapus endpoint CRUD `StandarMutuController`, membersihkan request dan seeder.

### F. Branch `master` (Local Historical Branch)
Branch `master` merupakan cabang awal sebelum repositori distandarkan menggunakan branch `main` sebagai default branch GitHub (berisi commit inisialisasi awal proyek).

