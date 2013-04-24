<?php
?>
<script src='js/jquery-1.9.1.min.js'></script>
<script type="text/javascript">
    function addService()
    {
        var salonName=$("#name").val();
        var address=$("#address").val();
        var user_id=$("#user_id").val();
        $.post('Controller/controller.php?action=saveSalonInfo',{'salonName':salonName,'salonAddress':address,"userId":user_id},function(data,status){
                    $("#services").show();
		    $("#salonId").val(data);
            });    
    }
    $("input[type='submit']").click(function(){
        alert("mohit");
        });
    $(document).ready(function() {
        $("#services").hide();
        });
</script>

<style type="text/css">

</style>

<center>
	<form id="myForm" action="" method="post">
	<h1 id="TempHeading">Salon Detail</h1>
	<table id="tempForm">
	<tbody><tr><td><label>Salon Name</label></td>
        <td><input name="Salon_Name" value="" pattern="[A-Za-z' ']*" title="only string value is required" required="true" type="text" id="name"></td></tr>
            <tr><td><label>Salon Address</label></td>
                <td><textarea style="width: 255px; height: 93px;" name="Salon_Address" required="true" id="address"></textarea></td></tr>
        </tbody></table>
	<input value="submit" id="formSubmit" type="button" onclick='addService();'>
        </form>
        <div id="services">
            
            <form id="myForm" action="Controller/controller.php?action=saveSalonServices" method="post">
               <h1 id="TempHeading">Salon services</h1>
	       <input type="hidden" value="" id="salonId" name="salonId">
                <input type="checkbox" name="svrvices[]" value="hairCutting"><label>Hair Cutting</label>
                    <input type="checkbox" name="svrvices[]" value="shaving"><label>Shaving</label><br/>
                        <input type="checkbox" name="svrvices[]" value="massage"><label>Massage</label>
                            <input type="checkbox" name="svrvices[]" value="coloring"><label>Hair Coloring</label><br/>
                <input value="submit" id="formSubmit" type="submit">
            </form>
        </div>
</center>

