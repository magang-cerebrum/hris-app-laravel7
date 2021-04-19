
<link href="../public/css/pdf/salary.css" rel="stylesheet">

<?php
    $count_allowance = count($data_allowance);
    $count_cut = count($data_cut);
?>

<div id="pdf-salary">
    <div class="head-salary">
        <table>
            <tr>
                <td class="head-image">
                    <img src="../public/img/title-cerebrum.jpg">
                </td>
                <td>
                    <h3>PT. Cerebrum Edukanesia Nusantara</h3>
                    <h5>Kp. Bunut RT 02/RW 09 Margahurip Banjaran Kab.Bandung</h5>
                    <p>E-mail : office@cerebrum.id</p>
                </td>
            </tr>
            <tr>
                <td class="sub-title" colspan="2">Slip Gaji</td>
            </tr>
        </table>
    </div>
    <div class="body-salary">
        <div class="border"></div>
        <table class="body-identity">
            <tr>
                <td class="identit-head">Nama</td>
                <td>:</td>
                <td class="value-identity">{{$data_staff->name}}</td>
                <td class="identity-empty"> </td>
                <td class="identit-head">Bulan</td>
                <td>:</td>
                <td>{{$month}}</td>
            </tr>
            <tr>
                <td class="identit-head">Jabatan</td>
                <td>:</td>
                <td class="value-identity">{{$data_staff->position}}</td>
                <td class="identity-empty"> </td>
                <td class="identit-head">Tahun</td>
                <td>:</td>
                <td>{{$year}}</td>
            </tr>
            <tr>
                <td class="identit-head">Divisi</td>
                <td>:</td>
                <td class="value-identity">{{$data_staff->division}}</td>
            </tr>
        </table>
        <div class="border"></div>
        <?php
            $check_allowance = true;
            $check_cut = true;
            $i=0;
        ?>
        <table class="body-count">
            <tr>
                <td colspan="4" class="title-count">Penerimaan</td>
                <td></td>
                <td colspan="4" class="title-count">Potongan</td>
            </tr>
            @while ($check_allowance == true || $check_cut == true)
                <tr>
                    @if ($check_allowance && $i < $count_allowance)
                        <td class="info-count">{{$data_allowance[$i]->name}}</td>
                        <td>:</td>
                        <td>Rp.</td>
                        <?php $format_number =  number_format($data_allowance[$i]->value,0, ',' , '.') ?>
                        <td class="value-count">{{$format_number}} ,-</td>    
                    @else
                        <td class="info-count"> </td> <td> </td> <td> </td> <td class="value-count"> </td>
                        <?php $check_allowance = false ?>
                    @endif
                    <td class="empty-count"> </td>
                    @if ($check_cut && $i < $count_cut)
                        <td class="info-count">{{$data_cut[$i]->name}}</td>
                        <td>:</td>
                        <td>Rp.</td>
                        <?php $format_number =  number_format($data_cut[$i]->value,0, ',' , '.') ?>
                        <td class="value-count">{{$format_number}} ,-</td>    
                    @else
                        <?php $check_cut = false ?>
                    @endif
                    <?php $i++ ?>
                </tr>
            @endwhile
            <tr><td colspan="9" class="empty-row"> </td></tr>
            <?php
                $format_allowance =  number_format($total_salary_allowance,0, ',' , '.');
                $format_cut =  number_format($total_salary_cut,0, ',' , '.');
                $format_salary =  number_format($total_salary,0, ',' , '.');
            ?>
            <tr>
                <td class="info-count">Total Penerimaan</td>
                <td>:</td>
                <td>Rp.</td>
                <td class="value-count">{{$format_allowance}} ,-</td>
                <td class="empty-count"> </td>
                <td class="info-count">Total Potongan</td>
                <td>:</td>
                <td>Rp.</td>
                <td class="value-count">{{$format_cut}} ,-</td>
            </tr>
            <tr><td colspan="9" class="empty-row"> </td></tr>
            <tr>
                <td>Take Home Pay</td>
                <td>:</td>
                <td>Rp.</td>
                <td class="value-count">{{$format_salary}} ,-</td>
            </tr>
            <tr>
                <td>Terbilang</td>
                <td>:</td>
                <td colspan="7">{{$string_salary}}</td>
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
                    <td>Bandung, {{$day.' '.$month.' '.$year}}</td>
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
                    <td>{{$data_staff->name}}</td>
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