# PEMBAGIAN TUGAS PENGEMBANGAN REST API
## Proyek PBL: Sistem Penjaminan Mutu & Akreditasi Program Studi (Kelompok 3)

Dokumen ini disusun khusus sebagai **panduan teknis pengerjaan backend REST API** (repositori ini) berdasarkan seluruh catatan evaluasi dosen pembimbing (**Pak Kuwat** & **Bu Wikta**) dari pertemuan tanggal 13 Oktober 2026 hingga 09 November 2026, guna mencapai target rilis penuh pada **UAS 14 Desember 2026**.

**Ruang Lingkup:** 100% Backend REST API (Laravel 13, PHP 8.4, MySQL, Swagger, Postman).  
**Koordinator Arsitektur & Integrasi Teknis:** Riki Ulir Niam  
**Tim Pengembang API (6 Orang):** Sean, Abi, Faqih, Kavin, Aini, Rafael.

---

## I. ANALISIS KEBUTUHAN & DAFTAR HAL YANG HARUS DIBENAHI PADA API

Berdasarkan hasil rekap catatan dosen dan audit langsung pada codebase backend, berikut adalah poin-poin krusial yang wajib diperbaiki dan ditambahkan:

### 1. Masalah Lifecycle Status & Verifikasi Project (Catatan Pak Kuwat 13/10)
* **Kondisi Saat Ini:** Kolom `status_project` pada tabel `project_akreditasi` masih bertipe string bebas tanpa validasi enum ketat.
* **Masalah:** Pak Kuwat menegaskan bahwa status project harus mencakup: `Draft`, `On Progress`, `Pending`, `Cancel`, dan `Selesai`. Project tidak boleh otomatis berubah `Selesai` hanya karena form terisi, melainkan harus menunggu verifikasi SK terakreditasi resmi.
* **Solusi API:**
  - Tambahkan kolom `tanggal_verifikasi_akreditasi` (date, nullable) dan `nomor_sk_akreditasi` (string, nullable) pada tabel `project_akreditasi`.
  - Pasang validasi enum eksplisit: `'in:Draft,On Progress,Pending,Cancel,Selesai'`.
  - Buat aturan bisnis (*business rule*): perubahan status ke `Selesai` mewajibkan adanya nomor SK atau verifikasi kelulusan akreditasi.

### 2. Ketiadaan Endpoint Metrik Dashboard Progress (Catatan Pak Kuwat 13/10)
* **Kondisi Saat Ini:** Belum ada endpoint khusus untuk dashboard.
* **Masalah:** Dosen meminta di dashboard tampil persentase pengisian 9 kriteria instrumen akreditasi.
* **Solusi API:**
  - Buat endpoint `GET /api/v1/projects/{id}/dashboard-progress` yang mengembalikan persentase kelengkapan pengisian per kriteria (Kriteria A, B, C.1–C.6, D) dan total progress project.

### 3. Ketergantungan Data Eksternal Kelompok 1 & 2 (Catatan Bu Wikta 19/10 & 09/11)
* **Kondisi Saat Ini:** Backend masih menggunakan foreign key internal atau mock manual yang belum terhubung ke service API Kelompok 1 (Prodi) dan Kelompok 2 (Dosen/User).
* **Masalah:** Saat plotting tim, data dosen belum ada. Saat pembuatan project, prodi belum terintegrasi otomatis ke TRK (Teknologi Rekayasa Komputer).
* **Solusi API:**
  - Buat HTTP Service Adapter untuk mengonsumsi API Kelompok 1 (Daftar Prodi, default ke TRK) dan API Kelompok 2 (Daftar Dosen dengan NIDN/NIP).
  - Sediakan mekanisme *fallback* lokal/seeder otomatis jika server kelompok lain sedang offline.

### 4. Pembatasan Hak Akses Butir bagi Dosen PIC/PJ (Catatan Bu Wikta 19/10 & UTS 26/10)
* **Kondisi Saat Ini:** Dosen yang login dengan role `DOSEN` dapat memanggil endpoint modifikasi tanpa diperiksa apakah dosen tersebut adalah PIC butir terkait.
* **Masalah:** Bu Wikta menegaskan bahwa dosen hanya memiliki privilege untuk mengunggah bukti dan melengkapi data pada butir yang ditugaskan kepadanya sebagai PIC/PJ.
* **Solusi API:**
  - Buat Laravel Authorization Policy (`IndikatorAssignmentPolicy`) yang memeriksa tabel `mapping_tim_akreditasi`.
  - Sediakan endpoint khusus dosen: `GET /api/v1/dosen/my-assignments` agar dosen langsung mendapatkan daftar butir tugasnya.

### 5. Pemisahan Halaman "Read Data" Evidence SPMI & Hasil Review (Catatan Bu Wikta 09/11)
* **Kondisi Saat Ini:** Pengambilan data evidence dan self assessment masih terpencar per baris ID, belum ada format rekapitulasi ringkas (*read-only overview*).
* **Masalah:** Dosen pembimbing mencatat: *"Yang belum: daftar dokumen Evidence dari SPMI dan Hasil Review dari reviewer (halaman read data). Alur: Project > Evidence > PIC > Read data."*
* **Solusi API:**
  - Buat endpoint `GET /api/v1/projects/{id}/evidence-overview` untuk menyajikan rekapitulasi 4 pilar dokumen evidence mutu secara terstruktur.
  - Buat endpoint `GET /api/v1/projects/{id}/review-summary` untuk menyajikan rekapitulasi hasil penilaian reviewer internal.

### 6. Rumus Simulasi Skor Sesuai Buku Panduan & Ketiadaan Penjelasan Prodi (Catatan Bu Wikta 19/10, 02/11, 09/11)
* **Kondisi Saat Ini:** `SelfAssessmentController` sebelumnya memanggil model usang `Bobot` yang telah dihapus, dan belum ada formula predikat kelulusan (Unggul/Baik Sekali/Baik). Selain itu, belum ada wadah bagi Kaprodi untuk memberi penjelasan.
* **Masalah:** Bu Wikta meminta nilai simulasi sesuai rumus buku panduan/spreadsheet LAM-INFOKOM, serta adanya "Penjelasan Prodi" yang diisi sendiri oleh Kaprodi pada penilaian.
* **Solusi API:**
  - Tambahkan kolom `penjelasan_prodi` (text, nullable) pada tabel `self_assessment`.
  - Sediakan endpoint `PUT /api/v1/self-assessment/{id}/penjelasan-prodi` (khusus role `KAPRODI`).
  - Bangun `ScoringCalculationService` untuk menghitung skor terbobot $\text{Skor} \times \text{Bobot}$, akumulasi nilai akhir ($0 - 400$), serta konversi ke predikat Unggul / Baik Sekali / Baik.

### 7. Proteksi Hapus Data Penting / Soft Delete (Catatan Bu Wikta 19/10 & UTS 26/10)
* **Kondisi Saat Ini:** Endpoint `DELETE` pada Rubrik dan Indikator dapat langsung menghapus baris tanpa memeriksa apakah data tersebut sudah digunakan pada tabel transaksi.
* **Masalah:** Jika Rubrik atau Indikator yang sudah memiliki data penilaian/mapping tim terhapus, terjadi integritas data rusak atau error SQL foreign key constraint.
* **Solusi API:**
  - Tambahkan guard di `RubrikController::destroy` dan `IndikatorController::destroy`: jika ID terpakai di `self_assessment` atau `mapping_tim_akreditasi`, tolak dengan response HTTP 422: *"Data tidak dapat dihapus karena telah digunakan pada instrumen/penilaian aktif."*

---

## II. MATRIKS PEMBAGIAN TUGAS API (6 ANGGOTA TIM)

| No | Nama | Peran API | Fitur & Modul API yang Dimiliki | Endpoint & Deliverables Utama |
|:--:|:---|:---|:---|:---|
| 1 | **Sean** | Core Integration & Lifecycle Engineer | Integrasi API Kelompok 1 & 2, Lifecycle Status Project, Kolom Verifikasi SK | `GET /api/v1/external/prodi`<br>`GET /api/v1/external/dosen`<br>`PUT /api/v1/projects/{id}/status` |
| 2 | **Abi** | Team Plotting & Authorization Engineer | Plotting Tim (PJ & PIC), Batch Assignment, Gate Hak Akses Dosen per Butir | `GET /api/v1/dosen/my-assignments`<br>`POST /api/v1/projects/{id}/mapping-tim`<br>`IndikatorAssignmentPolicy` |
| 3 | **Faqih** | SPMI & Evidence Pipeline Engineer | Evidence SPMI (4 Pilar Mutu), Shared Read Access, Overview Evidence Mutu | `GET /api/v1/projects/{id}/evidence-overview`<br>`POST /api/v1/evidence-spmi`<br>`EvidenceOverviewResource` |
| 4 | **Kavin** | Metrics, Dashboard & Readiness Engineer | Dashboard Progress API 9 Kriteria, Quick Create Project TRK, Audit Readiness Check | `GET /api/v1/projects/{id}/dashboard-progress`<br>`POST /api/v1/projects/quick-create`<br>`GET /api/v1/projects/{id}/readiness` |
| 5 | **Aini** | Master Data, Versioning & Protection Engineer | Penguncian Versi Aktif, Proteksi Hapus Rubrik/Indikator Terpakai, Hierarchy Context | `DELETE /api/v1/master/rubrik/{id}` (Protected)<br>`DELETE /api/v1/master/indikator/{id}` (Protected)<br>`GET /api/v1/master/instrumen/{id}/hierarchy` |
| 6 | **Rafael** | Scoring Engine & Assessment Engineer | Scoring Engine Simulasi LAM-INFOKOM, Endpoint Penjelasan Prodi Kaprodi, Review Summary | `PUT /api/v1/self-assessment/{id}/penjelasan-prodi`<br>`GET /api/v1/projects/{id}/review-summary`<br>`ScoringCalculationService` |

---

## III. RINCIAN TUGAS SPESIFIK & ACTION PLAN PER ANGGOTA

### 1. Sean — Core Integration & Lifecycle Engineer
* **Tanggung Jawab Utama:** Menjembatani sistem dengan Kelompok 1 (Prodi) dan Kelompok 2 (Dosen), serta mengelola siklus hidup status project akreditasi.
* **Rincian Tugas Teknis:**
  1. **Service Adapter Kelompok 1 (Prodi):**
     - Buat class `App\Services\External\ProdiApiService` menggunakan `Illuminate\Support\Facades\Http`.
     - Ambil daftar program studi resmi. Buat helper agar saat instansiasi default selalu mengembalikan Program Studi **TRK (Teknologi Rekayasa Komputer)**.
  2. **Service Adapter Kelompok 2 (Dosen & Pengguna):**
     - Buat class `App\Services\External\DosenApiService`.
     - Ambil daftar dosen (NIDN, Nama, Email, Bidang Minat) dari Kelompok 2.
     - Sediakan rute internal `GET /api/v1/external/dosen` dengan fallback data dummy/seeder jika server Kelompok 2 *unreachable*.
  3. **Pembaruan Lifecycle Status Project Akreditasi:**
     - Buat migrasi penambahan kolom: `tanggal_verifikasi_akreditasi` (date, nullable) dan `nomor_sk_akreditasi` (string, nullable) pada tabel `project_akreditasi`.
     - Update aturan validasi pada `StoreProjectAkreditasiRequest` dan `UpdateProjectAkreditasiRequest` dengan aturan status: `Draft`, `On Progress`, `Pending`, `Cancel`, `Selesai`.
     - Tambahkan method controller `updateStatus(Request $request, $id)`: tolak status `Selesai` jika tanggal verifikasi atau nomor SK belum terisi.
* **Target File & Deliverables:**
  - `app/Services/External/ProdiApiService.php`
  - `app/Services/External/DosenApiService.php`
  - `database/migrations/xxxx_xx_xx_update_project_akreditasi_status_and_sk.php`
  - Unit & Feature Test: `tests/Feature/ProjectLifecycleTest.php`

---

### 2. Abi — Team Plotting & Authorization Engineer
* **Tanggung Jawab Utama:** Memastikan pembagian tugas dosen (PJ & PIC) berjalan tanpa redudansi dan menerapkan pembatasan hak akses berbasis penugasan.
* **Rincian Tugas Teknis:**
  1. **Penyempurnaan Skema Penugasan PJ & PIC:**
     - Pastikan tabel `mapping_tim_akreditasi` membedakan dua peran penugasan utama:
       - **PJ (Penanggung Jawab):** Bertanggung jawab atas substansi kriteria/indikator.
       - **PIC (Pelaksana Teknis):** Bertanggung jawab atas pengunggahan berkas bukti dukung.
     - Dukung input batch: `assignments: [ { id_user, id_indikator, role: "PJ" }, { id_user, id_indikator, role: "PIC" } ]`.
  2. **Implementasi Authorization Policy Butir Indikator:**
     - Buat class `App\Policies\IndikatorAssignmentPolicy`.
     - Logika izin `upload-evidence` dan `edit-data`:
       - `ADMINISTRATOR` dan `KAPRODI`: Diizinkan untuk seluruh butir.
       - `DOSEN`: Hanya diizinkan jika terdaftar sebagai PIC atau PJ pada tabel `mapping_tim_akreditasi` untuk `id_indikator` bersangkutan.
  3. **Endpoint Khusus Dosen PIC (`my-assignments`):**
     - Buat method `getMyAssignments(Request $request)` pada `MappingTimAkreditasiController`.
     - Rute: `GET /api/v1/dosen/my-assignments`.
     - Mengembalikan daftar indikator yang ditugaskan kepada user yang sedang login beserta status kelengkapan buktinya.
* **Target File & Deliverables:**
  - `app/Policies/IndikatorAssignmentPolicy.php`
  - Modifikasi `app/Http/Controllers/Api/Akreditasi/MappingTimAkreditasiController.php`
  - Feature Test: `tests/Feature/PlottingTimAuthorizationTest.php`

---

### 3. Faqih — SPMI & Evidence Pipeline Engineer
* **Tanggung Jawab Utama:** Membangun saluran pengumpulan bukti dokumen mutu 4 pilar, akses publik read-only, dan endpoint rekapitulasi data (*Read Data*).
* **Rincian Tugas Teknis:**
  1. **Standardisasi 4 Pilar Dokumen Evidence SPMI:**
     - Pastikan model `EvidenceSpmi` menyimpan 4 pilar dokumen mutu secara terstruktur:
       - Pilar 1: Bukti Evaluasi Mutu (AMI & Monev Berkala).
       - Pilar 2: Bukti Pengendalian Mutu (RTM & Notula Rapat Tindak Lanjut).
       - Pilar 3: Bukti Dampak Mutu (Capaian IKU & Kepuasan Stakeholder).
       - Pilar 4: Dokumen Implementasi (Kebijakan SPMI, Manual Mutu, Standar Mutu, SOP PPEPP).
  2. **Mekanisme Shared Access Read-Only Token:**
     - Tambahkan field `access_token` (string 64 char, unique) pada tabel `evidence_spmi`.
     - Sediakan rute publik `GET /api/v1/public/evidence/{accessToken}` agar asesor eksternal dapat memeriksa bukti tanpa memerlukan akun SSO lokal.
  3. **Endpoint Halaman "Read Data Dokumen Evidence":**
     - Sediakan endpoint `GET /api/v1/projects/{id}/evidence-overview` (sesuai arahan Bu Wikta: `Project > Evidence > PIC > Read data`).
     - Mengembalikan rekapitulasi: link bukti 4 pilar, daftar indikator yang telah terisi bukti, riwayat temuan audit SPMI yang Open/Closed.
* **Target File & Deliverables:**
  - `app/Http/Controllers/Api/Spmi/EvidenceSpmiController.php` (method `overview`, `publicView`)
  - `app/Http/Resources/EvidenceOverviewResource.php`
  - Feature Test: `tests/Feature/EvidenceOverviewTest.php`

---

### 4. Kavin — Metrics, Dashboard & Readiness Engineer
* **Tanggung Jawab Utama:** Mengolah metrik performa pengisian 9 instrumen untuk dasbor, menyediakan pembuatan project ringkas, dan pengecekan kesiapan submit akreditasi.
* **Rincian Tugas Teknis:**
  1. **Endpoint Metrik Dashboard Progres 9 Kriteria:**
     - Buat controller `App\Http\Controllers\Api\Dashboard\DashboardProgressController`.
     - Endpoint: `GET /api/v1/projects/{id}/dashboard-progress`.
     - Menghitung persentase progres per kriteria (Kriteria 1 s.d. 9):
       $$\text{Progres Kriteria } (\%) = \left(\frac{\text{Jumlah Indikator Terisi Bukti}}{\text{Total Indikator pada Kriteria}}\right) \times 100\%$$
     - Menghitung total persentase pengisian keseluruhan instrumen (skala 0–100%).
  2. **Endpoint Pembuatan Project Cepat (Mode Ringkas TRK):**
     - Sediakan endpoint `POST /api/v1/projects/quick-create`:
       - Otomatis mengikat ke Versi Instrumen aktif (2.1), Jenjang Sarjana Terapan, Jenis Akreditasi Unggul, dan nama default *"Akreditasi Program Studi TRK {Tahun}"*.
       - Mengurangi friksi input form bagi Kaprodi (sesuai arahan Pak Kuwat & Kavindra 13/10).
  3. **Endpoint Pengecekan Kesiapan Submit (*Readiness Check*):**
     - Endpoint `GET /api/v1/projects/{id}/readiness`.
     - Mengembalikan daftar butir indikator kritis yang belum memiliki PIC, belum memiliki link evidence, atau skor simulasi yang belum diinput oleh reviewer.
* **Target File & Deliverables:**
  - `app/Http/Controllers/Api/Dashboard/DashboardProgressController.php`
  - Penambahan route pada `routes/api.php`
  - Feature Test: `tests/Feature/DashboardMetricsTest.php`

---

### 5. Aini — Master Data, Versioning & Protection Engineer
* **Tanggung Jawab Utama:** Menjaga integritas master data instrumen akreditasi LAM-INFOKOM 2.1, hierarki versi, dan pengamanan penghapusan data krusial.
* **Rincian Tugas Teknis:**
  1. **Proteksi Penghapusan Data Penting (Dependency Guard):**
     - Pada `RubrikController::destroy` dan `IndikatorController::destroy`:
       - Tambahkan pengecekan integritas sebelum eksekusi delete:
         Jika ID indikator/rubrik sudah tercatat pada tabel `self_assessment` atau `mapping_tim_akreditasi`, batalkan penghapusan dan kembalikan response HTTP 422:
         ```json
         {
           "success": false,
           "message": "Data tidak dapat dihapus karena telah digunakan dalam penilaian atau penugasan aktif.",
           "data": null,
           "errors": { "id": ["Data sedang aktif digunakan pada transaksi penilaian/penugasan."] }
         }
         ```
  2. **Penguncian Versi Instrumen Aktif:**
     - Saat membuat/memperbarui versi instrumen dengan `status_aktif = true`, buat mekanisme otomatis untuk menonaktifkan versi instrumen lain pada jenjang yang sama.
  3. **Optimalisasi Hierarki Konteks Dropdown:**
     - Endpoint: `GET /api/v1/master/instrumen/{id}/hierarchy`.
     - Mengembalikan data hierarki lengkap: Lembaga ➔ Versi Instrumen ➔ Jenjang ➔ Jenis Instrumen ➔ Kriteria ➔ Subkriteria dalam satu respons terpadu, agar frontend tidak kehilangan konteks pilihan atas saat dropdown berubah.
* **Target File & Deliverables:**
  - Guard logic pada `app/Http/Controllers/Api/Master/RubrikController.php` dan `IndikatorController.php`
  - `app/Http/Controllers/Api/Master/InstrumenController.php` (method `getHierarchy`)
  - Feature Test: `tests/Feature/MasterDataProtectionTest.php`

---

### 6. Rafael — Scoring Engine & Assessment Engineer
* **Tanggung Jawab Utama:** Mengembangkan mesin kalkulasi skor terbobot akreditasi sesuai standar LAM-INFOKOM 2.1, penanganan catatan penjelasan prodi, dan rekapitulasi hasil review.
* **Rincian Tugas Teknis:**
  1. **Pengembangan Mesin Skor (*Scoring Calculation Service*):**
     - Buat class `App\Services\Akreditasi\ScoringCalculationService`.
     - Formula Skor Terbobot per butir:
       $$\text{Skor Terbobot} = \text{Skor Rubrik (1, 2, 3, atau 4)} \times \text{Bobot Indikator}$$
     - Formula Skor Total Akreditasi (Skala 0 – 400):
       $$\text{Total Skor} = \sum_{i=1}^{53} \text{Skor Terbobot}_i$$
     - Penentuan Predikat Akreditasi Simulasi:
       - Total Skor $\ge 361$ dan memenuhi Threshold Kriteria D $\rightarrow$ **Terakreditasi Unggul**
       - Total Skor $301 - 360$ $\rightarrow$ **Terakreditasi Baik Sekali**
       - Total Skor $200 - 300$ $\rightarrow$ **Terakreditasi Baik**
       - Total Skor $< 200$ $\rightarrow$ **Tidak Terakreditasi**
  2. **Implementasi Fitur "Penjelasan Prodi" oleh Kaprodi:**
     - Buat migrasi: menambahkan kolom `penjelasan_prodi` (text, nullable) pada tabel `self_assessment`.
     - Endpoint: `PUT /api/v1/self-assessment/{id}/penjelasan-prodi`.
     - Middleware: Khusus role `kaprodi` (dan `administrator`), digunakan untuk memberikan klarifikasi atau penjelasan sanggahan atas catatan perbaikan dari reviewer.
  3. **Endpoint Ringkasan Hasil Reviewer (Halaman Read Data Review):**
     - Endpoint: `GET /api/v1/projects/{id}/review-summary`.
     - Mengembalikan rekapitulasi lengkap: total skor, predikat capaian, rincian skor per kriteria, daftar butir di bawah target ($\text{skor} \le 2$), catatan reviewer, dan tanggapan penjelasan prodi.
* **Target File & Deliverables:**
  - `database/migrations/xxxx_xx_xx_add_penjelasan_prodi_to_self_assessment.php`
  - `app/Services/Akreditasi/ScoringCalculationService.php`
  - Penambahan method pada `app/Http/Controllers/Api/Akreditasi/SelfAssessmentController.php`
  - Feature Test: `tests/Feature/ScoringFormulaLAMTest.php`

---

## IV. RENCANA TIMELINE & ROADMAP SPRINT (UAS 14 DESEMBER 2026)

```text
+-----------------------------------------------------------------------------------+
| SPRINT 1 (11 Nov - 17 Nov 2026) : Integrasi Eksternal & Proteksi Fondasi Database|
| - Sean : Service Kelompok 1 & 2, Lifecycle Status Project, Kolom SK Verifikasi    |
| - Abi  : Batch Plotting Tim PJ & PIC, Kebijakan Akses Dosen per Butir            |
| - Aini : Proteksi Hapus Rubrik/Indikator Terpakai, Hierarchy API Dropdown         |
+-----------------------------------------------------------------------------------+
                                         |
                                         v
+-----------------------------------------------------------------------------------+
| SPRINT 2 (18 Nov - 24 Nov 2026) : Pipeline Evidence & Scoring Calculation Engine  |
| - Faqih  : Overview Evidence SPMI 4 Pilar, Public Access Link                     |
| - Rafael : Mesin Hitung Skor LAM-INFOKOM, Predikat Unggul, Penjelasan Kaprodi     |
| - Kavin  : Dashboard Progress API 9 Kriteria, Quick Create Project TRK           |
+-----------------------------------------------------------------------------------+
                                         |
                                         v
+-----------------------------------------------------------------------------------+
| SPRINT 3 (25 Nov - 02 Des 2026) : Read Data Endpoints, Readiness & Postman Sync   |
| - Faqih & Rafael : Sinkronisasi Endpoint Read Data (Project > Evidence > Review)  |
| - Kavin          : Readiness Check API untuk Validasi Pra-Submit                  |
| - Riki           : Update Dokumentasi API_DOCUMENTATION.md, Swagger & Postman     |
+-----------------------------------------------------------------------------------+
                                         |
                                         v
+-----------------------------------------------------------------------------------+
| SPRINT 4 (03 Des - 10 Des 2026) : End-to-End Testing & Transaction Simulation    |
| - Seluruh Anggota : Uji coba simulasi siklus akreditasi lengkap tanpa error       |
| - Riki            : Code Freeze, Pint Formatting, Merge ke Branch Main            |
+-----------------------------------------------------------------------------------+
                                         |
                                         v
+-----------------------------------------------------------------------------------+
| FINALISASI & UAS (11 Des - 14 Des 2026) : Presentasi & Uji Live API               |
+-----------------------------------------------------------------------------------+
```

---

## V. ATURAN PENGEMBANGAN GIT & STANDAR KUALITAS KODE

1. **Aturan Penamaan Branch:**
   Setiap anggota wajib membuat branch turunan dari branch `riki` dengan konvensi:
   - Sean: `feat/external-integration-lifecycle`
   - Abi: `feat/plotting-tim-policy`
   - Faqih: `feat/evidence-spmi-overview`
   - Kavin: `feat/dashboard-metrics-readiness`
   - Aini: `feat/master-protection-hierarchy`
   - Rafael: `feat/scoring-engine-penjelasan-prodi`
2. **Kriteria Pull Request Diterima (Definition of Done):**
   - Wajib membuat pengujian fitur otomatis pada folder `tests/Feature/`.
   - Seluruh pengujian wajib berstatus **Passed** (`php artisan test`).
   - Kode wajib diformat dengan Laravel Pint (`vendor/bin/pint --dirty --format agent`).
   - Dilarang keras melakukan push langsung ke branch `main`. Seluruh PR diarahkan ke branch `riki` untuk diverifikasi oleh Riki sebelum di-merge ke `main`.
3. **Dokumentasi Terpadu:**
   - Setiap kali membuat endpoint baru atau mengubah request parameter, PIC bersangkutan wajib mencatat contoh request/response JSON agar dapat langsung disinkronkan ke file `API_DOCUMENTATION.md` dan Postman Collection.
