<?php
require('fpdf.php');
require('koneksi.php');

class PDF extends FPDF {

	function Header(){
		$this->Image('bg.jpeg', 0, 0,297);
	}

	// REKAPITULASI PROGRES FISIK KEUANGAN
	function head_rekapitulasi_progres_fisik_keuangan(){
		$this->SetFont('Arial','B',15);
		$this->Cell(0,7,'REKAPITULASI PROGRES FISIK DAN KEUANGAN', 0, 1,'L');
			// $this->SetX($this->GetX() + 60);
		$this->SetFont('Arial','B',10);

		$mydate=getdate(date("U"));
		$dt = $mydate['mday'].' '.$mydate['month'].' '.$mydate['year'];
		$this->Cell(0,5,'Sumber: SIPP Terpadu, status: '.$dt, 0, 0,'L');
		$this->Ln(1);

		$this->SetFont('Arial','B',5);

		$this->Ln(10);
		$this->Cell(5,12,'NO',1,0,'C');
		$this->Cell(50,12,'BALAI',1,0,'C');
		$this->Cell(12,12,'JUMLAH',1,0,'C');

		$this->Cell(36,30,'',0,0,'L'); // cell bantu
		$this->SetX($this->GetX() - 36);
		$this->Cell(36,6,'TAHAPAN KONTRAK',1,2,'C');
		$this->Cell(12,6,'BELUM',1,0,'C');
		$this->Cell(12,6,'LELANG',1,0,'C');
		$this->Cell(12,6,'KONTRAK',1,0,'C');

		$this->SetY($this->GetY() - 6);
		$this->SetX($this->GetX() + 103);
		$this->Cell(12,12,'SBSN',1,0,'C');
		$this->Cell(12,12,'L.SEGMEN',1,0,'C');

		$this->Cell(25,12,'',1,0,'L'); // cell bantu
		$this->SetX($this->GetX() - 25);
		$this->Cell(25,6,'PAGU',1,2,'C');
		$this->Cell(25,6,'JUMLAH',1,0,'C');

		$this->SetY($this->GetY() - 6);
		$this->SetX($this->GetX() + 152);
		$this->Cell(25,12,'NILAI KONTRAK',1,0,'C');
		$this->Cell(25,12,'SISA LELANG',1,0,'C');

		$this->Cell(25,12,'',1,0,'L'); // cell bantu
		$this->SetX($this->GetX() - 25);
		$this->Cell(25,6,'REALISASI',1,2,'C');
		$this->Cell(25,6,'JUMLAH',1,0,'C');

		$this->SetY($this->GetY() - 6);
		$this->SetX($this->GetX() + 227);
		$this->Cell(12,12,'REAL.KEU',1,0,'C');
		$this->Cell(12,12,'RENC.FISIK',1,0,'C');
		$this->Cell(12,12,'REAL.FISIK',1,0,'C');
		$this->Cell(12,12,'DEV.FISIK',1,0,'C');
		$this->Ln(12);
	}	

	function data_rekapitulasi_progres_fisik_keuangan(){
		require('koneksi.php');
		$this->SetFont('Arial','',7);

		$sql = "SELECT * FROM v_rekapitulasi_progres_fisik_dan_keuangan";
		$query = mysqli_query($connect, $sql);
		$num = 0;
		while ($row = mysqli_fetch_array($query)) {
			$num++;
			$this->Cell(5,6,$num,1,0,'C');
			$this->Cell(50,6,$row['nama_balai'],1,0,'L');
			$this->Cell(12,6,$row['jumlah_paket'],1,0,'R');
			$this->Cell(12,6,$row['siap'],1,0,'R');
			$this->Cell(12,6,$row['lelang'],1,0,'R');
			$this->Cell(12,6,$row['kontrak'],1,0,'R');
			$this->Cell(12,6,$row['sbsn'],1,0,'R');
			$this->Cell(12,6,$row['longsegmen'],1,0,'R');
			$this->Cell(25,6,$row['pagu_rpm'],1,0,'R');
			$this->Cell(25,6,$row['nilai_kontrak'],1,0,'R');
			$this->Cell(25,6,$row['sisa_lelang'],1,0,'R');
			$this->Cell(25,6,$row['realisasi_keuangan_rpm'],1,0,'R');
			$this->Cell(12,6,$row['realisasi_keuangan_persen'],1,0,'R');
			$this->Cell(12,6,$row['rencana_fisik'],1,0,'R');
			$this->Cell(12,6,$row['realisasi_fisik'],1,0,'R');
			$this->Cell(12,6,$row['deviasi_fisik'],1,1,'R');
		}
	}

	function total_rekapitulasi_progres_fisik_keuangan(){
		require('koneksi.php');
		$this->SetFont('Arial','B',7);

		$sql = "SELECT * FROM v_total_rekapitulasi_progres_fisik_dan_keuangan";
		$query = mysqli_query($connect, $sql);
		$row = mysqli_fetch_array($query);
		$this->Cell(55,6,'TOTAL',1,0,'C');
		$this->Cell(12,6,$row['jmlpaket'],1,0,'R');
		$this->Cell(12,6,$row['siap'],1,0,'R');
		$this->Cell(12,6,$row['lelang'],1,0,'R');
		$this->Cell(12,6,$row['kontrak'],1,0,'R');
		$this->Cell(12,6,$row['sbsn'],1,0,'R');
		$this->Cell(12,6,$row['longsegmen'],1,0,'R');
		$this->Cell(25,6,$row['pagurpm'],1,0,'R');
		$this->Cell(25,6,$row['nilaikontrak'],1,0,'R');
		$this->Cell(25,6,$row['sisa_lelang'],1,0,'R');
		$this->Cell(25,6,$row['realisasikeuanganrpm'],1,0,'R');
		$this->Cell(12,6,$row['realisasi_keuangan_persen'],1,0,'R');
		$this->Cell(12,6,$row['rencanafisik'],1,0,'R');
		$this->Cell(12,6,$row['realisasifisik'],1,0,'R');
		$this->Cell(12,6,$row['deviasifisik'],1,1,'R');	
	}

	// RANK BALAI PROGRES FISIK KEUANGAN
	function head_rank_balai_progres_fisik_keuangan(){
		$this->SetFont('Arial','B',15);
		$this->SetX($this->GetX() + 10);
		$this->Cell(0,7,'RANK BALAI PROGRES FISIK DAN KEUANGAN', 0, 1,'L');
		$this->SetX($this->GetX() + 10);
		$this->SetFont('Arial','B',10);

		$mydate=getdate(date("U"));
		$dt = $mydate['mday'].' '.$mydate['month'].' '.$mydate['year'];
		$this->Cell(0,5,'Sumber: SIPP Terpadu, status: '.$dt, 0, 0,'L');
		$this->Ln(1);

		$this->SetFont('Arial','B',5);
		$this->Ln(10);

		$this->SetX($this->GetX() + 12);
		$this->Cell(5,12,'No',1,0,'C');
		$this->Cell(50,12,'BALAI',1,0,'C');
		$this->Cell(12,12,'JUMLAH',1,0,'C');

		$this->Cell(25,12,'',1,0,'L'); // cell bantu
		$this->SetX($this->GetX() - 25);
		$this->Cell(25,6,'PAGU',1,2,'C');
		$this->Cell(25,6,'JUMLAH',1,0,'C');

		$this->Cell(37,30,'',0,0,'L'); // cell bantu
		$this->SetY($this->GetY() - 6);
		$this->SetX($this->GetX() + 104);
		$this->Cell(37,6,'PROGNOSIS',1,2,'C');
		$this->Cell(25,6,'JUMLAH',1,0,'C');
		$this->Cell(12,6,'%',1,0,'C');

		$this->SetY($this->GetY() - 6);
		$this->SetX($this->GetX() + 141);
		$this->Cell(25,12,'NILAI KONTRAK',1,0,'C');


		$this->Cell(37,30,'',0,0,'L'); // cell bantu
		$this->SetX($this->GetX() - 37);
		$this->Cell(37,6,'REALISASI KEUANGAN',1,2,'C');
		$this->Cell(25,6,'JUMLAH',1,0,'C');
		$this->Cell(12,6,'%',1,0,'C');

		$this->SetY($this->GetY() - 6);
		$this->SetX($this->GetX() + 203);
		$this->Cell(12,12,'RENC.FISIK',1,0,'C');
		$this->Cell(12,12,'REAL.FISIK',1,0,'C');
		$this->Cell(12,12,'DEV.FISIK',1,0,'C');
		$this->Cell(12,12,'RANK.KEU.',1,0,'C');
		$this->Cell(12,12,'RANK.FISIK',1,0,'C');
		$this->Ln(12);
	}	

	function data_rank_balai_progres_fisik_keuangan(){
		require('koneksi.php');
		$gen_rank = "CALL pro_generate_rank";
		mysqli_query($connect, $gen_rank);

		$this->SetFont('Arial','',7);

		$sql = "SELECT * FROM rank_fisik_keu ORDER BY kode_balai ASC";
		$query = mysqli_query($connect, $sql);
		$num = 0;
		while ($row = mysqli_fetch_array($query)) {
			$num++;
			$this->SetX($this->GetX() + 12);
			$this->Cell(5,6,$num,1,0,'C');
			$this->Cell(50,6,$row['nama_balai'],1,0,'L');
			$this->Cell(12,6,$row['jumlah_paket'],1,0,'R');
			$this->Cell(25,6,$row['pagu_rpm'],1,0,'R');
			$this->Cell(25,6,$row['prognosis_rupiah'],1,0,'R');
			$this->Cell(12,6,$row['prognosis_persen'],1,0,'R');
			$this->Cell(25,6,$row['nilai_kontrak'],1,0,'R');
			$this->Cell(25,6,$row['realisasi_keuangan_rpm'],1,0,'R');
			$this->Cell(12,6,$row['realisasi_keuangan_persen'],1,0,'R');
			$this->Cell(12,6,$row['rencana_fisik'],1,0,'R');
			$this->Cell(12,6,$row['realisasi_fisik'],1,0,'R');
			$this->Cell(12,6,$row['deviasi_fisik'],1,0,'R');
			$this->Cell(12,6,$row['rank_keu'],1,0,'R');
			$this->Cell(12,6,$row['rank_fisik'],1,1,'R');
		}
	}

	function total_rank_balai_progres_fisik_keuangan(){
		require('koneksi.php');
		$this->SetFont('Arial','B',7);

		$sql = "SELECT * FROM v_total_rank_rekapitulasi_progres_fisik_dan_keuangan";
		$query = mysqli_query($connect, $sql);
		$row = mysqli_fetch_array($query);
		$this->SetX($this->GetX() + 12);
		$this->Cell(55,6,'TOTAL',1,0,'C');
		$this->Cell(12,6,$row['jmlpaket'],1,0,'R');
		$this->Cell(25,6,$row['pagurpm'],1,0,'R');
		$this->Cell(25,6,$row['prognosis_rupiah'],1,0,'R');
		$this->Cell(12,6,$row['prognosis_persen'],1,0,'R');
		$this->Cell(25,6,$row['nilaikontrak'],1,0,'R');
		$this->Cell(25,6,$row['realisasikeuanganrpm'],1,0,'R');
		$this->Cell(12,6,$row['realisasi_keuangan_persen'],1,0,'R');
		$this->Cell(12,6,$row['rencanafisik'],1,0,'R');
		$this->Cell(12,6,$row['realisasifisik'],1,0,'R');
		$this->Cell(12,6,$row['deviasifisik'],1,0,'R');
		$this->Cell(12,6,'',1,0,'R');
		$this->Cell(12,6,'',1,1,'R');
	}

	// KRITIS PERBALAI
	function head_kritis_perbalai(){
		$this->SetX($this->GetX() + 60);
		$this->SetFont('Arial','B',15);
		$this->Cell(0,7,'JUMLAH PAKET KRITIS PERBALAI', 0, 1,'L');
		$this->SetX($this->GetX() + 60);
		$this->SetFont('Arial','B',10);

		$mydate=getdate(date("U"));
		$dt = $mydate['mday'].' '.$mydate['month'].' '.$mydate['year'];
		$this->Cell(0,5,'Sumber: SIPP Terpadu, status: '.$dt, 0, 0,'L');
		$this->Ln(1);

		$this->SetFont('Arial','B',7);

		$this->Ln(10);
		$this->SetX($this->GetX() + 60);
		$this->Cell(10,12,'NO',1,0,'C');
		$this->Cell(80,12,'BALAI',1,0,'C');
		$this->Cell(20,12,'JUMLAH',1,0,'C');

		$this->Cell(37,30,'',0,0,'L'); // cell bantu
		$this->SetXY($this->GetX() - 37, $this->GetY());
		$this->Cell(40,6,'TOTAL PAKET KRITIS',1,2,'C');
		$this->Cell(20,6,'PERIODE 1',1,0,'C');
		$this->Cell(20,6,'PERIODE 2',1,0,'C');
		$this->Ln();
	}	

	function data_kritis_perbalai(){
		require('koneksi.php');
		$sql = "SELECT * FROM v_kritis_perbalai";
		$query = mysqli_query($connect, $sql);
		$num = 0;

		$this->SetFont('Arial','',7);
		while ($row = mysqli_fetch_array($query)) {
			$num++;
			$this->SetX($this->GetX() + 60);
			$this->Cell(10,6,$num,1,0,'C');
			$this->Cell(80,6,$row['nama_balai'],1,0,'L');
			$this->Cell(20,6,$row['jml_kritis'].'   ',1,0,'R');
			$this->Cell(20,6,$row['jml_periode_1'].'   ',1,0,'R');
			$this->Cell(20,6,$row['jml_periode_2'].'   ',1,1,'R');
		}
	}

	function total_kritis_perbalai(){
		require('koneksi.php');
		$this->SetFont('Arial','B',7);

		$sql = "SELECT * FROM v_total_kritis_perbalai";
		$query = mysqli_query($connect, $sql);
		$row = mysqli_fetch_array($query);
		$this->SetX($this->GetX() + 60);
		$this->Cell(90,6,'TOTAL',1,0,'C');
		$this->Cell(20,6,$row['jml_kritis'],1,0,'R');
		$this->Cell(20,6,$row['jml_periode_1'],1,0,'R');
		$this->Cell(20,6,$row['jml_periode_2'],1,0,'R');
	}

	// KRITIS PERIODE 1
	function head_kritis_periode_1(){
		$this->SetFont('Arial','B',15);
		$this->Cell(0,7,'PAKET KRITIS FISIK PERIODE 1', 0, 1,'L');
			// $this->SetX($this->GetX() + 60);
		$this->SetFont('Arial','B',10);

		$mydate=getdate(date("U"));
		$dt = $mydate['mday'].' '.$mydate['month'].' '.$mydate['year'];
		$this->Cell(0,5,'Sumber: SIPP Terpadu, status: '.$dt, 0, 0,'L');
		$this->Ln(5);

		$this->SetFont('Arial','B',5);

		$this->Ln(10);
		$this->Cell(5,12,'NO',1,0,'C');
		$this->Cell(55,12,'PAKET KEGIATAN',1,0,'C');
		$this->Cell(11,12,'STATUS',1,0,'C');
		$this->Cell(40,12,'NAMA REKANAN',1,0,'C');

		$this->SetX($this->GetX() - 25);
		$this->Cell(25,12,'',0,0,'L'); // cell bantu
		$this->Cell(20,6,'PAGU',1,2,'C');
		$this->Cell(20,6,'TOTAL',1,0,'C');


		$this->Cell(37,30,'',0,0,'L'); // cell bantu
		$this->SetY($this->GetY() - 6);
		$this->SetX($this->GetX() + 131);
		$this->Cell(31,6,'PROGNOSIS',1,2,'C');
		$this->Cell(20,6,'TOTAL',1,0,'C');
		$this->Cell(11,6,'%',1,0,'C');

		$this->SetY($this->GetY() - 6);
		$this->SetX($this->GetX() + 162);
		$this->Cell(11,12,'L.SEGMEN',1,0,'C');
		$this->Cell(20,12,'NILAI KONTRAK',1,0,'C');
		$this->Cell(20,12,'SISA LELANG',1,0,'C');

		$this->SetX($this->GetX() - 25);
		$this->Cell(25,12,'',0,0,'L'); // cell bantu
		$this->Cell(20,6,'REALISASI',1,2,'C');
		$this->Cell(20,6,'TOTAL',1,0,'C');

		$this->SetY($this->GetY() - 6);
		$this->SetX($this->GetX() + 233);
		$this->Cell(11,12,'REAL.KEU',1,0,'C');
		$this->Cell(11,12,'RENC.FISIK',1,0,'C');
		$this->Cell(11,12,'REAL.FISIK',1,0,'C');
		$this->Cell(11,12,'DEV.FISIK',1,0,'C');
		$this->Ln(12);
	}	

	function tampilPaket($w, $h, $x, $t, $indent){
		$height = $h/3;
		$first = $height +2;
		$second = $height+$height+$height+3;
		$len = strlen($t);
		if($len>38){
			$txt = str_split($t,38);
			$this->SetX($x);
			$this->Cell($w,$first,$txt[0],'','',$indent);
			$this->SetX($x);
			$this->Cell($w,$second,$txt[1],'','',$indent);
			$this->SetX($x);
			$this->Cell($w,$h,'','LTRB',0,'L',0);
		}else{
			$this->SetX($x);
			$this->Cell($w,$h,$t,'LTRB',0,$indent,0);
		}
	}

	function tampil($w, $h, $x, $t, $indent){
		$height = $h/3;
		$first = $height +2;
		$second = $height+$height+$height+3;
		$len = strlen($t);
		$txtLength = $w - 10;
		if($len>30){
			$txt = str_split($t,30);
			$this->SetX($x);
			$this->Cell($w,$first,$txt[0],'','',$indent);
			$this->SetX($x);
			$this->Cell($w,$second,$txt[1],'','',$indent);
			$this->SetX($x);
			$this->Cell($w,$h,'','LTRB',0,'L',0);
		}else{
			$this->SetX($x);
			$this->Cell($w,$h,$t,'LTRB',0,$indent,0);
		}
	}

	function data_kritis_periode_1($kode_balai, $nama_balai){
		require('koneksi.php');
		$this->SetFont('Arial','B',7);
		$this->Cell(277,7,$nama_balai,1,0,'L');
		$this->Ln();

		$sqlbalai = "SELECT kode_satker, nama_satker FROM satker WHERE kode_balai='".$kode_balai."'";
		$querybalai = mysqli_query($connect, $sqlbalai);

		while($rowbalai = mysqli_fetch_array($querybalai)){

			$sql = "SELECT * FROM v_kritis_periode_1 WHERE kode_satker='".$rowbalai['kode_satker']."'";
			$query = mysqli_query($connect, $sql);
			$num = 0;

			if(mysqli_num_rows($query) > 0){

				$this->SetFont('Arial','B',7);
				$this->Cell(277,7,strtoupper($rowbalai['nama_satker']),1,0,'L');
				$this->Ln();

				$this->SetFont('Arial','',6);

				while ($row = mysqli_fetch_array($query)) {
					$num++;
					$x = $this->GetX();
					$this->tampil(5,7,$x,$num,'C');
					$x = $this->GetX();
					$this->tampilPaket(55,7,$x,strtoupper($row['nama_paket']),'L');
					$x = $this->GetX();
					$this->tampil(11,7,$x,$row['status_kontrak'],'C');
					$x = $this->GetX();
					$this->tampil(40,7,$x,strtoupper($row['nama_rekanan']),'L');
					$x = $this->GetX();
					$this->tampil(20,7,$x,$row['pagu_rpm'],'R');
					$x = $this->GetX();
					$this->tampil(20,7,$x,$row['prognosis_rupiah'],'R');
					$x = $this->GetX();
					$this->tampil(11,7,$x,$row['prognosis_persen'],'R');
					$x = $this->GetX();
					$this->tampil(11,7,$x,$row['longsegmen'],'R');
					$x = $this->GetX();
					$this->tampil(20,7,$x,$row['nilai_kontrak_rpm'],'R');
					$x = $this->GetX();
					$this->tampil(20,7,$x,$row['sisa_lelang'],'R');
					$x = $this->GetX();
					$this->tampil(20,7,$x,$row['rencana_keuangan_rpm'],'R');
					$x = $this->GetX();
					$this->tampil(11,7,$x,$row['realisasi_keuangan_persen'],'R');
					$x = $this->GetX();
					$this->tampil(11,7,$x,$row['rencana_fisik'],'R');
					$x = $this->GetX();
					$this->tampil(11,7,$x,$row['realisasi_fisik'],'R');
					$x = $this->GetX();
					$this->tampil(11,7,$x,$row['deviasi_fisik'],'R');
					$this->Ln();
				}

			}

		}
	}

	// KRITIS PERIODE 2
	function head_kritis_periode_2(){
		$this->SetFont('Arial','B',15);
		$this->Cell(0,7,'PAKET KRITIS FISIK PERIODE 2', 0, 1,'L');
			// $this->SetX($this->GetX() + 60);
		$this->SetFont('Arial','B',10);

		$mydate=getdate(date("U"));
		$dt = $mydate['mday'].' '.$mydate['month'].' '.$mydate['year'];
		$this->Cell(0,5,'Sumber: SIPP Terpadu, status: '.$dt, 0, 0,'L');
		$this->Ln(5);

		$this->SetFont('Arial','B',5);

		$this->Ln(10);
		$this->Cell(5,12,'NO',1,0,'C');
		$this->Cell(55,12,'PAKET KEGIATAN',1,0,'C');
		$this->Cell(11,12,'STATUS',1,0,'C');
		$this->Cell(40,12,'NAMA REKANAN',1,0,'C');

		$this->SetX($this->GetX() - 25);
		$this->Cell(25,12,'',0,0,'L'); // cell bantu
		$this->Cell(20,6,'PAGU',1,2,'C');
		$this->Cell(20,6,'TOTAL',1,0,'C');

		$this->Cell(37,30,'',0,0,'L'); // cell bantu
		$this->SetY($this->GetY() - 6);
		$this->SetX($this->GetX() + 131);
		$this->Cell(31,6,'PROGNOSIS',1,2,'C');
		$this->Cell(20,6,'TOTAL',1,0,'C');
		$this->Cell(11,6,'%',1,0,'C');

		$this->SetY($this->GetY() - 6);
		$this->SetX($this->GetX() + 162);
		$this->Cell(11,12,'L.SEGMEN',1,0,'C');
		$this->Cell(20,12,'NILAI KONTRAK',1,0,'C');
		$this->Cell(20,12,'SISA LELANG',1,0,'C');

		$this->SetX($this->GetX() - 25);
		$this->Cell(25,12,'',0,0,'L'); // cell bantu
		$this->Cell(20,6,'REALISASI',1,2,'C');
		$this->Cell(20,6,'TOTAL',1,0,'C');

		$this->SetY($this->GetY() - 6);
		$this->SetX($this->GetX() + 233);
		$this->Cell(11,12,'REAL.KEU',1,0,'C');
		$this->Cell(11,12,'RENC.FISIK',1,0,'C');
		$this->Cell(11,12,'REAL.FISIK',1,0,'C');
		$this->Cell(11,12,'DEV.FISIK',1,0,'C');
		$this->Ln(12);
	}	

	function data_kritis_periode_2($kode_balai, $nama_balai){
		require('koneksi.php');
		$this->SetFont('Arial','B',7);
		$this->Cell(277,7,$nama_balai,1,0,'L');
		$this->Ln();

		$sqlbalai = "SELECT kode_satker, nama_satker FROM satker WHERE kode_balai='".$kode_balai."'";
		$querybalai = mysqli_query($connect, $sqlbalai);

		while($rowbalai = mysqli_fetch_array($querybalai)){

			$sql = "SELECT * FROM v_kritis_periode_2 WHERE kode_satker='".$rowbalai['kode_satker']."'";
			$query = mysqli_query($connect, $sql);
			$num = 0;

			if(mysqli_num_rows($query) > 0){

				$this->SetFont('Arial','B',7);
				$this->Cell(277,7,strtoupper($rowbalai['nama_satker']),1,0,'L');
				$this->Ln();

				$this->SetFont('Arial','',6);

				while ($row = mysqli_fetch_array($query)) {
					$num++;
					$x = $this->GetX();
					$this->tampil(5,7,$x,$num,'C');
					$x = $this->GetX();
					$this->tampilPaket(55,7,$x,strtoupper($row['nama_paket']),'L');
					$x = $this->GetX();
					$this->tampil(11,7,$x,$row['status_kontrak'],'C');
					$x = $this->GetX();
					$this->tampil(40,7,$x,strtoupper($row['nama_rekanan']),'L');
					$x = $this->GetX();
					$this->tampil(20,7,$x,$row['pagu_rpm'],'R');
					$x = $this->GetX();
					$this->tampil(20,7,$x,$row['prognosis_rupiah'],'R');
					$x = $this->GetX();
					$this->tampil(11,7,$x,$row['prognosis_persen'],'R');
					$x = $this->GetX();
					$this->tampil(11,7,$x,$row['longsegmen'],'R');
					$x = $this->GetX();
					$this->tampil(20,7,$x,$row['nilai_kontrak_rpm'],'R');
					$x = $this->GetX();
					$this->tampil(20,7,$x,$row['sisa_lelang'],'R');
					$x = $this->GetX();
					$this->tampil(20,7,$x,$row['rencana_keuangan_rpm'],'R');
					$x = $this->GetX();
					$this->tampil(11,7,$x,$row['realisasi_keuangan_persen'],'R');
					$x = $this->GetX();
					$this->tampil(11,7,$x,$row['rencana_fisik'],'R');
					$x = $this->GetX();
					$this->tampil(11,7,$x,$row['realisasi_fisik'],'R');
					$x = $this->GetX();
					$this->tampil(11,7,$x,$row['deviasi_fisik'],'R');
					$this->Ln();
				}

			}

		}
	}

	// PROGRES LELANG
	function head_progres_lelang(){
		$this->SetFont('Arial','B',15);
		$this->SetX($this->GetX() + 20);
		$this->Cell(20,7,'PROGRES PELELANGAN PER BALAI', 0, 1,'L');

		$mydate=getdate(date("U"));
		$dt = $mydate['mday'].' '.$mydate['month'].' '.$mydate['year'];
		$this->SetFont('Arial','B',10);
		$this->SetX($this->GetX() + 20);
		$this->Cell(20,5,'Sumber: SIPP Terpadu, status: '.$dt, 0, 0,'L');
		$this->Ln(1);

		$this->SetFont('Arial','B',5);

		$this->Ln(10);
		$this->SetX($this->GetX() + 20);
		$this->Cell(10,12,'NO',1,0,'C');
		$this->Cell(50,12,'BALAI',1,0,'C');

		$this->Cell(37,30,'',0,0,'L'); // cell bantu
		$this->SetX($this->GetX() - 37);
		$this->Cell(40,6,'TOTAL',1,2,'C');
		$this->Cell(15,6,'JUMLAH PAKET',1,0,'C');
		$this->Cell(25,6,'PAGU',1,0,'C');

		$this->SetY($this->GetY() - 6);
		$this->Cell(25,12,'',0,0,'L'); // cell bantu
		$this->SetX($this->GetX() + 95);
		$this->Cell(40,6,'TERKONTRAK',1,2,'C');
		$this->Cell(15,6,'JUMLAH PAKET',1,0,'C');
		$this->Cell(25,6,'PAGU',1,0,'C');

		$this->SetY($this->GetY() - 6);
		$this->Cell(25,12,'',0,0,'L'); // cell bantu
		$this->SetX($this->GetX() + 135);
		$this->Cell(40,6,'PROSES LELANG',1,2,'C');
		$this->Cell(15,6,'JUMLAH PAKET',1,0,'C');
		$this->Cell(25,6,'PAGU',1,0,'C');

		$this->SetY($this->GetY() - 6);
		$this->Cell(25,12,'',0,0,'L'); // cell bantu
		$this->SetX($this->GetX() + 175);
		$this->Cell(40,6,'BELUM LELANG',1,2,'C');
		$this->Cell(15,6,'JUMLAH PAKET',1,0,'C');
		$this->Cell(25,6,'PAGU',1,1,'C');
	}	

	function data_progres_lelang(){
		require('koneksi.php');
		$this->SetFont('Arial','',7);

		$sql = "SELECT * FROM v_progres_lelang";
		$query = mysqli_query($connect, $sql);
		$num = 0;
		while ($row = mysqli_fetch_array($query)) {
			$num++;
			$this->SetX($this->GetX() + 20);
			$this->Cell(10,6,$num,1,0,'C');
			$this->Cell(50,6,$row['nama_balai'],1,0,'L');
			$this->Cell(15,6,$row['jumlah_paket'],1,0,'R');
			$this->Cell(25,6,$row['pagu_rpm'],1,0,'R');

			$this->Cell(15,6,$row['jml_kontrak'],1,0,'R');
			$this->Cell(25,6,$row['kontrak'],1,0,'R');

			$this->Cell(15,6,$row['jml_lelang'],1,0,'R');
			$this->Cell(25,6,$row['lelang'],1,0,'R');

			$this->Cell(15,6,$row['jml_siap'],1,0,'R');
			$this->Cell(25,6,$row['siap'],1,1,'R');
		}
	}

	function total_progres_lelang(){
		require('koneksi.php');
		$this->SetFont('Arial','B',7);

		$sql = "SELECT * FROM v_total_progres_lelang";
		$query = mysqli_query($connect, $sql);
		$row = mysqli_fetch_array($query);
		$this->SetX($this->GetX() + 20);
		$this->Cell(60,6,'GRAND TOTAL',1,0,'C');
		$this->Cell(15,6,$row['jumlah_paket'],1,0,'R');
		$this->Cell(25,6,$row['pagu_rpm'],1,0,'R');
		$this->Cell(15,6,$row['jml_kontrak'],1,0,'R');
		$this->Cell(25,6,$row['kontrak'],1,0,'R');
		$this->Cell(15,6,$row['jml_lelang'],1,0,'R');
		$this->Cell(25,6,$row['lelang'],1,0,'R');
		$this->Cell(15,6,$row['jml_siap'],1,0,'R');
		$this->Cell(25,6,$row['siap'],1,1,'R');
	}

	// PAKET BELUM LELANG
	function head_paket_belum_lelang(){
		$this->SetX($this->GetX() + 10);
		$this->SetFont('Arial','B',15);
		$this->Cell(0,7,'PAKET-PAKET BELUM LELANG', 0, 1,'L');
		$this->SetX($this->GetX() + 10);
		$this->SetFont('Arial','B',10);

		$mydate=getdate(date("U"));
		$dt = $mydate['mday'].' '.$mydate['month'].' '.$mydate['year'];
		$this->Cell(0,5,'Sumber: SIPP Terpadu, status: '.$dt, 0, 0,'L');
		$this->Ln(5);

		$this->SetFont('Arial','B',7.5);

		$this->Ln(10);
		$this->SetX($this->GetX() + 10);
		$this->Cell(10,12,'NO',1,0,'C');
		$this->Cell(50,12,'BALAI',1,0,'C');
		$this->Cell(50,12,'SATKER',1,0,'C');
		$this->Cell(110,12,'PAKET KEGIATAN',1,0,'C');

		$this->Cell(37,30,'',0,0,'L'); // cell bantu
		$this->SetX($this->GetX() - 37);
		$this->Cell(35,6,'PAGU',1,2,'C');
		$this->Cell(35,6,'TOTAL',1,1,'C');
	}	

	function tampilPaket_belum_lelang($w, $h, $x, $t, $indent){
		$height = $h/3;
		$first = $height +2;
		$second = $height+$height+$height+3;
		$len = strlen($t);
		if($len>88){
			$txt = str_split($t,88);
			$this->SetX($x);
			$this->Cell($w,$first,$txt[0],'','',$indent);
			$this->SetX($x);
			$this->Cell($w,$second,$txt[1],'','',$indent);
			$this->SetX($x);
			$this->Cell($w,$h,'','LTRB',0,'L',0);
		}else{
			$this->SetX($x);
			$this->Cell($w,$h,$t,'LTRB',0,$indent,0);
		}
	}

	function tampil_belum_lelang($w, $h, $x, $t, $indent){
		$height = $h/3;
		$first = $height +2;
		$second = $height+$height+$height+3;

		$len = strlen($t);
		if($len>36){
			$txt = str_split($t,36);
			$this->SetX($x);
			$this->Cell($w,$first,$txt[0],'','',$indent);
			$this->SetX($x);
			$this->Cell($w,$second,$txt[1],'','',$indent);
			$this->SetX($x);
			$this->Cell($w,$h,'','LTRB',0,'L',0);
		}else{
			$this->SetX($x);
			$this->Cell($w,$h,$t,'LTRB',0,$indent,0);

		}
	}

	function data_paket_belum_lelang(){
		require('koneksi.php');
		$this->SetFont('Arial','',6);

		$sql = "SELECT * FROM v_paket_belum_lelang";
		$query = mysqli_query($connect, $sql);
		$num = 0;

		while ($row = mysqli_fetch_array($query)) {
			$num++;
			$this->SetX($this->GetX() + 10);
			$x = $this->GetX();
			$this->tampilPaket_belum_lelang(10,7,$x,$num,'C');
			$x = $this->GetX();
			$this->tampil_belum_lelang(50,7,$x,strtoupper($row['nama_balai']),'L');
			$x = $this->GetX();
			$this->tampil_belum_lelang(50,7,$x,strtoupper($row['nama_satker']),'L');
			$x = $this->GetX();
			$this->tampilPaket_belum_lelang(110,7,$x,strtoupper($row['nama_paket']),'L');
			$x = $this->GetX();
			$this->tampilPaket_belum_lelang(35,7,$x,$row['pagu'],'R');
			$this->Ln();
		}
	}

	// PROGRES PAKET SBSN
	function head_progres_paket_sbsn(){
		$this->Image('bg.jpeg', 0, 0,297);

		$this->SetX($this->GetX() + 19);
		$this->SetFont('Arial','B',15);
		$this->Cell(0,7,'PROGRES PAKET SBSN PER BALAI', 0, 1,'L');
		$this->SetX($this->GetX() + 19);
		$this->SetFont('Arial','B',10);

		$mydate=getdate(date("U"));
		$dt = $mydate['mday'].' '.$mydate['month'].' '.$mydate['year'];
		$this->Cell(0,5,'Sumber: SIPP Terpadu, status: '.$dt, 0, 0,'L');
		$this->Ln(1);

		$this->SetFont('Arial','B',5);

		$this->Ln(10);
		$this->SetX($this->GetX() + 20);
		$this->Cell(10,12,'NO',1,0,'C');
		$this->Cell(50,12,'BALAI',1,0,'C');

		$this->Cell(37,30,'',0,0,'L'); // cell bantu
		$this->SetX($this->GetX() - 37);
		$this->Cell(40,6,'TOTAL',1,2,'C');
		$this->Cell(15,6,'JUMLAH PAKET',1,0,'C');
		$this->Cell(25,6,'PAGU',1,0,'C');


		$this->SetY($this->GetY() - 6);
		$this->Cell(25,12,'',0,0,'L'); // cell bantu
		$this->SetX($this->GetX() + 95);
		$this->Cell(40,6,'TERKONTRAK',1,2,'C');
		$this->Cell(15,6,'JUMLAH PAKET',1,0,'C');
		$this->Cell(25,6,'PAGU',1,0,'C');

		$this->SetY($this->GetY() - 6);
		$this->Cell(25,12,'',0,0,'L'); // cell bantu
		$this->SetX($this->GetX() + 135);
		$this->Cell(40,6,'PROSES LELANG',1,2,'C');
		$this->Cell(15,6,'JUMLAH PAKET',1,0,'C');
		$this->Cell(25,6,'PAGU',1,0,'C');

		$this->SetY($this->GetY() - 6);
		$this->Cell(25,12,'',0,0,'L'); // cell bantu
		$this->SetX($this->GetX() + 175);
		$this->Cell(40,6,'BELUM LELANG',1,2,'C');
		$this->Cell(15,6,'JUMLAH PAKET',1,0,'C');
		$this->Cell(25,6,'PAGU',1,1,'C');
	}	

	function data_progres_paket_sbsn(){
		require('koneksi.php');
		$this->SetFont('Arial','',7);

		$sql = "SELECT * FROM v_progres_paket_sbsn";
		$query = mysqli_query($connect, $sql);
		$num = 0;
		while ($row = mysqli_fetch_array($query)) {
			$num++;
			$this->SetX($this->GetX() + 20);
			$this->Cell(10,6,$num,1,0,'C');
			$this->Cell(50,6,$row['nama_balai'],1,0,'L');
			$this->Cell(15,6,$row['jumlah_paket'],1,0,'R');
			$this->Cell(25,6,$row['pagu_rpm'],1,0,'R');

			$this->Cell(15,6,$row['jml_kontrak'],1,0,'R');
			$this->Cell(25,6,$row['kontrak'],1,0,'R');

			$this->Cell(15,6,$row['jml_lelang'],1,0,'R');
			$this->Cell(25,6,$row['lelang'],1,0,'R');

			$this->Cell(15,6,$row['jml_siap'],1,0,'R');
			$this->Cell(25,6,$row['siap'],1,1,'R');
		}
	}

	function total_progres_paket_sbsn(){
		require('koneksi.php');
		$this->SetFont('Arial','B',7);

		$sql = "SELECT * FROM v_total_progres_sbsn";
		$query = mysqli_query($connect, $sql);
		$row = mysqli_fetch_array($query);
		$this->SetX($this->GetX() + 20);
		$this->Cell(60,7,'GRAND TOTAL',1,0,'C');
		$this->Cell(15,7,$row['jumlah_paket'],1,0,'R');
		$this->Cell(25,7,$row['pagu_rpm'],1,0,'R');

		$this->Cell(15,7,$row['jml_kontrak'],1,0,'R');
		$this->Cell(25,7,$row['kontrak'],1,0,'R');

		$this->Cell(15,7,$row['jml_lelang'],1,0,'R');
		$this->Cell(25,7,$row['lelang'],1,0,'R');

		$this->Cell(15,7,$row['jml_siap'],1,0,'R');
		$this->Cell(25,7,$row['siap'],1,1,'R');
	}

	// DAFTAR PAKET SBSN
	function head_daftar_paket_sbsn(){
		$this->SetFont('Arial','B',15);
		$this->Cell(20,7,'DAFTAR PAKET-PAKET SBSN', 0, 1,'L');

		$mydate=getdate(date("U"));
		$dt = $mydate['mday'].' '.$mydate['month'].' '.$mydate['year'];
		$this->SetFont('Arial','B',10);
		$this->Cell(20,5,'Sumber: SIPP Terpadu, status: '.$dt, 0, 0,'L');
		$this->Ln(5);

		$this->SetFont('Arial','B',5);

		$this->Ln();
		$this->Cell(5,12,'NO',1,0,'C');
		$this->Cell(52,12,'SATKER',1,0,'C');
		$this->Cell(55,12,'PAKET KEGIATAN',1,0,'C');
		$this->Cell(15,12,'STATUS',1,0,'C');
		$this->Cell(15,12,'JENIS',1,0,'C');
		$this->Cell(25,12,'NAMA REKANAN',1,0,'C');

		$this->SetX($this->GetX() - 20);
		$this->Cell(20,12,'',0,0,'L'); // cell bantu
		$this->Cell(20,6,'PAGU',1,2,'C');
		$this->Cell(20,6,'TOTAL',1,0,'C');


		$this->Cell(37,30,'',0,0,'L'); // cell bantu
		$this->SetY($this->GetY() - 6);
		$this->SetX($this->GetX() + 187);
		$this->Cell(30,6,'PROGNOSIS',1,2,'C');
		$this->Cell(20,6,'TOTAL',1,0,'C');
		$this->Cell(10,6,'%',1,0,'C');

		$this->SetY($this->GetY() - 6);
		$this->SetX($this->GetX() + 217);
		$this->Cell(10,12,'L.SEGMEN',1,0,'C');

		$this->SetY($this->GetY());
		$this->SetX($this->GetX() + 227);
		$this->Cell(10,12,'RENC.FSK',1,0,'C');
		$this->Cell(10,12,'REAL.FSK',1,0,'C');
		$this->Cell(20,12,'REAL.TOTAL',1,0,'C');
		$this->Cell(10,12,'REAL.KEU',1,0,'C');
		$this->Ln();
	}	

	function tampilRekanan_daftar_paket_sbsn($w, $h, $x, $t, $indent){
		$height = $h/3;
		$first = $height +2;
		$second = $height+$height+$height+3;
		$len = strlen($t);
		if($len>17){
			$txt = str_split($t,17);
			$this->SetX($x);
			$this->Cell($w,$first,$txt[0],'','',$indent);
			$this->SetX($x);
			$this->Cell($w,$second,$txt[1],'','',$indent);
			$this->SetX($x);
			$this->Cell($w,$h,'','LTRB',0,'L',0);
		}else{
			$this->SetX($x);
			$this->Cell($w,$h,$t,'LTRB',0,$indent,0);
		}
	}

	function tampilPaket_daftar_paket_sbsn($w, $h, $x, $t, $indent){
		$height = $h/3;
		$first = $height +2;
		$second = $height+$height+$height+3;

		$len = strlen($t);
		if($len>38){
			$txt = str_split($t,38);
			$this->SetX($x);
			$this->Cell($w,$first,$txt[0],'','',$indent);
			$this->SetX($x);
			$this->Cell($w,$second,$txt[1],'','',$indent);
			$this->SetX($x);
			$this->Cell($w,$h,'','LTRB',0,'L',0);
		}else{
			$this->SetX($x);
			$this->Cell($w,$h,$t,'LTRB',0,$indent,0);
		}
	}

	function tampil_daftar_paket_sbsn($w, $h, $x, $t, $indent){
		$height = $h/3;
		$first = $height +2;
		$second = $height+$height+$height+3;
		$len = strlen($t);
		$txtLength = $w - 10;
		if($len>30){
			$txt = str_split($t,30);
			$this->SetX($x);
			$this->Cell($w,$first,$txt[0],'','',$indent);
			$this->SetX($x);
			$this->Cell($w,$second,$txt[1],'','',$indent);
			$this->SetX($x);
			$this->Cell($w,$h,'','LTRB',0,'L',0);
		}else{
			$this->SetX($x);
			$this->Cell($w,$h,$t,'LTRB',0,$indent,0);
		}
	}

	function data_daftar_paket_sbsn($kode_balai, $nama_balai){
		require('koneksi.php');

		$sql = "SELECT * FROM v_paket_sbsn WHERE kode_balai='".$kode_balai."'";
		$query = mysqli_query($connect, $sql);
		$num = 0;

		if(mysqli_num_rows($query) > 0){
			
			$this->SetFont('Arial','B',7);
			$this->Cell(277,7,$nama_balai,1,0,'L');
			$this->Ln();

			$this->SetFont('Arial','',6);

			while ($row = mysqli_fetch_array($query)) {
				$num++;
				$x = $this->GetX();
				$this->tampil_daftar_paket_sbsn(5,7,$x,$num,'C');
				$x = $this->GetX();
				$this->tampilPaket_daftar_paket_sbsn(52,7,$x,strtoupper($row['nama_satker']),'L');
				$x = $this->GetX();
				$this->tampilPaket_daftar_paket_sbsn(55,7,$x,strtoupper($row['nama_paket']),'L');
				$x = $this->GetX();
				$this->tampil_daftar_paket_sbsn(15,7,$x,strtoupper($row['status_kontrak']),'C');
				$x = $this->GetX();
				$this->tampil_daftar_paket_sbsn(15,7,$x,$row['jenis_kontrak'],'C');
				$x = $this->GetX();
				$this->tampilRekanan_daftar_paket_sbsn(25,7,$x,strtoupper($row['nama_rekanan']),'L');
				$x = $this->GetX();
				$this->tampil_daftar_paket_sbsn(20,7,$x,$row['pagu_rpm'],'R');
				$x = $this->GetX();
				$this->tampil_daftar_paket_sbsn(20,7,$x,$row['prognosis_rupiah'],'R');
				$x = $this->GetX();
				$this->tampil_daftar_paket_sbsn(10,7,$x,$row['prognosis_persen'],'R');
				$x = $this->GetX();
				$this->tampil_daftar_paket_sbsn(10,7,$x,$row['longsegmen'],'R');
				$x = $this->GetX();
				$this->tampil_daftar_paket_sbsn(10,7,$x,$row['rencana_fisik'],'R');
				$x = $this->GetX();
				$this->tampil_daftar_paket_sbsn(10,7,$x,$row['realisasi_fisik'],'R');
				$x = $this->GetX();
				$this->tampil_daftar_paket_sbsn(20,7,$x,$row['realisasi_keuangan'],'R');
				$x = $this->GetX();
				$this->tampil_daftar_paket_sbsn(10,7,$x,$row['realisasi_keuangan_persen'],'R');
				$this->Ln();
			}

		}
	}

	// REKAPITULASI PELAKSANAAN ANGGARAN
	function head_rekapitulasi_pelaksanaan_anggaran(){
		$this->SetFont('Arial','B',15);
		$this->Cell(0,7,'REKAPITULASI PELAKSANAAN ANGGARAN', 0, 1,'L');
		$this->SetFont('Arial','B',10);

		$mydate=getdate(date("U"));
		$dt = $mydate['mday'].' '.$mydate['month'].' '.$mydate['year'];
		$this->Cell(0,5,'Sumber: SIPP Terpadu, status: '.$dt, 0, 0,'L');
		$this->Ln(1);

		$this->SetFont('Arial','B',5);

		$this->Ln(10);
		$this->Cell(5,12,'No',1,0,'C');
		$this->Cell(50,12,'BALAI',1,0,'C');
		$this->Cell(12,12,'JUMLAH',1,0,'C');

		$this->Cell(25,12,'',1,0,'L'); // cell bantu
		$this->SetX($this->GetX() - 25);
		$this->Cell(25,6,'PAGU',1,2,'C');
		$this->Cell(25,6,'JUMLAH',1,0,'C');

		$this->Cell(37,30,'',0,0,'L'); // cell bantu
		$this->SetY($this->GetY() - 6);
		$this->SetX($this->GetX() + 92);
		$this->Cell(37,6,'PROGNOSIS',1,2,'C');
		$this->Cell(25,6,'JUMLAH',1,0,'C');
		$this->Cell(12,6,'%',1,0,'C');

		$this->SetY($this->GetY() - 6);
		$this->SetX($this->GetX() + 129);
		$this->Cell(25,12,'NILAI KONTRAK',1,0,'C');


		$this->Cell(37,30,'',0,0,'L'); // cell bantu
		$this->SetX($this->GetX() - 37);
		$this->Cell(37,6,'REALISASI KEUANGAN',1,2,'C');
		$this->Cell(25,6,'JUMLAH',1,0,'C');
		$this->Cell(12,6,'%',1,0,'C');

		$this->SetY($this->GetY() - 6);
		$this->SetX($this->GetX() + 191);
		$this->Cell(12,12,'RENC.FISIK',1,0,'C');
		$this->Cell(12,12,'REAL.FISIK',1,0,'C');
		$this->Cell(12,12,'DEV.FISIK',1,0,'C');
		$this->Cell(25,12,'TIDAK TERSERAP.',1,0,'C');
		$this->Cell(25,12,'BELUM TERSERAP',1,0,'C');
		$this->Ln(12);
	}	

	function data_rekapitulasi_pelaksanaan_anggaran(){
		require('koneksi.php');
		$this->SetFont('Arial','',7);

		$sql = "SELECT * FROM v_rekapitulasi_pelaksanaan_anggaran";
		$query = mysqli_query($connect, $sql);
		$num = 0;
		while ($row = mysqli_fetch_array($query)) {
			$num++;
			$this->Cell(5,6,$num,1,0,'C');
			$this->Cell(50,6,$row['nama_balai'],1,0,'L');
			$this->Cell(12,6,$row['jumlah_paket'],1,0,'R');
			$this->Cell(25,6,$row['pagu_rpm'],1,0,'R');
			$this->Cell(25,6,$row['prognosis_rupiah'],1,0,'R');
			$this->Cell(12,6,$row['prognosis_persen'],1,0,'R');
			$this->Cell(25,6,$row['nilai_kontrak'],1,0,'R');
			$this->Cell(25,6,$row['realisasi_keuangan_rpm'],1,0,'R');
			$this->Cell(12,6,$row['realisasi_keuangan_persen'],1,0,'R');
			$this->Cell(12,6,$row['rencana_fisik'],1,0,'R');
			$this->Cell(12,6,$row['realisasi_fisik'],1,0,'R');
			$this->Cell(12,6,$row['deviasi_fisik'],1,0,'R');
			$this->Cell(25,6,$row['tidak_terserap'],1,0,'R');
			$this->Cell(25,6,$row['belum_terserap'],1,1,'R');
		}
	}

	function total_rekapitulasi_pelaksanaan_anggaran(){
		require('koneksi.php');
		$this->SetFont('Arial','B',7);

		$sql = "SELECT * FROM v_total_rekapitulasi_pelaksanaan_anggaran";
		$query = mysqli_query($connect, $sql);
		$row = mysqli_fetch_array($query);
		$this->Cell(55,6,'TOTAL',1,0,'C');
		$this->Cell(12,6,$row['val_jumlah_paket'],1,0,'R');
		$this->Cell(25,6,$row['val_pagu_rpm'],1,0,'R');
		$this->Cell(25,6,$row['val_prognosis_rupiah'],1,0,'R');
		$this->Cell(12,6,$row['prognosis_persen'],1,0,'R');
		$this->Cell(25,6,$row['val_nilai_kontrak'],1,0,'R');
		$this->Cell(25,6,$row['val_realisasi_keuangan_rpm'],1,0,'R');
		$this->Cell(12,6,$row['realisasi_keuangan_persen'],1,0,'R');
		$this->Cell(12,6,$row['rencana_fisik'],1,0,'R');
		$this->Cell(12,6,$row['realisasi_fisik'],1,0,'R');
		$this->Cell(12,6,$row['deviasi_fisik'],1,0,'R');
		$this->Cell(25,6,$row['val_tidak_terserap'],1,0,'R');
		$this->Cell(25,6,$row['val_belum_terserap'],1,1,'R');
	}

	// REKAPITULASI KONTRAK KESELURUHAN PERBALAI
	function head_rekapitulasi_kontrak_keseluruhan_perbalai($kode_balai){
		require('koneksi.php');
		$sql = "SELECT kode_balai, nama_balai FROM balai WHERE kode_balai='".$kode_balai."'";
		$query = mysqli_query($connect, $sql);
		$row = mysqli_fetch_array($query);

		$this->SetFont('Arial','B',9);
		$this->Cell(276,5,'REKAPITULASI KONTRAKTUAL KESELURUHAN PRESERVASI JALAN (REGULER DAN LONG SEGMENT)',0, 1,'C');
		$this->Cell(276,5,'TAHUN ANGGARAN 2019',0, 1,'C');
		$this->Cell(276,5,'DIREKTORAT PRESERVASI JALAN, DIREKTORAT JENDERAL BINA MARGA',0, 1,'C');
		$this->Cell(276,5,'"'.$row['nama_balai'].'"',0, 1,'C');

		$mydate=getdate(date("U"));
		$dt = $mydate['mday'].' '.$mydate['month'].' '.$mydate['year'];
		$this->SetFont('Arial','',7);
		$this->Cell(0,5,'Sumber: SIPP Terpadu, status: '.$dt, 0, 0,'L');
		$this->Ln(1);

		$this->SetFont('Arial','B',5);
		$this->Ln(10);
		$this->Cell(5,12,'NO',1,0,'C');
		$this->Cell(50,12,'NAMA PAKET',1,0,'C');
		$this->Cell(10,12,'STATUS',1,0,'C');
		$this->Cell(25,12,'NAMA REKANAN',1,0,'C');

		$this->SetX($this->GetX() - 20);
		$this->Cell(20,12,'',0,0,'L'); // cell bantu
		$this->Cell(18,6,'PAGU',1,2,'C');
		$this->Cell(18,6,'TOTAL',1,0,'C');


		$this->Cell(37,30,'',0,0,'L'); // cell bantu
		$this->SetY($this->GetY() - 6);
		$this->SetX($this->GetX() + 108);
		$this->Cell(28,6,'PROGNOSIS',1,2,'C');
		$this->Cell(18,6,'TOTAL',1,0,'C');
		$this->Cell(10,6,'%',1,0,'C');

		$this->SetY($this->GetY() - 6);
		$this->SetX($this->GetX() + 136);
		$this->Cell(10,12,'SBSN',1,0,'C');
		$this->Cell(10,12,'L.SEGMEN',1,0,'C');
		$this->Cell(15,12,'TGL.KONTRAK',1,0,'C');
		$this->Cell(18,12,'NILAI KONTRAK',1,0,'C');

		$this->SetX($this->GetX() - 25);
		$this->Cell(25,12,'',0,0,'L'); // cell bantu
		$this->Cell(18,6,'REALISASI',1,2,'C');
		$this->Cell(18,6,'TOTAL',1,0,'C');

		$this->SetY($this->GetY() - 6);
		$this->SetX($this->GetX() + 207);
		$this->Cell(10,12,'REAL.KEU',1,0,'C');
		$this->Cell(10,12,'RENC.FSK',1,0,'C');
		$this->Cell(10,12,'REAL.FSK',1,0,'C');
		$this->Cell(10,12,'DEV.FSK',1,0,'C');
		$this->Cell(11,12,'KET.KRITIS',1,0,'C');
		$this->Cell(18,12,'BLM.TERSERAP',1,0,'C');
		$this->Ln(12);
	}	

	function tampilKritis_rekapitulasi_kontrak_keseluruhan_perbalai($w, $h, $x, $t, $indent){
		$height = $h/3;
		$first = $height +2;
		$second = $height+$height+$height+3;
		$len = strlen($t);
		if($len>9){
			$txt = str_split($t,9);
			$this->SetX($x);
			$this->Cell($w,$first,$txt[0],'','',$indent);
			$this->SetX($x);
			$this->Cell($w,$second,$txt[1],'','',$indent);
			$this->SetX($x);
			$this->Cell($w,$h,'','LTRB',0,'L',0);
		}else{
			$this->SetX($x);
			$this->Cell($w,$h,$t,'LTRB',0,$indent,0);
		}
	}

	function tampilRekanan_rekapitulasi_kontrak_keseluruhan_perbalai($w, $h, $x, $t, $indent){
		$height = $h/3;
		$first = $height +2;
		$second = $height+$height+$height+3;
		$len = strlen($t);
		if($len>17){
			$txt = str_split($t,17);
			$this->SetX($x);
			$this->Cell($w,$first,$txt[0],'','',$indent);
			$this->SetX($x);
			$this->Cell($w,$second,$txt[1],'','',$indent);
			$this->SetX($x);
			$this->Cell($w,$h,'','LTRB',0,'L',0);
		}else{
			$this->SetX($x);
			$this->Cell($w,$h,$t,'LTRB',0,$indent,0);
		}
	}

	function tampilPaket_rekapitulasi_kontrak_keseluruhan_perbalai($w, $h, $x, $t, $indent){
		$height = $h/3;
		$first = $height +2;
		$second = $height+$height+$height+3;
		$len = strlen($t);
		if($len>36){
			$txt = str_split($t,36);
			$this->SetX($x);
			$this->Cell($w,$first,$txt[0],'','',$indent);
			$this->SetX($x);
			$this->Cell($w,$second,$txt[1],'','',$indent);
			$this->SetX($x);
			$this->Cell($w,$h,'','LTRB',0,'L',0);
		}else{
			$this->SetX($x);
			$this->Cell($w,$h,$t,'LTRB',0,$indent,0);
		}
	}

	function tampil_rekapitulasi_kontrak_keseluruhan_perbalai($w, $h, $x, $t, $indent){
		$height = $h/3;
		$first = $height +2;
		$second = $height+$height+$height+3;
		$len = strlen($t);
		$txtLength = $w - 10;
		if($len>30){
			$txt = str_split($t,30);
			$this->SetX($x);
			$this->Cell($w,$first,$txt[0],'','',$indent);
			$this->SetX($x);
			$this->Cell($w,$second,$txt[1],'','',$indent);
			$this->SetX($x);
			$this->Cell($w,$h,'','LTRB',0,'L',0);
		}else{
			$this->SetX($x);
			$this->Cell($w,$h,$t,'LTRB',0,$indent,0);
		}
	}

	function data_rekapitulasi_kontrak_keseluruhan_perbalai($kode_balai){
		require('koneksi.php');
		$sqlbalai = "SELECT kode_satker, nama_satker FROM satker WHERE kode_balai='".$kode_balai."'";
		$querybalai = mysqli_query($connect, $sqlbalai);

		while($rowbalai = mysqli_fetch_array($querybalai)){

			$sql = "SELECT * FROM v_rekapitulasi_kontrak WHERE kode_satker='".$rowbalai['kode_satker']."'";
			$query = mysqli_query($connect, $sql);
			$rowrekap = mysqli_fetch_array($query);
			$num = 0;

			if(mysqli_num_rows($query) > 0){

				$this->SetFont('Arial','B',7);
				$this->Cell(276,7,strtoupper($rowbalai['nama_satker']) .' / '. strtoupper($rowrekap['nama_ppk']).' (NIP.'. $rowrekap['nip_ppk'].') ' ,1,0,'L');
				$this->Ln();

				$this->SetFont('Arial','',6);

				while ($row = mysqli_fetch_array($query)) {
					$num++;
					$x = $this->GetX();
					$this->tampil_rekapitulasi_kontrak_keseluruhan_perbalai(5,7,$x,$num,'C');
					$x = $this->GetX();
					$this->tampilPaket_rekapitulasi_kontrak_keseluruhan_perbalai(50,7,$x,strtoupper($row['nama_paket']),'L');
					$x = $this->GetX();
					$this->tampil_rekapitulasi_kontrak_keseluruhan_perbalai(10,7,$x,$row['status_kontrak'],'C');
					$x = $this->GetX();
					$this->tampilRekanan_rekapitulasi_kontrak_keseluruhan_perbalai(25,7,$x,strtoupper($row['nama_rekanan']),'L');
					$x = $this->GetX();
					$this->tampil_rekapitulasi_kontrak_keseluruhan_perbalai(18,7,$x,$row['pagu'],'R');
					$x = $this->GetX();
					$this->tampil_rekapitulasi_kontrak_keseluruhan_perbalai(18,7,$x,$row['prognosis_rupiah'],'R');
					$x = $this->GetX();
					$this->tampil_rekapitulasi_kontrak_keseluruhan_perbalai(10,7,$x,$row['prognosis_persen'],'R');
					$x = $this->GetX();
					$this->tampil_rekapitulasi_kontrak_keseluruhan_perbalai(10,7,$x,$row['sbsn'],'C');
					$x = $this->GetX();
					$this->tampil_rekapitulasi_kontrak_keseluruhan_perbalai(10,7,$x,$row['longsegmen'],'R');
					$x = $this->GetX();
					$this->tampil_rekapitulasi_kontrak_keseluruhan_perbalai(15,7,$x,$row['tanggal_kontrak'],'C');
					$x = $this->GetX();
					$this->tampil_rekapitulasi_kontrak_keseluruhan_perbalai(18,7,$x,$row['nilai_kontrak'],'R');
					$x = $this->GetX();
					$this->tampil_rekapitulasi_kontrak_keseluruhan_perbalai(18,7,$x,$row['realisasi_keuangan'],'R');
					$x = $this->GetX();
					$this->tampil_rekapitulasi_kontrak_keseluruhan_perbalai(10,7,$x,$row['realisasi_keuangan_persen'],'R');
					$x = $this->GetX();
					$this->tampil_rekapitulasi_kontrak_keseluruhan_perbalai(10,7,$x,$row['rencana_fisik'],'R');
					$x = $this->GetX();
					$this->tampil_rekapitulasi_kontrak_keseluruhan_perbalai(10,7,$x,$row['realisasi_fisik'],'R');
					$x = $this->GetX();
					$this->tampil_rekapitulasi_kontrak_keseluruhan_perbalai(10,7,$x,$row['deviasi_fisik'],'R');
					$x = $this->GetX();
					$this->tampilKritis_rekapitulasi_kontrak_keseluruhan_perbalai(11,7,$x,$row['keterangan_kritis'],'C');
					$x = $this->GetX();
					$this->tampil_rekapitulasi_kontrak_keseluruhan_perbalai(18,7,$x,$row['belum_terserap'],'R');
					$this->Ln();
				}

			}

			$this->subtotal($rowbalai['kode_satker']);
			$this->Ln();

		}
		$this->total_rekapitulasi_kontrak_keseluruhan_perbalai();
		$this->Ln();
	}

	function subtotal($kode_satker){
		require('koneksi.php');
		$this->SetFont('Arial','B',6);
		$this->Cell(5,6,'',1,0,'C');
		$this->Cell(50,6,'SUB TOTAL',1,0,'C');
		$this->Cell(10,6,'',1,0,'C');
		$this->Cell(25,6,'',1,0,'C');

		$sql = "SELECT FORMAT(SUM(val_pagu),'C0') AS pagu FROM v_rekapitulasi_kontrak WHERE kode_satker='".$kode_satker."'";
		$query = mysqli_query($connect, $sql);
		$row = mysqli_fetch_array($query);
		$this->Cell(18,6,$row['pagu'],1,0,'R');

		$sql = "SELECT FORMAT(SUM(prognosis_rupiah),'C0') AS prognosis_rupiah FROM v_rekapitulasi_kontrak WHERE kode_satker='".$kode_satker."'";
		$query = mysqli_query($connect, $sql);
		$row = mysqli_fetch_array($query);
		$this->Cell(18,6,$row['prognosis_rupiah'],1,0,'R');

		$sql = "SELECT FORMAT(SUM(prognosis_persen),'C0') AS prognosis_persen FROM v_rekapitulasi_kontrak WHERE kode_satker='".$kode_satker."'";
		$query = mysqli_query($connect, $sql);
		$row = mysqli_fetch_array($query);
		$this->Cell(10,6,$row['prognosis_persen'],1,0,'R');

		$this->Cell(10,6,'',1,0,'C');
		$this->Cell(10,6,'',1,0,'C');
		$this->Cell(15,6,'',1,0,'C');

		$sql = "SELECT FORMAT(SUM(val_nilai_kontrak),'C0') AS nilai_kontrak FROM v_rekapitulasi_kontrak WHERE kode_satker='".$kode_satker."'";
		$query = mysqli_query($connect, $sql);
		$row = mysqli_fetch_array($query);
		$this->Cell(18,6,$row['nilai_kontrak'],1,0,'R');

		$sql = "SELECT FORMAT(SUM(realisasi_keuangan),'C0') AS realisasi_keuangan FROM v_rekapitulasi_kontrak WHERE kode_satker='".$kode_satker."'";
		$query = mysqli_query($connect, $sql);
		$row = mysqli_fetch_array($query);
		$this->Cell(18,6,$row['realisasi_keuangan'],1,0,'R');

		$sql = "SELECT FORMAT(SUM(realisasi_keuangan_persen),'C0') AS realisasi_keuangan_persen FROM v_rekapitulasi_kontrak WHERE kode_satker='".$kode_satker."'";
		$query = mysqli_query($connect, $sql);
		$row = mysqli_fetch_array($query);
		$this->Cell(10,6,$row['realisasi_keuangan_persen'],1,0,'R');


		$sql = "SELECT FORMAT(TRUNCATE (SUM(rencana_fisik) / COUNT(kode_satker),2),2) AS rencana_fisik FROM v_rekapitulasi_kontrak WHERE kode_satker='".$kode_satker."'";
		$query = mysqli_query($connect, $sql);
		$row = mysqli_fetch_array($query);
		$this->Cell(10,6,$row['rencana_fisik'],1,0,'R');

		$sql = "SELECT FORMAT(SUM(realisasi_fisik) / COUNT(kode_satker),2) AS realisasi_fisik FROM v_rekapitulasi_kontrak WHERE kode_satker='".$kode_satker."'";
		$query = mysqli_query($connect, $sql);
		$row = mysqli_fetch_array($query);
		$this->Cell(10,6,$row['realisasi_fisik'],1,0,'R');

		$sql = "SELECT FORMAT(SUM(deviasi_fisik) / COUNT(kode_satker),2) AS deviasi_fisik FROM v_rekapitulasi_kontrak WHERE kode_satker='".$kode_satker."'";
		$query = mysqli_query($connect, $sql);
		$row = mysqli_fetch_array($query);
		$this->Cell(10,6,$row['deviasi_fisik'],1,0,'R');

		$this->Cell(11,6,'',1,0,'R');

		$sql = "SELECT FORMAT(SUM(val_belum_terserap),'C0') AS belum_terserap FROM v_rekapitulasi_kontrak WHERE kode_satker='".$kode_satker."'";
		$query = mysqli_query($connect, $sql);
		$row = mysqli_fetch_array($query);
		$this->Cell(18,6,$row['belum_terserap'],1,0,'R');
	}

	function total_rekapitulasi_kontrak_keseluruhan_perbalai(){
		include('koneksi.php');
		$this->SetFont('Arial','B',5.5);
		$sql = "SELECT * FROM v_total_rekapitulasi_kontrak";
		$query = mysqli_query($connect, $sql);
		$row = mysqli_fetch_array($query);
		$this->Cell(5,6,'',1,0,'C');
		$this->Cell(50,6,'TOTAL',1,0,'C');
		$this->Cell(10,6,'',1,0,'C');
		$this->Cell(25,6,'',1,0,'C');
		$this->Cell(18,6,$row['pagu'],1,0,'R');
		$this->Cell(18,6,$row['prognosis_rupiah'],1,0,'R');
		$this->Cell(10,6,$row['prognosis_persen'],1,0,'R');
		$this->Cell(10,6,'',1,0,'C');
		$this->Cell(10,6,'',1,0,'C');
		$this->Cell(15,6,'',1,0,'C');
		$this->Cell(18,6,$row['val_nilai_kontrak'],1,0,'R');
		$this->Cell(18,6,$row['realisasi_keuangan'],1,0,'R');
		$this->Cell(10,6,$row['realisasi_keuangan_persen'],1,0,'R');
		$this->Cell(10,6,$row['rencana_fisik'],1,0,'R');
		$this->Cell(10,6,$row['realisasi_fisik'],1,0,'R');
		$this->Cell(10,6,$row['deviasi_fisik'],1,0,'R');
		$this->Cell(11,6,'',1,0,'R');
		$this->Cell(18,6,$row['val_belum_terserap'],1,0,'R');
	}

}

$sql = "SELECT kode_balai, nama_balai FROM balai";
$pdf = new PDF('L', 'mm', 'A4');	
$pdf->AliasNbPages();

$pdf->AddPage();
$pdf->head_rekapitulasi_progres_fisik_keuangan();
$pdf->data_rekapitulasi_progres_fisik_keuangan();
$pdf->total_rekapitulasi_progres_fisik_keuangan();

$pdf->AddPage();
$pdf->head_rank_balai_progres_fisik_keuangan();
$pdf->data_rank_balai_progres_fisik_keuangan();
$pdf->total_rank_balai_progres_fisik_keuangan();

$pdf->AddPage();
$pdf->head_kritis_perbalai();
$pdf->data_kritis_perbalai();
$pdf->total_kritis_perbalai();

$pdf->AddPage();
$pdf->head_kritis_periode_1();
$query = mysqli_query($connect, $sql);
while($row = mysqli_fetch_array($query)){
	$pdf->data_kritis_periode_1($row['kode_balai'], $row['nama_balai']);
	$pdf->Ln();
}

$pdf->AddPage();
$pdf->head_kritis_periode_2();
$query = mysqli_query($connect, $sql);
while($row = mysqli_fetch_array($query)){
	$pdf->data_kritis_periode_2($row['kode_balai'], $row['nama_balai']);
	$pdf->Ln();
}

$pdf->AddPage();
$pdf->head_progres_lelang();
$pdf->data_progres_lelang();
$pdf->total_progres_lelang();

$pdf->AddPage();
$pdf->head_paket_belum_lelang();
$pdf->data_paket_belum_lelang();

$pdf->AddPage();
$pdf->head_progres_paket_sbsn();
$pdf->data_progres_paket_sbsn();
$pdf->total_progres_paket_sbsn();

$pdf->AddPage();
$pdf->head_daftar_paket_sbsn();
$query = mysqli_query($connect, $sql);
while($row = mysqli_fetch_array($query)){
	$pdf->data_daftar_paket_sbsn($row['kode_balai'], $row['nama_balai']);
}

$pdf->AddPage();
$pdf->head_rekapitulasi_pelaksanaan_anggaran();
$pdf->data_rekapitulasi_pelaksanaan_anggaran();
$pdf->total_rekapitulasi_pelaksanaan_anggaran();

$query = mysqli_query($connect, $sql);
while($row = mysqli_fetch_array($query)){
	$pdf->AddPage();
	$pdf->head_rekapitulasi_kontrak_keseluruhan_perbalai($row['kode_balai']);
	$pdf->data_rekapitulasi_kontrak_keseluruhan_perbalai($row['kode_balai']);
} 

$gdate=getdate(date("U"));
$dt = $gdate['mday'].'-'.$gdate['month'].'-'.$gdate['year'];
$pdf->Output('D','Laporan-'.$dt.'.pdf'); 
?>