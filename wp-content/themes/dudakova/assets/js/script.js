jQuery(document).ready(function($) {

	$('#slider_home').slick({
		vertical: true,
		verticalSwiping: true,
		arrows: false,
		autoplay: true,
		autoplaySpeed: 6000
	});

	$('#slider_about').slick({
		vertical: true,
		verticalSwiping: true,
		arrows: false,
		autoplay: true,
		autoplaySpeed: 6000
	});

	$('.brands').click(function() {
		$('.about').css('opacity', '0');
		$(this).children('.about').css('opacity', '1');
	});

	function initialize() {

		var myLatLng = {lat: 48.213733, lng: 16.366325};

		var mapProp = {
			center: new google.maps.LatLng(48.213733, 16.366325),
			zoom: 15,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};

		var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

		var marker = new google.maps.Marker({
			position: myLatLng,
			map: map,
			title: 'Dudakova & Co'
		});
		marker.setMap(map);

	}

	google.maps.event.addDomListener(window, 'load', initialize);
	

	$('.site-header div.menu-primary-menu-container ul li:not(:nth-child(6)):not(:nth-child(7))').append('<div class="lines"></div>');
	$('.site-header div.menu-primary-menu-container ul li.current-menu-item:not(:nth-child(6)):not(:nth-child(7))').append('<div class="lines active_line"></div>');

	$('.site-header div.menu-primary-menu-de-container ul li:not(:nth-child(6)):not(:nth-child(7))').append('<div class="lines"></div>');
	$('.site-header div.menu-primary-menu-de-container ul li.current-menu-item:not(:nth-child(6)):not(:nth-child(7))').append('<div class="lines active_line"></div>');

	$('.site-header ul li').mouseenter(function() {
		$(this).children('.lines:not(.active_line)').show("slide", { direction: "left" }, 200);
	});
	$('.site-header ul li').mouseleave(function() {
		$('.lines:not(.active_line)').hide("slide", { direction: "left" }, 200);
	});
	
	$('#lang_sel_list').append('<div id="langs_arrs"></div>');
	

	if(window.matchMedia('(min-width: 1024px').matches) {
		$('#langs_arrs').mouseenter(function (){
			$('#lang_sel_list ul li:nth-child(2)').css('display', 'inline-block');
			$('#langs_arrs').css('border-top', '10px solid #424243');
		});
		$('#langs_arrs').mouseleave(function (){
			$('#lang_sel_list ul li:nth-child(2)').css('display', 'none');
			$('#langs_arrs').css('border-top', '10px solid #E4B84B');
		});
		$('#lang_sel_list ul li:nth-child(1) a').mouseenter(function() {
			$('#lang_sel_list ul li:nth-child(2)').css('display', 'inline-block');
			$('#langs_arrs').css('border-top', '10px solid #424243');
		});
		$('#lang_sel_list ul li:nth-child(2)').mouseenter(function() {
			$('#lang_sel_list ul li:nth-child(2)').css('display', 'inline-block');
			$('#langs_arrs').css('border-top', '10px solid #424243');
		});
		$('#lang_sel_list ul li:nth-child(2)').mouseleave(function() {
			$('#lang_sel_list ul li:nth-child(2)').css('display', 'none');
			$('#langs_arrs').css('border-top', '10px solid #E4B84B');
		});
		$('#lang_sel_list ul li:nth-child(1)').mouseleave(function() {
			$('#lang_sel_list ul li:nth-child(2)').css('display', 'none');
			$('#langs_arrs').css('border-top', '10px solid #E4B84B');
		});
	}
	
	$('#header_list_btn_1').click(function() {
		$('.site-header ul li:nth-child(1)').slideDown();
		$('.site-header ul li:nth-child(2)').slideDown();
		$('.site-header ul li:nth-child(3)').slideDown();
		$('.site-header ul li:nth-child(4)').slideDown();
		$('.site-header ul li:nth-child(5)').slideDown();
		$('.site-header ul li:nth-child(6)').slideDown();
		$(this).hide();
		$('#header_list_btn_2').show();
	});
	$('#header_list_btn_2').click(function() {
		$('.site-header ul li:nth-child(1)').slideUp();
		$('.site-header ul li:nth-child(2)').slideUp();
		$('.site-header ul li:nth-child(3)').slideUp();
		$('.site-header ul li:nth-child(4)').slideUp();
		$('.site-header ul li:nth-child(5)').slideUp();
		$('.site-header ul li:nth-child(6)').slideUp();
		$(this).hide();
		$('#header_list_btn_1').show();
	});

	$('.menu-primary-menu-container a, .menu-primary-menu-de-container a, #lang_sel_list a').on('click touchend', function(e) {
		var el = $(this);
		var link = el.attr('href');
		window.location = link;
	});

});