<?php
 
include "../config/koneksi.php";
session_start();

$cek=umenu_akses("?module=e_instansi",$_SESSION[NIP]);
if($cek==1 OR $_SESSION[LEVEL]=='admin' OR $_SESSION[LEVEL]=='user'){ ?>
<li><a href="?module=e_instansi">Master Instansi</a></li>
<?php }

$cek=umenu_akses("?module=e_catekspedisi",$_SESSION[NIP]);
if($cek==1 OR $_SESSION[LEVEL]=='admin' OR $_SESSION[LEVEL]=='user'){ ?>
<li><a href="?module=e_catekspedisi">Surat Keluar (Kirim)</a></li>
<?php }

$cek=umenu_akses("?module=ct_ekpedisi",$_SESSION[NIP]);
if($cek==1 OR $_SESSION[LEVEL]=='admin' OR $_SESSION[LEVEL]=='user'){ ?>
<li><a href="?module=ct_ekpedisi">Cetak Tanda Terima</a></li>
<?php }

$cek=umenu_akses("?module=paket",$_SESSION[NIP]);
if($cek==1 OR $_SESSION[LEVEL]=='admin' OR $_SESSION[LEVEL]=='user'){ ?>
<li><a href="?module=paket">Daftarkan Paket (Masuk)</a></li>
<?php }

?>
