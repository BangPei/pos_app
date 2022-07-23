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

	$('.modal').on('hidden.bs.modal', function (event) {
		resetForm($('#form-description'))
	  })

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

function formValid(form, callback) {
	form.unbind().submit(function () {
		if (form.valid()) {
			callback();
		}
		return false;
	})
}

function resetForm(form) {
	form.find("input").val("");
	form.find("input[type='checkbox']").prop("checked", false);
	form.find("textarea").val("");
	form.find("select").prop('selectedIndex', 0).trigger('change');
	form.find(".error").removeClass("error");
	form.find("#handling-error").remove();
}

function ajax(data, url, method, callback, callbackError) {
	$.ajax({
		url: url,
		data: JSON.stringify(data),
		type: method,
		headers: {
			"Content-Type": "application/json",
			"Cache-Control": "no-cache",
			"Authorization": token,
			// "x-client-data": xclientdata
		},
		success: function (a, b, c) {
			json = a;
			textStatus = b;
			jqXHR = c;
			callback();
		},
		error: function (a, b, c) {
			callbackError();
		}
	});
}
