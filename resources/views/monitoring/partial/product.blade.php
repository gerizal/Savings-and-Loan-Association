<div class="header text-center ">
    <div class="brand-logo">
        <img src="{{public_path('img/logo_kpf.jpg')}}" alt="" style="width:60px; height:60px; margin:0px"/>
        <h3 style="margin-bottom:5px;">ANALISA PEHITUNGAN</h3>
        <span >Produk : {{$product['name']}}</span>
    </div>
</div>
<div class="body mt-15">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="tb-finance">
                    <thead>
                        <tr>
                            <th colspan="3" class="bg-yellow br-r">Data Pembiayaan</th>
                            <th style="border:none"></th>
                            <th colspan="3" class="bg-yellow br-l">Detail Pembiayaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td class="text-right br-r">{{$taspen['name']}}</td>
                            <td style="border:none"></td>
                            <td class="br-l">Biaya Administrasi</td>
                            <td >:</td>
                            <td  class="text-right">{{formatIDR($administration_fee)}}</td>
                        </tr>
                        <tr>
                            <td>Nopen</td>
                            <td>:</td>
                            <td class="text-right br-r" >{{$taspen['nopen']}}</td>
                            <td style="border:none"></td>
                            <td class="br-l">Biaya Tatalaksana </td>
                            <td>:</td>
                            <td class="text-right" >{{formatIDR($management_fee)}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Lahir</td>
                            <td>:</td>
                            <td class="text-right br-r" >{{$taspen['birth_date']}}</td>
                            <td style="border:none"></td>
                            <td class="br-l">Biaya Asuransi</td>
                            <td>:</td>
                            <td class="text-right" >{{formatIDR($insurance_fee)}}</td>
                        </tr>
                        <tr>
                            <td>Usia Masuk</td>
                            <td>:</td>
                            <td class="text-right br-r" >{{$enter_age}}</td>
                            <td style="border:none"></td>
                            <td class="br-l">Biaya Buka Rekening</td>
                            <td>:</td>
                            <td class="text-right" >{{formatIDR($account_opening_fee)}}</td>
                        </tr>
                        <tr>
                            <td>Usia Lunas</td>
                            <td>:</td>
                            <td class="text-right br-r" >{{$paid_age}}</td>
                            <td style="border:none"></td>
                            <td class="br-l">Biaya Provisi</td>
                            <td>:</td>
                            <td class="text-right" >{{formatIDR($provision_fee)}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Lunas</td>
                            <td>:</td>
                            <td class="text-right br-r" >{{$paid_date}}</td>
                            <td style="border:none"></td>
                            <td width="150px" class="br-l">Biaya Materai</td>
                            <td>:</td>
                            <td class="text-right" >{{formatIDR($stamp_fee)}}</td>
                        </tr>
                        <tr>
                            <td>Gaji Bersih</td>
                            <td>:</td>
                            <td class="text-right br-r" >{{formatIDR($salary)}}</td>
                            <td style="border:none"></td>
                            <td class="br-l">Biaya Data Informasi</td>
                            <td>:</td>
                            <td class="text-right" >{{formatIDR($information_fee)}}</td>
                        </tr>
                        <tr>
                            <td>Produk Pembiayaan</td>
                            <td>:</td>
                            <td class="text-right br-r" >{{$product['name']}}</td>
                            <td style="border:none"></td>
                            <td class="br-l">Retensi Angsuran</td>
                            <td>:</td>
                            <td class="text-right" >0</td>
                        </tr>
                        <tr>
                            <td>Jenis Pembiayaan</td>
                            <td>:</td>
                            <td class="text-right br-r" >{{$finance_type['name']}}</td>
                            <td style="border:none"></td>
                            <td class="br-l">Blokir Angsuran {{$block_installment}}x</td>
                            <td>:</td>
                            <td class="text-right" >{{formatIDR($blockir_fee)}}</td>
                        </tr>
                        <tr>
                            <td>Tenor</td>
                            <td>:</td>
                            <td class="text-right br-r" >{{$tenor}}</td>
                            <td style="border:none"></td>
                            <td class="br-l">Terima Kotor</td>
                            <td>:</td>
                            <td class="text-right" >{{formatIDR($gross_amount)}}</td>
                        </tr>
                        <tr>
                            <td>Plafond</td>
                            <td>:</td>
                            <td class="text-right br-r" >{{formatIDR($plafon)}}</td>
                            <td style="border:none"></td>
                            <td class="br-l">BPP</td>
                            <td>:</td>
                            <td class="text-right" >{{formatIDR($bpp_fee)}}</td>
                        </tr>
                        <tr>
                            <td>Angsuran</td>
                            <td>:</td>
                            <td class="text-right br-r" >{{formatIDR($installment)}}</td>
                            <td style="border:none"></td>
                            <td class="br-l">Pelunasan</td>
                            <td>:</td>
                            <td class="text-right" >{{formatIDR($installment)}}</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td class="text-right br-r" >&nbsp;</td>
                            <td style="border:none"></td>
                            <td class="br-l">Terima Bersih</td>
                            <td>:</td>
                            <td class="text-right" >{{formatIDR($net_amount)}}</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td class="text-right br-r" >&nbsp;</td>
                            <td style="border:none" style="border-top:none; border-bottom:none"></td>
                            <td class="br-l">Sisa Gaji</td>
                            <td>:</td>
                            <td class="text-right" >{{formatIDR($rest_salary)}}</td>
                        </tr>
                    </tbody>
                </table>
                <br/>
                    <p>
                        <b>Keterangan:</b>
                        <ol style="padding-left:20px;">
                            <li class="text-justity">
                                Memberikan Kuasa kepada BANK untuk mentransfer dana realisasi pembiayaan ke rekening Koperasi Pemasaran Fadillah (KPF) di Bank.
                            </li>
                            <li class="text-justity">
                                Menyatakan telah menerima fasilitas Pembiayaan BANK melalui Koperasi Pemasaran Fadillah (KPF) selaku kuasa BANK sebesar Pokok Pembiayaan
                                tersebut di atas dengan cara pembayaran : Transfer ke Rekening / Tunai.
                            </li>
                        </ol>
                    </p>
            </div>
        </div>
    </div>
</div>
<div class="page-break"></div>
