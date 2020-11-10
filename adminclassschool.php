<?php
session_start();
//require 'test.ru/connection.php' ;
require_once('../../connection.php');
//require_once( '../functions.php' );
if ($_SESSION['type_user']=="admin"){
	//$_SESSION['ClassesGranBD']=null;
	   if(isset($_SESSION['ClassesGranVisible'])){}else{$_SESSION['ClassesGranVisible']="hidden;";}
	    if(isset($_SESSION['ClassesGranVisible'])){$_SESSION['ls_sleep_test']=0;}
	//echo $_SESSION['test_typerazchet'];
} else {header("Location: ../main.html");}
$currentyear=$_SESSION['currentyear'];
$idschool =$_SESSION['choosenschool'];
//классы
// закончили

function ColClassSchoolENDdiag(){
	global $idschool;
 global $link;
	global $currentyear;
	$query3 = "SELECT count(id_class) AS ColClass FROM class c where c.checkend=1 AND c.yearcreate='$currentyear' and c.id_school='$idschool'  ";
  $result3 = mysqli_query($link, $query3) or die("Ошибка " . mysqli_error($link));
   $row1 = mysqli_fetch_assoc($result3);
	 $col=$row1['ColClass'];
	 
	 return $col;
}
function ColClassSchoolNOdiag(){
	global $idschool;
 global $link;
	global $currentyear;
	$query3 = "SELECT count(id_class) AS ColClass FROM class c where c.checkend=0 AND c.yearcreate='$currentyear' and c.id_school='$idschool'  ";
  $result3 = mysqli_query($link, $query3) or die("Ошибка " . mysqli_error($link));
   $row1 = mysqli_fetch_assoc($result3);
	 $col=$row1['ColClass'];
	 
	 return $col;
}
function ColClassdiag(){
	global $idschool;
 global $link;
	global $currentyear;
	$query3 = "SELECT count(id_class) AS ColClass FROM class c where c.id_school='$idschool' AND c.yearcreate='$currentyear' ";
  $result3 = mysqli_query($link, $query3) or die("Ошибка " . mysqli_error($link));
   $row1 = mysqli_fetch_assoc($result3);
	 $col=$row1['ColClass'];
	 
	 return $col;
}

function ColUserSchoolENDdiag(){
	global $idschool;
 global $link;
	global $currentyear;
	$query3 = "SELECT count(id) AS ColClass FROM user u  WHERE u.checkend=1 AND u.id_school='$idschool' AND u.yearcreate='$currentyear'";
  $result3 = mysqli_query($link, $query3) or die("Ошибка " . mysqli_error($link));
   $row1 = mysqli_fetch_assoc($result3);
	 $col=$row1['ColClass'];
	 
	 return $col;
}
function ColUserSchoolNOdiag(){
	global $idschool;
 global $link;
	global $currentyear;
	$query3 = "SELECT count(id) AS ColClass FROM user u  WHERE u.checkend=0 AND u.id_school='$idschool' AND u.yearcreate='$currentyear'";
  $result3 = mysqli_query($link, $query3) or die("Ошибка " . mysqli_error($link));
   $row1 = mysqli_fetch_assoc($result3);
	 $col=$row1['ColClass'];
	 
	 return $col;
}
function ColUserdiag(){
	global $idschool;
 global $link;
	global $currentyear;
	$query3 = "SELECT count(id) AS ColClass FROM user u where u.id_school='$idschool' AND u.yearcreate='$currentyear'";
  $result3 = mysqli_query($link, $query3) or die("Ошибка " . mysqli_error($link));
   $row1 = mysqli_fetch_assoc($result3);
	 $col=$row1['ColClass'];
	 
	 return $col;
}





//таблица
function CheckClass($id,$col){
	$idschool =$_SESSION['choosenschool'];
	$col1=$col;
	global $currentyear;
	$link = mysqli_connect("localhost", "root", "root123bai", "test")
    or die("Ошибка " . mysqli_error($link));
	$bdclass="AND u.id_school='$idschool' AND u.class='$id' AND u.yearcreate='$currentyear'";
	//$bdclass.=$id;
	//$bdclass="'";
	$CheckTypeBD="SELECT count(*) AS typeA, 
(SELECT count(*) FROM user u WHERE u.test_type = 'B' AND u.checkend=1 $bdclass) AS typeB, 
(SELECT count(*) FROM user u WHERE u.test_type ='C' AND u.checkend=1 $bdclass) AS typeC
FROM user u WHERE u.test_type = 'A' AND u.checkend=1 $bdclass;";
		    $resulCheckTypeBD = mysqli_query($link, $CheckTypeBD) or die("Ошибка " . mysqli_error($link));
			$row11 = mysqli_fetch_assoc($resulCheckTypeBD);
	$typeA=$row11['typeA'];	  	
	$typeB = $row11['typeB'];
	 $typeC = $row11['typeC'];
		if ($typeA!=0){
			
			$CheckA="SELECT count(answeruser.id_question) AS typeA from answeruser,user u where answeruser.id_user=u.id AND u.id_school=$idschool AND u.class='$id' AND u.yearcreate='$currentyear'";
		    $resulCheckA = mysqli_query($link, $CheckA) or die("Ошибка " . mysqli_error($link));
			$coluser = mysqli_fetch_assoc($resulCheckA);
	$coluserA=$coluser['typeA'];	  	
			if ($coluserA !=$typeA*110){$count.="<span style='color:red'>НЕВЕРНО1</span>";}else{$count.="<span style='color:green'>Верно</span>";}
			
		}
if ($typeB!=0){
			
			$CheckB="SELECT count(answeruser.id_question) AS typeB from answeruser,user u where answeruser.id_user=u.id AND u.id_school=$idschool AND u.class='$id' AND u.yearcreate='$currentyear'";
		    $resulCheckB = mysqli_query($link, $CheckB) or die("Ошибка " . mysqli_error($link));
			$coluser = mysqli_fetch_assoc($resulCheckB);
	$coluserB=$coluser['typeB'];	  	
			if ($coluserB != $typeB*140){$count.="<span style='color:red'>НЕВЕРНО2</span>";}else{$count.="<span style='color:green'>Верно</span>";}
			
		}	
if ($typeC!=0){
			
			$CheckC="SELECT count(answeruser.id_question) AS typeC from answeruser,user u where answeruser.id_user=u.id AND u.id_school=$idschool AND u.class='$id' AND u.test_type='C' AND u.yearcreate='$currentyear'";
		    $resulCheckC = mysqli_query($link, $CheckC) or die("Ошибка " . mysqli_error($link));
			$coluser = mysqli_fetch_assoc($resulCheckC);
	$coluserC=$coluser['typeC'];	  	
			if ($coluserC !=$typeC*140){$count.="<span style='color:red'>НЕВЕРНО2</span>";}else{$count.="<span style='color:green'>Верно</span>";}
			
		}			
			
return $count;

}

function NameSchool(){
	$link = mysqli_connect("localhost", "root", "root123bai", "test")
    or die("Ошибка " . mysqli_error($link));
	$id_school= $_SESSION['choosenschool'];
	$query3 = "SELECT s.name_school AS ColClass,checkend FROM school  s  WHERE s.id_school =  $id_school;";
  $result3 = mysqli_query($link, $query3) or die("Ошибка " . mysqli_error($link));
   $row1 = mysqli_fetch_assoc($result3);
	 $col=$row1['ColClass'];
	 $choosenschoolname=$row1['ColClass'];
	 $_SESSION['choosenschoolname']=$choosenschoolname;
	 			$checkstat=$row1['checkend'];
			if ($checkstat==0){$status="<span style = 'color:orange'>подготовка</span>";}
			if ($checkstat==1){$status="<span style = 'color:blue'>тестирование</span>";}
			if ($checkstat==2){$status="<span style = 'color:green'>закончено</span>";}
	 
	$output=" <h2 align = center>Мониторинг тестирования: $col</H2>
<h2 align = center>Статус: $status</H2>";
	 
	 
	 
	 return $output;
}
function checkSchool($id,$schoolORclass){
	global $currentyear;
	$a=$id;
	$b=$schoolORclass;
	$idschool = $_SESSION['choosenschool'];
	 $link = mysqli_connect("localhost", "root", "root123bai", "test")
    or die("Ошибка " . mysqli_error($link));
	$sql1="SELECT c.checkend from class c where c.name_class='$a' AND id_school=$idschool AND c.yearcreate='$currentyear' ";
	$query1 = mysqli_query($link, $sql1) or die("Ошибка " . mysqli_error($link));
	

$check;

	 $row2 = mysqli_fetch_assoc($query1);
	 $row1=$row2['checkend'];
	 if ($row1==0){
	$check="<span style='color:blue'>В процессе</span>";
	 }else{
		 
		 
		 $check="<span style='color:green'>Закончено</span>";}

	// $sql2="SELECT * from user where  $b='$a'";
	// $query2 = mysqli_query($link, $sql2) or die("Ошибка " . mysqli_error($link));
	// $count1 = mysqli_num_rows($query2);
 // if( $count1 > 0 ) {$check="<span style='color:green'>Закончено</span>";} else {$check="<span style='color:red'>Класс пуст</span>";};
	
	return $check;
}

//переписать
function checkCol($id,$class){
	global $currentyear;
$a=$id;
$b=$class;
$link = mysqli_connect("localhost", "root", "root123bai", "test")
    or die("Ошибка " . mysqli_error($link));
$query3 = "SELECT Colvsego AS Col, 
	 
(SELECT count(*) FROM user u WHERE u.id_school = $a AND u.checkend=1 AND u.class='$b' AND u.yearcreate='$currentyear') AS Endtest
FROM class s  WHERE s.id_school =  $a AND s.name_class='$b' AND s.yearcreate='$currentyear' ;";
  $result3 = mysqli_query($link, $query3) or die("Ошибка " . mysqli_error($link));
   $row1 = mysqli_fetch_assoc($result3);
	 $_SESSION['Col']=$row1['Col'];
	 $_SESSION['Endtest']=$row1['Endtest'];
	
}

function getResultClass () {


	// Подключаемся к СУБД MySQL
	global $currentyear;
	 $link = mysqli_connect("localhost", "root", "root123bai", "test")
    or die("Ошибка " . mysqli_error($link));
	// Выбираем всех производителей из таблицы
	//$idschool=$_SESSION['idschool'];
	$sProducerId = $_SESSION['choosenschool'];
	
	
	
	// Строка запроса из базы данных
	
	 $sql = "SELECT s.name_school,c.checkend, c.name_class,c.end_time,c.checkobrabotka FROM school s, class c where c.id_school= '" . $sProducerId . "' AND c.yearcreate='$currentyear' AND s.id_school= '" . $sProducerId . "'ORDER BY LPAD(name_class, 10, '0')";
	
	// Выполняем запрос
	
	$query = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link));
	//$query1 = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link));
	// Поместим данные, которые будет возвращать функция, в массив
	// Пока что он будет пустым
	$rows = mysqli_num_rows($query); // количество полученных строк
    $field = mysqli_num_fields($query);
	$array ;
	$output_string .= "<table id='table' class='simple-little-table' cellspacing='0'>";
	$output_string .=" <thead><tr>
		
		<th>Класс</th>
		<th>Всего</th>
		<th>Протестировано</th>
		<th>Статус</th>
		<th>Время окончания</th>
		<th>Совпадение вопросов</th>
		 <th><p>Выбрать всех</p><input type='checkbox' id = 'chckHead' value='all' onclick='checkAll(this)'/></th>

	 </tr></thead>
	
	 <tbody id='t_body'>";
	// Инициализируем счетчик
	$bdiduser;
 for ($i = 0 ; $i < $rows ; ++$i)
    {
        $row = mysqli_fetch_row($query);
		$clas=$row[2];
	$output_string .="<div class='dropdown'>";
		  $output_string .= "<tr id='rowtable' class='rowlink' title='Нажмите на строку для вызова меню взаимодествия с классом'>";
		 //$output_string .=" <div id='myDropdown' class='dropdown-content'><a href='#home'>Home</a><a href='#about'>About</a><a href='#contact'>Contact</a></div></div>";
            for ($j = 2 ; $j < $field-2 ; ++$j) {
				$output_string .= "<td class='item'>$row[$j]</td>";
			}
			//$row1 = mysqli_fetch_assoc($query);
           //$a=$row[0];
		  
		  
		   //$cla=CheckClass($row[2]);
		   
		   $b=checkCol($sProducerId,$row[2]);
		   $col= $_SESSION['Col'];
		   $end= $_SESSION['Endtest'];
		   $output_string .= "<td class='item2'>$col</td>";
		   $output_string .= "<td class='item3'>$end</td>";
			$a=checkSchool($row[2],"class");
			$cla=CheckClass($row[2],$_SESSION['Col']);
			$id=$row[2];
			$checkendclass=$row[1];
$checkobrabotkaclass=$row[4];
			if ($checkobrabotkaclass==1){$a="<span style='color:orange'>Обработано</span>";$bool="disabled";}
			if ($checkobrabotkaclass==0){$bool="";}
			if ($checkendclass==1){$boolvozob="";}
			if ($checkendclass==0){$boolvozob="disabled";}
			$clas=$row[2];
			$timeend=$row[3];
			$output_string .= "<td class='item4'>$a</td>";
			$output_string .= "<td class='item5'>$timeend</td>";
			$output_string .= "<td class='item6'>$cla</td>";
			$output_string .=" <div id='$clas' class='dropdown-content'><p> Действия с классом: $clas </p>
			<p>&nbsp;</p>
			<div class='kek'><button name='choosenclass' class='posmotret' value='$clas' type='submit'>Посмотреть</button></div>
			<p>&nbsp;</p>
			<div class='kek'><button name='choosenclassanaliz' class='posmotret' value='$clas' type='submit'>Анализ</button></div></p>
			<p>&nbsp;</p>
			<button name='choosenclassvozobnovit' class='vozobnov' value='$clas' $boolvozob type='submit'>Возобновить</button>
			<p>&nbsp;</p>
			<button name='choosenclasszakonchit' class='posmotret1' value='$clas' type='submit'>Закончить</button>
			<p>&nbsp;</p>
			<button name='choosenclassedit' class='obrabotano' value='$clas' $bool type='submit'>Изменить</button>
			<p>&nbsp;</p>
			<button name='deleteclass' value='$id' class='posmotret1'onclick='return proverka(this.value);' type='button'>Удалить</button>
			<p>&nbsp;</p>
			</div>";
			//$output_string .= "<td class='item7'><div class='kek'><button name='choosenclass' class='posmotret' value='$clas' type='submit'>Посмотреть</button></div><p>&nbsp;</p><div class='kek'><button name='choosenclassanaliz' class='posmotret' value='$clas' type='submit'>Анализ</button></div></p><p>&nbsp;</p><button name='choosenclassvozobnovit' class='vozobnov' value='$clas' $boolvozob type='submit'>Возобновить</button><p>&nbsp;</p><button name='choosenclassobrabotano' class='obrabotano' value='$clas' $bool type='submit'>Обработано</button><p>&nbsp;</p><button name='deleteclass' value='$id' class='posmotret1'onclick='return proverka();' type='submit'>Удалить</button> </td>";
			//$output_string .= "<td><button name='end' class='posmotret' value='$clas' type='submit'>Закончить тестирование</button></td>";
				//$output_string .= "<td><input name ='box[]' type='checkbox' class='chcktbl' value='$id'></td>";
        		//$output_string .= "<td><button name='deleteuser' value='$id' class='posmotret1'onclick='return proverka();' type='submit'>Удалить</button></td>";
		$output_string .= "<td class='item7'><input name ='box[]' type='checkbox' class='chcktbl' value='$id'></td>";
		$output_string .= "</tr></div>";
    }
	
	// Возвращаем вызову функции массив с данными
 $output_string .= "</tbody>";
	$array [ 0 ][ 'id_school' ]= $output_string;
return $output_string;
}
?>

<html >
<head>
<script src="../../js/jquery-3.4.1.js"></script>
 <!-- Resources -->
<script src="../../amcharts4/core.js"></script>
<script src="../../amcharts4/charts.js"></script>
<script src="../../amcharts4/themes/animated.js"></script>
<script src="../../amcharts4/lang/ru_RU.js"></script>
<link rel="stylesheet" type="text/css" href="../../js/tooltipster-master/dist/css/tooltipster.bundle.min.css" />
<script type="text/javascript" src="../../js/tooltipster-master/dist/js/tooltipster.bundle.min.js"></script>
<script src="../../js/tooltipster-master/dist/js/tooltipster.bundle.js"></script>
<script src="../../js/sweetalert.js"></script>
<script type="text/javascript" src="../../js/jquery.cookie.js"></script>
<link rel="stylesheet" href="../../css/prog.css">
<script type="text/javascript">
$(window).on('load', function () {
	 
      $('.preloader').fadeOut().delay(400).fadeOut('slow');
    });

	
	$(document).ready(function(){
            $("#search").keyup(function(){
                _this = this;
                $.each($("#table tbody tr"), function() {
                    if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                       $(this).hide();
                    else
                       $(this).show();                
                });
            });
			
			
			
			
			$(function() {
$('.tooltipster').tooltipster({
	contentAsHTML:'true',
 maxWidth: '300',
 side: 'bottom',
 theme:'light' 
});
 
});
	$(function() {
$('.rowlink').tooltipster({
	contentAsHTML:'true',
 maxWidth: '300',
 side: 'bottom',
 theme:'light' 
});
 
});

$(function() {
$('#mydivheader').tooltipster({
	contentAsHTML:'true',
 maxWidth: '300',
 side: 'top',
 theme:'light' 
});
 
});


//границы плавающее окно
 
//Make the DIV element draggagle:
dragElement(document.getElementById(("mydiv")));

function dragElement(elmnt) {
  var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
  if (document.getElementById(elmnt.id + "header")) {
    /* if present, the header is where you move the DIV from:*/
    document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
  } else {
    /* otherwise, move the DIV from anywhere inside the DIV:*/
    elmnt.onmousedown = dragMouseDown;
  }

  function dragMouseDown(e) {
    e = e || window.event;
    // get the mouse cursor position at startup:
    pos3 = e.clientX;
    pos4 = e.clientY;
    document.onmouseup = closeDragElement;
    // call a function whenever the cursor moves:
    document.onmousemove = elementDrag;
  }

  function elementDrag(e) {
    e = e || window.event;
    // calculate the new cursor position:
    pos1 = pos3 - e.clientX;
    pos2 = pos4 - e.clientY;
    pos3 = e.clientX;
    pos4 = e.clientY;
    // set the element's new position:
    elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
    elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
	var topgran=(elmnt.offsetTop - pos2) + "px";
	var leftgran=(elmnt.offsetLeft - pos1) + "px";
	$.cookie('topgran', topgran);
	$.cookie('leftgran', leftgran);
  }

  function closeDragElement() {
    /* stop moving when mouse button is released:*/
    document.onmouseup = null;
    document.onmousemove = null;
	
  }
}
	//границы плавающее окно  
   	  
	  
//нажатие закрыть окно выборки классов
  $('#close').click(function(){
   // alert('закрыть');
   
   
   var span = document.createElement("span");
span.innerHTML = "Список классов/групп будет <span style = 'color:red'>очищен</span>";
      
      event.preventDefault();
	 // alert("Класс ${nameclass} будет удален!");
	  swal({
  title: "Вы уверены?",
content:span,
  icon: "warning",
 buttons: ["Нет!", "Да, закрыть окно"],
 closeOnClickOutside: false,
			allowOutsideClick: false,
			closeOnEsc: false,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
    
 //$('#mydiv').hide(); 
 $('#close').hide(); 
  $('.arrow-4').hide(); 
  $('#rasschet').hide(); 
$('#mydiv').css('visibility', 'hidden');
$("#t_bodygran").empty();
if (typeof $.cookie('bodymydivtoggle') !== 'undefined') {
   $.cookie('bodymydivtoggle', 1);
}

$.post("gran.php", { ExitGran: 1 })
.done(function(data) {
 // alert("Data Loaded: " + data);
 //location.reload();
});
 

  } else {
   /*  swal("Список не очищен",{
		closeOnClickOutside: false,
			allowOutsideClick: false,
	closeOnEsc: false,}
	); */
	
  }
});
   
   
   
   
   
   
   
   
   
   
   
   
  
})

//свернуть
 $("#arrowhide").click(function () {
  //    $('#bodymydiv').slideToggle("hide");
  $('#bodymydiv').slideToggle(300);  
   var display = $('#bodymydiv').css("display");
   
   if (typeof $.cookie('bodymydivtoggle') == 'undefined') {
   $.cookie('bodymydivtoggle', 1);
}
   
   
 if (  $.cookie('bodymydivtoggle')==1){ $.cookie('bodymydivtoggle', 0);}else{ $.cookie('bodymydivtoggle', 1);}
 
//alert(display);
 
    });


$(".arrow-4").click(function() {
    $(this).toggleClass("open");
});

//клик на кнопку рассчитать внутри майдива
/* $("#rasschet").click(function() {
   alert();
}); */



//клик на кнопку рассчитать границы
	$('#addgranclass').click(function(){
  
   
   
   
   var a = !!document.querySelector(".chcktbl:checked");

    if (a==true){
		$("#addgranclass").prop('disabled', true);
		//$('#mydiv').show();
		
		var arr = [];
    $('table tbody tr').each(function () {
        if ($('input:checked', this).length) {
            arr.push($(this).find('td:eq(0)').text());
        }
    });

	//добавляем классы в обработку
	$.post("gran.php", { addClassGran: arr })
.done(function(data) {
// alert("Data Loaded: " + data);
 
 $("#t_bodygran").empty();
  $("#t_bodygran").append(data);
  var ClassesGranCount=$.cookie('ClassesGranCount');
   var UsersGranCount=$.cookie('UsersGranCount');
//обновление шапки(количества)
//классы
$("#colgranclass").empty();
  $("#colgranclass").append("Количество классов/групп: "+ClassesGranCount);
  //юзеры
  $("#colgranuser").empty();
  $("#colgranuser").append("Количество тестируемых: "+UsersGranCount+" чел.");
  
//скролл вниз
let elem = document.querySelector('#tablegrandiv');
console.log(elem.scrollHeight);
elem.scrollTop = elem.scrollHeight;
 
 $('#rasschet').show();
 $('#close').show(); 
  $('.arrow-4').show(); 
 $('#mydiv').css('visibility', 'visible');
 //console.log('пост успешно');
 $("#addgranclass").prop('disabled', false);
});
	
	
		console.log(arr);
		
	
	
	
	
	}else{
		
		 var span = document.createElement("span");
span.innerHTML = "Выберите хотя бы один класс/группу для вычисления границ!";
	
	 swal({

			title: "Ошибка!",
			content:span,
			icon: "warning",
			closeOnClickOutside: false,
			allowOutsideClick: false,
			closeOnEsc: false,
			button: "Понятно!"

});
		
	}

})

var ClassesGranTable="<?=$_SESSION['ClassesGranTable'];?>";
var ClassesGranCount="<?=$_SESSION['ClassesGranCount'];?>";
var UsersGranCount="<?=$_SESSION['UsersGranCount'];?>";
//обновление шапки(количества)
//классы
$("#colgranclass").empty();
  $("#colgranclass").append("Количество классов/групп: "+ClassesGranCount);
  
  //тестируемые
  $("#colgranuser").empty();
  $("#colgranuser").append("Количество тестируемых: "+UsersGranCount+" чел.");
  
//обновление таблицы
 $("#t_bodygran").empty();
  $("#t_bodygran").append(ClassesGranTable);
  
  var ClassesGranVisible="<?=$_SESSION['ClassesGranVisible'];?>";
  if (ClassesGranVisible!="hidden;"){
	  
	  var topgran=$.cookie('topgran');
	  var leftgran=$.cookie('leftgran');
	  $('#mydiv').css('top', topgran);
	  $('#mydiv').css('left', leftgran);
  }
  
  if (typeof $.cookie('bodymydivtoggle') !== 'undefined') {
  
  if ($.cookie('bodymydivtoggle')==1){$('#bodymydiv').css('display', 'block');}
  if ($.cookie('bodymydivtoggle')==0){$('#bodymydiv').css('display', 'none');}
}

  
 let elem = document.querySelector('#tablegrandiv');
console.log(elem.scrollHeight);
elem.scrollTop = elem.scrollHeight;
        });//document ready
	
	
	
	

	
	
	
	
$(function(){
  $('#t_body').on('click', '.rowlink', function(){
 //  alert($(this).find('.item').html());
  var classname=$(this).find('.item').html();
 // document.cookie = "choosenschoolcook="+schoolname; */
 //alert("нажал на строку");
 
 
  const content = document.querySelector(".dropdown-content")
	content.classList.remove('show');
	
 document.getElementById(classname).classList.toggle("show");

/* if (!event.target.matches('.rowlink')) {

    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  } */
	// location.href = "adminschool1.php";
	 
  });
 
});
// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.item') && !event.target.matches('.item2')
       && !event.target.matches('.item3') && !event.target.matches('.item4')	
       && !event.target.matches('.item5') && !event.target.matches('.item6') 
        && !event.target.matches('.item7')  ) {
	  //alert("нажал вне");
let elements = document.querySelectorAll('.dropdown-content');

  for (let elem of elements) {
    elem.classList.remove('show');
  }
  /* const content = document.querySelector(".dropdown-content")
	content.classList.remove('show'); */
  }
}





function proverka (value){
	var nameclass=value;
var span = document.createElement("span");
span.innerHTML = "Класс/группа <b>"+nameclass+"</b> будет <span style = 'color:red'>удален(а)</span>. Логины и их ответы будут <span style = 'color:red'>удалены</span>.";
      
      event.preventDefault();
	 // alert("Класс ${nameclass} будет удален!");
	  swal({
  title: "Вы уверены?",
content:span,
  icon: "warning",
 buttons: ["Нет!", "Да, удалить класс"],
 closeOnClickOutside: false,
			allowOutsideClick: false,
			closeOnEsc: false,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
    swal("Класс/группа "+ nameclass+" удален(а)!", {
      icon: "success",
	  closeOnClickOutside: false,
			allowOutsideClick: false,
			closeOnEsc: false,
    }).then(function() {



$.post("adminclassschool1.php", { deleteclass: nameclass })
.done(function(data) {
 // alert("Data Loaded: " + data);
 location.reload();
});
 
}); 
  } else {
    swal("Класс/группа "+ nameclass+" не удален(а)!",{
		closeOnClickOutside: false,
			allowOutsideClick: false,
	closeOnEsc: false,}
	);
	
  }
});

}




















function checkAll(obj) {
  'use strict';
  // Получаем NodeList дочерних элементов input формы: 
  var items = obj.form.getElementsByTagName("input"), 
      len, i;
  // Здесь, увы цикл по элементам формы:
  for (i = 0, len = items.length; i < len; i += 1) {
    // Если текущий элемент является чекбоксом...
    if (items.item(i).type && items.item(i).type === "checkbox") {
      // Дальше логика простая: если checkbox "Выбрать всё" - отмечен            
      if (obj.checked) {
        // Отмечаем все чекбоксы...
        items.item(i).checked = true;
      } else {
        // Иначе снимаем отметки со всех чекбоксов:
        items.item(i).checked = false;
      }       
    }
  }
}

function changeLink(id,text) {
	 
      document.getElementById(id).innerHTML=text;
     
      document.getElementById(id).target="_blank";
	  }
	  function sub() {

    var a = !!document.querySelector(".chcktbl:checked");

    a || alert("Выберите хотя бы один класс/группу!");

    return a

};  


document.addEventListener('DOMContentLoaded', () => {

    const getSort = ({ target }) => {
        const order = (target.dataset.order = -(target.dataset.order || -1));
        const index = [...target.parentNode.cells].indexOf(target);
        const collator = new Intl.Collator(['en', 'ru'], { numeric: true });
        const comparator = (index, order) => (a, b) => order * collator.compare(
            a.children[index].innerHTML,
            b.children[index].innerHTML
        );
        
        for(const tBody of target.closest('table').tBodies)
            tBody.append(...[...tBody.rows].sort(comparator(index, order)));

        for(const cell of target.parentNode.cells)
            cell.classList.toggle('sorted', cell === target);
    };
    
    document.querySelectorAll('.simple-little-table thead').forEach(tableTH => tableTH.addEventListener('click', () => getSort(event)));
    
});




am4core.ready(function() {



//2
var colorSet2 = new am4core.ColorSet();
// Create chart instance
var chart2 = am4core.create("chartdiv2", am4charts.PieChart);
let title2 = chart2.titles.create();
title2.text = "Ученики";
title2.fontSize = 20;
title2.marginBottom = 5;
// Add data
chart2.data = [ {
   "country": "НЕ приступили",
  "litres": <?=ColUserSchoolNOdiag();?>
}, {
  "country": "Закончили",
  "litres": <?=ColUserSchoolENDdiag();?>,
  
} ];

// Set inner radius
chart2.innerRadius = am4core.percent(40);

// Add label

var label2 = chart2.seriesContainer.createChild(am4core.Label);
label2.text = <?=ColUserdiag();?>;
label2.horizontalCenter = "middle";
label2.verticalCenter = "middle";
label2.fontSize = 30;

// Add and configure Series
var pieSeries2 = chart2.series.push(new am4charts.PieSeries());
pieSeries2.dataFields.value = "litres";
pieSeries2.dataFields.category = "country";


// This creates initial animation
pieSeries2.hiddenState.properties.opacity = 1;
pieSeries2.hiddenState.properties.endAngle = -90;
pieSeries2.hiddenState.properties.startAngle = -90;

colorSet2.list = ["#ff0000","#008000"].map(function(color) {
  return new am4core.color(color);
});
pieSeries2.colors = colorSet2;



//3
var colorSet3 = new am4core.ColorSet();
// Create chart instance
var chart3 = am4core.create("chartdiv3", am4charts.PieChart);
let title3 = chart3.titles.create();
title3.text = "Классы";
title3.fontSize = 20;
title3.marginBottom = 5;
// Add data
chart3.data = [ {
   "country": "НЕ закончили",
  "litres": <?=ColClassSchoolNOdiag();?>
}, {
  "country": "Закончили",
  "litres": <?=ColClassSchoolENDdiag();?>,
  
} ];

// Set inner radius
chart3.innerRadius = am4core.percent(40);

// Add label

var label3 = chart3.seriesContainer.createChild(am4core.Label);
label3.text = <?=ColClassdiag();?>;
label3.horizontalCenter = "middle";
label3.verticalCenter = "middle";
label3.fontSize = 30;

// Add and configure Series
var pieSeries3 = chart3.series.push(new am4charts.PieSeries());
pieSeries3.dataFields.value = "litres";
pieSeries3.dataFields.category = "country";


// This creates initial animation
pieSeries3.hiddenState.properties.opacity = 1;
pieSeries3.hiddenState.properties.endAngle = -90;
pieSeries3.hiddenState.properties.startAngle = -90;

colorSet3.list = ["#ff0000","#008000"].map(function(color) {
  return new am4core.color(color);
});
pieSeries3.colors = colorSet3;
}); // end am4core.ready()

//голова таблицы

function FixTable(table) {
	var inst = this;
	this.table  = table;
 
	$('tr > th',$(this.table)).each(function(index) {
		var div_fixed = $('<div/>').addClass('fixtable-fixed');
		var div_relat = $('<div/>').addClass('fixtable-relative');
		div_fixed.html($(this).html());
		div_relat.html($(this).html());
		$(this).html('').append(div_fixed).append(div_relat);
		$(div_fixed).hide();
	});
 
	this.StyleColumns();
	this.FixColumns();
 
	$(window).scroll(function(){
		inst.FixColumns()
	}).resize(function(){
		inst.StyleColumns()
	});
}
 
FixTable.prototype.StyleColumns = function() {
	var inst = this;
	$('tr > th', $(this.table)).each(function(){
		var div_relat = $('div.fixtable-relative', $(this));
		var th = $(div_relat).parent('th');
		$('div.fixtable-fixed', $(this)).css({
			'width': $(th).outerWidth(true) - parseInt($(th).css('border-left-width')) + 'px',
			'height': $(th).outerHeight(true) + 'px',
			'left': $(div_relat).offset().left - parseInt($(th).css('padding-left')) + 'px',
			'padding-top': $(div_relat).offset().top - $(inst.table).offset().top + 'px',
			'padding-left': $(th).css('padding-left'),
			'padding-right': $(th).css('padding-right')
		});
	});
}
 
FixTable.prototype.FixColumns = function() {
	var inst = this;
	var show = false;
	var s_top = $(window).scrollTop();
	var h_top = $(inst.table).offset().top;
 
	if (s_top < (h_top + $(inst.table).height() - $(inst.table).find('.fixtable-fixed').outerHeight()) && s_top > h_top) {
		show = true;
	}
 
	$('tr > th > div.fixtable-fixed', $(this.table)).each(function(){
		show ? $(this).show() : $(this).hide()
	});
}








function checktype() {
	     var test_type;
$.post("gran.php", { checktype: 1 })
.done(function(data) {
 // alert("Data Loaded: " + data);
   test_type=data;
 //console.log(data);
alert(test_type);
return test_type;
});

}

//нажатие кнопки рассчитать
function ls_ajax_test() {
	var test_type;
	$.post("gran.php", { checktype: 1 })
.done(function(data) {
 // alert("Data Loaded: " + data);
   test_type=data;


	if (test_type!="none"){
        /**
         * Переменная интервала.
         * Будем запускать функцию опроса результата прогресса каждую секунду
         * @type object
         */
		 	$('.popup-fade').fadeIn();
        var myVar = setInterval(function() {
            ls_ajax_progress();
        }, 1000);
 
        /**
         * Выполняем AJAX запрос к скрипту эмуляции
         */
        $.ajax({
            type: 'POST',
            url: 'gran.php',
			data: {rasschet: '1'},
            success: function(data) {
                /**
                 * По завершению работы скрипта эмуляции останавливаем таймер 
                 * опроса прогресса
                 * @returns {Boolean}
                 */
                clearInterval(myVar);
 
                /**
                 * В результирующий тег пишем результат
                 * @returns {Boolean}
                 */
				 //закончено
				// alert('theEnd');
                //$('#progress').html('DONE');
				
				$(location).attr('href','viewgran.php');
            },
        });
 
        /**
         * На всякий случай вернем FALSE
         * @returns {Boolean}
         */
        return false;
	}else{
		console.log(data);
		var span = document.createElement("span");
span.innerHTML = "Тип теста у классов должен быть одинаковым!";
	
	 swal({

			title: "Ошибка!",
			content:span,
			icon: "warning",
			closeOnClickOutside: false,
			allowOutsideClick: false,
			closeOnEsc: false,
			button: "Понятно!"

});
	}
	
	
	});

	
    }
	
	
	
	
    function ls_ajax_progress() {
        /**
         * Выполняем AJAX запрос к скрипту опроса результата прогресса
         * @returns {Boolean}
         */
        $.ajax({
            type: 'POST',
            url: 'test_progress.php',
            success: function(data) {
                /**
                 * В реультирующий тег пишем то, что вернул скрипт
                 */
                //$('#progress').html(data);
          // console.log(data);
document.querySelector('progress').value = data;
$('#percentbar').css('width', data+'%');

$("#percentbar").data("value", data);
//alert($("#percentbar").data("value"));
  //console.log($("#percentbar").data("value", data));

  
$('#percentbar').attr( 'data-value', data );


		   },
        });
 
        /**
         * На всякий случай вернем FALSE
         * @returns {Boolean}
         */
        return false;
    }








</script>
<style>
.extremum-slide {
	border:1px solid;
	padding:50px;
}
.dropdown {
	float: right;
    position: relative;
    display: inline-block;
}

.dropdown-content {
	align:center;
	right:0;
    display: none;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 180px;
	max-width: 400px;
    overflow: auto;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown a:hover {background-color: #ddd;}

.show {display: block;}
.kek
{
       display: inline-block;
	   margin: auto 5px;
}
.container1 {
     width: 100%;
  overflow: auto;
 height: 30vh;
  -moz-user-select: none;
    -webkit-user-select: none;
    -ms-user-select: none;
    -o-user-select: none;
    user-select: none;
}

.containertablegrandiv{
	  width: 100%;
	   	height:350px;
  overflow: auto;

  -moz-user-select: none;
    -webkit-user-select: none;
    -ms-user-select: none;
    -o-user-select: none;
    user-select: none;
}
.exitright{

    width: 150px; 
     
    position: fixed; 
    top:10px; 
    right:0; 
	
}
th.sorted[data-order="1"],
th.sorted[data-order="-1"] {
   
}

th.sorted[data-order="1"]::after,
th.sorted[data-order="-1"]::after {
    right: 8px;
   
}

th.sorted[data-order="-1"]::after {
	content: "▼"
}

th.sorted[data-order="1"]::after {
	content: "▲"
}
</style>
<link rel="shortcut icon" href="../../icon.ico" type="image/x-icon">

<!-- Прелоадер -->
  <div class="preloader">
    <div class="preloader__row">
      <div class="preloader__item"></div>
      <div class="preloader__item"></div>
    </div>
  </div>
 
  <title>Мониторинг тестирования </title>
  
  
  
      <link rel="stylesheet" href="../../css/adminstyleclassschool.css">

  
</head>

<body>

<body {
section {position: absolute;
        top: 50%;
        left: 50%;
        margin-right: -50%;
        transform: translate(-50%, -50%) }}
><p>&nbsp;</p> 
<div class="popup-fade">
		<div class="popup">
	<div id="progress" style="width: 350px;">
<h4 align="center">Вычисление...</h4>
<p>&nbsp;</p> 
<p>&nbsp;</p> 
 <p id="percentbar" style="width:0%" data-value="0"></p>
	<progress id="progressBar" max="100" value="0" class="php"></progress>
   </div>
</div>
</div>
<div id="mydiv" style="visibility: <?=$_SESSION['ClassesGranVisible'];?>">
  <div id="mydivheader" title="Зажмите чтобы перетащить">Определение границ
  <div class="arrow-4" id="arrowhide">
    <span class="arrow-4-left"></span>
    <span class="arrow-4-right"></span>
</div>
  <div id="close" class="cl-btn-2">
    <div>
        <div class="leftright"></div>
        <div class="rightleft"></div>
        <span class="close-btn">закрыть</span>
    </div>
</div></div>
<div id="bodymydiv">
  <p>&nbsp;</p>
  <span id="colgranclass"></span> <span id="colgranuser"></span>
  <p>&nbsp;</p>
  <div id="tablegrandiv" class="containertablegrandiv">
  <table id='tablegran' class='simple-little-table' cellspacing='0'>
	<thead><tr>
		
		<th>Район</th>
		<th>Школа</th>
		<th>Класс</th>
		<th>Тип</th>

	 </tr></thead>
	
	 <tbody id='t_bodygran'>
	
	
</tbody>
</table>
  </div>
 
 <a id="rasschet"  class="blubtn" onclick="return ls_ajax_test();
        return false;" >Рассчитать</a>
  </div>
</div>
<?=NameSchool();?>

<div class="container">
	<section id="content">
		<form name="form"  action="adminclassschool1.php" method="post"   enctype="multipart/form-data">
			<div align = center> 
			<p>
<p><span style='color:red' id='checkage'></span></p>
</p>
<div class="kek">
<input type="button"  class="knopki" Value="Назад в район" onclick=" document.location.replace('adminschool.php');">
</div>
<div class="kek">
<input type="submit" name="print" value="Распечатать ответы" onClick="return sub()">
</div>
<div class="kek">
<input type="submit" name="printempty" value="Скачать без формул" onClick="return sub()">
</div>
<div class="kek">
<input type="button" id="addgranclass" name="addgranclass" value="Рассчитать границы" class ="granbutton" >
</div>
		
		<div id="chartdiv3" style="height:220px;width:460px;display: inline-block;margin-left:5px;"></div>
		
		<div id="chartdiv2" style="height:220px;width:480px;display: inline-block;margin-left:5px;"></div>

<hr>
	
</hr>
<span style='color:red' id='check'></span>
<input type="text"  id="search" placeholder="Поиск по таблице" style="height:10px;" class="tooltipster" autocomplete="off" title='Введите класс для поиска'>
				<div id="table1" class="container1">
				<?=getResultClass();?>
				</div> 
</div>
<div align="center" >


</div>

		</form><!-- form -->
		
	</section><!-- content -->
</div><!-- container -->
<p>&nbsp;</p> 
<div class="exitright">
<input type="button" class="button4" Value="Выход" onclick=" document.location.replace('../../destroy.php');">
<p>&nbsp;</p> 
<div class="kek">
<input type="button"  type="button" class="button4" Value="Меню " style="background: #fff331f7 linear-gradient(#fff331f7, #c38832);" onclick=" document.location.replace('../admin.php');">
</div>
</div>
</div>
</body>
</html> 
</body>
</html>
