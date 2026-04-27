<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
        <meta content="charset=utf-8"/>
        <style>
            body{
                font-size: 10pt;
            }

            .br-l{
                border: none;
                border-left: 1px solid #000 !important;
            }
            .br-r{
                border: none;
                border-right: 1px solid #000 !important;
            }
            .br-t{
                border: none !important;
                border-top: 1px solid #000 !important;
            }
            .br-b{
                border: none !important;
                border-bottom: 1px solid #000 !important;
            }
            .page-break {
                page-break-after: always;
            }
            *, ::after, ::before{
                box-sizing: border-box;
            }
            .container {
                padding-right: 15px;
                padding-left: 15px;
                margin-right: auto;
                margin-left: auto;
            }
            .row {
                /* display: flex; */
                /* -ms-flex-wrap: wrap; */
                /* flex-wrap: wrap; */
                margin-right: -7.5px;
                margin-left: -7.5px;
            }
            .col-md-4 {
                float: left;
                position: relative;
                width: 33.3%;
                padding-right: 7.5px;
                padding-left: 7.5px;
                max-width: 33.33%;
            }
            .col-md-6 {
                float: left;
                position: relative;
                width: 50%;
                padding-right: 7.5px;
                padding-left: 7.5px;
                max-width: 50%;
            }
            .col-md-12 {
                float: left;
                position: relative;
                width: 100%;
                padding-right: 7.5px;
                padding-left: 7.5px;
                max-width: 100%;
            }
            .text-right {
                text-align: right !important;
            }

            .text-center {
                text-align: center !important;
            }

            .text-left {
                text-align: left !important;
            }

            .text-justify {
                text-align: justify;
            }
            table {
                border-collapse: collapse;
                width: 100%;
            }
            .bg-yellow{
                background-color: #f9a61d;
            }

            .tb-finance{
                width: 100%;
            }

            .tb-finance th {
                border: 1px solid #000;
                padding: 10px;
            }

            .tb-finance tr td:first-child {
                border-left: 1px solid #000;
            }

            .tb-finance tr td:last-child {
                border-right: 1px solid #000;

            }
            .tb-finance tr:last-child td {
                border-bottom: 1px solid #000;
            }
            .tb-finance td {
                padding: 2px 5px;
            }

            .tb-finance tbody{
                font-size: 10pt;
            }

            .tb-installment{
                font-size: 10pt;
                width: 100%;
                display: table;
                table-layout: fixed;
            }

            .tb-installment th{
                border: 1px solid #000;
                padding: 10px;
            }
            .tb-installment td{
                border: 1px solid #000;
                padding: 5px;
            }

            .tb-head-installment {
                margin-bottom: 15px;
            }
            .tb-head-installment tr td:first-child{
                padding-right: 10px;
                /* padding-top: 3px; */
                /* padding-bottom: 3px; */
            }
            .tb-head-installment tr td:last-child{
                padding-left: 5px;
                /* padding-top: 3px; */
                /* padding-bottom: 3px; */
            }

            .sign-box{
                height: 80px;
                width: 150px;
                border: 1px solid #000;
                margin-top:5px;
                margin-bottom:5px;
            }
            .sign-box-m{
                height: 65px;
                width: 150px;
                border: 1px solid #000;
            }

            .text-10{
                font-size: 10pt;
            }

            .mt-15{
                margin-top: 15px;
            }

            .align-top td {
                vertical-align: top;
            }

            .br-t{
                border-top: 1px solid #000;
            }
            .br-b{
                border-bottom: 1px solid #000;
            }
            .br-l{
                border-left: 1px solid #000;
            }
            .br-r{
                border-right: 1px solid #000;
            }

            .tb-sign tr td{
                padding: 25px 25px;
                width: 33.33%;
                height:200px;
                /* border:1px solid #000; */
            }

            .tb-sign tr td div:first-child{
                height: 50px;
            }
            .stamp-box{
                margin-top: 25px;
                margin-bottom: 25px;
                height: 50px;
            }
            .stamp-box-m{
                margin-top: 25px;
                margin-bottom: 25px;
                height: 30px;
            }
            .tb-bordered tr th{
                border:1px solid #000;
            }
            .tb-bordered tr td{
                border:1px solid #000;
            }

            .chapter{
                margin-bottom: 5px;
            }
            h4{
                margin-top: 10px !important;
                margin-bottom: 10px !important;
            }
            p{
                margin-top: 10px;
            }


            .header{
                position: relative;
                width: 60px;
                display: block;
                padding-top: 8px;
                padding-left: 8px;
                padding-right: 8px;
                padding-bottom: 8px;
                width: 100%;
                margin-bottom: 25px;
            }
            .header img{
                float: left;
                line-height: .8;
                margin-left: 0px;
                margin-right: 30px;
            }

            .header span{
                line-height: 18px;
                font-size: 18px;
            }
        </style>
    </head>
    <body style="margin: 0;">
        <div>
            <div class="header">
                <img src="{{public_path('img/logo_kpf.jpg')}}" alt="" style="width:60px; height:60px; margin:0px"/>
                <!-- <img src="{{asset('img/logo_kpf.jpg')}}" alt="" style="width:60px; height:60px;"/> -->
                <span><h3>Koperasi Pemasaran Fadillah</h3></span>
            </div>
            <div class="body mt-15">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <table>
                                <tr><td width="80">No</td><td>: {{$data['number']}}</td></tr>
                                <tr><td>Lampiran &nbsp;&nbsp;</td><td>: {{$data['debitur']}} ({{numToWords($data['debitur'])}}) Dafar Permohonan Dropping</td></tr>
                                <tr><td>Perihal</td><td>: Permohonan Dropping Dana Pembiayaan Pensiun Periode Bulan {{$data['month']}} Tahun {{$data['year']}}</td></tr>
                            </table>
                            <p>
                            Kepada Yth<br/>
                            Direktur<br/>
                            <b>{{$data['receiver_name']}}</b><br/>
                            Di tempat
                            </p>
                            <p class="text-justify">
                            Bersama surat ini kami ajukan permohonan pencairan dan pemindahbukuan atas pengajuan yang sudah disetujui oleh komite bank. Adapun rekap dropping tersebut kami sampaikan sebagai berikut :
                            </p>
                            <table>
                                <tr><td width="5">1.&nbsp;</td><td width="270">Jumlah Debitur</td><td>: {{$data['debitur']}}</td></tr>
                                <tr><td>2.&nbsp;</td><td>Jumlah PLafond</td><td>: {{$data['plafond']}}</td></tr>
                                <tr><td>3.&nbsp;</td><td>Dropping Ke Rek. KOPERASI PEMASARAN</td><td>: {{$data['dropping']}}</td></tr>
                            </table>
                            <p>
                            Rincian data kami lampirkan bersama dengan surat ini.<br/>Dana tersebut pada butir 2. diatas mohon dapat disetorkan / ditransfer kepada kami di :
                            </p>
                            <table>
                                <tr><td width="100">No Rekening</td><td>: {{$data['account_number']}}</td></tr>
                                <tr><td>Atas Nama</td><td>: {{$data['account_name']}}</td></tr>
                                <tr><td>Nama Bank</td><td>: {{$data['bank_name']}}</td></tr>
                            </table>
                            <p>
                            Demikian kami sampaikan dan atas perhatian serta kerjasama yang terjalin baik selama ini diucapkan terima kasih.
                            </p>
                            <p>{{$data['place_date']}}</p>
                            <table class="text-center" style="width:200px">
                                <tr>
                                    <td>A.N. PENGURUS</td>
                                </tr>
                                <tr>
                                    <td height="100"></td>
                                </tr>
                                <tr>
                                    <td style="border-bottom:1px solid #000">{{$data['operational_chief']}}</td>
                                </tr>
                                <tr>
                                    <td>Kepala Operasional</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-break"></div>
            <div class="header">
                <img src="{{public_path('img/logo_kpf.jpg')}}" alt="" style="width:60px; height:60px; margin:0px"/>
                <!-- <img src="{{asset('img/logo_kpf.jpg')}}" alt="" style="width:60px; height:60px;"/> -->
                <span><h3>Koperasi Pemasaran Fadillah</h3></span>
            </div>
            <div class="body mt-15">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <table>
                                <tr><td width="100"><b>No Surat</b></td><td>: {{$data['number']}}</td></tr>
                                <tr><td><b>No Rekening</b> &nbsp;&nbsp;</td><td>: {{$data['account_number']}}</td></tr>
                                <tr><td><b>Atas Nama</b> &nbsp;&nbsp;</td><td>: {{$data['account_name']}}</td></tr>
                                <tr><td><b>Nama Bank</b> &nbsp;&nbsp;</td><td>: {{$data['bank_name']}}</td></tr>
                            </table>
                            <table class="tb-installment" style="margin-top:30px;width:110%;font-size:11px;margin-left:-45px;">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="15px" style="padding-left:0px;padding-right:0px;">No</th>
                                        <th>Nopen</th>
                                        <th>Nama Debitur</th>
                                        <th>Jenis Produk</th>
                                        <th>Plafond</th>
                                        <th>Adm Bank</th>
                                        <th>Biaya Layanan Kredit</th>
                                        <th>Bunga GP</th>
                                        <th>Blokir Angsuran</th>
                                        <th>Dropping Koperasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['applications'] as $num => $application)
                                        <tr>
                                            <td class="text-center">{{$num+1}}</td>
                                            <td>{{$application['nopen']}}</td>
                                            <td>{{$application['debitur']}}</td>
                                            <td>{{$application['type']}}</td>
                                            <td class="text-right">{{$application['plafond']}}</td>
                                            <td class="text-right">{{$application['adm_fee']}}</td>
                                            <td class="text-right">{{$application['service_fee']}}</td>
                                            <td class="text-right">{{$application['interest']}}</td>
                                            <td class="text-right">{{$application['block_installment']}}</td>
                                            <td class="text-right">{{$application['dropping']}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" class="text-center">Total</th>
                                        <th>{{$data['total_plafond']}}</th>
                                        <th>{{$data['total_adm_fee']}}</th>
                                        <th>{{$data['total_service_fee']}}</th>
                                        <th></th>
                                        <th>{{$data['total_block_installment']}}</th>
                                        <th>{{$data['total_dropping']}}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <p>&nbsp;</p>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="text-center" style="width:200px">
                                <tr>
                                    <td>Diproses Oleh</td>
                                </tr>
                                <tr>
                                    <td height="100"></td>
                                </tr>
                                <tr>
                                    <td style="border-bottom:1px solid #000">{{$data['operational_chief']}}</td>
                                </tr>
                                <tr>
                                    <td>Kepala Operasional</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="text-center" style="width:200px; float:right">
                                <tr>
                                    <td>Diperiksa Oleh</td>
                                </tr>
                                <tr>
                                    <td height="100"></td>
                                </tr>
                                <tr>
                                    <td style="border-bottom:1px solid #000">{{$data['finance_manager']}}</td>
                                </tr>
                                <tr>
                                    <td>Manajer Keuangan</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
