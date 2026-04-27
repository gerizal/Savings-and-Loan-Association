<div class="row">
    <div class="col-md-12">
        <div class="header">
            <div class="brand-flex left-logo">
            </div>
            <div  class="brand-flex text-center" style="width:60%">
                <h3 class="text-center" style="margin-bottom:5px;">SURAT PERNYATAAN DAN KUASA DEBET REKENING (SPKDR)</h3>
                <span>NO AKAD : {{$contract_number}}</span>
            </div>
            <div  class="brand-flex right-logo">
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <p>Yang bertanda tangan dibawah ini,</p>
        <table>
            <tr><td>1.&nbsp;</td><td> Nama Penerima Manfaat Pensiun (MP) &emsp;&emsp;<td>: {{$taspen['name']}}</td></tr>
            <tr><td>2.&nbsp;</td><td> Tempat dan Tanggal Lahir <td>: {{$taspen['birth_place']}} , {{date('d-M-Y', strtotime($taspen['birth_date']))}}</td></tr>
            <tr><td>3.&nbsp;</td><td> Alamat Lengkap <td>: {{$taspen['complete_address']}}</td></tr>
            <tr><td>4.&nbsp;</td><td> No Telepon <td>: {{$taspen['phone_number']}}</td></tr>
            <tr><td>5.&nbsp;</td><td> NIP / NRP / NOPEN <td>: {{$taspen['nopen']}}</td></tr>
        </table>
        <p class="text-justity">Yang untuk melakukan tindakan hukum dalam surat ini telah mendapat persetujuan dari suami/istri saya yaitu :</p>
        <table>
            <tr><td>1.&nbsp;</td><td> Nama &emsp;&emsp;</td><td>: {{$has_relation ? $spouse['name']:''}}</td></tr>
            <tr>
                <td>2.&nbsp;</td>
                <td> Tempat dan Tanggal Lahir &emsp;&emsp;</td>
                @if ($has_relation)
                    <td>: {{$spouse['birth_place']}} , {{date('d-M-Y', strtotime($spouse['birth_date']))}}</td>
                @else
                    <td>: </td>
                @endif
            </tr>
            <tr><td>3.&nbsp;</td><td> Alamat Lengkap &emsp;&emsp;</td><td>: {{$has_relation ? $taspen['complete_address']:''}}</td></tr>
            <tr><td>4.&nbsp;</td><td> No KTP&emsp;&emsp;</td><td>: {{$has_relation ? $spouse['id_number'] : ''}}</td></tr>
        </table>
        <p class="text-right">
            <b>*) diisi apabila Peminjam bukan Janda/Duda</b>
        </p>
        <p class="text-justity">Sehubungan dengan ini saya menyatakan telah mendapat pembiayaan dari KOPERASI PEMASARAN FADILLAH Sebesar {{formatIDR($plafon)}} ({{ucwords(numToWords($plafon))}}). atau sejumlah yang disetujui oleh KOPERASI PEMASARAN FADILLAH, serta sesuai dengan surat Perjanjian Pembiayaan nomor {{$contract_number}} yang saya tanda tangani kemudian, yang pembayaran gaji pensiunnya dibayarkan di PT. POS INDONESIA (PERSERO) KANTOR POS, maka dengan
        ini saya menyatakan :</p>
        <ol style="list-style: decimal;">
            <li class="text-justity">Pada saat dana pensiun saya sudah masuk ke rekening PT. POS INDONESIA (PERSERO), dengan ini saya memberi kuasa kepada PT. POS INDONESIA
        (PERSERO) , untuk melakukan pemotongan dana pensiun saya untuk membayar angsuran sebesar {{formatIDR($installment)}} sampai dengan pinjaman/kewajiban
        saya lunas dan hasil potongan tersebut disetorkan ke rekening Bank BANK RAKYAT INDONESIA a.n KOPERASI PEMASARAN FADILLAH dengan nomor
        rekening 013201001538308</li>
            <li class="text-justity">Bahwa sisa gaji saya sendiri pada saat ini dan seterusnya (sampai pembiayan saya lunas) benar-benar cukup untuk dipotong sejumhlah tersebut diatas,
        dan jika ternyata dikemudian hari gaji saya tidak cukup jumlahnya untuk dipotong karena sebab apapun, maka berarti saya telah melakukan tindakan
        pidana pemalsuan data/keterangan</li>
            <li class="text-justity">Bahwa sepenuhnya dari pembiayaan yang saya ambil/terima tersebut benar-benar saya pergunakan untuk keperluan saya sendiri dan saya tidak akan
        mengalihkan tempat pengambilan gaji pensiun saya ketempat lain sampai dengan pembiayaan saya lunas sepenuhnya.</li>
            <li class="text-justity">Bahwa saya sanggup melunasi pembiayaan saya kepada Koperasi Pemasaran Fadillah, apabila saya melakukan pernikahan yang menyebabkan tunjangan pensiun (Janda/Duda**) hilang.</li>
        </ol>
        <p class="text-justity">Pemberian kuasa ini tidak otomatis melepaskan tanggungjawab saya terhadap kelancaran pembayaran angsuran pembiayaan tersebut sampai dengan lunas
        tepat waktunya, sehingga saya sebagai pihak pemberi kuasa bertanggung jawab penuh terhadap segala macam tindakan penerima kuasa yang berkaitan dengan
        Surat Kuasa ini. Dan saya memberikan wewenang kepada pihak Koperasi Pemasaran Fadillah , untuk membantu melakukan penagihan apabila ada keterlambatan dalam penyerahan uang hasil pemotongan gaji pensiun saya tersebut.
        </p>
        <p  class="text-justity">Demikian Surat Pernyataan dan Kuasa ini dibuat dalam keadaan sadar dan tanpa paksaan dari pihak manapun, untuk dapat dipergunakan sebagaimana mestinya</p>
        <p class="text-right"><b>, </b></p>
        <table class="text-center align-top tb-sign" style="width: 100%;">
            <tr>
                <td style="padding:25px 100px;">
                    <div>
                        <span>Mengetahui<br/>Koperasi Pemasaran Fadilah</span>
                    </div>
                    <div class="stamp-box">
                        <span>&nbsp;</span>
                    </div>
                    <div class="br-b">
                        <span>&nbsp;</span>
                    </div>
                </td>
                <td style="padding:25px 100px;">
                    <div>
                        <span>Pemberi Kuasa<br/>&nbsp;</span>
                    </div>
                    <div class="stamp-box">
                        <span>&nbsp;</span>
                    </div>
                    <div  class="br-b">
                        <span>{{$taspen['name']}}</span>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="page-break"></div>
