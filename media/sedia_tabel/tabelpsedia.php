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
                         ORDER BY idtgl ASC");
                    $rs        = mysqli_fetch_array($tgl);
                    $update = date('Y-m-d');

?>

                    <section class="page-heading fade-in-up">
                      <h4 class="page-title">
                        Tabel Jenis Barang Persediaan<br>
                        <h6>Barang Persediaan masuk dan keluar</h6>
                      </h4>
                    </section>
                    <section class="content fade-in-up">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box">
                                        <div class="ibox">
                                            <div class="ibox-head">
                                                <div class="ibox-title">Referensi Tabel Persediaan
                                                </div>
                                            </div>
                                            <div class="ibox-body"> 
                                            <table id="table_4" class="table table-bordered table-striped responsive">
                                            <thead>
                                                <tr>
                                                    <th bgcolor='#88c7f2'> NO </th>
                                                    <th bgcolor='#88c7f2'> KODE BARANG</th>
                                                    <th bgcolor='#88c7f2'> URAIAN BARANG</th>
                                                    <th bgcolor='#88c7f2'> MEREK_TYPE</th>
                                                    <th bgcolor='#88c7f2'> SATUAN</th>
                                                    <th bgcolor='#88c7f2'> IMG</th>
                                                    <th bgcolor='#88c7f2'> DESKRIPSI</th>
                                                    <?php if ($_SESSION[LEVEL]=='admin') {?>
                                                    <th bgcolor='#88c7f2'> UPLOAD</th>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sensus = mysqli_query($koneksi, 
                                                          "SELECT a.kd_brg, a.ur_brg,
                                                                  a.kd_kbrg, a.kd_jbrg, 
                                                                  a.satuan, a.kd_lokasi,
                                                                  b.kd_brg, b.img, b.flag, 
                                                                  b.merek_type, b.created
                                                           FROM c_brgsedia a 
                                                           LEFT JOIN c_imgbrgsedia b ON b.kd_brg=a.kd_brg
                                                           ORDER BY a.kd_brg ASC");
                                                $no = 0;
                                                while ($r = mysqli_fetch_array($sensus)) {
                                                    $no++;
                                                ?>
                                                    <tr>
                                                        <td><?php echo "$no"; ?></td>
                                                        <td><?php echo "$r[kd_kbrg]"; ?> 
                                                        <?php echo "$r[kd_jbrg]"; ?></td>
                                                        <td><?php echo "$r[ur_brg]"; ?></td>
                                                        <td><?php echo "$r[merek_type]"; ?></td>
                                                        <td><?php echo "$r[satuan]"; ?></td>
                                                        <?php if ($r['flag'] == '1') { ?>
                                                        <td align="center"><i class="fa fa-close"></i></td>
                                                        <td>img belum diupload : <?php echo $update; ?></td>
                                                        <?php } else { ?>
                                                        <td align="center">
                                                        <a href="#" type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#view<?php echo "$r[kd_brg]"; ?>"><i class='fa fa-search'></i></a>
                                                        </td>
                                                        <td>terupload : <?php echo indotgl($r[created]); ?></td>
                                                        <div class="modal fade" id="view<?php echo "$r[kd_brg]"; ?>" role="dialog">
                                                                <div class="modal-dialog">
                                                                    <!-- Modal content-->
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="btn btn-default pull-right btn-sm" data-dismiss="modal"><i class="fa fa-close"></i></i> </button>

                                                                            <h4 class="modal-title"><?php echo "$r[kd_brg]"; ?><br>
                                                                                <?php echo "$r[ur_brg]"; ?></h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <?php

                                                                            $img = mysqli_query(
                                                                                $koneksi,
                                                                                "SELECT a.kd_brg, a.img, a.flag, a.created,
                                                                                        b.kd_brg, b.ur_brg
                                                                                FROM c_imgbrgsedia a
                                                                                LEFT JOIN c_brgsedia b ON b.kd_brg = a.kd_brg
                                                                                WHERE a.kd_brg = '$r[kd_brg]'
                                                                                ORDER BY a.kd_brg ASC"
                                                                            );
                                                                            $view = mysqli_fetch_array($img);
                                                                            ?>
                                                                            <img src='<?php echo "_imgsedia/" . $view['img'] . ""; ?>' class="rounded" width='100%' height='100%' />
                                                                        <?php } ?>
                                                                        </div>
                                                        <?php if ($_SESSION[LEVEL]=='admin') {?>
                                                        <td align="center">
                                                        <a class='btn btn-primary btn-xs' href=<?php echo "?module=tbl_brg&act=uploadImg&kd_brg=$r[kd_brg]"; ?>>
                                                        <i class='fa fa-upload'></i></a>   
                                                        </td>
                                                        <?php } ?>
                                                    </tr>
                                                <?php } ?>
                                                <tfoot>
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

                case "uploadImg":
                    if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
                        $tampil = mysqli_query(
                            $koneksi,
                            "SELECT a.kd_brg, a.ur_brg,
                                    a.kd_kbrg, a.kd_jbrg, 
                                    a.satuan, a.kd_lokasi,
                                    b.kd_brg, b.img, b.flag
                            FROM c_brgsedia a 
                            LEFT JOIN c_imgbrgsedia b ON b.kd_brg=a.kd_brg
                            WHERE a.kd_brg = '$_GET[kd_brg]'
                            ORDER BY a.kd_brg ASC");
                        $r  = mysqli_fetch_array($tampil);
                    ?>

                    <section class="page-heading fade-in-up">
                      <h4 class="page-title">
                        Update Tabel Jenis Barang Persediaan<br>
                        <h6>Barang Persediaan masuk dan keluar</h6>
                      </h4>
                    </section>
                    <section class="content fade-in-up">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box">
                                    <div class="ibox">
                                        <div class="ibox-head">
                                            <div class="ibox-title">Upload Referensi
                                            </div>
                                        </div>
                                        <div class="ibox-body">
                                        <div class="row">
                                        <div class="col-md-6">
                                            <form method='post' class='form-horizontal' action='<?php echo "$aksi?module=tbl_brg&act=uploadImage"; ?>' enctype='multipart/form-data'>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label class="control-label">KELOMPOK BARANG</label>
                                                        <input type="text" class="form-control" name='kd_kbrg' value='<?php echo "$r[kd_kbrg]"; ?>' readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label class="control-label">JENIS BARANG</label>
                                                        <input type="text" class="form-control" name='kd_jbrg' value='<?php echo "$r[kd_jbrg]"; ?>' readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label class="control-label">KODE BARANG</label>
                                                        <input type="text" class="form-control" name='kd_brg' value='<?php echo "$r[kd_brg]"; ?>' readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label class="control-label">URAIAN BARANG</label>
                                                        <input type="text" class="form-control" name='ur_brg' value='<?php echo "$r[ur_brg]"; ?>' readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label class="control-label">MEREK_TYPE BARANG</label>
                                                        <input type="text" class="form-control" name='merek_type' value='<?php echo "$_POST[merek_type]"; ?>'>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                            <h4>UPLOAD IMAGE</h4>
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <input type="file" name='img' class="form-control-file" id="uploadImage" onchange="PreviewImage();">
                                                            <small> Upload Image max : 1 Mb </small>
                                                        </div>
                                                    </div>
        
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label>Preview Image</label><br>
                                                            <img id="uploadPreview" style="width: 350px; height: 350px;" />
                                                        </div>
                                                    </div>
                                                 
                                            
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <button name="upload" type="submit" class="btn btn-primary btn-sm"><i class="fa fa-upload"></i>&nbsp;&nbsp;&nbsp; UPLOAD GAMBAR</button>
                                                </div>
                                            </div>
                                        </form>



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

<script type="text/javascript">
    function PreviewImage() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);
        oFReader.onload = function(oFREvent) {
            document.getElementById("uploadPreview").src = oFREvent.target.result;
        };
    };
</script>

                    <section class="content fade-in-up">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box">
                                    <div class="ibox">
                                        <div class="ibox-head">
                                           <div class="ibox-title">Referensi Tabel Persediaan</div>
                                        </div>
                                        <div class="ibox-body"> 


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>