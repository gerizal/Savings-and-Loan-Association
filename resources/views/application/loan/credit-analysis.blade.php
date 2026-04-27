<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
        <meta content="charset=utf-8"/>
        <style>
            @page { margin: 0px; }
            body { margin: 0px; }
            .row {
                /* margin-right: -15px;
                margin-left: -15px; */
                width:720px;
            }

            .row:before,
            .row:after{
                display: table;
                content: " ";
            }
            .row:after{
                clear: both;
            }

            .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
                position: relative;
                min-height: 1px;
                /* padding-right: 15px;
                padding-left: 15px; */
            }

            .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12 {
                float: left;
            }
            .col-md-12 {
                width: 100%;
            }
            .col-md-11 {
                width: 91.66666667%;
            }
            .col-md-10 {
                width: 83.33333333%;
            }
            .col-md-9 {
                width: 75%;
            }
            .col-md-8 {
                width: 66.66666667%;
            }
            .col-md-7 {
                width: 58.33333333%;
            }
            .col-md-6 {
                width: 50%;
            }
            .col-md-5 {
                width: 41.66666667%;
            }
            .col-md-4 {
                width: 33.33333333%;
            }
            .col-md-3 {
                width: 25%;
            }
            .col-md-2 {
                width: 16.66666667%;
            }
            .col-md-1 {
                width: 8.33333333%;
            }

            .container {
                padding-right: 35px;
                padding-left: 35px;
                margin-right: auto;
                margin-left: auto;
            }

            body{
                font-size: 10pt;
            }


            *, ::after, ::before{
                box-sizing: border-box;
            }

            table {
                border-collapse: collapse;
                width: 100%;
                margin: 0px;
            }


            .stamp-box{
                margin-top: 5px;
                margin-bottom: 5px;
                height: 80px;
                border: 1px solid #000;
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
            }

            .text-left {
            text-align: left;
            }
            .text-right {
            text-align: right;
            }
            .text-center {
            text-align: center;
            }
            .text-justify {
            text-align: justify;
            }
            .text-nowrap {
            white-space: nowrap;
            }
            .text-lowercase {
            text-transform: lowercase;
            }
            .text-uppercase {
            text-transform: uppercase;
            }
            .text-capitalize {
            text-transform: capitalize;
            }
            .text-muted {
            color: #777;
            }
            .text-primary {
            color: #337ab7;
            }

            .section{
                padding: 15px;
                border: 1px solid #000;
            }

            .notes{
                padding: 15px;
                border: 1px solid #000;
            }

            .notes-box{
                margin-top: 5px;
                margin-bottom: 5px;
                height: 80px;
                border: 1px solid #000;
            }

            .mt5{
                margin-top: 5px;
            }
            .mb5{
                margin-bottom: 5px;
            }
            .mt10{
                margin-top: 10px;
            }
            .hr-full{
                margin-right: -15px;
                margin-left: -15px;
            }

            p{
                margin-top: 10px;
                margin-bottom: 10px;
            }

            .border-right-none{
                border-right: none;
            }
        </style>
    </head>
    <body style="margin: 0;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="header text-center">
                        <h3>
                            MEMORANDUM ANALISA DAN USULAN KREDIT<br/>
                            KREDIT BARU / TAMBAHAN / PERPANJANGAN / RESTRUKTUR<br/>
                            No. ...... MK/KPF/PP/{{date('m/Y')}}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="section">
                        <div class="sub-section">
                            <table>
                                <tr>
                                    <td  width="150">Nama</td>
                                    <td>: {{$taspen['name']}}</td>
                                </tr>
                                <tr>
                                    <td>Tempat, Tanggal Lahir</td>
                                    <td>: {{ucwords($taspen['birth_place'])}}, {{$taspen['birth_date']}}</td>
                                </tr>
                                <tr>
                                    <td>Status Kawin</td>
                                    <td>: {{$taspen['marital_status']}}</td>
                                </tr>
                                <tr>
                                    <td>No KTP</td>
                                    <td>: {{$taspen['id_number']}}</td>
                                </tr>
                                <tr>
                                    <td>No NPWP</td>
                                    <td>: {{$taspen['tax_number']}}</td>
                                </tr>
                                <tr>
                                    <td valign="top">Alamat KTP</td>
                                    <td>: {{$taspen['complete_address']}}</td>
                                </tr>
                                <tr>
                                    <td valign="top">Alamat Domisili</td>
                                    <td>: {{$taspen['domicile']['complete_address']}}</td>
                                </tr>
                                <tr>
                                    <td>Nama Ibu Kandung</td>
                                    <td>: {{$taspen['mother_name']}}</td>
                                </tr>
                                <tr>
                                    <td>No Telepon/HP</td>
                                    <td>: {{$taspen['phone_number']}}</td>
                                </tr>
                                <tr>
                                    <td>No KTP</td>
                                    <td>: </td>
                                </tr>
                            </table>
                        </div>
                        <hr class="hr-full"/>
                        <div class="sub-section">
                            <table>
                                <tr>
                                    <td colspan="2"  class="text-center"><b>PENDAPATAN/PENGELUARAN/BULAN</b></td>
                                </tr>
                                <tr>
                                    <td  width="150">Pendapatan</td>
                                    <td>: {{formatIDR($salary)}}</td>
                                </tr>
                                <tr>
                                    <td>Angsuran Channeling KPF</td>
                                    <td>: {{formatIDR($installment)}}</td>
                                </tr>
                                <tr>
                                    <td>Fee Collection KPF</td>
                                    <td>: {{formatIDR(60000)}}</td>
                                </tr>
                            </table>
                        </div>
                        <hr class="hr-full"/>
                        <div class="sub-section">
                            <table>
                                <tr>
                                    <td colspan="2"  class="text-center"><b>JAMINAN</b></td>
                                </tr>
                                <tr>
                                    <td width="150">No SK Pensiun</td>
                                    <td>: {{$taspen['skep_number']}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="section">
                        <div class="sub-section">
                            <table>
                                <tr>
                                    <td  width="150">Nama</td>
                                    <td>: {{$spouse['name']}}</td>
                                </tr>
                                <tr>
                                    <td>Tempat, Tanggal Lahir</td>
                                    <td>: {{ucwords($spouse['birth_place'])}}, {{$spouse['birth_date']}}</td>
                                </tr>
                                <tr>
                                    <td valign="top">Alamat KTP</td>
                                    <td>: {{$spouse['complete_address']}}</td>
                                </tr>
                                <tr>
                                    <td>No KTP</td>
                                    <td>: {{$spouse['id_number']}}</td>
                                </tr>
                                <tr>
                                    <td>Pekerjaan</td>
                                    <td>: {{$spouse['occupation']}}</td>
                                </tr>
                            </table>
                        </div>
                        <hr class="hr-full"/>
                        <div class="sub-section">
                            <p class="text-center"><b>TUJUAN PENGAJUAN PINJAMAN</b></p>
                            <p>Pemohon mengajukan pinjaman sebesar {{formatIDR($plafon)}} yang dipergunakan
                            untuk {{$purpose}}</p>
                        </div>
                        <hr class="hr-full"/>
                        <div class="sub-section">
                            <p class="text-center"><b>LATAR BELAKANG</b></p>
                            <p>Pemohon adalah Pensiunan TASPEN dengan data sbb : No Pensiun :
                            {{$taspen['nopen']}} No SK : {{$taspen['skep_number']}} Penerbit SK: {{$taspen['skep_publisher']}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="section mt5">
                        <p  class="text-center"><b>USULAN DAN REKOMENDASI</b></p>
                        <p>Mempertimbangkan hasil analisa dan data diatas maka kami mengusulkan kepada Komite Kredit untuk menyetujui Fasilitas kredit kepada calon debitur sebagai
                        berikut:</p>
                        <table>
                            <tr>
                                <td  width="150">Fasilitas</td>
                                <td>: Pinjaman {{$product['name']}}</td>
                                <td width="150">Asuransi Jiwa</td>
                                <td>: {{formatIDR($insurance_fee)}}</td>
                            </tr>
                            <tr>
                                <td>Jenis</td>
                                <td>: {{$interest_type=='flat' ? 'Angsuran Tetap':'Angsuran Berjangka'}}</td>
                                <td>Angsuran Channeling BPR</td>
                                <td>: {{formatIDR($installment)}}</td>
                            </tr>
                            <tr>
                                <td>Plafond</td>
                                <td>: {{formatIDR($plafon)}}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Jangka Waktu</td>
                                <td>: {{$tenor}}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Bunga</td>
                                <td>: {{$interest}}%</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Admin & Provisi</td>
                                <td>: {{formatIDR(($administration_fee+$provision_fee))}}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row mt5">
                <div class="col-md-3">
                    <div class="section text-center border-right-none">
                        <span>Diusulkan</span>
                        <div class="stamp-box"></div>
                        <span>Account Officer</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="section text-center border-right-none">
                        <span>Direkomendasikan</span>
                        <div  class="stamp-box"></div>
                        <span>Team Credit Review</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="section text-center border-right-none">
                        <span>Disetujui / Ditolak</span>
                        <div  class="stamp-box"></div>
                        <span>Wakil Ketua KK</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="section text-center">
                        <span>Disetujui / Ditolak</span>
                        <div  class="stamp-box"></div>
                        <span>Ketua Komite Kredit</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="section mt5">
                        <span>Catatan</span>
                        <div class="notes-box"></div>
                        <span>Kepada: Bagian Adm. Kredit<br/>
                        Mohon disiapkan pengikatan kredit ymk. pada tanggal:</span>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
