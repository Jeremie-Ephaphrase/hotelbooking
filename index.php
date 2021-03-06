<?php
//start session 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="stylesheet" href="css/style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Booking</title>

        </head>
        <body>

            <h1>Hotel Bookings</h1>
            
                <form class="submission" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">

        
           <input type="text" id="firstname" name="firstname" placeholder="First Name" required><br>
           <input type="text" id="lastname" name="lastname" placeholder="Last Name" required><br>
           <input  type="date" id="Startdate" name="indate" min="2018-01-01" max="2020-01-01" required><br>
           <input  type="date" id="Lastdate" name="outdate" min="2018-01-01" max="2020-01-01" required><br>
        

       <select name="hotelname" required>
           <option value="international hotel">International Hotel</option>
           <option value="nelson hotel">Nelson Hotel</option>
           <option value="african hotel">African Hotel</option>
           <option value="protia hotel">Protia Hotel</option>
       </select><br>
       <input type="submit" id="submit" name="submit"><br>
  </form>
  </body>
</html>
   <?php
    require_once "connect.php";
//creating table into a database 
   $sql = "CREATE TABLE IF NOT EXISTS bookings(
       id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
       firstname VARCHAR(50),
       lastname VARCHAR(50),
       hotelname VARCHAR(50),
       indate VARCHAR(30),
       outdate VARCHAR(30),
       booked INT(4))";


   $conn ->query($sql);
   echo $conn-> error;
  
   //write to database

   if(isset($_POST['submit'])){
       //create Session var from post data
           $_SESSION['firstname'] = $_POST['firstname'];
           $_SESSION['lastname'] = $_POST['lastname'];
           $_SESSION['hotelname'] = $_POST['hotelname'];
           $_SESSION['indate'] = $_POST['indate'];
           $_SESSION['outdate'] = $_POST['outdate'];
       
//if(isset($_POST['indate'.'outdate'])){
       //amount of days the user stays at the hotel
       $datetime1 = new DateTime($_SESSION['indate']);
       $datetime2 = new DateTime($_SESSION['outdate']);

       $interval = $datetime1-> diff($datetime2);
//}

$checkInStamp = strtotime($_SESSION['indate']);
$checkOutStamp = strtotime($_SESSION['outdate']);
if ($checkInStamp - $checkOutStamp > 86400 || $checkInStamp == $checkOutStamp) {
    header("Location: ?erro=timestamp");
    exit;
}


//calculate days amount 
$daysbooked = $interval->format('%d');
   $value;
switch($_SESSION['hotelname']){
 case "international hotel":
 $value = $daysbooked * 400;
 break;

 case "nelson hotel":
 $value = $daysbooked * 429;
 break;

 case "african hotel":
 $value = $daysbooked * 322;
 break;

 case "protia hotel":
 $value = $daysbooked * 565;
 break;

 default:
 return "Invalid Booking";
}

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$result = mysqli_query($conn,"SELECT hotelname, indate, outdate, firstname, lastname FROM bookings WHERE firstname='$firstname' && lastname='$lastname'"); 
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='feedback'> You have a booking already! 
        <br> Firstname: ". $row['firstname'] . 
        "<br> Lastname: " . $row['lastname'].
        "<br> Start Date: " . $row['indate'].
        "<br> End Date: " . $row['outdate'].
        "<br> Hotel Name: " . $row['hotelname'].
        "<br>" . $interval->format('%d days') . "<br> total: " . $value . "</div>";
        
    } 
}

echo "<div class='feedback'> <br> Firstname: ". $_SESSION['firstname'] . "<br>
   Lastname: " . $_SESSION['lastname'].
   "<br> Start Date: " . $_SESSION['indate'].
   "<br> End Date: " . $_SESSION['outdate'].
   "<br> Hotel Name: " . $_SESSION['hotelname'].
   "<br>" . $interval->format('%d days') . "<br> total: " . $value . "</div>";
   
       echo "<form class='form-inline' role='form' method='post' action=".
       htmlentities($_SERVER["PHP_SELF"]).
       "><button type='submit' id='submit' name='confirm'>confirm</button></form>";
   }
       if(isset($_POST['confirm'])){
           $stmt = $conn->prepare("INSERT INTO bookings(firstname,lastname,hotelname,indate,outdate)VALUES(?,?,?,?,?)");
               $stmt -> bind_param('sssss',$firstname,$lastname,$hotelname,$indate,$outdate);
       

       $firstname = $_SESSION['firstname'];
       $lastname = $_SESSION['lastname'];
       $hotelname = $_SESSION['hotelname'];
       $indate = $_SESSION['indate'];
       $outdate = $_SESSION['outdate'];
       $stmt -> execute();
       echo "<h2>Booking Confirmed</h2>";
    }
?>

<?php
    if (isset($_GET['error']) && $_GET['error'] == 'timestamp') {
?>
        <div class='panel panel-default'>
        <h3>
            You must atleast select 1 day
        </h3>
        </div>
<?php
    }
?>

<style>


h1{
    text-align: center;
    color: white;
    text-transform: uppercase;
}

 h2{
    text-align: center;
    color: white;
    text-transform: uppercase;
}

select {
    display: block;
    width: 69%;
    padding: 8px 77px 8px 93px;
    margin: 0px 0px 0px 61px;
}

#submit {
    border: 0px;
    background-color: crimson;
    padding: 8px 77px 8px 93px;
    margin: 0px 0px 0px 61px;
    color: white;
    width: 69%;
    text-transform: uppercase;
        cursor: pointer; }

    
button#submit {
    border: 0px;
    background-color: crimson;
    padding: 8px 77px 8px 93px;
    margin: 0px 0px 0px 85px;
    color: white;
    width: 68%;
    text-transform: uppercase;
    cursor: pointer; }

    form {
    display: block;
    padding: 8px 77px 8px 244px;
    margin: 0px 0px 0px 61px;
    
}
</style>


