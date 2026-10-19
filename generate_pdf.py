import os
from reportlab.lib.pagesizes import A4
from reportlab.lib import colors
from reportlab.platypus import (
    SimpleDocTemplate, Paragraph, Spacer, Table, TableStyle, PageBreak, KeepTogether, Preformatted
)
from reportlab.lib.styles import getSampleStyleSheet, ParagraphStyle
from reportlab.pdfgen import canvas

class NumberedCanvas(canvas.Canvas):
    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)
        self._saved_page_states = []

    def showPage(self):
        self._saved_page_states.append(dict(self.__dict__))
        self._startPage()

    def save(self):
        num_pages = len(self._saved_page_states)
        for state in self._saved_page_states:
            self.__dict__.update(state)
            self.draw_page_decorations(num_pages)
            super().showPage()
        super().save()

    def draw_page_decorations(self, page_count):
        self.saveState()
        self.setFont("Helvetica", 8)
        self.setFillColor(colors.HexColor("#64748b"))
        
        # Header (pages > 1)
        if self._pageNumber > 1:
            self.drawString(42, 810, "Spesifikasi Kebutuhan Data & Kontrak API (Kelompok 3 ke Kelompok 1 & 2)")
            self.setStrokeColor(colors.HexColor("#cbd5e1"))
            self.setLineWidth(0.5)
            self.line(42, 804, 553, 804)
        
        # Footer
        self.setStrokeColor(colors.HexColor("#cbd5e1"))
        self.setLineWidth(0.5)
        self.line(42, 40, 553, 40)
        
        footer_left = "PBL Sistem Akreditasi LAM INFOKOM 2.1 • Kelompok 3"
        footer_right = f"Halaman {self._pageNumber} dari {page_count}"
        self.drawString(42, 28, footer_left)
        self.drawRightString(553, 28, footer_right)
        self.restoreState()

def build_pdf(filename):
    doc = SimpleDocTemplate(
        filename,
        pagesize=A4,
        leftMargin=42,
        rightMargin=42,
        topMargin=48,
        bottomMargin=48
    )

    styles = getSampleStyleSheet()

    # Custom styles
    title_style = ParagraphStyle(
        'DocTitle',
        parent=styles['Normal'],
        fontName='Helvetica-Bold',
        fontSize=15,
        leading=19,
        textColor=colors.HexColor('#0f172a'),
        spaceAfter=4
    )

    badge_style = ParagraphStyle(
        'Badge',
        parent=styles['Normal'],
        fontName='Helvetica-Bold',
        fontSize=8,
        leading=10,
        textColor=colors.HexColor('#0369a1'),
        spaceAfter=6
    )

    subtitle_style = ParagraphStyle(
        'Subtitle',
        parent=styles['Normal'],
        fontName='Helvetica',
        fontSize=9.5,
        leading=13,
        textColor=colors.HexColor('#475569'),
        spaceAfter=12
    )

    h1_style = ParagraphStyle(
        'Heading1_Custom',
        parent=styles['Normal'],
        fontName='Helvetica-Bold',
        fontSize=12,
        leading=16,
        textColor=colors.HexColor('#0284c7'),
        spaceBefore=14,
        spaceAfter=8,
        keepWithNext=True
    )

    h2_style = ParagraphStyle(
        'Heading2_Custom',
        parent=styles['Normal'],
        fontName='Helvetica-Bold',
        fontSize=10,
        leading=13,
        textColor=colors.HexColor('#1e293b'),
        spaceBefore=10,
        spaceAfter=4,
        keepWithNext=True
    )

    body_style = ParagraphStyle(
        'Body_Custom',
        parent=styles['Normal'],
        fontName='Helvetica',
        fontSize=8.5,
        leading=12,
        textColor=colors.HexColor('#334155'),
        alignment=4,  # Justify
        spaceAfter=6
    )

    body_bold = ParagraphStyle(
        'Body_Bold',
        parent=body_style,
        fontName='Helvetica-Bold'
    )

    table_header = ParagraphStyle(
        'TableHeader',
        parent=styles['Normal'],
        fontName='Helvetica-Bold',
        fontSize=8,
        leading=10,
        textColor=colors.white
    )

    table_cell = ParagraphStyle(
        'TableCell',
        parent=styles['Normal'],
        fontName='Helvetica',
        fontSize=7.8,
        leading=10.5,
        textColor=colors.HexColor('#1e293b')
    )

    table_cell_bold = ParagraphStyle(
        'TableCellBold',
        parent=styles['Normal'],
        fontName='Helvetica-Bold',
        fontSize=7.8,
        leading=10.5,
        textColor=colors.HexColor('#0f172a')
    )

    code_style = ParagraphStyle(
        'CodeStyle',
        parent=styles['Normal'],
        fontName='Courier',
        fontSize=7.2,
        leading=9.2,
        textColor=colors.HexColor('#0f172a')
    )

    elements = []

    # Title & Header
    elements.append(Paragraph("DOKUMEN SPESIFIKASI INTEROPERABILITAS DATA & KONTRAK REST API", badge_style))
    elements.append(Paragraph("Daftar Kebutuhan Data Kelompok 3 (Akreditasi & SPMI) dari Kelompok 1 & 2", title_style))
    elements.append(Paragraph("Project Based Learning (PBL) — Pengembangan Sistem Informasi Akreditasi LAM INFOKOM Versi 2.1", subtitle_style))

    # Meta Table Box
    meta_data = [
        [
            Paragraph("<b>Pemohon (Konsumen API):</b> Kelompok 3 (Akreditasi, Mutu & Reporting)", table_cell),
            Paragraph("<b>Penyedia API 1:</b> Kelompok 1 (Pendidikan & Lulusan)", table_cell)
        ],
        [
            Paragraph("<b>Versi Dokumen:</b> 1.0 (Oktober 2026)", table_cell),
            Paragraph("<b>Penyedia API 2:</b> Kelompok 2 (SDM, Tri Dharma & Kerjasama)", table_cell)
        ]
    ]
    meta_table = Table(meta_data, colWidths=[255, 255])
    meta_table.setStyle(TableStyle([
        ('BACKGROUND', (0,0), (-1,-1), colors.HexColor('#f1f5f9')),
        ('BOX', (0,0), (-1,-1), 1, colors.HexColor('#cbd5e1')),
        ('INNERGRID', (0,0), (-1,-1), 0.5, colors.HexColor('#e2e8f0')),
        ('TOPPADDING', (0,0), (-1,-1), 5),
        ('BOTTOMPADDING', (0,0), (-1,-1), 5),
        ('LEFTPADDING', (0,0), (-1,-1), 8),
        ('RIGHTPADDING', (0,0), (-1,-1), 8),
    ]))
    elements.append(meta_table)
    elements.append(Spacer(1, 10))

    # Section 1: Pengantar
    elements.append(Paragraph("1. Latar Belakang & Peran Sistem Kelompok 3", h1_style))
    elements.append(Paragraph(
        "Berdasarkan dokumen pembagian kerja PBL Sistem Akreditasi LAM INFOKOM 2.1, <b>Kelompok 3</b> bertanggung jawab atas mesin akreditasi utama (<i>Core LAM INFOKOM Engine</i>), Evaluasi Diri (LED), Laporan Kinerja Program Studi (LKPS), Repositori Bukti/Evidence Terpusat, Audit Mutu Internal (SPMI), serta <i>Dashboard Readiness & Early Warning System</i>.",
        body_style
    ))
    elements.append(Paragraph(
        "Sesuai prinsip <b>Mata Kuliah Interoperabilitas</b>, sistem Kelompok 3 tidak diperkenankan menginput ulang data operasional yang sudah dikelola oleh kelompok lain. Sistem Kelompok 3 akan mengonsumsi (<i>consume</i>) data agregat kuantitatif dan repositori evidence dari <b>Kelompok 1</b> dan <b>Kelompok 2</b> via REST API berformat JSON.",
        body_style
    ))

    # Section 2: Kebutuhan dari Kelompok 1
    elements.append(Paragraph("2. Kebutuhan Data dari KELOMPOK 1 (Pendidikan, Mahasiswa & Lulusan)", h1_style))
    elements.append(Paragraph(
        "Data ini dibutuhkan untuk penilaian <b>Kriteria C2 (Relevansi Pendidikan)</b>, penyusunan tabel LKPS profil mahasiswa, serta perhitungan rasio kecukupan mahasiswa terhadap dosen.",
        body_style
    ))

    k1_table_data = [
        [
            Paragraph("No", table_header),
            Paragraph("Kategori Data", table_header),
            Paragraph("Parameter / Field yang Dibutuhkan", table_header),
            Paragraph("Kegunaan di Kelompok 3 (Akreditasi)", table_header)
        ],
        [
            Paragraph("1", table_cell),
            Paragraph("<b>Statistik Mahasiswa</b>", table_cell),
            Paragraph("• Mahasiswa Aktif per angkatan (TS-4 s.d. TS)<br/>• Daya Tampung, Pendaftar, Lulus Seleksi, Registrasi<br/>• Mahasiswa Transfer dan Mahasiswa Asing", table_cell),
            Paragraph("• Input otomatis Tabel LKPS Mahasiswa Baru.<br/>• Pembagi perhitungan <b>Rasio Dosen : Mahasiswa</b>.", table_cell)
        ],
        [
            Paragraph("2", table_cell),
            Paragraph("<b>Statistik Kelulusan & Masa Studi</b>", table_cell),
            Paragraph("• Rata-rata IPK Lulusan prodi<br/>• Rata-rata Masa Studi Lulusan (semester/tahun)<br/>• Persentase Kelulusan Tepat Waktu (KTW)", table_cell),
            Paragraph("• Scoring matriks rubrik keberhasilan studi.<br/>• Trigger <i>Early Warning System</i> jika KTW &lt; 70%.", table_cell)
        ],
        [
            Paragraph("3", table_cell),
            Paragraph("<b>Prestasi Mahasiswa</b>", table_cell),
            Paragraph("• Rekap jumlah prestasi akademik & non-akademik<br/>• Tingkat: Wilayah/Lokal, Nasional, Internasional", table_cell),
            Paragraph("• Pengisian poin capaian mahasiswa pada tabel LKPS Prestasi Mahasiswa.", table_cell)
        ],
        [
            Paragraph("4", table_cell),
            Paragraph("<b>Kurikulum & CPL</b>", table_cell),
            Paragraph("• Persentase rata-rata ketercapaian CPL prodi<br/>• Jumlah Mata Kuliah & RPS terintegrasi OBE", table_cell),
            Paragraph("• Narasi evaluasi diri (LED) Kriteria Pembelajaran.", table_cell)
        ],
        [
            Paragraph("5", table_cell),
            Paragraph("<b>Evidence Pendidikan</b>", table_cell),
            Paragraph("• URL/Dokumen Kurikulum resmi, Sampel RPS, SK Prestasi", table_cell),
            Paragraph("• Ditautkan langsung ke menu <i>Evidence</i> per butir indikator akreditasi.", table_cell)
        ]
    ]

    t_k1 = Table(k1_table_data, colWidths=[20, 105, 210, 175])
    t_k1.setStyle(TableStyle([
        ('BACKGROUND', (0,0), (-1,0), colors.HexColor('#0284c7')),
        ('ALIGN', (0,0), (0,-1), 'CENTER'),
        ('VALIGN', (0,0), (-1,-1), 'TOP'),
        ('GRID', (0,0), (-1,-1), 0.5, colors.HexColor('#cbd5e1')),
        ('ROWBACKGROUNDS', (0,1), (-1,-1), [colors.white, colors.HexColor('#f8fafc')]),
        ('TOPPADDING', (0,0), (-1,-1), 4),
        ('BOTTOMPADDING', (0,0), (-1,-1), 4),
        ('LEFTPADDING', (0,0), (-1,-1), 5),
        ('RIGHTPADDING', (0,0), (-1,-1), 5),
    ]))
    elements.append(t_k1)

    elements.append(Paragraph("<b>Spesifikasi Endpoint API yang Diharapkan dari Kelompok 1:</b>", h2_style))
    k1_code = (
        "1. GET /api/v1/mahasiswa/statistik?id_prodi={id}&tahun={ts}\n"
        "   Output: { id_prodi: 1, tahun_akademik: '2026/2027', daya_tampung: 120, pendaftar: 480,\n"
        "             mahasiswa_baru: 112, mahasiswa_aktif: 425, mahasiswa_asing: 2 }\n"
        "2. GET /api/v1/lulusan/statistik?id_prodi={id}\n"
        "   Output: { id_prodi: 1, rata_rata_ipk: 3.52, rata_rata_masa_studi_tahun: 4.1, persentase_lulus_tepat_waktu: 87.2 }\n"
        "3. GET /api/v1/prestasi/summary?id_prodi={id} & GET /api/v1/kurikulum/cpl-summary?id_prodi={id}"
    )
    t_k1_code = Table([[Paragraph(k1_code.replace('\n', '<br/>'), code_style)]], colWidths=[510])
    t_k1_code.setStyle(TableStyle([
        ('BACKGROUND', (0,0), (-1,-1), colors.HexColor('#f8fafc')),
        ('BOX', (0,0), (-1,-1), 0.5, colors.HexColor('#94a3b8')),
        ('TOPPADDING', (0,0), (-1,-1), 4),
        ('BOTTOMPADDING', (0,0), (-1,-1), 4),
        ('LEFTPADDING', (0,0), (-1,-1), 6),
    ]))
    elements.append(t_k1_code)

    elements.append(PageBreak())

    # Section 3: Kebutuhan dari Kelompok 2
    elements.append(Paragraph("3. Kebutuhan Data dari KELOMPOK 2 (SDM, Tri Dharma & Kerja Sama)", h1_style))
    elements.append(Paragraph(
        "Data ini dibutuhkan untuk penilaian <b>Kriteria C3 (Relevansi Penelitian), C4 (Relevansi PkM), C5 (Akuntabilitas SDM)</b>, serta pemetaan kerja sama tridharma.",
        body_style
    ))

    k2_table_data = [
        [
            Paragraph("No", table_header),
            Paragraph("Kategori Data", table_header),
            Paragraph("Parameter / Field yang Dibutuhkan", table_header),
            Paragraph("Kegunaan di Kelompok 3 (Akreditasi)", table_header)
        ],
        [
            Paragraph("1", table_cell),
            Paragraph("<b>Kualifikasi DTPS (Dosen)</b>", table_cell),
            Paragraph("• Total Dosen Tetap Program Studi (DTPS)<br/>• Jumlah Dosen berkualifikasi S3 (Doktor)<br/>• Jumlah Dosen Lektor Kepala dan Guru Besar<br/>• Jumlah Dosen ber-Serdos & Sertifikasi Profesi", table_cell),
            Paragraph("• Perhitungan kecukupan kualifikasi dosen.<br/>• Pembilang perhitungan rasio dosen:mahasiswa.", table_cell)
        ],
        [
            Paragraph("2", table_cell),
            Paragraph("<b>Kinerja Penelitian DTPS</b>", table_cell),
            Paragraph("• Jumlah judul penelitian DTPS dalam 3 tahun (TS)<br/>• Sumber dana: Mandiri, PT, Nasional (Hibah), LN<br/>• Jumlah mahasiswa yang terlibat penelitian dosen", table_cell),
            Paragraph("• Pengisian otomatis Tabel LKPS Penelitian.<br/>• Skor produktivitas penelitian dosen per tahun.", table_cell)
        ],
        [
            Paragraph("3", table_cell),
            Paragraph("<b>Publikasi, Sitasi & HKI</b>", table_cell),
            Paragraph("• Jumlah Jurnal Internasional (Scopus/WoS)<br/>• Jumlah Jurnal Nasional Terakreditasi Sinta<br/>• Jumlah Buku ber-ISBN dan Sitasi karya dosen<br/>• Jumlah Paten / Hak Cipta (HKI) terdaftar", table_cell),
            Paragraph("• Matriks skor indikator luaran publikasi ilmiah pada instrumen LAM INFOKOM.<br/>• Visualisasi trend publikasi pada dashboard.", table_cell)
        ],
        [
            Paragraph("4", table_cell),
            Paragraph("<b>Pengabdian Masyarakat (PkM)</b>", table_cell),
            Paragraph("• Jumlah kegiatan PkM DTPS dalam 3 tahun terakhir<br/>• Sumber pendanaan PkM dan luaran produk/HAKI<br/>• Keterlibatan mahasiswa dalam kegiatan PkM", table_cell),
            Paragraph("• Pengisian otomatis Tabel LKPS Pengabdian kepada Masyarakat (PkM).", table_cell)
        ],
        [
            Paragraph("5", table_cell),
            Paragraph("<b>Kerja Sama Tridharma</b>", table_cell),
            Paragraph("• Jumlah dokumen kerja sama aktif (MoU, MoA, IA)<br/>• Kategori: Bidang Pendidikan, Penelitian, atau PkM<br/>• Skala: Wilayah/Lokal, Nasional, Internasional", table_cell),
            Paragraph("• Scoring bobot kriteria kemitraan dan reputasi program studi.", table_cell)
        ],
        [
            Paragraph("6", table_cell),
            Paragraph("<b>Evidence SDM & Tri Dharma</b>", table_cell),
            Paragraph("• URL SK DTPS, Sertifikat Serdos, Kontrak Penelitian/PkM, Bukti MoU/MoA/IA", table_cell),
            Paragraph("• Terintegrasi ke modul verifikasi bukti dukung fisik reviewer di Kelompok 3.", table_cell)
        ]
    ]

    t_k2 = Table(k2_table_data, colWidths=[20, 105, 210, 175])
    t_k2.setStyle(TableStyle([
        ('BACKGROUND', (0,0), (-1,0), colors.HexColor('#0284c7')),
        ('ALIGN', (0,0), (0,-1), 'CENTER'),
        ('VALIGN', (0,0), (-1,-1), 'TOP'),
        ('GRID', (0,0), (-1,-1), 0.5, colors.HexColor('#cbd5e1')),
        ('ROWBACKGROUNDS', (0,1), (-1,-1), [colors.white, colors.HexColor('#f8fafc')]),
        ('TOPPADDING', (0,0), (-1,-1), 4),
        ('BOTTOMPADDING', (0,0), (-1,-1), 4),
        ('LEFTPADDING', (0,0), (-1,-1), 5),
        ('RIGHTPADDING', (0,0), (-1,-1), 5),
    ]))
    elements.append(t_k2)

    elements.append(Paragraph("<b>Spesifikasi Endpoint API yang Diharapkan dari Kelompok 2:</b>", h2_style))
    k2_code = (
        "1. GET /api/v1/dosen/statistik?id_prodi={id}\n"
        "   Output: { id_prodi: 1, jumlah_dtps: 20, dosen_s3: 8, lektor_kepala: 3, guru_besar: 1,\n"
        "             sertifikat_pendidik: 17, sertifikat_kompetensi: 12 }\n"
        "2. GET /api/v1/penelitian/statistik?id_prodi={id}&tahun={ts}\n"
        "   Output: { id_prodi: 1, total_penelitian_3th: 35, keterlibatan_mahasiswa: 28,\n"
        "             sumber_dana: { institusi: 20, nasional: 12, internasional: 3 } }\n"
        "3. GET /api/v1/publikasi-hki/statistik?id_prodi={id}\n"
        "   Output: { id_prodi: 1, publikasi_scopus: 14, jurnal_nasional_sinta: 24, hki_paten: 8 }\n"
        "4. GET /api/v1/kerjasama/summary?id_prodi={id}\n"
        "   Output: { id_prodi: 1, total_kerjasama_aktif: 17, internasional: 3, nasional: 10, lokal: 4 }"
    )
    t_k2_code = Table([[Paragraph(k2_code.replace('\n', '<br/>'), code_style)]], colWidths=[510])
    t_k2_code.setStyle(TableStyle([
        ('BACKGROUND', (0,0), (-1,-1), colors.HexColor('#f8fafc')),
        ('BOX', (0,0), (-1,-1), 0.5, colors.HexColor('#94a3b8')),
        ('TOPPADDING', (0,0), (-1,-1), 4),
        ('BOTTOMPADDING', (0,0), (-1,-1), 4),
        ('LEFTPADDING', (0,0), (-1,-1), 6),
    ]))
    elements.append(t_k2_code)

    # Section 4: Data Master Pengguna
    elements.append(Paragraph("4. Kebutuhan Data Referensi & Master Pengguna (User Management)", h1_style))
    elements.append(Paragraph(
        "Kelompok 3 mengelola alur penugasan borang dan validasi akreditasi. Dibutuhkan referensi ID pengguna dari modul autentikasi/pengguna untuk mengisi tabel berikut:",
        body_style
    ))

    user_table_data = [
        [
            Paragraph("Modul di Kelompok 3", table_header),
            Paragraph("Field Foreign Reference", table_header),
            Paragraph("Role & Fungsi Pengguna yang Diharapkan", table_header)
        ],
        [
            Paragraph("<b>Mapping Tim Akreditasi</b>", table_cell),
            Paragraph("<code>mapping_tim_akreditasi.id_user</code>", table_cell),
            Paragraph("Dosen / PIC penyusun yang ditugaskan mengisi narasi per butir indikator akreditasi.", table_cell)
        ],
        [
            Paragraph("<b>Self Assessment</b>", table_cell),
            Paragraph("<code>self_assessment.id_reviewer</code>", table_cell),
            Paragraph("Reviewer Internal / Asesor yang memberikan penilaian skor rubrik dan catatan rekomendasi.", table_cell)
        ],
        [
            Paragraph("<b>Audit Mutu Internal (SPMI)</b>", table_cell),
            Paragraph("<code>data_spmi_audit.id_auditor</code>", table_cell),
            Paragraph("Auditor Internal SPMI yang mencatat temuan observasi / ketidaksesuaian mutu prodi.", table_cell)
        ],
        [
            Paragraph("<b>Validasi Bukti Fisik</b>", table_cell),
            Paragraph("<code>bukti.validated_by</code>", table_cell),
            Paragraph("Asesor / Pimpinan yang menyetujui, meminta revisi, atau menolak berkas bukti dukung.", table_cell)
        ]
    ]

    t_user = Table(user_table_data, colWidths=[130, 160, 220])
    t_user.setStyle(TableStyle([
        ('BACKGROUND', (0,0), (-1,0), colors.HexColor('#0284c7')),
        ('VALIGN', (0,0), (-1,-1), 'TOP'),
        ('GRID', (0,0), (-1,-1), 0.5, colors.HexColor('#cbd5e1')),
        ('ROWBACKGROUNDS', (0,1), (-1,-1), [colors.white, colors.HexColor('#f8fafc')]),
        ('TOPPADDING', (0,0), (-1,-1), 4),
        ('BOTTOMPADDING', (0,0), (-1,-1), 4),
        ('LEFTPADDING', (0,0), (-1,-1), 5),
    ]))
    elements.append(t_user)

    # Section 5: Contoh Hasil Agregasi
    elements.append(Paragraph("5. Contoh Output Hasil Agregasi di Dashboard Kelompok 3", h1_style))
    elements.append(Paragraph(
        "Setelah mengonsumsi API dari Kelompok 1 dan Kelompok 2, sistem Kelompok 3 akan otomatis menggabungkannya menjadi kalkulasi otomatis kesiapan akreditasi (<i>Accreditation Readiness</i>):",
        body_style
    ))

    agg_code = (
        "{\n"
        "  \"program_studi\": \"D4 Teknologi Rekayasa Komputer\",\n"
        "  \"mahasiswa_aktif\": 425,              // Diambil dari API Kelompok 1\n"
        "  \"lulusan_tepat_waktu\": 87.2,         // Diambil dari API Kelompok 1\n"
        "  \"dtps\": 20,                          // Diambil dari API Kelompok 2\n"
        "  \"publikasi_dtps\": 38,                 // Diambil dari API Kelompok 2\n"
        "  \"rasio_dosen_mahasiswa\": 21.25,     // Dihitung otomatis oleh Kelompok 3: (425 / 20)\n"
        "  \"hasil_simulasi_akreditasi\": {\n"
        "    \"skor_sdm\": 3.85,                  // Evaluasi otomatis berdasarkan matriks LAM INFOKOM\n"
        "    \"skor_pendidikan\": 3.70,           // Evaluasi otomatis berdasarkan matriks LAM INFOKOM\n"
        "    \"overall_readiness\": \"88.5%\",      // Persentase kesiapan dokumen & ketercapaian skor\n"
        "    \"proyeksi_peringkat\": \"Terakreditasi Unggul\"\n"
        "  }\n"
        "}"
    )
    t_agg = Table([[Paragraph(agg_code.replace('\n', '<br/>'), code_style)]], colWidths=[510])
    t_agg.setStyle(TableStyle([
        ('BACKGROUND', (0,0), (-1,-1), colors.HexColor('#f8fafc')),
        ('BOX', (0,0), (-1,-1), 0.5, colors.HexColor('#94a3b8')),
        ('TOPPADDING', (0,0), (-1,-1), 4),
        ('BOTTOMPADDING', (0,0), (-1,-1), 4),
        ('LEFTPADDING', (0,0), (-1,-1), 6),
    ]))
    elements.append(t_agg)

    # Section 6: Standar Teknis Interoperabilitas
    elements.append(Paragraph("6. Standar Teknis & Protokol Interoperabilitas", h1_style))
    std_text = (
        "1. <b>Standar Format Response:</b> Seluruh endpoint API wajib menggunakan pembungkus standar JSON:<br/>"
        "   <code>{ \"success\": true/false, \"message\": \"pesan\", \"data\": { ... }, \"errors\": null }</code>.<br/>"
        "2. <b>Filter & Parameter:</b> Setiap endpoint wajib mendukung query parameter <code>id_prodi</code> dan <code>tahun</code>.<br/>"
        "3. <b>Dokumentasi Terpadu:</b> Setiap kelompok wajib menyediakan antarmuka <b>OpenAPI / Swagger UI</b> yang dapat diakses langsung oleh pengembang lain untuk verifikasi kontrak data."
    )
    elements.append(Paragraph(std_text, body_style))

    doc.build(elements, canvasmaker=NumberedCanvas)
    print(f"PDF berhasil dibuat: {filename}")

if __name__ == "__main__":
    output_pdf = r"c:\Users\HP OMEN\Documents\college\semester 3\pbl\akreditasi\Dokumen_Kebutuhan_Data_Kelompok_1_dan_2.pdf"
    build_pdf(output_pdf)
