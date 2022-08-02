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
        $aksi = "media/aksi/layananumum.php";
        switch ($_GET['act']) {
            default:
                if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
                    $tgl = mysqli_query(
                        $koneksi,
                        "SELECT s_tglawal, s_tglakhir, s_thnang FROM s_settgl
                         ORDER BY idtgl ASC"
                    );
                    $rs        = mysqli_fetch_array($tgl);
                    $update = date('Y-m-d');

?>
                    <section class="page-heading fade-in-up">
                      <h4 class="page-title">
                        Tabel Stok Barang Persediaan<br>
                        <h6>Barang Persediaan masuk dan keluar</h6>
                      </h4>
                    </section>
                    <section class="content fade-in-up">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box">
                                        <div class="ibox">
                                            <div class="ibox-head">
                                                <div class="ibox-title">Referensi Persediaan</div>
                                            </div>
                                            <div class="ibox-body">
                                                <form method='post' class='form-horizontal' action='' enctype='multipart/form-data'>
                                                      <div class="form-group">
                                                          <div class="col-sm-5">
                                                            <label class="control-label">CARI KODE BARANG</label>
                                                              <select class="form-control s2"  name='kd_brg' onchange="this.form.submit();">
                                                                  <option value='BLANK'>PILIH</option>
                                                                  <?php
                                                                  $dataSql = "SELECT a.kd_brg, a.ur_brg, a.satuan, a.kd_kbrg, a.kd_jbrg,
                                                                                     b.kd_brg, b.flag
                                                                              FROM c_brgsedia a
                                                                              LEFT JOIN c_imgbrgsedia b ON b.kd_brg = a.kd_brg
                                                                              WHERE b.flag = '2'
                                                                              ORDER BY a.kd_brg ASC";
                                                                  $dataQry = mysqli_query($koneksi, $dataSql) or die("Gagal Query" . mysqli_error($koneksi));
                                                                  while ($dataRow = mysqli_fetch_assoc($dataQry)) {
                                                                      if ($dataRow['kd_brg'] == $_POST['kd_brg']) {
                                                                          $cek = " selected";
                                                                      } else {
                                                                          $cek = "";
                                                                      }
                                                                      echo "
                                                                      <option value='$dataRow[kd_brg]' $cek>$dataRow[kd_brg] - $dataRow[ur_brg]</option>";
                                                                  }
                                                                  $sqlData = "";
                                                                  ?>
                                                              </select>
                                                              <small>Nama Barang</small>
                                                          </div>
                                                      </div>
                                                  </form>
                                                  <?php

                                                    $a = mysqli_query($koneksi,
                                                        " SELECT a.kd_brg, a.ur_brg, a.satuan, 
                                                                 a.kd_kbrg, a.kd_jbrg,
                                                                 b.kd_brg, b.img, b.merek_type
                                                          FROM   c_brgsedia a
                                                          LEFT JOIN c_imgbrgsedia b ON b.kd_brg = a.kd_brg
                                                          WHERE  a.kd_brg='$_POST[kd_brg]'");
                                                          $data = mysqli_fetch_array($a);
                                                          $cekdata = mysqli_num_rows($a);
                                                          if(isset($_POST['kd_brg']) && $cekdata==0 ){
                                                          echo "
                                                          <font color='red'>
                                                          <h2>Kode Barang $a[kd_brg] $a[ur_brg] Tidak Ditemukan</h2>
                                                          </font>
                                                          ";
                                                                }else{
                                                      ?>
                                                <table id="table_3" class="table table-bordered table-striped responsive">
                                                    <thead>
                                                        <tr>
                                                            <th bgcolor='#88c7f2'> KODE BARANG</th>
                                                            <th bgcolor='#88c7f2'> URAIAN BARANG</th>
                                                            <th bgcolor='#88c7f2'> SATUAN</th>
                                                            <th bgcolor='#88c7f2'> MEREK_TYPE</th>
                                                            <th bgcolor='#88c7f2'> STOK GUDANG</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                    $querymasuk = mysqli_query($koneksi,
                                                              " SELECT a.kd_brg, a.ur_brg, a.satuan,
                                                                      b.kd_brg, SUM(b.kuantitas) AS masuk
                                                                FROM   c_brgsedia a
                                                                LEFT JOIN c_sediamasuk b ON b.kd_brg=a.kd_brg
                                                                WHERE  b.kd_brg='$_POST[kd_brg]'");
                                                    
                                                    $querykeluar = mysqli_query($koneksi,
                                                              " SELECT a.kd_brg, a.ur_brg, a.satuan,
                                                                       c.kd_brg, SUM(c.kuantitas) AS keluar
                                                                FROM   c_brgsedia a
                                                                LEFT JOIN c_sediakeluar c ON c.kd_brg=a.kd_brg
                                                                WHERE  c.kd_brg='$_POST[kd_brg]'");
                                                    $dm = mysqli_fetch_array($querymasuk);
                                                    $dk = mysqli_fetch_array($querykeluar);
                                                    $masuk=$dm['masuk'];
                                                    $keluar=$dk['keluar'];
                                                    $SAkr=$masuk-$keluar  ;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo "$data[kd_kbrg]"; ?> 
                                                            <?php echo "$data[kd_jbrg]"; ?></td>
                                                            <td><?php echo "$data[ur_brg]"; ?></td>
                                                            <td><?php echo "$data[satuan]"; ?></td>
                                                            <td><?php echo "$data[merek_type]"; ?></td>
                                                            <td align="center"><strong><?php echo "$SAkr"; ?></strong></td>
                                                        </tr>
                                                        </tfoot>
                                                        <?php } ?>
                                                </table> 
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
                ?>
<?php
        }
    }
}
?>