$(document).ready(function(){
		$('#buildingName').addClass('ajax');
		flag = 0;
		$('.ajax').change(function(){
			ajax_query(this.id);
			});
		function ajax_query(upper){
		var value = $('#' + upper).val();
		//alert(value);
		var param = {};
		param[upper]=value;
		$.post('getroom.php' , param , function(ret_val){
			var str = '#div';
			$(str+upper).html(ret_val);
			if(upper=='buildingName'){
			$('#roomName').change(function(){
				ajax_query('roomName');
				});
			}
			if(flag==0){
				$('#check').click();flag=1;
				toggleDisabled(document.getElementById('content2'));
			}
			});

		}
		ajax_query('buildingName');
});
