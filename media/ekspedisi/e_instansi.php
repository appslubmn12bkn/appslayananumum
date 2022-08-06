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
        $aksi = "media/aksi/ekspedisi.php";
        switch ($_GET['act']) {
            default:
                if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
                    $tgl = mysqli_query($koneksi,
                        "SELECT s_tglawal, s_tglakhir, s_thnang FROM s_settgl
                         ORDER BY idtgl ASC");
                    $rs        = mysqli_fetch_array($tgl); 
                    $update = date('Y-m-d');

?>
                    <section class="page-heading fade-in-up">
                      <h4 class="page-title">
                        Master Instansi<br>
                        <h6>Ekpedisi</h6>
                      </h4>
                    </section>
                    <section class='content fade-in-up'>
                        <div class='row'>
                            <div class='col-md-4'>
                                <div class='box'>
                                    <div class='ibox'>
                                        <div class='ibox-head'>
                                           <div class='ibox-title'>Pencarian</div>
                                        </div>
                                        <div class='ibox-body'> 
                                                <form method='post' class='form-horizontal' action=''>
                                                    <div class='form-group row'>
                                                        <div class='col-sm-12'>
                                                        <input type="text" class="form-control" placeholder="Ketik Nama Instansi" name="mas_masints" value='<?php echo "$_POST[mas_masints]"; ?>'>
                                                        <small>keyword : Nama Instansi / Kode Instansi</small>
                                                        </div>
                                                    </div>
                                                    <button type='submit' name='preview' class='btn btn-ms btn-primary'>
                                                    <i class="fa fa-search"></i>&nbsp;&nbsp;Detail</button>
                                                </form> 
                                                <?php
                                                $sql = "SELECT  INS_KODINS,INS_NAMINS
                                                        FROM m_instansi
                                                        ORDER BY INS_KODINS ASC";                     
                                                $a= mysqli_query($koneksi,$sql);
                                                $data = mysqli_fetch_array($a);
                                                $cekdata = mysqli_num_rows($a);
                                                if (isset($_POST['mas_masints']) && $cekdata == 0) {
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
                                           <div class='ibox-title'>Master Instansi</div>
                                        </div>
                                        <div class='ibox-body'> 
                                        <div class="row">
                                            <table class="table table-bordered table-striped mb-none" id="table_4">
                                                  <thead>
                                                  <tr>
                                                      <th bgcolor="#d2d6de">#</th>
                                                      <th bgcolor="#d2d6de">KODE INSTANSI</th>
                                                      <th bgcolor="#d2d6de">NAMA INSTANSI</th>
                                                      <th bgcolor="#d2d6de">KODE ANGKA</th>
                                                   </tr>
                                                   </thead>
                                                   <tbody>
                                                    <?php
                                                    $sql = "SELECT  INS_KODINS,INS_NAMINS,INS_KODANGKA
                                                            FROM m_instansi
                                                            WHERE INS_NAMINS LIKE '%$_POST[mas_masints]%' 
                                                            OR INS_KODINS LIKE '%$_POST[mas_masints]%'
                                                            ORDER BY INS_NAMINS ASC";
                                                    $tabel = mysqli_query($koneksi,$sql);
                                                    $numRows = mysqli_num_rows($tabel);
                                                    $no = 0;
                                                    while ($x = mysqli_fetch_array($tabel)) {
                                                        $no++;
                                                    ?>
                                                    <tr>
                                                      <td><?php echo"$no";?></td>
                                                      <td><?php echo"$x[INS_KODINS]";?></td>
                                                      <td><?php echo"$x[INS_NAMINS]";?></td>
                                                      <td><?php echo"$x[INS_KODANGKA]";?></td>
                                                    </tr>
                                                    </tfoot>
                                                    <?php } ?>
                                            </table> 
                                        </div>
                                            <font face=tahoma size=2>Jumlah Instansi terdeteksi: 
                                            <b><?php echo "$numRows"; ?></b></font>
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

