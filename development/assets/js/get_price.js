function get_price()
{
	var	boarding	=	$('#boardinglist').val();
	var	term		=	$('#periodlist').val();
	alert(boarding);
	alert(term);
	if(boarding!='' && term!=''){
		$('input[type="submit"]').attr('disabled','disabled');
		$('input[type="submit"]').attr('class', 'disable-button');
		$.ajax({
			url: base_url+"purchase_ticket/get_price",
			async: false,
			type: "POST",
			data: "boarding_id="+boarding+"&term_id="+term,
			dataType: "html",
			success: function(data) {
				//alert(data)
				if(data != "")
				{

					$('#ticket-dist').show();
					var totalPrice	=	(((parseFloat(data)*parseFloat(sur_charge))/100)+parseFloat(data)).toFixed(2);
					$('#ticket-dist').html('<h3><span>Ticket</span>: &pound;'+data+'</h3><h3><span>ADMIN FEE</span>: '+sur_charge+'%</h3><h3><span>Total</span>: &pound;'+totalPrice+'</h3>');
					alert(totalPrice);
					$("input[name=boarding_point_price]").val(data);
					$("input[name=user_ticket_surcharge]").val(sur_charge);
					$("input[name=user_ticket_totalprice]").val(totalPrice);
				
					$('input[type="submit"]').attr('class', 'input-button');
					$('input[type="submit"]').removeAttr('disabled');
				}
				else
				{
					$('#ticket-dist').html('<h3><span style="width:350px; float:left;">No ticket available.</span></h3>');
				}
			}
		})
	}
}
