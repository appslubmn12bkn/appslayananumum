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
                                                <table id="table_5" class="table table-bordered table-striped responsive">
                                                    <thead>
                                                        <tr>
                                                            <th bgcolor='#88c7f2'> NO </th>
                                                            <th bgcolor='#88c7f2'> KODEFIKASI</th>
                                                            <th bgcolor='#88c7f2'> URAIAN</th>
                                                            <th bgcolor='#88c7f2'> NUP</th>
                                                            <th bgcolor='#88c7f2'> PEROLEHAN</th>
                                                            <th bgcolor='#88c7f2'> MEREK_TYPE</th>
                                                            <th bgcolor='#88c7f2'> STATUS</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                        $qry  = "SELECT a.kd_brg, a.no_aset, a.tgl_perlh,
                                                                        a.merk_type, a.status_label,
                                                                        b.kd_brg, b.ur_sskel, b.satuan,
                                                                        c.b_kdbrg, c.b_noaset, c.b_merektype,
                                                                        d.status_label, d.uraian_status
                                                                  FROM b_bmnsatker a
                                                                  LEFT JOIN b_nmbmn b ON b.kd_brg = a.kd_brg
                                                                  LEFT JOIN b_bmnbaru c ON c.b_kdbrg = a.kd_brg AND c.b_noaset=a.no_aset 
                                                                  LEFT JOIN s_statuslbl d ON d.status_label=a.status_label
                                                                  WHERE (a.status_label IN ('1'))
                                                                  ORDER BY a.kd_brg AND a.no_aset ASC";
                                                        $lbl    = mysqli_query($koneksi,$qry);
                                                        $no = 0;
                                                        while ($r= mysqli_fetch_array($lbl)) {
                                                            $no++;
                                                        ?>
                                                            <tr>
                                                                <td><?php echo "$no"; ?></td>
                                                                <td><?php echo "$r[b_kdbrg]"; ?></td>
                                                                <td><?php echo "$r[ur_sskel]"; ?></td>
                                                                <td><?php echo "$r[b_noaset]"; ?></td>
                                                                <td><?php echo indotgl($r[tgl_perlh]); ?></td>
                                                                <td><?php echo "$r[b_merektype]"; ?></td>
                                                                <?php if($r['status_label']=='1') {?>
                                                                <td>
                                                                <div class="badge badge-success badge-pill" align='center'>
                                                                <strong><?php echo "$r[uraian_status]"; ?></strong> 
                                                                </div>
                                                                </td>
                                                                <?php }else{?>
                                                                <td>
                                                                <div class="badge badge-info badge-pill" align='center'>
                                                                <strong><?php echo "$r[uraian_status]"; ?></strong> 
                                                                </div>
                                                                </td>
                                                                <?php }?>
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
                        Label Registrasi Barang Milik Negara<br>
                        <span class="badge badge-danger badge-pill m-r-5 m-b-5">Label Registrasi</span>
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

                                    <div class="form-group">
                                    <label class="col-sm-2 col-form-label"></label>
                                    <button type="submit" class='btn btn-danger btn-sm'>
                                    <i class="fa fa-search"></i> Tampilkan</button>
                                    </div>
                                </form>

                                <?php
                                        $a = mysqli_query(
                                            $koneksi,
                                            "   SELECT  a.b_kdbrg, a.b_noaset, 
                                                        b.kd_brg, b.no_aset, b.status_label,
                                                        c.kd_brg, c.ur_sskel
                                                FROM   b_bmnbaru a
                                                LEFT JOIN b_bmnsatker b ON b.kd_brg = a.b_kdbrg AND b.no_aset = a.b_noaset
                                                INNER JOIN b_nmbmn c ON c.kd_brg = a.b_kdbrg
                                                WHERE  a.b_kdbrg ='$_POST[kd_brg]'
                                                AND a.b_noaset BETWEEN '$_POST[nupAW]' AND '$_POST[nupAK]'
                                                ORDER BY a.b_kdbrg AND a.b_noaset ASC"
                                        );
                                        $data = mysqli_fetch_array($a);
                                        $cekdata = mysqli_num_rows($a);
                                        if (isset($_POST['kd_brg']) and isset($_POST['nupAW']) and isset($_POST['nupAK']) && $cekdata == 0) {
                                            echo "
                                            <h4><font color='red'>Pemberitahuan!</font></h4>
                                            Data Tidak Ditemukan, Cek BMN!";
                                        } else {
                                        ?>
                                        <table id='simpletable' class='table table-bordered table-striped'>
                                                <thead>
                                                    <tr>
                                                        <th bgcolor='#0b3f5f' style='width: 7px'>
                                                            <font color='#fff'>#</font>
                                                        </th>
                                                        <th bgcolor='#0b3f5f'>
                                                            <font color='#fff'>KODE</font>
                                                        </th>
                                                        <th bgcolor='#0b3f5f'>
                                                            <font color='#fff'>URAIAN</font>
                                                        </th>
                                                        <th bgcolor='#0b3f5f'>
                                                            <font color='#fff'>NO ASET</font>
                                                        </th>
                                                        <th bgcolor='#0b3f5f'>
                                                            <font color='#fff'>MEREK</font>
                                                        </th>
                                                        <th bgcolor='#0b3f5f'>
                                                            <font color='#fff'>TRN</font>
                                                        </th>
                                                        <th bgcolor='#0b3f5f'>
                                                            <font color='#fff'>LOKASI</font>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $cek = mysqli_query(
                                                        $koneksi,
                                                        "SELECT a.b_kdbrg, a.b_noaset, 
                                                                c.kd_brg, c.ur_sskel,
                                                                d.merk_type, d.kondisi, 
                                                                d.status_label, d.kd_lokasi,
                                                                d.kd_brg, d.no_aset, d.jns_trn
                                                        FROM b_bmnbaru a
                                                        LEFT JOIN b_nmbmn c ON c.kd_brg=a.b_kdbrg
                                                        LEFT JOIN b_bmnsatker d ON d.kd_brg=a.b_kdbrg AND d.no_aset=a.b_noaset
                                                        WHERE a.b_kdbrg ='$_POST[kd_brg]'
                                                        AND d.status_label = '1'
                                                        AND  a.b_noaset BETWEEN '$_POST[nupAW]' AND '$_POST[nupAK]'
                                                        AND (d.jns_trn IN (100, 101, 102, 103, 105, 113, 107, 112))
                                                        ORDER BY a.b_noaset ASC"
                                                    );

                                                    $numRows = mysqli_num_rows($cek);
                                                    $no = 0;
                                                    while ($r = mysqli_fetch_array($cek)) {
                                                        $no++;
                                                    ?>
                                                        <tr>
                                                            <td><?php echo "$no"; ?></td>
                                                            <td><?php echo "$r[kd_brg]"; ?></td>
                                                            <td><?php echo "$r[ur_sskel]"; ?></b></td>
                                                            <td><?php echo "$r[b_noaset]"; ?></td>
                                                            <td><?php echo "$r[merk_type]"; ?></td>
                                                            <td><?php echo "$r[jns_trn]"; ?></td>
                                                            <td><?php echo "$r[kd_lokasi]"; ?></td>
                                                        </tr>
                                                        </tfoot>
                                                    <?php }
                                                    if ($cekdata == 0) {
                                                    ?>

                                                    <?php } else { ?>
                                                        <form method=POST action='<?php echo "media/bmn/cetaklabel.php?kd_brg=$_POST[kd_brg]&nupAW=$_POST[nupAW]&nupAK=$_POST[nupAK]"; ?>' target='_blank'>
                                                            <p><button type=submit class='btn btn-dark btn-md'><i class='fa fa-print'></i>
                                                                    &nbsp;&nbsp;&nbsp;Tampilkan Label Barcode</button></a></p>
                                                        </form>
                                                    <?php } ?>
                                            </table>
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
