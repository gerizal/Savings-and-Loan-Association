SELECT 
    pd.*, 
    dp.*, 
    dpb.*, 
    p.*, 
    b.*, 
    jp.*, 
    r.*, 
    u.*, 
    uc.*, 
    up.*, 
    dt.*, 
    dk.*, 
    dom.*, 
    dpas.*, 
    tj.*, 
    bp.*, 
    ba.*, 
    bps.*, 
    ja.*
FROM 
    pelunasanDebitur pd 
JOIN 
    DataPengajuan dp ON pd.data_pengajuan_id = dp.id 
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
    DataTaspen dt ON dp.id = dt.data_pengajuan_id 
LEFT JOIN 
    DataKeluarga dk ON dt.data_keluarga_id = dk.id 
LEFT JOIN 
    Domisili dom ON dt.domisili_id = dom.id 
LEFT JOIN 
    DataPasangan dpas ON dt.data_pasangan_id = dpas.id 
LEFT JOIN 
    TunjanganPotongan tj ON dt.tunjangan_potongan_id = tj.id 
LEFT JOIN 
    BerkasPengajuan bp ON dp.id = bp.data_pengajuan_id 
LEFT JOIN 
    DataPengajuanAlamat ba ON dp.id = ba.data_pengajuan_id 
LEFT JOIN 
    DataPengajuanPasangan bps ON dp.id = bps.data_pengajuan_id 
LEFT JOIN 
    JadwalAngsuran ja ON dp.id = ja.data_pengajuan_id 
WHERE 
    dp.status_lunas = true 
    AND dp.is_active = true 
    AND pd.tanggal_pelunasan BETWEEN ? AND ? 
ORDER BY 
    pd.tanggal_pelunasan ASC 
LIMIT ? OFFSET ?;
