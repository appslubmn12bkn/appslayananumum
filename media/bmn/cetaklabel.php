<?php
session_start();
ob_start();
include('../../config/phpqrcode/qrlib.php');	// Ini adalah letak pemyimpanan plugin qrcode
include('../../config/koneksi.php');
include('../../config/inc.library.php');
include('../../config/fungsi_indotgl.php');
include('../../includes/css.php');

if (empty($_SESSION['UNAME']) and empty($_SESSION['PASSWORD'])) {
	echo "

<section class='content'>

      <div class='error-page'>
        <h2 class='headline text-red'>500</h2>

        <div class='error-content'>
          <h3><i class='fa fa-warning text-red'></i> Oops! Something went wrong.</h3>

          <p>
            We will work on fixing that right away.
            Meanwhile, you may <a href='localhost/appslubmn'>return to dashboard</a> Login Dulu YA.
          </p>
        </div>
      </div>
      <!-- /.error-page -->

    </section>";
} else {
	$html = '
<html>
<head>
</head>
<body>';
	echo "";
?>

	<html>

	<head>
		<style type="text/css">

			h3 {
				text-align: right;
			}


		</style>
	</head>

	<body>
		<?php
		# Baca variabel URL
		$kdbrg = $_GET['kd_brg'];
		$nupAW = $_GET['nupAW'];
		$nupAK = $_GET['nupAK'];

		$qry=	" SELECT a.b_kdbrg, a.b_noaset, 
						b.kdukpb, b.nmukpb, a.b_tglperlh,
						b.pebin, b.pbi, b.wilayah,
						b.ukpb, b.upkpb, b.jk,
						c.kd_brg, c.ur_sskel,
						d.merk_type, d.kondisi, 
						d.thn_ang, d.periode,
						d.kd_brg, d.no_aset, d.status_label,
						d.jns_trn, d.kd_lokasi
						FROM b_bmnbaru a
						LEFT JOIN b_nmbmn c ON c.kd_brg=a.b_kdbrg
						LEFT JOIN b_bmnsatker d ON d.kd_brg=a.b_kdbrg AND d.no_aset=a.b_noaset
						LEFT JOIN s_satker b ON b.kdukpb=d.kd_lokasi
						WHERE a.b_kdbrg='$kdbrg'
						AND  a.b_noaset BETWEEN '$nupAW ' AND '$nupAK'
						AND (d.jns_trn IN (100, 101, 102, 103, 105, 113, 107, 112))
						ORDER BY a.b_noaset ASC";
		$label = mysqli_query($koneksi,$qry);
		
		for ($i = $nupAW; $i <= $nupAK; $i++) {
			mysqli_query($koneksi, "UPDATE b_bmnsatker
								SET	kd_brg			= '$kdbrg',
										no_aset		= '$i',
										status_label		= '2'
									WHERE kd_brg = '$kdbrg' AND no_aset = '$i'");

		?>

		<?php 
		

		$tempdir = "../../_qrcodeimg/";		// Nama folder untuk pemyimpanan file qrcode

		if (!file_exists($tempdir))		//jika folder belum ada, maka buat
			mkdir($tempdir);

		?>
		<table width="350" height="60" border='0'>
			<?php while ($barcode = mysqli_fetch_array($label)) {
				// berikut adalah parameter qr code
				$teks_qrcode	= "$barcode[kd_brg]$barcode[b_noaset] $barcode[kd_lokasi]";
				$namafile		= "$barcode[b_noaset].png";
				$quality		= "Q"; // ini ada 4 pilihan yaitu L (Low), M(Medium), Q(Good), H(High)
				$ukuran			= 2; // 1 adalah yang terkecil, 10 paling besar
				$padding		= 2;

				QRCode::png($teks_qrcode, $tempdir . $namafile, $quality, $ukuran, $padding);
			?>
			<tr>
					<td>
					<font face="Roboto" size="4">
					<B><?php echo "$barcode[pebin]"; ?>.<?php echo "$barcode[pbi]"; ?>.<?php echo "$barcode[wilayah]"; ?>.<?php echo "$barcode[ukpb]"; ?>.<?php echo "$barcode[upkpb]"; ?>.<?php echo "$barcode[jk]"; ?> <?php echo "$barcode[thn_ang]"; ?></B>
					</font>
					</td>
			</tr>
			<tr>
		    <td width="269">
		    <font face="Aero" size="6">
				<b><?php echo "$barcode[b_kdbrg]"; ?> <?php echo "$barcode[b_noaset]"; ?></b>
				</font><br>
				<font face="Roboto" size="4">
				<?php echo "$barcode[ur_sskel]"; ?><br>
				<?php echo "$barcode[merk_type]"; ?>
				</font>
				</td>
			</tr>
			<tr>
				<td align="right">
				<font face="Roboto" size="3"><b>				
				<?php echo "$barcode[jns_trn]"; ?>_<?php echo "$barcode[thn_ang]"; ?> <?php echo "$barcode[periode]"; ?> <?php echo "$barcode[ukpb]"; ?></b>
				<br>
				<img src="../../_qrcodeimg/<?php echo $namafile; ?>"><br>
				<b><?php echo "$barcode[nmukpb]"; ?></b>
				</font><br>
				<font face="Roboto" size="1"><b>sensus_22</b></font>
				</td>
			</tr>
			<tr><td height="14"></td></tr>
<?php }} ?>
		</table>

	</body>

	</html>
<?php } ?>
<?php
//$out = ob_get_contents();
//ob_end_clean();
//include("../../MPDF/mpdf.php");
//$mpdf = new mPDF('c','A4-P','');
//$mpdf = new mPDF('utf-8',array(75,35));
//$mpdf->SetDisplayMode('fullpage');
//$stylesheet = file_get_contents('mpdf/mpdf.css');
//$mpdf->WriteHTML($stylesheet,1);
//$mpdf->WriteHTML($html);
//$mpdf->WriteHTML($out);
//$mpdf->Output();
?>