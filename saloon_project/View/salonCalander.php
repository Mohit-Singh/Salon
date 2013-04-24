
<link rel='stylesheet' href='css/theme.css' />
<link href='css/fullcalendar.css' rel='stylesheet' />
<link href='css/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='js/jquery-1.9.1.min.js'></script>
<script src='js/jquery-ui-1.10.2.custom.min.js'></script>
<script src='js/fullcalendar.min.js'></script>

<script>

	$(document).ready(function() {
	
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		renderCalEventsCount();
		var calendar = $('#calendar').fullCalendar({
			theme:true,
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			ignoreTimezone :Boolean, default: true,
			selectable: true,
			selectHelper: true,
			select: function(start, end, allDay) {
				var title = prompt('Event Title:');
				if (title) {
					var calStartDate=Math.round(start.getTime() / 1000);
					var dbStartDate=$.fullCalendar.formatDate(start, "yyyy-MM-dd HH:mm:ss");
					var calEndDate=Math.round(end.getTime() / 1000);
					var dbEndDate=$.fullCalendar.formatDate(end, "yyyy-MM-dd HH:mm:ss");
					var slotId=$("#slotCount").val();
					var userId=$("#user_id").val();
					var salonId=$("#salon_id").val();
					slotId=parseInt(slotId)+1;
					$("#slotCount").val(slotId);
					calendar.fullCalendar('renderEvent',
						{
							id:slotId,
							title: title,
							start: start,
							end: end,
							allDay: allDay
						},
						true // make the event "stick"
					);
					$.post('./Controller/controller.php?action=saveSlot',{"Calstart":calStartDate,
												"Calend":calEndDate,
												"DbStart":dbStartDate,
												"DbEnd":dbEndDate,
												"SlotId":slotId,
												"salonId":salonId,
												"title":title,
												"allDay":allDay,
												"clientId":userId},function(data){
						//alert(data);
						//event.end=data;
						//calendar.fullCalendar('updateEvent',event);
						
						});
				}
				calendar.fullCalendar('unselect');
			},
			editable: true,
			eventColor: '#378006',
			allDayDefault: false,
			events: 'Controller/json-events.php?salonId='+$("#salon_id").val(),
			/*events: [
		    
			    // your event source
			    {
				url: './Controller/controller.php?action=getCalEvents',
				type: 'POST',
				data: {
				    salonId: $("#salon_id").val()
				    
				},
				success:function(data){
					alert(data);
				},
				error: function() {
				    alert('there was an error while fetching events!');
				},
			    }		    
			],*/			
			eventAfterRender:function( event, element, view ) {
				//alert(event.title);
				},
			eventDrop:function( event, dayDelta, minuteDelta, allDay, revertFunc, jsEvent, ui, view ) {
				var calStartDate=Math.round(event.start.getTime() / 1000);
				var dbStartDate=$.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
				var calEndDate=Math.round(event.end.getTime() / 1000);
				var dbEndDate=$.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
				var slotId=$("#slotCount").val();
				var userId=$("#user_id").val();
				var salonId=$("#salon_id").val();
					alert(
					    "The end date of " + event.title + " has been moved " +
					    dayDrenderCalEventsCountelta + " days and " +
					    minuteDelta + " minutes."
					);
				
					if (!confirm("is this okay?")) {
					    revertFunc();
					}
					else{
						$.post('./Controller/controller.php?action=resizeChk',{"Calstart":calStartDate,
													"Calend":calEndDate,
													"DbStart":dbStartDate,
													"DbEnd":dbEndDate,
													"SlotId":slotId,
													"salonId":salonId,
													"clientId":userId},function(data){
							//alert(data);
							 //revertFunc();
							
							});
					}
				},
			eventResize  :function( event, dayDelta, minuteDelta, revertFunc, jsEvent, ui, view ) {
				var calStartDate=Math.round(event.start.getTime() / 1000);
				var dbStartDate=$.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
				var calEndDate=Math.round(event.end.getTime() / 1000);
				var dbEndDate=$.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
				var slotId=$("#slotCount").val();
				var userId=$("#user_id").val();
				var salonId=$("#salon_id").val();
					alert(
					    "The end date of " + event.title + " has been moved " +
					    dayDelta + " days and " +
					    minuteDelta + " minutes."
					);
				
					if (!confirm("is this okay?")) {
					    revertFunc();
					}
					else{
						$.post('./Controller/controller.php?action=resizeChk',{"Calstart":calStartDate,
													"Calend":calEndDate,
													"DbStart":dbStartDate,
													"DbEnd":dbEndDate,
													"SlotId":slotId,
													"salonId":salonId,
													"clientId":userId},function(data){
							//alert(data);
							 //revertFunc();
							
							});
					}
				},				
			eventClick: function(event) {
				alert(event.id+" "+event.start+" "+event.end+" "+event.allDay);
				// opens events in a popup window
				//window.open('View/header.html', 'gcalevent', 'width=700,height=600');
				//return false;
			},			
		});
		
	});

	function renderCalEventsCount()
	{
		var salonId=$("#salon_id").val();
		$.post('./Controller/controller.php?action=getCalEvents',{"salonId":salonId},function(data){
			$("#slotCount").val(data);
			});
	}


</script>
<style>

	#calBody {
		margin-top: 40px;
		text-align: center;
		font-size: 13px;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		}

	#calendar {
		width: 900px;
		margin: 0 auto;
		}

</style>
</head>
<div id="calBody">	
<div id='calendar'>
<input type="hidden" id="salon_id" value="<?php echo $_SESSION['clientSaloonData'][0]['id'];?>">	
<input type="hidden" value="0" id="slotCount">	
</div>
</div>