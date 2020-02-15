<?php
$iYear = date('Y');

for($i = 1; $i <= 12; $i++) {
  echo $iNumDaysInMonth = date('t', mktime(0,0,0,$i,1,$iYear));

  for($j = 1; $j <= $iNumDaysInMonth; $j++) {
   echo $iDayNum = date('N', mktime(0,0,0,$i,$j,$iYear));

    if($iDayNum == 3) {
      // wednesday
    } elseif($iDayNum == 5) {
      // friday
    } elseif($iDayNum == 1) {
      // monday
    }
  }
}


function periode($var, $i2)
{
    if($var=='1') {
        return '+'.$i2.' day';
    }
    else if($var=='2') {
        return '+'.$i2.' week';
    }
    else if($var=='3') {
        return '+'.$i2.' month';
    }
}

$current_date = date('Y-m-d');
echo date('Y-m-d', strtotime(periode(1, 1), strtotime($current_date)));
echo '<br />'.date('Y-m-d', strtotime(periode(2, 2), strtotime($current_date)));
echo '<br />'.date('Y-m-d', strtotime(periode(3, 1), strtotime($current_date)));
?>