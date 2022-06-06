<?php
include_once("dbconnect.php");

if (isset($_SESSION['sessionid'])) {
    $_email = $_SESSION['email'];
}else{
    $cust_email = "guest@gmail.com";
}

if (isset($_POST['submit'])){
    $subjectid = $_POST['tutor_id'];
    if ($cust_email == "guest@gmail.com"){
        echo "<script>alert('Please register an account first.');</script>";
        echo "<script> window.location.replace('signup.php')</script>";
    }else{
       echo "<script> window.location.replace('tutordetails.php?prid=$tutorid')</script>";
        echo "<script>alert('OK.');</script>";
    }
}

if (isset($_GET['tutor_id'])) {
    $tutorid = $_GET['tutor_id'];
    $sqltutor= "SELECT * FROM tbl_tutors WHERE tutor_id = '$tutorid'";
    $stmt = $conn->prepare($sqltutor);
    $stmt->execute();
    $number_of_result = $stmt->rowCount();
    if ($number_of_result > 0) {
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $rows = $stmt->fetchAll();
    } else {
        echo "<script>alert('Tutor not found.');</script>";
        echo "<script> window.location.replace('index.php')</script>";
    }
} else {
    echo "<script>alert('Page Error.');</script>";
    echo "<script> window.location.replace('index.php')</script>";
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
    <script src="../js/menu.js" defer></script>
    <link rel="stylesheet" href="../css/style1.css">
    <title>Welcome to MyTutor</title>
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

    <div class="w3-pink">
        <button class="w3-button w3-yellow w3-xlarge" onclick="w3_open()">☰</button>
        <div class="w3-container">
            <h3>Tutors Details</h3>
        </div>
    </div>
    <div class="w3-bar w3-yellow">
        <a href="index.php" class="w3-bar-item w3-button w3-right">Back</a>
    </div>
    <div>
    <?php
        foreach ($rows as $tutors) {
           

            $tutorid = $tutors['tutor_id'];
            $tutoremail = $tutors['tutor_email'];
            $tutorphone = $tutors['tutor_phone'];
            $tutorpassword= $tutors['tutor_password'];
            $tutorname = $tutors['tutor_name'];
            $tutordescription= $tutors['tutor_description'];

        }
        echo "<div class='w3-card-4 w3-round' style='margin:4px'>
            <header class='w3-container w3-blue'><h5><b>$tutorname</b></h5></header>";
            echo "<a href='tutordetails.php?tutor_id=$tutorid' style='text-decoration: none;'><img class='w3-image' src=../../admin/assets/tutors/$tutorid.jpg" .
                " onerror=this.onerror=null;this.src='../../admin/css/2.png'" . " style='width:100%;height:250px'></a><hr>";

        echo "<div class='w3-container w3-padding-large'><h4><b>$tutorname</b></h4>";

        echo "<div class='w3-container'><br>Tutor id: $tutorid<br><p>Tutor Name : $tutorname <br>Email: $tutoremail<br>
        Phone Number: $tutorphone<br>Description : $tutordescription	<br>


        <form action='tutordetails.php' method='post'> 
            <input type='hidden'  name='tutor_id' value='$tutorid'>
            <input class='w3-button w3-yellow w3-round' type='submit' name='submit' value='BUY'>
        </form>
        </div></div>";

     
     
     


    ?>
    </div>
    <div class="w3-center w3-bottom w3-yellow" style="max-width:3000px;margin:0 auto;">MyTutor<p>Author: LIM JIA JUN<br></div>
</body>

</html>