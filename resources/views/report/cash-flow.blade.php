@extends('layouts.template')
@section('title','Laporan')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Arus Kas</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Laporan</li>
                    <li class="breadcrumb-item active">Arus Kas</li>
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <input type="hidden" class="form-control float-right" id="start_date">
                <input type="hidden" class="form-control float-right" id="end_date">
                <table id="dataTable" class="table table-bordered table-striped table-hover" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Area Pelayanan</th>
                            <th class="text-center">Unit Pelayanan</th>
                            <th class="text-center">MOC & Admin</th>
                            <th class="text-center">NOPEN</th>
                            <th class="text-center">No SK Pensiun</th>
                            <th class="text-center">Nama Pemohon</th>
                            <th class="text-center">Mitra Bank</th>
                            <th class="text-center">Sumber Dana</th>
                            <th class="text-center">Tenor</th>
                            <th class="text-center">Plafond</th>
                            <th class="text-center">Produk Pembiayaan</th>
                            <th class="text-center">Jenis Pembiayaan</th>
                            <th class="text-center">Tanggal Pengajuan</th>
                            <th class="text-center">Tanggal Akad</th>
                            <th class="text-center">Tanggal Cair</th>
                            <th class="text-center">Tanggal Lunas</th>
                            <th class="text-center">Margin (%)</th>
                            <th class="text-center">Admin Bank</th>
                            <th class="text-center">Admin Mitra</th>
                            <th class="text-center">Pencadangan Pusat</th>
                            <th class="text-center">Tatalaksana</th>
                            <th class="text-center">Status Deviasi</th>
                            <th class="text-center">Keterangan Deviasi</th>
                            <th class="text-center">Asuransi (%)</th>
                            <th class="text-center">Premi Asuransi</th>
                            <th class="text-center">Selisih Asuransi</th>
                            <th class="text-center">Data Informasi</th>
                            <th class="text-center">Pembukaan Tabungan</th>
                            <th class="text-center">Biaya Materai</th>
                            <th class="text-center">Biaya Mutasi</th>
                            <th class="text-center">Biaya Provisi</th>
                            <th class="text-center">Angsuran Perbulan</th>
                            <th class="text-center">Angsuran Bank</th>
                            <th class="text-center">Angsuran KPF</th>
                            <th class="text-center">Blokir Angsuran</th>
                            <th class="text-center">Nominal Take Over</th>
                            <th class="text-center">Pencairan</th>
                            <th class="text-center">Dropping</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
@endsection
@push('script')
    <script>
        var createAccess={!!check_access('laporan','create')!!}
        var banks = @json($banks);
        $(function () {
            getData()

            let bankOption = '';
            bankOption+=`<option value="">Semua</option>`
            $.each(banks, function(key, value) {
                bankOption+=`<option value="${value.id}">${value.name}</option>`
            });

            var buttonCreate = ''
            if(createAccess==1){
                buttonCreate = `<label><button type="button" class="btn btn-success btn-sm btn-print"><i class='fa fa-print'></i>&nbsp;Print</button></label>`
            }
            $('#dataTable_length').append(`
                <label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                        </div>
                        <input type="text" class="custom-select custom-select-sm form-control form-control-sm float-right" id="daterange" aria-controls="dataTable">
                    </div>
                </label>
                <label>
                    <select class="custom-select custom-select-sm form-control form-control-sm" id="status" placeholder="Status" aria-controls="dataTable">
                        <option value="" selected>Semua</option>
                        <option value="queue">Antri</option>
                        <option value="pending">Pending</option>
                        <option value="on process">Diproses</option>
                        <option value="approve">Disetujui</option>
                    </select>
                </label>
                <label>
                    <select class="custom-select custom-select-sm form-control form-control-sm" id="bank" placeholder="Group" aria-controls="dataTable">
                        ${bankOption}
                    </select>
                </label>
                ${buttonCreate}
            `)
            $('#dataTable_length').parent().removeClass('col-md-6').addClass('col-md-8')
            $('#dataTable_filter').parent().removeClass('col-md-6').addClass('col-md-4')
            $('#daterange').daterangepicker({
                autoApply:true
            })
            $('#daterange').on('apply.daterangepicker', function(ev, e) {
                var startDate = e.startDate.format('YYYY-MM-DD')
                var endDate = e.endDate.format('YYYY-MM-DD')
                $('#start_date').val(startDate)
                $('#end_date').val(endDate)
                reloadDataTable()
            });

            $('#bank').change(function() {
                reloadDataTable()
            });
            $('#status').change(function() {
                reloadDataTable()
            });
            $('#group').change(function() {
                reloadDataTable()
            });
        })


        $(document).on('click', '.btn-print', function(event) {
            var startDate = $('#start_date').val() || ''
            var endDate = $('#end_date').val() || ''
            var status = $('#status').val() || ''
            var group = $('#group').val() || ''
            var bank = $('#bank').val() || ''
            var params = {
                _token: "{{ csrf_token() }}",
                start_date: startDate,
                end_date: endDate,
                status: status,
                bank: bank
            }
            $.ajax({
                url: "{{ route('report.generate-report-cash-flow') }}",
                type: "post",
                data: params,
                xhrFields: {responseType: "blob"},
                success: function (data) {
                    var blob = new Blob([data], {type: "application/octet-stream"});
                    const downloadUrl = URL.createObjectURL(blob);
                    const a = document.createElement("a");
                    a.href = downloadUrl;
                    a.download = "report.xlsx";
                    document.body.appendChild(a);
                    a.click();
                }
            });
        });


        function getData(){
            var employeeDT = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                filter: true,
                fixedColumns: {
                    leftColumns: 7
                },
                scrollCollapse: true,
                scrollX: true,
                ajax: {
                    url: "{!! route('report.cash-flow-datatable') !!}",
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"}
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                    { data: 'area_pelayanan', name: 'area_pelayanan', searchable: false, orderable: false },
                    { data: 'unit_pelayanan', name: 'unit_pelayanan', searchable: false, orderable: false },
                    { data: 'moc_admin', name: 'moc_admin', searchable: false, orderable: false },
                    { data: 'nopen', name: 'nopen', searchable: false, orderable: false },
                    { data: 'no_sk_pensiun', name: 'no_sk_pensiun', searchable: false, orderable: false },
                    { data: 'nama_pemohon', name: 'nama_pemohon', searchable: true, orderable: true },
                    { data: 'mitra_bank', name: 'mitra_bank', searchable: false, orderable: false },
                    { data: 'sumber_dana', name: 'sumber_dana', searchable: false, orderable: false },
                    { data: 'tenor', name: 'tenor', searchable: false, orderable: true },
                    { data: 'plafond', name: 'plafond', searchable: false, orderable: true },
                    { data: 'produk_pembiayaan', name: 'produk_pembiayaan', searchable: false, orderable: false },
                    { data: 'jenis_pembiayaan', name: 'jenis_pembiayaan', searchable: false, orderable: false },
                    { data: 'tanggal_pengajuan', name: 'tanggal_pengajuan', searchable: false, orderable: true },
                    { data: 'tanggal_akad', name: 'tanggal_akad', searchable: false, orderable: true },
                    { data: 'tanggal_cair', name: 'tanggal_cair', searchable: false, orderable: true },
                    { data: 'tanggal_lunas', name: 'tanggal_lunas', searchable: false, orderable: true },
                    { data: 'margin', name: 'margin', searchable: false, orderable: true },
                    { data: 'admin_bank', name: 'admin_bank', searchable: false, orderable: false },
                    { data: 'admin_mitra', name: 'admin_mitra', searchable: false, orderable: false },
                    { data: 'pencadangan_pusat', name: 'pencadangan_pusat', searchable: false, orderable: false },
                    { data: 'tatalaksana', name: 'tatalaksana', searchable: false, orderable: false },
                    { data: 'status_deviasi', name: 'status_deviasi', searchable: false, orderable: false },
                    { data: 'keterangan_deviasi', name: 'keterangan_deviasi', searchable: false, orderable: false },
                    { data: 'asuransi', name: 'asuransi', searchable: false, orderable: false },
                    { data: 'premi_asuransi', name: 'premi_asuransi', searchable: false, orderable: false },
                    { data: 'selisih_asuransi', name: 'selisih_asuransi', searchable: false, orderable: false },
                    { data: 'data_informasi', name: 'data_informasi', searchable: false, orderable: false },
                    { data: 'pembukaan_tabungan', name: 'pembukaan_tabungan', searchable: false, orderable: false },
                    { data: 'biaya_materai', name: 'biaya_materai', searchable: false, orderable: false },
                    { data: 'biaya_mutasi', name: 'biaya_mutasi', searchable: false, orderable: false },
                    { data: 'biaya_provisi', name: 'biaya_provisi', searchable: false, orderable: false },
                    { data: 'angsuran_perbulan', name: 'angsuran_perbulan', searchable: false, orderable: true },
                    { data: 'angsuran_bank', name: 'angsuran_bank', searchable: false, orderable: false },
                    { data: 'angsuran_kpf', name: 'angsuran_kpf', searchable: false, orderable: false },
                    { data: 'blokir_angsuran', name: 'blokir_angsuran', searchable: false, orderable: false },
                    { data: 'nominal_take_over', name: 'nominal_take_over', searchable: false, orderable: false },
                    { data: 'pencairan', name: 'pencairan', searchable: false, orderable: false },
                    { data: 'dropping', name: 'dropping', searchable: false, orderable: false }
                ]
            });
        }

        function reloadDataTable(){
            var startDate = $('#start_date').val() || ''
            var endDate = $('#end_date').val() || ''
            var status = $('#status').val() || ''
            var group = $('#group').val() || ''
            var bank = $('#bank').val() || ''
            var params = new URLSearchParams({
                'start_date': startDate,
                'end_date': endDate,
                'status': status,
                'group': group,
                'bank': bank
            });
            $('#dataTable').DataTable().ajax.url("{!! route('report.cash-flow-datatable') !!}?"+params.toString()).load();
        }

        $('#modalViewFile').on('show.bs.modal', function (event) {
            var data = $(event.relatedTarget).data()
            var modal = $(this)
            modal.find('.modal-title').text(data.title)
            var modalContent = `<iframe
                            src="${data.url}"
                            frameBorder="0"
                            scrolling="auto"
                            height="600px"
                            width="100%"
                        ></iframe>`
            if(data.type){
                if(data.type=='video'){
                    modalContent = `<video src="${data.url}" height="auto" width="100%" controls></video>`
                }else if(data.type=='img'){
                    modalContent = `<img src="${data.url}" class="img img-responsive" />`
                }

            }
            modal.find('.modal-body').html(modalContent)
        })
    </script>
@endpush
