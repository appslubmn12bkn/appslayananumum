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

	if ($module == 'bmnTambah' and $act == 'addBMN') {
		$tgl = date('Y-m-d');
		$nupAW = $_POST['nupAW'];
		$nupAK = $_POST['nupAK'];
		for ($i = $nupAW; $i <= $nupAK; $i++) {
			$cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT b_kdbrg, b_noaset FROM b_bmnbaru WHERE b_kdbrg='$_POST[kd_brg]' AND b_noaset ='$i'"));
			if ($cek > 0) {
?>
				<script type="text/javascript">
					setTimeout(function() {
						swal({
							title: 'ERROR',
							text: 'DATA SUDAH ADA',
							type: 'error',
							showConfirmButton: false
						});
					}, 10);
					window.setTimeout(function() {
						window.location.replace('../../appsmedia.php?module=bmnTambah');
					}, 1500);
				</script>
			<?php

			} else {
				mysqli_query($koneksi, "INSERT INTO b_bmnbaru
								SET	b_kdbrg			= '$_POST[kd_brg]',
									b_noaset		= '$i',
									b_tgltrn		= '$_POST[b_tgltrn]',
									b_tglbuku		= '$_POST[b_tglbuku]',
									b_tglperlh		= '$_POST[b_tglperlh]',
									b_kondisi		= '$_POST[b_kondisi]',
									b_tercatat		= '$_POST[b_tercatat]',
									b_kuantitas		= '$_POST[b_kuantitas]',
									b_rphaset		= '0',
									b_merektype		= '$_POST[b_merektype]',
									b_bmntrn		= '$_POST[jns_trn]',
									b_keterangan	= '$_POST[b_keterangan]',
									b_bmnasalperlh	= '$_POST[b_bmnasalperlh]'");

				mysqli_query($koneksi, "INSERT INTO b_bmnsatker
								SET	kd_brg		= '$_POST[kd_brg]',
									no_aset		= '$i',
									thn_ang     = '$_POST[thn_ang]',
									periode     = '$_POST[periode]',
									kd_lokasi	= '$_POST[kdsatker]',
									tgl_buku	= '$_POST[b_tglbuku]',
									tgl_perlh	= '$_POST[b_tglperlh]',
									kondisi		= '$_POST[b_kondisi]',
									tercatat	= '$_POST[b_tercatat]',
									kuantitas	= '$_POST[b_kuantitas]',
									rph_aset	= '0',
									rph_sat		= '0',
									merk_type	= '$_POST[b_merektype]',
									jns_trn		= '$_POST[jns_trn]',
									keterangan  = '$_POST[b_keterangan]',
									asal_perlh	= '$_POST[b_bmnasalperlh]'");

			?>
				<script type="text/javascript">
					setTimeout(function() {
						swal({
							title: 'SUKSES',
							text: 'BMN Baru Berhasil di tambahkan',
							type: 'success',
							showConfirmButton: false
						});
					}, 10);
					window.setTimeout(function() {
						window.location.replace('../../appsmedia.php?module=bmnTambah');
					}, 1500);
				</script>
			<?php
			}
		}
	} 


	elseif ($module == 'bmnTambah' and $act == 'updateHarga') {
		$tgl = date('Y-m-d');
		$nupAW = $_POST['nupAW'];
		$nupAK = $_POST['nupAK'];
		for ($i = $nupAW; $i <= $nupAK; $i++) {
			mysqli_query($koneksi, "UPDATE b_bmnbaru
								SET	b_kdbrg			= '$_POST[kd_brg]',
									b_noaset		= '$i',
									b_rphaset		= '$_POST[b_rphaset]'
									WHERE b_kdbrg = '$_POST[kd_brg]' AND b_noaset = '$i'");

			mysqli_query($koneksi, "UPDATE b_bmnsatker
								SET	b_kdbrg		= '$_POST[kd_brg]',
									b_noaset	= '$i',
									rph_aset	= '$_POST[b_rphaset]',
									rph_sat		= '$_POST[b_rphsat]'
									WHERE b_kdbrg = '$_POST[kd_brg]' AND b_noaset = '$i'");

			?>
				<script type="text/javascript">
					setTimeout(function() {
						swal({
							title: 'SUKSES',
							text: 'BMN Baru Berhasil di tambahkan',
							type: 'success',
							showConfirmButton: false
						});
					}, 10);
					window.setTimeout(function() {
						window.location.replace('../../appsmedia.php?module=bmnTambah');
					}, 1500);
				</script>
			<?php
		}
	} 

	elseif ($module == 'bmnTambah' and $act == 'updateBAST') {
		$tgl = date('Y-m-d');
		$nupAW = $_POST['nupAW'];
		$nupAK = $_POST['nupAK'];
		for ($i = $nupAW; $i <= $nupAK; $i++) {
			mysqli_query($koneksi, "UPDATE b_bmnbaru
								SET	b_kdbrg		= '$_POST[kd_brg]',
									b_noaset	= '$i',
									b_bast		= '$_POST[b_bast]',
									b_tglbast	= '$_POST[b_tglbast]'
									WHERE b_kdbrg = '$_POST[kd_brg]' AND b_noaset = '$i'");

			?>
				<script type="text/javascript">
					setTimeout(function() {
						swal({
							title: 'SUKSES',
							text: 'BMN Baru Berhasil di tambahkan',
							type: 'success',
							showConfirmButton: false
						});
					}, 10);
					window.setTimeout(function() {
						window.location.replace('../../appsmedia.php?module=bmnTambah');
					}, 1500);
				</script>
			<?php
		}
	}
	elseif ($module == 'bmnUpload' and $act == 'saveBAST') {
		$createdDate = date('Y-m-d H:i:s');
		$namaFile = $_FILES['bukti']['name'];
		$namaSementara = $_FILES['bukti']['tmp_name'];
		$dirUpload = "../../_bast/";
		$terupload = move_uploaded_file($namaSementara, $dirUpload . $namaFile);
		if ($terupload) {
			mysqli_query($koneksi, "INSERT INTO b_uploadbast
									SET	b_kdbrg			= '$_POST[kd_brg]',
										b_noaset_awal  	= '$_POST[nupAW]',
										b_noaset_akhir	= '$_POST[nupAK]',
										b_merektype 	= '$_POST[b_merektype]',
										b_tglbuku  		= '$_POST[b_tglbuku]',
										b_tglperlh		= '$_POST[b_tglperlh]',
										b_kondisi 		= '$_POST[b_kondisi]',
										b_kuantitas 	= '$_POST[qty]',
										b_bast  		= '$_POST[b_bast]',
										b_tglbast		= '$_POST[b_tglbast]',
										b_bukti	 		= '$namaFile'");
			?>
			<script type="text/javascript">
				setTimeout(function() {
					swal({
						title:'SUKSES',
						text: 'BAST Berhasil di Upload',
						type: 'success',
						showConfirmButton: false
					});
				}, 10);
				window.setTimeout(function() {
					window.location.replace('../../appsmedia.php?module=bmnUpload');
				}, 1500);
			</script>
		<?php
		} else {
		?>
			<script type="text/javascript">
				setTimeout(function() {
					swal({
						title: 'GAGAL',
						text: 'FILE GAGAL DIUNGGAH',
						type: 'error',
						showConfirmButton: false
					});
				}, 10);
				window.setTimeout(function() {
					window.location.replace('../../appsmedia.php?module=bmnUpload');
				}, 1500);
			</script>
		<?php
		}
	} 
}
?>