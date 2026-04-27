@extends('layouts.template')
@section('title','BERKAS PEMBIAYAAN')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">BERKAS PEMBIAYAAN</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Pemberkasan</li>
                    <li class="breadcrumb-item active">BERKAS PEMBIAYAAN</li>
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
                            <th rowspan="2">No</th>
                            <th rowspan="2">Area Pelayanan</th>
                            <th rowspan="2">Tanggal Pencairan</th>
                            <th rowspan="2">No Pensiun</th>
                            <th rowspan="2">Nama Pemohon</th>
                            <th rowspan="2">Sumber Dana</th>
                            <th rowspan="2">Nomor Akad</th>
                            <th rowspan="2">Tenor</th>
                            <th rowspan="2">Plafond</th>
                            <th rowspan="2">Produk Pembiayaan</th>
                            <th rowspan="2">Jenis Pembiayaan</th>
                            <th colspan="7" class="text-center">View Berkas</th>
                            <th rowspan="2" class="text-center">Status Jaminan</th>
                        </tr>
                        <tr>
                            <th class="text-center">Pengajuan</th>
                            <th class="text-center">Akad</th>
                            <th class="text-center">Pelunasan</th>
                            <th class="text-center">Jaminan</th>
                            <th class="text-center">Buku Rekening</th>
                            <th class="text-center">Mutasi</th>
                            <th class="text-center">Flagging</th>
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
        var banks = @json($banks);
        $(function () {
            getData()

            let bankOption = '';
            bankOption+=`<option value="">Semua</option>`
            $.each(banks, function(key, value) {
                bankOption+=`<option value="${value.id}">${value.name}</option>`
            });

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

        $(document).on('click', '.btn-upload-file', function(event) {
            let data = $(this).data();
            Swal.fire({
                title: data.title,
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "<i class='fa fa-upload'></i>&nbsp;Upload",
                cancelButtonText: "<i class='fa fa-times'></i>&nbsp;Batal",
                reverseButtons: true,
                preConfirm: () => {
                    let result ={
                        file:$('#file')[0].files[0],
                        id:data.id
                    }
                    return result
                },
                html:`
                    <div class="form-group required  text-left">
                        <label class="control-label">Upload Berkas SI</label>
                        <input id="file" type="file" class="form-control">
                    </div>
                `
            }).then((result) => {
                if (result.isConfirmed) {
                    uploadFile(data.url, result.value)
                }
            });
        });
        function uploadFile(url, values){
            var formData = new FormData();
            formData.append("file", values.file);
            formData.append("id", values.id);
            $.ajax({
                url: url,
                type: "post",
                headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    reloadDataTable()
                }
            });
        }

        function getData(){
            var employeeDT = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                filter: true,
                fixedColumns: {
                    leftColumns: 4
                },
                scrollCollapse: true,
                scrollX: true,
                ajax: {
                    url: "{!! route('files.application.datatable') !!}",
                    type: 'GET'
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                    { data: 'service_unit_name', name: 'service_unit_name', searchable: false, orderable: false},
                    { data: 'disbursement_date', name: 'disbursement_date', searchable: false, orderable: false},
                    { data: 'nopen', name: 'nopen', searchable: false, orderable: false},
                    { data: 'debitur', name: 'debitur', searchable: false, orderable: false},
                    { data: 'bank_name', name: 'bank_name', searchable: false, orderable: false},
                    { data: 'contract_number', name: 'contract_number', searchable: false, orderable: false},
                    { data: 'tenor', name: 'tenor', searchable: false, orderable: false},
                    { data: 'plafond', name: 'plafond', searchable: false, orderable: false},
                    { data: 'product_name', name: 'product_name', searchable: false, orderable: false},
                    { data: 'finance_type', name: 'finance_type', searchable: false, orderable: false},
                    { data: 'application_file', name: 'application_file', searchable: false, orderable: false},
                    { data: 'contract_file', name: 'contract_file', searchable: false, orderable: false},
                    { data: 'settelment_file', name: 'settelment_file', searchable: false, orderable: false},
                    { data: 'guarantee_file', name: 'guarantee_file', searchable: false, orderable: false},
                    { data: 'account_bank_file', name: 'account_bank_file', searchable: false, orderable: false},
                    { data: 'mutation_file', name: 'mutation_file', searchable: false, orderable: false},
                    { data: 'flagging_file', name: 'flagging_file', searchable: false, orderable: false},
                    { data: 'guarantee_status', name: 'guarantee_status', searchable: false, orderable: false},
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
            $('#dataTable').DataTable().ajax.url("{!! route('files.application.datatable') !!}?"+params.toString()).load();
        }

        function openCloseModalViewFile($params = null, action = 'show'){
            $('#modalViewFile').modal(action)
        }

        $('#modalViewFile').on('show.bs.modal', function (event) {
            $('#btn-submit-files').attr('disabled', false)
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

        $('#modalUploadFiles').on('show.bs.modal', function (event) {
            var data = $(event.relatedTarget).data()
            var modal = $(this)
            modal.find('#application_id').val(data.id)
        })
    </script>
@endpush
