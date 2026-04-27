@extends('layouts.template')
@section('title','Kehadiran')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Kehadiran</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Kehadiran</li>
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
            <div class="card-header">
                <h3 class="card-title">Data Kehadiran</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group" style="text-align: center;">
                            <label for="attendance" class="control-label center" id="attendance_time" onload="getTime()" style="font-size:6vw"></label>
                            <p class="help-block center" id="attendance_date" onload="getDate()" style="font-size:5vw"></p>
                        </div>
                        <div class="form-group" style="text-align: center;">
                            <button type="button" {{$check_in_time != '' ? 'disabled' : ''}} class="btn btn-success btn-sm btn-md" id="check_in" style="font-size:4vw">Masuk</button>
                            <button type="button" {{$check_out_time != '' ? 'disabled' : ''}} class="btn btn-danger btn-sm btn-md" id="check_out"style="font-size:4vw">Keluar</button>
                        </div>
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
        getTime()
        getDate()
        function getTime() {
            const today = new Date();
            let h = today.getHours();
            let m = today.getMinutes();
            let s = today.getSeconds();
            m = checkTime(m);
            s = checkTime(s);
            document.getElementById('attendance_time').innerHTML =  h + ":" + m + ":" + s;
            setTimeout(getTime, 1000);
        }

        function checkTime(i) {
            if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
            return i;
        }
        function getDate(){
            var date = new Date();
            var tahun = date.getFullYear();
            var bulan = date.getMonth();
            var tanggal = date.getDate();
            var hari = date.getDay();
            var jam = date.getHours();
            var menit = date.getMinutes();
            var detik = date.getSeconds();
            switch(hari) {
            case 0: hari = "Minggu"; break;
            case 1: hari = "Senin"; break;
            case 2: hari = "Selasa"; break;
            case 3: hari = "Rabu"; break;
            case 4: hari = "Kamis"; break;
            case 5: hari = "Jum'at"; break;
            case 6: hari = "Sabtu"; break;
            }
            switch(bulan) {
            case 0: bulan = "Januari"; break;
            case 1: bulan = "Februari"; break;
            case 2: bulan = "Maret"; break;
            case 3: bulan = "April"; break;
            case 4: bulan = "Mei"; break;
            case 5: bulan = "Juni"; break;
            case 6: bulan = "Juli"; break;
            case 7: bulan = "Agustus"; break;
            case 8: bulan = "September"; break;
            case 9: bulan = "Oktober"; break;
            case 10: bulan = "November"; break;
            case 11: bulan = "Desember"; break;
            }
            // var tampilTanggal = "Tanggal: " + hari + ", " + tanggal + " " + bulan + " " + tahun;
            document.getElementById('attendance_date').innerHTML =  hari + ", " + tanggal + " " + bulan + " " + tahun;
        }
        $('#check_in').click(function (e) { 
            $.ajax({
                type: "POST",
                url: "{!! route('attendance.store') !!}",
                data: {
                    _token: "{{ csrf_token() }}",
                    check_in_time : $('#attendance_time').text()
                },
                dataType: "json",
                success: function (response) {
                    console.log(response)
                }
            });
            $(this).prop("disabled", true);
            
        });

        $('#check_out').click(function (e) { 
            $.ajax({
                type: "POST",
                url: "{!! route('attendance.store') !!}",
                data: {
                    _token: "{{ csrf_token() }}",
                    check_out_time : $('#attendance_time').text()
                },
                dataType: "json",
                success: function (response) {
                    console.log(response)
                }
            });
            $(this).prop("disabled", true);
        });
    </script>
@endpush
