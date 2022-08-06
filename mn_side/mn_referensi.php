 <?php
 
include "../config/koneksi.php";
session_start();

$cek=umenu_akses("?module=tbl_stokbrg",$_SESSION[NIP]);
if($cek==1 OR $_SESSION[LEVEL]=='admin' OR $_SESSION[LEVEL]=='user'){ ?>
<li>
<a href="?module=tbl_stokbrg">Daftar Stok Barang</a>
</li>
<?php }

$cek=umenu_akses("?module=tbl_brg",$_SESSION[NIP]);
if($cek==1 OR $_SESSION[LEVEL]=='admin' OR $_SESSION[LEVEL]=='user'){ ?>
<li>
<a href="?module=tbl_brg">Tabel Barang Sedia</a>
</li>
<?php }

$cek=umenu_akses("?module=mobnas",$_SESSION[NIP]);
if($cek==1 OR $_SESSION[LEVEL]=='admin' OR $_SESSION[LEVEL]=='user'){ ?>
<li>
<a href="?module=mobnas">Kendaraan Dinas</a>
</li>
<?php }

$cek=umenu_akses("?module=sarprasunit",$_SESSION[NIP]);
if($cek==1 OR $_SESSION[LEVEL]=='admin' OR $_SESSION[LEVEL]=='user'){ ?>
<li>
<a href="?module=sarprasunit">Ruangan</a>
</li>
<?php }

?>
