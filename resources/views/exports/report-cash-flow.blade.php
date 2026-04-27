<style>
    .text-right {
                text-align: right !important;
    }

    .text-center {
        text-align: center !important;
    }

    .text-left {
        text-align: left !important;
    }

    .text-justify {
        text-align: justify;
    }
</style>
<table>
    <thead>
    <tr style="text-align: center">
        <th class="text-center" width="3">No</th>
        <th class="text-center" width="20">Area Pelayanan</th>
        <th class="text-center" width="20">Unit Pelayanan</th>
        <th class="text-center" width="20">MOC &amp; Admin</th>
        <th class="text-center" width="20">NOPEN</th>
        <th class="text-center" width="20">No SK Pensiun</th>
        <th class="text-center" width="20">Nama Pemohon</th>
        <th class="text-center" width="20">Mitra Bank</th>
        <th class="text-center" width="20">Sumber Dana</th>
        <th class="text-center" width="20">Tenor</th>
        <th class="text-center" width="20">Plafond</th>
        <th class="text-center" width="20">Produk Pembiayaan</th>
        <th class="text-center" width="20">Jenis Pembiayaan</th>
        <th class="text-center" width="20">Tanggal Pengajuan</th>
        <th class="text-center" width="20">Tanggal Akad</th>
        <th class="text-center" width="20">Tanggal Cair</th>
        <th class="text-center" width="20">Tanggal Lunas</th>
        <th class="text-center" width="20">Margin (%)</th>
        <th class="text-center" width="20">Admin Bank</th>
        <th class="text-center" width="20">Admin Mitra</th>
        <th class="text-center" width="20">Pencadangan Pusat</th>
        <th class="text-center" width="20">Tatalaksana</th>
        <th class="text-center" width="20">Status Deviasi</th>
        <th class="text-center" width="20">Keterangan Deviasi</th>
        <th class="text-center" width="20">Asuransi (%)</th>
        <th class="text-center" width="20">Premi Asuransi</th>
        <th class="text-center" width="20">Selisih Asuransi</th>
        <th class="text-center" width="20">Data Informasi</th>
        <th class="text-center" width="20">Pembukaan Tabungan</th>
        <th class="text-center" width="20">Biaya Materai</th>
        <th class="text-center" width="20">Biaya Mutasi</th>
        <th class="text-center" width="20">Biaya Provisi</th>
        <th class="text-center" width="20">Angsuran Perbulan</th>
        <th class="text-center" width="20">Angsuran Bank</th>
        <th class="text-center" width="20">Angsuran KPF</th>
        <th class="text-center" width="20">Blokir Angsuran</th>
        <th class="text-center" width="20">Nominal Take Over</th>
        <th class="text-center" width="20">Pencairan</th>
        <th class="text-center" width="20">Dropping</th>
    </tr>
    </thead>
    <tbody>
        @foreach($data as $key => $_data)
        <tr>
            <td>{{ $key+1}}</td>
            <td>{{ $_data->area_pelayanan}}</td>
            <td>{{ $_data->unit_pelayanan}}</td>
            <td>{{ $_data->moc_admin}}</td>
            <td>'{{ $_data->nopen}}</td>
            <td>{{ $_data->no_sk_pensiun}}</td>
            <td>{{ $_data->nama_pemohon}}</td>
            <td>{{ $_data->mitra_bank}}</td>
            <td>{{ $_data->sumber_dana}}</td>
            <td>{{ $_data->tenor}}</td>
            <td>{{ formatIDR($_data->plafond)}}</td>
            <td>{{ $_data->produk_pembiayaan}}</td>
            <td>{{ $_data->jenis_pembiayaan}}</td>
            <td>{{ $_data->tanggal_pengajuan}}</td>
            <td>{{ $_data->tanggal_akad}}</td>
            <td>{{ $_data->tanggal_cair}}</td>
            <td>{{ $_data->tanggal_lunas}}</td>
            <td>{{ $_data->margin}}</td>
            <td>{{ formatIDR($_data->admin_bank)}}</td>
            <td>{{ formatIDR($_data->admin_mitra)}}</td>
            <td>{{ formatIDR($_data->pencadangan_pusat)}}</td>
            <td>{{ formatIDR($_data->tatalaksana)}}</td>
            <td>{{ $_data->status_deviasi}}</td>
            <td>{{ $_data->keterangan_deviasi}}</td>
            <td>{{ $_data->asuransi}}</td>
            <td>{{ formatIDR($_data->premi_asuransi)}}</td>
            <td>{{ formatIDR($_data->selisih_asuransi)}}</td>
            <td>{{ $_data->data_informasi}}</td>
            <td>{{ formatIDR($_data->pembukaan_tabungan)}}</td>
            <td>{{ formatIDR($_data->biaya_materai)}}</td>
            <td>{{ formatIDR($_data->biaya_mutasi)}}</td>
            <td>{{ formatIDR($_data->biaya_provisi)}}</td>
            <td>{{ formatIDR($_data->angsuran_perbulan)}}</td>
            <td>{{ formatIDR($_data->angsuran_bank)}}</td>
            <td>{{ formatIDR($_data->angsuran_kpf)}}</td>
            <td>{{ formatIDR($_data->blokir_angsuran)}}</td>
            <td>{{ formatIDR($_data->nominal_take_over)}}</td>
            <td>{{ formatIDR($_data->pencairan)}}</td>
            <td>{{ formatIDR($_data->dropping)}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
