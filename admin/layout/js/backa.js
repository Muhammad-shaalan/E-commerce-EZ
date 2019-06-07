$(function () {
	"use strict";
	 $("select").selectBoxIt({
	 	autoWidth: false
	 });

	 //Profile Page (The Latest)
	 $('.toggle-info').click(function(){
	 	$(this).toggleClass('selected').parent().next('.card-body').fadeToggle(100);
	 	if($(this).hasClass('selected')){
	 		$(this).html('<i class="fa fa-minus"></i>');
	 	}else{
	 		$(this).html('<i class="fa fa-plus"></i>');
	 	}

	 });

	$('[placeholder]').focus(function () {
		$(this).attr('data-text', $(this).attr('placeholder'));
		$(this).attr('placeholder', '');
	}).blur(function () {
		$(this).attr('placeholder', $(this).attr('data-text'));
	})

	$('input').each(function(){
		if($(this).attr('required') === "required"){
			$(this).after('<span class="astrixs">*<span>')
		}
	})

	$('.show-password').hover(function(){
		$('.passwordfield').attr('type', 'text');
	},function(){
		$('.passwordfield').attr('type', 'password');
	});

	$('.card-title').click(function(){
		$(this).next('.full-view').fadeToggle(200);
	});

	$('.option span').click(function(){
		$(this).addClass('active').siblings('span').removeClass('active');
		if($(this).data('view') == 'full'){
			$('.cat .full-view').fadeIn(200);
		}else{
			$('.cat .full-view').fadeOut(200);
		}
	})

	$('.category .child-cat li').hover(function(){
		$(this).find('.show').fadeIn(100);
	},function(){
		$(this).find('.show').fadeOut(100);
	}
	);
});