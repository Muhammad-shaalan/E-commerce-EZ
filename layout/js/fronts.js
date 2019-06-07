$(function () {
	"use strict";
	 $("select").selectBoxIt({
	 	autoWidth: false
	 });

	$('[placeholder]').focus(function () {
		$(this).attr('data-text', $(this).attr('placeholder'));
		$(this).attr('placeholder', '');
	}).blur(function () {
		$(this).attr('placeholder', $(this).attr('data-text'));
	})

	//Show Astrixs
	$('input').each(function(){
		if($(this).attr('required') === "required"){
			$(this).after('<span class="astrixs">*<span>')
		}
	})

	$('h1 span').click(function(){
		$(this).addClass('selected').siblings().removeClass('selected');
		$('.loginPage form').hide();
		$('.' + $(this).data('class')).fadeIn(100);
	})

	$('.live').keyup(function(){
		$($(this).data('class')).text($(this).val());
	});

});