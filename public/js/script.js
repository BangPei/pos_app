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
