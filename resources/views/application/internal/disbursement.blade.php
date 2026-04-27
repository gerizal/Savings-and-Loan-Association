@extends('layouts.template')
@section('title','Pengajuan Pencairan')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Pengajuan Pencairan</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Pengajuan Internal</li>
                    <li class="breadcrumb-item active">Pengajuan Pencairan</li>
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
@php
$user_role = user_role()
@endphp
<div class="row">
    <div class="col-12">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <input type="hidden" class="form-control float-right" id="start_date">
                <input type="hidden" class="form-control float-right" id="end_date">
                <table id="dataTable" class="table table-bordered table-striped table-hover" width="100%">
                    @if ($user_role->slug=='bank')
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">Tanggal Cetak</th>
                            <th rowspan="2">Nomor Surat</th>
                            <th rowspan="2">Sumber Dana</th>
                            <th rowspan="2">Status</th>
                            <th rowspan="2">Proses Pencairan</th>
                            <th rowspan="2" class="text-center">View SI</th>
                            <th colspan="2" class="text-center">Bukti Transfer</th>
                            <!-- <th rowspan="2" class="text-center">Nominatif</th> -->
                            <th rowspan="2" class="text-center">Debitur</th>
                            <th rowspan="2" class="text-center">Plafond</th>
                            <th rowspan="2" class="text-center">Dropping</th>
                            <th rowspan="2" class="text-center">Tanggal Cair</th>
                        </tr>
                        <tr>
                            <th class="text-center">Upload</th>
                            <th class="text-center">View</th>
                        </tr>
                    </thead>
                    @else
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">Tanggal Cetak</th>
                            <th rowspan="2">Nomor Surat</th>
                            <th rowspan="2">Sumber Dana</th>
                            <th rowspan="2">Status</th>
                            <th colspan="3" class="text-center">Surat Pengajuan</th>
                            <th colspan="2" class="text-center">Bukti Transfer</th>
                            <!-- <th rowspan="2" class="text-center">Nominatif</th> -->
                            <th rowspan="2" class="text-center">Debitur</th>
                            <th rowspan="2" class="text-center">Plafond</th>
                            <th rowspan="2" class="text-center">Dropping</th>
                            <th rowspan="2" class="text-center">Tanggal Cair</th>
                        </tr>
                        <tr>
                            <th class="text-center">Cetak Surat</th>
                            <th class="text-center">Upload</th>
                            <th class="text-center">View</th>
                            <th class="text-center">Upload</th>
                            <th class="text-center">View</th>
                        </tr>
                    </thead>
                    @endif
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
        var userRole = {!!user_role()!!}
        $(function () {
            $('#datetimepicker1').datetimepicker({
                        useCurrent: false,
                        format: 'MM/DD/YYYY, HH:mm',
                        sideBySide: true,
                        date: '12/18/2018 18:30',
                        allowInputToggle: true
                    })
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

            $('#formFiles').submit(function(e){
                $('#btn-submit-files').attr('disabled', true)
                e.preventDefault();
                var form = document.getElementById('formFiles');
                var formData = new FormData(form)
                $.ajax({
                    url: "{{route('application.files.upload')}}",
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success:function(response){
                        reloadDataTable()
                        $('#btn-submit-files').attr('disabled', false)
                        $('#modalUploadFiles').modal('hide');
                    }
                });
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
            let columns = [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                    { data: 'date', name: 'date', searchable: false, orderable: false},
                    { data: 'number', name: 'number', searchable: false, orderable: false},
                    { data: 'name', name: 'name', searchable: false, orderable: false},
                    { data: 'status', name: 'status', searchable: false, orderable: false},
                    { data: 'view_si', name: 'view_si', searchable: false, orderable: false},
                    { data: 'upload_file', name: 'upload_file', searchable: false, orderable: false},
                    { data: 'view_evidence', name: 'view_evidence', searchable: false, orderable: false},
                    { data: 'upload_transfer_evidence', name: 'uplaod_transfer_evidence', searchable: false, orderable: false},
                    { data: 'view_transfer_evidence', name: 'view_transfer_evidence', searchable: false, orderable: false},
                    // { data: 'view_nominative', name: 'view_nominative', searchable: false, orderable: false},
                    { data: 'debitur', name: 'debitur', searchable: false, orderable: false},
                    { data: 'plafond', name: 'plafond', searchable: false, orderable: false},
                    { data: 'dropping', name: 'dropping', searchable: false, orderable: false},
                    { data: 'disbursement_date', name: 'disbursement_date', searchable: false, orderable: false}
                ]
            if(userRole.slug=='bank'){
                columns=[
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                    { data: 'date', name: 'date', searchable: false, orderable: false},
                    { data: 'number', name: 'number', searchable: false, orderable: false},
                    { data: 'name', name: 'name', searchable: false, orderable: false},
                    { data: 'status', name: 'status', searchable: false, orderable: false},
                    { data: 'submit_process', name: 'submit_process', searchable: false, orderable: false},
                    { data: 'view_evidence', name: 'view_evidence', searchable: false, orderable: false},
                    { data: 'upload_transfer_evidence', name: 'uplaod_transfer_evidence', searchable: false, orderable: false},
                    { data: 'view_transfer_evidence', name: 'view_transfer_evidence', searchable: false, orderable: false},
                    // { data: 'view_nominative', name: 'view_nominative', searchable: false, orderable: false},
                    { data: 'debitur', name: 'debitur', searchable: false, orderable: false},
                    { data: 'plafond', name: 'plafond', searchable: false, orderable: false},
                    { data: 'dropping', name: 'dropping', searchable: false, orderable: false},
                    { data: 'disbursement_date', name: 'disbursement_date', searchable: false, orderable: false}
                ]
            }
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
                    url: "{!! route('application.internal.disbursement.datatable') !!}",
                    type: 'GET'
                },
                columns: columns
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
            $('#dataTable').DataTable().ajax.url("{!! route('application.internal.disbursement.datatable') !!}?"+params.toString()).load();
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

        $(document).on('click', '.btn_submit_process', function(event) {
            let data = $(this).data();
            Swal.fire({
                title: 'Proses Pencairan',
                text: 'Apakah anda yakin akan memproses pencairan?',
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "<i class='fas fa-check'></i>&nbsp;Proses",
                cancelButtonText: "<i class='fa fa-times'></i>&nbsp;Batal",
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    var formData = new FormData();
                    formData.append("status", data.status);
                    formData.append("id", data.id);
                    $.ajax({
                        url: data.url,
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
            });
        });
    </script>
@endpush
