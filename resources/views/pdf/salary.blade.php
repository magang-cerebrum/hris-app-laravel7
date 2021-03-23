{{-- <link href="{{ asset('css/fonts.css')}}" rel="stylesheet"> --}}
{{-- <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet"> --}}
{{-- <link href="public/css/nifty.min.css" rel="stylesheet"> --}}
{{-- <link href="../public/css/pdf/salary.css" rel="stylesheet"> --}}
<link href="{{ asset('css/pdf/salary.css')}}" rel="stylesheet">
{{-- <link href="../public/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"> --}}

<div id="pdf-salary">
    <div class="head-salary">
        <table>
            <tr>
                <td rowspan="3" class="head-image">
                    {{-- <img src="../public/img/logo-cerebrum.jpg"> --}}
                    <img src="{{ asset('img/title-cerebrum.jpg')}}">
                </td>
                <td>
                    <h3>PT. Cerebrum Edukanesia Nusantara</h3>
                    <h5>Kp. Bunut RT 02/RW 09 Margahurip Banjaran Kab.Bandung</h5>
                    <p>E-mail : office@cerebrum.id</p>
                </td>
            </tr>
            <tr><td class="empty"> </td></tr>
            <tr>
                <td class="sub-title">Slip Gaji</td>
            </tr>
        </table>
    </div>
    <div class="body-salary">
        <div class="border"></div>
        <table class="body-identity">
            <tr>
                <td class="identit-head">Nama</td>
                <td>:</td>
                <td class="value-identity">Dumy Staff</td>
                <td class="identity-empty"> </td>
                <td class="identit-head">Bulan - Tahun</td>
                <td>:</td>
                <td>Maret - 2021</td>
            </tr>
            <tr>
                <td class="identit-head">Jabaran</td>
                <td>:</td>
                <td class="value-identity">Dumy Jabatan</td>
            </tr>
            <tr>
                <td class="identit-head">Divisi</td>
                <td>:</td>
                <td class="value-identity">Dumy Divisi</td>
            </tr>
        </table>
        <div class="border"></div>
        <table class="body-count">
            <tr>
                <td colspan="4" class="title-count">Penerimaan</td>
                <td></td>
                <td colspan="4" class="title-count">Potongan</td>
            </tr>
            <tr>
                <td class="info-count-left">Gaji Pokok</td>
                <td>:</td>
                <td>Rp.</td>
                <td class="value-count">1.000.000 ,-</td>
                <td class="empty-count"></td>
                <td class="info-count-right">Pinjaman ke Cerebrum</td>
                <td>:</td>
                <td>Rp.</td>
                <td class="value-count">100.000 ,-</td>
            </tr>
            <tr>
                <td class="info-count-left">Bonus</td>
                <td>:</td>
                <td>Rp.</td>
                <td class="value-count">500.000 ,-</td>
                <td class="empty-count"></td>
                <td class="info-count-right">BMT (Potongan Wajib & Pokok)</td>
                <td>:</td>
                <td>Rp.</td>
                <td class="value-count">100.000 ,-</td>
            </tr>
            <tr>
                <td class="info-count-left">Lembur</td>
                <td>:</td>
                <td>Rp.</td>
                <td class="value-count">500.000 ,-</td>
                <td class="empty-count"></td>
                <td class="info-count-right">BMT (Pinjaman)</td>
                <td>:</td>
                <td>Rp.</td>
                <td class="value-count">50.000 ,-</td>
            </tr>
            <tr>
                <td class="info-count-left">Tunjangan Pulsa WFH</td>
                <td>:</td>
                <td>Rp.</td>
                <td class="value-count">200.000 ,-</td>
                <td class="empty-count"></td>
                <td class="info-count-right">Denda Keterlambatan</td>
                <td>:</td>
                <td>Rp.</td>
                <td class="value-count">200.000 ,-</td>
            </tr>
            <tr><td colspan="9" class="empty-row"> </td></tr>
            <tr>
                <td class="info-count-left">Total Penerimaan</td>
                <td>:</td>
                <td>Rp.</td>
                <td class="value-count">2.200.000 ,-</td>
                <td class="empty-count"></td>
                <td class="info-count-right">Total Potongan</td>
                <td>:</td>
                <td>Rp.</td>
                <td class="value-count">450.000 ,-</td>
            </tr>
            <tr><td colspan="9" class="empty-row"> </td></tr>
            <tr>
                <td>Take Home Pay</td>
                <td>:</td>
                <td>Rp.</td>
                <td class="value-count">1.750.000 ,-</td>
            </tr>
            <tr>
                <td>Terbilang</td>
                <td>:</td>
                <td colspan="7">Satu Juta Tujuh Ratus Lima Puluh Ribu Rupiah</td>
            </tr>
        </table>
        <div class="border"></div>
    </div>
    <div class="foot-salary">
        <div class="signature">
            <table>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Bandung, 23 Maret 2021</td>
                </tr>
                <tr>
                    <td class="name">Penerima</td>
                    <td class="empty"> </td>
                    <td class="name">Menyetujui</td>
                </tr>
                <tr>
                    <td class="col-signature" colspan="3"> </td>
                </tr>
                <tr>
                    <td>Dumy Admin</td>
                    <td></td>
                    <td>Hadi Rahman Fauzi</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Chief Development Officer</td>
                </tr>
            </table>
        </div>
    </div>
</div>