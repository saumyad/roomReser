<?php
include("essential.php");
check_login();

dbconnect();

if(isset($_POST['roomName'])){
	$q = '';
	if($_POST['roomName'] != ''){
		$qq = "select roomId from Room where roomName='".$_POST['roomName']."';" ;
		$rr = execute($qq);
		if(mysql_num_rows($rr) > 1)die();
		$rr = mysql_fetch_array($rr);
		$q = "select * from Booking where roomId='".$rr[0]."';";
		$r = execute($q);
		$arrey=array();
		$arreycount=0;
		while($row = mysql_fetch_array($r))
		{
			$timeslot=$row["timeSlot"];
			for($ii=0;$ii<48;$ii++)
			{
				if($ii==$timeslot){$arrey[]=$ii;$arreycount++;}
			}
		}
		$sst = "<select name='timeSlot' id='timeSlot'>";
		$sst .= "<option value='' >--Please select--</option>";

		for($ii=0;$ii<$arreycount-1;$ii++)
		{
			for($jj=$ii;$jj<$arreycount;$jj++)
			{
				if($arrey[$ii]>$arrey[$jj])
				{
					$xx=$arrey[$ii];
					$arrey[$ii]=$arrey[$jj];
					$arrey[$jj]=$xx;
				}
			}
		}
		for($ii=0;$ii<48;$ii++)
		{

			if($arrey[$jj]<$ii && $jj<$arreycount-1){$jj++;}
			if($arrey[$jj]==$ii){
				if($jj<$arreycount-1){$jj++;}
				continue;}
				if($ii%2==0){
					$start=$ii/2;
					$end=($ii+1)/2;
					$sst .= "<option value=".$ii." id=".$ii.">".$start.":00".$end.":30 </option>";
				}
				else if($arrey[$ii]%2!=0){	
					$start=$ii/2;
					$end=($ii+1)/2;
					$sst .= "<option value=".$ii." id=".$ii.">".$start.":30".$end.":00 </option>";
				}

				$id =  $row[0];
		}
	}
	else
	{
		$sst = "<select name='timeSlot' id='timeSlot'>";
		$sst .= "<option value='' >--Please select--</option>";
		for($ii=0;$ii<48;$ii++)
		{
			if($ii%2==0){
				$start=$ii/2;
				$end=($ii+1)/2;
				$sst .= "<option value=".$ii." id=".$ii.">".$start.":00".end.":30 </option>";
			}
			else if($arrey[$ii]%2!=0){	
				$start=$ii/2;
				$end=($ii+1)/2;
				$sst .= "<option value=".$ii." id=".$ii.">".$start.":30".end.":00 </option>";
			}
		}
	}
	$sst .= "</select>";
	echo $sst;
}
else {
  echo "not working";
}
?>
