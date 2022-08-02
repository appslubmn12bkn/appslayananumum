<?php
session_start();
error_reporting(0);
error_reporting('E_NONE');
ob_start();
include('../../config/koneksi.php');
include('../../config/inc.library.php');
include('../../config/fungsi_indotgl.php');

if (empty($_SESSION['UNAME']) and empty($_SESSION['PASSWORD'])) {
    echo "<link href='../../asset/bootstrap/css/bootstrap.css' rel='stylesheet' type='text/css'>

                        <div class='alert alert-info'>
                        <br>
						<h2><i class='icon fa fa-info'></i> Pemberitahuan!</h2>
                        <b> MAAF BERITA ACARA TIDAK BISA DITAMPILKAN !,</b> <bR>
                        Untuk menampilkan BERITA ACARA yang mau dicetak, Anda harus login terlebih dahulu <br>
                        <br>
											  </div>";
} else {
    $html = '
<html>
<head>
</head>
<body>';

    echo "";
?>

    <html>

    <head>
        <meta name="viewport" content="width=device-width,initial-scale=1.0" />
        <style type="text/css">
            h1 {
                font-family: Bookman Old Style;
                font-size: 11px;
                font-style: italic;
                font-variant: normal;
                font-weight: 400;
                line-height: 15.6px;
            }

            h2 {
                font-family: Bookman Old Style;
                font-size: 11px;
                font-style: italic;
                font-variant: normal;
                font-weight: 400;
                line-height: 15.6px;
            }

            h3 {
                font-family: Bookman Old Style;
                font-size: 14px;
                font-style: normal;
                font-variant: normal;
                font-weight: bold;
                line-height: 15.4px;
            }

            h4 {
                font-family: Arial;
                font-size: 12px;
                text-align: left;
                font-variant: normal;
                font-weight: 400;
                line-height: 15.6px;
            }

            h5 {
                font-family: Arial;
                font-size: 12px;
                text-align: center;
                font-variant: normal;
                font-weight: 400;
                line-height: 15.6px;
            }

            p {
                font-family: Arial;
                font-size: 11px;
                font-style: normal;
                font-variant: normal;
                font-weight: 400;
                line-height: 20px;
            }

            blockquote {
                font-family: Bookman Old Style;
                font-size: 21px;
                font-style: normal;
                font-variant: normal;
                font-weight: 400;
                line-height: 30px;
            }

            pre {
                font-family: Bookman Old Style;
                font-size: 13px;
                font-style: normal;
                font-variant: normal;
                font-weight: 400;
                line-height: 18.5667px;
            }

            .table1 {
                font-family: sans-serif;
                color: #444;
                font-size: 11px;
                border-collapse: collapse;
                width: 100%;
                border: 1px solid #f2f5f7;
            }

            .table2 {
                font-family: sans-serif;
                font-size: 11px;
                border-collapse: collapse;
                width: 100%;
            }

            .table1 tr th {
                background: #fff;
                color: #000;
                font-weight: normal;
            }

            .table1,
            th,
            td {
                padding: 8px 20px;
            }

            .table1 tr:hover {
                background-color: #f5f5f5;
            }

            .table1 tr:nth-child(even) {
                background-color: #f2f2f2;
            }
        </style>
    </head>

    <body>
        <?php
        $tglawal  = $_GET['tglawal'];
        $tglakhir  = $_GET['tglakhir'];
        $update = date('Y-m-d');
        $query1 = "  UPDATE e_tblekspedisi 
                     SET e_flag  = '2',
                        e_tgldiambil = '$update'
                     WHERE e_tglterima BETWEEN '$tglawal' AND '$tglakhir'";
        mysqli_query($koneksi, $query1);

        $query2 = "  SELECT  a.e_tglterima, a.e_unitkirim, 
                            a.idekspedisi, a.e_instansi,
                            a.e_nosurat, a.e_alamat, 
                            a.e_flag, a.e_satker, 
                            b.r_idutama, b.r_ruangutama
                    FROM e_tblekspedisi a 
                    LEFT JOIN r_ruangutama b ON b.r_idutama = a.e_unitkirim
                    WHERE a.e_tglterima BETWEEN '$tglawal' AND '$tglakhir'
                    AND a.e_flag = '2'
                    ORDER BY idekspedisi ASC";
        $cek2 = mysqli_query($koneksi,$query2);
        $unik = mysqli_fetch_array($cek2);

        $sql = "SELECT * FROM s_satker";
        $satker = mysqli_query($koneksi, $sql);
        $head = mysqli_fetch_array($satker);

        $sql = "SELECT * FROM s_settgl ORDER BY idtgl ASC";
        $tgl = mysqli_query($koneksi,$sql);
        $rs = mysqli_fetch_array($tgl);
        $update = date('Y-m-d');
        ?>
        <br><br>
        <h4>
            <?php echo "$head[nmpb]"; ?><br>
            <?php echo "$head[nmukpb]"; ?>
        </h4>
        <h5>
            TRANSAKSI SURAT KELUAR / KIRIM EKSPEDISI
        </h5>
        <?php
        
        ?>
        <table border='1' class="table1">
            <thead>
                <tr>
                    <th align='center' width='20px'>No</th>
                    <th align='center' width='20px'>TANGGAL TERIMA</th>
                    <th align='center' width='100px'>UNIT PENGIRIM</th>
                    <th align='center' width='50px'>NOMOR SURAT</th>
                    <th align='center' width='50px'>TUJUAN SURAT</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = " SELECT a.e_tglterima, a.e_unitkirim, 
                                a.idekspedisi, a.e_instansi,
                                a.e_nosurat, a.e_alamat, 
                                a.e_flag, a.e_satker, 
                                b.r_idutama, b.r_ruangutama,
                                c.INS_KODINS, c.INS_NAMINS
                         FROM e_tblekspedisi a
                         LEFT JOIN r_ruangutama b ON b.r_idutama = a.e_unitkirim
                         LEFT JOIN m_instansi c ON c.INS_KODINS = a.e_instansi
                         WHERE a.e_tglterima BETWEEN '$tglawal' AND '$tglakhir'
                         AND a.e_tglterima BETWEEN '$rs[s_tglawal]' AND '$rs[s_tglakhir]' 
                         AND a.e_flag = '2'
                         ORDER BY idekspedisi ASC" ;
                $cek = mysqli_query($koneksi, $sql);
                $numRows = mysqli_num_rows($cek);
                $no = 0;
                while ($r = mysqli_fetch_array($cek)) {
                    $no++;
                ?>
                    <tr>
                        <td align='center'><?php echo "$no"; ?></td>
                        <td align='center'><?php echo indotgl($r['e_tglterima']); ?></td>
                        <td><?php echo "$r[r_ruangutama]"; ?></td>
                        <td align='center'><?php echo "$r[e_nosurat]"; ?></td>
                        <td><?php echo "$r[INS_NAMINS]"; ?><br>
                            <?php echo "$r[e_satker]"; ?><br>
                            <?php echo "$r[e_alamat]"; ?></td>

                    </tr>
                    </tfoot>
                <?php } ?>
        </table>
        <table width="100%"  class="table2">
            <tr>
                <td></td>
                <td></td>
                <td align="right">Pekanbaru, <?php echo indotgl($update); ?></td>
            </tr>
            <tr >
                <td>Petugas Sub. Bagian Umum</td>
                <td></td>
                <td align="center">Penyedia Ekspedisi<br>PT. Citra Van Titipan Kilat (TIKI) </td>
            </tr>
            <tr >
                <td></td>
                <td height='75px'></td>
                <td > </td>
            </tr>
            <tr >
                <td width='230px'>(_______________________________)</td>
                <td></td>
                <td width='230px'>(_______________________________)</td>
            </tr>
        </table>
    </body>

    </html>
<?php } ?>
<?php
$out = ob_get_contents();
ob_end_clean();
include("../../MPDF/mpdf.php");
$mpdf = new mPDF('c', 'F4-P', '');
$mpdf->SetDisplayMode('fullpage');
$stylesheet = file_get_contents('mpdf/mpdf.css');
$mpdf->WriteHTML($stylesheet, 1);
$mpdf->WriteHTML($html);
$mpdf->WriteHTML($out);
$mpdf->Output();
?>