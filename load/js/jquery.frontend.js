jQuery(document).ready(function() {
	jQuery('input[placeholder]').placeholder();
	jQuery('#login-form').submit(function() {
		if (!jQuery(this).hasClass('active')) {
			jQuery(this).find('input[type="text"]').fadeIn(300);
			jQuery(this).find('input[type="password"]').fadeIn(300);
			jQuery(this).addClass('active');
			jQuery(this).find('input[type="text"]').focus();
			return false;
		}
	});
	
	if (jQuery(window).width() < 768) {
		jQuery('#login-form').find('input[type="text"]').fadeIn(300);
		jQuery('#login-form').find('input[type="password"]').fadeIn(300);
		jQuery('#login-form').addClass('active');
	} else {
		jQuery('#login-form').find('input[type="text"]').fadeOut(300);
		jQuery('#login-form').find('input[type="password"]').fadeOut(300);
		jQuery('#login-form').removeClass('active');
	}
	
	jQuery('#content').center();
	
});

jQuery(window).resize(function() { 
	jQuery('#content').center();
	if (jQuery(window).width() < 768) {
		jQuery('#login-form').find('input[type="text"]').fadeIn(300);
		jQuery('#login-form').find('input[type="password"]').fadeIn(300);
		jQuery('#login-form').addClass('active');
	} else {
		jQuery('#login-form').find('input[type="text"]').fadeOut(400);
		jQuery('#login-form').find('input[type="password"]').fadeOut(400);
		jQuery('#login-form').removeClass('active');
	}
});
 
jQuery.fn.center = function () {
    this.css("position","fixed");
    this.css("top", Math.max(0, ((jQuery(window).height() - jQuery(this).outerHeight()) / 2) +  jQuery(window).scrollTop()) + "px");
    return this;
}