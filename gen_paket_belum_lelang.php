<?php
require('fpdf.php');

class PDF extends FPDF {

	function Header(){
		$this->Image('bg.jpeg', 0, 0,297);

		if ($this->page == 1)
		{
			$this->SetX($this->GetX() + 10);
			$this->SetFont('Arial','B',15);
			$this->Cell(0,7,'PAKET-PAKET BELUM LELANG', 0, 1,'L');
			$this->SetX($this->GetX() + 10);
			$this->SetFont('Arial','B',10);

			$mydate=getdate(date("U"));
			$dt = $mydate['mday'].' '.$mydate['month'].' '.$mydate['year'];
			$this->Cell(0,5,'Sumber: SIPP Terpadu, status: '.$dt, 0, 0,'L');
			$this->Ln(5);
		}

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

	function tampilPaket($w, $h, $x, $t, $indent){
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

	function tampil($w, $h, $x, $t, $indent){
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

	function data(){

		include('koneksi.php');
		$this->SetFont('Arial','',6);

		$sql = "SELECT * FROM v_paket_belum_lelang";

		$query = mysqli_query($connect, $sql);
		$num = 0;

		while ($row = mysqli_fetch_array($query)) {
			$num++;
			$this->SetX($this->GetX() + 10);
			$x = $this->GetX();
			$this->tampilPaket(10,7,$x,$num,'C');
			$x = $this->GetX();
			$this->tampil(50,7,$x,strtoupper($row['nama_balai']),'L');
			$x = $this->GetX();
			$this->tampil(50,7,$x,strtoupper($row['nama_satker']),'L');
			$x = $this->GetX();
			$this->tampilPaket(110,7,$x,strtoupper($row['nama_paket']),'L');
			$x = $this->GetX();
			$this->tampilPaket(35,7,$x,$row['pagu'],'R');
			$this->Ln();
		}

	}

}

$pdf = new PDF('L', 'mm', 'A4');	
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->data();
$gdate=getdate(date("U"));
$dt = $gdate['mday'].'-'.$gdate['month'].'-'.$gdate['year'];
$pdf->Output('D','paket-belum-lelang-'.$dt.'.pdf'); 
?>