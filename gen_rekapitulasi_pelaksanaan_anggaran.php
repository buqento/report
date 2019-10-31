<?php
require('fpdf.php');

class PDF extends FPDF {

	function Header(){
		$this->Image('bg.jpeg', 0, 0,297);

		if ($this->page == 1)
		{
			// $this->SetX($this->GetX() + 60);
			$this->SetFont('Arial','B',15);
			$this->Cell(0,7,'REKAPITULASI PELAKSANAAN ANGGARAN', 0, 1,'L');
			// $this->SetX($this->GetX() + 60);
			$this->SetFont('Arial','B',10);

			$mydate=getdate(date("U"));
			$dt = $mydate['mday'].' '.$mydate['month'].' '.$mydate['year'];
			$this->Cell(0,5,'Sumber: SIPP Terpadu, status: '.$dt, 0, 0,'L');
			$this->Ln(1);
		}

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

	function data(){

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

	function total(){
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
}

$pdf = new PDF('L', 'mm', 'A4');	
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->data();
$pdf->total();

$gdate=getdate(date("U"));
$dt = $gdate['mday'].'-'.$gdate['month'].'-'.$gdate['year'];
$pdf->Output('D','rekapitulasi-pelaksanaan-anggaran-'.$dt.'.pdf'); 
?>