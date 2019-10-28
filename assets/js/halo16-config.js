(function($) {
	"use strict";
	$(function() {

		$('.color_picker').wpColorPicker();

		$('#ignore_css').change(function() {
			$('.cp').toggleClass('cp_disabled');

		});

		Form.onReady();
	});

	var Form = {

		onReady: function() {
			$('input[type="submit"]').on('click', Form.buttonClickCallBack);
			$("#halo16-plugin-config-form").submit(Form.submitCallback);
		},

		buttonClickCallBack: function() {
			$("#halo16-plugin-config-form").data('button', this.id);
		},

		submitCallback: function(event) {
			var action_name = $("#halo16-plugin-config-form").data('button');
			if ($("#halo16-plugin-config-form").data('button') != 'submit') {
				$('<input />').attr('type', 'hidden')
					.attr('name', 'reset')
					.attr('value', action_name)
					.appendTo('#halo16-plugin-config-form');
			}
		}
	};

}(jQuery));
