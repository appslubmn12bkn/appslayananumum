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
        $aksi = "media/aksi/ekspedisi.php";
        switch ($_GET['act']) {
            default:
                if ($_SESSION['LEVEL'] == 'admin') {
                    $sql = "SELECT * FROM s_settgl ORDER BY idtgl ASC";
                    $tgl = mysqli_query($koneksi,$sql);
                    $rs = mysqli_fetch_array($tgl);
                    $update = date('Y-m-d');

?>
                <section class="page-heading fade-in-up">
                    <h4 class="page-title">
                        Cetak Pengambilan Ekspedisi<br>
                        <h6>Ekspedisi</h6>
                    </h4>
                </section>
                <section class='content fade-in-up'>
                    <div class='row'>
                        <div class='col-md-12'>
                            <div class='box'>
                                <div class='ibox'>
                                    <div class='ibox-head'>
                                        <div class='ibox-title'>Cetak Tanda Terima</div>
                                    </div>
                                    <div class='ibox-body'> 

                                    <form class='form-horizontal' method='POST' action='' enctype='multipart/form-data'>
                                            <div class="form-group row">
                                                <div class="col-md-2">
                                                    <div class="input-group date">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="form-control datepicker" placeholder="yyyy/mm/dd" name="tglawal" value='<?php echo "$_POST[tglTerima]"; ?>' data-toggle="tooltip" data-placement="top" title="Tanggal Awal">
                                                    </div><!-- input-group -->
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="input-group date">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="form-control datepicker" placeholder="yyyy/mm/dd" name="tglakhir" value='<?php echo "$_POST[tglTerima]"; ?>' data-toggle="tooltip" data-placement="top" title="Tanggal Awal">
                                                    </div><!-- input-group -->
                                                </div>
                                            <button type='submit' name='preview' class='btn btn-primary btn-md'>
                                            <i class='fa fa-search'></i>&nbsp;&nbsp;&nbsp;TAMPILKAN</button>
                                            </div>
                                        </form>
                                        <br>
                                        <?php
                                        if (isset($_POST['preview'])) {
                                            $tglawal = $_POST['tglawal'];
                                            $tglakhir = $_POST['tglakhir'];
                                            if (empty($tglawal) AND empty($tglakhir)) {
                                                echo "<script language='javascript'>alert('Masih ada yang kosong');
                                                window.location = 'appsmedia.php?module=ct_ekpedisi'</script>";
                                            } else {
                                        ?>
                                            <div class="form-group row">
                                                <table id="table_4" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th bgcolor='#88c7f2'> No </th>
                                                            <th bgcolor='#88c7f2'> NOMOR SURAT</th>
                                                            <th bgcolor='#88c7f2'> UNIT KIRIM</th>
                                                            <th bgcolor='#88c7f2'> TUJ. INSTANSI</th>
                                                            <th bgcolor='#88c7f2'> TUJ. SATKER</th>
                                                            <th bgcolor='#88c7f2'> ALAMAT SURAT</th>
                                                            <th bgcolor='#88c7f2'> TANGGAL TERIMA</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $sql = "SELECT  a.e_tglterima, a.e_unitkirim, 
                                                                        a.idekspedisi, a.e_instansi,
                                                                        a.e_nosurat, a.e_alamat, 
                                                                        a.e_flag, a.e_satker, 
                                                                        b.r_idutama, b.r_ruangutama
                                                                FROM e_tblekspedisi a
                                                                LEFT JOIN r_ruangutama b ON b.r_idutama = a.e_unitkirim
                                                                WHERE a.e_tglterima BETWEEN '$tglawal' AND '$tglakhir'
                                                                AND a.e_tglterima BETWEEN '$rs[s_tglawal]' AND '$rs[s_tglakhir]' 
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
                                                            </tr>
                                                            </tfoot>
                                                        <?php } ?>
                                                </table>
                                                </div>
                                                <form method=POST action='<?php echo "media/ekspedisi/cetakEkpedisikl.php?tglawal=$tglawal&tglakhir=$tglakhir"; ?>' 
                                                    target='_blank'>
                                                    <button type=submit class='btn btn-danger btn-sm flat'>
                                                    <i class='fa fa-print'></i> &nbsp;&nbsp;Cetak Tanda Terima</button>
                                                </form>
                                        <?php }
                                        } ?>

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