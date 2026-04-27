@extends('layouts.template')
@section('title','Detail Angsuran')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Detail Angsuran</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Angsuran</li>
                    <li class="breadcrumb-item active">Detail</li>
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
            <div class="card-body">
                <input type="hidden" class="form-control float-right" id="start_date">
                <input type="hidden" class="form-control float-right" id="end_date">
                <div class="row">
                    <div class="col-md-12">
                        <table style="width:100%">
                            <tr>
                                <td>Nopen</td>
                                <td>: {{$taspen->nopen}}</td>
                                <td></td>
                                <td>Plafond</td>
                                <td>: Rp {{number_format($application->plafon, 2, ",", ".")}}</td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td>: {{$taspen->name}}</td>
                                <td></td>
                                <td>Tenor</td>
                                <td>: {{$application->tenor}}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Akad</td>
                                <td>: {{$contract->akad_date}}</td>
                                <td></td>
                                <td>Produk Pembiayaan</td>
                                <td>: {{$product->name}}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Lunas</td>
                                <td>: {{$contract->settlement_date}}</td>
                                <td></td>
                                <td>Jenis Pembiayaan</td>
                                <td>: {{$finance_type->name}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="divider-line"><span> Jadwal Angsuran </span></div>
                    </div>
                    <div class="col-md-12 table-responsive">
                        <table id="dataTable" class="table table-bordered table-striped table-hover" width="100%">
                            <thead>
                                <tr class="bg-yellow">
                                    <th >No</th>
                                    <th >Jadwal Bayar</th>
                                    <th >Angsuran</th>
                                    <th >Pokok</th>
                                    <th >Margin</th>
                                    <th >Status</th>
                                    <th >Tanggal Pembayaran</th>
                                    <th >Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
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
                    <select class="custom-select custom-select-sm form-control form-control-sm" id="status" placeholder="Status Pembayaran" aria-controls="dataTable">
                        <option value="" selected>Semua</option>
                        <option value="1">Bayar</option>
                        <option value="0">Belum Bayar</option>
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
                    url: "{!! $application->url !!}",
                    type: 'GET'
                },
                createdRow: function (row, data, dataIndex) {
                    // if (data.status == '0') {
                        // $(row).addClass('bg-yellow');
                    // }
                },
                columns: [
                    { data: 'number', name: 'number', searchable: false, orderable: false},
                    { data: 'payment_date', name: 'payment_date', searchable: false, orderable: false},
                    { data: 'amount', name: 'amount', searchable: false, orderable: false},
                    { data: 'primary_loan', name: 'primary_loan', searchable: false, orderable: false},
                    { data: 'margin', name: 'margin', searchable: false, orderable: false},
                    { data: 'status_label', name: 'status_label', searchable: false, orderable: false},
                    { data: 'settlement_date', name: 'settlement_date', searchable: false, orderable: false},
                    { data: 'action', name: 'action', searchable: false, orderable: false},
                ]
            });
        }

        function reloadDataTable(){
            var startDate = $('#start_date').val() || ''
            var endDate = $('#end_date').val() || ''
            var status = $('#status').val() || ''
            var params = new URLSearchParams({
                'start_date': startDate,
                'end_date': endDate,
                'status': status
            });
            $('#dataTable').DataTable().ajax.url("{!! $application->url !!}?"+params.toString()).load();
        }


        $(document).on('click', '.btn-payment', function(event) {
            let data = $(this).data();
            console.log('DATA', data);
            Swal.fire({
                title: "Bayar Tagihan",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "<i class='fa fa-check'></i>&nbsp;Bayar",
                cancelButtonText: "<i class='fa fa-times'></i>&nbsp;Batal",
                reverseButtons: true,
                didOpen: function() {
                    $('#datetimepicker').datetimepicker({
                        format: 'DD-MM-YYYY',
                    })
                },
                preConfirm: () => {
                    let result ={
                        status: data.status,
                        file:$('#file')[0].files[0],
                        payment_type: document.getElementById("payment_type").value,
                        description: document.getElementById("description").value,
                    }
                    return result
                },
                html:`
                    <div class="form-group text-left">
                        <label class="control-label">No Akad</label>
                        <input id="contract_number" class="form-control" readonly value="${data.akad}">
                    </div>
                    <div class="form-group text-left">
                        <label class="control-label">Angsuran Ke</label>
                        <input id="number" class="form-control" readonly value="${data.number}">
                    </div>
                    <div class="form-group text-left">
                        <label class="control-label">Metode Pembayaran</label>
                        <select id="payment_type" name="payment_type" class="form-control">
                            <option value="cash" selected>Tunai</option>
                            <option value="transfer">Transfer</option>
                        </select>
                    </div>
                    <div class="form-group text-left">
                        <label class="control-label">Bukti Bayar</label>
                        <input id="file" type="file" class="form-control">
                    </div>
                    <div class="form-group text-left">
                        <label class="control-label">Keterangan</label>
                        <textarea id="description" class="form-control"></textarea>
                    </div>
                `
            }).then((result) => {
                if (result.isConfirmed) {
                    pay(data.url, result.value)
                }
            });
        });

        function pay(url, values){
            var status = values.status == 0 ? 1:0
            var formData = new FormData();
            formData.append("status", status);
            formData.append("file", values.file);
            formData.append("payment_type", values.payment_type);
            formData.append("description", values.description);
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


        $(document).on('click', '.btn-cancel-payment', function(event) {
            let data = $(this).data();
            Swal.fire({
                title: "Batal Bayar Tagihan",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "<i class='fa fa-check'></i>&nbsp;Simpan",
                cancelButtonText: "<i class='fa fa-times'></i>&nbsp;Batal",
                reverseButtons: true,
                didOpen: function() {
                    $('#datetimepicker').datetimepicker({
                        format: 'DD-MM-YYYY',
                    })
                },
                preConfirm: () => {
                    let result ={
                        description: document.getElementById("description").value,
                    }
                    return result
                },
                html:`
                    <div class="form-group text-left">
                        <label class="control-label">No Akad</label>
                        <input id="contract_number" class="form-control" readonly value="${data.akad}">
                    </div>
                    <div class="form-group text-left">
                        <label class="control-label">Angsuran Ke</label>
                        <input id="number" class="form-control" readonly value="${data.number}">
                    </div>
                    <div class="form-group text-left">
                        <label class="control-label">Keterangan Pembatalan</label>
                        <textarea id="description" class="form-control"></textarea>
                    </div>
                `
            }).then((result) => {
                if (result.isConfirmed) {
                    unPay(data.url, result.value)
                }
            });
        });

        function unPay(url, values){
            var status = values.status == 0 ? 1:0
            var formData = new FormData();
            formData.append("status", 0);
            formData.append("description", values.description);
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
    </script>
@endpush
