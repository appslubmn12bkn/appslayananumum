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
      //  $aksi = "media/AKSI/bmn.php";
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
                                                                FROM b_bmnbaru a
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
                        <span class="badge badge-success badge-pill m-r-5 m-b-5">Tambah BMN Baru</span>
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
                                <form method='post' class='form-horizontal' action='<?php echo "$aksi?module=bmnTambah&act=bmnBaru"; ?>' enctype='multipart/form-data'>
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
                                        <input type="text" maxlength="3" class="form-control" name='b_tgltrn' id="b_tgltrn" value='<?php echo date("Y-m-d"); ?>' readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Tanggal Perolehan</label>
                                        <div class="col-sm-2">
                                        <input type="text" maxlength="3" class="form-control" name='b_tglperlh' id="b_tglperlh" value='<?php echo "$_POST[b_tglperlh]"; ?>'>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Tanggal Pembukuan</label>
                                        <div class="col-sm-2">
                                        <input type="text" maxlength="3" class="form-control" name='b_tglbuku' id="b_tglbuku" value='<?php echo "$_POST[b_tglbuku]"; ?>'>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Kuantitas Trx</label>
                                        <div class="col-sm-1">
                                        <input type="text" maxlength="3" class="form-control" name='b_kuantitas' id="b_kuantitas" value='1' readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Rupiah Aset</label>
                                        <div class="col-sm-2">
                                        <input type="text" class="form-control" name='b_rphaset' id="b_rphaset" value='<?php echo "$_POST[b_rphaset]"; ?>'>
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
                                    <button type=submit value=Simpan Data class='btn btn-primary btn-md'>
                                    <i class='fa fa-check'></i>&nbsp;&nbsp;&nbsp;Simpan </button></a>

                                    <button type=reset value=Simpan Data class='btn btn-danger btn-md'>
                                    <i class='fa fa-times'></i>&nbsp;&nbsp;&nbsp; Clear </button></a>
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
