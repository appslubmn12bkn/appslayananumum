<?php
 
include "../config/koneksi.php";
session_start();

$cek=umenu_akses("?module=bmnMaster",$_SESSION[NIP]);
if($cek==1 OR $_SESSION[LEVEL]=='admin' OR $_SESSION[LEVEL]=='user'){ ?>
<li><a href="?module=bmnMaster">Master Aset</a></li>
<?php }

$cek=umenu_akses("?module=bmnHistory",$_SESSION[NIP]); 
if($cek==1 OR $_SESSION[LEVEL]=='admin' OR $_SESSION[LEVEL]=='user'){ ?>
<li><a href="?module=bmnHistory">History BMN</a></li>
<?php }

$cek=umenu_akses("?module=bmnTambah",$_SESSION[NIP]);
if($cek==1 OR $_SESSION[LEVEL]=='admin' OR $_SESSION[LEVEL]=='user'){ ?>
<li><a href="?module=bmnTambah">Tambah Aset</a></li>
<?php }

$cek=umenu_akses("?module=bmnUpload",$_SESSION[NIP]);
if($cek==1 OR $_SESSION[LEVEL]=='admin' OR $_SESSION[LEVEL]=='user'){ ?>
<li><a href="?module=bmnUpload">Upload BAST Hibah (TF)</a></li>
<?php }

?>
                            
                            
                            