jQuery(window).ready(function(){
		jQuery.fn.tzCheckbox = function(options){
		options = jQuery.extend({
			labels : ['ON','OFF']
		},options);
		
		return this.each(function(){
			var originalCheckBox = jQuery(this),
				labels = [];
			if(originalCheckBox.data('on')){
				labels[0] = originalCheckBox.data('on');
				labels[1] = originalCheckBox.data('off');
			}
			else labels = options.labels;
			var checkBox = jQuery('<span>');
				 checkBox.addClass(this.checked?' tzCheckBox checked':'tzCheckBox');
			     checkBox.prepend('<span class="tzCBContent">'+labels[this.checked?0:1]+ '</span><span class="tzCBPart"></span>');
			checkBox.insertAfter(originalCheckBox.hide());

			checkBox.click(function(){
				checkBox.toggleClass('checked');
				var isChecked = checkBox.hasClass('checked');
				originalCheckBox.attr('checked',isChecked);
				checkBox.find('.tzCBContent').html(labels[isChecked?0:1]);
			});

			originalCheckBox.bind('change',function(){
				checkBox.click();
			});
		});
	};
	
	jQuery('#state').tzCheckbox({labels:['On','Off']});
	var vColorPickerOptions = {
    	defaultColor: false,
    	change: function(event, ui){},
    	clear: function() {},
		hide: true,
		palettes: true
	};
 
	jQuery('#body_bg_color, #font_color, #body_bg_blur_color').wpColorPicker(vColorPickerOptions);
	
	
	
});