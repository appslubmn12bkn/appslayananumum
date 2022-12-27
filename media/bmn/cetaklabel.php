<?php
session_start();
ob_start();
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
			h1 {
				font-family: Bookman Old Style;
				font-size: 11px;
				font-style: italic;
				font-variant: normal;
				font-weight: 400;
				line-height: 15.6px;
			}

			h2 {
				font-family: Bookman Old Style;
				font-size: 11px;
				font-style: italic;
				font-variant: normal;
				font-weight: 400;
				line-height: 15.6px;
			}

			h3 {
				font-family: Arial;
				font-size: 14px;
				font-style: normal;
				font-variant: normal;
				text-align: center;
				font-weight: bold;
				line-height: 15.4px;
			}

			h4 {
				font-family: Arial;
				font-size: 12px;
				text-align: left;
				font-variant: normal;
				font-weight: 400;
				line-height: 15.6px;
			}

			h5 {
				font-family: Arial;
				font-size: 11px;
				text-align: left;
				font-variant: normal;
				font-weight: 400;
				line-height: 15.6px;
			}

			p {
				font-family: Arial;
				font-size: 11px;
				font-style: normal;
				font-variant: normal;
				font-weight: 400;
			}

			blockquote {
				font-family: Bookman Old Style;
				font-size: 21px;
				font-style: normal;
				font-variant: normal;
				font-weight: 400;
				line-height: 30px;
			}

			pre {
				font-family: Bookman Old Style;
				font-size: 13px;
				font-style: normal;
				font-variant: normal;
				font-weight: 400;
				line-height: 18.5667px;
			}

			.table1 {
				font-family: arial;
				font-size: 14px;
				color: #444;
				border-collapse: collapse;
				width: 100%;
				border: 1px solid #000;
			}


			.table1 th {
				background: #ccc;
				color: #000;
				font-weight: normal;
				border: 1px solid #000;
			}

			.table1 td {
				padding: 8px 20px;
				border: 0px solid #000;
			}

			.table1 tr:hover {
				background-color: #f5f5f5;
			}

			.table1 tr:nth-child(even) {
				background-color: #f2f2f2;
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
						b.kdukpb, b.nmukpb, 
						b.pebin, b.pbi, b.wilayah,
						b.ukpb, b.upkpb, b.jk,
						c.kd_brg, c.ur_sskel,
						d.merk_type, d.kondisi, d.thn_ang,
						d.kd_brg, d.no_aset, d.jns_trn, d.kd_lokasi
						FROM b_bmnbaru a
						LEFT JOIN b_nmbmn c ON c.kd_brg=a.b_kdbrg
						LEFT JOIN b_bmnsatker d ON d.kd_brg=a.b_kdbrg AND d.no_aset=a.b_noaset
						LEFT JOIN s_satker b ON b.kdukpb=d.kd_lokasi
						WHERE a.b_kdbrg='$kdbrg'
						AND  a.b_noaset BETWEEN '$nupAW ' AND '$nupAK'
						AND (d.jns_trn IN (100, 101, 102, 103, 105, 113, 107, 112))
						ORDER BY a.b_noaset ASC";
		$label = mysqli_query($koneksi,$qry);
		?>

		<table width="350" height="60" border='1'>
			<?php while ($barcode = mysqli_fetch_array($label)) {?>
			<tr>
					<td>
						<font face='arial' size='2'>
							&nbsp;<strong><?php echo "$barcode[pebin]"; ?>.<?php echo "$barcode[pbi]"; ?>.<?php echo "$barcode[wilayah]"; ?>.<?php echo "$barcode[ukpb]"; ?>.<?php echo "$barcode[upkpb]"; ?>.<?php echo "$barcode[jk]"; ?> <?php echo "$barcode[thn_ang]"; ?></strong>
						</font>
					</td>
			</tr>
			
			<tr>
					<td height="100">
						<font face='arial' size='1' >
							&nbsp;<strong><?php echo "$barcode[pebin]"; ?>.<?php echo "$barcode[pbi]"; ?>.<?php echo "$barcode[wilayah]"; ?>.<?php echo "$barcode[ukpb]"; ?>.<?php echo "$barcode[upkpb]"; ?>.<?php echo "$barcode[jk]"; ?> <?php echo "$barcode[thn_ang]"; ?></strong>
						<br>
						
							&nbsp;<strong><?php echo "$barcode[nmukpb]"; ?></strong>
						</font>
					</td>
			</tr>

			<tr>
					<td>
						<font face='arial' size='2'>
							&nbsp;<strong><?php echo "$barcode[nmukpb]"; ?></strong>
						</font>
					</td>
			</tr>

		</table>
<br><br>








		<table width="215" height="60" border='1'>
			
				<tr>
					<td colspan='2'>
						<font face='arial' size='1'>
							&nbsp;<strong><?php echo "$barcode[pebin]"; ?>.<?php echo "$barcode[pbi]"; ?>.<?php echo "$barcode[wilayah]"; ?>.<?php echo "$barcode[ukpb]"; ?>.<?php echo "$barcode[upkpb]"; ?>.<?php echo "$barcode[jk]"; ?> <?php echo "$barcode[thn_ang]"; ?></strong>
						<br>
						
							&nbsp;<strong><?php echo "$barcode[nmukpb]"; ?></strong>
						</font>
					</td>
				</tr>
				<tr>
					<td width="30" height="60" valign='top'><img src="../../_qrcodeimg/<?php echo $namafile; ?>">
				</td>
					<td colspan="2">
						<font face='arial' size='3'>
						<strong><?php echo "$barcode[kd_brg]"; ?>&nbsp;<?php echo "$barcode[b_noaset]"; ?></strong>
						</font>
						<font face='arial' size='1'>
						</font>
						<br>
						<font face='arial' size='1'>
							<?php echo "$barcode[ur_sskel]"; ?> - <?php echo "$barcode[merk_type]"; ?><br>
							<?php echo "$barcode[b_unik]"; ?> <br>
							<?php echo "$barcode[r_ruangannama]"; ?> 
						</font>
					</td>
				</tr>
				<tr>
					<td ></td>
					<td height="10px"> </td>
				</tr>
			<?php } ?>

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