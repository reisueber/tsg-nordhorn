(function($) {

	var coordinates = function(element) {
		element = $(element);
		var top = element.position().top;
		var left = element.position().left;

		$('#Form_EditForm_profilImageX').val(left);
		$('#Form_EditForm_profilImageY').val(top);
		console.log('X: ' + left + ' ' + 'Y: ' + top);
	}

	$( "#profilImage" ).draggable({
		start: function() {
			coordinates('#profilImage');
		},
		stop: function() {
			coordinates('#profilImage');
		}
	});

	console.log("function");

	$(document).ready(function(){
		$(document).keypress("-",function(e) {
			if(e.ctrlKey)
				console.log("minus");
				$('#profilImage img').imageResize();
		});
	});

	$.fn.imageResize = function(options) {

		var that = this;
		var settings = {
			width: 100,
			height: 100
		};
		options = $.extend(settings, options);

		if (!that.is('img')) {
			return;
		}

		return that.each(function() {

			var maxWidth = options.width;
			var maxHeight = options.height;
			var ratio = 0;
			var width = $(that).width();
			var height = $(that).height();

			if (width > maxWidth) {
				ratio = maxWidth / width;
				$(that).css('width', maxWidth);
				$(that).css('height', height * ratio);

			}

			if (height > maxHeight) {
				ratio = maxHeight / height;
				$(that).css('height', maxHeight);
				$(that).css('width', width * ratio);

			}

		});
	};
})(jQuery);

var profilEditForm = new Vue({
	el: '#ProfilFormApp',
	data:{
		tab0IsActive: true,
		tab1IsActive: false,
		tab2IsActive: false,
		tab3IsActive: false,
		tab4IsActive: false
	},
	methods:{
		clickTab0: function(event){
			this.tab0IsActive = true,
			this.tab1IsActive = false,
			this.tab2IsActive = false,
			this.tab3IsActive = false,
			this.tab4IsActive = false
		},
		clickTab1: function(event){
			this.tab0IsActive = false,
			this.tab1IsActive = true,
			this.tab2IsActive = false,
			this.tab3IsActive = false,
			this.tab4IsActive = false
		},
		clickTab2: function(event){
			this.tab0IsActive = false,
			this.tab1IsActive = false,
			this.tab2IsActive = true,
			this.tab3IsActive = false,
			this.tab4IsActive = false
		},
		clickTab3: function(event){
			this.tab0IsActive = false,
			this.tab1IsActive = false,
			this.tab2IsActive = false,
			this.tab3IsActive = true,
			this.tab4IsActive = false
		},
		clickTab4: function(event){
			this.tab0IsActive = false,
			this.tab1IsActive = false,
			this.tab2IsActive = false,
			this.tab3IsActive = false,
			this.tab4IsActive = true
		}
	}
});