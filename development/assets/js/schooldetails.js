function get_routes(val)
{	
	
	$.ajax({
		url: base_url+"admin_boarding/route_list",
		async: false,
		type: "POST",
		data: "school_id="+val,
		dataType: "html",
		success: function(data) {
			$('#schoolRouteList').html(data);
		}
	})
}
function get_route_terms(val)
{	
	
	$.ajax({
		url: base_url+"admin_boarding/term_list",
		async: false,
		type: "POST",
		data: "school_id="+val,
		dataType: "html",
		success: function(data) {
			$('#MainDiv').html(data);
		}
	})
}
function get_boarding_point(val)
{	
	$.ajax({
		url: base_url+"admin_boarding/boarding_list",
		async: false,
		type: "POST",
		data: "school_route_id="+val,
		dataType: "html",
		success: function(data) {
			$('#boardinglist').html(data);
		}
	})
}

function get_route_termList(val)
{	
	
	$.ajax({
		url: base_url+"admin_boarding/get_route_term_list",
		async: false,
		type: "POST",
		data: "school_id="+val,
		dataType: "html",
		success: function(data) {
			$('#schoolTermList').html(data);
		}
	})
}

function get_route_termList_admin(val)
{	
	
	$.ajax({
		url: base_url+"admin_boarding/get_route_term_list_admin",
		async: false,
		type: "POST",
		data: "school_id="+val,
		dataType: "html",
		success: function(data) {
			$('#periodlist').html(data);
		}
	})
}