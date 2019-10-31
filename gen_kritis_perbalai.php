<?php
require('fpdf.php');
require('koneksi.php');

class PDF extends FPDF {

	function Header(){
		$this->Image('bg.jpeg', 0, 0,297);

		if ($this->page == 1)
		{
			$this->SetX($this->GetX() + 60);
			$this->SetFont('Arial','B',15);
			$this->Cell(0,7,'JUMLAH PAKET KRITIS PERBALAI', 0, 1,'L');
			$this->SetX($this->GetX() + 60);
			$this->SetFont('Arial','B',10);

			$mydate=getdate(date("U"));
			$dt = $mydate['mday'].' '.$mydate['month'].' '.$mydate['year'];
			$this->Cell(0,5,'Sumber: SIPP Terpadu, status: '.$dt, 0, 0,'L');
			$this->Ln(1);
		}

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

	function data(){

		include('koneksi.php');

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

	function total(){
		include('koneksi.php');
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

}

$pdf = new PDF('L', 'mm', 'A4');	
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->data();
$pdf->total();

$gdate=getdate(date("U"));
$dt = $gdate['mday'].'-'.$gdate['month'].'-'.$gdate['year'];
$pdf->Output('D','kritis-balai-'.$dt.'.pdf'); 
?>