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
        <th class="text-center" width="20">Status Pelunasan</th>
        <th class="text-center" width="20">Area Pelayanan</th>
        <th class="text-center" width="20">NOPEN</th>
        <th class="text-center" width="20">No SK</th>
        <th class="text-center" width="20">Nama Pemohon</th>
        <th class="text-center" width="20">No Akad</th>
        <th class="text-center" width="20">Tanggal Akad</th>
        <th class="text-center" width="20">Berkas Pelunasan</th>
        <th class="text-center" width="20">Tanggal Pelunasan</th>
        <th class="text-center" width="20">Sumber Dana</th>
        <th class="text-center" width="20">Produk Pembiayaan</th>
        <th class="text-center" width="10">Tenor</th>
        <th class="text-center" width="20">Plafon</th>
    </tr>
    </thead>
    <tbody>
        @foreach($data as $key => $_data)
        <tr>
            <td>{{ $key+1}}</td>
            <td>{{ $_data->status_pelunasan}}</td>
            <td>{{ $_data->area_pelayanan}}</td>
            <td>{{ $_data->nopen}}</td>
            <td>{{ $_data->no_sk}}</td>
            <td>{{ $_data->nama_pemohon}}</td>
            <td>{{ $_data->no_akad}}</td>
            <td>{{ $_data->tanggal_akad}}</td>
            <td>{{ $_data->berkas_pelunasan}}</td>
            <td>{{ $_data->tanggal_pelunasan}}</td>
            <td>{{ $_data->sumber_dana}}</td>
            <td>{{ $_data->produk_pembiayaan}}</td>
            <td>{{ $_data->tenor}}</td>
            <td>{{ formatIDR($_data->plafond)}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
