<?php
// https://www.mindphp.com/developer/php-pdf/5038-create-a-pdf-with-php-lesson2.html
// เรียกไฟล์ TCPDF Library เข้ามาใช้งาน กำหนดที่อยู่ตามที่แตกไฟล์ไว้
require_once('TCPDF/tcpdf.php');

$filename = 'report';
$topic = 'รายงานข้อมูล';

//เชื่อมต่อฐานข้อมูล
require_once "connection.php";

$strSQL = "SELECT * FROM invoice i,customer c,payment p WHERE  i.cust_id = c.cust_id AND i.inv_id = p.inv_id ";
if ($_GET["room"] != 'all' && $_GET["room"] != '') {
  $topic .= 'ห้องพัก'.$_GET["room"];
  $filename = $filename . '_'.$_GET["room"];
  $room = $_GET["room"];
  $strSQL =  $strSQL . " AND i.room_id = '" . $_GET["room"] . "' ";
}
if ($_GET["cust"] != '') {
  $topic .= 'คุณ'.$_GET["cust"];
  $filename = $filename . '_'.$_GET["cust"];
  $cust = $_GET["cust"];
  $strSQL =  $strSQL . " AND i.cust_id = '" . $_GET["cust"] . "' ";
}
if ($_GET["month"] != 0) {
    $topic .= 'เดือน'.$_GET["month"];
    $filename = $filename . '_'.$_GET["month"];
  $month = $_GET["month"];
  $strSQL =  $strSQL . " AND i.inv_date LIKE '%-" . $month . "-%' ";
}
if ($_GET["year"] != 0) {
    $topic .= 'ปี'.$_GET["year"];
    $filename = $filename . '_'.$_GET["year"];
  $year = $_GET["year"];
  $strSQL =  $strSQL . " AND i.inv_date LIKE '%" . $year . "%' ";
}

$strSQL = $strSQL . " ORDER BY i.inv_date DESC ";

$objQuery = mysqli_query($conn, $strSQL);

// เรียกใช้ Class TCPDF กำหนดรายละเอียดของหน้ากระดาษ
// PDF_PAGE_ORIENTATION = กระดาษแนวตั้ง
// PDF_UNIT = หน่วยวัดขนาดของกระดาษเป็นมิลลิเมตร (mm)
// PDF_PAGE_FORMAT = รูปแบบของกระดาษเป็น A4
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8');

// กำหนดคุณสมบัติของไฟล์ PDF เช่น ผู้สร้างไฟล์ หัวข้อไฟล์ คำค้น 
$pdf->SetTitle('รายงาน');
$pdf->SetKeywords('Mindphp, TCPDF, PDF, example, guide');
$pdf->SetHeaderData('', 0, '', '', array (0, 0, 0), array (255, 255, 255));


// กำหนดให้ขึ้นหน้าใหม่แบบอัตโนมัติ เมื่อเนื้อหาเกินระยะที่กำหนด
// PDF_MARGIN_BOTTOM = 25mm นับจากขอบล่าง
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// กำหนดตัวอักษรสำหรับส่วนเนื้อหา ชื่อตัวอักษร รูปแบบและขนาดตัวอักษร
$pdf->SetFont('freeserif', '', 14);

// กำหนดให้สร้างหน้าเอกสาร
$pdf->AddPage();

$html = '<h3 style="text-align: center;">'.$topic.'</h3>';
$html .= '<h6 style="text-align: center;"> ออกรายงานวันที่ ' . date("Y/m/d") .'</h6>';
$table = '<table style="text-align: center;width: 100%;">';
$table .='<style>';
$table .='td {border-bottom: 1px solid #000;height:30px;vertical-align: middle;}';
$table .='th {border-bottom: 2px solid #000;height:25px;}';
$table .='</style>';
$table .= '<tr>';
$table .= '<th style="width:20%">วันที่</th><th style="width:10%">ห้อง</th><th style="width:10%">รหัส</th><th style="width:20%">ชื่อลูกค้า</th><th style="width:20%">รายการชำระ</th><th style="width:20%">สถานะการชำระ</th>';
$table .= '</tr>';
while($row = mysqli_fetch_array($objQuery)) { 
    $table .= '<tr>';
    $table .= '<td>'.$row['inv_date'].'</td>';
    $table .= '<td>'.$row['room_id'].'</td>';
    $table .= '<td>'. $row['cust_id'].'</td>';
    $table .= '<td>'. $row['cust_name'].' '.$row['cust_surname'].'</td>';
    $table .= '<td>'.$row['pay_amount'].'</td>';
    $table .= '<td>'.$row['pay_status'].'</td>';
    $table .= '</tr>';
 } 
$table .= '</table>';


// ข้อมูลที่จะแสดงในเนื้อหา
// $html = "Welcome to <b> ".$_POST['id']."</b>";

$namefile = $filename.'.pdf';
// กำหนดการแสดงข้อมูลแบบ HTML 
// สามารถกำหนดความกว้างความสูงของกรอบข้อความ 
// กำหนดตำแหน่งที่จะแสดงเป็นพิกัด x กับ y ซึ่ง x คือแนวนอนนับจากซ้าย ส่วน y คือแนวตั้งนับจากด้านล่าง
$pdf->writeHTMLCell(0, 0, '', 10, $html, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', 30, $table , 0);

// กำหนดการชื่อเอกสาร และรูปแบบการแสดงผล
$pdf->Output($namefile, 'I');