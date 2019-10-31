<?php
require('fpdf.php');

class PDF extends FPDF {

	function Header(){
		
		$this->Image('bg.jpeg', 0, 0,297);

		if ($this->page == 1)
		{
			$this->SetFont('Arial','B',15);
			$this->SetX($this->GetX() + 20);
			$this->Cell(20,7,'PROGRES PELELANGAN PER BALAI', 0, 1,'L');

			$mydate=getdate(date("U"));
			$dt = $mydate['mday'].' '.$mydate['month'].' '.$mydate['year'];
			$this->SetFont('Arial','B',10);
			$this->SetX($this->GetX() + 20);
			$this->Cell(20,5,'Sumber: SIPP Terpadu, status: '.$dt, 0, 0,'L');
			$this->Ln(1);
		}

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

	function data(){

		include('koneksi.php');
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

	function total(){
		include('koneksi.php');
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
}

$pdf = new PDF('L', 'mm', 'A4');	
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->data();
$pdf->total();
$gdate=getdate(date("U"));
$dt = $gdate['mday'].'-'.$gdate['month'].'-'.$gdate['year'];
$pdf->Output('D','progres-pelelangan-perbalai-'.$dt.'.pdf'); 
?>