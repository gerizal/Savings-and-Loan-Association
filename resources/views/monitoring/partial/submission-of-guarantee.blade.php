<div class="row">
    <div class="col-md-12">
        <div class="header">
            <div class="brand-flex left-logo">
                @if ($bank['logo']!='')
                    <img src="{{$bank['logo']}}" alt="" style="width:60px; height:60px; margin:0px" class="pull-left"/>
                @endif
            </div>
            <div  class="brand-flex" style="width:60%">
                <h3 style="margin-bottom:5px;" class="text-center">TANDA TERIMA PENYERAHAN JAMINAN</h3>
            </div>
            <div  class="brand-flex right-logo">
                <img src="{{public_path('img/logo_kpf.jpg')}}" alt="" style="width:60px; height:60px; margin:0px" class="pull-right"/>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <table class="tb-head-installment">
            <tr><td>Nama &emsp;&emsp;</td><td>:{{$taspen['name']}}</td></tr>
            <tr><td>Nip/Nopen &emsp;&emsp;</td><td>:{{$taspen['nopen']}}</td></tr>
            <tr><td>Instansi &emsp;&emsp;</td><td>:</td></tr>
            <tr><td>Loket Bayar &emsp;&emsp;</td><td>:KANTOR POS</td></tr>
            <tr><td>Alamat &emsp;&emsp;</td><td>:</td></tr>
        </table>
    </div>
    <div class="col-md-6">
        <table class="tb-head-installment" style="width:100%">
            <tr>
                <td>
                    <div class="sign-box pull-right" style="padding: 10px; height:auto; width:100%">
                        Surat Keputusan Pensiun Asli<br/>
                        {{$taspen['skep_number']}}<br/>
                        Tertanggal, {{$taspen['skep_date']}}<br/>
                        Atas Nama: {{$taspen['name']}}
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table  class="text-center align-top" style="width: 100%;">
            <tr><td colspan="3" class="text-center" style="padding: 10px; height:20px">Diserahkan Tanggal</td></tr>
            <tr>
                <td style="width:250;height:50px; border:1px solid #000; padding: 5; margin: 0;">
                    <div style="padding: 0; margin: 0;">
                        <span>Debitur</span>
                    </div>
                    <div class="stamp-box-m">
                        <span>&nbsp;</span>
                    </div>
                    <div  style="padding: 0; margin: 0;">
                        <span>{{$taspen['name']}}</span>
                    </div>
                </td>
                <td style="width: auto"></td>
                <td style="width:250;height:50px; border:1px solid #000; padding: 5; margin: 0;">
                    <div  style="padding: 0; margin: 0;">
                        <span>Kepala Unit Pelayanan</span>
                    </div>
                    <div class="stamp-box-m">
                        <span>&nbsp;</span>
                    </div>
                    <div  style="padding: 0; margin: 0;">
                        <span>&nbsp;</span>
                    </div>
                </td>
            </tr>
            <tr><td colspan="3" class="text-center" style="padding: 10px; height:20px">Dikembalikan Tanggal</td></tr>
            <tr>
                <td style="width:250;height:50px; border:1px solid #000; padding: 5; margin: 0;">
                    <div>
                        <span>Debitur</span>
                    </div>
                    <div class="stamp-box-m">
                        <span>&nbsp;</span>
                    </div>
                    <div>
                        <span>{{$taspen['name']}}</span>
                    </div>
                </td>
                <td style="width: auto"></td>
                <td style="width:250;height:50px; border:1px solid #000; padding: 5; margin: 0;">
                    <div>
                        <span>Kepala Unit Pelayanan</span>
                    </div>
                    <div class="stamp-box-m">
                        <span>&nbsp;</span>
                    </div>
                    <div>
                        <span>&nbsp;</span>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
<hr style="border-top: 1px dashed"/>
<div class="row">
    <div class="col-md-12">
        <div class="header">
            <div class="brand-flex left-logo">
                @if ($bank['logo']!='')
                    <img src="{{$bank['logo']}}" alt="" style="width:60px; height:60px; margin:0px" class="pull-left"/>
                @endif
            </div>
            <div  class="brand-flex" style="width:60%">
                <h3 style="margin-bottom:5px;" class="text-center">TANDA TERIMA PENYERAHAN JAMINAN</h3>
            </div>
            <div  class="brand-flex right-logo">
                <img src="{{public_path('img/logo_kpf.jpg')}}" alt="" style="width:60px; height:60px; margin:0px" class="pull-right"/>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <table class="tb-head-installment">
            <tr><td>Nama &emsp;&emsp;</td><td>:{{$taspen['name']}}</td></tr>
            <tr><td>Nip/Nopen &emsp;&emsp;</td><td>:{{$taspen['nopen']}}</td></tr>
            <tr><td>Instansi &emsp;&emsp;</td><td>:</td></tr>
            <tr><td>Loket Bayar &emsp;&emsp;</td><td>:KANTOR POS</td></tr>
            <tr><td>Alamat &emsp;&emsp;</td><td>:</td></tr>
        </table>
    </div>
    <div class="col-md-6">
        <table class="tb-head-installment" style="width:100%">
            <tr>
                <td>
                    <div class="sign-box pull-right" style="padding: 10px; height:auto; width:100%">
                        Surat Keputusan Pensiun Asli<br/>
                        {{$taspen['skep_number']}}<br/>
                        Tertanggal, {{$taspen['skep_date']}}<br/>
                        Atas Nama: {{$taspen['name']}}
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table  class="text-center align-top" style="width: 100%;">
            <tr><td colspan="3" class="text-center" style="padding: 10px; height:20px">Diserahkan Tanggal</td></tr>
            <tr>
                <td style="width:250;height:50px; border:1px solid #000; padding: 5; margin: 0;">
                    <div style="padding: 0; margin: 0;">
                        <span>Debitur</span>
                    </div>
                    <div class="stamp-box-m">
                        <span>&nbsp;</span>
                    </div>
                    <div  style="padding: 0; margin: 0;">
                        <span>{{$taspen['name']}}</span>
                    </div>
                </td>
                <td style="width: auto"></td>
                <td style="width:250;height:50px; border:1px solid #000; padding: 5; margin: 0;">
                    <div  style="padding: 0; margin: 0;">
                        <span>Kepala Unit Pelayanan</span>
                    </div>
                    <div class="stamp-box-m">
                        <span>&nbsp;</span>
                    </div>
                    <div  style="padding: 0; margin: 0;">
                        <span>&nbsp;</span>
                    </div>
                </td>
            </tr>
            <tr><td colspan="3" class="text-center" style="padding: 10px; height:20px">Dikembalikan Tanggal</td></tr>
            <tr>
                <td style="width:250;height:50px; border:1px solid #000; padding: 5; margin: 0;">
                    <div>
                        <span>Debitur</span>
                    </div>
                    <div class="stamp-box-m">
                        <span>&nbsp;</span>
                    </div>
                    <div>
                        <span>{{$taspen['name']}}</span>
                    </div>
                </td>
                <td style="width: auto"></td>
                <td style="width:250;height:50px; border:1px solid #000; padding: 5; margin: 0;">
                    <div>
                        <span>Kepala Unit Pelayanan</span>
                    </div>
                    <div class="stamp-box-m">
                        <span>&nbsp;</span>
                    </div>
                    <div>
                        <span>&nbsp;</span>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
