// คำสั่งสำหลับ show เมนูในปุ่มสามเหลี่ยม >> [admin_menu]
$('.serv-btn').click(function () {
	$('nav ul .serv-show').toggleClass('show')
	$('nav ul .second').toggleClass('rotate')
})