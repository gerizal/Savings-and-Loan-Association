<div class="row">
    <div class="col-md-12">
        <div class="header">
            <div class="brand-flex left-logo">
                @if ($bank['logo']!='')
                    <img src="{{$bank['logo']}}" alt="" style="width:60px; height:60px; margin:0px" class="pull-left"/>
                @endif
            </div>
            <div  class="brand-flex" style="width:60%">
                <h3 style="margin-bottom:5px;" class="text-center">BUKTI PENCAIRAN PEMBIAYAAN</h3>
            </div>
            <div  class="brand-flex right-logo">
                <div class="brand-logo pull-right text-center">
                    <img src="{{public_path('img/logo_kpf.jpg')}}" alt="" style="width:60px; height:60px; margin:0px"/>
                    <h3 style="margin-bottom:-25px;">{{$bank['code']}}</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table>
            <tr>
                <td>Nama</td><td>: {{$taspen['name']}}</td>
            </tr>
            <tr>
                <td>Nopen</td><td>: {{$taspen['nopen']}}</td>
            </tr>
            <tr>
                <td>Kantor Bayar Pensiun</td><td>: {{$destination_paymaster}}</td>
            </tr>
        </table>
        <p><p>RINCIAN PENERIMAAN PEMBIAYAAN</p></p>
        <table>
            <tr>
                <td>Pokok Pembiayaan</td><td>: {{$taspen['name']}}</td>
            </tr>
            <tr>
                <td>Biaya Administrasi</td><td>: {{formatIDR($administration_fee)}}</td>
            </tr>
            <tr>
                <td>Biaya Asuransi</td><td>: {{formatIDR($insurance_fee)}}</td>
            </tr>
            <tr>
                <td>Biaya Pembukaan Rekening</td><td>: {{formatIDR($account_opening_fee)}}</td>
            </tr>
            <tr>
                <td>Biaya Materai</td><td>: {{formatIDR($stamp_fee)}}</td>
            </tr>
            <tr>
                <td>Biaya Lain-lain</td><td>: {{formatIDR($other_fee)}}</td>
            </tr>
            <tr>
                <td>Penerimaan Bersih</td><td>: {{formatIDR($net_amount)}} - ({{ucwords(numToWords($net_amount))}})</td>
            </tr>
            <tr>
                <td>Margin Efektif</td><td>: {{(float)$interest}}%</td>
            </tr>
            <tr>
                <td>Jangka Waktu</td><td>: {{$tenor}} Bulan</td>
            </tr>
            <tr>
                <td>Total Angsuran</td><td>: {{formatIDR($installment)}} - ({{ucwords(numToWords($installment))}} )</td>
            </tr>
        </table>
        <p class="text-justity">Menyatakan telah menerima fasilitas Pembiayaan {{$bank['name']}} melalui Koperasi Pemasaran Fadillah sebesar tersebut di atas melalui BANK
    Transfer ke rekening Debitur.</p>
        <table>
            <tr><td>Dibuat Di &emsp;</td><td>: {{$branch['name']}}</td></tr>
            <tr><td>Tanggal</td><td>: {{date('d-M-Y', strtotime($contract_date))}}</td></tr>
        </table>
        <table  class="text-center align-top tb-sign" style="width: 100%;">
            <tr>
                <td style="padding:25px 100px;">
                    <div>
                        <span>Diterima Oleh</span>
                    </div>
                    <div class="stamp-box">
                        <span>&nbsp;</span>
                    </div>
                    <div>
                        <span>{{$taspen['name']}}</span>
                    </div>
                    <div class="br-t">
                        <span>Debitur</span>
                    </div>
                </td>
                <td style="padding:25px 100px;">
                    <div>
                        <span>Diperiksa Oleh</span>
                    </div>
                    <div class="stamp-box">
                        <span>&nbsp;</span>
                    </div>
                    <div>
                        <span>-----------</span>
                    </div>
                    <div class="br-t">
                        <span>Kepala Unit Pelayanan</span>
                    </div>
                </td>
            </tr>
            <tr></tr>
            <tr>
                <td style="padding:25px 100px;">
                    <div>
                        <span>Diperiksa Oleh</span>
                    </div>
                    <div class="stamp-box">
                        <span>&nbsp;</span>
                    </div>
                    <div>
                        <span>{{env('APP_FINANCE_MANAGER')}}</span>
                    </div>
                    <div class="br-t">
                        <span>Manajer Keuangan</span>
                    </div>
                </td>
                <td style="padding:25px 100px;">
                    <div>
                        <span>Diotorisasi Oleh</span>
                    </div>
                    <div class="stamp-box">
                        <span>&nbsp;</span>
                    </div>
                    <div>
                        <span>{{env('APP_DIRECTUR')}}</span>
                    </div>
                    <div class="br-t">
                        <span>{{env('APP_POSITION')}}</span>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="page-break"></div>
