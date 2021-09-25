<?php 

ob_start();
session_start();

$pageTitle = 'A to Z 4 All | E-commerce Portal';
    
include 'init.php';



$times = getTimes(9,10,21,30,15) ; 

$apps = superGet('Start_Time', 'appointment') ; 

print_r($times);
echo('<br>   - - - - - -  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - <br>');
print_r($apps);
echo('<br>   - - - - - -  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - <br>');

foreach($apps as $app){
    $H = explode(':',$app['Start_Time'])[3];
    $M = explode(':',$app['Start_Time'])[4];
    echo('From DB : '.$H. '-'.$M.'<br>');
    echo('<br>   - - - - - -  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - <br>');
    foreach($times as $key => $value){
        $h = explode(':',$value)[0] ;
        $m = explode(':',$value)[1] ;
        echo('From times : ' . $h.'-'.$m.'<br>');
        
        if( ($H == $h)  && ($M == $m) ){
            unset($times[$key]);
            echo(' Hi ');
        }
    }
}

print_r($times);
  

?>






<?php
include  $tpl . "footer.php";
?>