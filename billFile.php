<?php
// https://www.mindphp.com/developer/php-pdf/5038-create-a-pdf-with-php-lesson2.html
// เรียกไฟล์ TCPDF Library เข้ามาใช้งาน กำหนดที่อยู่ตามที่แตกไฟล์ไว้
require_once('TCPDF/tcpdf.php');

$id = $_GET['id'];

//เชื่อมต่อฐานข้อมูล
require_once "connection/connection.php";
$sql="SELECT * FROM invoice i, customer c, payment p WHERE  i.cust_id = c.cust_id AND i.inv_id = p.inv_id AND pay_id = '$id' ";

$query = mysqli_query($conn, $sql);
$result = mysqli_fetch_assoc($query);
$json = json_encode($result);
$data = json_decode($json);
  
// echo "<script>console.log('Debug Objects: " . $_POST['name'] . "' );</script>";

// เรียกใช้ Class TCPDF กำหนดรายละเอียดของหน้ากระดาษ
// PDF_PAGE_ORIENTATION = กระดาษแนวตั้ง
// PDF_UNIT = หน่วยวัดขนาดของกระดาษเป็นมิลลิเมตร (mm)
// PDF_PAGE_FORMAT = รูปแบบของกระดาษเป็น A4
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, "A5", true, 'UTF-8');

// กำหนดคุณสมบัติของไฟล์ PDF เช่น ผู้สร้างไฟล์ หัวข้อไฟล์ คำค้น 
$pdf->SetCreator('AP Admin');
// $pdf->SetAuthor('Mindphp Developer');
$pdf->SetTitle('Bill_'.$data->room_id.'_'.$data->pay_date);
$pdf->SetSubject('Invoice');

// กำหนดรายละเอียดของหัวกระดาษ สีข้อความและสีของเส้นใต้
// PDF_HEADER_LOGO = ไฟล์รูปภาพโลโก้
// PDF_HEADER_LOGO_WIDTH = ขนาดความกว้างของโลโก้
$pdf->SetHeaderData('', 0, '', '', array (255, 255, 255), array (255, 255, 255));

// กำหนดรายละเอียดของท้ายกระดาษ สีข้อความและสีของเส้น
$pdf->setFooterData(array (255, 255, 255), array (255, 255, 255));

// กำหนดตัวอักษร รูปแบบและขนาดของตัวอักษร (ตัวอักษรดูได้จากโฟลเดอร์ fonts)
// PDF_FONT_NAME_MAIN = ชื่อตัวอักษร helvetica
// PDF_FONT_SIZE_MAIN = ขนาดตัวอักษร 10
// $pdf->setHeaderFont(Array (PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
// $pdf->setFooterFont(Array (PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// กำหนดระยะขอบกระดาษ
// PDF_MARGIN_LEFT = ขอบกระดาษด้านซ้าย 15mm
// PDF_MARGIN_TOP = ขอบกระดาษด้านบน 27mm
// PDF_MARGIN_RIGHT = ขอบกระดาษด้านขวา 15mm
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

// กำหนดระยะห่างจากขอบกระดาษด้านบนมาที่ส่วนหัวกระดาษ
// PDF_MARGIN_HEADER = 5mm
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// กำหนดระยะห่างจากขอบกระดาษด้านล่างมาที่ส่วนท้ายกระดาษ
// PDF_MARGIN_FOOTER = 10mm
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// กำหนดให้ขึ้นหน้าใหม่แบบอัตโนมัติ เมื่อเนื้อหาเกินระยะที่กำหนด
// PDF_MARGIN_BOTTOM = 25mm นับจากขอบล่าง
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// กำหนดตัวอักษรสำหรับส่วนเนื้อหา ชื่อตัวอักษร รูปแบบและขนาดตัวอักษร
$pdf->SetFont('freeserif', '', 12);

// กำหนดให้สร้างหน้าเอกสาร
$pdf->AddPage();


$html = '<h1 style="text-align: center;">ใบเสร็จรับเงิน</h1>';
$html .= '<table width="100%">';
$html .= '  <tr><td>หมายเลขห้องพัก: '.$data->room_id.'</td><td style="text-align: right;">วันที่: '.$data->pay_date.'</td></tr>';
$html .= '  <tr><td>ชื่อลูกค้า: '.$data->cust_name.' '.$data->cust_surname.'</td><td style="text-align: right;">หมายเลขใบเสร็จ: '.$data->pay_id.'</td></tr>';
$html .= '</table>';

$html .= '<br>';
$html .= '<hr size="5" noshade>';
$html .= '<p></p>';
$html .= '<p></p>';

$html .= '<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>';
$html .= '<table width="80%" >';
$html .= '  <tr><th style="text-align: left;">หมายเลขใบแจ้งหนี้: '.$data->inv_id.'</th>';
$html .= '  <th style="text-align: right;">ยอดรับชำระ: '.$data->pay_amount.'</th></tr>';
$html .= '</table>';

$html .= '<br>';

$html .= '<div ALIGN="CENTER">';
$html .= '<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>';
$html .= '<table border="1" cellpadding="5" width="80%" style="font-size: 10px;" >';
$html .= '  <tr style="background-color: #D6EEEE;border: 2px solid black;"><th>รายการ</th>';
$html .= '  <th>จำนวนเงิน</th></tr>';
$html .= '  <tr><td>ยอดเรียกชำระ</td>';
$html .= '  <td>'.$data->inv_total.'</td></tr>';
$html .= '  <tr><td>ยอดชำระ</td>';
$html .= '  <td>'.$data->pay_amount.'</td></tr>';
$html .= '  <tr><td>ยอดคงเหลือ</td>';
$html .= '  <td>0</td></tr>';
$html .= '</table>';
$html .= '</div>';


// ข้อมูลที่จะแสดงในเนื้อหา
// $html = "Welcome to <b> ".$_POST['id']."</b>";

$namefile = 'Bill_'.$data->room_id.'_'.$data->pay_date.'.pdf';
// กำหนดการแสดงข้อมูลแบบ HTML 
// สามารถกำหนดความกว้างความสูงของกรอบข้อความ 
// กำหนดตำแหน่งที่จะแสดงเป็นพิกัด x กับ y ซึ่ง x คือแนวนอนนับจากซ้าย ส่วน y คือแนวตั้งนับจากด้านล่าง
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
// $pdf->writeHTMLCell(0, '', 50, 30, $table , 0);

// กำหนดการชื่อเอกสาร และรูปแบบการแสดงผล
$pdf->Output($namefile, 'I');