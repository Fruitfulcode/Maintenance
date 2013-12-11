jQuery(document).ready(function() {
	jQuery('input[placeholder], textarea[placeholder]').placeholder();
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
		
	jQuery(window).resize();
	jQuery('body > div:not(".preloader")').each(function() {
		jQuery(this).css({'visibility': 'hidden'});
	});
});

jQuery(window).load(function() { 
	jQuery('#content').center();
	jQuery('body > div:not(".preloader")').each(function() {
		jQuery(this).css({'visibility': 'visible'});
	});
	setInterval( function() { jQuery('body > .preloader').fadeOut(300); }, 1000); 
});

jQuery(window).resize(function() { 
	if ((jQuery(window).width() < 1025) || (jQuery(window).width() < 769)) {
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
 
jQuery.fn.center = function () {
    this.css("position","absolute");
    this.css("top", Math.max(0, ((jQuery(window).height() - jQuery(this).outerHeight()) / 2) +  jQuery(window).scrollTop()) + "px");
    return this;
}