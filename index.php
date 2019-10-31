<!DOCTYPE html>
<html>
<head>
	<title></title>
	<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
</head>
<body>


	<a href="gen_rekapitulasi_progres_fisik_keuangan.php">Rekapitulasi Progres Fisik & Keuangan</a>
	<br>
	<a href="gen_rank_balai_progres_fisik_keuangan.php">Rank Balai Progres Fisik & Keuangan</a>
	<br>
	<a href="gen_kritis_perbalai.php">Jumlah Paket Kritis Perbalai</a>
	<br>
	<a href="gen_kritis_periode_1.php">Paket Kritis Fisik Periode 1</a>
	<br>
	<a href="gen_kritis_periode_2.php">Paket Kritis Fisik Periode 2</a>
	<br>
	<a href="gen_progres_lelang.php">Progres Pelelangan Perbalai</a>
	<br>
	<a href="gen_paket_belum_lelang.php">Paket-paket Belum Lelang</a>
	<br>
	<a href="gen_progres_paket_sbsn.php">Progres Paket SBSN Perbalai</a>
	<br>
	<a href="gen_daftar_paket_sbsn.php">Daftar Paket SBSN</a>	
	<br>
	<a href="gen_rekapitulasi_pelaksanaan_anggaran.php">Rekapitulasi Pelaksanaan Anggaran</a>
	<hr>

	<p>
		REKAPITULASI KONTRAKTUAL KESELURUHAN PRESERVASI JALAN (REGULER DAN LONG SEGMENT)
	</p>
	<?php
		require('koneksi.php');
		$sql = "SELECT kode_balai, nama_balai FROM balai";
		$query = mysqli_query($connect, $sql);
		while($row = mysqli_fetch_array($query)){
			echo '<li>';
			echo '<a href="gen_rekapitulasi_kontrak_keseluruhan_perbalai.php?kode_balai='.$row['kode_balai'].'">'.$row['nama_balai'].'</a><br>';
			echo '</li>';
		} 
	?>

</body>
</html>