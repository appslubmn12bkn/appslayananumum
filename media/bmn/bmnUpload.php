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
                        DAFTAR BARANG MILIK NEGARA<br>
                        <span class="badge badge-warning badge-pill m-r-5 m-b-5">Upload BAST (Pengadaan / TF)</span>
                      </h4>
                    </section>

                    <section class="content fade-in-up">
                    <a class='btn btn-primary btn-md' href=<?php echo "?module=bmnUpload&act=addBAST"; ?>>
                    <i class="fa fa-plus"></i>&nbsp;&nbsp; Upload Bukti Tanda Terima Pengadaan / Transfer BMN </a>
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
                                                            <th bgcolor='#88c799'> NO </th>
                                                            <th bgcolor='#88c799'> KODE</th>
                                                            <th bgcolor='#88c799'> URAIAN</th>
                                                            <th bgcolor='#88c799'> NO AWAL</th>
                                                            <th bgcolor='#88c799'> NO AKHIR </th>
                                                            <th bgcolor='#88c799'> TGL PEROLEH </th>
                                                            <th bgcolor='#88c799'> QTY </th>
                                                            <th bgcolor='#88c799'> BAST </th>
                                                            <th bgcolor='#88c799'> TGL BAST </th>
                                                            <th bgcolor='#88c799' width='25px'> MEREK_TYPE</th>
                                                            <th bgcolor='#88c799' width='25px'> BUKTI</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $newData = mysqli_query(
                                                            $koneksi,
                                                            " SELECT a.b_kdbrg, a.b_noaset_awal, 
                                                                     a.b_noaset_akhir, a.b_tglbuku, 
                                                                     a.b_tglperlh, a.b_kondisi, 
                                                                     a.b_kuantitas, a.b_merektype, 
                                                                     a.b_bast, a.b_tglbast, a.b_bukti,
                                                                     b.kd_brg, b.ur_sskel, b.satuan
                                                                FROM b_uploadbast a
                                                                LEFT JOIN b_nmbmn b ON b.kd_brg = a.b_kdbrg
                                                                WHERE a.b_tglperlh BETWEEN '$rs[s_tglawal]' 
                                                                AND '$rs[s_tglakhir]'
                                                                ORDER BY a.b_kdbrg ASC");

                                                        $no = 0;
                                                        while ($r = mysqli_fetch_array($newData)) {
                                                            $no++;
                                                        ?>
                                                            <tr>
                                                                <td><?php echo "$no"; ?></td>
                                                                <td><?php echo "$r[b_kdbrg]"; ?></td>
                                                                <td><?php echo "$r[ur_sskel]"; ?></td>
                                                                <td><?php echo "$r[b_noaset_awal]"; ?></td>
                                                                <td><?php echo "$r[b_noaset_akhir]"; ?></td>
                                                                <td><?php echo indotgl($r[b_tglperlh]); ?></td>
                                                                <td><?php echo "$r[b_kuantitas]"; ?></td>
                                                                <td><?php echo "$r[b_bast]"; ?></td>
                                                                <td><?php echo indotgl($r[b_tglbast]); ?></td>
                                                                <td><?php echo "$r[b_merektype]"; ?></td>
                                                                <td>
                                                                <a href='<?php echo"?module=bmnUpload&act=bukti&kd_brg=$r[b_kdbrg]&no_awal=$r[b_noaset_awal]&no_akhir=$r[b_noaset_akhir]";?>'>
                                                                <?php echo "$r[b_bukti]"; ?></a> 
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

case "addBAST":
if ($_SESSION['LEVEL']=='admin' or $_SESSION['LEVEL'] == 'user'){
?>
<!-- Page Content -->
                <section class="page-heading fade-in-up">
                    <h4 class="page-title">
                        Transaksi Aset / Barang Milik Negara<br>
                        <span class="badge badge-success badge-pill m-r-5 m-b-5">Upload BAST</span>
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
                                <form method='post' class='form-horizontal' action='<?php echo "$aksi?module=bmnUpload&act=saveBAST"; ?>' enctype='multipart/form-data'>
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
                                        <label class="col-sm-2 col-form-label">Merek / Type</label>
                                        <div class="col-sm-10">
                                        <input type="text" class="form-control" name='b_merektype' id="b_merektype" value='<?php echo "$_POST[b_merektype]"; ?>'>
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

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Bukti BAST (.Pdf) </label>
                                        <div class="col-sm-5">
                                        <input type="file" class="form-control" name='bukti' id="bukti">
                                        </div>
                                    </div>

                                    <fieldset>
                                    <label for='Kode' class='col-sm-2 control-label'></label>
                                    <button type=submit Data class='btn btn-primary btn-md'>
                                    <i class='fa fa-check'></i>&nbsp;&nbsp;&nbsp;Simpan </button>

                                    <button type=reset class='btn btn-dark btn-md'>
                                    <i class='fa fa-times'></i>&nbsp;&nbsp;&nbsp; Clear </button>

                                    <a class='btn btn-danger btn-md' href=<?php echo "?module=bmnUpload"; ?>>
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

case "bukti":
if ($_SESSION['LEVEL']=='admin' or $_SESSION['LEVEL'] == 'user'){
$qry    = "SELECT b_kdbrg, b_noaset_awal, b_noaset_akhir, b_bukti 
           FROM b_uploadbast 
           WHERE b_kdbrg = '$_GET[kd_brg]' 
           AND b_noaset_awal = '$_GET[no_awal]' 
           AND b_noaset_akhir = '$_GET[no_akhir]'
           ORDER BY b_kdbrg ASC";
$bukti  = mysqli_query($koneksi,$qry);
$rsb    = mysqli_fetch_array($bukti);
?>
<!-- Page Content -->
                <section class="page-heading fade-in-up">
                    <h4 class="page-title">
                        Bukti Pengiriman / BAST<br>
                        <span class="badge badge-dark badge-pill m-r-5 m-b-5">Bukti Pengiriman / BAST Kirim</span>
                      </h4>
                </section>
                <section class='content fade-in-up'>
                  <a href=''>
                  <button type="button" class="btn btn-dark btn-sm">
                    <i class="fa fa-refresh"></i>&nbsp;&nbsp;Muat Ulang
                  </button></a>

                  <a href='<?php echo"?module=bmnUpload";?>'>
                  <button type="button" class="btn btn-danger btn-sm">
                  <i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Kembali 
                  </button>
                  </a>
                        <div class='row'>
                            <div class='col-md-12'>
                                <div class='box'>
                                    <div class='ibox'>
                                        <div class='ibox-head'>
                                            <div class='ibox-title'>TA : <?php echo "$rs[s_thnang]"; ?></div>
                                        </div>
                                        <div class='ibox-body'> 
                                        <embed src="_bast/<?php echo $rsb[b_bukti]; ?>" type='application/pdf' width='100%' height='700px'/></embed>    
             
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
