<?php
session_start();
if (empty($_SESSION['UNAME']) and empty($_SESSION['PASSWORD'])) {
    echo "<link href='bootstrap/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
      			<center>
      			Modul Tidak Bisa Di Akses,
      			Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=index.php><b>LOGIN</b></a></center>";
} else {
    $cek = user_akses($_GET['module'], $_SESSION['NIP']);
    if ($cek == 1 or $_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
        $aksi = "media/AKSI/ekspedisi.php";
        switch ($_GET['act']) {
            default:
                if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
                    $sql = "SELECT * FROM s_settgl ORDER BY idtgl ASC";
                    $tgl = mysqli_query($koneksi,$sql);
                    $rs = mysqli_fetch_array($tgl);
                    $update = date('Y-m-d');
    ?>

<section class="page-heading fade-in-up">
    <h4 class="page-title">
        Catat Ekspedisi<br>
    <h6>Ekpedisi</h6>
    </h4>
<a class='btn btn-primary btn-md' href=<?php echo"?module=e_catekspedisi&act=catat";?>>
<i class='fa fa-plus'></i> Tambah Surat Ekspedisi (Kirim)</a>
</section>
<section class='content fade-in-up'>
    <div class='row'>
        <div class='col-md-12'>
           <div class='box'>
                <div class='ibox'>
                    <div class='ibox-head'>
                        <div class='ibox-title'>Tambah Data</div>
                    </div>
                    <div class='ibox-body'> 
                        <div class='row'>
                        <table id="table_4" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th bgcolor='#157ac0' class="text-white"> No </th>
                                                    <th bgcolor='#157ac0' class="text-white"> NOMOR SURAT</th>
                                                    <th bgcolor='#157ac0' class="text-white"> UNIT KIRIM</th>
                                                    <th bgcolor='#157ac0' class="text-white"> TUJ. INSTANSI</th>
                                                    <th bgcolor='#157ac0' class="text-white"> TUJ. SATKER</th>
                                                    <th bgcolor='#157ac0' class="text-white"> ALAMAT SURAT</th>
                                                    <th bgcolor='#157ac0' class="text-white"> TANGGAL TERIMA</th>
                                                    <th bgcolor='#157ac0' class="text-white"> </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = " SELECT a.e_tglterima, a.e_unitkirim, 
                                                                a.idekspedisi, a.e_instansi,
                                                                a.e_nosurat, a.e_alamat, 
                                                                a.e_flag, a.e_satker, 
                                                                b.r_idutama, b.r_ruangutama
                                                         FROM e_tblekspedisi a
                                                         LEFT JOIN r_ruangutama b ON b.r_idutama = a.e_unitkirim
                                                         WHERE a.e_tglterima BETWEEN '$rs[s_tglawal]' AND '$rs[s_tglakhir]' 
                                                         AND a.e_flag = '1'
                                                         ORDER BY idekspedisi ASC";
                                                $ekspedisi = mysqli_query($koneksi,$sql);
                                                $no = 0;
                                                while ($r = mysqli_fetch_array($ekspedisi)) {
                                                    $no++;
                                                ?>
                                                    <tr>
                                                        <td><?php echo "$no"; ?></td>
                                                        <td><?php echo "$r[e_nosurat]"; ?></td>
                                                        <td><?php echo "$r[r_ruangutama]"; ?></td>
                                                        <td><?php echo "$r[e_instansi]"; ?></td>
                                                        <td><?php echo "$r[e_satker]"; ?></td>
                                                        <td><?php echo "$r[e_alamat]"; ?></td>
                                                        <td><?php echo "$r[e_tglterima]"; ?></td>
                                                        <th align="center">
                                                            <a class='btn btn-danger btn-sm flat' href='<?php echo "$aksi?module=ekspedisi&act=hapus&idekspedisi=$r[idekspedisi]" ?>' onClick="return confirm('Anda yakin ingin menghapus ?<?php echo $o['ur_brg']; ?>?');">
                                                                <i class='fa fa-trash'></i></a>
                                                        </th>
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

case "catat":
if ($_SESSION['LEVEL']=='admin'){

?>
<!-- Page Content -->
                <section class="page-heading fade-in-up">
                    <h4 class="page-title">
                        Catat Surat Keluar (Kirim)<br>
                        <h6>Ekspedisi</h6>
                      </h4>
                </section>
                <section class='content fade-in-up'>
                        <div class='row'>
                            <div class='col-md-12'>
                                <div class='box'>
                                    <div class='ibox'>
                                        <div class='ibox-head'>
                                           <div class='ibox-title'>Referensi Tabel Persediaan</div>
                                        </div>
                                        <div class='ibox-body'> 

                                        <form class='form-horizontal' method='POST' action='<?php echo "$aksi?module=e_catekspedisi&act=catatSurat"; ?>' enctype='multipart/form-data'>
                                            <div class="form-group row">
                                                <div class="col-md-2">
                                                    <label>Tanggal Kirim</label>
                                                    <div class="input-group date">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="form-control datepicker" placeholder="yyyy/mm/dd" name="tglTerima" value='<?php echo "$_POST[tglTerima]"; ?>' data-toggle="tooltip" data-placement="top" title="Tanggal Awal" required>
                                                    </div><!-- input-group -->
                                                </div>

                                                <div class="col-sm-5">
                                                    <label>Unit</label>
                                                    <select class="select2 form-control s2" style="width: 100%" name='unut' required>
                                                        <option value='BLANK'>PILIH</option>
                                                        <?php
                                                        $dataSql = "SELECT * FROM r_ruangutama 
                                                                    WHERE (r_idutama IN('2','3','4','5','6'))
                                                                    ORDER BY r_idutama ASC";
                                                        $dataQry = mysqli_query($koneksi, $dataSql) or die("Gagal Query" . mysqli_error($koneksi));
                                                        while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                            if ($dataRow['r_idutama'] == $_POST['unut']) {
                                                                $cek = " selected";
                                                            } else {
                                                                $cek = "";
                                                            }
                                                            echo "
                                                            <option value='$dataRow[r_idutama]' $cek>$dataRow[r_ruangutama]</option>";
                                                        }
                                                        $sqlData = "";
                                                        ?>
                                                    </select>
                                                    <small> Pilih Nama Unit </small>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label>Nomor Surat Keluar </label>
                                                    <input type="text" class="form-control" placeholder="nomor surat keluar" name="noSurat" value='<?php echo "$_POST[noSurat]"; ?>' required>
                                                    <small> Input Nomor Surat </small>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <label>Instansi Tujuan</label>
                                                    <select class="form-control s2" style="width: 100%" name='instansi' required>
                                                        <option value='BLANK'>PILIH</option>
                                                        <?php
                                                        $dataSql = "SELECT  INS_KODINS,INS_NAMINS
                                                                    FROM m_instansi
                                                                    ORDER BY INS_KODINS ASC";
                                                        $dataQry = mysqli_query($koneksi, $dataSql) or die("Gagal Query" . mysqli_error($koneksi));
                                                        while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                            if ($dataRow['INS_KODINS'] == $_POST['instansi']) {
                                                                $cek = " selected";
                                                            } else {
                                                                $cek = "";
                                                            }
                                                            echo "
                                                            <option value='$dataRow[INS_KODINS]' $cek>$dataRow[INS_NAMINS]</option>";
                                                        }
                                                        $sqlData = "";
                                                        ?>
                                                    </select>
                                                    <small> Pilih Nama Instansi </small>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label>Tujuan Satuan Kerja</label>
                                                    <input type="text" class="form-control" placeholder="Nama Satuan Kerja (Instansi)" name="satker" value='<?php echo "$_POST[satker]"; ?>'>
                                                    <small> Input Nama Instansi </small>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label>Alamat Surat Tujuan </label>
                                                    <textarea class="form-control" rows="4" name='tujuanSurat' placeholder="Enter ..."><?php echo "$_POST[tujuanSurat]"; ?></textarea>
                                                    <small> Input Tujuan / Alamat Surat </small>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label>Deskripsikan Isi </label>
                                                    <textarea class="form-control" rows="4" name='deskIsi' placeholder="Enter ..."><?php echo "$_POST[deskIsi]"; ?></textarea>
                                                    <small> Deskripsikan Isi Surat yang akan dikirim </small>
                                                </div>
                                            </div>


                                            <button type='submit' class='btn btn-primary btn-md flat'>
                                                <i class='fa fa-check'></i>&nbsp;&nbsp;&nbsp;SIMPAN</button>
                                        </form>
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