<?php
echo "test" ;die(); 
//require_once('../conn_string.php');
require_once($CFG->dirroot .'/config.php');
require_once($CFG->dirroot .'/course/lib.php');
require_once($CFG->dirroot .'/lib/blocklib.php');
require_once '../Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$i = 1;

function assign_rand_value($num)
{
// accepts 1 - 36
  switch($num)
  {
    case "1":
     $rand_value = "a";
    break;
    case "2":
     $rand_value = "b";
    break;
    case "3":
     $rand_value = "c";
    break;
    case "4":
     $rand_value = "d";
    break;
    case "5":
     $rand_value = "e";
    break;
    case "6":
     $rand_value = "f";
    break;
    case "7":
     $rand_value = "g";
    break;
    case "8":
     $rand_value = "h";
    break;
    case "9":
     $rand_value = "i";
    break;
    case "10":
     $rand_value = "j";
    break;
    case "11":
     $rand_value = "k";
    break;
    case "12":
     $rand_value = "l";
    break;
    case "13":
     $rand_value = "m";
    break;
    case "14":
     $rand_value = "n";
    break;
    case "15":
     $rand_value = "o";
    break;
    case "16":
     $rand_value = "p";
    break;
    case "17":
     $rand_value = "q";
    break;
    case "18":
     $rand_value = "r";
    break;
    case "19":
     $rand_value = "s";
    break;
    case "20":
     $rand_value = "t";
    break;
    case "21":
     $rand_value = "u";
    break;
    case "22":
     $rand_value = "v";
    break;
    case "23":
     $rand_value = "w";
    break;
    case "24":
     $rand_value = "x";
    break;
    case "25":
     $rand_value = "y";
    break;
    case "26":
     $rand_value = "z";
    break;
    case "27":
     $rand_value = "0";
    break;
    case "28":
     $rand_value = "1";
    break;
    case "29":
     $rand_value = "2";
    break;
    case "30":
     $rand_value = "3";
    break;
    case "31":
     $rand_value = "4";
    break;
    case "32":
     $rand_value = "5";
    break;
    case "33":
     $rand_value = "6";
    break;
    case "34":
     $rand_value = "7";
    break;
    case "35":
     $rand_value = "8";
    break;
    case "36":
     $rand_value = "9";
    break;
  }
return $rand_value;
}


function get_rand_id($length)
{
  if($length>0) 
  { 
  $rand_id="";
   for($i=1; $i<=$length; $i++)
   {
   mt_srand((double)microtime() * 1000000);
   $num = mt_rand(1,26);
   $rand_id .= assign_rand_value($num);
   }
  }
return $rand_id;
} 

//echo $length = $_GET['digit'];
//echo $n = $_GET['trn'];
//echo $pin = $_GET['pin'];

//$today = date("Y-m-d");
//$filename = 'RDNG-'.date('d-M-Y-H-i-s').'.xls';

$gn = '<table border=0>';

for($j=1;$j<=$n;$j++)
{
	//echo 'I = '.$i.'<br/>';
	$stat = 1;
	do
	{
	    $num = get_rand_id($length);
		//echo 'NUM = '.$num.'<br/>';
		$sql = "select id from mdl_passcode where code = '".strtoupper($num)."' ";
		$rs = mysql_query($sql);
		$nr = $rs->num_rows;
		//echo 'ROW = '.$nr.'<br/>';
		if($nr > 0) $stat = 0;
		else 
		{
			//echo 'NO<br/>';
			$stat = 1;
			$gen = $gen . '<tr><td>'.$num .'</td></tr>';
			//echo 'GEN = '.$gen.'<br/>';

			if($pin == 'yes') $insert = sprintf("insert into mdl_passcode (code, update_date) values ('%s','%s')",strtoupper($num),$today);
			else $insert = sprintf("insert into mdl_passcode (code) values ('%s')",strtoupper($num));
			mysql_query($insert);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i, strtoupper($num));
			$i++;
		}
	}
	while($stat == 0);
}

$gen = $gen . '</table>';

$objPHPExcel->getActiveSheet()->setTitle('Random Number');

$objPHPExcel->setActiveSheetIndex(0);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save($filename);

echo "<br/><center><table><tr><td>Please click the icon</td><td> <a href='ops/".$filename."'><img src='images/excel_icon.png' border='0'/></a></td><td> to download the codes.</td></tr></table></center>";
?>

