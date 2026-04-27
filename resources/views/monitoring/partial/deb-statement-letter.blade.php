<div class="row">
    <div class="col-md-12">
        <div class="header">
            <div class="brand-flex left-logo">
            </div>
            <div  class="brand-flex" style="width:60%">
                <h3 class="text-center" style="margin-bottom:5px;">SURAT PERNYATAAN DEBITUR</h3>
                <h3 class="text-center" style="margin-bottom:5px;">MITRA KERJA PT POS INDONESIA (PERSERO)</h3>
            </div>
            <div  class="brand-flex right-logo">
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <p>Yang bertanda tangan dibawah ini :</p>
        <p>a. Nama PNS/ Pensiunan &emsp;&emsp;: {{$taspen['name']}}</p>
        <p  class="text-justity">Sehubungan dengan saya mengambil fasilitas kredit Pembiayaan Pensiun pada Mitra Kerja PT POS INDONESIA (PERSERO) Kantor Cabang __________________
        dengan perjanjian kredit nomor {{$contract_number}} maka dengan ini saya menyatakan:</p>
        <ol style="list-style: decimal;">
            <li  class="text-justity">Pada saat penerimaan pembayaran Manfaat Tabungan Hari Tua (THT) dan/atau Pensiun saya setiap bulan dari *PT TASPEN (PERSERO), agar dibayarkan
        melalui rekening saya nomor: ___________________________ atas Nama: _______________________________ Pada PT POS INDONESIA (PERSERO), Kantor
        Cabang ___________________ sampai dengan kredit saya lunas.</li>
            <li  class="text-justity">Memberi kuasa kepada PT POS INDONESIA (PERSERO), Kantor Cabang __________________________________ untuk melakukan Pengecekan Data kepesertaan Saya dan sekaligus untuk mendafarkan Flagging Data Saya pada PT TASPEN (PERSERO) selama jangka waktu kredit yang telah disetujui yaitu Tanggal
        ____ Bulan ____ Tahun ________ sampai dengan Tanggal ____ Bulan ____ Tahun ________ .</li>
        </ol>
        <p>Demikian surat pernyataan dan kuasa ini saya buat, untuk dipergunakan sebagaimana mestinya.</p>
        <p class="text-right"><b>{{$branch['name']}}, {{date('d-M-Y', strtotime($contract_date))}}</b></p>
        <div style="width: 100%;" class="text-center">
            <div style="width: 300px; right:0; position:relative; float:right">
                <div>
                    <span>Yang menyatakan</span>
                </div>
                <div class="stamp-box">
                    <span>Meterai <br/> Rp. 10.000,-</span>
                </div>
                <div class="br-b">
                    <span>{{$taspen['name']}}</span>
                </div>
            </div>
        </div>
        <p>Catatan :
            <ol style="list-style: decimal;">
                <li>Lembar 1 untuk PT TASPEN (PERSERO)</li>
                <li>Lembar 2 untuk PT POS INDONESIA (PERSERO)</li>
                <li>Lembar 3 untuk debitur</li>
                <li>Lembar 4 untuk arsip</li>
            </ol>
        </p>
    </div>
</div>
<div class="page-break"></div>
