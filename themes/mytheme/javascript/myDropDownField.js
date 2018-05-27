(function($) {
	$(document).ready(function() {

		$('.button-dropdown-menu-below li').on( 'click', function () {
			var selection = $(this).text();
			var inputField = $(this).data("fieldname");
			console.info(inputField);
			$('#dropdown-'+inputField).html( selection + " <i class=\"fa fa-caret-down\"></i>");
			console.info('input#field-'+inputField + "- Value: " + selection);
			$('input#field-'+inputField).attr("value", selection);
		} );

	} );
})(jQuery);

