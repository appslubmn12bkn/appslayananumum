<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=1,initial-scale=1,user-scalable=1" />
	<link rel="stylesheet" type="text/css" href="../../bower_components/sweetalert/css/sweetalert.css" />
	<script src="../../bower_components/sweetalert/js/sweetalert.min.js"></script>
	<script src="../../bower_components/sweetalert/js/jquery.1.12.0-min.js"></script>
</head>

</html>
<?php
session_start();
include "../../config/koneksi.php";
if (empty($_SESSION['UNAME']) and empty($_SESSION['PASSWORD'])) {
	echo "<link href='../../bootstrap/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
			<center>Untuk mengakses modul, Anda harus login <br>";
	echo "<a href=index.php><b>LOGIN</b></a></center>";
} else {


	$module = $_GET['module'];
	$act = $_GET['act'];

	if ($module == 'e_catekspedisi' and $act == 'catatSurat') {
		mysqli_query($koneksi, "INSERT INTO	e_tblekspedisi
							SET	e_alamat	= '$_POST[tujuanSurat]',
								e_tglterima	= '$_POST[tglTerima]',
								e_nosurat	= '$_POST[noSurat]',
								e_flag		= '1',
								e_satker	= '$_POST[satker]',
								e_instansi	= '$_POST[instansi]',
								e_unitkirim	= '$_POST[unut]'");
?>
		<script type="text/javascript">
			setTimeout(function() {
				swal({
					title: 'SUKSES',
					text: 'Surat Ekspedisi, berhasil dicatat',
					type: 'success',
					showConfirmButton: false
				});
			}, 10);
			window.setTimeout(function() {
				window.location.replace('../../appsmedia.php?module=e_catekspedisi');
			}, 1000);
		</script>
	<?php
		//header('location:../../media.php?module='.$module);
	} elseif ($module == 'ekspedisi' and $act == 'hapus') {
		mysqli_query($koneksi, "DELETE FROM e_tblekspedisi WHERE idekspedisi = '$_GET[idekspedisi]'");
	?>
		<script type="text/javascript">
			setTimeout(function() {
				swal({
					title: 'UPDATE SUKSES',
					text: 'Hapus Berhasil',
					type: 'success',
					showConfirmButton: false
				});
			}, 10);
			window.setTimeout(function() {
				window.location.replace('../../appsmedia.php?module=e_catekspedisi');
			}, 1000);
		</script>
<?php
		//header('location:../../media.php?module='.$module);
	}
}
?>