<?php
session_start();
if (isset($_SESSION['sessionid'])) {
    $email = $_SESSION['email'];
   
   
    
}
include_once("dbconnect.php");
if (isset($_GET['submit'])) {
    $operation = $_GET['submit'];
    if ($operation == 'delete') {
        $subjectid = $_GET['subject_id'];
        $sqldelete = "DELETE FROM `tbl_subjects` WHERE subject_id = '$subjectid'";
        $conn->exec($sqldelete);
        echo "<script>alert('subject deleted')</script>";
    }
    if ($operation == 'search') {
        $search = $_GET['search'];
        $sqlsubject = "SELECT * FROM tbl_subjects WHERE subject_name LIKE '%$search%'";
        
        
    }
} else {
    $sqlsubject = "SELECT * FROM tbl_subjects";
}

$results_per_page = 10;
if (isset($_GET['pageno'])) {
    $pageno = (int)$_GET['pageno'];
    $page_first_result = ($pageno - 1) * $results_per_page;
} else {
    $pageno = 1;
    $page_first_result = 0;
}

if ($email !="guest@gmail.com"){
    $stmtqty = $conn -> prepare("SELECT * FROM tbl_carts WHERE user_email = '$email'");
	$stmtqty -> execute();
	$resultqty = $stmtqty -> setFetchMode(PDO::FETCH_ASSOC);
	$rowsqty = $stmtqty -> fetchAll();
	$carttotal = 0;
	foreach($rowsqty as $carts) {
	    $carttotal = $carts['cart_qty'] + $carttotal;
	}
}
$stmt = $conn->prepare($sqlsubject);
$stmt->execute();
$number_of_result = $stmt->rowCount();
$number_of_page = ceil($number_of_result / $results_per_page);
$sqlsubject = $sqlsubject . " LIMIT $page_first_result , $results_per_page";
$stmt = $conn->prepare($sqlsubject);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();

$conn= null;


function truncate($string, $length, $dots = "...") {
    return (strlen($string) > $length) ? substr($string, 0, $length - strlen($dots)) . $dots : $string;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../js/menu.js" defer></script>
    <link rel="stylesheet" href="../css/style1.css">
    <title>Welcome to My Tutor</title>
    <div class="w3-bar w3-border  ">
    <a href="login.php" class="w3-bar-item w3-button w3-right w3-white w3-border w3-border-red w3-round-large">Logout</a>
</head>

<body style="max-width:2200px;margin:0 auto;">
    <div class="w3-sidebar w3-bar-block w3-light-grey" style="width:15%" id="mySidebar">
    <button onclick="w3_close()" class="w3-bar-item w3-button w3-large">Close &times;</button>


        <a href="index.php" class="w3-bar-item w3-button w3-red">Dashboard</a>
        <a href="signup.php" class="w3-bar-item w3-button w3-black">My Profile</a>
      
        <a href="index.php" class="w3-bar-item w3-button w3-green">My Courses</a>
        <a href="tutors.php" class="w3-bar-item w3-button w3-pink">My Tutors</a>
        <a href="#" class="w3-bar-item w3-button w3-white w3-gray">My Subscription</a>
        
        <a href="login.php" class="w3-bar-item w3-button w3-pale-red">Logout</a>
       
      
    </div>

    <div class="w3-yellow">
        <button class="w3-button w3-yellow w3-xlarge" onclick="w3_open()">☰</button>
        
       
          

            <div class="w3-container w3-center w3-panel w3-black">
  <h2 class="w3-text-orange" style="text-shadow:1px 1px 0 #444">
  <b>Subject List</b></h2>

            <div class="w3-panel w3-center w3-white w3-border w3-border-red w3-round-large ">Welcome<br /><?php echo $email?></div> 
         
            
        </div>
    </div>
   
       
        
        <div class="w3-center w3-padding-16" style="font-family:'Courier New' ">MyTutor</div>
    </div>
    <div class="w3-card w3-container w3-padding w3-margin w3-round">
        <h3> Search</h3>
        <form>
            <div class="w3-row ">
            
                    <p><input class="w3-input w3-block  w3-border" type="search" name="search"  
                     placeholder="Please  Search the Subject List"/></p>
                </div>
                <button class="w3-button w3-white w3-border w3-border-red w3-round-large w3-right" type="submit" name="submit" value="search">search</button>
                
            </div>

             
            
        </form>

    </div>
    <div class="w3-grid-template">
        <?php
        $i = 0;
        foreach ($rows as $subjects) {
            $i++;
            $subjectid = $subjects['subject_id'];
            $subjectname = truncate($subjects['subject_name'],15);
            $subjectdescription = $subjects['subject_description'];
            $subjectprice = $subjects['subject_price'];
            $tutorid = $subjects['tutor_id'];
            $subjectsessions = $subjects['subject_sessions'];
            $subjectrating= $subjects['subject_rating'];

          



            echo "<div class='w3-card-4 w3-round' style='margin:4px'>
            <header class='w3-container w3-black'><h5><b>$subjectname</b></h5></header>";
            echo "<a href='subjectdetails.php?subject_id=$subjectid' style='text-decoration: none;'><img class='w3-image' src=../../admin/assets/courses/$subjectid.png" .
                " onerror=this.onerror=null;this.src='../../admin/css/2.png'"
                . " style='width:100%;height:250px'></a><hr>";
            echo "<div class='w3-container'><p>Subject Name : $subjectname <br>Description: $subjectdescription<br>
            Price: RM $subjectprice<br>Tutor id: $tutorid<br>Session: $subjectsessions<br>Ranking : $subjectrating	<br>
            <div class='w3-button w3-yellow w3-round w3-block' onClick='addCart($subjectid)'>Add to Cart</div></p></div>
            </div>";
            
        }
        ?>
    </div>
    <br>
    <?php
    $num = 1;
    if ($pageno == 1) {
        $num = 1;
    } else if ($pageno == 2) {
        $num = ($num) + 10;
    } else {
        $num = $pageno * 10 - 9;
    }
    echo "<div class='w3-container w3-row'>";
    echo "<center>";
    for ($page = 1; $page <= $number_of_page; $page++) {
        echo '<a href = "index.php?pageno=' . $page . '" style=
            "text-decoration: underline">&nbsp&nbsp' . $page . ' </a>';
    }
    echo " ( " . $pageno . " )";
    echo "</center>";
    echo "</div>";
    ?>
    <br>

    <div class="w3-center w3-bottom w3-yellow" style="max-width:3000px;margin:0 auto;">MyTutor<p>Author: LIM JIA JUN<br></div>
    

</body>


</html>