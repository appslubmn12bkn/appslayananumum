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
                        <h6>Sejarah / Perjalanan </h6>
                      </h4>
                    </section>
                    
                    <section class="content fade-in-up">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="box">
                                    <div class="ibox">
                                        <div class="ibox-head">
                                            <div class="ibox-title">
                                            Satuan Kerja : <?php echo "$log[nmukpb]"; ?>
                                            </div>
                                        </div>
                                        <div class="ibox-body">
                                        <form method="POST" action="">
                                        <div class="row mb-3">
                                            <div class="col-sm-2">
                                            <div class="form-group">
                                                <select name="s_filter" id="s_filter" class="form-control">
                                                <option value="">Filter</option>
                                                <option value="kd_brg"<?php if ($s_filter=="kd_brg"){ echo "selected"; } ?>>Kode Barang</option>
                                                <option value="nm_brg" <?php if ($s_filter=="nm_brg"){ echo "selected"; } ?>>Nama Barang
                                                </option>
                                                </select>
                                            </div>
                                            </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <input type="text" placeholder="Keyword" name="s_keyword" id="s_keyword" class="form-control" value="<?php if (isset($_GET['s_keyword'])) {echo $_GET['s_keyword'];} ?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-1">
                                                    <div class="form-group">
                                                        <input type="text" placeholder="nup Awal" name="s_nupAW" id="s_nupAW" class="form-control" value="<?php if (isset($_GET['s_nupAW'])) {echo $_GET['s_nupAW'];} ?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-1">
                                                    <div class="form-group">
                                                        <input type="text" placeholder="nup Akhir" name="s_nupAK" id="s_nupAK" class="form-control" value="<?php if (isset($_GET['s_nupAK'])) {echo $_GET['s_nupAK'];} ?>">
                                                    </div>
                                                </div>

                                                <div class="col-sm-4" >
                                                    <button id="history" name="history" class="btn btn-danger">Tampilkan</button>
                                                </div>
                                            </div>
                                        </form>
                                        <?php
                                        if (isset($_POST['history'])) {
                                            $s_filter = $_POST['s_filter'];
                                            $s_keyword = $_POST['s_keyword'];
                                            if (empty($s_filter) and  empty($_POST['s_keyword']) and empty($_POST['nupAW']) and empty($_POST['nupAK'])) {
                                                echo "<script language='javascript'>alert('Masih ada yang belum diisi');
                                                window.location = 'landing.php?module=masterAset'</script>";
                                            } else {
                                        ?>
                                            <div class="row">
                                                <table id="table_4" class="table table-bordered table-striped responsive">
                                                    <thead>
                                                        <tr>
                                                            <th bgcolor='#88c7f2'> KODE</th>
                                                            <th bgcolor='#88c7f2'> UARIAN BMN</th>
                                                            <th bgcolor='#88c7f2'> NUP</th>
                                                            <th bgcolor='#88c7f2'> SAT </th>
                                                            <th bgcolor='#88c7f2'> TGL_BUKU</th>
                                                            <th bgcolor='#88c7f2'> TRX</th>
                                                            <th bgcolor='#88c7f2'> UR_TRX</th>
                                                            <th bgcolor='#88c7f2'> PEROLEH</th>     
                                                            <th bgcolor='#88c7f2'> TERCATAT</th>
                                                            <th bgcolor='#88c7f2'> UNIT</th>
                                                            <th bgcolor='#88c7f2'> RPH</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $query= 
                                                    "SELECT a.kd_brg,a.no_aset,
                                                            a.tgl_perlh, a.tgl_buku,
                                                            a.tercatat, a.jns_trn,
                                                            a.rph_aset,
                                                            b.kd_brg, b.ur_sskel, b.satuan,
                                                            c.jns_trn, c.ur_trn,
                                                            d.idcatat, d.tercatat, d.ur_catat
                                                     FROM b_masteraset a
                                                     LEFT JOIN b_nmbmn b ON b.kd_brg = a.kd_brg
                                                     LEFT JOIN b_transaksi c ON c.jns_trn = a.jns_trn 
                                                     LEFT JOIN b_tercatat d ON d.idcatat = a.tercatat 
                                                     WHERE a.kd_brg LIKE '%$s_keyword%' 
                                                     AND a.no_aset BETWEEN '$_POST[s_nupAW]' AND '$_POST[s_nupAK]'
                                                     OR b.ur_sskel LIKE '%$s_keyword%' 
                                                     AND a.no_aset BETWEEN '$_POST[s_nupAW]' AND '$_POST[s_nupAK]'
                                                     ORDER BY a.kd_brg AND a.no_aset ASC";
                                                    $masteru = mysqli_query($koneksi,$query);
                                                    $no = 0;
                                                    while ($r = mysqli_fetch_array($masteru)) {
                                                    $no++;
                                                    ?>
                                                        <tr>
                                                                <td><?php echo "$r[kd_brg]"; ?></td>
                                                                <td><?php echo "$r[ur_sskel]"; ?></td>
                                                                <td><?php echo "$r[no_aset]"; ?></td>
                                                                <td><?php echo "$r[satuan]"; ?></td>
                                                                <td><?php echo "$r[tgl_buku]"; ?></td>
                                                                <td><?php echo "$r[jns_trn]"; ?></td>
                                                                <td><?php echo "$r[ur_trn]"; ?></td>
                                                                <td><?php echo "$r[tgl_perlh]"; ?></td>
                                                                <td><?php echo "$r[tercatat]"; ?></td>
                                                                <td></td>
                                                                <td><?php echo "$r[rph_aset]"; ?></td>
                                                        </tr>
                                                        </tfoot>
                                                <?php } ?>
                                                </table> 
                                            <?php }} ?>

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
