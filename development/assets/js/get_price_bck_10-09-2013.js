function get_price()
{
	var	boarding	=	$('#boardinglist').val();
	var	term		=	$('#periodlist').val();
	
	if(boarding!='' && term!=''){
		$.ajax({
			url: base_url+"purchase_ticket/get_price",
			async: false,
			type: "POST",
			data: "boarding_id="+boarding+"&term_id="+term,
			dataType: "html",
			success: function(data) {
				$('#purchasePrice').html(data);
				$("input[name=boarding_point_price]").val(data);
			}
		})
	}
}
