<?php 

ob_start();
session_start();
$pageTitle = 'Click & Meet';  
include 'init.php';
?>
<div class="container" >    
    <div class="row">
        
        <h3>Dein Termin wird gebucht</h3>
        
        <br>
        <p>Vieln Dank, dass hast du deinen Termin gebucht</p>
    </div>
</div>




<?php
include  $tpl . "footer.php";
?>