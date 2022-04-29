<?php
// https://www.mindphp.com/developer/php-pdf/5038-create-a-pdf-with-php-lesson2.html
// เรียกไฟล์ TCPDF Library เข้ามาใช้งาน กำหนดที่อยู่ตามที่แตกไฟล์ไว้
require_once('TCPDF/tcpdf.php');

$filename = 'report';
$topic = 'รายงานข้อมูล';

//เชื่อมต่อฐานข้อมูล
require_once "connection.php";

$strSQL = "SELECT * FROM invoice i,customer c,payment p WHERE  i.cust_id = c.cust_id AND i.inv_id = p.inv_id AND c.cust_status = 'live'  ";
if ($_GET["room"] != 'all' && $_GET["room"] != '') {
  $topic .= 'ห้องพัก '.$_GET["room"];
  $filename = $filename . '_'.$_GET["room"];
  $room = $_GET["room"];
  $strSQL =  $strSQL . " AND i.room_id = '" . $_GET["room"] . "' ";
}
if ($_GET["status"] != 'all' && $_GET["status"] != '') {
  $topic .= 'สถานะ'.$_GET["status"];
  $filename = $filename . '_'.$_GET["status"];
  $status = $_GET["status"];
  $strSQL =  $strSQL . " AND p.pay_status = '" . $_GET["status"] . "' ";
}
if ($_GET["cust"] != '') {
  $topic .= 'คุณ'.$_GET["cust"];
  $filename = $filename . '_'.$_GET["cust"];
  $cust = $_GET["cust"];
  $strSQL =  $strSQL . " AND i.cust_id = '" . $_GET["cust"] . "' ";
}
if ($_GET["month"] != 0) {
    $topic .= 'เดือน '.$_GET["month"];
    $filename = $filename . '_'.$_GET["month"];
  $month = $_GET["month"];
  $strSQL =  $strSQL . " AND i.inv_date LIKE '%-" . $month . "-%' ";
}
if ($_GET["year"] != 0) {
    $topic .= 'ปี '.$_GET["year"];
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

// $html = '<h3 style="text-align: center;">'.$topic.'</h3>';
// $html .= '<h5 style="text-align: center;"> ออกรายงานวันที่ ' . date("Y/m/d") .'</h5>';

$html = '<table width="100%">';
// $html .= '  <tr><td>รายงานการชำระเงิน</td><td style="text-align: right;">ออกรายงานวันที่: ' . date("Y/m/d") .'</td></tr>';
$html .= '  <tr><td>'.$topic.'</td><td style="text-align: right;">ออกรายงานวันที่: ' . date("Y/m/d") .'</td></tr>';
$html .= '</table>';

$table = '<table style="text-align: center;width: 100%;" cellpadding="5" >';
$table .='<style>';
// $table .='td {border-bottom: 1px solid #000;height:30px;vertical-align: middle;}';
$table .='td {height:30px;}';
$table .='th {border-bottom: 2px solid #000;height:25px;}';
$table .='</style>';
$table .= '<tr>';
$table .= '<th style="width:15%">วันที่</th>
<th style="width:10%">หมายเลขห้อง</th>
<th style="width:10%">รหัสสมาชิก</th>
<th style="width:20%">ชื่อลูกค้า</th>
<th style="width:5%"></th>
<th style="width:10%">ยอดเงิน</th>
<th style="width:10%">ยอดชำระ</th>
<th style="width:10%">ค้างชำระ</th>
<th style="width:10%">สถานะ</th>';
$table .= '</tr>';
while($row = mysqli_fetch_array($objQuery)) { 
    $table .= '<tr>';
    $table .= '<td>'.$row['inv_date'].'</td>';
    $table .= '<td>'.$row['room_id'].'</td>';
    $table .= '<td>'. $row['cust_id'].'</td>';
    $table .= '<td>'. $row['cust_name'].' '.$row['cust_surname'].'</td>';
    $table .= '<td></td>';
    $table .= '<td>'.$row['inv_total'].'</td>';
    $table .= '<td>'.$row['pay_amount'].'</td>';
    $table .= '<td>0</td>';
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