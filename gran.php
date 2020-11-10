<?php
session_start();
require_once('../../connection.php');
//$currentyear=$_SESSION['currentyear'];
//(id_school=1 and (class='6Б' or class='9А' )) or (id_school=2 and (class='11Г' ))  
$currentyear=$_SESSION['currentyear'];

function ClassGranUserCount($ClassesGranBD){
	
	 global $link;
	global $currentyear;
	$query3 = "SELECT count(id) AS Col FROM user  where checkend=1 AND yearcreate='$currentyear' and $ClassesGranBD  ";
  $result3 = mysqli_query($link, $query3) or die("Ошибка " . mysqli_error($link));
   $row1 = mysqli_fetch_assoc($result3);
	 $col=$row1['Col'];
	 
	 return $col;
}
function TypeClass($nameclass,$id_school){
	
	
	 global $link;
	global $currentyear;
	$query3 = "SELECT test_type AS type FROM class  where checkend=1 AND yearcreate='$currentyear' and id_school=$id_school AND name_class='$nameclass' ";
  $result3 = mysqli_query($link, $query3) or die("Ошибка " . mysqli_error($link));
   $row1 = mysqli_fetch_assoc($result3);
	 $type=$row1['type'];
	 
	 return $type;
	
	
	
}
if (isset($_POST['addClassGran'])){
	session_start();
	$rayon=$_SESSION['choosenrayon'];
	$idschool =$_SESSION['choosenschool'];
	$choosenschoolname =$_SESSION['choosenschoolname'];
	
	$classnamearr=$_POST['addClassGran'];
	$ClassesGranTable=$_SESSION['ClassesGranTable'];
	$_SESSION['ClassesGranVisible']="visible;";
	
	$ClassesGranCount=$_SESSION['ClassesGranCount'];
	if ($_SESSION['ClassesGranBD']==null){$ClassesGranBD=" (yearcreate='2020' AND checkend=1 AND id_school=$idschool and (";}else{  $ClassesGranBD=" or (yearcreate='2020' AND checkend=1 AND id_school=$idschool and (";}
  


$total = count($classnamearr);
$counter = 0;
//перебор массива с выбранными классами
	foreach ($classnamearr as $value) {
		
		$counter++;
  if($counter == $total){
	  $ClassesGranCount+=1;
	   // делаем что-либо с последним элементом...
	   //создание массива запроса в бд с классами
    $ClassesGranBD.="class='$value'";
	
	//создание таблицы с классами
		$ClassesGranTable.= "<tr>";
		
		$ClassesGranTable.= "<td >$rayon</td>";
		$ClassesGranTable.= "<td >$choosenschoolname</td>";
		$ClassesGranTable.= "<td >$value</td>";
		$test_type=TypeClass($value,$idschool);
		$ClassesGranTable.= "<td class=\'type\'>$test_type</td>";
		
		$ClassesGranTable.= "</tr>";
  }
  else{
    // делаем что-либо с каждым элементом
	$ClassesGranCount+=1;
	//создание массива запроса в бд с классами
	$ClassesGranBD.="class='$value'";
	$ClassesGranBD.=" or ";
	
	//создание таблицы с классами
		$ClassesGranTable.= "<tr>";
		
		$ClassesGranTable.= "<td >$rayon</td>";
		$ClassesGranTable.= "<td >$choosenschoolname</td>";
		$ClassesGranTable.= "<td >$value</td>";
	$test_type=TypeClass($value,$idschool);
		$ClassesGranTable.= "<td class=\'type\'>$test_type</td>";
		
		$ClassesGranTable.= "</tr>";
	
  }
		
     //$ClassesGranBD.="class='$value'";
  }
  
    $ClassesGranBD.="))";
	$_SESSION['ClassesGranBD'].=$ClassesGranBD;
	$_SESSION['ClassesGranTable']=$ClassesGranTable;
	$_SESSION['ClassesGranCount']=$ClassesGranCount;
	setcookie("ClassesGranCount", $ClassesGranCount);
	
	$UsersGranCount=ClassGranUserCount($_SESSION['ClassesGranBD']);
	$_SESSION['UsersGranCount']=$UsersGranCount;
	setcookie("UsersGranCount", $UsersGranCount);
	echo $ClassesGranTable;
}

if (isset($_POST['ExitGran'])){
	session_start();
	if ($_POST['ExitGran']==1){
	
	$_SESSION['ClassesGranBD']=null;
	$_SESSION['ClassesGranVisible']="hidden;";
	$_SESSION['ClassesGranTable']=null;
	//кол класс
	$_SESSION['ClassesGranCount']=null;
	setcookie("ClassesGranCount", null);
	//кол юзер
	$_SESSION['UsersGranCount']=null;
	setcookie("UsersGranCount", null);
	}
}

if (isset($_POST['rasschet'])){
	
	$CountStrok=15;
	 $X =0;
	for ($i = 1; $i <= $CountStrok; $i++)
{
    /**
     * Стартуем сессию
     */
    session_start();
 
    /**
     * Записываем значение прогресса в переменную сессии
     */
	 $X = ( 100 * $i ) / $CountStrok;
	 $perprogress=round($X , 2);
    $_SESSION['ls_sleep_test'] = $perprogress;
 
    /**
     * Закрываем сессию на запись
     */
    session_write_close();
 
    /**
     * Ждем 1 секунду
     */
 // sleep(1);
}
 
 
 
 
 
/**
 * Выходим из скрипта
 */
 
 
exit();



}



if (isset($_POST['checktype'])){
	$typeA=0;
	$typeB=0;
	$typeC=0;
	$countclass=0;
	$test_typerazchet="none";
	$data = str_replace("class", "name_class", $_SESSION['ClassesGranBD']);
	
	
	
	$querycheck = "
	SELECT 
MAX(test_type) AS test_type, 
COUNT(test_type) AS Count
FROM `class`  
where $data
GROUP BY (test_type)";
  $resultcheck = mysqli_query($link, $querycheck) or die("Ошибка " . mysqli_error($link));
	while ($result1 = mysqli_fetch_array($resultcheck)) {

$test_type=$result1['test_type'];
 $count=$result1['Count'];
$countclass+=$result1['Count'];
if ($test_type=="A"){$typeA=$count;}
if ($test_type=="B"){$typeB=$count;}
if ($test_type=="C"){$typeC=$count;}
	}
	
if ($typeA==$countclass)	{$test_typerazchet="A";}
if ($typeB==$countclass)	{$test_typerazchet="B";}
if ($typeC==$countclass)	{$test_typerazchet="C";}
	
	echo $test_typerazchet;
	$_SESSION['test_typerazchet']=$test_typerazchet;
	
}

?>