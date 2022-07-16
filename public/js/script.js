function formatNumber(total) {
	return parseFloat(total).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString().replace('.00', '');
}