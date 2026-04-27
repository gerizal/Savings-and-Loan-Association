<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>{{env('APP_NAME')}} | @yield('title')</title>
        <link rel="icon" type="image/x-icon" href="{{asset('/favicon.ico')}}">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome Icons -->
        <link href="{{ asset("/bower_components/admin-lte/plugins/fontawesome-free/css/all.min.css") }}" rel="stylesheet" type="text/css" />
        <!-- IonIcons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <!-- <link href="{{ asset("/bower_components/admin-lte/dist/css/adminlte.min.css") }}" rel="stylesheet" type="text/css" /> -->
        <!-- iCheck -->
        <link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css") }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/dist/css/adminlte.min.css") }}">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/daterangepicker/daterangepicker.css") }}">

        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css") }}">
        <link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables-fixedcolumns/css/fixedColumns.bootstrap4.min.css") }}">
        <link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css") }}">
        <link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css") }}">
        <link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css") }}">
        <link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/sweetalert2/sweetalert2.min.css") }}">
        <link rel="stylesheet" href="{{ asset ('/bower_components/admin-lte/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset ('/bower_components/admin-lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
        
        <!-- Leaflet CSS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
              integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" 
              crossorigin=""/>
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
					<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js") }}"></script>
					<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js") }}"></script>
					<![endif]-->
        <style>
            .required .control-label:after{
                color: red;
                content: "*";
                position: absolute;
                margin-left: 5px;
            }

            .img-user-preview{
                max-height: 300px;
                margin-bottom: 10px;
            }

            .help-block {
                display: block;
                margin-top: -10px;
                margin-bottom: 10px;
                font-size: 13px;
                color: #737373;
            }
            .divider-line{
                display: flex;
                align-items: center;
                margin: 16px 0;
                color: rgba(0, 0, 0, 0.88);
                font-weight: 500;
                font-size: 16px;
                white-space: nowrap;
                text-align: center;
                border-block-start: 0 rgba(5, 5, 5, 0.06);
            }
            .divider-line::before,
            .divider-line::after{
                position: relative;
                width: 50%;
                border-block-start: 1px solid transparent;
                border-block-start-color: #ced4da;
                border-block-end: 0;
                transform: translateY(50%);
                content: '';
            }
            .divider-line .divider-text{
                display: inline-block;
                padding-block: 0;
                padding-inline: 1em;
            }
            .divider-line span{
                font-size: 14px;
                font-style: italic;
                opacity: .7;
            }

            .sidebar{
                float: left !important;
            }
            .d-block.profile{
                color: white;
            }

            td.dt-marekting,
            td.dt-branch,
            td.dt2-marekting,
            td.dt2-branch {
                background: url(https://www.datatables.net/examples/resources/details_open.png) no-repeat center center;
                cursor: pointer;
                width: 40px !important;
                transition: .5s;
            }

            tr.shown td.dt-marekting,
            tr.shown td.dt-branch,
            tr.shown td.dt2-marekting,
            tr.shown td.dt2-branch {
                background: url(https://www.datatables.net/examples/resources/details_close.png) no-repeat center center;
                width: 40px !important;
                transition: .5s;
            }

            .tr-detail td,
            .table-marketing .tr-detail td{
                padding-top: 0px !important;
                padding-right: 0px !important;
                padding-left: 65px !important;
                padding-bottom: 0px !important;
            }
            .table-marketing,
            .table-debitur{
                margin: 0px !important;
            }

            .table-marketing td,
            .table-debitur td,
            .tr-detail .table-debitur td{
                padding: .75rem !important;
            }
            .table-marketing{
                margin-left: 50px !important;
            }
            tr .shown:first-child{
                border-bottom: none !important;
            }

            .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active,
            .sidebar-light-primary .nav-sidebar>.nav-item>.nav-link.active {
                background-color: rgb(249 115 22);
                color: #fff;
            }
            .table-modal-simulasi td{
                padding: 8px !important;
            }
            #modal-content{
                background-color: #fff;
            }
            @media(max-width: 991px) {
                div.dataTables_scrollBody>table>tbody td,
                table.dataTable th{
                    left:0px !important;
                    position: relative !important;
                }
            }
            .map {
                width: 100%;
                height: 400px;
                z-index: 1;
            }
        </style>
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper" id="body">
            <!-- Navbar -->
            @include('layouts.partials.navbar')
            <!-- /.navbar -->
            <!-- Main Sidebar Container -->
            @include('layouts.partials.sidebar')
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                @yield('breadcrumb')
                <!-- /.content-header -->
                <!-- Main content -->
                <div class="content" id="main-content">
                    <div class="container-fluid">
                        @include('layouts.partials.alert')
                        @yield('content')
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
            <!-- Main Footer -->
            @include('layouts.partials.footer')
            @include('layouts.partials.delete')
        </div>
        <div class="modal fade bd-example-modal-xl" id="modalViewFile" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
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
                    <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div> -->
                </div>
            </div>
        </div>

        <!-- REQUIRED JS SCRIPTS -->
        <!-- jQuery 2.1.3 -->
        <script src="{{ asset ("/bower_components/admin-lte/plugins/jquery/jquery.min.js") }}"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="{{ asset ("/bower_components/admin-lte/plugins/jquery-ui/jquery-ui.min.js") }}"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="{{ asset ("/bower_components/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js") }}" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset ("/bower_components/admin-lte/dist/js/adminlte.min.js") }}" type="text/javascript"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <!-- daterangepicker -->
        <script src="{{ asset ("/bower_components/admin-lte/plugins/moment/moment.min.js") }}"></script>
        <script src="{{ asset ("/bower_components/admin-lte/plugins/inputmask/jquery.inputmask.min.js") }}"></script>
        <script src="{{ asset ("/bower_components/admin-lte/plugins/daterangepicker/daterangepicker.js") }}"></script>

        <script src="{{ asset ("/bower_components/admin-lte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js") }}"></script>
        <script>
            $.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- DataTables  & Plugins -->
        <script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
        <script src="{{ asset ("/bower_components/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js") }}"></script>
        <script src="{{ asset ("/bower_components/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js") }}"></script>
        <script src="{{ asset ("/bower_components/admin-lte/plugins/datatables-fixedcolumns/js/dataTables.fixedColumns.min.js") }}"></script>
        <script src="{{ asset ("/bower_components/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js") }}"></script>
        <script src="{{ asset ("/bower_components/admin-lte/plugins/datatables-buttons/js/dataTables.buttons.min.js") }}"></script>
        <script src="{{ asset ("/bower_components/admin-lte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js") }}"></script>
        
        <!-- Leaflet JS -->
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" 
                integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" 
                crossorigin=""></script>
        <script src="{{asset('assets/scripts/leaflet-map.js')}}"></script>
        s/pdfmake/pdfmake.min.js") }}"></script>
        <script src="{{ asset ("/bower_components/admin-lte/plugins/pdfmake/vfs_fonts.js") }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ asset ('/bower_components/admin-lte/plugins/select2/js/select2.full.min.js') }}"></script>
        <script>
            $(function () {
                $(document).on('click', '.btn-modal-delete', function(e) {
                    e.preventDefault();
                    var url = jQuery(this).attr('href');
                    $('#destroy').attr('action', url );
                    $('#import').attr( 'method', 'delete' );
                    $('#delete-modal').modal('show');
                })


                $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

                $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                });

                $.validator.setDefaults({
                    submitHandler: function () {
                    alert( "Form successful submitted!" );
                    }
                });

                $('#quickForm').validate({
                    rules: {
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                        minlength: 5
                    },
                    terms: {
                        required: true
                    },
                    },
                    messages: {
                    email: {
                        required: "Please enter a email address",
                        email: "Please enter a valid email address"
                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 5 characters long"
                    },
                    terms: "Please accept our terms"
                    },
                    errorElement: 'span',
                    errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                    },
                    highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                    },
                    unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                    }
                });

                $('input[type=number]').on('keydown' , (event)=>{
                    let key = event.key;
                    let value = event.target.value;
                    console.log('KEY', key)
                    console.log('VALUE', value)
                    let new_value = parseInt(value + key);
                    console.log('NEW VALUE', new_value)
                    let max = Number(event.target.max);
                    let min = Number(event.target.min);
                    console.log('MAX', max)
                    console.log('MIN', min)
                    if(max > 0 ){
                        if(new_value > max){
                            event.preventDefault();
                        }
                    }

                });

                $('.currency-mask').on('keydown' , (event)=>{
                    let key = event.key;
                    let value = event.target.value;
                    let new_value = parseInt(value).toString()+key;
                    let max = Number(event.target.max);
                    let min = Number(event.target.min);
                    if(max > 0 ){
                        if(parseInt(new_value) > max){
                            event.preventDefault();
                        }
                    }

                });

                $(".currency-mask").inputmask("currency", {
                    radixPoint: ',',
                    suffix:"",
                    prefix:'Rp. ',
                    autoUnmask: true,
                    max:$(this).attr('max')
                });
                $(".date-mask").inputmask({ "mask": "99-99-9999", 'autoUnmask' : true});

                $('.currency-mask-2').on('keydown' , (event)=>{
                    let key = event.key;
                    let value = event.target.value;
                    let new_value = parseInt(value).toString()+key;
                    let max = Number(event.target.max);
                    let min = Number(event.target.min);
                    if(max > 0 ){
                        if(parseInt(new_value) > max){
                            event.preventDefault();
                        }
                    }

                });

                $(".currency-mask-2").inputmask("currency", {
                    radixPoint: ',',
                    suffix:"",
        
                    max:$(this).attr('max')
                });
            });
        </script>
        <!-- jquery-validation -->
        <script src="{{ asset ("/bower_components/admin-lte/plugins/jquery-validation/jquery.validate.min.js") }}"></script>
        <script src="{{ asset ("/bower_components/admin-lte/plugins/jquery-validation/additional-methods.min.js") }}"></script>
        <script src="{{ asset ("/bower_components/admin-lte/plugins/sweetalert2/sweetalert2.all.min.js") }}"></script>
        @stack('script')

    </body>
</html>
