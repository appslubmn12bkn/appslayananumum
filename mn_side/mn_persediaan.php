<?php
 
include "../config/koneksi.php";
session_start();

$cek=umenu_akses("?module=sedia_pengajuan",$_SESSION[NIP]);
if($cek==1 OR $_SESSION[LEVEL]=='admin' OR $_SESSION[LEVEL]=='user'){ ?>
<li><a href="?module=sedia_pengajuan">Permohonan</a></li>
<?php }

$cek=umenu_akses("?module=c_printsedia",$_SESSION[NIP]);
if($cek==1 OR $_SESSION[LEVEL]=='admin' OR $_SESSION[LEVEL]=='user'){ ?>
<li><a href="?module=c_printsedia">Print Pengajuan</a></li>
<?php }

$cek=umenu_akses("?module=c_cekstatus",$_SESSION[NIP]);
if($cek==1 OR $_SESSION[LEVEL]=='admin' OR $_SESSION[LEVEL]=='user'){ ?>
<li><a href="?module=c_cekstatus">Status Pengajuan</a></li>
<?php }

?>
                            
                            
                            