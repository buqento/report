<?php
require('fpdf.php');
require('koneksi.php');

class PDF extends FPDF {

	function Header(){
		$this->Image('bg.jpeg', 0, 0,297);

		if ($this->page == 1)
		{
			require('koneksi.php');
			$sql = "SELECT kode_balai, nama_balai FROM balai WHERE kode_balai='".$_GET['kode_balai']."'";
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
		}

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

	function tampilKritis($w, $h, $x, $t, $indent){
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

	function tampilRekanan($w, $h, $x, $t, $indent){
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

	function tampilPaket($w, $h, $x, $t, $indent){
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

	function data($kode_balai){

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
					$this->tampil(5,7,$x,$num,'C');
					$x = $this->GetX();
					$this->tampilPaket(50,7,$x,strtoupper($row['nama_paket']),'L');
					$x = $this->GetX();
					$this->tampil(10,7,$x,$row['status_kontrak'],'C');
					$x = $this->GetX();
					$this->tampilRekanan(25,7,$x,strtoupper($row['nama_rekanan']),'L');
					$x = $this->GetX();
					$this->tampil(18,7,$x,$row['pagu'],'R');
					$x = $this->GetX();
					$this->tampil(18,7,$x,$row['prognosis_rupiah'],'R');
					$x = $this->GetX();
					$this->tampil(10,7,$x,$row['prognosis_persen'],'R');
					$x = $this->GetX();
					$this->tampil(10,7,$x,$row['sbsn'],'C');
					$x = $this->GetX();
					$this->tampil(10,7,$x,$row['longsegmen'],'R');
					$x = $this->GetX();
					$this->tampil(15,7,$x,$row['tanggal_kontrak'],'C');
					$x = $this->GetX();
					$this->tampil(18,7,$x,$row['nilai_kontrak'],'R');
					$x = $this->GetX();
					$this->tampil(18,7,$x,$row['realisasi_keuangan'],'R');
					$x = $this->GetX();
					$this->tampil(10,7,$x,$row['realisasi_keuangan_persen'],'R');
					$x = $this->GetX();
					$this->tampil(10,7,$x,$row['rencana_fisik'],'R');
					$x = $this->GetX();
					$this->tampil(10,7,$x,$row['realisasi_fisik'],'R');
					$x = $this->GetX();
					$this->tampil(10,7,$x,$row['deviasi_fisik'],'R');
					$x = $this->GetX();
					$this->tampilKritis(11,7,$x,$row['keterangan_kritis'],'C');
					$x = $this->GetX();
					$this->tampil(18,7,$x,$row['belum_terserap'],'R');
					$this->Ln();
				}

			}

			$this->subtotal($rowbalai['kode_satker']);
			$this->Ln();

		}
		$this->total();
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

	function total(){
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

$pdf = new PDF('L', 'mm', 'A4');	
$pdf->AliasNbPages();

$pdf->AddPage();
$pdf->data($_GET['kode_balai']);

$gdate=getdate(date("U"));
$dt = $gdate['mday'].'-'.$gdate['month'].'-'.$gdate['year'];
$pdf->Output('D','rekapitulasi-kontrak-balai-'.$_GET['kode_balai'].'-'.$dt.'.pdf'); 
?>
