 <?php
 
include "../config/koneksi.php";
session_start();

$cek=umenu_akses("?module=tbl_ppnpn",$_SESSION[NIP]);
if($cek==1 OR $_SESSION[LEVEL]=='admin' OR $_SESSION[LEVEL]=='user'){ ?>
<li>
<a href="?module=tbl_ppnpn">Daftar PPNPN</a>
</li>
<?php }

?>
