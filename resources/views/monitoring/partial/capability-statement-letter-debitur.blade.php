<div class="row">
    <div class="col-md-12">
        <div class="header" style="height: 20px;">
            <div class="brand-flex left-logo">
            </div>
            <div  class="brand-flex" style="width:60%">
                <h3 style="margin-bottom:5px;" class="text-center">SURAT PERNYATAAN DAN KESANGGUPAN</h3>
            </div>
            <div  class="brand-flex right-logo">
                {{-- <img src="{{public_path('img/logo_kpf.jpg')}}" alt="" style="width:60px; height:60px; margin:0px" class="pull-right"/> --}}
                <h3 style="margin-bottom:5px;">DEBITUR</h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <p>Yang bertanda tangan dibawah ini,</p>
        <table>
            <tr><td>Nama &emsp;&emsp;</td><td>: {{$taspen['name']}}</td></tr>
            <tr><td>Nopen &emsp;&emsp;</td><td>: {{$taspen['nopen']}}</td></tr>
            <tr><td>No. KTP &emsp;&emsp;</td><td>: {{$taspen['id_number']}}</td></tr>
            <tr><td>Alamat &emsp;&emsp;</td><td>: {{$taspen['complete_address']}}</td></tr>
        </table>
        <p>Dengan ini menyatakan :</p>
        <ol style="list-style: decimal;">
            <li>Telah menerima fasilitas Kredit dari {{$bank['name']}} melalui Koperasi Pemasaran Fadillah sebesar {{formatIDR($plafon)}} dengan besar angsuran {{formatIDR($installment)}} per bulan, selama {{$tenor}} bulan, terhitung mulai bulan {{\Carbon\Carbon::parse($start_date)->format('m')}} tahun {{\Carbon\Carbon::parse($start_date)->format('Y')}} sampai dengan bulan {{\Carbon\Carbon::parse($end_date)->format('m')}} tahun {{\Carbon\Carbon::parse($end_date)->format('Y')}}.</li>
            <li>Telah memperoleh penjelasan mengenai karakteristik Kredit Pensiun serta telah mengerti dan memahami segala konsekuensinya, termasuk manfaat, resiko dan biaya – biaya yang timbul terkait dengan Kredit Pensiun.</li>
            <li>Bersedia mematuhi dan menyetujui ketentuan pembatalan Kredit sebagai berikut :
                <ol style="list-style: lower-alpha;">
                    <li>Untuk pengajuan Kredit yang telah disetujui tetapi belum dilakukan transfer dana dikenakan penalti biaya administrasi pembatalan sebesar 1% dari plafon yang disetujui.</li>
                    <li>Untuk pengajuan yang telah disetujui dan telah dilakukan transfer dana dikenakan penalti biaya administrasi dengan ketentuan jika pembatalan dilakukan :
                        <ol style="list-style: upper-roman;">
                            <li>Maksimal H+2 setelah pencairan denda penalti sebesar 1% dari plafon.</li>
                            <li>Lebih dari H+2 atau lewat Bulan setelah pencairan denda penalti mengacu pada No. 4 Poin B.</li>
                            <li>Lewat bulan setelah pencairan denda penalti sebesar 6,00% dari plafon.</li>
                            <li>Dana harus dikembalikan sejak pemberitahuan pembatalan sejumlah dana pencairan + penalti biaya administrasi.</li>
                        </ol>
                    </li>
                </ol>
            </li>
            <li>Bersedia mematuhi dan menyetujui ketentuan dan persyaratan pelunasan dipercepat sebagai berikut :
                <ol style="list-style: lower-alpha;">
                <li>Pelunasan Lanjut
                    <ol style="list-style: decimal;">
                        <li>Pelunasan Lanjut/Rehab, dapat dilakukan setelah Angsuran di muka terproses autodebet</li>
                        <li>Perhitungan pelunasan Lanjut diatur sbb:
                            <table class="align-top">
                                <tr><td>a&nbsp; < &nbsp;</td><td><span>Tanggal Akad<br/>1). Sisa pokok bulan lalu<br/>2). ada pengembalian angsuran bulan berjalan</span></td></tr>
                                <tr><td>b&nbsp; >= &nbsp;</td><td><span>Tanggal Akad<br/>1). Sisa pokok bulan lalu - pokok bulan berjalan<br/>2). tidak ada pengembalian angsuran bulan berjalan</span></td></tr>
                            </table>
                        </li>
                        <li>Sisa pokok Kredit posisi pada saat pelunasan sesuai yang tercata pada system.</li>
                        <li>Pengembalian angsuran bulan berjalan ditransfer langsung melalui rekening debitur maksimal hari kerja pertama bulan berikutnya.</li>
                        <li>Batas waktu akhir pelunasan lanjut adalah tanggal 25 setiap bulannya, khusus pelunasan lanjut yang dilakukan diatas tanggal 20 dikenakan potongan 1x angsuran dimuka.</li>
                    </ol>
                </li>
                <li>Pelunasan Lepas
                    <ol style="list-style: decimal;">
                        <li>Pelunasan Lepas baru dapat dilakukan setelah Angsuran ke 6 terproses autodebet.</li>
                        <li>Biaya administrasi pelunasan Lepas adalah :
                            <table class="align-top">
                                <tr><td>a. &nbsp;</td><td><span>Angsuran Terbayar <= 12 bulan<br/><b>sisa pokok bulan lalu + 4x angsuran</b></span></td></tr>
                                <tr><td>b. &nbsp;</td><td><span>Angsuran Terbayar > 12 bulan<br/><b>sisa pokok bulan lalu + 2x angsuran</b></span></td></tr>
                            </table>
                        </li>
                        <li>Tidak ada pengembalian angsuran.</li>
                        <li>Batas waktu akhir pelunasan lepas adalah tanggal 20 setiap bulannya.</li>
                        <li>Untuk pelunasan lepas Debitur diwajibkan melakukan konfirmasi ke Kantor Pusat via telepon dan setelah mendapatkan nominal pelunasan serta nomor rekening, maka penyetoran uang pelunasan tersebut wajib disetorkan sendiri ke rekening Kantor Pusat.</li>
                        <li>Pengambilan SK Asli akan dikirimkan dari Kantor Pusat ke Unit Pelayanan paling cepat tanggal 1 bulan berikutnya.</li>
                    </ol>
                </li>
                </ol>
            </li>
            <li>
                <table>
                    <tr><td>a. &nbsp;</td><td>Mekanisme Pelunasan wajib menghubungi Kantor Pusat Koperasi Pemasaran Fadillah di no telepon ____________________.</td></tr>
                    <tr><td>b. &nbsp;</td><td>Tidak diperkenankan melakukan penyetoran sejumlah uang pelunasan kepada petugas dilapangan. Apabila hal tersebut dilakukan, Kantor Pusat Koperasi Pemasaran Fadillah tidak bertanggung jawab jika terjadi hal-hal yang tidak diinginkan.</td></tr>
                </table>
            </li>
            <li>Apabila diperlukan bersedia untuk dilakukan pemindahan Kantor Bayar Gaji Pensiun ke Kantor Bayar Gaji Pensiun yang ditunjuk Koperasi Pemasaran Fadillah.</li>
            <li>Segala resiko atas pemberian pernyataan ini adalah merupakan tanggung jawab Pemberi Pernyataan sepenuhnya dan oleh karena itu Pemberi Pernyataan menyatakan membebaskan Koperasi Pemasaran Fadillah dan seluruh karyawannya dari segala tuntutan dan/atau gugatan hukum yang mungkin timbul dari pihak manapun akibat adanya pemberian pernyataan ini.</li>
            <li>Terhitung mulai Bulan 7 Tahun 2024, apabila gaji pensiun saya tidak terpotong/terdebet oleh kantor bayar gaji pensiunan saya, maka saya akan melakukan penyetoran keajiban angsuran saya secara tunai kepada Koperasi Pemasaran Fadillah melalui Unit Pelayanan dimana saya mengajukan pinjaman saya.</li>
        </ol>
        <p>Demikian surat pernyataan ini dibuat dengan sebenarnya dengan dilandasi itikad baik tanpa paksaan dari siapapun dan pihak manapun.</p>
        <p class="text-right"><b>{{$branch['name']}}, {{date('d-M-Y', strtotime($contract_date))}}</b></p>
        <div style="float:right;width:200px" class="text-center">
            <div>
                <span>Yang Membuat Pernyataan</span>
            </div>
            <div class="stamp-box">
                <span>&nbsp;</span>
            </div>
            <div>
                <span>{{$taspen['name']}}</span>
            </div>
            <div class="br-t">
                <span>Nasabah</span>
            </div>
        </div>
    </div>
</div>
<div class="page-break"></div>
