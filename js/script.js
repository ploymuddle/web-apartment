
const bar = document.querySelector('.bar');
bar.onclick = () => {
	const menu = document.querySelector('nav');
	menu.classList.toggle('show');
}


//  คำสั่งสำหลับแสดงสถานะ ในแถบเมนูที่ใช้งานอยู่
$('nav ul li').click(function () {
	$(this).addClass('active').siblings().removeClass('active')
})
