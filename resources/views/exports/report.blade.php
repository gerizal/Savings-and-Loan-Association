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
        <th class="text-center" width="20">Tanggal Pengajuan</th>
        <th class="text-center" width="15">Area Pelayanan</th>
        <th class="text-center" width="15">Unit Pelayanan</th>
        <th class="text-center" width="15">No Pensiun</th>
        <th class="text-center" width="15">No SK Pensiun</th>
        <th class="text-center" width="20">Nama Pemohon</th>
        <th class="text-center" width="20">Sumber Dana</th>
        <th class="text-center" width="20">Produk Pembiayaan</th>
        <th class="text-center" width="20">Jenis Pembiayaan</th>
        <th class="text-center" width="10">Tenor</th>
        <th class="text-center" width="20">Plafon</th>
        <th class="text-center" width="20">Tanggal Akad</th>
        <th class="text-center" width="20">Tanggal Cair</th>
        <th class="text-center" width="20">Tanggal Lunas</th>
        <th class="text-center" width="20">Margin</th>
        <th class="text-center" width="20">Admin Bank</th>
        <th class="text-center" width="20">Admin Mitra</th>
        <th class="text-center" width="20">Angsuran</th>
        <th class="text-center" width="20">Pencairan</th>
    </tr>
    </thead>
    <tbody>
        @foreach($data as $key => $_data)
        <tr>
            <td>{{ $key+1}}</td>
            <td>{{ $_data->date}}</td>
            <td>{{ $_data->area_name}}</td>
            <td>{{ $_data->branch_name}}</td>
            <td>{{ $_data->nopen}}</td>
            <td>{{ $_data->skep_number}}</td>
            <td>{{ $_data->debitur}}</td>
            <td>{{ $_data->bank_name}}</td>
            <td>{{ $_data->product_name}}</td>
            <td>{{ $_data->finance_type}}</td>
            <td>{{ $_data->tenor}}</td>
            <td>{{ formatIDR($_data->plafond)}}</td>
            <td>{{ $_data->contract_date}}</td>
            <td>{{ $_data->reception_date}}</td>
            <td>{{ $_data->settlement_date}}</td>
            <td>{{ formatIDR($_data->margin)}}</td>
            <td>{{ formatIDR($_data->bank_installment)}}</td>
            <td>{{ formatIDR($_data->col_fee)}}</td>
            <td>{{ formatIDR($_data->installment)}}</td>
            <td>{{ formatIDR($_data->net_amount)}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
