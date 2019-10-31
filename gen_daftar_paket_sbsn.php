<?php
require('fpdf.php');
require('koneksi.php');

class PDF extends FPDF {

	function Header(){

		$this->Image('bg.jpeg', 0, 0,297);

		if ($this->page == 1)
		{
			$this->SetFont('Arial','B',15);
			// $this->SetX($this->GetX() + 18);
			$this->Cell(20,7,'DAFTAR PAKET-PAKET SBSN', 0, 1,'L');

			$mydate=getdate(date("U"));
			$dt = $mydate['mday'].' '.$mydate['month'].' '.$mydate['year'];
			$this->SetFont('Arial','B',10);
			// $this->SetX($this->GetX() + 18);
			$this->Cell(20,5,'Sumber: SIPP Terpadu, status: '.$dt, 0, 0,'L');
			$this->Ln(5);
		}

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

	function Footer(){
    // Position at 1.5 cm from bottom
		$this->SetY(-15);
    // Arial italic 8
		$this->SetFont('Arial','I',6);
    // Page number
		// $this->Cell(0,10,'Hal. '.$this->PageNo().'/{nb}',0,0,'C');
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
				$this->tampil(5,7,$x,$num,'C');
				$x = $this->GetX();
				$this->tampilPaket(52,7,$x,strtoupper($row['nama_satker']),'L');
				$x = $this->GetX();
				$this->tampilPaket(55,7,$x,strtoupper($row['nama_paket']),'L');
				$x = $this->GetX();
				$this->tampil(15,7,$x,strtoupper($row['status_kontrak']),'C');
				$x = $this->GetX();
				$this->tampil(15,7,$x,$row['jenis_kontrak'],'C');
				$x = $this->GetX();
				$this->tampilRekanan(25,7,$x,strtoupper($row['nama_rekanan']),'L');
				$x = $this->GetX();
				$this->tampil(20,7,$x,$row['pagu_rpm'],'R');
				$x = $this->GetX();
				$this->tampil(20,7,$x,$row['prognosis_rupiah'],'R');
				$x = $this->GetX();
				$this->tampil(10,7,$x,$row['prognosis_persen'],'R');
				$x = $this->GetX();
				$this->tampil(10,7,$x,$row['longsegmen'],'R');
				$x = $this->GetX();
				$this->tampil(10,7,$x,$row['rencana_fisik'],'R');
				$x = $this->GetX();
				$this->tampil(10,7,$x,$row['realisasi_fisik'],'R');
				$x = $this->GetX();
				$this->tampil(20,7,$x,$row['realisasi_keuangan'],'R');
				$x = $this->GetX();
				$this->tampil(10,7,$x,$row['realisasi_keuangan_persen'],'R');
				$this->Ln();
			}

		}


	}

}

$pdf = new PDF('L', 'mm', 'A4');	
$pdf->AliasNbPages();
$pdf->AddPage();
// $pdf->Image('bg.jpeg', 0, 0,297);
// $pdf->top();

$sql = "SELECT kode_balai, nama_balai FROM balai";
$query = mysqli_query($connect, $sql);
while($row = mysqli_fetch_array($query)){
	$pdf->data($row['kode_balai'], $row['nama_balai']);
}

$gdate=getdate(date("U"));
$dt = $gdate['mday'].'-'.$gdate['month'].'-'.$gdate['year'];
$pdf->Output('D','paket-sbsn-'.$dt.'.pdf'); 
?>
