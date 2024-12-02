<?php
require_once('fpdf.php');

class PDF_Rotate extends FPDF
{
	var $angle=0;

	function Rotate($angle,$x=-1,$y=-1)
	{
		if($x==-1)
			$x=$this->x;
		if($y==-1)
			$y=$this->y;
		if($this->angle!=0)
			$this->_out('Q');
		$this->angle=$angle;
		if($angle!=0)
		{
			$angle*=M_PI/180;
			$c=cos($angle);
			$s=sin($angle);
			$cx=$x*$this->k;
			$cy=($this->h-$y)*$this->k;
			$this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
		}
	}

	function _endpage()
	{
		if($this->angle!=0)
		{
			$this->angle=0;
			$this->_out('Q');
		}
		parent::_endpage();
	}
}

class PDF_project_spec extends PDF_Rotate
{

	// Page header
	function Header()
	{
		$this->SetFont('Arial','B',15);
		//Put the watermark
		// $this->Image('./views/coact/assets/images/logo_round.jpg',55,160,100,100);
		$this->Image($_SERVER['DOCUMENT_ROOT'].'/views/coact/assets/images/logo.jpg',10,7,40);
//		$this->Image($_SERVER['DOCUMENT_ROOT'].'/views/coact/assets/images/logo.jpg',55,17,100);
		$this->Ln(2);
		// Logo
		// $this->Image('/assets/images/logo_icon_dark.png',10,6,30);
		// Arial bold 15

		$this->SetFont('Arial','B',20);
		// Move to the right
		$this->Cell(55);
		// Title
		$this->Cell(85,0,"Site Specifications",10,0,'C');
		// Line break
		$this->Ln(8);
		$this->SetTextColor(18,72,74);

		$this->SetFont('Arial','B',15);
		$this->Cell(190,10,$this->title,1,0,'C');

		$this->Ln(10);
	}

	function RotatedText($x, $y, $txt, $angle)
	{
		//Text rotated around its origin
		$this->Rotate($angle,$x,$y);
		$this->Text($x,$y,$txt);
		$this->Rotate(0);
	}

	// Page footer
	function Footer()
	{
		// Position at 1.5 cm from bottom
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		// Page number
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
//		// Logo
//		$this->Cell(-3,-10,'Operated By.',0,0,'C');
//		$this->Image($_SERVER['DOCUMENT_ROOT'].'/views/coact/assets/images/logo.jpg',190,280,15);
	}

	// Better table
	function ImprovedTable($header, $data)
	{
		// Column widths
		$w = array(95,95);
		// Header
		$this->SetFont('Arial','B');
		for($i=0;$i<count($header);$i++)
			$this->Cell($w[$i],7,$header[$i],1,0,'C');
		$this->Ln();
		// Data
		foreach($data as $row)
		{
			$this->Cell($w[0],6,$row[0],'LR');
			$this->Cell($w[1],6,$row[1],'LR');
			// $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
			// $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
			$this->Ln();
		}
		// Closing line
		$this->Cell(array_sum($w),0,'','T');

	}

	// Boxed info full width
	function boxinfo($data)
	{
		$your_content_width=190;
		$your_content_heigth=28;
		// Column widths
		$w = array(80,110);
		//The BorderBox
		$actual_position_y = $this->GetY()+3;
		$yourLeftosition =10;
		$this->SetFillColor(255, 255, 255);
		$this->SetDrawColor(0, 0, 0);
		$this->Cell($your_content_width, $your_content_heigth, "", 1, 1, 'C');

		$this->SetXY($yourLeftosition, $actual_position_y );

		foreach($data as $row)
		{
			$this->Cell($w[0],6,$row,'LR',0,'L',$fill);
			$actual_position_y+=5;

			// $fill = !$fill;
		}

	}

	function boxinfofooter($data)
	{
		$your_content_width=190;
		$your_content_heigth=18;
		// Column widths
		$w = array(95,95);
		//The BorderBox
		$actual_position_y = $this->GetY()+3;
		$yourLeftosition =10;
		$this->SetFillColor(255, 255, 255);
		$this->SetDrawColor(0, 0, 0);
		$this->Cell($your_content_width, $your_content_heigth, "", 1, 1, 'C');

		foreach($data as $row)
		{
			//Your actual content
			$this->SetXY($yourLeftosition, $actual_position_y  );
			$this->Cell($w[0],2,$row[0],0, 1, 'L');
			$this->SetXY($yourLeftosition+$w[0], $this->GetY() );
			$this->Cell($w[1],2,$row[1],0, 1, 'R');
			$actual_position_y+=5;
		}



	}

	// Boxed info half width
	function boxinfosplit($data1,$data2)
	{
		$your_content_width=95;
		$your_content_heigth=30;
		// Column widths
		$w = array(95,95);
		//The BorderBox
		$actual_position_y = $this->GetY()+3;
		$initial_position_y=$actual_position_y;
		$yourLeftosition =10;
		$this->SetFillColor(255, 255, 255);
		$this->SetDrawColor(0, 0, 0);
		$this->Cell($your_content_width, $your_content_heigth, "", 1, 1, 'C');

		// Data
		foreach($data1 as $row)
		{
			//Your actual content
			$this->SetXY($yourLeftosition, $actual_position_y  );
			$this->Cell($w[0],2,$row,0, 1, 'L');
			// $this->SetXY($yourLeftosition+$w[0], $this->GetY() );
			// $this->Cell($w[1],2,$row[1],0, 1, 'R');
			$actual_position_y+=5;
		}


		$actual_position_y = $initial_position_y;
		$yourLeftosition =105;
		$this->SetFillColor(255, 255, 255);
		$this->SetDrawColor(0, 0, 0);
		$this->SetXY($yourLeftosition, $actual_position_y-3  );
		$this->Cell($your_content_width, $your_content_heigth, "", 1, 1, 'C');

		// Data
		foreach($data2 as $row)
		{
			//Your actual content
			$this->SetXY($yourLeftosition, $actual_position_y  );
			$this->Cell($w[0],2,$row,0, 1, 'L');
			// $this->SetXY($yourLeftosition+$w[0], $this->GetY() );
			// $this->Cell($w[1],2,$row[1],0, 1, 'R');
			$actual_position_y+=5;
		}
	}

	// Colored table
	function FancyTable($header, $data)
	{
		// Colors, line width and bold font
		$this->SetFillColor(192, 192, 192);
		$this->SetTextColor(0);
		$this->SetDrawColor(0, 0, 0);
		$this->SetLineWidth(.3);
		$this->SetFont('Arial','B');
		// Header
		$w = array(65, 125 );
		for($i=0;$i<count($header);$i++)
			$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
		$this->Ln();
		// Color and font restoration
		$this->SetFillColor(220, 220, 220);
		$this->SetTextColor(0);
		$this->SetFont('');
		// Data
		$fill = false;
		$total=0;
		foreach($data as $key => $row)
		{
			// ADP 2018/10/25 Don't write the "Notes in this section"
			if ($key != 'Notes')
			{
				$str = str_replace('_',' ',$key);
				$this->Cell($w[0],6,$str,'LRB',0,'L',$fill);
				$this->Cell($w[1],6,$row,'LRB',0,'L',$fill);
				$this->Ln();
				// $fill = !$fill;
			}
		}
		// Closing line
		$this->Cell(array_sum($w),0,'','T');
		$this->Ln();

//		$this->Cell($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5],6,'Total Price','LR',0,'R',$fill);
//		$this->Cell($w[6],6,$total,'LR',0,'R',$fill);
//		$this->Ln();
//		$this->Cell(array_sum($w),0,'','T');
	}

}

?>
