$(document).ready(function(){
	$('.select2').select2()

	$('.number2').on('keyup', function(event) {
		if (event.which >= 37 && event.which <= 40) return;
		$(this).val(function(index, value) {
			return value
				.replace(/\D/g, "")
				.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		});
	});

	$('form[data-vaidate=true]').validate({
		rules: {
		  email: {
			required: true,
			email: true,
		  },
		  password: {
			required: true,
			minlength: 5
		  },
		  terms: {
			required: true
		  },
		},
		messages: {
		  email: {
			required: "Please enter a email address",
			email: "Please enter a valid email address"
		  },
		  password: {
			required: "Please provide a password",
			minlength: "Your password must be at least 5 characters long"
		  },
		  terms: "Please accept our terms"
		},
		errorElement: 'span',
		errorPlacement: function (error, element) {
		  error.addClass('invalid-feedback');
		  element.closest('.form-group').append(error);
		},
		highlight: function (element, errorClass, validClass) {
		  $(element).addClass('is-invalid');
		},
		unhighlight: function (element, errorClass, validClass) {
		  $(element).removeClass('is-invalid');
		}
	  });
})
function formatNumber(total) {
	return parseFloat(total).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString().replace('.00', '');
}
function IsNumeric(event) {
	var keycode = event.which;
	if (!(event.shiftKey == false && (keycode == 8 || keycode == 37 || keycode == 46 || keycode == 110 ||keycode==13|| (keycode >= 48 && keycode <= 57)))) {
		event.preventDefault();
	}
}
