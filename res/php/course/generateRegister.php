<?php
    session_start();
    if (!isset($_SESSION['UserID'])){
        header("Location: ../login");
    }
    require('../../tfpdf/tfpdf.php');
    $register = new tFPDF();

    $names = $_POST['names'];

    $register->AddPage();
    $register->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
    $register->AddFont('DejaVu','B','DejaVuSans-Bold.ttf',true);
    $register->SetFont('DejaVu','B',24);
    $register->Cell(40,10,'Register for '. $_POST["courseName"]);
    $register->Ln();
    $register->SetFont('DejaVu','',16);
    // for($i = 0; $i < count($names); $i++) {
        foreach ($names as $name){
        @$register->Cell(40,10, "☐    " . $name);
        $register->Ln();
    }
    $register->Output('F', '../../../registers/AttendanceRegister'.date('dmy').'.pdf');
    echo(json_encode(array('statusCode' => 200, 'URL' => 'AttendanceRegister'.date('dmy').'.pdf')));
?>