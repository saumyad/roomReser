$(document).ready(function(){
		
		function ajax_search(){
		var b = $('#buildingName').val();
		var param ={};
		param['buildingName'] = b;
		$.post('getroom.php',param,function(data){
			$('#divbuildingName').html(data);
			});
		}
		function addOption(myparent,val){
		var opt = document.createElement('option');
		opt.text = val;
		opt.value = val;
		opt.id = val;
		myparent.options.add(opt);
		}
		//man this function really messed me up .... check when u get time ...
		/*
		   function generate_all_timeSlots(){
		//var time = $(document.createElement('select')).attr('id','timeSlot');
		//time.insertBefore('#fake');
		var s = document.createElement('select');
		s.setAttribute('id','timeSlot');
		div = document.getElementById('divdate');
		div.appendChild(s);
		var list = document.getElementById('timeSlot');
		var half = ':30';
		var full = ':00';
		for( i=0 ; i<24 ; i++){
		j=''+i;
		addOption(list,j+full);
		addOption(list,j+half);
		}
		}*/
		ajax_search();
		//	generate_all_timeSlots();
		$('#buildingName').change(function(){
				ajax_search();
				});
		$('table').addClass('center');
		$('p').addClass('welcome');
});
		function validateform(){
			var x = document.forms['queryroom']["buildingName"].value;
			if (x=="" || x == null){	
					alert("Building or room must be specified");
					return false;
				}
			}

