vtotal = 0.00;

function jscheck(seq,id,ajax,valor) {
		
		//var c = $('#'+seq).is(':checked');
				
		if($('#'+seq).is(':checked')) {
			$.post(ajax,{'grid_dfrun_toggle_btn': [id,'0']});
			vtotal -= valor;
		}
		else  { 
			$.post(ajax,{'grid_dfrun_toggle_btn': [id,'1']});
			vtotal += valor;
		}
		$('#idsel').html(Number(vtotal.toFixed(2)).formatMoney(2, 'R$ ', '.', ','));
}
	

Number.prototype.formatMoney = function(places, symbol, thousand, decimal) {
	places = !isNaN(places = Math.abs(places)) ? places : 2;
	symbol = symbol !== undefined ? symbol : "$";
	thousand = thousand || ",";
	decimal = decimal || ".";
	var number = this, 
	    negative = number < 0 ? "-" : "",
	    i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",
	    j = (j = i.length) > 3 ? j % 3 : 0;
	return symbol + negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "");
};