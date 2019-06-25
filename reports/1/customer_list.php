<?php
include('../fpdf.php');
$db = new PDO('mysql:host=localhost;dbname=aircon_services','root','');

class myPDF extends FPDF
{
// Page header
function Header()
{


    
    // Logo
    $size="20";  //(min 0, max 210; it's for making image big or small,
    $absx=(175-$size)/2;
    $this->Image('logo.png',$absx,5,$size);
   $this->Ln(45);



// HEADER TITLE
    $this->SetFont('Times','B',30);
    $this->CELL(0,0,'Customer List',0,0,'C');
    $this->Ln();
    $this->SetFont('Times','',12);
    $this->Cell(0,14,'Ang POGI ni Carlo Velarde ',0,0,'C');
    $this->Ln(5);

 
// FOR DATE
        $this->SetX(50);
        $this->SetFont('Arial', 'I', 10);
        date_default_timezone_set('UTC');
        $Date=date('m-d-Y');
        $this->Cell(0, 5, 'Date: '.$Date, 0, 'R', 0);
        $this->Ln(10);
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
}


function headerTable(){
  ;
 $this->SetFont('Times','B',12, True, 0);
 $this->Cell(60,10,'Customer Name',1,0,'C');
 $this->Cell(40,10,'Email',1,0,'C');
 $this->Cell(40,10,'Contact Number',1,0,'C');
 $this->Cell(50,10,'Address',1,0,'C');
 $this->Ln();

}
function viewTable($db){
    $this->SetFont('Times','',12);
    $stmt = $db->query('SELECT * from user_info');
    while($data = $stmt->fetch(PDO::FETCH_OBJ)){
    $this->Cell(60,10,$data->lastname.', '.$data->firstname,1,0,'L');
    $this->Cell(40,10,$data->email,1,0,'L');
     $this->Cell(40,10,$data->mobile,1,0,'L');
    $this->Cell(50,10,$data->address,1,0,'L');
       
    $this->Ln(10);

  }
// TOTAL RECORD COUNT
          $conn=mysqli_connect("localhost","root","","aircon_services");
          // Check connection
          if (mysqli_connect_errno())
          {
          echo "Failed to connect to MySQL: " . mysqli_connect_error();
          }
          $sql="SELECT count(*) from user_info";
          $result=mysqli_query($conn,$sql);
          $row=mysqli_fetch_array($result);
          // echo "$row[0]";
                 $this->SetFont('Times','B',12);
                 $this->Cell(195,12, 'Total: '.$row[0] ,0, 'L',0);
          mysqli_close($conn);
}
} 


// Instanciation of inherited class

$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P'); // LANDSCAPE PRINT
$pdf->headerTable();
$pdf->viewTable($db);
$pdf->SetFont('Times','',12);
//for($i=1;$i<=40;$i++)
    //$pdf->Cell(0,10,'Printing line number '.$i,0,1);
$pdf->Output();