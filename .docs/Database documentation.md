# Dokumentasi Database KPFIDB

## Informasi Database
- **Nama Database**: your_db_username
- **Host**: your_db_host
- **Server Version**: MySQL 8.0.44
- **Character Set**: utf8mb4
- **Collation**: utf8mb4_unicode_ci
- **Tanggal Dump**: 20 Januari 2026, 19:25:11

---

## Daftar Tabel

Database ini memiliki 28 tabel utama yang mengelola sistem pembiayaan pensiun dan operasional kantor.

### 1. Bank
**Deskripsi**: Menyimpan data bank mitra dan konfigurasi biaya-biaya terkait.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | VARCHAR(191) | Primary Key |
| name | VARCHAR(191) | Nama bank (Unique) |
| kode | VARCHAR(191) | Kode bank (Unique, Nullable) |
| by_admin | DOUBLE | Biaya admin |
| by_admin_bank | DOUBLE | Biaya admin bank (Nullable) |
| by_lainnya | DOUBLE | Biaya lainnya (Nullable) |
| by_tatalaksana | INT | Biaya tata laksana |
| by_materai | INT | Biaya materai |
| by_buka_rekening | INT | Biaya buka rekening |
| by_angsuran | DOUBLE | Biaya angsuran |
| by_flagging | INT | Biaya flagging (Default: 20000) |
| by_epotpen | INT | Biaya epotpen (Default: 35000) |
| by_provisi | INT | Biaya provisi (Default: 0) |
| margin_bank | DOUBLE | Margin bank (Default: 14) |
| is_syariah | BOOLEAN | Status bank syariah (Default: 0) |
| logo | VARCHAR(191) | Path logo bank (Nullable) |
| up_direktur | VARCHAR(191) | Nama up direktur (Nullable) |
| direktur | VARCHAR(191) | Nama direktur (Nullable) |
| penanggung_jawab | VARCHAR(191) | Nama penanggung jawab (Nullable) |
| account_officer | VARCHAR(191) | Nama account officer (Nullable) |
| credit_review | VARCHAR(191) | Nama credit review (Nullable) |
| ketua_credit | VARCHAR(191) | Nama ketua credit (Nullable) |
| wakil_ketua | VARCHAR(191) | Nama wakil ketua (Nullable) |
| diperiksa_oleh | VARCHAR(191) | Nama pemeriksa (Nullable) |
| jabatan_diperiksa | VARCHAR(191) | Jabatan pemeriksa (Nullable) |
| otorisasi_oleh | VARCHAR(191) | Nama otorisasi (Nullable) |
| jabatan_otorisasi | VARCHAR(191) | Jabatan otorisasi (Nullable) |
| akad | VARCHAR(191) | Jenis akad (Nullable) |
| sk_akad | LONGTEXT | SK akad (Nullable) |
| alamat | VARCHAR(191) | Alamat bank (Nullable) |
| no_telepon | VARCHAR(191) | Nomor telepon (Nullable) |
| email | VARCHAR(191) | Email bank (Nullable) |
| is_active | BOOLEAN | Status aktif (Default: 1) |
| created_at | DATETIME(3) | Tanggal dibuat (Default: CURRENT_TIMESTAMP) |
| is_flash | BOOLEAN | Status flash (Default: 0) |
| pembulatan | INT | Pembulatan (Default: 1) |

**Index**:
- PRIMARY KEY: id
- UNIQUE KEY: name, kode

---

### 2. BerkasPengajuan
**Deskripsi**: Menyimpan data berkas-berkas yang diperlukan dalam proses pengajuan pembiayaan.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | VARCHAR(191) | Primary Key |
| berkas_slik | VARCHAR(191) | Berkas SLIK (Nullable) |
| berkas_pengajuan | VARCHAR(191) | Berkas pengajuan (Nullable) |
| video_wawancara | VARCHAR(191) | Video wawancara (Nullable) |
| video_asuransi | VARCHAR(191) | Video asuransi (Nullable) |
| berkas_akad | VARCHAR(191) | Berkas akad (Nullable) |
| tanggal_akad | VARCHAR(191) | Tanggal akad (Nullable) |
| bukti_cair | VARCHAR(191) | Bukti pencairan (Nullable) |
| tanggal_bukti_cair | DATETIME(3) | Tanggal bukti cair (Nullable) |
| pelunasan | VARCHAR(191) | Berkas pelunasan (Nullable) |
| tanggal_pelunasan | DATETIME(3) | Tanggal pelunasan (Nullable) |
| jaminan | VARCHAR(191) | Berkas jaminan (Nullable) |
| tanggal_jaminan | DATETIME(3) | Tanggal jaminan (Nullable) |
| rekening | VARCHAR(191) | Berkas rekening (Nullable) |
| tanggal_rekening | DATETIME(3) | Tanggal rekening (Nullable) |
| mutasi | VARCHAR(191) | Berkas mutasi (Nullable) |
| tanggal_mutasi | DATETIME(3) | Tanggal mutasi (Nullable) |
| flagging | VARCHAR(191) | Berkas flagging (Nullable) |
| tanggal_flagging | DATETIME(3) | Tanggal flagging (Nullable) |
| video_cair | VARCHAR(191) | Video pencairan 1 (Nullable) |
| tanggal_video_cair | DATETIME(3) | Tanggal video cair 1 (Nullable) |
| video_cair2 | VARCHAR(191) | Video pencairan 2 (Nullable) |
| tanggal_video_cair2 | DATETIME(3) | Tanggal video cair 2 (Nullable) |
| video_cair3 | VARCHAR(191) | Video pencairan 3 (Nullable) |
| tanggal_video_cair3 | DATETIME(3) | Tanggal video cair 3 (Nullable) |
| no_rekening | VARCHAR(191) | Nomor rekening (Nullable) |
| nama_bank | VARCHAR(191) | Nama bank (Nullable) |
| berkas_lainnya | VARCHAR(191) | Berkas lainnya (Nullable) |
| tanggal_berkas_lainnya | DATETIME(3) | Tanggal berkas lainnya (Nullable) |
| epotpen | VARCHAR(191) | Berkas epotpen (Nullable) |
| tanggal_epotpen | DATETIME(3) | Tanggal epotpen (Nullable) |
| berkas_flagging | VARCHAR(191) | Berkas flagging (Nullable) |
| berkas_idpb | VARCHAR(191) | Berkas IDPB (Nullable) |
| status_flagging | ENUM | Status flagging (Default: BELUM_PROSESS) |
| status_mutasi | ENUM | Status mutasi (Default: BELUM_PROSESS) |
| video_akad | VARCHAR(191) | Video akad (Nullable) |
| tanggal_video_akad | DATETIME(3) | Tanggal video akad (Nullable) |

**Enum Values**:
- status_flagging/status_mutasi: 'SELESAI', 'PROSESS', 'GAGAL', 'BELUM_PROSESS'

---

### 3. Blog
**Deskripsi**: Menyimpan artikel blog untuk website.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | VARCHAR(191) | Primary Key |
| title | VARCHAR(191) | Judul artikel |
| slug | VARCHAR(191) | URL slug (Unique) |
| image | VARCHAR(191) | Path gambar (Default: /blog/blog.jpg) |
| description | VARCHAR(191) | Deskripsi singkat |
| body | LONGTEXT | Konten artikel |
| view | INT | Jumlah views (Default: 0) |
| like | INT | Jumlah like (Default: 0) |
| dislike | INT | Jumlah dislike (Default: 0) |
| is_active | BOOLEAN | Status aktif (Default: 1) |
| created_at | DATETIME(3) | Tanggal dibuat (Default: CURRENT_TIMESTAMP) |
| updated_at | DATETIME(3) | Tanggal diupdate (Nullable) |
| keyword | VARCHAR(191) | Keyword SEO (Default: 'kpf artikel') |
| blogCategoryId | VARCHAR(191) | Foreign Key ke BlogCategory |

**Foreign Keys**:
- blogCategoryId → BlogCategory(id) ON DELETE RESTRICT ON UPDATE CASCADE

---

### 4. BlogCategory
**Deskripsi**: Kategori untuk artikel blog.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | VARCHAR(191) | Primary Key |
| name | VARCHAR(191) | Nama kategori (Unique) |
| slug | VARCHAR(191) | URL slug (Unique) |
| description | VARCHAR(191) | Deskripsi kategori (Nullable) |
| image | VARCHAR(191) | Path gambar (Default: /category/category.jpg) |
| is_active | BOOLEAN | Status aktif (Default: 1) |

---

### 5. Cost
**Deskripsi**: Menyimpan data biaya operasional.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | VARCHAR(191) | Primary Key |
| name | VARCHAR(191) | Nama biaya |
| nominal | INT | Nominal biaya |
| keterangan | VARCHAR(191) | Keterangan biaya |
| is_active | BOOLEAN | Status aktif (Default: 1) |
| is_fixed | BOOLEAN | Status fixed cost (Default: 0) |
| created_at | DATETIME(3) | Tanggal dibuat (Default: CURRENT_TIMESTAMP) |
| updated_at | DATETIME(3) | Tanggal diupdate (Nullable) |
| userId | VARCHAR(191) | Foreign Key ke User (Nullable) |

**Foreign Keys**:
- userId → User(id) ON DELETE SET NULL ON UPDATE CASCADE

---

### 6. DataDomisili
**Deskripsi**: Menyimpan data alamat KTP dan alamat domisili.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | VARCHAR(191) | Primary Key |
| alamat | VARCHAR(191) | Alamat KTP |
| rt | VARCHAR(191) | RT KTP (Nullable) |
| rw | VARCHAR(191) | RW KTP (Nullable) |
| kelurahan | VARCHAR(191) | Kelurahan KTP (Nullable) |
| kecamatan | VARCHAR(191) | Kecamatan KTP (Nullable) |
| kota | VARCHAR(191) | Kota KTP (Nullable) |
| provinsi | VARCHAR(191) | Provinsi KTP (Nullable) |
| kode_pos | VARCHAR(191) | Kode pos KTP (Nullable) |
| alamat_domisili | VARCHAR(191) | Alamat domisili (Nullable) |
| rt_domisili | VARCHAR(191) | RT domisili (Nullable) |
| rw_domisili | VARCHAR(191) | RW domisili (Nullable) |
| kelurahan_domisili | VARCHAR(191) | Kelurahan domisili (Nullable) |
| kecamatan_domisili | VARCHAR(191) | Kecamatan domisili (Nullable) |
| kota_domisili | VARCHAR(191) | Kota domisili (Nullable) |
| provinsi_domisili | VARCHAR(191) | Provinsi domisili (Nullable) |
| kode_pos_domisili | VARCHAR(191) | Kode pos domisili (Nullable) |
| geo_location | VARCHAR(191) | Koordinat lokasi (Nullable) |

---

### 7. DataKeluarga
**Deskripsi**: Menyimpan data anggota keluarga pegawai.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | VARCHAR(191) | Primary Key |
| nama | VARCHAR(191) | Nama anggota keluarga |
| hubungan | VARCHAR(191) | Hubungan keluarga (Nullable) |
| no_telepon | VARCHAR(191) | Nomor telepon (Nullable) |
| alamat | VARCHAR(191) | Alamat (Nullable) |
| tanggal_lahir | VARCHAR(191) | Tanggal lahir (Nullable) |
| tanggal_wafat | VARCHAR(191) | Tanggal wafat (Nullable) |
| tanggal_nikah | VARCHAR(191) | Tanggal nikah (Nullable) |
| akhir_sks | VARCHAR(191) | Akhir SKS (Nullable) |
| no_kk | VARCHAR(191) | Nomor KK (Nullable) |
| no_ktp | VARCHAR(191) | Nomor KTP (Nullable) |
| no_skep | VARCHAR(191) | Nomor SKEP (Nullable) |
| npwp | VARCHAR(191) | NPWP (Nullable) |
| kode_tunjang | VARCHAR(191) | Kode tunjangan (Default: '1') |
| keterangan | VARCHAR(191) | Keterangan (Nullable) |
| hak_bagi | DOUBLE | Hak bagi (Nullable) |
| tat_tunjang | VARCHAR(191) | TAT tunjangan (Nullable) |
| tmt_tunjang | VARCHAR(191) | TMT tunjangan (Nullable) |
| gelar_depan | VARCHAR(191) | Gelar depan (Nullable) |

---

### 8. DataPasangan
**Deskripsi**: Menyimpan data pasangan dari peserta.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | VARCHAR(191) | Primary Key |
| nama_pasangan | VARCHAR(191) | Nama pasangan (Nullable) |
| tempat_lahir_pasangan | VARCHAR(191) | Tempat lahir pasangan (Nullable) |
| tanggal_lahir_pasangan | VARCHAR(191) | Tanggal lahir pasangan (Nullable) |
| nik_pasangan | VARCHAR(191) | NIK pasangan (Nullable) |
| masa_ktp_pasangan | VARCHAR(191) | Masa berlaku KTP pasangan (Nullable) |
| pekerjaan_pasangan | VARCHAR(191) | Pekerjaan pasangan (Nullable) |
| alamat_pasangan | VARCHAR(191) | Alamat pasangan (Nullable) |

---

### 9. DataPembiayaan
**Deskripsi**: Menyimpan detail pembiayaan yang diajukan.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | VARCHAR(191) | Primary Key |
| pengajuan | INT | Nominal pengajuan |
| tenor | INT | Jangka waktu pembiayaan (bulan) |
| margin_bank | DOUBLE | Margin bank |
| biaya_provisi | INT | Biaya provisi |
| biaya_admin | INT | Biaya admin |
| biaya_admin_bank | INT | Biaya admin bank |
| biaya_buka_rekening | INT | Biaya buka rekening |
| biaya_flagging | INT | Biaya flagging |
| biaya_tata_laksana | INT | Biaya tata laksana |
| biaya_materai | INT | Biaya materai |
| biaya_angsuran | INT | Biaya angsuran |
| biaya_lainnya | INT | Biaya lainnya |
| biaya_mutasi | INT | Biaya mutasi |
| biaya_epotpen | INT | Biaya epotpen |
| total_pokok | INT | Total pokok |
| tanggal_pembiayaan | VARCHAR(191) | Tanggal mulai pembiayaan (Nullable) |
| total_margin | INT | Total margin |
| jumlah_diterima | INT | Jumlah diterima |
| angsuran | INT | Angsuran per bulan |
| angsuran_margin_bank | INT | Angsuran margin bank |
| angsuran_kpfi | INT | Angsuran KPFI |
| total_pengembalian | INT | Total pengembalian |
| jenisPembiayaanId | VARCHAR(191) | Foreign Key ke JenisPembiayaan |
| is_active | BOOLEAN | Status aktif (Default: 1) |
| created_at | DATETIME(3) | Tanggal dibuat (Default: CURRENT_TIMESTAMP) |

**Foreign Keys**:
- jenisPembiayaanId → JenisPembiayaan(id) ON DELETE RESTRICT ON UPDATE CASCADE

---

### 10. DataPencairan
**Deskripsi**: Menyimpan data pencairan dana pembiayaan.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | VARCHAR(191) | Primary Key |
| type | ENUM | Tipe pencairan |
| jumlah_pencairan | INT | Jumlah pencairan |
| biaya_materai | INT | Biaya materai |
| biaya_admin_bank | INT | Biaya admin bank |
| biaya_admin | INT | Biaya admin |
| biaya_transfer | INT | Biaya transfer |
| biaya_angsuran | INT | Biaya angsuran |
| biaya_jasa_lainnya | INT | Biaya jasa lainnya |
| biaya_kpfi | INT | Biaya KPFI |
| nama_bank | VARCHAR(191) | Nama bank tujuan (Nullable) |
| nomor_rekening | VARCHAR(191) | Nomor rekening tujuan (Nullable) |
| jumlah_diterima_debitur | INT | Jumlah diterima debitur |
| tanggal_pencairan | DATETIME(3) | Tanggal pencairan (Default: CURRENT_TIMESTAMP) |

**Enum Values**:
- type: 'CASH', 'TRANSFER'

---

### 11. DataPengajuan
**Deskripsi**: Tabel utama untuk data pengajuan pembiayaan.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | VARCHAR(191) | Primary Key |
| tanggal_pengajuan | DATETIME(3) | Tanggal pengajuan (Default: CURRENT_TIMESTAMP) |
| nopen | VARCHAR(191) | Nomor peserta (Nullable) |
| nama | VARCHAR(191) | Nama pemohon (Nullable) |
| nama_skep | VARCHAR(191) | Nama di SKEP (Nullable) |
| kode_jiwa | VARCHAR(191) | Kode jiwa (Nullable) |
| golongan | VARCHAR(191) | Golongan (Nullable) |
| jenis_pensiun | VARCHAR(191) | Jenis pensiun (Nullable) |
| nik | VARCHAR(191) | NIK (Nullable) |
| masa_ktp | VARCHAR(191) | Masa berlaku KTP (Nullable) |
| npwp | VARCHAR(191) | NPWP (Nullable) |
| pendidikan | ENUM | Pendidikan terakhir (Nullable) |
| jenis_kelamin | ENUM | Jenis kelamin (Nullable) |
| agama | ENUM | Agama (Nullable) |
| masa_kerja | INT | Masa kerja (Nullable) |
| status_rumah | ENUM | Status kepemilikan rumah (Nullable) |
| menempati_tahun | VARCHAR(191) | Tahun menempati (Nullable) |
| nama_ibu_kandung | VARCHAR(191) | Nama ibu kandung (Nullable) |
| pekerjaan_sekarang | VARCHAR(191) | Pekerjaan saat ini (Nullable) |
| alamat_pekerjaan | VARCHAR(191) | Alamat pekerjaan (Nullable) |
| jenis_usaha | ENUM | Jenis usaha (Nullable) |
| status_kawin | ENUM | Status perkawinan (Nullable) |
| nomor_sk_pensiun | VARCHAR(191) | Nomor SK pensiun (Nullable) |
| tanggal_sk_pensiun | VARCHAR(191) | Tanggal SK pensiun (Nullable) |
| tmt_pensiun | VARCHAR(191) | TMT pensiun (Nullable) |
| penerbit_sk | VARCHAR(191) | Penerbit SK (Nullable) |
| no_telepon | VARCHAR(191) | Nomor telepon (Nullable) |
| status_pengajuan | ENUM | Status pengajuan |
| keterangan_pengajuan | TEXT | Keterangan pengajuan (Nullable) |
| tanggal_ttd_pengajuan | DATETIME(3) | Tanggal TTD pengajuan (Nullable) |
| nama_pemeriksa_pengajuan | VARCHAR(191) | Nama pemeriksa pengajuan (Nullable) |
| status_verifikasi | ENUM | Status verifikasi (Nullable) |
| keterangan_verifikasi | TEXT | Keterangan verifikasi (Nullable) |
| tanggal_verifikasi | DATETIME(3) | Tanggal verifikasi (Nullable) |
| nama_pemeriksa_verifikasi | VARCHAR(191) | Nama pemeriksa verifikasi (Nullable) |
| status_checker | ENUM | Status checker (Nullable) |
| keterangan_checker | TEXT | Keterangan checker (Nullable) |
| tanggal_checker | DATETIME(3) | Tanggal checker (Nullable) |
| nama_pemeriksa_checker | VARCHAR(191) | Nama pemeriksa checker (Nullable) |
| status_maker | ENUM | Status maker (Nullable) |
| keterangan_maker | TEXT | Keterangan maker (Nullable) |
| tanggal_maker | DATETIME(3) | Tanggal maker (Nullable) |
| nama_pemeriksa_maker | VARCHAR(191) | Nama pemeriksa maker (Nullable) |
| status_approval | ENUM | Status approval (Nullable) |
| keterangan_approval | TEXT | Keterangan approval (Nullable) |
| tanggal_approval | DATETIME(3) | Tanggal approval (Nullable) |
| nama_pemeriksa_approval | VARCHAR(191) | Nama pemeriksa approval (Nullable) |
| status_pencairan | ENUM | Status pencairan (Nullable) |
| tanggal_pencairan | DATETIME(3) | Tanggal pencairan (Nullable) |
| tanggal_cetak_akad | DATETIME(3) | Tanggal cetak akad (Nullable) |
| nomor_akad | VARCHAR(191) | Nomor akad (Nullable) |
| jenis_margin | ENUM | Jenis margin (Nullable) |
| is_active | BOOLEAN | Status aktif (Default: 1) |
| is_cetak | BOOLEAN | Status cetak (Default: 0) |
| pembayaran_asuransi | BOOLEAN | Status pembayaran asuransi (Default: 0) |
| status_lunas | BOOLEAN | Status lunas (Default: 0) |
| tanggal_pembayaran_asuransi | DATETIME(3) | Tanggal pembayaran asuransi (Nullable) |
| area_pelayanan_berkas | VARCHAR(191) | Area pelayanan berkas (Nullable) |
| jenis_asuransi | VARCHAR(191) | Jenis asuransi (Default: 'CIU') |
| tagihan_manual | BOOLEAN | Status tagihan manual (Default: 0) |
| moc | VARCHAR(191) | MOC (Nullable) |
| berkasPengajuanId | VARCHAR(191) | Foreign Key ke BerkasPengajuan (Nullable) |
| dataTaspenId | VARCHAR(191) | Foreign Key ke DataTaspen (Nullable) |
| user_id | VARCHAR(191) | Foreign Key ke User (Nullable) |
| data_pembiayaan_id | VARCHAR(191) | Foreign Key ke DataPembiayaan |
| bankId | VARCHAR(191) | Foreign Key ke Bank (Nullable) |
| dataPencairanId | VARCHAR(191) | Foreign Key ke DataPencairan (Nullable) |
| dataPengajuanKeluargaId | VARCHAR(191) | Foreign Key ke DataPengajuanKeluarga |
| dataPengajuanAlamatId | VARCHAR(191) | Foreign Key ke DataPengajuanAlamat (Nullable) |
| penyerahanBerkasId | VARCHAR(191) | Foreign Key ke PenyerahanBerkas (Nullable) |
| penyerahanJaminanId | VARCHAR(191) | Foreign Key ke PenyerahanJaminan (Nullable) |

**Enum Values**:
- pendidikan: 'SD', 'SMP', 'SMA', 'D3', 'S1', 'S2', 'S3', 'LAINNYA'
- jenis_kelamin: 'LAKI_LAKI', 'PEREMPUAN'
- agama: 'ISLAM', 'KATHOLIK', 'KONGHUCU', 'HINDU', 'BUDHA', 'ATHEIS', 'KRISTEN', 'LAINNYA'
- status_rumah: 'SEWA', 'MILIK_SENDIRI', 'MILIK_KELUARGA', 'MILIK_ORANGLAIN', 'NGEKOS', 'TIDAK_PUNYA_RUMAH'
- jenis_usaha: 'WARUNG_KOPI', 'TOKO_KELONTONG', 'JASA_CUCI_MOBIL_DAN_MOTOR', 'KATERING', 'LOUNDRY', 'SALON_KECANTIKAN', 'LAINNYA'
- status_kawin: 'BELUM_KAWIN', 'KAWIN', 'JANDA', 'DUDA'
- status_pengajuan/verifikasi/checker/maker/approval: 'ANTRI', 'DITOLAK', 'SETUJU', 'PENDING'
- status_pencairan: 'TRANSFER', 'PROSES', 'BATAL'
- jenis_margin: 'FLAT', 'ANUITAS'

**Foreign Keys**: (banyak, lihat detail di tabel)

---

### 12. DataPengajuanAlamat
**Deskripsi**: Menyimpan data alamat khusus untuk pengajuan.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | VARCHAR(191) | Primary Key |
| alamat | VARCHAR(191) | Alamat KTP (Nullable) |
| rt | VARCHAR(191) | RT KTP (Nullable) |
| rw | VARCHAR(191) | RW KTP (Nullable) |
| kelurahan | VARCHAR(191) | Kelurahan KTP (Nullable) |
| kecamatan | VARCHAR(191) | Kecamatan KTP (Nullable) |
| kota | VARCHAR(191) | Kota KTP (Nullable) |
| provinsi | VARCHAR(191) | Provinsi KTP (Nullable) |
| kode_pos | VARCHAR(191) | Kode pos KTP (Nullable) |
| no_telepon | VARCHAR(191) | Nomor telepon (Nullable) |
| alamat_domisili | VARCHAR(191) | Alamat domisili (Nullable) |
| rt_domisili | VARCHAR(191) | RT domisili (Nullable) |
| rw_domisili | VARCHAR(191) | RW domisili (Nullable) |
| kelurahan_domisili | VARCHAR(191) | Kelurahan domisili (Nullable) |
| kecamatan_domisili | VARCHAR(191) | Kecamatan domisili (Nullable) |
| kota_domisili | VARCHAR(191) | Kota domisili (Nullable) |
| provinsi_domisili | VARCHAR(191) | Provinsi domisili (Nullable) |
| kode_pos_domisili | VARCHAR(191) | Kode pos domisili (Nullable) |
| geo_location | VARCHAR(191) | Koordinat lokasi (Nullable) |

---

### 13. DataPengajuanKeluarga
**Deskripsi**: Menyimpan data keluarga khusus untuk pengajuan.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | VARCHAR(191) | Primary Key |
| nama_pasangan | VARCHAR(191) | Nama pasangan (Nullable) |
| tempat_lahir_pasangan | VARCHAR(191) | Tempat lahir pasangan (Nullable) |
| tanggal_lahir_pasangan | VARCHAR(191) | Tanggal lahir pasangan (Nullable) |
| nik_pasangan | VARCHAR(191) | NIK pasangan (Nullable) |
| masa_ktp_pasangan | VARCHAR(191) | Masa berlaku KTP pasangan (Nullable) |
| pekerjaan_pasangan | VARCHAR(191) | Pekerjaan pasangan (Nullable) |
| alamat_pasangan | VARCHAR(191) | Alamat pasangan (Nullable) |
| nama_keluarga_tidak_serumah | VARCHAR(191) | Nama keluarga tidak serumah (Nullable) |
| hubungan | VARCHAR(191) | Hubungan keluarga (Nullable) |
| no_telepon_keluarga | VARCHAR(191) | Nomor telepon keluarga (Nullable) |
| alamat_keluarga | VARCHAR(191) | Alamat keluarga (Nullable) |

---

### 14. DataTaspen
**Deskripsi**: Menyimpan data peserta dari sistem Taspen.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | VARCHAR(191) | Primary Key |
| nopen | VARCHAR(191) | Nomor peserta (Unique) |
| nama | VARCHAR(191) | Nama peserta |
| nama_skep | VARCHAR(191) | Nama di SKEP (Nullable) |
| no_skep | VARCHAR(191) | Nomor SKEP (Nullable) |
| kode_jiwa | VARCHAR(191) | Kode jiwa |
| no_telepon | VARCHAR(191) | Nomor telepon (Nullable) |
| nik | VARCHAR(191) | NIK (Nullable) |
| masa_ktp | VARCHAR(191) | Masa berlaku KTP (Nullable) |
| npwp | VARCHAR(191) | NPWP (Nullable) |
| pendidikan | ENUM | Pendidikan terakhir (Nullable) |
| jenis_kelamin | ENUM | Jenis kelamin (Nullable) |
| agama | ENUM | Agama (Nullable) |
| masa_kerja | INT | Masa kerja (Nullable) |
| status_rumah | ENUM | Status kepemilikan rumah (Nullable) |
| menempati_tahun | VARCHAR(191) | Tahun menempati (Nullable) |
| nama_ibu_kandung | VARCHAR(191) | Nama ibu kandung (Nullable) |
| pekerjaan_sekarang | VARCHAR(191) | Pekerjaan saat ini (Nullable) |
| alamat_pekerjaan | VARCHAR(191) | Alamat pekerjaan (Nullable) |
| jenis_usaha | ENUM | Jenis usaha (Nullable) |
| status_kawin | ENUM | Status perkawinan (Nullable) |
| nomor_sk_pensiun | VARCHAR(191) | Nomor SK pensiun (Nullable) |
| tanggal_sk_pensiun | DATETIME(3) | Tanggal SK pensiun (Nullable) |
| tanggal_lahir | VARCHAR(191) | Tanggal lahir (Nullable) |
| tanggal_wafat | VARCHAR(191) | Tanggal wafat (Nullable) |
| tanggal_nikah | VARCHAR(191) | Tanggal nikah (Nullable) |
| akhir_sks | VARCHAR(191) | Akhir SKS (Nullable) |
| tmt_pensiun | VARCHAR(191) | TMT pensiun (Nullable) |
| penerbit_sk | VARCHAR(191) | Penerbit SK (Nullable) |
| golongan | VARCHAR(191) | Golongan (Nullable) |
| jenis_pensiun | VARCHAR(191) | Jenis pensiun (Nullable) |
| nipnrp | VARCHAR(191) | NIP/NRP (Nullable) |
| status_peserta | VARCHAR(191) | Status peserta (Default: 'PENSIUN') |
| jandadudaypdari | VARCHAR(191) | Janda/duda YP dari (Nullable) |
| tanggal_lahir_jandadudayp | VARCHAR(191) | Tanggal lahir janda/duda YP (Nullable) |
| awal_flagging | VARCHAR(191) | Awal flagging (Nullable) |
| akhir_flagging | VARCHAR(191) | Akhir flagging (Nullable) |
| alamat_cabang | VARCHAR(191) | Alamat cabang (Nullable) |
| blth_rincian | VARCHAR(191) | BLTH rincian (Nullable) |
| cicilan | VARCHAR(191) | Cicilan (Nullable) |
| jenis_hutang | VARCHAR(191) | Jenis hutang (Nullable) |
| jumlah_kotor | VARCHAR(191) | Jumlah kotor (Nullable) |
| jumlah_potongan | VARCHAR(191) | Jumlah potongan (Nullable) |
| jumlah_total | VARCHAR(191) | Jumlah total (Nullable) |
| jumlah_hutang | VARCHAR(191) | Jumlah hutang (Nullable) |
| jenis_dapem | VARCHAR(191) | Jenis dapem (Nullable) |
| kantor_cabang | VARCHAR(191) | Kantor cabang (Nullable) |
| ktr_bay_dapem | VARCHAR(191) | Kantor bayar dapem (Nullable) |
| mitra_flagging | VARCHAR(191) | Mitra flagging (Nullable) |
| no_dosir | VARCHAR(191) | Nomor dosir (Nullable) |
| no_rek | VARCHAR(191) | Nomor rekening (Nullable) |
| nu_dapem | VARCHAR(191) | NU dapem (Nullable) |
| pembulatan | VARCHAR(191) | Pembulatan (Nullable) |
| penpok | VARCHAR(191) | Penpok (Nullable) |
| status_dapem | VARCHAR(191) | Status dapem (Nullable) |
| tanggal_sekarang | VARCHAR(191) | Tanggal sekarang (Nullable) |
| tanggal_surat | VARCHAR(191) | Tanggal surat (Nullable) |
| tkd | VARCHAR(191) | TKD (Nullable) |
| tmt_stop | VARCHAR(191) | TMT stop (Nullable) |
| tpmtp | VARCHAR(191) | TPMTP (Nullable) |
| tpp | VARCHAR(191) | TPP (Nullable) |
| tpph21 | VARCHAR(191) | TPPH21 (Nullable) |
| no_kk | VARCHAR(191) | Nomor KK (Nullable) |
| no_ktp | VARCHAR(191) | Nomor KTP (Nullable) |
| data_tidak_baik | BOOLEAN | Status data tidak baik (Default: 0) |
| is_active | BOOLEAN | Status aktif (Default: 1) |
| created_at | DATETIME(3) | Tanggal dibuat (Default: CURRENT_TIMESTAMP) |
| updated_at | DATETIME(3) | Tanggal diupdate (Default: CURRENT_TIMESTAMP) |
| dataDomisiliId | VARCHAR(191) | Foreign Key ke DataDomisili (Nullable) |
| dataPasanganId | VARCHAR(191) | Foreign Key ke DataPasangan (Nullable) |
| tunjanganPotonganId | VARCHAR(191) | Foreign Key ke TunjanganPotongan (Nullable) |

**Foreign Keys**:
- dataDomisiliId → DataDomisili(id) ON DELETE SET NULL ON UPDATE CASCADE
- dataPasanganId → DataPasangan(id) ON DELETE SET NULL ON UPDATE CASCADE
- tunjanganPotonganId → TunjanganPotongan(id) ON DELETE SET NULL ON UPDATE CASCADE

---

### 15. Flagging
**Deskripsi**: Menyimpan data flagging untuk pembiayaan.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | VARCHAR(191) | Primary Key |
| data_pengajuan_id | VARCHAR(191) | Foreign Key ke DataPengajuan |
| tanggal | DATETIME(3) | Tanggal flagging |
| keterangan | TEXT | Keterangan flagging (Nullable) |
| status | ENUM | Status flagging |

**Enum Values**:
- status: 'SELESAI', 'PROSESS', 'GAGAL'

**Foreign Keys**:
- data_pengajuan_id → DataPengajuan(id) ON DELETE RESTRICT ON UPDATE CASCADE

---

### 16. Gaji
**Deskripsi**: Menyimpan data gaji pegawai.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | VARCHAR(191) | Primary Key |
| userId | VARCHAR(191) | Foreign Key ke User |
| gaji_pokok | DOUBLE | Gaji pokok |
| tunjangan | DOUBLE | Tunjangan (Nullable) |
| potongan | DOUBLE | Potongan (Nullable) |
| total_gaji | DOUBLE | Total gaji |
| bulan | INT | Bulan gaji |
| tahun | INT | Tahun gaji |
| tanggal_bayar | DATETIME(3) | Tanggal pembayaran (Nullable) |
| keterangan | VARCHAR(191) | Keterangan (Nullable) |
| created_at | DATETIME(3) | Tanggal dibuat (Default: CURRENT_TIMESTAMP) |

**Foreign Keys**:
- userId → User(id) ON DELETE RESTRICT ON UPDATE CASCADE

---

### 17. Income
**Deskripsi**: Menyimpan data pemasukan.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | VARCHAR(191) | Primary Key |
| nominal | DOUBLE | Nominal pemasukan |
| keterangan | VARCHAR(191) | Keterangan pemasukan |
| tanggal | DATETIME(3) | Tanggal pemasukan |
| is_active | BOOLEAN | Status aktif (Default: 1) |
| created_at | DATETIME(3) | Tanggal dibuat (Default: CURRENT_TIMESTAMP) |
| updated_at | DATETIME(3) | Tanggal diupdate (Nullable) |

---

### 18. Inventaris
**Deskripsi**: Menyimpan data inventaris kantor.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | VARCHAR(191) | Primary Key |
| kode | VARCHAR(191) | Kode inventaris (Nullable) |
| nama | VARCHAR(191) | Nama barang |
| jumlah | INT | Jumlah barang |
| harga | DOUBLE | Harga satuan |
| tanggal_pembelian | DATETIME(3) | Tanggal pembelian |

---

### 19. JadwalAngsuran
**Deskripsi**: Menyimpan jadwal angsuran pembiayaan.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | VARCHAR(191) | Primary Key |
| angsuran_ke | INT | Angsuran ke- |
| angsuran | INT | Nominal angsuran |
| pokok | INT | Pokok angsuran |
| margin | INT | Margin angsuran |
| margin_bank | INT | Margin bank |
| collfee | INT | Collection fee |
| status | BOOLEAN | Status bayar (Default: 0) |
| tanggal_bayar | DATETIME(3) | Tanggal pembayaran (Nullable) |
| tanggal_pelunasan | DATETIME(3) | Tanggal pelunasan (Nullable) |
| sisa | INT | Sisa pokok |
| dataPengajuanId | VARCHAR(191) | Foreign Key ke DataPengajuan |

**Foreign Keys**:
- dataPengajuanId → DataPengajuan(id) ON DELETE RESTRICT ON UPDATE CASCADE

---

### 20. JenisPembiayaan
**Deskripsi**: Menyimpan jenis-jenis pembiayaan yang tersedia.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | VARCHAR(191) | Primary Key |
| name | VARCHAR(191) | Nama jenis pembiayaan (Unique) |
| by_mutasi | INT | Biaya mutasi |
| is_active | BOOLEAN | Status aktif (Default: 1) |
| created_at | DATETIME(3) | Tanggal dibuat (Default: CURRENT_TIMESTAMP) |

---

### 21. Maintenance
**Deskripsi**: Menyimpan status maintenance sistem.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | VARCHAR(191) | Primary Key |
| is_maintenance | BOOLEAN | Status maintenance |
| route | VARCHAR(191) | Route yang maintenance |
| timeInMinutes | VARCHAR(191) | Waktu dalam menit |
| currentTime | VARCHAR(191) | Waktu saat ini |

---

### 22. MemoInternal
**Deskripsi**: Menyimpan memo internal kantor.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | VARCHAR(191) | Primary Key |
| title | VARCHAR(191) | Judul memo |
| description | TEXT | Isi memo |

---

### 23. OutcomeCategory
**Deskripsi**: Kategori untuk pengeluaran.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | VARCHAR(191) | Primary Key |
| name | VARCHAR(191) | Nama kategori (Unique) |
| description | VARCHAR(191) | Deskripsi kategori (Nullable) |
| is_active | BOOLEAN | Status aktif (Default: 1) |

---

### 24. PelunasanDebitur
**Deskripsi**: Menyimpan data pelunasan debitur.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | VARCHAR(191) | Primary Key |
| type | ENUM | Tipe pelunasan |
| by_admin | INT | Biaya admin |
| sisa_pokok | INT | Sisa pokok |
| no_rekening | VARCHAR(191) | Nomor rekening |
| nama_bank | VARCHAR(191) | Nama bank |
| keterangan | VARCHAR(191) | Keterangan |
| tanggal_pelunasan | DATETIME(3) | Tanggal pelunasan |
| berkas_pelunasan | VARCHAR(191) | Berkas pelunasan |
| dataPengajuanId | VARCHAR(191) | Foreign Key ke DataPengajuan |

**Enum Values**:
- type: 'TOPUP', 'MENINGGAL_DUNIA', 'LEPAS'

**Foreign Keys**:
- dataPengajuanId → DataPengajuan(id) ON DELETE RESTRICT ON UPDATE CASCADE

---

### 25. PenyerahanBerkas
**Deskripsi**: Menyimpan data penyerahan berkas.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | VARCHAR(191) | Primary Key |
| tanggal_penyerahan | DATETIME(3) | Tanggal penyerahan |
| penerima | VARCHAR(191) | Nama penerima |
| keterangan | TEXT | Keterangan (Nullable) |
| berkas | VARCHAR(191) | File berkas (Nullable) |

---

### 26. PenyerahanJaminan
**Deskripsi**: Menyimpan data penyerahan jaminan.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | VARCHAR(191) | Primary Key |
| tanggal_penyerahan | DATETIME(3) | Tanggal penyerahan |
| penerima | VARCHAR(191) | Nama penerima |
| jenis_jaminan | VARCHAR(191) | Jenis jaminan |
| keterangan | TEXT | Keterangan (Nullable) |
| berkas | VARCHAR(191) | File berkas (Nullable) |

---

### 27. TunjanganPotongan
**Deskripsi**: Menyimpan data tunjangan dan potongan.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | VARCHAR(191) | Primary Key |
| t_anak | VARCHAR(191) | Tunjangan anak (Nullable) |
| t_istri | VARCHAR(191) | Tunjangan istri (Nullable) |
| t_beras | VARCHAR(191) | Tunjangan beras (Nullable) |
| t_cacat | VARCHAR(191) | Tunjangan cacat (Nullable) |
| t_dahor | VARCHAR(191) | Tunjangan dahor (Nullable) |
| pot_alimentasi | VARCHAR(191) | Potongan alimentasi (Nullable) |
| pot_askes | VARCHAR(191) | Potongan askes (Nullable) |
| pot_assos | VARCHAR(191) | Potongan assos (Nullable) |
| pot_ganti_rugi | VARCHAR(191) | Potongan ganti rugi (Nullable) |
| pot_kasda | VARCHAR(191) | Potongan kasda (Nullable) |
| pot_kpkn | VARCHAR(191) | Potongan KPKN (Nullable) |
| pot_pph21 | VARCHAR(191) | Potongan PPh21 (Nullable) |
| pot_sewa_rumah | VARCHAR(191) | Potongan sewa rumah (Nullable) |
| kpkn | VARCHAR(191) | KPKN (Nullable) |
| spn | VARCHAR(191) | SPN (Nullable) |

---

### 28. UnitCabang
**Deskripsi**: Menyimpan data unit cabang.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | VARCHAR(191) | Primary Key |
| name | VARCHAR(191) | Nama cabang (Unique) |
| kode_area | VARCHAR(191) | Kode area (Unique) |
| number_code | VARCHAR(191) | Kode nomor (Nullable) |
| alamat_cabang | VARCHAR(191) | Alamat cabang (Nullable) |
| created_at | DATETIME(3) | Tanggal dibuat (Default: CURRENT_TIMESTAMP) |
| is_active | BOOLEAN | Status aktif (Default: 1) |
| unit_pelayanan_id | VARCHAR(191) | Foreign Key ke UnitPelayanan (Nullable) |

**Foreign Keys**:
- unit_pelayanan_id → UnitPelayanan(id) ON DELETE SET NULL ON UPDATE CASCADE

---

### 29. UnitPelayanan
**Deskripsi**: Menyimpan data unit pelayanan.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | VARCHAR(191) | Primary Key |
| name | VARCHAR(191) | Nama unit pelayanan (Unique) |
| kode_area | VARCHAR(191) | Kode area (Unique) |
| number_kode | VARCHAR(191) | Kode nomor (Nullable) |
| created_at | DATETIME(3) | Tanggal dibuat (Default: CURRENT_TIMESTAMP) |
| is_active | BOOLEAN | Status aktif (Default: 1) |

---

### 30. User
**Deskripsi**: Menyimpan data pengguna/pegawai sistem.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id | VARCHAR(191) | Primary Key |
| nip | VARCHAR(191) | NIP (Unique, Nullable) |
| nik | VARCHAR(191) | NIK (Unique, Nullable) |
| first_name | VARCHAR(191) | Nama depan |
| last_name | VARCHAR(191) | Nama belakang |
| username | VARCHAR(191) | Username (Unique) |
| email | VARCHAR(191) | Email (Unique) |
| tempat_lahir | VARCHAR(191) | Tempat lahir (Nullable) |
| tanggal_lahir | DATETIME(3) | Tanggal lahir (Nullable) |
| alamat | VARCHAR(191) | Alamat (Nullable) |
| no_telepon | VARCHAR(191) | Nomor telepon |
| password | VARCHAR(191) | Password (hashed) |
| role | ENUM | Role pengguna |
| posisi | VARCHAR(191) | Posisi/jabatan (Nullable) |
| status_pkwt | VARCHAR(191) | Status PKWT (Nullable) |
| status_active | BOOLEAN | Status aktif |
| picture | VARCHAR(191) | Foto profil (Default: /profile/profile_default.svg) |
| mulai_kontrak | DATETIME(3) | Mulai kontrak (Default: CURRENT_TIMESTAMP) |
| masa_kotrak | INT | Masa kontrak dalam bulan (Default: 3) |
| created_at | DATETIME(3) | Tanggal dibuat (Default: CURRENT_TIMESTAMP) |
| target | INT | Target penjualan (Default: 50000000) |
| buka_tabungan | DOUBLE | Buka tabungan (Nullable) |
| bulan_masuk | INT | Bulan masuk (Nullable) |
| is_anggota | BOOLEAN | Status anggota (Default: 0) |
| simpanan_bulanan | DOUBLE | Simpanan bulanan (Nullable) |
| unit_cabang_id | VARCHAR(191) | Foreign Key ke UnitCabang (Nullable) |
| bank_id | VARCHAR(191) | Foreign Key ke Bank (Nullable) |

**Enum Values**:
- role: 'MASTER', 'ENTRY_DATA', 'BANK', 'VERIFIKASI', 'CHECKER', 'MAKER', 'APPROVAL', 'MARKETING', 'OPERASIONAL', 'BISNIS', 'PEMBERKASAN', 'KEUANGAN', 'MANAGEMENT', 'AUDIT'

**Foreign Keys**:
- unit_cabang_id → UnitCabang(id) ON DELETE SET NULL ON UPDATE CASCADE
- bank_id → Bank(id) ON DELETE SET NULL ON UPDATE CASCADE

---

## Relasi Antar Tabel

### Relasi Utama

1. **User → UnitCabang → UnitPelayanan**
   - User berada di suatu cabang (UnitCabang)
   - Setiap cabang tergabung dalam unit pelayanan tertentu

2. **DataPengajuan (Tabel Sentral)**
   - Terhubung ke DataPembiayaan (detail pembiayaan)
   - Terhubung ke User (marketing yang handle)
   - Terhubung ke Bank (bank mitra)
   - Terhubung ke BerkasPengajuan (dokumen-dokumen)
   - Terhubung ke DataTaspen (data dari Taspen)
   - Terhubung ke DataPencairan (detail pencairan)
   - Terhubung ke DataPengajuanKeluarga (data keluarga)
   - Terhubung ke DataPengajuanAlamat (data alamat)
   - Terhubung ke PenyerahanBerkas (penyerahan berkas)
   - Terhubung ke PenyerahanJaminan (penyerahan jaminan)

3. **DataTaspen**
   - Terhubung ke DataDomisili (alamat)
   - Terhubung ke DataPasangan (data pasangan)
   - Terhubung ke TunjanganPotongan (tunjangan dan potongan)

4. **JadwalAngsuran → DataPengajuan**
   - Setiap pengajuan memiliki banyak jadwal angsuran

5. **Blog → BlogCategory**
   - Setiap artikel tergabung dalam suatu kategori

---

## Flow Proses Bisnis

### Alur Pengajuan Pembiayaan

1. **Pengajuan**
   - Data dibuat di tabel `DataPengajuan`
   - Status: `status_pengajuan` = 'ANTRI'

2. **Verifikasi**
   - Petugas verifikasi memeriksa
   - Status: `status_verifikasi` = 'SETUJU'/'DITOLAK'/'PENDING'

3. **Checker**
   - Checker melakukan pemeriksaan
   - Status: `status_checker` = 'SETUJU'/'DITOLAK'/'PENDING'

4. **Maker**
   - Maker memproses lebih lanjut
   - Status: `status_maker` = 'SETUJU'/'DITOLAK'/'PENDING'

5. **Approval**
   - Approval melakukan persetujuan final
   - Status: `status_approval` = 'SETUJU'/'DITOLAK'/'PENDING'

6. **Pencairan**
   - Dana dicairkan
   - Status: `status_pencairan` = 'TRANSFER'/'PROSES'/'BATAL'
   - Data pencairan disimpan di `DataPencairan`

7. **Angsuran**
   - Jadwal angsuran dibuat di `JadwalAngsuran`
   - Setiap bulan status angsuran diupdate

8. **Pelunasan**
   - Data pelunasan disimpan di `PelunasanDebitur`
   - `status_lunas` diupdate menjadi `true`

---

## Catatan Penting

1. **Semua tabel menggunakan VARCHAR(191) untuk ID** - menggunakan UUID sebagai primary key

2. **Timestamps**:
   - `created_at` menggunakan DATETIME(3) dengan default CURRENT_TIMESTAMP(3)
   - Presisi hingga millisecond

3. **Soft Delete**:
   - Banyak tabel menggunakan `is_active` untuk soft delete
   - Data tidak benar-benar dihapus, hanya statusnya yang diubah

4. **Status Tracking**:
   - Sistem tracking lengkap untuk setiap tahap approval
   - Menyimpan nama pemeriksa, tanggal, dan keterangan

5. **Foreign Key Constraints**:
   - Sebagian besar menggunakan `ON DELETE SET NULL` atau `ON DELETE RESTRICT`
   - Memastikan integritas referensial data

6. **Character Set**: utf8mb4 untuk mendukung emoji dan karakter Unicode penuh

---

## Indeks dan Optimasi

- Semua primary key otomatis terindeks
- Unique constraints pada kolom-kolom seperti `username`, `email`, `nip`, `nik`
- Foreign key juga otomatis terindeks oleh MySQL InnoDB

---

**Dibuat dari**: Dump20260120.sql  
**Engine**: InnoDB  
**Versi MySQL**: 8.0.44