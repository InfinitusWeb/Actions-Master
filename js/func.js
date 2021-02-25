function ajax ( script_php , valor )
{
	$.ajax({
            url: script_php,
            type: 'POST',
            data: {param: valor},
            async: false          
	});
}

function sa2Confirm (title, text, confirmBtnText, text2 ) 
{

swal.fire({
  	title: title,
 	text: text,
  	type: 'question',
  	showCancelButton: true,
  	confirmButtonColor: '#3085d6',
  	cancelButtonColor: '#d33',
	cancelButtonText: 'Cancelar',
  	confirmButtonText: confirmBtnText
}).then((result) => {
	if (result.value) {
   		sc_btn_acao();
  	}else{
		swal.fire({
			type: 'warning', 
			title: text2,
			showCloseButton: true,
			timer: 1500
		});
	}
})	
	
}