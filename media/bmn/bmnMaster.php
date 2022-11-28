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
                                        <table id="table_3" class="table table-bordered table-striped responsive">
                                            <thead>
                                                <tr>
                                                    <th bgcolor='#88c7f2'> TA </th>
                                                    <th bgcolor='#88c7f2'> KODE</th>
                                                    <th bgcolor='#88c7f2'> UARIAN BMN</th>
                                                    <th bgcolor='#88c7f2'> NUP</th>
                                                    <th bgcolor='#88c7f2'> PEROLEH</th>
                                                    <th bgcolor='#88c7f2'> TRX</th>
                                                    <th bgcolor='#88c7f2'> KONDISI</th>
                                                    <th bgcolor='#88c7f2'> RPH</th>
                                                    <th bgcolor='#88c7f2'> MEREK TYPE</th>
                                                    <th bgcolor='#88c7f2'> KETERANGAN</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $newData = mysqli_query($koneksi,
                                                    " SELECT a.thn_ang,a.periode,a.kd_brg,
                                                             a.no_aset,a.tgl_perlh,a.tercatat,            
                                                             a.kondisi,a.jns_trn,
                                                             a.rph_aset,a.merk_type,
                                                             a.asal_perlh, a.keterangan,
                                                             b.kd_brg, b.ur_sskel, b.satuan
                                                        FROM b_bmnsatker a
                                                        LEFT JOIN b_nmbmn b ON b.kd_brg = a.kd_brg
                                                        ORDER BY a.no_aset ASC");

                                                $no = 0;
                                                while ($r = mysqli_fetch_array($newData)) {
                                                    $no++;
                                                ?>
                                                    <tr>
                                                        <td><?php echo "$r[thn_ang]"; ?></td>
                                                        <td><?php echo "$r[kd_brg]"; ?></td>
                                                        <td><?php echo "$r[ur_sskel]"; ?></td>
                                                        <td><?php echo "$r[no_aset]"; ?></td>
                                                        <td><?php echo indotgl($r[tgl_perlh]); ?></td>
                                                        <td><?php echo "$r[jns_trn]"; ?></td>
                                                        <td><?php echo "$r[kondisi]"; ?></td>
                                                        <td><?php echo "$r[rph_aset]"; ?></td>
                                                        <td><?php echo "$r[merk_type]"; ?></td>
                                                        <td><?php echo "$r[asal_perlh]"; ?>, <?php echo "$r[keterangan]"; ?>
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
                    </section>


               <?php
                } else {
                    echo "Anda tidak berhak mengakses halaman ini.";
                }
                break;

                case "upload":
                if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
                    $tampil = mysqli_query($koneksi,"   SELECT  a.registrasi, a.unit, a.unut,
                                                            a.pemohon, a.tglmohon, a.prosedur,
                                                            a.tglkirimunit, a.user, a.idminta,
                                                            b.r_idutama, b.r_ruangutama, 
                                                            b.r_namaruang, c.pns_nip, c.pns_nama,
                                                            d.flag, d.ur_flag
                                                    FROM c_unitsediaminta a
                                                    LEFT JOIN r_ruangutama b ON b.r_idutama = a.unut
                                                    LEFT JOIN m_pegawai c ON c.pns_nip = a.pemohon
                                                    LEFT JOIN c_prosedia d ON d.flag = a.prosedur
                                                    WHERE a.registrasi = '$_GET[registrasi]'
                                                    ORDER BY a.idminta AND a.tglmohon ASC");
                    $rs = mysqli_fetch_array($tampil);
                ?>

        <section class="page-heading fade-in-up">
            <h4 class="page-title">
            Transaksi Persediaan (Unit)<br>
            <h6>Barang Persediaan masuk dan keluar</h6>
            </h4>
        </section>

        <section class='content fade-in-up'>
            <div class='row'>

                <div class='col-md-7'>
                    <div class='box'>
                        <div class='ibox'>
                            <div class='ibox-head'>
                                <div class='ibox-title'>Upload</div>
                                <span class='badge badge-primary m-r-5 m-b-5'><?php echo "$rs[registrasi]"; ?> - [<?php echo "$rs[r_idutama]"; ?>] <?php echo "$rs[r_ruangutama]"; ?>
                                </span>
                                
                            </div>
                            <div class='ibox-body'> 
                            <table id="table_2" class="table table-bordered table-striped responsive">
                                            <thead>
                                                <tr>
                                                    <th bgcolor='#88c7f2'> IMG </th>
                                                    <th bgcolor='#88c7f2'> KODE BARANG</th>
                                                    <th bgcolor='#88c7f2'> URAIAN BARANG</th>
                                                    <th bgcolor='#88c7f2'> DETAIL</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sensus = mysqli_query($koneksi, 
                                                          "SELECT a.kd_brg, a.ur_brg,
                                                                  a.kd_kbrg, a.kd_jbrg, 
                                                                  a.satuan, a.kd_lokasi,
                                                                  b.kd_brg, b.img, b.flag
                                                           FROM c_brgsedia a 
                                                           LEFT JOIN c_imgbrgsedia b ON b.kd_brg=a.kd_brg
                                                           WHERE b.flag = '2'
                                                           ORDER BY a.kd_brg ASC");
                                                $no = 0;
                                                while ($r = mysqli_fetch_array($sensus)) {
                                                $no++;
                                                ?>
                                                    <tr>
                                                        <td align='center' width='150px' height="90px">
                                                        <img src='<?php echo"_imgsedia/$r[img]";?>' 
                                                        width= "110px" height="100px" />
                                                        </td>
                                                        <td><?php echo "$r[kd_kbrg]"; ?> 
                                                        <?php echo "$r[kd_jbrg]"; ?></td>
                                                        <td><?php echo "$r[ur_brg]"; ?></td>
                                                        <td align="center">
                                                        <form class='form-horizontal' method='post' action='' enctype='multipart/form-data'>
                                                        <input type='hidden' value='<?php echo"$r[kd_brg]";?>' name='kd_brg'>
                                                        <button type='submit' class='btn btn-primary btn-md'>
                                                        <i class="fa fa-search"></i> </button></td>
                                                        </form>
                                                        </td>
                                                        
                                                    </tr>
                                                <?php } ?>
                                                <tfoot>
                                            </table> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class='col-md-5'>
                                            <div class='box'>
                                                <div class='ibox'>
                                                    <div class='ibox-head'>
                                                       <div class='ibox-title'>Detail</div>
                                                    </div>
                                                    <div class='ibox-body'> 

                                            <!-- QUERY CARI KODE DAN STOK -->
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

                                                $a = mysqli_query($koneksi,
                                                            " SELECT a.kd_brg, a.ur_brg, a.satuan, 
                                                                     a.kd_kbrg, a.kd_jbrg,
                                                                     b.kd_brg, b.img, b.merek_type
                                                              FROM   c_brgsedia a
                                                              LEFT JOIN c_imgbrgsedia b ON b.kd_brg = a.kd_brg
                                                              WHERE  a.kd_brg='$_POST[kd_brg]'");
                                                $data = mysqli_fetch_array($a);
                                                $dm = mysqli_fetch_array($querymasuk);
                                                $dk = mysqli_fetch_array($querykeluar);
                                                $masuk=$dm['masuk'];
                                                $keluar=$dk['keluar'];
                                                $stokAkhir=$masuk-$keluar  ;
                                                $cekdata = mysqli_num_rows($a);
                                                if(isset($_POST['kd_brg']) && $cekdata==0 ){
                                                echo "<h4><font color='red'>Data Tidak Ditemukan!</font></h4>";
                                                }else{
                                                  ?>
                                                <!-- END -->
                                                <form class='form-horizontal' method='post' action='<?php echo"$aksi?module=sedia_pengajuan&act=upload&registrasi=$_GET[registrasi]";?>' enctype='multipart/form-data'>
                                                <input type="hidden" name='noreg' value='<?php echo "$rs[registrasi]"; ?>' readonly>
                                                <input type="hidden" name='unut' value='<?php echo "$rs[r_idutama]"; ?>'readonly>
                                                <input type="hidden" name='pic' value='<?php echo "$rs[pemohon]"; ?>' readonly>
                                                <!-- UPLOAD -->

                                                <div class="form-group row">
                                                    <div class="col-sm-5">
                                                    <small><strong>KODE BARANG</strong> </small>
                                                    <input type='text' class='form-control' name='kd_brg' value='<?php echo"$data[kd_brg]";?>' readonly>  
                                                    </div>

                                                    <div class="col-sm-7">
                                                    <small><strong>URAIAN BARANG</strong> </small>
                                                    <input type='text' class='form-control' name='ur_brg' value='<?php echo"$data[ur_brg]";?>' readonly>  
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-sm-6">
                                                    <small><strong>MEREK / TYPE</strong> </small>
                                                    <input type='text' class='form-control' name='merek_type' value='<?php echo"$data[merek_type]";?>' readonly>  
                                                    </div>

                                                    <div class="col-sm-3">
                                                    <small><strong>SATUAN</strong> </small>
                                                    <input type='text' class='form-control' name='satuan' value='<?php echo"$data[satuan]";?>' readonly>  
                                                    </div>
                                                    <div class="col-sm-3">
                                                    <small><strong>STOK</strong> </small>
                                                    <input type='text' class='form-control' name='stok' value='<?php echo"$stokAkhir";?>' readonly>  
                                                    </div>
                                                </div>
                                                <?php if($stokAkhir=='0'){?>

                                                <h4><font color="red">&nbsp;&nbsp;&nbsp;Maaf Barang sedang Kosong</font></h4>

                                                <?php } else { ?>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                    <small><strong>KEBUTUHAN UNIT (QTY)</strong> </small>
                                                    <input type='text' class='form-control' maxlength="4" name='qtyButuh' value='<?php echo"$_POST[qtyButuh]";?>'> 
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                    <small><strong>CATATAN (UNIT) SPESIFIK BARANG</strong></small>
                                                    <textarea type='text' rows="5" class='form-control' name='catatan'>
                                                    <?php echo"$_POST[catatan]";?></textarea>
                                                    </div>
                                                </div>
                                                &nbsp;&nbsp;&nbsp;
                                                <button type='submit' id='btnInsert' class='btn btn-sm btn-danger'>
                                                <i class='fa fa-shopping-basket'></i> &nbsp;&nbsp; MASUK KERANJANG</button>
                                                <?php } ?>                                          
                                                <!-- END -->
                                                </form>
                                                <?php } ?>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>

                </div>
               <section class='content fade-in-up'>
                        <div class='row'>
                            <div class='col-md-12'>
                                <div class='box'>
                                    <div class='ibox'>
                                        <div class='ibox-head'>
                                           <div class='ibox-title'>Keranjang Pesanan (Unit)</div>
                                        </div>
                                        <div class='ibox-body'> 

                                                <div class="col-sm-12">
                                                  <?php
                                                  $qry = mysqli_query($koneksi,
                                                  " SELECT  a.registrasi, a.kd_brg, a.qtyMohon, 
                                                            a.catatan, a.qtyACC, 
                                                            a.merek_type, a.flag_kirim,
                                                            b.registrasi, b.unit, b.unut, 
                                                            b.pemohon, b.idminta,
                                                            b.tglmohon, b.qtypesanan, b.prosedur,
                                                            c.kd_brg, c.ur_brg, c.satuan
                                                    FROM c_sediakeluarunit a
                                                    LEFT JOIN c_unitsediaminta b ON b.registrasi = a.registrasi
                                                    LEFT JOIN c_brgsedia c ON c.kd_brg = a.kd_brg
                                                    WHERE a.registrasi='$_GET[registrasi]' AND a.flag_kirim = 'N'
                                                    ORDER BY b.idminta ASC");
                                                ?>
                                                    <div class="form-group">
                                                    <form name='myform' method='post' action='<?php echo"$aksi?module=sedia_pengajuan&act=kirimPermohonan";?>'>
                                                  <input type='hidden' class='form-control' name='registrasi' placeholder='Nomor Pengajuan' maxlength='4' value='<?php echo"$r[registrasi]";?>' readonly>

                                                  <table id="table_5" class="table table-bordered table-striped responsive">
                                                  <thead>
                                                    <tr>
                                                        <th bgcolor="#88c7f2"><input class='minimal' type="checkbox" onchange="checkAll(this)">&nbsp;&nbsp;&nbsp;PILIH</th>
                                                        <th bgcolor="#88c7f2">URAIAN (KODE - UR BARANG)</th>
                                                        <th bgcolor="#88c7f2">SAT.</th>
                                                        <th bgcolor="#88c7f2">MEREK_TYPE</th>
                                                        <th bgcolor="#88c7f2">QTY</th>
                                                        <th bgcolor="#88c7f2">HAPUS</th>
                                                    </tr>
                                                    </thead>
                                                        <tbody>
                                                  <?php
                                                  $i = 0;
                                                  while($o = mysqli_fetch_array($qry)){
                                                  ?>
                                                    <tr>
                                                        <td>
                                                        <div class='border-checkbox-group border-checkbox-group-primary'>
                                                        <input class='minimal' type='checkbox' name='registrasi<?php echo"$i";?>' value='<?php echo"$o[registrasi]";?>' />
                                                        </div>
                                                        </td>
                                                        <td><?php echo"$o[kd_brg] - $o[ur_brg]";?></td>
                                                        <td><?php echo"$o[satuan]";?></td>
                                                        <td><?php echo"$o[merek_type]";?></td>
                                                        <td><?php echo"$o[qtyMohon]";?></td>
                                                        <td><a class='btn btn-danger btn-sm' href='<?php echo "$aksi?module=sedia_pengajuan&act=hapus&kd_brg=$o[kd_brg]&registrasi=$o[registrasi]"?>' onClick="return confirm('Anda yakin ingin menghapus ?<?php echo $o['ur_brg'];?>?');"><i class='fa fa-trash'></i></a>
                                                        </td>
                                                    </tr>
                                                    </tfoot>
                                                  <?php $i++;  } ?>
                                                  </table>
                                                  <input type='hidden' name='n' value='<?php echo"$i";?>'/>
                                                  <button type='submit' id='btnKirim' class='btn btn-sm btn-danger'>
                                                  <i class='fa fa-send'></i> &nbsp;&nbsp; KIRIM PENGAJUAN</button>
                                                  </div>
                                                  <!-- /.box-body -->
                                                  </form>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
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
  function checkAll(box) 
  {
   let checkboxes = document.getElementsByTagName('input');

   if (box.checked) { // jika checkbox teratar dipilih maka semua tag input juga dipilih
    for (let i = 0; i < checkboxes.length; i++) {
     if (checkboxes[i].type == 'checkbox') {
      checkboxes[i].checked = true;
     }
    }
   } else { // jika checkbox teratas tidak dipilih maka semua tag input juga tidak dipilih
    for (let i = 0; i < checkboxes.length; i++) {
     if (checkboxes[i].type == 'checkbox') {
      checkboxes[i].checked = false;
     }
    }
   }
  }
 </script>
