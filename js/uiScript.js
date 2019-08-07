//Empty modal from everything 
function emptyModal() {
	jQuery('#modalPizza').empty();
	jQuery('#modalBody').empty();
}

//some visual functions by jQuery
jQuery(document).ready(function () {
	claculateCartPrices();
	// Smooth scrolling using jQuery easing
	jQuery('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function () {
		if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
			var target = jQuery(this.hash);
			target = target.length ? target : jQuery('[name=' + this.hash.slice(1) + ']');
			if (target.length) {
				$('html, body').animate({
					scrollTop: (target.offset().top - 56)
				}, 1000, "easeInOutExpo");
				return false;
			}
		}
	});

	// Closes responsive menu when a scroll trigger link is clicked
	jQuery('.js-scroll-trigger').click(function () {
		$('.navbar-collapse').collapse('hide');
	});

	// Collapse Navbar
	var navbarCollapse = function () {
		try {
			if (jQuery("#mainNav").offset().top > 100) {
				jQuery("#mainNav").addClass("navbar-shrink");
				jQuery("#mainNav").addClass("shadow-sm");
			} else {
				jQuery("#mainNav").removeClass("navbar-shrink");
				jQuery("#mainNav").removeClass("shadow-sm");
			}
		} catch (error) {}
    };
    
	// Collapse now if page is not at top
	navbarCollapse();
	// Collapse the navbar when page is scrolled
	jQuery(window).scroll(navbarCollapse);
});

//this is to watch changes on pizza stack
jQuery(document).change(function () {
	checkIngredients();
	if (toCalc == "pizza") {
		calculatePizzaPrice();
	} else if (toCalc == "nonPizza") {
		calculateNonPizzaPrice();
	}
});

function checkIngredients() {
	if (jQuery('input[value="Cheese"]').prop("checked")) {
		jQuery('.Cheese').css('opacity', '1');
	} else {
		jQuery('.Cheese').css('opacity', '0');
	}
	if (jQuery('input[value="Tomato"]').prop("checked")) {
		jQuery('.Tomato').css('opacity', '1');
	} else {
		jQuery('.Tomato').css('opacity', '0');
	}
	if (jQuery('input[value="Pepper"]').prop("checked")) {
		jQuery('.Pepper').css('opacity', '1');
	} else {
		jQuery('.Pepper').css('opacity', '0');
	}
	if (jQuery('input[value="Onion"]').prop("checked")) {
		jQuery('.Onion').css('opacity', '1');
	} else {
		jQuery('.Onion').css('opacity', '0');
	}
	if (jQuery('input[value="Rocca"]').prop("checked")) {
		jQuery('.Rocca').css('opacity', '1');
	} else {
		jQuery('.Rocca').css('opacity', '0');
	}
	if (jQuery('input[value="BlackOlive"]').prop("checked")) {
		jQuery('.BlackOlive').css('opacity', '1');
	} else {
		jQuery('.BlackOlive').css('opacity', '0');
	}
	if (jQuery('input[value="GreenOlive"]').prop("checked")) {
		jQuery('.GreenOlive').css('opacity', '1');
	} else {
		jQuery('.GreenOlive').css('opacity', '0');
	}
	if (jQuery('input[value="Sausage"]').prop("checked")) {
		jQuery('.Sausage').css('opacity', '1');
	} else {
		jQuery('.Sausage').css('opacity', '0');
	}
	if (jQuery('input[value="Mushroom"]').prop("checked")) {
		jQuery('.Mushroom').css('opacity', '1');
	} else {
		jQuery('.Mushroom').css('opacity', '0');
	}
	if (jQuery('input[value="Shrimp"]').prop("checked")) {
		jQuery('.Shrimp').css('opacity', '1');
	} else {
		jQuery('.Shrimp').css('opacity', '0');
	}
}