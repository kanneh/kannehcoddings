<?php
function getColour($dt)
{
	$colours=array();
	$blue=false;
	$red=false;
	$green=false;
	$cr=0;
	$cg=0;
	$cb=0;
	while (!$blue || !$green || !$red) {

		if ($cb+$dt>255) {
			if(!$green && $cg+$dt<=255){
				$cb=0;
				$cg+=$dt;
				$colours[]='rgb('.$cr.', '.$cg.','.$cb.')';
			}elseif (!$red && $cr+$dt<=255) {
				$cb=0;
				$cg=0;
				$cr+=$dt;
				$colours[]='rgb('.$cr.', '.$cg.','.$cb.')';
			}else{
				$blue=true;
				$green=true;
				$red=true;
			}
		}else{
			$cb+=$dt;
			$colours[]='rgb('.$cr.', '.$cg.','.$cb.')';
		}
	}
	return $colours;
}
function getColorDt($w)
{
	if ($w<7) {
		return 255;
	}elseif ($w<26) {
		return 127;
	}elseif ($w<63) {
		return 85;
	}elseif ($w<124) {
		return 63;
	}elseif ($w<215) {
		return 51;
	}elseif ($w<342) {
		return 42;
	}elseif ($w<511) {
		return 36;
	}elseif ($w<728) {
		return 31;
	}elseif ($w<999) {
		return 28;
	}
	return 25;
}
function getDateDiffTotal($date1,$date2,$form="years")
{
	if ($date2>$date1) {
		$mdate=$date1;
		$date1=$date2;
		$date2=$mdate;
	}
	$y1=date_format(date_create($date1),"Y");
	$y2=date_format(date_create($date2),"Y");
	$m1=date_format(date_create($date1),"m");
	$m2=date_format(date_create($date2),"m");
	$d1=date_format(date_create($date1),"d");
	$d2=date_format(date_create($date2),"d");
	$h1=date_format(date_create($date1),"H");
	$h2=date_format(date_create($date2),"H");
	$M1=date_format(date_create($date1),"i");
	$M2=date_format(date_create($date2),"i");
	$s1=date_format(date_create($date1),"s");
	$s2=date_format(date_create($date2),"s");

	$y=$y1-$y2;
	$m=$m1-$m2;
	$d=$d1-$d2;
	$h=$h1-$h2;
	$M=$M1-$M2;
	$s=$s1-$s2;

	if ($m<0 && $y>0) {
		$m=$m+12;
		$y=$y-1;
	}

	if ($d<0) {
		if ($m==0 && $y>0) {
			$m=12;
			$y=$y-1;
		}
		$d=$d+30.4375;
		$m=$m-1;
	}
	if ($h<0) {
		if ($m==0 && $y>0) {
			$m=12;
			$y=$y-1;
		}
		if($d==0){
			$d=$d+30.4375;
			$m=$m-1;
		}
		$h=$h+24;
		$d=$d-1;
	}
	if($M<0){
		if ($m==0 && $y>0) {
			$m=12;
			$y=$y-1;
		}
		if($d==0){
			$d=$d+30.4375;
			$m=$m-1;
		}
		if ($h==0) {
			$h=$h+24;
			$d=$d-1;
		}
		$M=$M+59;
		$h=$h-1;
	}
	if ($s<0) {
		if ($m==0 && $y>0) {
			$m=12;
			$y=$y-1;
		}
		if($d==0){
			$d=$d+30.4375;
			$m=$m-1;
		}
		if ($h==0) {
			$h=$h+24;
			$d=$d-1;
		}
		if($M==0){
			$M=$M+59;
			$h=$h-1;
		}
		$s=$s+59;
		$M=$M-1;
	}

	switch ($form) {
		case 'seconds':
			$result=$s+$M*60+$h*3600+$d*24*3600+$m*30.4375*24*3600+$y*365.25*24*3600;
			break;
		case 'minutes':
			$result=$s/60+$M+$h*60+$d*24*60+$m*30.4375*24*60+$y*365.25*24*60;
			break;
		case 'hours':
			$result=$s/3600+$M/60+$h+$d*24+$m*30.4375*24+$y*365.25*24;
			break;
		case 'days':
			$result=$M/(60*24)+$h/24+$d+$m*30.4375+$y*365.25;
			break;
		case 'months':
			$result=$h/(24*30.4375)+$d/30.4375+$m+$y*365.25/30.4375;
			break;
		default:
			$result=$y+$m/12+$d/(12*30.4375);
			break;
	}

	return $result;
}
function prepareQualification($mqualifications)
{
	$qualifications=array();
	$qualifications['q']=array();
	$qualifications['i']=array();
	$mqualifications=json_decode($mqualifications);
	foreach ($mqualifications as $key) {
		$mq=explode(':', $key);
		$qualifications['q'][]=$mq[0];
		$qualifications['i'][$mq[0]]=$mq[1];
	}
	return $qualifications;
}
function preparePermission($permissions)
{
	$permission = array();
	$mpermission=json_decode($permissions);
	foreach ($mpermission as $key => $value) {
		if (is_array($value)) {
			for ($i=0; $i < count($value); $i++) { 
				$permission[]=array(
					'text'=>$key.":".$value[$i],
					'value'=>$key.":".$value[$i]);
			}
		}
	}
	return $permission;
}
function setDate($year,$month,$day,$hour="",$min="",$sec="",$frac="")
{
	# code...
	if ($hour=="" && $min=="" && $sec=="" && $frac=="") {
		# code...
		return $year.'-'.setDigit10($month).'-'.setDigit10($day);
	}elseif ($hour!="" && $min!="" && $sec!="" && $frac!="") {
		# code...
		return $year.'-'.setDigit10($month).'-'.setDigit10($day).' T'.$hour;
	}
	return '2019-09-09';
}
function setDigit10($num)
{
	if ($num<10) {
		return '0'.$num;
	}
	return $num;
}
?>