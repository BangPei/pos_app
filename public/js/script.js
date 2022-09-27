$(document).ready(function(){
	$('.select2').select2({})
	$('.select2').on('select2:open', function () {
		$('input.select2-search__field')[0].focus();
	})
	// $('.select2').select2({
    //     dropdownParent: $('.modal-body')
    // });

	$('.npwp').mask('99.999.999.9-999.999', {
		placeholder: "__.___.___._-___.___"
	});

	$('.number2').on('keyup', function(event) {
		if (event.which >= 37 && event.which <= 40) return;
		$(this).val(function(index, value) {
			return value
				.replace(/\D/g, "")
				.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		});
	});

	$('.modal').on('hidden.bs.modal', function (event) {
		resetForm($('.modal form'))
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

function numberFormat(num) {
	return $.fn.dataTable.render.number(',', '.', 2, '').display(num)
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
		data: data,
		type: method,
		headers:{
			'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
		},
		success: function (json,text) {
			json = json;
			callback(json);
		},
		error: function (err) {
			callbackError == null?
				toastr.error(err?.responseJSON?.message??"Tidak Dapat Mengakses Server")
				:callbackError(err);
		}
	});
}

function reloadJsonDataTable(dtable, json) {
	dtable.clear().draw();
	dtable.rows.add(json).draw();
}

function tableNumber(table) {
	table.on('order.dt search.dt', function () {
        let i = 1;
        table.cells(null, 0, { 
			search: 'applied', 
			order: 'applied'
		}).every(function (cell) {
            this.data(i++);
        });
    }).draw();
}

function keyupTableNumber(table) {
	table.on('keyup', '.number2', function(event) {
		if (event.which >= 37 && event.which <= 40) return;
		$(this).val(function(index, value) {
			return value
				.replace(/\D/g, "")
				.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		});
	});
}

function getQueryString() {
	location.queryString = {};
	location.search.substring(1).split("&").forEach(function (pair) {
		if (pair === "") return;
		var parts = pair.split("=");
		location.queryString[parts[0]] = parts[1] && decodeURIComponent(parts[1].replace(/\+/g, " "));
	});
	return location.queryString;
}
