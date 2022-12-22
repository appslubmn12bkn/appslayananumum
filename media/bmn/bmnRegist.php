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
      $aksi = "media/AKSI/savebmn.php";
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
                        LAYANAN UMUM BARANG MILIK NEGARA<br>
                        <h6>Label Registrasi / Barcode </h6>
                      </h4>
                    </section>

                    <section class="content fade-in-up">
                    <a class='btn btn-primary btn-md' href=<?php echo "?module=bmnRegist&act=label"; ?>>
                    <i class="fa fa-print"></i>&nbsp;&nbsp;Cetak Label Registrasi / Barcode </a>
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
                                                            <th bgcolor='#88c7f2'> URAIAN</th>
                                                            <th bgcolor='#88c7f2'> NUP</th>
                                                            <th bgcolor='#88c7f2'> MEREK_TYPE</th>
                                                            <th bgcolor='#88c7f2'> STATUS</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            </tfoot>
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

case "label":
if ($_SESSION['LEVEL']=='admin' or $_SESSION['LEVEL'] == 'user'){
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
<!-- Page Content -->
                <section class="page-heading fade-in-up">
                    <h4 class="page-title">
                        Transaksi Aset / Barang Milik Negara<br>
                        <span class="badge badge-success badge-pill m-r-5 m-b-5">Tambah BMN Baru</span>
                      </h4>
                </section>
                <section class='content fade-in-up'>
                    <div class='row'>
                        <div class='col-md-12'>
                            <div class='box'>
                            <div class='ibox'>
                                <div class='ibox-head'>
                                    <div class='ibox-title'>TA : <?php echo "$rs[s_thnang]"; ?> <?php echo "$log[LOKINS]"; ?></div>
                                </div>
                                <div class='ibox-body'> 
                                <form method="POST" action="">
                                   <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Pencarian Kodefikasi</label>
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <select class="form-control s2" name='kd_brg'>
                                                  <option value='BLANK'>PILIH</option>
                                                  <?php
                                                    $dataSql = "SELECT a.kd_brg, a.ur_sskel, a.satuan
                                                                FROM  b_nmbmn a 
                                                                ORDER BY kd_brg ASC";
                                                    $dataQry = mysqli_query($koneksi, $dataSql) or die ("Gagal Query".mysql_error());
                                                    while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                    if ($dataRow['kd_brg']==$_POST['kd_brg']) {
                                                      $cek = " selected";
                                                    } else { $cek=""; }
                                                    echo "
                                                  <option value='$dataRow[kd_brg]' $cek>$dataRow[kd_brg]  -  $dataRow[ur_sskel]</option>";
                                                    }
                                                    $sqlData ="";
                                                    ?>
                                                  </select>
                                            </div>
                                        <button type="submit" class='btn btn-danger btn-sm'><i class="fa fa-search"></i> Tampilkan</button>
                                        </div>
                                    </div>                                        
                                </form>
                                  <?php
                                    $a = mysqli_query($koneksi,
                                    " SELECT a.kd_brg, a.ur_sskel, a.satuan
                                      FROM   b_nmbmn a
                                      WHERE  a.kd_brg='$_POST[kd_brg]'");
                                    $r = mysqli_fetch_array($a);
                                    $cekdata = mysqli_num_rows($a);
                                    if(isset($_POST['kd_brg']) && $cekdata==0 ){
                                      echo "
                                      <h4>Ulang Lagi</h4>";
                                    }else{
                                  ?>
                                <form method='post' class='form-horizontal' action='<?php echo "$aksi?module=bmnTambah&act=addBMN"; ?>' enctype='multipart/form-data'>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"></label>
                                        <div class="col-sm-2">
                                        <input type="text" class="form-control" name='kd_brg' id="kd_brg" value='<?php echo "$r[kd_brg]"; ?>' readonly>
                                        </div>

                                        <div class="col-sm-5">
                                        <input type="text" class="form-control" name='nm_brg' id="nm_brg" value='<?php echo "$r[ur_sskel]"; ?>' readonly>
                                        </div>

                                        <div class="col-sm-2">
                                        <input type="text" class="form-control" name='satuan' id="satuan" value='<?php echo "$r[satuan]"; ?>' readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Tahun Anggaran</label>
                                        <div class="col-sm-1">
                                        <input type="text" class="form-control" name='thn_ang' value='<?php echo "$rs[s_thnang]"; ?>' readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Periode Anggaran</label>
                                        <div class="col-sm-1">
                                        <input type="text" class="form-control" name='periode' value='<?php echo date(m); ?>' readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Kode Satuan Kerja</label>
                                        <div class="col-sm-2">
                                        <input type="text" class="form-control" name='kdsatker' value='<?php echo "$log[kdukpb]"; ?>' readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Jenis Transaksi (Trx)</label>
                                        <div class="col-sm-4">
                                            <select class="form-control s2" name='jns_trn'>
                                                <option value='BLANK'>PILIH</option>
                                                <option value='101'>101 - Pembelian [Pengadaan Sendiri]</option>
                                                <option value='102'>102 - Transfer Masuk [Pengadaan Pusat]</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Jumlah BMN</label>
                                        <div class="col-sm-1">
                                        <input type="text" maxlength="3" class="form-control" name='qty' id="qty" value='<?php echo "$_POST[qty]"; ?>' onkeyup=sum2();>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">No Aset</label>
                                        <div class="col-sm-1">
                                        <input type="text" class="form-control" maxlength="3" name='nupAW' id="nupAW" value='<?php echo "$_POST[nupAW]"; ?>' onkeyup=sum2();>
                                        <small>Awal</small>
                                        </div>

                                        <div class="col-sm-1">
                                        <input type="text" class="form-control" maxlength="3" name='nupAK' id="nupAK" value='<?php echo "$_POST[nupAK]"; ?>' readonly>
                                        <small>Akhir</small>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Tanggal Transaksi</label>
                                        <div class="col-sm-2">
                                        <input type="text" maxlength="12" class="form-control" name='b_tgltrn' id="b_tgltrn" value='<?php echo date("Y-m-d"); ?>' readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Tanggal Perolehan</label>
                                        <div class="col-sm-2">
                                        <input type="text" maxlength="12" class="form-control datepicker" name='b_tglperlh' id="b_tglperlh" value='<?php echo "$_POST[b_tglperlh]"; ?>'>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Tanggal Pembukuan</label>
                                        <div class="col-sm-2">
                                        <input type="text" maxlength="12" class="form-control datepicker" name='b_tglbuku' id="b_tglbuku" value='<?php echo "$_POST[b_tglbuku]"; ?>'>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Kuantitas Trx</label>
                                        <div class="col-sm-1">
                                        <input type="text" maxlength="3" class="form-control" name='b_kuantitas' id="b_kuantitas" value='1' readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Kondisi BMN</label>
                                        <div class="col-sm-3">
                                            <select class="form-control s2" name='b_kondisi'>
                                                <option value='BLANK'>PILIH</option>
                                                <option value='1'>BB - Barang Baik</option>
                                                <option value='2'>RR - Rusak Ringan</option>
                                                <option value='3'>RB - Rusak Berat</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">BMN Tercatat</label>
                                        <div class="col-sm-3">
                                            <select class="form-control s2" name='b_tercatat'>
                                                <option value='BLANK'>PILIH</option>
                                                <option value='1'>DBR - Daftar Barang Ruangan</option>
                                                <option value='2'>DBL - Daftar Barang Lainnya</option>
                                                <option value='3'>KIB - Kartu Induk Barang</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Asal Perolehan</label>
                                        <div class="col-sm-10">
                                        <input type="text" class="form-control" name='b_bmnasalperlh' id="b_bmnasalperlh" value='<?php echo "$_POST[b_bmnasalperlh]"; ?>'>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Merek / Type</label>
                                        <div class="col-sm-10">
                                        <input type="text" class="form-control" name='b_merektype' id="b_merektype" value='<?php echo "$_POST[b_merektype]"; ?>'>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Keterangan</label>
                                        <div class="col-sm-10">
                                        <input type="text" class="form-control" name='b_keterangan' id="b_keterangan" value='<?php echo "$_POST[b_keterangan]"; ?>'>
                                        </div>
                                    </div>

                                    <fieldset>
                                    <label for='Kode' class='col-sm-2 control-label'></label>
                                    <button type=submit Data class='btn btn-primary btn-md'>
                                    <i class='fa fa-check'></i>&nbsp;&nbsp;&nbsp;Simpan </button>

                                    <button type=reset class='btn btn-dark btn-md'>
                                    <i class='fa fa-times'></i>&nbsp;&nbsp;&nbsp; Clear </button>

                                    <a class='btn btn-danger btn-md' href=<?php echo "?module=bmnTambah"; ?>>
                                    <i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Kembali </a>
                                    </fieldset>

                                </form>
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

case "upHarga":
if ($_SESSION['LEVEL']=='admin' or $_SESSION['LEVEL'] == 'user'){
?>
<!-- Page Content -->
                <section class="page-heading fade-in-up">
                    <h4 class="page-title">
                        Transaksi Aset / Barang Milik Negara<br>
                        <span class="badge badge-primary badge-pill m-r-5 m-b-5">Update Harga BMN</span>
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
                                <form method="POST" action="">
                                   <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Pencarian Kodefikasi</label>
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <select class="form-control s2" name='kd_brg'>
                                                  <option value='BLANK'>PILIH</option>
                                                  <?php
                                                    $dataSql = "SELECT a.kd_brg, a.ur_sskel, a.satuan
                                                                FROM  b_nmbmn a 
                                                                ORDER BY kd_brg ASC";
                                                    $dataQry = mysqli_query($koneksi, $dataSql) or die ("Gagal Query".mysql_error());
                                                    while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                    if ($dataRow['kd_brg']==$_POST['kd_brg']) {
                                                      $cek = " selected";
                                                    } else { $cek=""; }
                                                    echo "
                                                  <option value='$dataRow[kd_brg]' $cek>$dataRow[kd_brg]  -  $dataRow[ur_sskel]</option>";
                                                    }
                                                    $sqlData ="";
                                                    ?>
                                                  </select>
                                            </div>
                                        <button type="submit" class='btn btn-danger btn-sm'><i class="fa fa-search"></i> Tampilkan</button>
                                        </div>
                                    </div>                                        
                                </form>
                                  <?php
                                    $a = mysqli_query($koneksi,
                                    " SELECT a.kd_brg, a.ur_sskel, a.satuan
                                      FROM   b_nmbmn a
                                      WHERE  a.kd_brg='$_POST[kd_brg]'");
                                    $r = mysqli_fetch_array($a);
                                    $cekdata = mysqli_num_rows($a);
                                    if(isset($_POST['kd_brg']) && $cekdata==0 ){
                                      echo "
                                      <h4>Ulang Lagi</h4>";
                                    }else{
                                  ?>
                                <form method='post' class='form-horizontal' action='<?php echo "$aksi?module=bmnTambah&act=updateHarga"; ?>' enctype='multipart/form-data'>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"></label>
                                        <div class="col-sm-2">
                                        <input type="text" class="form-control" name='kd_brg' id="kd_brg" value='<?php echo "$r[kd_brg]"; ?>' readonly>
                                        </div>

                                        <div class="col-sm-5">
                                        <input type="text" class="form-control" name='nm_brg' id="nm_brg" value='<?php echo "$r[ur_sskel]"; ?>' readonly>
                                        </div>

                                        <div class="col-sm-2">
                                        <input type="text" class="form-control" name='satuan' id="satuan" value='<?php echo "$r[satuan]"; ?>' readonly>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Jumlah BMN</label>
                                        <div class="col-sm-1">
                                        <input type="text" maxlength="3" class="form-control" name='qty' id="qty" value='<?php echo "$_POST[qty]"; ?>' onkeyup=sum2();>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">No Aset</label>
                                        <div class="col-sm-1">
                                        <input type="text" class="form-control" maxlength="3" name='nupAW' id="nupAW" value='<?php echo "$_POST[nupAW]"; ?>' onkeyup=sum2();>
                                        <small>Awal</small>
                                        </div>

                                        <div class="col-sm-1">
                                        <input type="text" class="form-control" maxlength="3" name='nupAK' id="nupAK" value='<?php echo "$_POST[nupAK]"; ?>' readonly>
                                        <small>Akhir</small>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Rupiah Aset</label>
                                        <div class="col-sm-2">
                                        <input type="text" class="form-control" name='b_rphaset' id="b_rphaset" value='<?php echo "$_POST[b_rphaset]"; ?>'>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Rupiah Satuan</label>
                                        <div class="col-sm-2">
                                        <input type="text" class="form-control" name='b_rphsat' id="b_rphsat" value='<?php echo "$_POST[b_rphsat]"; ?>'>
                                        </div>
                                    </div>

                                    <fieldset>
                                    <label for='Kode' class='col-sm-2 control-label'></label>
                                    <button type=submit Data class='btn btn-primary btn-md'>
                                    <i class='fa fa-check'></i>&nbsp;&nbsp;&nbsp;Simpan </button>

                                    <button type=reset class='btn btn-dark btn-md'>
                                    <i class='fa fa-times'></i>&nbsp;&nbsp;&nbsp; Clear </button>

                                    <a class='btn btn-danger btn-md' href=<?php echo "?module=bmnTambah"; ?>>
                                    <i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Kembali </a>
                                    </fieldset>

                                </form>
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

case "upBAST":
if ($_SESSION['LEVEL']=='admin' or $_SESSION['LEVEL'] == 'user'){
?>
<!-- Page Content -->
                <section class="page-heading fade-in-up">
                    <h4 class="page-title">
                        Transaksi Aset / Barang Milik Negara<br>
                        <span class="badge badge-info badge-pill m-r-5 m-b-5">Update Berita Acara Serah Terima</span>
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
                                <form method="POST" action="">
                                   <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Pencarian Kodefikasi</label>
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <select class="form-control s2" name='kd_brg'>
                                                  <option value='BLANK'>PILIH</option>
                                                  <?php
                                                    $dataSql = "SELECT a.kd_brg, a.ur_sskel, a.satuan
                                                                FROM  b_nmbmn a 
                                                                ORDER BY kd_brg ASC";
                                                    $dataQry = mysqli_query($koneksi, $dataSql) or die ("Gagal Query".mysql_error());
                                                    while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                    if ($dataRow['kd_brg']==$_POST['kd_brg']) {
                                                      $cek = " selected";
                                                    } else { $cek=""; }
                                                    echo "
                                                  <option value='$dataRow[kd_brg]' $cek>$dataRow[kd_brg]  -  $dataRow[ur_sskel]</option>";
                                                    }
                                                    $sqlData ="";
                                                    ?>
                                                  </select>
                                            </div>
                                        <button type="submit" class='btn btn-danger btn-sm'><i class="fa fa-search"></i> Tampilkan</button>
                                        </div>
                                    </div>                                        
                                </form>
                                  <?php
                                    $a = mysqli_query($koneksi,
                                    " SELECT a.kd_brg, a.ur_sskel, a.satuan
                                      FROM   b_nmbmn a
                                      WHERE  a.kd_brg='$_POST[kd_brg]'");
                                    $r = mysqli_fetch_array($a);
                                    $cekdata = mysqli_num_rows($a);
                                    if(isset($_POST['kd_brg']) && $cekdata==0 ){
                                      echo "
                                      <h4>Ulang Lagi</h4>";
                                    }else{
                                  ?>
                                <form method='post' class='form-horizontal' action='<?php echo "$aksi?module=bmnTambah&act=updateBAST"; ?>' enctype='multipart/form-data'>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"></label>
                                        <div class="col-sm-2">
                                        <input type="text" class="form-control" name='kd_brg' id="kd_brg" value='<?php echo "$r[kd_brg]"; ?>' readonly>
                                        </div>

                                        <div class="col-sm-5">
                                        <input type="text" class="form-control" name='nm_brg' id="nm_brg" value='<?php echo "$r[ur_sskel]"; ?>' readonly>
                                        </div>

                                        <div class="col-sm-2">
                                        <input type="text" class="form-control" name='satuan' id="satuan" value='<?php echo "$r[satuan]"; ?>' readonly>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Jumlah BMN</label>
                                        <div class="col-sm-1">
                                        <input type="text" maxlength="3" class="form-control" name='qty' id="qty" value='<?php echo "$_POST[qty]"; ?>' onkeyup=sum2();>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">No Aset</label>
                                        <div class="col-sm-1">
                                        <input type="text" class="form-control" maxlength="3" name='nupAW' id="nupAW" value='<?php echo "$_POST[nupAW]"; ?>' onkeyup=sum2();>
                                        <small>Awal</small>
                                        </div>

                                        <div class="col-sm-1">
                                        <input type="text" class="form-control" maxlength="3" name='nupAK' id="nupAK" value='<?php echo "$_POST[nupAK]"; ?>' readonly>
                                        <small>Akhir</small>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">No BAST</label>
                                        <div class="col-sm-10">
                                        <input type="text" class="form-control" name='b_bast' id="b_bast" value='<?php echo "$_POST[b_bast]"; ?>'>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Tanggal BAST</label>
                                        <div class="col-sm-2">
                                        <input type="text" maxlength="12" class="form-control datepicker" name='b_tglbast' id="b_tglbast" value='<?php echo "$_POST[b_tglbast]"; ?>'>
                                        </div>
                                    </div>

                                    <fieldset>
                                    <label for='Kode' class='col-sm-2 control-label'></label>
                                    <button type=submit Data class='btn btn-primary btn-md'>
                                    <i class='fa fa-check'></i>&nbsp;&nbsp;&nbsp;Simpan </button>

                                    <button type=reset class='btn btn-dark btn-md'>
                                    <i class='fa fa-times'></i>&nbsp;&nbsp;&nbsp; Clear </button>

                                    <a class='btn btn-danger btn-md' href=<?php echo "?module=bmnTambah"; ?>>
                                    <i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Kembali </a>
                                    </fieldset>

                                </form>
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
