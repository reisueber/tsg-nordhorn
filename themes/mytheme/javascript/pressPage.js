(function($) {

	console.log("pressPage.js");

	let coordinates = function(element) {
		element = $(element);
		let top = element.position().top;
		let left = element.position().left;

		$('#Form_EditForm_MainImageX').val(left);
		$('#Form_EditForm_MainImageY').val(top);
		console.log('X: ' + left + ' ' + 'Y: ' + top);
	}

	let size = function(element, ui){
		element = $(element);
		//let size = ui.size.width;
		//console.log(size);
	}

	$( "#mainImageWrapper" ).draggable({
		start: function() {
			coordinates('#mainImageWrapper');
		},
		stop: function() {
			coordinates('#mainImageWrapper');
		}
	});

	$("#mainImage").resizable({
		ghost: true,
		aspectRatio: true,
		stop: function( event, ui ) {
			console.log(ui.size.width);
			$('#Form_EditForm_MainImageWidth').val(ui.size.width);
		}
	});
})(jQuery);