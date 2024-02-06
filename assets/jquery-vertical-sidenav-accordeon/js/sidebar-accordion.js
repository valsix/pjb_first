$(document).ready(function() {
	$('.menu li:has(ul.menu)').click(function(e) {
        alert("klik parent");
		e.preventDefault();

		if($(this).hasClass('activado')) {
			$(this).removeClass('activado');
			$(this).children('ul.dropdown-menu').slideUp();
		} else {
			$('.menu li ul.dropdown-menu').slideUp();
			$('.menu li').removeClass('activado');
			$(this).addClass('activado');
			$(this).children('ul.dropdown-menu').slideDown();
		}

		$('.menu li ul.dropdown-menu li a').click(function() {
            alert("klik a");
			window.location.href = $(this).attr('href');
		})
	});
});