{{-- <div class="header text-center ">
    <div class="brand-logo">
        <img src="{{public_path('img/logo_kpf.jpg')}}" alt="" style="width:60px; height:60px; margin:0px"/>
        <h3 style="margin-bottom:5px;">SURAT PERNYATAAN</h3>
        <h3 style="margin-bottom:5px;">PERIHAL : PEMOTONGAN GAJI DIATAS 70%</h3>
    </div>
</div> --}}
<div class="row">
    <div class="col-md-12">
        <div class="header">
            <div class="brand-flex left-logo">
            </div>
            <div  class="brand-flex" style="width:60%">
                <h3 class="text-center" style="margin-bottom:5px;">SURAT PERNYATAAN</h3>
                <h3 class="text-center" style="margin-bottom:5px;">PERIHAL : PEMOTONGAN GAJI DIATAS 70%</h3>
            </div>
            <div  class="brand-flex right-logo">
                {{-- <img src="{{public_path('img/logo_kpf.jpg')}}" alt="" style="width:60px; height:60px; margin:0px" class="pull-right"/> --}}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <p>Yang bertanda tangan dibawah ini :</p>
        <table>
            <tr><td>Name &emsp;&emsp;</td><td>: {{$taspen['name']}}</td></tr>
            <tr><td>Nopen&emsp;&emsp;</td><td>: {{$taspen['nopen']}}</td></tr>
            <tr><td>No KTP&emsp;&emsp;</td><td>: {{$taspen['id_number']}}</td></tr>
            <tr><td>Alamat&emsp;&emsp;</td><td>: {{$taspen['complete_address']}}</td></tr>
        </table>
        <p>Sehubungan saya memerlukan dana yang cukup besar, dengan ini saya menyatakan :</p>
        <p><ol style="list-style: decimal;">
            <li>Bersedia membayar angsuran pembiayaan BANK diatas 70% gaji pensiun yang saya terima setiap bulan, karena :
                <ol style="list-style: lower-alpha;">
                    <li>
                    Saya memiliki penghasilan tetap dari usaha diluar gaji pensiun.*)
                    </li>
                    <li>
                    Saya mendapat tunjangan dari keluarga (anak-anak) setiap bulan yang jumlahnya dapat menutupi kekurangan jika sisa gaji pensiun tidak mencukupi
        untuk kebutuhan sehari-hari.*)
                    </li>
                </ol>
            </li>
            <li>Saya bertanggung jawab atas pengambilan sisa gaji saya setiap bulannya di Kantor Bayar Gaji yang ditunjuk oleh Koperasi Pemasaran Fadillah.
        Demikian surat pernyataan ini dibuat dengan sebenarnya dengan dilandasi itikad baik tanpa paksaan dari siapapun dan pihak manapun.</li>
        </ol></p>
        <p class="text-right"><b>{{$branch['name']}}, {{date('d-M-Y', strtotime($contract_date))}}</b></p>
        <table class="text-center align-top tb-sign" style="width: 100%;">
            <tr>
                <td style="padding:25px 50px;">
                    <div>
                        <span>&nbsp;</span>
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
                <td style="padding:25px 50px;">
                    <div>
                        <span>&nbsp;</span>
                    </div>
                    <div class="stamp-box">
                        <span>&nbsp;</span>
                    </div>
                    <div>
                        <span>------------</span>
                    </div>
                    <div  class="br-t">
                        <span>SPV Kantor Layanan</span>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="page-break"></div>
