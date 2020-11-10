
// ----------------------------------------------------------------
// Theme Selection
// ----------------------------------------------------------------

$(function() {

	var image = "";
	var theme = "bg-primary bg-dark bg-light bg-white header-dark header-light";

	// avatar and active selection for navbar
	$('[data-avatar]').click(function () {
		$('[data-avatar]').removeClass("selected");
		$(this).addClass("selected");
		document.getElementById("user_avatar").value = this.dataset.avatar;
	});

	// bootstrap theme and active selection
	$('[data-theme]').click(function () {
		$('[data-theme]').removeClass("selected");
		$(this).addClass("selected");
		document.getElementById("user_theme").value = this.dataset.theme;
	});

	// bootstrap header class selection for navbar
	$('[data-header]').click(function () {
		$('.header').removeClass(theme);
		$('.header').addClass($(this).attr('data-header'));
		document.getElementById("user_theme_header").value = this.dataset.header;
	});

	// bootstrap class selection for footer
	$('[data-footer]').click(function () {
		$('.footer').removeClass(theme);
		$('.footer').addClass($(this).attr('data-footer'));
		document.getElementById("user_theme_footer").value = this.dataset.footer;
	});

	// bootstrap subheader class selection for navbar
	$('[data-subheader]').click(function () {
		$('.subheader').removeClass(theme);
		$('.subheader').addClass($(this).attr('data-subheader'));
		document.getElementById("user_theme_subheader").value = this.dataset.subheader;
	});

	// image selection for image gallery modal
	$('[data-media]').click(function () {
		$('[data-media]').removeClass("selected");
		$(this).addClass("selected");
		image = this.dataset.media;
	});

	// image selection for image gallery modal
	$('#image-btn').click(function () {
		if (document.getElementById("user_avatar")) {
			document.getElementById("user_avatar").value = image;
		}
		else {
			document.getElementById("featured-image").src = image;
			document.getElementById("post_image").value = image;
		}
	});

	// icon selection for favicon gallery modal
	$('[data-icon]').click(function () {
		$('[data-icon]').removeClass("selected");
		$(this).addClass("selected");
		image = this.dataset.icon;
	});

	// icon selection for favicon gallery modal
	$('#icon-btn').click(function () {
		document.getElementById("site-icon").value = image;
	});

});

function swapStyleSheet(sheet) {
	document.getElementById('page-theme').setAttribute('href', sheet);
}