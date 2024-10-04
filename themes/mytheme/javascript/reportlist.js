(function($) {
	$(document).ready(function() {

		$('tbody').on( 'click', 'tr', function () {
			$(this).toggleClass('selected');
		} );

		$('.button.action').on('click', function(){
			$type = $(this).html();
			$output = "";
			var selectedFields = $('tr.selected');
			var length = selectedFields.length;

			selectedFields.each(function(index, value){
				thisVal = $(this).val();
				if(parseInt(thisVal) !== 0) {
					if (index === (length - 1)) {
						$output = $output + $(this).attr('id');
					}else{
						$output = $output + $(this).attr('id') + ',';
					}
				}
			});

			window.location = "meldeliste/updateReport?type="+$type+"&ids=" + $output;
		});

		$('#searchFilterField').keyup(function(){
			// Declare variables 
			  console.info("search");
			  var input, filter, table, tr, td, i;
			  input = document.getElementById("searchFilterField");
			  filter = input.value.toUpperCase();
			  table = $('#reportlist');
			  tr = $('#reportlist tr');

			  // Loop through all table rows, and hide those who don't match the search query
			  $('tr').each(function(i, value){
			  		td = this.getElementsByTagName("td")[0];
				    if (td) {
				      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
				        this.style.display = "";
				      } else {
				        this.style.display = "none";
				      }
				    } 
			  });
		});
			

	} );
})(jQuery);

var showReportForm = new Vue({
	el: '#TournamentForm',
	data:{
		show: false
	},
	methods:{
		toggle: function(){
			this.show = !this.show
		}
	}
})

