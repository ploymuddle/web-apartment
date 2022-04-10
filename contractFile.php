<?php
// https://www.mindphp.com/developer/php-pdf/5038-create-a-pdf-with-php-lesson2.html
// เรียกไฟล์ TCPDF Library เข้ามาใช้งาน กำหนดที่อยู่ตามที่แตกไฟล์ไว้
require_once('TCPDF/tcpdf.php');

$id = $_POST['id'];

//เชื่อมต่อฐานข้อมูล
require_once "connection.php";
$sql="SELECT * FROM contract co, customer cu ,  room r , room_type rt 
 WHERE  cu.cust_id = co.cust_id 
 AND r.room_id = co.room_id 
 AND r.type_room = rt.type_room 
 AND co.con_id = '".$id."'";

$query = mysqli_query($conn, $sql);
$result = mysqli_fetch_assoc($query);
$json = json_encode($result);
$data = json_decode($json);


// echo "<script>console.log('Debug Objects: " . $_POST['name'] . "' );</script>";

// เรียกใช้ Class TCPDF กำหนดรายละเอียดของหน้ากระดาษ
// PDF_PAGE_ORIENTATION = กระดาษแนวตั้ง
// PDF_UNIT = หน่วยวัดขนาดของกระดาษเป็นมิลลิเมตร (mm)
// PDF_PAGE_FORMAT = รูปแบบของกระดาษเป็น A4
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8');

// กำหนดคุณสมบัติของไฟล์ PDF เช่น ผู้สร้างไฟล์ หัวข้อไฟล์ คำค้น 
$pdf->SetCreator('Mindphp');
$pdf->SetAuthor('Mindphp Developer');
$pdf->SetTitle('Mindphp Example 02');
$pdf->SetSubject('Mindphp Example');
$pdf->SetKeywords('Mindphp, TCPDF, PDF, example, guide');

// กำหนดรายละเอียดของหัวกระดาษ สีข้อความและสีของเส้นใต้
// PDF_HEADER_LOGO = ไฟล์รูปภาพโลโก้
// PDF_HEADER_LOGO_WIDTH = ขนาดความกว้างของโลโก้
$pdf->SetHeaderData('', 0, 'AP Apartment', '222 kkk bbb 21000', array (0, 0, 0), array (0, 0, 0));

// กำหนดรายละเอียดของท้ายกระดาษ สีข้อความและสีของเส้น
$pdf->setFooterData(array (0, 0, 0), array (0, 64, 0));

// กำหนดตัวอักษร รูปแบบและขนาดของตัวอักษร (ตัวอักษรดูได้จากโฟลเดอร์ fonts)
// PDF_FONT_NAME_MAIN = ชื่อตัวอักษร helvetica
// PDF_FONT_SIZE_MAIN = ขนาดตัวอักษร 10
$pdf->setHeaderFont(Array (PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array (PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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
$pdf->SetFont('freeserif', '', 14);

// กำหนดให้สร้างหน้าเอกสาร
$pdf->AddPage();

$html = '<h3 style="text-align: center;">สัญญาเช่าหอพัก</h3>';
$html .= '<p style="font-size: 12px;text-align: right;">ฉบับที่ '.$data->con_id.'</p>';
$html .= '<p style="font-size: 12px;text-align: right;">วันที่ '.$data->con_checkin.'</p>';
$html .= '<p style="font-size: 12px;text-indent: 80;line-height:20px;">ได้รับเงินจาก คุณ '.$data->cust_name.' '.$data->cust_surname.' เพื่อชำระค่ามัดจำ จำนวน '.$data->con_deposit.' บาท ได้เข้าพัก ณ ห้อง '.$data->room_id.' เป็นห้องพักประเภท '.$data->type_room.' ค่าเช่าห้องพัก เดือนละ '.$data->type_rental.' บาท รายละเอียดข้อมูลลูกค้าดังนี้'.'</p>';

$table = '<table border="1" width="400" cellpadding="10" style="font-size: 12px;">';
$table .= '  <tr><th width="100">ชื่อ</th><td>'.$data->cust_name.'</td></tr>';
$table .= '  <tr><th width="100">นามสกุล</th><td>'.$data->cust_surname.'</td></tr>';
$table .= '  <tr><th width="100">เบอร์โทร</th><td>'.$data->cust_tel.'</td></tr>';
$table .= '  <tr><th width="100">Email</th><td>'.$data->cust_email.'</td></tr>';
$table .= '</table>';


// ข้อมูลที่จะแสดงในเนื้อหา
// $html = "Welcome to <b> ".$_POST['id']."</b>";

$namefile = $data->room_id.'_'.$data->con_checkin.'_'.$_POST['id'].'.pdf';
// กำหนดการแสดงข้อมูลแบบ HTML 
// สามารถกำหนดความกว้างความสูงของกรอบข้อความ 
// กำหนดตำแหน่งที่จะแสดงเป็นพิกัด x กับ y ซึ่ง x คือแนวนอนนับจากซ้าย ส่วน y คือแนวตั้งนับจากด้านล่าง
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(50, '', 50, 90, $table , 0);

// กำหนดการชื่อเอกสาร และรูปแบบการแสดงผล
$pdf->Output($namefile, 'I');