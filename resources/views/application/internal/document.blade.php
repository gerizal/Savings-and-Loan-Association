@extends('layouts.template')
@section('title','Upload Dokumen Mitra')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Upload Dokumen</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Pengajuan Internal</li>
                    <li class="breadcrumb-item active">Dokumen</li>
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
                            <th rowspan="2">Tanggal Pengajuan</th>
                            <th rowspan="2">No Pensiun</th>
                            <th rowspan="2">Nama Pemohon</th>
                            <th rowspan="2">Produk Pembiayaan</th>
                            <th rowspan="2">Jenis Pembiayaan</th>
                            <th rowspan="2">Tenor</th>
                            <th rowspan="2">Plafon</th>
                            <th rowspan="2"  class="text-center">Upload Berkas</th>
                            <th colspan="2"  class="text-center">Berkas Pengajuan</th>
                            <th colspan="2"  class="text-center">Berkas Akad</th>
                            <th rowspan="2"  class="text-center">RIPLAY</th>
                            <th colspan="2"  class="text-center">Berkas Pelunasan</th>
                            <th colspan="2"  class="text-center">Berkas Jaminan</th>
                            <th colspan="4"  class="text-center">Buku Rekening</th>
                            <th colspan="2"  class="text-center">Berkas Mutasi</th>
                            <th colspan="2"  class="text-center">Berkas Flaging</th>
                            <th colspan="2"  class="text-center">Bukti Cair</th>
                            <th colspan="2"  class="text-center">Video Cair</th>
                            <th colspan="2"  class="text-center">Video Cair 2</th>
                            <th colspan="2"  class="text-center">Video Cair 3</th>
                            <th colspan="2"  class="text-center">Epotpen</th>
                            <!-- <th rowspan="2">Aksi</th> -->
                        </tr>
                        <tr>
                            <th class="text-center">View</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">View</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">View</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">View</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">View</th>
                            <th class="text-center">No Rekening</th>
                            <th class="text-center">Nama Bank</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">View</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">View</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">View</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">View</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">View</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">View</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">View</th>
                            <th class="text-center">Tanggal</th>
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
<!-- <div class="modal fade bd-example-modal-xl" id="modalViewFile" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
        </div>
  </div>
</div> -->

<div class="modal fade bd-example-modal-xl" id="modalUploadFiles" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Upload Berkas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formFiles" method="post" action="{{route('application.files.upload')}}" enctype="multipart/form-data">
                @csrf()
                <input type="hidden" class="form-control" id="application_id" name="application_id">
                <input type="hidden" class="form-control" id="deleted_files" name="deleted_files">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Upload Berkas Akad</label>
                                <input type="file" class="form-control d-none" id="akad" name="akad" onchange="onUploadChange('akad', this)">
                                <div class="row">
                                    <div class="col-md-9">
                                        <input type="text" readonly class="form-control" id="akad_preview" name="akad_preview" placeholder="No File Chosen">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-danger d-none" id="delete-akad" onclick="handleClickDelete('akad')"><i class="fas fa-trash"></i><span>&nbsp;Hapus</span></button>
                                        <button type="button" class="btn btn-default" onclick="handleClickUpload('akad')"  id="upload-akad"><i class="fas fa-upload"></i><span> &nbsp;Upload </span></button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Upload Berkas Pelunasan</label>
                                <input type="file" class="form-control d-none" id="settlement" name="settlement" onchange="onUploadChange('settlement', this)">
                                <div class="row">
                                    <div class="col-md-9">
                                        <input type="text" readonly class="form-control" id="settlement_preview" name="settlement_preview" placeholder="No File Chosen">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-danger d-none" id="delete-settlement" onclick="handleClickDelete('settlement')"><i class="fas fa-trash"></i><span>&nbsp;Hapus</span></button>
                                        <button type="button" class="btn btn-default" onclick="handleClickUpload('settlement')"  id="upload-settlement"><i class="fas fa-upload"></i><span> &nbsp;Upload </span></button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Upload Berkas Jaminan</label>
                                <input type="file" class="form-control d-none" id="guarantee" name="guarantee" onchange="onUploadChange('guarantee', this)">
                                <div class="row">
                                    <div class="col-md-9">
                                        <input type="text" readonly class="form-control" id="guarantee_preview" name="guarantee_preview" placeholder="No File Chosen">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-danger d-none" id="delete-guarantee" onclick="handleClickDelete('guarantee')"><i class="fas fa-trash"></i><span>&nbsp;Hapus</span></button>
                                        <button type="button" class="btn btn-default" onclick="handleClickUpload('guarantee')"  id="upload-guarantee"><i class="fas fa-upload"></i><span> &nbsp;Upload </span></button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Upload Berkas Mutasi</label>
                                <input type="file" class="form-control d-none" id="mutation" name="mutation" onchange="onUploadChange('mutation', this)">
                                <div class="row">
                                    <div class="col-md-9">
                                        <input type="text" readonly class="form-control" id="mutation_preview" name="mutation_preview" placeholder="No File Chosen">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-danger d-none" id="delete-mutation" onclick="handleClickDelete('mutation')"><i class="fas fa-trash"></i><span>&nbsp;Hapus</span></button>
                                        <button type="button" class="btn btn-default" onclick="handleClickUpload('mutation')"  id="upload-mutation"><i class="fas fa-upload"></i><span> &nbsp;Upload </span></button>
                                    </div>
                                </div>
                            </div>
                            <div class="divider-line"><span>Rekening Bank</span></div>
                            <div class="form-group">
                                <label>Upload Berkas Buku Rekening</label>
                                <input type="file" class="form-control d-none" id="account_bank" name="account_bank" onchange="onUploadChange('account_bank', this)">
                                <div class="row">
                                    <div class="col-md-9">
                                        <input type="text" readonly class="form-control" id="account_bank_preview" name="account_bank_preview" placeholder="No File Chosen">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-danger d-none" id="delete-account_bank" onclick="handleClickDelete('account_bank')"><i class="fas fa-trash"></i><span>&nbsp;Hapus</span></button>
                                        <button type="button" class="btn btn-default" onclick="handleClickUpload('account_bank')"  id="upload-account_bank"><i class="fas fa-upload"></i><span> &nbsp;Upload </span></button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 col-xs-12">
                                    <div class="form-group">
                                        <label>No Rekening</label>
                                        <input type="number" class="form-control" id="account_bank_number" name="account_bank_number">
                                    </div>
                                </div>
                                <div class="col-md-7 col-xs-12">
                                    <div class="form-group">
                                        <label>Nama Bank</label>
                                        <input type="text" class="form-control" id="bank_name" name="bank_name">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Upload Berkas Flagging</label>
                                <input type="file" class="form-control d-none" id="flagging" name="flagging" onchange="onUploadChange('flagging', this)">
                                <div class="row">
                                    <div class="col-md-9">
                                        <input type="text" readonly class="form-control" id="flagging_preview" name="flagging_preview" placeholder="No File Chosen">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-danger d-none" id="delete-flagging" onclick="handleClickDelete('flagging')"><i class="fas fa-trash"></i><span>&nbsp;Hapus</span></button>
                                        <button type="button" class="btn btn-default" onclick="handleClickUpload('flagging')"  id="upload-flagging"><i class="fas fa-upload"></i><span> &nbsp;Upload </span></button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Upload Berkas Epotpen </label>
                                <input type="file" class="form-control d-none" id="epotpen" name="epotpen" onchange="onUploadChange('epotpen', this)">
                                <div class="row">
                                    <div class="col-md-9">
                                        <input type="text" readonly class="form-control" id="epotpen_preview" name="epotpen_preview" placeholder="No File Chosen">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-danger d-none" id="delete-epotpen" onclick="handleClickDelete('epotpen')"><i class="fas fa-trash"></i><span>&nbsp;Hapus</span></button>
                                        <button type="button" class="btn btn-default" onclick="handleClickUpload('epotpen')"  id="upload-epotpen"><i class="fas fa-upload"></i><span> &nbsp;Upload </span></button>
                                    </div>
                                </div>
                            </div>
                            <div class="divider-line"><span>Pencairan</span></div>
                            <div class="form-group">
                                <label>Upload Berkas Bukti Cair </label>
                                <input type="file" class="form-control d-none" id="disbursement" name="disbursement" onchange="onUploadChange('disbursement', this)">
                                <div class="row">
                                    <div class="col-md-9">
                                        <input type="text" readonly class="form-control" id="disbursement_preview" name="disbursement_preview" placeholder="No File Chosen">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-danger d-none" id="delete-disbursement" onclick="handleClickDelete('disbursement')"><i class="fas fa-trash"></i><span>&nbsp;Hapus</span></button>
                                        <button type="button" class="btn btn-default" onclick="handleClickUpload('disbursement')"  id="upload-disbursement"><i class="fas fa-upload"></i><span> &nbsp;Upload </span></button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Upload Video Cair </label>
                                <input type="file" class="form-control d-none" id="disbursement_video" name="disbursement_video" onchange="onUploadChange('disbursement_video', this)">
                                <div class="row">
                                    <div class="col-md-9">
                                        <input type="text" readonly class="form-control" id="disbursement_video_preview" name="disbursement_video_preview" placeholder="No File Chosen">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-danger d-none" id="delete-disbursement_video" onclick="handleClickDelete('disbursement_video')"><i class="fas fa-trash"></i><span>&nbsp;Hapus</span></button>
                                        <button type="button" class="btn btn-default" onclick="handleClickUpload('disbursement_video')"  id="upload-disbursement_video"><i class="fas fa-upload"></i><span> &nbsp;Upload </span></button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Upload Video Cair 2</label>
                                <input type="file" class="form-control d-none" id="disbursement_video_2" name="disbursement_video_2" onchange="onUploadChange('disbursement_video_2', this)">
                                <div class="row">
                                    <div class="col-md-9">
                                        <input type="text" readonly class="form-control" id="disbursement_video_2_preview" name="disbursement_video_2_preview" placeholder="No File Chosen">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-danger d-none" id="delete-disbursement_video_2" onclick="handleClickDelete('disbursement_video_2')"><i class="fas fa-trash"></i><span>&nbsp;Hapus</span></button>
                                        <button type="button" class="btn btn-default" onclick="handleClickUpload('disbursement_video_2')"  id="upload-disbursement_video_2"><i class="fas fa-upload"></i><span> &nbsp;Upload </span></button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Upload Video Cair 3</label>
                                <input type="file" class="form-control d-none" id="disbursement_video_3" name="disbursement_video_3" onchange="onUploadChange('disbursement_video_3', this)">
                                <div class="row">
                                    <div class="col-md-9">
                                        <input type="text" readonly class="form-control" id="disbursement_video_3_preview" name="disbursement_video_3_preview" placeholder="No File Chosen">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-danger d-none" id="delete-disbursement_video_3" onclick="handleClickDelete('disbursement_video_3')"><i class="fas fa-trash"></i><span>&nbsp;Hapus</span></button>
                                        <button type="button" class="btn btn-default" onclick="handleClickUpload('disbursement_video_3')"  id="upload-disbursement_video_3"><i class="fas fa-upload"></i><span> &nbsp;Upload </span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btn-submit-files" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
  </div>
</div>
@endsection
@push('script')
    <script>
        var banks = @json($banks);
        var deletedFiles = [];
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
                    <select class="custom-select custom-select-sm form-control form-control-sm" id="group" placeholder="Group" aria-controls="dataTable">
                        <option value="express">Express</option>
                        <option value="regular">Reguler</option>
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

        $(document).on('click', '.print-contract', function(event) {
            let data = $(this).data();
            var contractNumber = '';
            Swal.fire({
                title: "Cetak Akad",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "<i class='fa fa-print'></i>&nbsp;Cetak",
                cancelButtonText: "<i class='fa fa-times'></i>&nbsp;Batal",
                reverseButtons: true,
                didOpen: function() {
                    $('#datetimepicker').datetimepicker({
                        format: 'DD-MM-YYYY',
                    })

                    $('#datetimepicker').on('change.datetimepicker', function(e){
                        console.log(e);
                        contractNumber = `/KPF-OPS/KPF/${moment(e.date).format("DDMMYYYY")}`;
                        $('#contract_number').val(contractNumber);
                        $('#contract_number').attr('readonly',false);
                    })
                },
                preConfirm: () => {
                    let result ={
                        contract_date: document.getElementById("contract_date").value,
                        contract_number: document.getElementById("contract_number").value,
                        interest_type: document.getElementById("interest_type").value,
                        interest: document.getElementById("interest").value,
                        id: document.getElementById("id").value,
                        url: document.getElementById("url").value,
                    }
                    return result
                },
                html:`
                    <input type="hidden" id="url" class="form-control" value="${data.url}">
                    <input type="hidden" id="id" class="form-control" value="${data.id}">
                    <div class="form-group required text-left">
                        <label class="control-label">Tanggal Cetak</label>
                        <div class="input-group date" id="datetimepicker" data-target-input="nearest">
                            <input class="form-control datetimepicker-input" data-target="#datetimepicker" type="text" name="contract_date" id="contract_date">
                            <div class="input-group-append" data-target="#datetimepicker" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group required  text-left">
                        <label class="control-label">Nomor Akad</label>
                        <input id="contract_number" class="form-control" readonly value="">
                    </div>
                    <div class="form-group required  text-left">
                        <label class="control-label">Produk Pembiayaan</label>
                        <input id="finance_product" class="form-control" readonly>
                    </div>
                    <div class="form-group required  text-left">
                        <label class="control-label">Jenis Pembiayaan</label>
                        <input id="finance_type" class="form-control" readonly>
                    </div>
                    <div class="form-group required  text-left">
                        <label class="control-label">Sumber Dana</label>
                        <input id="fund" class="form-control" readonly>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group required  text-left">
                                <label class="control-label">Jenis Margin</label>
                                <select id="interest_type" class="form-control" required>
                                    <option value="Flat">Flat</option>
                                    <option value="Anuitas">Anuitas</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group required text-left">
                                <label class="control-label">Margin</label>
                                <input type="number" step="0.01" id="interest" class="form-control" required>
                            </div>
                        </div>
                    </div>
                `
            }).then((result) => {
                console.log('RESULT', result);
                if (result.isConfirmed) {
                    printContract(result.value)
                }
            });
        });
        function printContract(values){
            $.ajax({
                url: values.url,
                type: "post",
                data: {
                    _token: "{{ csrf_token() }}",
                    contract_date:values.contract_date,
                    contract_number:values.contract_number,
                    interest:values.interest,
                    interest_type:values.interest_type,
                },
                xhrFields: {responseType: "blob"},
                success: function (data) {
                    var blob = new Blob([data], {type: "application/octet-stream"});
                    const downloadUrl = URL.createObjectURL(blob);
                    const a = document.createElement("a");
                    a.href = downloadUrl;
                    a.download = values.contract_number+".pdf";
                    document.body.appendChild(a);
                    a.click();
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
                    url: "{!! route('application.internal.document.datatable') !!}",
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"}
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                    { data: 'date', name: 'date', searchable: false, orderable: false},
                    { data: 'nopen', name: 'nopen', searchable: false, orderable: false},
                    { data: 'name', name: 'name', searchable: false, orderable: false},
                    { data: 'product_name', name: 'product_name', searchable: false, orderable: false},
                    { data: 'finance_type', name: 'finance_type', searchable: false, orderable: false},
                    { data: 'tenor', name: 'tenor', searchable: false, orderable: false},
                    { data: 'plafon', name: 'plafon', searchable: false, orderable: false},
                    { data: 'upload_file', name: 'upload_file', searchable: false, orderable: false},
                    { data: 'view_application_file', name: 'view_application_file', searchable: false, orderable: false},
                    { data: 'application_file_date', name: 'application_file_date', searchable: false, orderable: false},
                    { data: 'view_akad', name: 'view_akad', searchable: false, orderable: false},
                    { data: 'akad_date', name: 'akad_date', searchable: false, orderable: false},
                    { data: 'riplay', name: 'riplay', searchable: false, orderable: false},
                    { data: 'view_settlement', name: 'view_settlement', searchable: false, orderable: false},
                    { data: 'settlement_date', name: 'settlement_date', searchable: false, orderable: false},
                    { data: 'view_guarantee', name: 'view_guarantee', searchable: false, orderable: false},
                    { data: 'guarantee_date', name: 'guarantee_date', searchable: false, orderable: false},
                    { data: 'view_account_bank', name: 'view_account_bank', searchable: false, orderable: false},
                    { data: 'account_bank_number', name: 'account_bank_number', searchable: false, orderable: false},
                    { data: 'bank_name', name: 'bank_name', searchable: false, orderable: false},
                    { data: 'account_bank_date', name: 'account_bank_date', searchable: false, orderable: false},
                    { data: 'view_mutation', name: 'view_mutation', searchable: false, orderable: false},
                    { data: 'mutation_date', name: 'mutation_date', searchable: false, orderable: false},
                    { data: 'view_flagging', name: 'view_flagging', searchable: false, orderable: false},
                    { data: 'flagging_date', name: 'flagging_date', searchable: false, orderable: false},
                    { data: 'view_disbursement', name: 'view_disbursement', searchable: false, orderable: false},
                    { data: 'disbursement_date', name: 'disbursement_date', searchable: false, orderable: false},
                    { data: 'view_disbursement_video', name: 'view_disbursement_video', searchable: false, orderable: false},
                    { data: 'disbursement_video_date', name: 'disbursement_video_date', searchable: false, orderable: false},
                    { data: 'view_disbursement_video_2', name: 'view_disbursement_video_2', searchable: false, orderable: false},
                    { data: 'disbursement_video_2_date', name: 'disbursement_video_2_date', searchable: false, orderable: false},
                    { data: 'view_disbursement_video_3', name: 'view_disbursement_video_3', searchable: false, orderable: false},
                    { data: 'disbursement_video_3_date', name: 'disbursement_video_3_date', searchable: false, orderable: false},
                    { data: 'view_epotpen', name: 'view_epotpen', searchable: false, orderable: false},
                    { data: 'epotpen_date', name: 'epotpen_date', searchable: false, orderable: false}
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
            $('#dataTable').DataTable().ajax.url("{!! route('application.internal.document.datatable') !!}?"+params.toString()).load();
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
            var files = data.file
            var modal = $(this)
            if(files){
                for (var key in files) {
                    console.log('#'+key+'_preview',files[key]);
                    if(['account_bank_number','bank_name'].includes(key)){
                        $('#'+key).val(files[key]);
                    }else{
                        $('#'+key+'_preview').val(files[key])
                        if(files[key]){
                            $('#delete-'+key).removeClass('d-none')
                            $('#upload-'+key).removeClass('d-none').addClass('d-none')
                        }else{
                            $('#delete-'+key).removeClass('d-none').addClass('d-none')
                            $('#upload-'+key).removeClass('d-none')
                        }
                    }
                }
            }

            deletedFiles = []
            $('#deleted_files').val(null);
            modal.find('#application_id').val(data.id)
        })

        function handleClickUpload(name){
            $("#"+name).click();
        }
        function handleClickDelete(name){
            $("#"+name+'_preview').val('');
            if(name=='account_bank'){
                $("#account_bank_number").val('');
                $("#bank_name").val('');
            }
            $('#delete-'+name).removeClass('d-none').addClass('d-none')
            $('#upload-'+name).removeClass('d-none')
            deletedFiles.push(name)
            $('#deleted_files').val(deletedFiles.toString());
        }

        function onUploadChange(name, file){
            $('#'+name+'_preview').val(file.files[0].name);
            $('#delete-'+name).removeClass('d-none')
            $('#upload-'+name).removeClass('d-none').addClass('d-none')
            deletedFiles = deletedFiles.filter(x=>x!=name)
            $('#deleted_files').val(deletedFiles.toString());
        }
    </script>
@endpush
