SELECT 
    dp.*, 
    dpb.*, 
    p.*, 
    b.*, 
    jp.*, 
    r.*, 
    u.*, 
    uc.*, 
    up.*, 
    bp.*, 
    ba.*, 
    bps.*, 
    dpas.*, 
    dk.*, 
    dom.*, 
    dpas2.*, 
    tj.*, 
    ja.*
FROM 
    DataPengajuan dp 
JOIN 
    DataPembiayaan dpb ON dp.id = dpb.data_pengajuan_id 
JOIN 
    Produk p ON dpb.produk_id = p.id 
JOIN 
    Bank b ON p.bank_id = b.id 
JOIN 
    JenisPembiayaan jp ON dpb.jenis_pembiayaan_id = jp.id 
JOIN 
    Refferal r ON dpb.refferal_id = r.id 
JOIN 
    User u ON dp.user_id = u.id 
JOIN 
    UnitCabang uc ON u.unit_cabang_id = uc.id 
JOIN 
    UnitPelayanan up ON uc.unit_pelayanan_id = up.id 
LEFT JOIN 
    BerkasPengajuan bp ON dp.id = bp.data_pengajuan_id 
LEFT JOIN 
    DataPengajuanAlamat ba ON dp.id = ba.data_pengajuan_id 
LEFT JOIN 
    DataPengajuanPasangan bps ON dp.id = bps.data_pengajuan_id 
LEFT JOIN 
    DataTaspen dpas ON dp.id = dpas.data_pengajuan_id 
LEFT JOIN 
    DataKeluarga dk ON dpas.data_keluarga_id = dk.id 
LEFT JOIN 
    Domisili dom ON dpas.domisili_id = dom.id 
LEFT JOIN 
    DataPasangan dpas2 ON dpas.data_pasangan_id = dpas2.id 
LEFT JOIN 
    TunjanganPotongan tj ON dpas.tunjangan_potongan_id = tj.id 
LEFT JOIN 
    JadwalAngsuran ja ON dp.id = ja.data_pengajuan_id 
WHERE 
    dp.status_pencairan = 'TRANSFER' 
    AND dp.is_active = true 
    AND dp.status_lunas = false 
    AND (dpb.name LIKE ? OR dpb.nopen LIKE ?)
ORDER BY 
    ja.angsuran_ke ASC;
