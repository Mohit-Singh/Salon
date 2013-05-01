<?php 
echo "<pre>";
print_r($data);
print_r($_GET);
?>
<script src='js/jquery-1.9.1.min.js'></script>
<script src="js/jquery-ui.js"></script>
<link rel="stylesheet" href="./css/jquery-ui.css" />

<script>

$(document).ready(function() {

	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();
	$("#slotDate").hide();
	$("#slotDate").datepicker({
		changeYear: true,
		changeMonth: true,
		dateFormat: "yy-mm-dd"
			});

	$.post('./Controller/controller.php?action=getAllSalon',{},function(result){
		
		newdata= jQuery.parseJSON( result );
		 $.each(newdata, function(key, value){
					$("#Salon").append("<option value="+value['id']+">"+value['saloon_name']+"</option>");
			 });
		});
	
	//alert("mogir");
	//date=date.format("m/dd/yyyy");
	//alert("hdlkshjfkls");
	//input = date.parse(date);
	//alert(input);
	//$("#todayDate").html(input);
	//input=$("#todayDate").html();
	//alert(input);
	//input = Date.parse(input);
	//alert(input);
	//$("#todayDate").html(input);

});

function chkSlot(obj)
{
	var id=$(obj).val();
	$.post('./Controller/controller.php?action=getAllSalonService',{"salonId":id},function(result){
		
		newdata= jQuery.parseJSON( result );
		 $.each(newdata, function(key, value){
					$("#selectForm").append("<input type='checkbox' name='reqSlotTime[]' value="+value['duration']+"><label>"+value['service']+"</label><br/>");
			 });
		 $("#salId").val(id);
		 $("#slotDate").show();
		 $("#selectForm").append("<input type='submit' value='ok'>");
		});
	
}

</script>
<script type="text/javascript">

</script>

<div id="visitorSelect">
	<select id="Salon" onchange="chkSlot(this);">
	<option value="none">None</option>
	</select>
<form id="selectForm" action="./Controller/controller.php?action=visitorAvailableSlot" method="post">
<input type="hidden" name="salonId" value="" id="salId">
<input type='text' id='slotDate' name='slotDate' value='' readonly="readonly">

</form>

</div>
