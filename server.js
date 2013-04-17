function getServerTime(){
	$.post("servertime.php",function(time){
	 	$('#serverTime').html(time);
	});

}
window.setInterval("getServerTime()",500);
