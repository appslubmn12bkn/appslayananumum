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
        $aksi = "media/aksi/pengajuan.php";
        switch ($_GET['act']) {
            default:
                if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
                    $query  = "SELECT s_tglawal, s_tglakhir, s_thnang FROM s_settgl ORDER BY idtgl ASC"
                    $tgl    = mysqli_query($koneksi,$query);
                    $rs     = mysqli_fetch_array($tgl);
                    $update = date('Y-m-d');

?>
                    <section class="page-heading fade-in-up">
                      <h4 class="page-title">
                        Blanko Pengajuan (Unit)<br>
                        <h6>Barang Persediaan masuk dan keluar</h6>
                      </h4>
                    </section>
                    <section class='content fade-in-up'>
                        <div class='row'>
                            <div class='col-md-4'>
                                <div class='box'>
                                    <div class='ibox'>
                                        <div class='ibox-head'>
                                           <div class='ibox-title'>Registrasi</div>
                                        </div>
                                        <div class='ibox-body'> 
                                        <strong>NOMOR REGISTRASI : </strong>
                                                <form method='post' class='form-horizontal' action=''>
                                                    <div class='form-group row'>
                                                        <div class='col-sm-9'>
                                                            <select class="form-control" style="width: 100%" 
                                                            name='registrasi'>
                                                                <option value=''></option>
                                                                <?php
                                                                $Sql = "SELECT  a.registrasi, a.unut, 
                                                                                a.unit, a.prosedur,
                                                                                b.r_idutama, b.r_ruangutama
                                                                        FROM c_unitsediaminta a 
                                                                        LEFT JOIN r_ruangutama b ON b.r_idutama=a.unut
                                                                        WHERE a.prosedur = '3'
                                                                        ORDER BY a.registrasi ASC";
                                                                $Qry = mysqli_query($koneksi, $Sql) 
                                                                or die("Gagal Query" . mysqli_error($koneksi));
                                                                while ($dataRow = mysqli_fetch_array($Qry)) {
                                                                if ($dataRow['registrasi'] == $_POST['registrasi']) {
                                                                $cek = " selected"; } else { $cek = ""; }
                                                                echo "
                                                                <option value='$dataRow[registrasi]' 
                                                                $cek>$dataRow[registrasi]  -  $dataRow[r_ruangutama]
                                                                </option>";}
                                                                $sqlData = "";
                                                                ?>
                                                            </select>
                                                        </div>
                                                    <button type='submit' name='preview' class='btn btn-ms btn-primary'>
                                                    Detail</button>
                                                    </div>
                                                </form> 
                                                <?php
                                                $sql = "SELECT  a.registrasi, a.unut, 
                                                                a.unit,
                                                                b.r_idutama, b.r_ruangutama                          
                                                        FROM c_unitsediaminta a 
                                                        LEFT JOIN r_ruangutama b ON b.r_idutama=a.unut
                                                        WHERE  a.registrasi ='$_POST[registrasi]'
                                                        ORDER BY a.registrasi ASC";                     
                                                $a= mysqli_query($koneksi,$sql);
                                                $data = mysqli_fetch_array($a);
                                                $cekdata = mysqli_num_rows($a);
                                                if (isset($_POST['registrasi']) && $cekdata == 0) {
                                                echo "<Font color='red'> <h3>DATA TIDAK DITEMUKAN!</h3></font>";
                                                } else {
                                                ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <div class='col-md-8'>
                                <div class='box'>
                                    <div class='ibox'>
                                        <div class='ibox-head'>
                                           <div class='ibox-title'>Detail Permintaan</div>
                                        </div>
                                        <div class='ibox-body'> 
                                        <div class="row">
                                            <table class="table table-bordered table-striped mb-none" id="table_4">
                                                  <thead>
                                                  <tr>
                                                      <th bgcolor="#d2d6de">#</th>
                                                      <th bgcolor="#d2d6de">URAIAN (KODE - NAMA)</th>
                                                      <th bgcolor="#d2d6de">PENGAJUAN</th>
                                                      <th bgcolor="#d2d6de">MEREK_TYPE</th>
                                                      <th bgcolor="#d2d6de">TRANSAKSI</th>
                                                      <th bgcolor="#d2d6de">TGL MOHON</th>
                                                   </tr>
                                                   </thead>
                                                   <tbody>
                                                    <?php
                                                    $tabel = mysqli_query($koneksi,
                                                    "SELECT a.registrasi, a.tglproses, 
                                                            a.satuan, a.flag_kirim, 
                                                            a.kd_brg, a.qtyACC, a.tanggaltl,
                                                            a.qtyMohon, a.merek_type, a.prosedur,
                                                            b.registrasi, a.catatanpersetujuan, 
                                                            a.catatanklaim,
                                                            b.tglmohon, b.prosedur,
                                                            c.kd_brg, c.ur_brg, c.kd_kbrg, c.kd_jbrg,
                                                            d.flag, d.ur_flag,
                                                            e.kd_brg, e.jns_trn
                                                    FROM c_sediakeluarunit  a
                                                    LEFT JOIN c_unitsediaminta b ON b.registrasi = a.registrasi
                                                    LEFT JOIN c_brgsedia c ON c.kd_brg = a.kd_brg
                                                    LEFT JOIN c_prosedia d ON d.flag = a.prosedur
                                                    LEFT JOIN c_sediakeluar e ON e.kd_brg = a.kd_brg
                                                    WHERE a.registrasi = '$_POST[registrasi]' 
                                                    AND (a.prosedur IN ('3','61')) 
                                                    AND a.flag_kirim = 'Y'
                                                    ORDER BY a.registrasi ASC");

                                                    $numRows = mysqli_num_rows($tabel);
                                                    $no = 0;
                                                    while ($x = mysqli_fetch_array($tabel)) {
                                                        $no++;
                                                    ?>
                                                    <tr>
                                                      <td><?php echo"$no";?></td>
                                                      <td><?php echo"$x[kd_kbrg] $x[kd_jbrg] - $x[ur_brg]";?></td>
                                                      <td><?php echo"$x[qtyMohon] $x[satuan]";?></td>
                                                      <td><?php echo"$x[merek_type]";?></td>
                                                      <td><?php echo"$x[jns_trn]";?></td>
                                                      <td><?php echo indotgl($x[tglmohon]);?></td>
                                                    </tr>
                                                    </tfoot>
                                                    <?php } ?>
                                            </table> 
                                        </div>
                                            <font face=tahoma size=2>Jumlah ATK/ARTK/BAKOM diajukan: <b><?php echo "$numRows"; ?></b></font>
                                            <table>
                                            <thead>
                                            <tr>
                                            <th>
                                            <form method=POST action='<?php echo "media/sedia_cetak/sedia_cetaklamp.php?registrasi=$_POST[registrasi]"; ?>' target='_blank'>
                                            <button type=submit class='btn btn-danger btn-sm'><i class='fa fa-print'></i>
                                            &nbsp;&nbsp;&nbsp;Cetak Bon (Pdf.)</button></a>
                                            </form>
                                            </th>
                                            </tr>
                                            </thead>
                                            </table>
                                            <?php } ?>
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
                ?>
<?php
        }
    }
}
?>

