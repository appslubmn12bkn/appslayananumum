<?php
session_start();
error_reporting(0);
error_reporting('E_NONE');
include('../../config/fungsi_indotgl.php');
if (empty($_SESSION['UNAME']) and empty($_SESSION['PASSWORD'])) {
    echo "<link href='bootstrap/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
      			<center>
      			Modul Tidak Bisa Di Akses,
      			Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=index.php><b>LOGIN</b></a></center>";
} else {
    $cek = user_akses($_GET['module'], $_SESSION['NIP']);
    if ($cek == 1 or $_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
      //  $aksi = "media/aksi/pengajuan.php";
        switch ($_GET['act']) {
            default:
                if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
                    $query  = "SELECT s_tglawal, s_tglakhir, s_thnang FROM s_settgl ORDER BY idtgl ASC";
                    $tgl    = mysqli_query($koneksi,$query);
                    $rs     = mysqli_fetch_array($tgl);
                    $update = date('Y-m-d');

                    $sql = "SELECT  a.NIP, a.LEVEL, 
                                    a.LOGIN_TERAKHIR, a.LOKINS,
                                    b.pns_nip, b.pns_nama,
                                    c.kdukpb, c.nmukpb
                            FROM a_useraktif a
                            LEFT JOIN m_pegawai b ON b.pns_nip=a.NIP
                            LEFT JOIN s_satker c ON c.kdukpb = a.LOKINS
                            WHERE a.NIP='$_SESSION[NIP]'
                            GROUP BY a.NIP ASC ";
                    $us_log = mysqli_query($koneksi,$sql);
                    $log   = mysqli_fetch_array($us_log);

                    ?>
                    <section class="page-heading fade-in-up">
                      <h4 class="page-title">
                        DAFTAR BARANG MILIK NEGARA<br>
                        <h6>Penambahan Aset / BMN Kantor </h6>
                      </h4>
                    </section>

                    <section class="content fade-in-up">
                    <a class='btn btn-primary btn-md' href=<?php echo "?module=bmnTambah&act=tambah"; ?>>
                    <i class="fa fa-plus"></i>&nbsp;&nbsp;Tambah Barang Milik Negara </a>

                    <a class='btn btn-success btn-md' href=<?php echo "?module=bmnTambah&act=cetak"; ?>>
                    <i class="fa fa-print"></i>&nbsp;&nbsp;Cetak Transaksi Tambah </a>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box">
                                    <div class="ibox">
                                            <div class="ibox-head">
                                                <div class="ibox-title">
                                                TA : <?php echo "$rs[s_thnang]"; ?> | Satuan Kerja : <?php echo "$log[nmukpb]"; ?> 
                                                </div>
                                            </div>
                                            <div class="ibox-body">
                                                <div class="row">
                                                <table id="table_3" class="table table-bordered table-striped responsive">
                                                    <thead>
                                                        <tr>
                                                            <th bgcolor='#88c7f2'> NO </th>
                                                            <th bgcolor='#88c7f2'> KODEFIKASI</th>
                                                            <th bgcolor='#88c7f2'> NAMA BARANG</th>
                                                            <th bgcolor='#88c7f2'> NUP</th>
                                                            <th bgcolor='#88c7f2'> TGL_BUKU </th>
                                                            <th bgcolor='#88c7f2'> PEROLEHAN </th>
                                                            <th bgcolor='#88c7f2'> KONDISI </th>
                                                            <th bgcolor='#88c7f2'> QTY</th>
                                                            <th bgcolor='#88c7f2'> TRX</th>
                                                            <th bgcolor='#88c7f2'> RPH ASET</th>
                                                            <th bgcolor='#88c7f2'> MEREK_TYPE </th>
                                                            <th bgcolor='#88c7f2' width='25px'> UBAH</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $newData = mysqli_query(
                                                            $koneksi,
                                                            " SELECT a.b_kdbrg, a.b_noaset, 
                                                                     a.b_tgltrn,a.b_tglperlh, 
                                                                     a.b_tglbuku,a.b_kondisi, 
                                                                     a.b_kuantitas, a.b_rphaset,
                                                                     a.b_merektype, a.b_bmntrn,
                                                                     b.kd_brg, b.ur_sskel, b.satuan
                                                                FROM b_bmnBaru a
                                                                LEFT JOIN b_nmbmn b ON b.kd_brg = a.b_kdbrg
                                                                WHERE a.b_tglperlh BETWEEN '$rs[s_tglawal]' 
                                                                AND '$rs[s_tglakhir]'
                                                                ORDER BY a.b_kdbrg AND a.b_noaset ASC");

                                                        $no = 0;
                                                        while ($r = mysqli_fetch_array($newData)) {
                                                            $no++;
                                                        ?>
                                                            <tr>
                                                                <td><?php echo "$no"; ?></td>
                                                                <td><?php echo "$r[b_kdbrg]"; ?></td>
                                                                <td><?php echo "$r[ur_sskel]"; ?></td>
                                                                <td><?php echo "$r[b_noaset]"; ?></td>
                                                                <td><?php echo indotgl($r[b_tglbuku]); ?></td>
                                                                <td><?php echo indotgl($r[b_tglperlh]); ?></td>
                                                                <td><?php echo "$r[b_kondisi]"; ?></td>
                                                                <td><?php echo "$r[b_kuantitas]"; ?></td>
                                                                <td><?php echo "$r[b_bmntrn]"; ?></td>
                                                                <td><?php echo "$r[b_rphaset]"; ?></td>
                                                                <td><?php echo "$r[b_merektype]"; ?></td>
                                                                <td align="center">
                                                                <a class='btn btn-danger btn-md' href=<?php echo "?module=bmnTambah&act=updateBmn&kdbrg=$r[b_kdbrg]&nup=$r[b_noaset]"; ?>><i class='fa fa-edit'></i>
                                                                </a>
                                                                </td>
                                                            </tr>
                                                            </tfoot>
                                                        <?php } ?>
                                                </table> 
                                                </div>
                                            </div>
                                     </div>
                                </div>
                            </div>
                        </div>
                    </section>


               <?php
                } else {
                    echo "Anda tidak berhak mengakses halaman ini.";
                }
                break;

case "tambah":
if ($_SESSION['LEVEL']=='admin' or $_SESSION['LEVEL'] == 'user'){
$tampil = mysqli_query($koneksi, "SELECT * FROM b_sensus 
                                 WHERE b_kdbrg ='$_GET[kd_brg]' AND b_noaset = '$_GET[no_aset]'");
                       $r= mysqli_fetch_array($tampil);

?>
<!-- Page Content -->
                <section class="page-heading fade-in-up">
                    <h4 class="page-title">
                        Transaksi Aset / Barang Milik Negara<br>
                        <h6>Tambah</h6>
                      </h4>
                </section>
                <section class='content fade-in-up'>
                    <div class='row'>
                        <div class='col-md-12'>
                            <div class='box'>
                            <div class='ibox'>
                                <div class='ibox-head'>
                                    <div class='ibox-title'>TA : <?php echo "$rs[s_thnang]"; ?></div>
                                </div>
                                <div class='ibox-body'> 
                                <form method='post' class='form-horizontal' action='' enctype='multipart/form-data'>
                                    <div class="form-group row">
                                    <div class="col-sm-5">
                                        <label>Kode Barang (BMN)</label>
                                        <select class="form-control s2"  name='kd_brg' onchange="this.form.submit();">
                                            <option value='BLANK'>PILIH</option>
                                            <?php
                                                $dataSql = 
                                                "SELECT kd_brg, ur_sskel, satuan FROM b_nmbmn ORDER BY kd_brg ASC";
                                                $dataQry = mysqli_query($koneksi, $dataSql) or die("Gagal Query" . mysqli_error($koneksi));
                                                while ($dataRow = mysqli_fetch_assoc($dataQry)) {
                                                if ($dataRow['kd_brg'] == $_POST['kd_brg']) {
                                                $cek = " selected"; } else { $cek = ""; }
                                                echo "
                                                <option value='$dataRow[kd_brg]' $cek>$dataRow[kd_brg] - $dataRow[ur_sskel]</option>";
                                                }
                                                $sqlData = "";
                                            ?>
                                        </select>
                                        <small> Pilih Kode Barang : 31001xxx / Nama Barang </small>
                                    </div>
                                    </div>
                                </form>
                                <?php
                                    $brg = mysqli_query(
                                    $koneksi,
                                    " SELECT    a.kd_brg, a.ur_sskel, a.satuan
                                    FROM b_nmbmn a
                                    WHERE kd_brg = '$_POST[kd_brg]'
                                    ORDER BY nourut ASC");
                                    $a = mysqli_fetch_array($brg);
                                    $ceka = mysqli_num_rows($brg);
                                    if (isset($_POST['cari']) && $ceka == 0) {
                                    echo "
                                    <div class='alert bg-danger alert-danger text-white' role='alert'>
                                    <h4><i class='ik ik-alert-octagon'></i> Pemberitahuan!</h4>
                                    Coba Lagi
                                    </div>";
                                    } else {
                                ?>

                                    <?php } ?>                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>
<?php
}else{echo "Anda tidak berhak mengakses halaman ini.";}
break;

                ?>
<?php
        }
    }
}
?>
