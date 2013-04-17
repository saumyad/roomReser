$(document).ready(function(){
		$('#buildingName').addClass('ajax');
		$('.ajax').change(function(){
			ajax_query(this.id);
			});
		function ajax_query(upper){
		var value = $('#' + upper).val();
		var param = {};
		param[upper]=value;
		$.post('getroom.php' , param , function(ret_val){
			var str = '#div';
			$(str+upper).html(ret_val);
			});
		}
		ajax_query('buildingName');
		$('#roomName').change(function(){
		  alert('change');
		});


/*		$('#roomName').change(function(){
			ajax_query2();
		});
		function ajax_query2(){
		//var value = $('#roomName').val();
		var value = '301';
		var param = {};
		param['roomName']=value;
		alert(value);
		$.post('findp.php' , param , function(ret_val){
			$('#fake').html(ret_val);
			});
		}
		ajax_query2();
*/
		});
