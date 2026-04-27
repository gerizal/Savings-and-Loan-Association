<div class="row">
    <div class="col-md-12">
        <div class="header">
            <div class="brand-flex left-logo">
                @if ($bank['logo']!='')
                    <img src="{{$bank['logo']}}" alt="" style="width:60px; height:60px; margin:0px" class="pull-left"/>
                @endif
            </div>
            <div  class="brand-flex" style="width:60%">
                <h3 style="margin-bottom:5px;" class="text-center">CHECKLIST KELENGKAPAN DOKUMENPEMBIAYAAN PENSIUNAN</h3>
            </div>
            <div  class="brand-flex right-logo">
                <img src="{{public_path('img/logo_kpf.jpg')}}" alt="" style="width:60px; height:60px; margin:0px" class="pull-right"/>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table>
            <tr><td>Nama Debitur&emsp;&emsp;</td><td>: {{$taspen['name']}}</td></tr>
            <tr><td>No.SK Pensiun &emsp;&emsp;</td><td>: {{$taspen['skep_number']}}</td></tr>
            <tr><td>Pembiayaan &emsp;&emsp;</td><td>: {{formatIDR($plafon)}}</td></tr>
            <tr><td>Angsuran &emsp;&emsp;</td><td>: {{formatIDR($installment)}}</td></tr>
            <tr><td>Jangka Waktu &emsp;&emsp;</td><td>: {{$tenor}}</td></tr>
            <tr><td>Produk Pembiayaan&emsp;&emsp;</td><td>: {{$product['name']}}</td></tr>
            <tr><td>Jenis Pembiayaan &emsp;&emsp;</td><td>: {{$finance_type['name']}}</td></tr>
        </table>
        <br/>
        <table  class="text-center align-top tb-bordered" style="width: 100%;">
            <thead class="bg-yellow text-center">
                <tr class="text-center">
                    <th class="text-center" rowspan="2" style="width: 30px">No</th>
                    <th class="text-center" rowspan="2" style="width: 300px">Dokumen Persyaratan Pengajuan Pembiayaan</th>
                    <th class="text-center" colspan="2">Cek Marketing</th>
                    <th class="text-center" rowspan="2" style="width: 50px">Lbr</th>
                    <th class="text-center" colspan="2">Cek Mitra Pusat</th>
                    <th class="text-center" rowspan="2" style="width: 50px">Lbr</th>
                    <th class="text-center" colspan="2">Cek {{$bank['code']}}</th>
                    <th class="text-center" rowspan="2" style="width: 50px">Lbr</th>
                </tr>
                <tr>
                    <th class="text-center">Asli</th>
                    <th class="text-center">FC</th>
                    <th class="text-center">Asli</th>
                    <th class="text-center">FC</th>
                    <th class="text-center">Asli</th>
                    <th class="text-center">FC</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td class="text-left" style="padding: 3px;"> &nbsp; KTP Pemohon</td>
                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td class="text-left" style="padding: 3px;"> &nbsp; KTP Suami Istri</td>
                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td class="text-left" style="padding: 3px;"> &nbsp; Kartu Keluarga Pemohon</td>
                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td class="text-left" style="padding: 3px;"> &nbsp; KTP NPWP (untuk pembiayaan >Rp. 50 Jt)</td>
                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td>5</td>
                    <td class="text-left" style="padding: 3px;"> &nbsp; Perjanjian Kredit halaman 1, 2 dan 3</td>
                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td>6</td>
                    <td class="text-left" style="padding: 3px;"> &nbsp; Jadwal Angsuran untuk {{$bank['code']}}</td>
                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td>7</td>
                    <td class="text-left" style="padding: 3px;"> &nbsp; Surat Pernyataan DSR 70%</td>
                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td>8</td>
                    <td class="text-left" style="padding: 3px;"> &nbsp; Surat Pernyataan dan Kesanggupan</td>
                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td>9</td>
                    <td class="text-left" style="padding: 3px;"> &nbsp; KARIP/Buku ASABRI</td>
                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td>10</td>
                    <td class="text-left" style="padding: 3px;"> &nbsp; Slip Gaji (POS)/Rekening Koran (Bank)/Print Out Butab (Bank) 3 BulanTerakhir</td>
                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td>11</td>
                    <td class="text-left" style="padding: 3px;"> &nbsp; Analisa Perhitungan/Simulasi</td>
                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td>12</td>
                    <td class="text-left" style="padding: 3px;"> &nbsp; Form Permohonan Pembiayaan Pensiun</td>
                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td>13</td>
                    <td class="text-left" style="padding: 3px;"> &nbsp; Surat Keterangan dan Pernyataan Perihal Kesehatan dan Domisili Debitur</td>
                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td>14</td>
                    <td class="text-left" style="padding: 3px;"> &nbsp; Surat Keterangan dan Pernyataan Perihal Perbedaan Identitas</td>
                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td>15</td>
                    <td class="text-left" style="padding: 3px;"> &nbsp; Surat Pernyataan DEBITUR Mitra Kerja PT. Pos Indonesia</td>
                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>
            </tbody>
        </table>
        <br/>
        <table  class="text-center align-top tb-bordered" style="width: 100%;">
            <thead class="bg-yellow">
                <tr>
                    <th rowspan="2" class="text-center" style="width: 30px">No</th>
                    <th rowspan="2" class="text-center" style="width: 300px">Deskripsi Dokumen</th>
                    <th rowspan="2" class="text-center">Asli/Copy</th>
                    <th colspan="3" class="text-center">Checklist</th>
                </tr>
                <tr>
                    <th class="text-center">Marketing</th>
                    <th class="text-center">Mitra Pusat</th>
                    <th class="text-center">{{$bank['code']}}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td class="text-left" style="padding: 3px;"> &nbsp; Surat Keputusan Pensiun</td>
                    <td>Asli</td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td class="text-left" style="padding: 3px;"> &nbsp; Data Pembelian Barang</td>
                    <td>Asli</td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td class="text-left" style="padding: 3px;"> &nbsp; Jadwal Anguran (Repayment schedule)</td>
                    <td>Asli</td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td class="text-left" style="padding: 3px;"> &nbsp; Bukti Pencairan Pembiayaan</td>
                    <td>Asli</td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td>5</td>
                    <td class="text-left" style="padding: 3px;"> &nbsp; Tanda terima penyeraan jaminan</td>
                    <td>Asli</td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td>6</td>
                    <td class="text-left" style="padding: 3px;"> &nbsp; Suran Penyataan Pemotongan Gaji > 70%</td>
                    <td>Asli</td><td></td><td></td><td></td>
                </tr>
            </tbody>
        </table>
        <p>Keterangan :</p>
        <table>
            <tr><td></td><td>Isi dengan tanda cek (v)</td></tr>
            <tr><td>*</td><td>Coret yang tidak perlu</td></tr>
            <tr><td>**</td><td>Bila ada wajib dilampirkan Seluruh dokumen menggunakan kertas A4 70 gram</td></tr>
            <tr style="color: red;"><td>***</td><td>Semua Form-form yang di minta sudah di isi lengkap (Redaksi, Materai, Tanda Tangan terkait)</td></tr>
            <tr style="color: red;"><td>****</td><td>Cabang Mengirim berkas H+2 dari tanggal Pencairan Tahap 2</td></tr>
            <tr style="color: red;"><td>***** &emsp;</td><td>Maksimal pengiriman berkas tanggal 5 bulan berikutnya</td></tr>
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
            <div  class="brand-flex" style="width:60%">
                <h3 style="margin-bottom:5px;" class="text-center">DOKUMENT CHECKLIST</h3>
            </div>
            <div  class="brand-flex right-logo">
                <img src="{{public_path('img/logo_kpf.jpg')}}" alt="" style="width:60px; height:60px; margin:0px" class="pull-right"/>
            </div>
        </div>
    </div>
</div>
<div class="row mt-15">
    <div class="col-md-12">
        <table  class="text-center align-top tb-bordered" style="width: 100%;">
            <thead class="bg-yellow">
                <tr><th colspan="6"  class="text-center">Sekat 1</th></tr>
                <tr>
                    <th rowspan="2" style="width: 30px"  class="text-center">No</th>
                    <th rowspan="2" style="width: 300px" class="text-center">Deskripsi Dokumen</th>
                    <th rowspan="2"  class="text-center">Asli/Copy</th>
                    <th colspan="3" class="text-center">Checklist</th>
                </tr>
                <tr>
                    <th class="text-center">Marketing</th>
                    <th class="text-center">Mitra Pusat</th>
                    <th class="text-center">{{$bank['code']}}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td class="text-left" style="padding: 3px;"> &nbsp; KTP Pemohon</td>
                    <td>Copy</td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td class="text-left" style="padding: 3px;"> &nbsp; KTP Suami / Istri*</td>
                    <td>Copy</td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td class="text-left" style="padding: 3px;"> &nbsp; Katu Keluarga Pemohon</td>
                    <td>Copy</td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td class="text-left" style="padding: 3px;"> &nbsp; NPWP </td>
                    <td>Copy</td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td>5</td>
                    <td class="text-left" style="padding: 3px;"> &nbsp; KARIP / Buku ASABRI</td>
                    <td>Copy</td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td>6</td>
                    <td class="text-left" style="padding: 3px;"> &nbsp; Slip Gaji karyawan / Rekening Bank 3 Bln Terakhir</td>
                    <td>Asli</td><td></td><td></td><td></td>
                </tr>
            </tbody>
        </table>
        <br/>
        <table  class="text-center align-top tb-bordered" style="width: 100%;">
            <thead class="bg-yellow">
                <tr><th colspan="6" class="text-center">Sekat 2</th></tr>
                <tr>
                    <th rowspan="2" style="width: 30px"  class="text-center">No</th>
                    <th rowspan="2" style="width: 300px"  class="text-center">Deskripsi Dokumen</th>
                    <th rowspan="2" class="text-center">Asli/Copy</th>
                    <th colspan="3" class="text-center">Checklist</th>
                </tr>
                <tr>
                    <th class="text-center">Marketing</th>
                    <th class="text-center">Mitra Pusat</th>
                    <th class="text-center">{{$bank['code']}}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td class="text-left" style="padding: 3px;"> &nbsp; Analisa Pembiayaan </td>
                    <td>Asli</td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td class="text-left" style="padding: 3px;"> &nbsp; Form Permohonan Pembiayaan Pensiun</td>
                    <td>Asli</td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td class="text-left" style="padding: 3px;"> &nbsp; Surat Keterangan Asli Pos</td>
                    <td>Asli</td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td class="text-left" style="padding: 3px;"> &nbsp; Surat pernyataan ketentuan pembiayaan, keterangan kesehatan dan domisili pemohon</td>
                    <td>Asli</td><td></td><td></td><td></td>
                </tr>
                <tr>
                    <td>5</td>
                    <td class="text-left" style="padding: 3px;"> &nbsp; Surat Keterangan / Pernyataan Lainnya</td>
                    <td>Asli</td><td></td><td></td><td></td>
                </tr>
            </tbody>
        </table>
        <br/>
        <br/>
        <table class="text-center align-top tb-sign" style="width: 100%;">
            <tr>
                <td style="padding:25px 50px;">
                    <div>
                        <span>Telah Diperiksa: Lengkap/Tidak*<br/>Yang menyerahkan</span>
                    </div>
                    <div class="stamp-box-m">
                        <span>&nbsp;</span>
                    </div>
                    <div>
                        <span>&nbsp;</span>
                    </div>
                    <div class="br-t">
                        <span>PETUGAS PELAYANAN MITRA {{$bank['code']}}</span>
                    </div>
                </td>
                <td style="padding:25px 50px;">
                    <div>
                        <span>Telah Diperiksa: Lengkap/Tidak*<br/>Yang menerima dan memeriksa</span>
                    </div>
                    <div class="stamp-box-m">
                        <span>&nbsp;</span>
                    </div>
                    <div>
                        <span>&nbsp;</span>
                    </div>
                    <div  class="br-t">
                        <span>ADM FILLING</span>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
