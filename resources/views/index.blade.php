@extends('layouts.template')
@section('title','Dashboard')

@section('content')
<div class="row">
    <div class="col-md-7">
        <div class="card card-success">
            <!-- <div class="card-header">
            <h3 class="card-title">Bar Chart</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
                </button>
            </div>
            </div> -->
            <div class="card-body">
                <div class="chart">
                    <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <!-- /.col (LEFT) -->
    <div class="col-md-5">
        <div class="card card-danger">
            <!-- <div class="card-header">
                <h3 class="card-title">Donut Chart</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                    </button>
                </div>
            </div> -->
            <div class="card-body">
                <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <!-- /.col (RIGHT) -->
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card card-danger">
            <div class="card-header">
                <h3 class="card-title">Data Bisnis Bank (Reguler)</h3>
            </div>
            <div class="card-body table-responsive">
                <table id="regularTable" class="table table-bordered table-striped" style="width: 100%;">
                    <thead style="width:100%">
                        <tr>
                            <th rowspan="2" class="text-center">Sumber Dana</th>
                            <th colspan="2" class="text-center">ANTRIAN PENGAJUAN BANK</th>
                            <th colspan="2" class="text-center">PENGAJUAN DROPPING</th>
                            <th rowspan="2" class="text-center">{{date('Y-m-d')}}</th>
                            <th colspan="2" class="text-center">TOTAL</th>
                        </tr>
                        <tr>
                            <th class="text-center">SLIK</th>
                            <th class="text-center">APPROVAL</th>
                            <th class="text-center">ANTRI</th>
                            <th class="text-center">PROSES</th>
                            <th class="text-center">DROPING</th>
                            <th class="text-center">OS</th>
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
        <div class="card card-danger">
            <div class="card-header">
                <h3 class="card-title">Data Bisnis Bank (Flash)</h3>
            </div>
            <div class="card-body table-responsive">
                <table id="flashTable" class="table table-bordered table-striped" style="width: 100%;">
                    <thead>
                        <tr>
                            <th rowspan="2" class="text-center">Sumber Dana</th>
                            <th colspan="2" class="text-center">ANTRIAN PENGAJUAN BANK</th>
                            <th colspan="2" class="text-center">PENGAJUAN DROPPING</th>
                            <th rowspan="2" class="text-center">{{date('Y-m-d')}}</th>
                            <th colspan="2" class="text-center">TOTAL</th>
                        </tr>
                        <tr>
                            <th class="text-center">SLIK</th>
                            <th class="text-center">APPROVAL</th>
                            <th class="text-center">ANTRI</th>
                            <th class="text-center">PROSES</th>
                            <th class="text-center">DROPING</th>
                            <th class="text-center">OS</th>
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
        <div class="card card-danger">
            <div class="card-header">
                <h3 class="card-title">Data Bisnis Area</h3>
            </div>
            <div class="card-body table-responsive">
                <table id="areaTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">Nama Area</th>
                            <th class="text-center">Kode Area</th>
                            <th class="text-center">Total Cabang</th>
                            <th class="text-center">Total Marketing</th>
                            <th class="text-center">Total Antrian</th>
                            <th class="text-center">Total Pencairan</th>
                            <!-- <th class="text-center"></th> -->
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
        <div class="card card-danger">
            <div class="card-header">
            <h3 class="card-title">Data Bisnis Cabang</h3>
            </div>
            <div class="card-body table-responsive">
                <table id="branchTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">Nama Cabang</th>
                            <th class="text-center">Area Pelayanan</th>
                            <th class="text-center">Total Marketing</th>
                            <th class="text-center">Total Antrian</th>
                            <th class="text-center">Total Pencairan</th>
                            <!-- <th class="text-center"></th> -->
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
        <div class="card card-danger">
            <div class="card-header text-center">
                <h3 class="card-title text-center">Data Bisnis Marketing</h3>
            </div>
            <div class="card-body table-responsive">
                <table id="marketingTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">Nama Marketing</th>
                            <th class="text-center">Jabatan</th>
                            <th class="text-center">Unit Pelayanan</th>
                            <th class="text-center">Area Pelayanan</th>
                            <th class="text-center">Total Nasabah</th>
                            <th class="text-center">Total Plafond</th>
                            <!-- <th class="text-center"></th> -->
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
<!-- ChartJS -->
<script src="{{ asset ("/bower_components/admin-lte/plugins/chart.js/Chart.min.js") }}"></script>
<script>
  $(function () {
    $('#regularTable').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        lengthChange: false,
        paginate:false,
        info: false,
        ajax: {
            url: "{!! route('home.regular.datatable') !!}",
            type: 'GET'
        },
        columns: [
            { data: 'name', name: 'name', searchable: false, orderable: false},
            { data: 'slik', name: 'slik', searchable: false, orderable: false},
            { data: 'approval', name: 'approval', searchable: false, orderable: false},
            { data: 'dropping_queue', name: 'queue', searchable: false, orderable: false},
            { data: 'dropping_process', name: 'process', searchable: false, orderable: false},
            { data: 'new_data', name: 'new_data', searchable: false, orderable: false},
            { data: 'total_dropping', name: 'dropping', searchable: false, orderable: false},
            { data: 'total_os', name: 'os', searchable: false, orderable: false},
        ]
    });

    $('#flashTable').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        lengthChange: false,
        paginate:false,
        info: false,
        ajax: {
            url: "{!! route('home.flash.datatable') !!}",
            type: 'GET'
        },
        columns: [
            { data: 'name', name: 'name', searchable: false, orderable: false},
            { data: 'slik', name: 'slik', searchable: false, orderable: false},
            { data: 'approval', name: 'approval', searchable: false, orderable: false},
            { data: 'dropping_queue', name: 'queue', searchable: false, orderable: false},
            { data: 'dropping_process', name: 'process', searchable: false, orderable: false},
            { data: 'new_data', name: 'new_data', searchable: false, orderable: false},
            { data: 'total_dropping', name: 'dropping', searchable: false, orderable: false},
            { data: 'total_os', name: 'os', searchable: false, orderable: false},
        ]
    });

    $('#areaTable').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        lengthChange: false,
        paginate:false,
        info: false,
        ajax: {
            url: "{!! route('home.area.datatable') !!}",
            type: 'GET'
        },
        columns: [
            { data: 'name', name: 'name', searchable: false, orderable: false},
            { data: 'code_area', name: 'code_area', searchable: false, orderable: false},
            { data: 'total_branch', name: 'total_branch', searchable: false, orderable: false},
            { data: 'total_marketing', name: 'total_marketing', searchable: false, orderable: false},
            { data: 'total_queue', name: 'total_queue', searchable: false, orderable: false},
            { data: 'total_disbursement', name: 'total_disbursement', searchable: false, orderable: false},
        ]
    });

    $('#branchTable').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        lengthChange: false,
        paginate:false,
        info: false,
        ajax: {
            url: "{!! route('home.branch.datatable') !!}",
            type: 'GET'
        },
        columns: [
            { data: 'branch_name', name: 'branch_name', searchable: false, orderable: false},
            { data: 'name', name: 'name', searchable: false, orderable: false},
            { data: 'total_marketing', name: 'total_marketing', searchable: false, orderable: false},
            { data: 'total_queue', name: 'total_queue', searchable: false, orderable: false},
            { data: 'total_disbursement', name: 'total_disbursement', searchable: false, orderable: false},
        ]
    });

    $('#marketingTable').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        lengthChange: false,
        paginate:false,
        info: false,
        ajax: {
            url: "{!! route('home.marketing.datatable') !!}",
            type: 'GET'
        },
        columns: [
            { data: 'name', name: 'name', searchable: false, orderable: false},
            { data: 'job_title', name: 'job_title', searchable: false, orderable: false},
            { data: 'service_unit_name', name: 'service_unit_name', searchable: false, orderable: false},
            { data: 'branch_name', name: 'branch_name', searchable: false, orderable: false},
            { data: 'total_debitur', name: 'total_debitur', searchable: false, orderable: false},
            { data: 'total_plafond', name: 'total_plafond', searchable: false, orderable: false},
        ]
    });

    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = @json($donut_chart);
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    })

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = @json($chart_data)

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    new Chart(barChartCanvas, {
      type: 'line',
      data: barChartData,
      options: barChartOptions
    })

    // new Chart(stackedBarChartCanvas, {
    //   type: 'bar',
    //   data: stackedBarChartData,
    //   options: stackedBarChartOptions
    // })
  })
</script>
@endpush
