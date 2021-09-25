 <?php 
echo '<option>Select Time</option>';

include 'init.php';

// Get Start and End Time 
$gYear  = $_GET['year'];
$gMonth = $_GET['month'];
$gDay   = $_GET['day'];

$workTime = superGet( '*','providers_pranch', 'P_Pranch_ID = 1 '); 
$startTime =  $workTime[0]['Start_Time'];
$endTime =  $workTime[0]['End_Time'] ; 

    $duration =  15 ; // '+15 minutes' ; 

$startH = (int)date("H", strtotime($startTime)) ;
$startM = (int)date("i", strtotime($startTime)) ;
$endH =   (int)date("H", strtotime($endTime)) ;
$endM =   (int)date("i", strtotime($endTime)) ; 

// Get the all appoitments in open deuration
$times = getTimes($startH,$startM,$endH,$endM,15);

// Check if th appoitment is available 
$appoitments = superGet('*', 'appointment'," YEAR(`Start_Time`) ='".$gYear."' AND MONTH(`Start_Time`) ='".$gMonth."' AND DAY(`Start_Time`) ='".$gDay."'");    // ** filter the day 
foreach($appoitments as $appoitment){
    
  $aYear =  explode(':',$appoitment['Start_Time'])[0] ;
  $aMonth = explode(':',$appoitment['Start_Time'])[1] ;
  $aDay =   explode(':',$appoitment['Start_Time'])[2] ;
  $aHour =  explode(':',$appoitment['Start_Time'])[3] ;
  $aMinut = explode(':',$appoitment['Start_Time'])[4] ;


  foreach($times as $key => $time ){
      $tHour  = explode(':', $time)[0];
      $tMinut = explode(':', $time)[1];

      if($tHour == $aHour && $tMinut == $aMinut){
          unset($times[$key]);
      }
  }

}// end foreach Appoitments 

foreach($times as $time){
echo('<option value ="'.$time.'">'.$time.'</option>');
}

include  $tpl . "footer.php";
?>