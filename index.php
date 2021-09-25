<?php 

ob_start();
session_start();
$pageTitle = 'Click & Meet';  
include 'init.php';
?>

<div class="container" >    
    <div class="row">
        <div class="col col-md-5">
            <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                <div class="col-md-8 col-md-offset-2">
                    <input class="form-control"  id="selected_day"  name="selected_day" type="hidden" >
                    <input class="form-control"  id="selected_month" name="selected_month" type="hidden" >
                    <input class="form-control"  id="selected_year"  name="selected_year" type="hidden" >
                    <input class="form-control"  id="selected_h"  name="selected_h" type="hidden" >
                    <input class="form-control"  id="selected_m"  name="selected_m" type="hidden" >
                </div>
            
                <div class="col-md-8 col-md-offset-2">
                    <label >Time</label>
                    <select class="form-control" onchange="updateTime(value)" id="tim_list" >

                    </select>
                </div>
                
                <div class="col-md-8 col-md-offset-2">
                    <label >Name</label>
                    <input class="form-control" type="text" name="name" placeholder="Name"  required >
                </div>
                
                <div class="col-md-8 col-md-offset-2">
                    <label >Email</label>
                    <input class="form-control" type="email" name="email" placeholder="Email"  required >
                </div>
                
                <div class="col-md-8 col-md-offset-2">
                    <label >Phone</label>
                    <input class="form-control" type="tel" name="tel" placeholder="Phone"  required >
                </div>
                
                <div class="col-md-8 col-md-offset-2">
                    <input  class="form-control" type="submit"  value="save " >
                </div>
            </form>
        </div>
         
        
        <!-- Start Calander -->
        <div class="col col-md-7">
            <div class="elegant-calencar d-md-flex">
						<div class="wrap-header d-flex align-items-center">
				      <p id="reset">reset</p>
			        <div id="header" class="p-0">
		            <div class="pre-button d-flex align-items-center justify-content-center"><i class="fa fa-chevron-left"></i></div>
		            <div class="head-info">
		                <div class="head-day"></div>
		                <div class="head-month"></div>
		            </div>
		            <div class="next-button d-flex align-items-center justify-content-center"><i class="fa fa-chevron-right"></i></div>
			        </div>
			      </div>
			      <div class="calendar-wrap">
			        <table id="calendar">
		            <thead>
		                <tr>
		                    <th>Sun</th>
		                    <th>Mon</th>
		                    <th>Tue</th>
		                    <th>Wed</th>
		                    <th>Thu</th>
		                    <th>Fri</th>
		                    <th>Sat</th>
		                </tr>
		            </thead>
		            <tbody>
	                <tr>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                </tr>
	                <tr>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                </tr>
	                <tr>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                </tr>
	                <tr>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                </tr>
	                <tr>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                </tr>
	                <tr>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                </tr>
		            </tbody>
			        </table>
			      </div>
			    </div>
        </div>
        <!-- End Calander -->
        
    </div>
</div>

<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
    $name = isset($_POST['name']) ? $_POST['name'] : 'NULL';
    $email = isset($_POST['email']) ? $_POST['email'] : 'NULL';
    $tel = isset($_POST['tel']) ? $_POST['tel'] : 'NULL';
    
    $year =  isset($_POST['selected_year']) ? $_POST['selected_year'] : 'NULL';
    $month = isset($_POST['selected_month']) ? $_POST['selected_month'] : 'NULL';
    $day =   isset($_POST['selected_day']) ? $_POST['selected_day'] : 'NULL';
    $hour =  isset($_POST['selected_h']) ? $_POST['selected_h'] : 'NULL';
    $minut = isset($_POST['selected_m']) ? $_POST['selected_m'] : 'NULL';
    
    
    /// Temp 
    $duration = 15;
    $ppranch = 1;
    $start = $year.':'.$month.':'.$day.':'.$hour.':'.$minut;
    
    $stmt = $con->prepare("INSERT INTO users(User_Name, Full_Name, Email, User_Tel )
                                VALUES(:zname, :zfullname, :zemail, :ztel)") ;
        $stmt->execute(array(
                        'zname'          => $name,
                        'zfullname'      => $name,
                        'zemail'         => $email,
                        'ztel'           => $tel
                         ));
    
     // Trick to get the last (Item_ID) from the DB to use it 
    $ID  =$con->prepare ("SELECT max(User_ID) FROM users");
    $ID->execute();
    $ids = $ID->fetchAll();
    foreach ($ids as $id) {   }
    $lastID = $id['max(User_ID)'];
    
    $stmt = $con->prepare("INSERT INTO appointment(Duration, User_ID, P_Pranch_ID, Start_Time )
                                VALUES(:zduration, :zuser, :zppranch, :zstart)") ;
        $stmt->execute(array(
                        'zduration'  => $duration,
                        'zuser'      => $lastID,
                        'zppranch'   => $ppranch,
                        'zstart'     => $start
                         ));
    
    // send email
   
      $headers = "Content-type:text/html;charset=UTF-8" . "\r\n"."From:info@a2z4a.com";
                $emailMsg = "
                <html>
                <head>
                <title>Click & Meet</title>
                </head>
                <body>
                <br>
                <p>Dear User</p>
                <br>
                <p>You have bocked successfuly an Appoitment.</p><br>
                <p>Your Appoitment: ".$start." .</p>
                <br><br>
                <p>With best regards</p>

                <table>
                <tr>
                <th>Click & Meet team</th>
                </tr>
                <tr>
                <td><a href = 'http://a2z4a.com'>www.CM.A2Z4A.com</a></td>
                <td></td>
                </tr>
                </table>
                </body>
                </html>

                " ;


            mail($email,'Click & Meet',$emailMsg,$headers);
    
    header('Location: added.php');
    exit;
                         
}
     
    
?>

<script type="text/javascript">
    function updateTime(input){
        document.getElementById('selected_h').value = input.split(':')[0];
        document.getElementById('selected_m').value = input.split(':')[1];        
    }
</script>



<?php
include  $tpl . "footer.php";
?>