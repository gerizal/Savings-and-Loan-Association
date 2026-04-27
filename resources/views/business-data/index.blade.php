@extends('layouts.template')
@section('title','Data Bisnis')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Bisnis</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Bisnis</li>
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
    <div class="col-sm-12 col-md-12">
        <div class="dataTables_length" id="dataTable_length">
            <input type="hidden" id="start_date" value="">
            <input type="hidden" id="end_date" value="">
            <label>
                <div class="input-group date" id="datetime" data-target-input="nearest">
                    <input type="text" class="custom-select custom-select-sm form-control form-control-sm float-right" id="daterange" aria-controls="dataTable">
                    <div class="input-group-append" data-target="#datetime" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </label>
            <label>
                <select class="custom-select custom-select-sm form-control form-control-sm" id="service_id" name="service_id" placeholder="Status" aria-controls="dataTable">
                    <option value="" selected="" disabled>Area Layanan</option>
                    @foreach($service_areas as $service_area)
                        <option value="{{$service_area->id}}">{{$service_area->name}}</option>
                    @endforeach
                </select>
            </label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title" id="selectedArea" style="text-align: center!important; float:none !important;">&nbsp;</h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Pengajuan Telah Cair</h3>
            </div>
            <div class="card-body table-responsive">
                <table id="disbursedTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" width="5px">&nbsp;</th>
                            <th class="text-center">Area</th>
                            <th class="text-center">NOA</th>
                            <th class="text-center">Total Plafond</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card card-warning">
            <div class="card-header">
            <h3 class="card-title">Pengajuan Dalam Proses</h3>
            </div>
            <div class="card-body table-responsive">
                <table id="nonDisbursedTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center"  width="5px">&nbsp;</th>
                            <th class="text-center">Area</th>
                            <th class="text-center">NOA</th>
                            <th class="text-center">Total Plafond</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
@endsection

@push('script')
<script>

  $(document).ready(function () {
    var dtMarketing;
    var dtDebitur;
    var dt2Marketing;
    var dt2Debitur;
    $('#daterange').daterangepicker({
        autoApply:true
    })
    $('#daterange').on('apply.daterangepicker', function(ev, e) {
        var startDate = e.startDate.format('YYYY-MM-DD')
        var endDate = e.endDate.format('YYYY-MM-DD')
        $('#start_date').val(startDate)
        $('#end_date').val(endDate)
        reloadDataTable('#disbursedTable')
        reloadDataTable('#nonDisbursedTable')
    });
    $('#service_id').change(function() {
        var el = document.getElementById('service_id');
        var text = el.options[el.selectedIndex].innerHTML;
        $('#selectedArea').text(text)
        reloadDataTable('#disbursedTable')
        reloadDataTable('#nonDisbursedTable')
    });
    var disbursedTable = $('#disbursedTable').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        lengthChange: false,
        paginate:false,
        info: false,
        ajax: {
            url: "{!! route('business-data.datatable') !!}",
            type: 'POST',
            headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
            data:{status:['approve']}
        },
        columns: [
            { data: null, className: 'dt-branch', orderable: false, searchable: false, defaultContent: ''},
            { data: 'name', name: 'name', searchable: false, orderable: false},
            { data: 'noa', name: 'noa', searchable: false, orderable: false},
            { data: 'plafond', name: 'plafond', searchable: false, orderable: false}
        ]
    });

    $('#disbursedTable tbody').on('click', 'td.dt-branch', function () {
        var tr = $(this).closest('tr');
        var row = disbursedTable.row(tr);
        var rowData = row.data();
        var branchId = rowData.id;

        var childTable = 'dtBranch'+branchId
        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            $('#'+childTable).DataTable().destroy();
        }
        else {
            row.child(expandRow(childTable,'marketing')).show();
            dtMarketing = $('#'+childTable).DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                lengthChange: false,
                paginate:false,
                info: false,
                select: false,
                ajax: {
                    url: "{!! route('business-data.datatable-marketing') !!}",
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                    data:{status:['approve'], branch_id: branchId}
                },
                columns: [
                    { data: null, className: 'dt-marekting', orderable: false, searchable: false, defaultContent: ''},
                    { data: 'name', name: 'name', searchable: false, orderable: false},
                    { data: 'noa', name: 'noa', searchable: false, orderable: false},
                    { data: 'plafond', name: 'plafond', searchable: false, orderable: false}
                ]
            });

            tr.addClass('shown');
            tr.next().addClass("tr-detail");
        }
    });

    $('tbody').on('click', 'td.dt-marekting', function () {
        var tr = $(this).closest('tr');
        var row = dtMarketing.row(tr);
        var rowData = row.data();
        console.log('DATA', rowData);
        var marketingId = rowData.id;

        var childTable = 'dtMarketing'+marketingId
        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            $('#'+childTable).DataTable().destroy();
        }
        else {
            row.child(expandRow(childTable,'debitur')).show();
            dtDebitur = $('#'+childTable).DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                lengthChange: false,
                paginate:false,
                info: false,
                select: false,
                ajax: {
                    url: "{!! route('business-data.datatable-debitur') !!}",
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                    data:{status:['approve'], marketing_id: marketingId}
                },
                columns: [
                    { data: 'name', name: 'name', searchable: false, orderable: false},
                    { data: 'nopen', name: 'nopen', searchable: false, orderable: false},
                    { data: 'bank_name', name: 'bank_name', searchable: false, orderable: false},
                    { data: 'tenor', name: 'tenor', searchable: false, orderable: false},
                    { data: 'plafond', name: 'plafond', searchable: false, orderable: false}
                ]
            });

            tr.addClass('shown');
            tr.next().addClass("tr-detail");
        }
    });

    var nonDisbursedTable = $('#nonDisbursedTable').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        lengthChange: false,
        paginate:false,
        info: false,
        ajax: {
            url: "{!! route('business-data.datatable') !!}",
            type: 'POST',
            headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
            data:{status:['pending','queue']}
        },
        columns: [
            { data: null, className: 'dt2-branch', orderable: false, searchable: false, defaultContent: ''},
            { data: 'name', name: 'name', searchable: false, orderable: false},
            { data: 'noa', name: 'noa', searchable: false, orderable: false},
            { data: 'plafond', name: 'plafond', searchable: false, orderable: false}
        ]
    });

    $('#nonDisbursedTable tbody').on('click', 'td.dt2-branch', function () {
        var tr = $(this).closest('tr');
        // var tr = $(this).closest('tr');
        var row = nonDisbursedTable.row(tr);
        var rowData = row.data();
        var branchId = rowData.id;

        var childTable = 'dt2Branch'+branchId
        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            $('#'+childTable).DataTable().destroy();
        }
        else {
            row.child(expandRow(childTable,'marketing')).show();
            dt2Marketing = $('#'+childTable).DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                lengthChange: false,
                paginate:false,
                info: false,
                select: false,
                ajax: {
                    url: "{!! route('business-data.datatable-marketing') !!}",
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                    data:{status:['pending','queue'], branch_id: branchId}
                },
                columns: [
                    { data: null, className: 'dt2-marekting', orderable: false, searchable: false, defaultContent: ''},
                    { data: 'name', name: 'name', searchable: false, orderable: false},
                    { data: 'noa', name: 'noa', searchable: false, orderable: false},
                    { data: 'plafond', name: 'plafond', searchable: false, orderable: false}
                ]
            });

            tr.addClass('shown');
            tr.next().addClass("tr-detail");
        }
    });

    $('tbody').on('click', 'td.dt2-marekting', function () {
        var tr = $(this).closest('tr');
        var row = dt2Marketing.row(tr);
        var rowData = row.data();
        var marketingId = rowData.id;

        var childTable = 'dt2Marketing'+marketingId
        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            $('#'+childTable).DataTable().destroy();
        }
        else {
            row.child(expandRow(childTable,'debitur')).show();
            dt2Debitur = $('#'+childTable).DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                lengthChange: false,
                paginate:false,
                info: false,
                select: false,
                ajax: {
                    url: "{!! route('business-data.datatable-debitur') !!}",
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                    data:{status:['pending','queue'], marketing_id: marketingId}
                },
                columns: [
                    { data: 'name', name: 'name', searchable: false, orderable: false},
                    { data: 'nopen', name: 'nopen', searchable: false, orderable: false},
                    { data: 'bank_name', name: 'bank_name', searchable: false, orderable: false},
                    { data: 'tenor', name: 'tenor', searchable: false, orderable: false},
                    { data: 'plafond', name: 'plafond', searchable: false, orderable: false}
                ]
            });

            tr.addClass('shown');
            tr.next().addClass("tr-detail");
        }
    });

    function reloadDataTable(tableName){
        var startDate = $('#start_date').val() || ''
        var endDate = $('#end_date').val() || ''
        var serviceId = $('#service_id').val() || ''
        var params = new URLSearchParams({
            'start_date': startDate,
            'end_date': endDate,
            'service_id': serviceId
        });
        $(tableName).DataTable().ajax.url("{!! route('business-data.datatable') !!}?"+params.toString()).load();
    }

    function expandRow(id, type='marketing') {
        var dt = `<table id="${id}" class="table table-bordered table-striped table-hover table-marketing" style="margin: 0px !important;">
                <thead>
                    <tr>
                        <th class="text-center"  width="15px">&nbsp;</th>
                        <th>Marketing</th>
                        <th>NOA</th>
                        <th>Plafond</th>
                    </tr>
                </thead>
            </table>`
        if(type == 'debitur'){
            dt = `<table id="${id}" class="table table-bordered table-striped table-hover table-debitur"  style="margin: 0px !important;">
                <thead>
                    <tr>
                        <th>Pemohon</th>
                        <th>Nopen</th>
                        <th>Sumber Dana</th>
                        <th>Tenor</th>
                        <th>Plafond</th>
                    </tr>
                </thead>
            </table>`
        }
        return $(dt).toArray();
    }

  })
</script>
@endpush
