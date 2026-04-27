<div class="row">
    <div class="col-md-12">
        <div class="header">
            <div class="brand-flex left-logo">
                @if ($bank['logo']!='')
                    <img src="{{$bank['logo']}}" alt="" style="width:60px; height:60px; margin:0px" class="pull-left"/>
                @endif
            </div>
            <div  class="brand-flex text-center" style="width:60%">
                <h3 style="margin-bottom:5px;">KARTU ANGSURAN</h3>
                <span>NO AKAD : {{$contract_number}}</span>
            </div>
            <div  class="brand-flex right-logo">
                <img src="{{public_path('img/logo_kpf.jpg')}}" alt="" style="width:60px; height:60px; margin:0px" class="pull-right"/>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table style="font-size: 10px; width: 100%;">
            <tr>
                <td style="width: 100px">Tanggal Akad</td>
                <td  style="width: 200px">: {{date('d-M-Y', strtotime($contract_date))}}</td>
                <td  style="width: 100px">Nama</td>
                <td  style="width: 200x">: {{$taspen['name']}}</td>
                <td rowspan="4"  style="width: auto">
                    <div class="pull-right text-right" style="padding: 0px;margin-top:-15px;">
                        <span class="text-right">Debitur</span>
                        <div class="sign-box-m"></div>
                        <span>Tanda Tangan Debitur</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Plafond Pembiayaan</td>
                <td>: {{formatIDR($plafon)}}</td>
                <td>Nopen</td>
                <td>: {{$taspen['nopen']}}</td>
            </tr>
            <tr>
                <td>Jangka Waktu</td>
                <td>: {{$tenor}}</td>
                <td>Kantor Bayar</td>
                <td>: {{$destination_paymaster}}</td>
            </tr>
            <tr>
                <td>Angsuran Perbulan</td>
                <td>: {{formatIDR($installment)}}</td>
                <td>Area Pelayanan</td>
                <td>: {{$branch['name']}}</td>
            </tr>
        </table>
        <br/>
        <br/>
        <table class="tb-installment">
            <thead>
                <tr class="bg-yellow">
                    <th style="width: 50px;">Periode</th>
                    <th >Tanggal Bayar</th>
                    <th >Angsuran</th>
                    <th >Pokok</th>
                    <th >Margin</th>
                    <th >Sisa Pokok</th>
                </tr>
            </thead>
            <tbody style="font-size: 10px">
                <tr>
                    <td style="width: 50px;">0</td>
                    <td >-</td>
                    <td >0</td>
                    <td >0</td>
                    <td ></td>
                    <td >{{formatIDR($plafon)}}</td>
                </tr>
                @foreach ( $installment_schedules as $installment_schedule )
                    <tr>
                        <td style="width: 50px;">{{$installment_schedule['number']}}</td>
                        <td >{{\Carbon\Carbon::parse($installment_schedule['payment_date'])->format('d-M-Y')}}</td>
                        <td >{{formatIDR($installment_schedule['amount'])}}</td>
                        <td >{{formatIDR($installment_schedule['primary_loan'])}}</td>
                        <td >{{formatIDR($installment_schedule['margin'])}}</td>
                        <td >{{formatIDR($installment_schedule['remains'])}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="page-break"></div>


<div class="row">
    <div class="col-md-12">
        <div class="header">
            <div class="brand-flex left-logo">
                @if ($bank['logo']!='')
                    <img src="{{$bank['logo']}}" alt="" style="width:60px; height:60px; margin:0px" class="pull-left"/>
                @endif
            </div>
            <div  class="brand-flex text-center" style="width:60%">
                <h3 style="margin-bottom:5px;">KARTU ANGSURAN</h3>
                <span>NO AKAD : {{$contract_number}}</span>
            </div>
            <div  class="brand-flex right-logo">
                <img src="{{public_path('img/logo_kpf.jpg')}}" alt="" style="width:60px; height:60px; margin:0px" class="pull-right"/>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table style="font-size: 10px; width: 100%;">
            <tr>
                <td style="width: 100px">Tanggal Akad</td>
                <td  style="width: 200px">: {{date('d-M-Y', strtotime($contract_date))}}</td>
                <td  style="width: 100px">Nama</td>
                <td  style="width: 200x">: {{$taspen['name']}}</td>
                <td rowspan="4"  style="width: auto">
                    <div class="pull-right text-right" style="padding: 0px;margin-top:-15px;">
                        <span class="text-right">{{$bank['code']}}</span>
                        <div class="sign-box-m"></div>
                        <span>Tanda Tangan Debitur</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Plafond Pembiayaan</td>
                <td>: {{formatIDR($plafon)}}</td>
                <td>Nopen</td>
                <td>: {{$taspen['nopen']}}</td>
            </tr>
            <tr>
                <td>Jangka Waktu</td>
                <td>: {{$tenor}}</td>
                <td>Kantor Bayar</td>
                <td>: {{$destination_paymaster}}</td>
            </tr>
            <tr>
                <td>Angsuran Perbulan</td>
                <td>: {{formatIDR($installment)}}</td>
                <td>Area Pelayanan</td>
                <td>: {{$branch['name']}}</td>
            </tr>
        </table>
        <br/>
        <br/>
        <table class="tb-installment">
            <thead>
                <tr class="bg-yellow">
                    <th style="width: 50px;">Periode</th>
                    <th >Tanggal Bayar</th>
                    <th >Angsuran</th>
                    <th >Pokok</th>
                    <th >Margin</th>
                    <th >Sisa Pokok</th>
                </tr>
            </thead>
            <tbody style="font-size: 10px">
                <tr>
                    <td style="width: 50px;">0</td>
                    <td >-</td>
                    <td >0</td>
                    <td >0</td>
                    <td ></td>
                    <td >{{formatIDR($plafon)}}</td>
                </tr>
                @foreach ( $installment_schedules as $installment_schedule )
                    <tr>
                        <td style="width: 50px;">{{$installment_schedule['number']}}</td>
                        <td >{{\Carbon\Carbon::parse($installment_schedule['payment_date'])->format('d-M-Y')}}</td>
                        <td >{{formatIDR($installment_schedule['amount'])}}</td>
                        <td >{{formatIDR($installment_schedule['primary_loan'])}}</td>
                        <td >{{formatIDR($installment_schedule['margin'])}}</td>
                        <td >{{formatIDR($installment_schedule['remains'])}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="page-break"></div>
