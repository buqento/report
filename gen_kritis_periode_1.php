<?php
require('fpdf.php');
require('koneksi.php');

class PDF extends FPDF {

	function Header(){
		$this->Image('bg.jpeg', 0, 0,297);

		if ($this->page == 1)
		{
			// $this->SetX($this->GetX() + 60);
			$this->SetFont('Arial','B',15);
			$this->Cell(0,7,'PAKET KRITIS FISIK PERIODE 1', 0, 1,'L');
			// $this->SetX($this->GetX() + 60);
			$this->SetFont('Arial','B',10);

			$mydate=getdate(date("U"));
			$dt = $mydate['mday'].' '.$mydate['month'].' '.$mydate['year'];
			$this->Cell(0,5,'Sumber: SIPP Terpadu, status: '.$dt, 0, 0,'L');
			$this->Ln(5);
		}

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

	function Footer(){
    // Position at 1.5 cm from bottom
		$this->SetY(-15);
    // Arial italic 8
		$this->SetFont('Arial','I',6);
    // Page number
		$this->Cell(0,10,'Hal. '.$this->PageNo().'/{nb}',0,0,'C');
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

	function data($kode_balai, $nama_balai){

		include('koneksi.php');

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

}

$pdf = new PDF('L', 'mm', 'A4');	
$pdf->AliasNbPages();
$pdf->AddPage();

$sql = "SELECT kode_balai, nama_balai FROM balai";
$query = mysqli_query($connect, $sql);
while($row = mysqli_fetch_array($query)){
	$pdf->data($row['kode_balai'], $row['nama_balai']);
	$pdf->Ln();
}

$gdate=getdate(date("U"));
$dt = $gdate['mday'].'-'.$gdate['month'].'-'.$gdate['year'];
$pdf->Output('D','kritis-p1-'.$dt.'.pdf'); 
?>
