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
        <th class="text-center" width="20">NOPEN</th>
        <th class="text-center" width="20">Nama Pemohon</th>
        <th class="text-center" width="20">Sumber Dana</th>
        <th class="text-center" width="20">Tanggal Akad</th>
        <th class="text-center" width="20">Tanggal Cair</th>
        <th class="text-center" width="20">Tanggal Lunas</th>
        <th class="text-center" width="20">Produk Pembiayaan</th>
        <th class="text-center" width="20">Jenis Pembiayaan</th>
        <th class="text-center" width="10">Tenor</th>
        <th class="text-center" width="20">Plafon</th>
        <th class="text-center" width="20">Angsuran</th>
        <th class="text-center" width="20">Angsuran Bank</th>
        <th class="text-center" width="20">Pokok</th>
        <th class="text-center" width="20">Angsuran Ke</th>
        <th class="text-center" width="20">Sisa Tenor</th>
        <th class="text-center" width="20">Outstanding</th>
    </tr>
    </thead>
    <tbody>
        @foreach($data as $key => $_data)
        <tr>
            <td>{{ $key+1}}</td>
            <td>{{ $_data->nopen}}</td>
            <td>{{ $_data->nama_pemohon}}</td>
            <td>{{ $_data->sumber_dana}}</td>
            <td>{{ $_data->tanggal_akad}}</td>
            <td>{{ $_data->tanggal_cair}}</td>
            <td>{{ $_data->tanggal_lunas}}</td>
            <td>{{ $_data->produk_pembiayaan}}</td>
            <td>{{ $_data->jenis_pembiayaan}}</td>
            <td>{{ $_data->tenor}}</td>
            <td>{{ formatIDR($_data->plafond)}}</td>
            <td>{{ formatIDR($_data->angsuran)}}</td>
            <td>{{ formatIDR($_data->pokok)}}</td>
            <td>{{ formatIDR($_data->angsuran_ke)}}</td>
            <td>{{ formatIDR($_data->sisa_tenor)}}</td>
            <td>{{ formatIDR($_data->outstanding)}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
