@extends('layouts.template')
@section('title','Laporan')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Laporan Bulanan</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Laporan</li>
                    <li class="breadcrumb-item active">Laporan Bulanan</li>
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
                            <th class="text-center">Area</th>
                            <th class="text-center">Unit Pelayanan</th>
                            <th class="text-center">Nama Pemohon</th>
                            <th class="text-center">Tanggal Pencairan</th>
                            <th class="text-center">Produk</th>
                            <th class="text-center">Jenis</th>
                            <th class="text-center">Sumber Dana</th>
                            <th class="text-center">Tenor</th>
                            <th class="text-center">Plafond</th>
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
                url: "{{ route('report.generate-report') }}",
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
                    url: "{!! route('report.monthly-datatable') !!}",
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"}
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                    { data: 'area', name: 'area', searchable: true, orderable: true },
                    { data: 'unit_pelayanan', name: 'unit_pelayanan', searchable: true, orderable: true },
                    { data: 'nama_pemohon', name: 'nama_pemohon', searchable: true, orderable: true },
                    { data: 'tanggal_pencairan', name: 'tanggal_pencairan', searchable: false, orderable: true },
                    { data: 'produk', name: 'produk', searchable: true, orderable: false },
                    { data: 'jenis', name: 'jenis', searchable: false, orderable: false },
                    { data: 'sumber_dana', name: 'sumber_dana', searchable: false, orderable: false },
                    { data: 'tenor', name: 'tenor', searchable: false, orderable: true },
                    { data: 'plafond', name: 'plafond', searchable: false, orderable: true }
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
            $('#dataTable').DataTable().ajax.url("{!! route('report.monthly-datatable') !!}?"+params.toString()).load();
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
