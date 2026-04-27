<div class="row">
    <div class="col-md-12">
        <div class="header">
            <div class="brand-flex left-logo">
                @if ($bank['logo']!='')
                    <img src="{{$bank['logo']}}" alt="" style="width:60px; height:60px; margin:0px" class="pull-left"/>
                @endif
            </div>
            <div  class="brand-flex text-center" style="width:60%">
                <h3 class="text-center" style="margin-bottom:5px;">PERJANJIAN KREDIT</h3>
                <span>NO AKAD : {{$contract_number}}</span>
            </div>
            <div  class="brand-flex right-logo">
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 text-justify">
        <p style="margin-top:20px;">
            Yang bertanda tangan di bawah ini :
            <table >
                <tr>
                    <td>Nama</td>
                    <td>: {{env('APP_DIRECTUR')}}</td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>: {{env('APP_POSITION')}}</td>
                </tr>
            </table>
            <p class="text-justify">Dalam kedudukan selaku Direktur Utama, oleh karenanya bertindak untuk dan atas nama serta sah mewakili {{$bank['contract_decision_letter']}}, yang selanjutnya disebut "BANK".</p>
            <table>
                <tr>
                    <td>Nama</td>
                    <td>: {{$taspen['name']}}</td>
                </tr>
                <tr>
                    <td>NIK</td>
                    <td>: {{$taspen['id_number']}}</td>
                </tr>
                <tr>
                    <td>Tempat/Tanggal Lahir &emsp;&emsp;</td>
                    <td>: {{$taspen['birth_date']}} , {{date('d-M-Y', strtotime($taspen['birth_date']))}}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>: {{$taspen['complete_address']}}</td>
                </tr>
                <tr>
                    <td>Pekerjaan</td>
                    <td>: {{$taspen['current_job']}}</td>
                </tr>
            </table>
            <p>Dan untuk tindakan hukum ini telah mendapat persetujuan suami/isterinya :</p>
            <table>
                <tr>
                    <td>Nama</td>
                    <td>: {{$has_relation ? $spouse['name']:''}}</td>
                </tr>
                <tr>
                    <td>NIK</td>
                    <td>: {{$has_relation ? $spouse['id_number']:''}}</td>
                </tr>
                <tr>
                    <td>Tempat/Tanggal Lahir&emsp;&emsp;</td>
                    @if ($has_relation)
                        <td>: {{$spouse['birth_place']}}, {{date('d-M-Y', strtotime($spouse['birth_date']))}}</td>
                    @else
                        <td>: </td>
                    @endif
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>: {{$has_relation ? $taspen['complete_address']:''}}</td>
                </tr>
                <tr>
                    <td>Pekerjaan</td>
                    <td>: {{$has_relation ? $spouse['occupation']:''}}</td>
                </tr>
            </table>
            <p>Selanjutnya disebut "DEBITUR"</p>
            <p class="text-justify">Selanjutnya BANK dan DEBITUR terlebih dahulu menerangkan dengan ini telah sepakat untuk mengadakan Perjanjian Kredit (selanjutnya disebut
            “Perjanjian”) dengan syarat-syarat dan ketentuan-ketentuan sebagai berikut:</p>
            <div class="text-center">
                <h4>Pasal 1<br/>FASILITAS KREDIT</h4>
            </div>
            <p class="text-justify">
            BANK dengan ini menyetujui memberikan suatu kredit kepada DEBITUR dan DEBITUR menyetujui untuk menerima fasilitas kredit yang disebut Kredit
            Channeling dengan Plafond Kredit sebesar{{formatIDR($plafon)}} ({{ucfirst(numToWords($plafon))}})
            </p>
            <div class="text-center">
                <h4>Pasal 2<br/>TUJUAN PENGGUNAAN & JANGKA WAKTU</h4>
            </div>
            @if ($bank['code']=='BPR SIP')
                <table>
                    <tr><td>Jangka Waktu &emsp;&emsp;</td><td>: {{$tenor}} Bulan sejak {{$start_date}} sampai dengan {{$end_date}}</td></tr>
                    <tr><td>Angsuran &emsp;&emsp;</td><td>: {{formatIDR($installment)}} / Bulan</td></tr>
                    <tr><td>GP &emsp;&emsp;</td><td>: 1 Bulan</td></tr>
                    <tr><td>Tanggal Pembayaran&emsp;&emsp;</td><td>: {{$start_date}}</td></tr>
                    <tr><td>Suku Bunga Efektif&emsp;&emsp;</td><td>: {{(float)$interest}}% / Tahun</td></tr>
                    <tr><td>Tujuan Penggunaan&emsp;&emsp;</td><td>: {{$purpose}}</td></tr>
                </table>
            @else
                <table>
                    <tr><td>Jangka Waktu &emsp;&emsp;</td><td>: {{$tenor}} Bulan sejak {{$start_date}} sampai dengan {{$end_date}}</td></tr>
                    <tr><td>Angsuran &emsp;&emsp;</td><td>: {{formatIDR($installment-$col_fee)}} / Bulan</td></tr>
                    <tr><td>Fee Collection &emsp;&emsp;</td><td>: {{formatIDR($col_fee)}} / Bulan</td></tr>
                    <tr><td>Total Angsuran &emsp;&emsp;</td><td>: {{formatIDR($installment)}} / Bulan</td></tr>
                    <tr><td>Tanggal Pembayaran&emsp;&emsp;</td><td>: {{$start_date}}</td></tr>
                    <tr><td>Suku Bunga Flat&emsp;&emsp;</td><td>: {{(float)$interest}} / Tahun</td></tr>
                    <tr><td>Tujuan Penggunaan&emsp;&emsp;</td><td>: {{$purpose}}</td></tr>
                </table>
            @endif

            <div class="page-break"></div>
            <div class="text-center">
                <h4>Pasal 3<br/>BIAYA - BIAYA</h4>
            </div>
            <table>
                <tr><td>3.1 &nbsp;</td><td class="text-justity">Untuk pembebanan angsuran,bunga, provisi, biaya-biaya, denda dan segala biaya lainnya yang terhutang berkenaan dengan pemberian kredit
            ini, DEBITUR memberi kuasa kepada BANK untuk mendebet rekening debitur yang ada pada BANK.</td></tr>
                <tr><td>3.2 &nbsp;</td><td  class="text-justity">DEBITUR berjanji dan dengan ini mengikat diri untuk menanggung seluruh biaya yang diperlukan berkenaan dengan pelaksanaan Akad ini
            sepanjang hal ini diberitahukan BANK kepada DEBITUR sebelum ditandatangani Akad ini dan DEBITUR menyatakan persetujuannya. Adapun
            biaya-biaya tersebut adalah sebagai berikut</td></tr>
            </table>
            @if ($bank['code']=='BPR SIP')
            <table  class="align-top">
                <tr><td>a.&nbsp;</td><td> Administrasi <td>: {{formatIDR($administration_fee)}}</td></tr>
                <tr><td>b.&nbsp;</td><td> Asuransi Jiwa / Kredit &emsp;&emsp;<td>: {{formatIDR($insurance_fee)}}</td></tr>
                <tr><td>c.&nbsp;</td><td> Layanan Kredit <td>: {{formatIDR($provision_fee)}}</td></tr>
                <tr><td>d.&nbsp;</td><td> Materai <td>: {{formatIDR($stamp_fee)}}</td></tr>
                <tr><td>e.&nbsp;</td><td> Biaya Lain-lain <td>: {{formatIDR($other_fee)}}</td></tr>
                <tr><td></td><td><td>: ___________________+</td></tr>
                <tr><td></td><td> <b>Total Biaya</b> <td><b>: {{formatIDR(($administration_fee+$insurance_fee+$provision_fee+$stamp_fee+$other_fee))}}</b></td></tr>
            </table>
            @else
            <table  class="align-top">
                <tr><td>a.&nbsp;</td><td> Administrasi <td>: {{formatIDR($administration_fee)}}</td></tr>
                <tr><td>b.&nbsp;</td><td> Asuransi Jiwa / Kredit &emsp;&emsp;<td>: {{formatIDR($insurance_fee)}}</td></tr>
                <tr><td>c.&nbsp;</td><td> Pembukaan Tabungan <td>: {{formatIDR($account_opening_fee)}}</td></tr>
                <tr><td>d.&nbsp;</td><td> Materai <td>: {{formatIDR($stamp_fee)}}</td></tr>
                <tr><td>e.&nbsp;</td><td> Biaya Lain-lain <td>: {{formatIDR($other_fee)}}</td></tr>
                <tr><td></td><td><td>: ___________________+</td></tr>
                <tr><td></td><td> <b>Total Biaya</b> <td><b>: {{formatIDR(($administration_fee+$insurance_fee+$account_opening_fee+$stamp_fee+$other_fee))}}</b></td></tr>
            </table>
            @endif
            <p>Segala biaya yang timbul sehubungan dengan Akad ini merupakan tanggung jawab dan wajib dibayar oleh DEBITUR.</p>
            <!-- <div class="page-break"></div> -->
            <div class="text-center">
                <h4>Pasal 4<br/>JAMINAN</h4>
            </div>
            <table  class="align-top">
                <tr><td>4.1&nbsp;</td><td class="text-justify">Bahwa guna menjamin lebih lanjut pembayaran kembali kewajiban DEBITUR kepada BANK seperti yang disebut pada perjanjian ini, perubahan
                    dan/atau novasi atau Perjanjian Kredit yang dibuat dikemudian hari atau sebab apapun juga, maka DEBITUR menyerahkan jaminan kepada
                    BANK berupa :
                </td></tr>
                <tr><td>&nbsp;</td><td>
                    <ol style="list-style-type: lower-alpha">
                        <li>Asli Surat Keputusan (SK) Pensiun : Nomor {{$taspen['skep_number']}} tertanggal : {{date('d-M-Y', strtotime($taspen['skep_date']))}} atas nama : {{$taspen['name']}}</li>
                        <li>Asli Surat Pernyataan Kuasa Potong Gaji atas nama : {{$taspen['name']}}</li>
                        <li>Asli Bukti Flagging Pos atas nama : {{$taspen['name']}} </li>
                    </ol>
                </td></tr>
                <tr><td>4.2&nbsp;</td><td  class="text-justify">DEBITUR memberi kuasa kepada BANK untuk melakukan tindakan dan perbuatan hukum yang dianggap wajar dan perlu oleh BANK yang berkaitan dengan pemberian jaminan tersebut diatas.</td></tr>
                <tr><td>4.3&nbsp;</td><td  class="text-justify">DEBITUR dengan ini menyatakan dan menjamin bahwa JAMINAN tersebut diatas adalah benar dan milik DEBITUR, dan hanya DEBITUR sajalah yang berhak untuk menyerahkannya sebagai Jaminan, tidak sedang diberikan sebagai Jaminan untuk sesuatu hutang pada pihak lain dengan jalan bagaimanapun juga, tidak dalam keadaan sengketa serta bebas dari sitaan, serta belum dijual atau dijanjikan untuk dijual atau dialihkan kepada pihak lain dengan cara apapun juga</td></tr>
                <tr><td>4.4&nbsp;</td><td  class="text-justify">DEBITUR menjamin bahwa mengenai hal – hal tersebut pada pasal 4 ayat 4.1 diatas, baik sekarang maupun dikemudian hari, BANK tidak akan mendapat tuntutan atau gugatan dari pihak manapun juga yang menyatakan mempunyai hak terlebih dahulu atau turut mempunyai hak atas JAMINAN tersebut diatas.</td></tr>
            </table>
            <div class="text-center">
                <h4>Pasal 5<br/>KEWAJIAN DEBITUR</h4>
            </div>
            <p>Untuk lebih menjamin pelaksanaan Perjanjian ini oleh DEBITUR, maka DEBITUR berkewajiban untuk :</p>
            <table  class="align-top">
                <tr><td>5.1&nbsp;</td><td  class="text-justify">Mempergunakan kredit tersebut semata-mata hanya sebagaimana yang tertera dalam pasal 1 Perjanjian ini.</td></tr>
                <tr><td>5.2&nbsp;</td><td class="text-justify">DEBITUR menyetujui dan wajib mengikat diri untuk menyerahkan semua surat dan dokumen apapun, yang asli serta sah dan membuktikan
                    pemilikan atas segala benda yang dijadikan jaminan termasuk dalam Pasal 4 ayat 4.1 tersebut di atas kepada BANK guna dipergunakan
                    untuk pelaksanaan pengikatan benda tersebut sebagai jaminan kredit, dan selanjutnya dikuasai oleh BANK sampai dilunasi seluruh jumlah
                    hutangnya.</td></tr>
                <tr><td>5.3&nbsp;</td><td class="text-justify">DEBITUR Wajib mengikuti Asuransi Jiwa dan atau Asuransi Kredit.</td></tr>
                <tr><td>5.4&nbsp;</td><td class="text-justify">DEBITUR wajib memperpanjang masa pertanggungan termasuk bilamana masa berakhir, sampai lunasnya fasilitas kredit dibayar kembali oleh
                DEBITUR kepada BANK, apabila DEBITUR dengan alasan apapun tidak memperpanjang masa pertanggungan tersebut, maka segala resiko yang
                terjadi pada agunan tersebut menjadi resiko DEBITUR sendiri.</td></tr>
                <tr><td>5.5&nbsp;</td><td class="text-justify">DEBITUR wajib membayar premi-premi dan lain-lain biaya asuransi tepat pada waktunya dan menyerahkan asli dari setiap polis atau setiap
                perpanjangannya dan setiap tanda-tanda pembayarannya kepada BANK. BANK dengan ini diberi kuasa oleh DEBITUR untuk menutup dan
                memperpanjang asuransi yang dima</td></tr>
            </table>
            <div class="page-break"></div>
            <div class="text-center">
                <h4>Pasal 6<br/>PEMBAYARAN KEMBALI KREDIT</h4>
            </div>
            <table class="align-top">
                <tr><td>6.1&nbsp;</td><td class="text-justify">Pembayaran kembali kredit/pinjaman uang tersebut dilakukan secara angsuran bulanan, yang terdiri dari angsuran pokok kredit dan bunga
                dalam jumlah tetap. Jumlah-jumlah uang yang terutang oleh DEBITUR kepada BANK berdasarkan/sesuai dengan catatan-catatan dan/atau
                pembukuan BANK merupakan bukti yang mengikat bagi DEBITUR mengenai utang DEBITUR dibayar lunas, untuk itu DEBITUR tidak akan
                menyangkal dan/atau mengajukan keberatan-keberatan akan jumlah-jumlah uang yang terhutang oleh DEBITUR.</td></tr>
                <tr><td>6.2&nbsp;</td><td class="text-justify"> Demikian pula apabila jangka waktu fasilitas kredit telah berakhir atau diakhiri sebelum jangka waktu berakhir dan ternyata masih terdapat
                sisa utang sebagai akibat perubahan tingkat suku bunga, maka DEBITUR wajib menandatangani perpanjangan Perjanjian Kredit.</td></tr>
                <tr><td>6.3&nbsp;</td><td class="text-justify"> Setiap perubahan besarnya pembayaran bunga pinjaman selalu akan diberitahukan secara tertulis oleh BANK kepada DEBITUR. Dan surat
                pemberitahuan perubahan suku bunga tersebut, dan/atau jadwal angsuran pinjaman pokok dan bunga pinjaman, merupakan satu kesatuan
                dan tidak terpisahkan dari perjanjian ini, serta DEBITUR tidak akan menyangkal dalam bentuk apapun juga atas perubahan suku bunga
                tersebut.</td></tr>
                <tr><td>6.4&nbsp;</td><td class="text-justify"> DEBITUR membayar angsuran pokok dan bunga pinjaman melalui pemotongan gaji yang dilakukan oleh KANTOR POS KC {{$branch['name']}}
                berdasarkan surat kuasa pemotongan gaji sampai seluruh kewajibanya dinyatakan lunas oleh BANK.</td></tr>
                <tr><td>6.5&nbsp;</td><td class="text-justify"> Semua pembayaran pada BANK harus dilakukan di tempat kedudukan BANK melalui rekening DEBITUR atau rekening lain yang ditentukan oleh
                BANK.</td></tr>
            </table>
            <div class="text-center">
                <h4>Pasal 7<br/>DENDA KETERLAMBATAN & PINALTY</h4>
            </div>
            <table class="align-top">
            <tr><td>7.1&nbsp;</td><td class="text-justify"> Bahwa atas setiap keterlambatan pembayaran cicilan/angsuran oleh DEBITUR kepada BANK, maka DEBITUR dikenakan denda menurut ketentuan BANK yang berlaku pada saat ditandatanganinya Perjanjian ini, yaitu sebesar 0,3%,- (nol koma tiga persen) perhari.</td></tr>
            <tr><td>7.2&nbsp;</td><td class="text-justify"> Pelunasan sebagian atau seluruh pinjaman sebelum jatuh tempo dapat dilakukan DEBITUR dengan ketentuan bahwa setiap pelunasan baik sebagian atau seluruh pinjaman tersebut DEBITUR dikenakan penalty sebesar 7% (tujuh perseratus) yang dihitung dari sisa Pokok Pinjaman DEBITUR yang tertera pada pembukuan pihak BANK.</td></tr>
            </table>
            <div class="text-center">
                <h4>Pasal 8<br/>SYARAT & KETENTUAN</h4>
            </div>
            <table class="align-top">
            <tr><td>8.1&nbsp;</td><td class="text-justify">BANK berhak untuk sewaktu-waktu menghentikan dan memutuskan perjanjian ini dengan mengesampingkan ketentuan-ketentuan Pasal 1266
                dan Pasal 1267 Kitab Undang-Undang Hukum Perdata sehingga tidak diperlukan lagi suatu surat pemberitahuan (Somasi) atau surat peringatan
                dari juru sita atau surat lain yang serupa itu, dalam hal demikian seluruh hutang DEBITUR kepada BANK harus dibayar seketika dan sekaligus,
                yaitu dalam hal terjadi salah satu kejadian dibawah ini :
                    <ol style="list-style-type: lower-alpha">
                        <li>Bilamana DEBITUR menggunakan fasilitas pinjaman ini menyimpang dari tujuan penggunaan yang telah disetujui oleh BANK.</li>
                        <li>Bilamana DEBITUR lalai atau tidak memenuhi syarat-syarat atau ketentuan-ketentuan / kewajiban-kewajiban yang dimaksud dalam
                        Perjanjian ini dan atau perubahan/tambahan dan atau perjanjian-perjanjian pengikatan jaminan.</li>
                        <li>Bilamana menurut pertimbangan BANK keadaan keuangan, bonafiditas dan solvabilitas DEBITUR mundur sedemikian rupa sehingga
                        DEBITUR tidak dapat membayar hutangnya.</li>
                        <li>Bilamana DEBITUR menanggung hutang pihak ketiga tanpa persetujuan tertulis terlebih dahulu dari BANK.</li>
                        <li>Bilamana pernyataan-pernyataan, surat-surat, keterangan-keterangan yang diberikan DEBITUR kepada BANK ternyata tidak benar.</li>
                        <li>Bilamana menurut pertimbangan BANK ada hal-hal lain yang meragukan pengembalian pelunasan kredit tersebut.</li>
                    </ol>
                </td></tr>
                <tr><td>8.2&nbsp;</td><td class="text-justify"> Bahwa segala pembukuan / catatan yang dibuat oleh BANK menjadi tanda bukti yang mengikat dan sah atas jumlah hutang DEBITUR kepadaBANK.</td></tr>
                <tr><td>8.3&nbsp;</td><td class="text-justify"> Apabila DEBITUR meninggal dunia, maka semua hutang dan kewajiban DEBITUR kepada BANK yang timbul berdasarkan Perjanjian ini berikut semua perubahannya dikemudian dan atau berdasarkan apapun juga tetap merupakan satu kesatuan hutang dari para ahli waris DEBITUR atau PENANGGUNG (jika ada).</td></tr>
                <tr><td>8.4&nbsp;</td><td class="text-justify"> Debitur dengan ini berjanji, akan tunduk kepada segala ketentuan dan sesuai dengan ketentuan peraturan perundang-undangan termasuk ketentuan peraturan Otoritas Jasa Keuangan.</td></tr>
                <tr><td>8.5&nbsp;</td><td class="text-justify"> Perjanjian ini telah disesuaikan dengan ketentuan peraturan perundang-undangan termasuk ketentuan peraturan Otoritas Jasa Keuangan.</td></tr>
            </table>
            <div class="page-break"></div>
            <div class="text-center">
                <h4>Pasal 9<br/>KOMUNIKASI & PEMBERITAHUAN</h4>
            </div>
            <p>Setiap pemberitahuan atau komunikasi lainnya yang berhubungan dengan Perjanjian Kredit ini dapat dikirimkan ke alamat sebagai berikut :</p>
            <b>{{$bank['name']}}</b>
            <table>
                <tr><td>No Telepon &emsp;&emsp;</td><td>: {{$bank['phone_number']}}</td></tr>
                <tr><td>Email </td><td>: {{$bank['email']}}</td></tr>
                <tr><td>Alamat </td><td>: {{$bank['address']}}</td></tr>
            </table>
            <b>DEBITUR</b>
            <table>
                <tr><td>Nama </td><td>: {{$taspen['name']}}</td></tr>
                <tr><td>No Telepon &emsp;&emsp;</td><td>: {{$taspen['phone_number']}}</td></tr>
                <tr><td>Alamat </td><td>: {{$taspen['complete_address']}}</td></tr>
            </table>
            <table class="align-top"></table>
            <div class="text-center">
                <h4>Pasal 10<br/>DOMISILI HUKUM</h4>
            </div>
            <p>Mengenai perjanjian ini dan segala akibat serta pelaksanaannya kedua belah pihak menerangkan telah memilih tempat kedudukan hukum yang tetap dan umum di Kantor Panitera Pengadilan Negeri Bandung, demikian dengan tidak mengurangi hak dari BANK untuk memohon gugatan atau pelaksanaan eksekusi dari perjanjian ini melalui Peradilan lainnya dalam wilayah Republik Indonesia.</p>
            <table class="align-top"></table>
            <div class="text-center">
                <h4>Pasal 11<br/>LAIN-LAIN</h4>
            </div>
            <table class="align-top">
                <tr><td>11.1&nbsp;</td><td class="text-justify"> Sebelum Akad ini ditandatangani oleh DEBITUR, DEBITUR mengakui dengan sebenarnya, bahwa DEBITUR telah membaca dengan cermat atau dibacakan kepada DEBITUR, sehingga oleh karena itu DEBITUR memahami sepenuhnya segala yang akan menjadi akibat hukum setelah DEBITUR menandatangani Perjanjian Kredit ini.</td></tr>
                <tr><td>11.2&nbsp;</td><td class="text-justify"> Apabila ada hal-hal yang belum diatur atau belum cukup diatur dalam Perjanjian Kredit ini, maka DEBITUR dan BANK akan mengaturnya Bersama secara musyawarah untuk mufakat dalam suatu Addendum.</td></tr>
                <tr><td>11.3&nbsp;</td><td class="text-justify"> Setiap Addendum dari Perjanjian Kredit ini merupakan satu kesatuan yang tidak dapat dipisahkan dari Perjanjian Kredit ini.</td></tr>
            </table>
            <!-- <br/> -->
            <p class="text-right"><b>Jakarta, {{$contract_date}}</b></p>
            <table class="text-center align-top tb-sign" style="width: 100%;">
                <tr>
                    <td>
                        <div>
                            <span>{{$bank['name']}}</span>
                        </div>
                        <div class="stamp-box">
                            <span>&nbsp;</span>
                        </div>
                        <div>
                            <span>{{$bank['directur']}}</span>
                        </div>
                        <div class="br-t">
                            <span>Direktur Utama</span>
                        </div>
                    </td>
                    <td>
                        <div>
                            <span>Debitur</span>
                        </div>
                        <div class="stamp-box">
                            <span>Materai <br/> Rp 10.000</span>
                        </div>
                        <div>
                            <span>{{$taspen['name']}}</span>
                        </div>
                        <div class="br-t">
                            <span>Debitur</span>
                        </div>
                    </td>
                    <td>
                        <div>
                            <span>Menyetujui</span>
                        </div>
                        <div class="stamp-box">
                            <span>&nbsp;</span>
                        </div>
                        <div>
                            <span> {{$has_relation ? $spouse['name']:''}}</span>
                        </div>
                        <div class="br-t">
                            <span>Suami / Istri / Ahli Waris*</span>
                        </div>
                    </td>
                </tr>
            </table>

        </p>
    </div>
</div>
<div class="page-break"></div>
