jQuery(document).ready(function() {
	jQuery('input[placeholder]').placeholder();
	jQuery('#login-form').submit(function() {
	   if (!jQuery(this).hasClass('active')) {
			jQuery(this).find('span.licon').fadeIn(300);
			jQuery(this).find('span.picon').fadeIn(300);
			jQuery(this).addClass('active');
			jQuery(this).find('input[type="text"]').focus();
			return false;
		}
	});
	
	if (jQuery('#login-form').hasClass('error')){
			jQuery('#login-form').find('span.licon').fadeIn(100);
			jQuery('#login-form').find('span.picon').fadeIn(100);
			jQuery('#login-form').find('input[type="text"]').focus();
	}
		
	if (jQuery(window).width() < 768) {
		jQuery('#login-form').find('span.licon').fadeIn(300);
		jQuery('#login-form').find('span.picon').fadeIn(300);
		jQuery('#login-form').addClass('active');
	} else {
		if (!jQuery('#login-form').hasClass('error')) {
				jQuery('#login-form').find('span.licon').fadeOut(300);
				jQuery('#login-form').find('span.picon').fadeOut(300);
				jQuery('#login-form').removeClass('active');
		}	
	}
	
	jQuery('#content').center();
	
});

jQuery(window).resize(function() { 
	if (jQuery(window).width() < 768) {
		jQuery('#login-form').find('span.licon').fadeIn(300);
		jQuery('#login-form').find('span.picon').fadeIn(300);
		jQuery('#login-form').addClass('active');
	} else {
		jQuery('#login-form').find('span.licon').fadeOut(400);
		jQuery('#login-form').find('span.picon').fadeOut(400);
		jQuery('#login-form').removeClass('active');
	}
	jQuery('#content').center();
});
 
jQuery.fn.center = function () {
    this.css("position","fixed");
    this.css("top", Math.max(0, ((jQuery(window).height() - jQuery(this).outerHeight()) / 2) +  jQuery(window).scrollTop()) + "px");
    return this;
}