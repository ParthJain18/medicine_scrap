<!doctype html>

<html>

<head>
       <link rel="shortcut icon" href="logo.ico"/>
    <title>
        MedBazaar: Search Result
    </title>
    <link href="https://fonts.googleapis.com/css?family=Bitter&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/searchres.css">
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <nav>
        <div class="navbar navbar-expand-md navbar-light bg-success">
            <a href="#" class="navbar-brand">
                <img src="logo.jpg" class="logo" />
            </a>
            <h1 style="color: white"> MedBazaar: The Online Pharma Search Engine </h1>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav nav ml-auto">
                    <li class="navbar-item"> <a class="nav-link" href="index.php" style="color: white;"> Home</a></li>
                    <li class="navbar-item"> <a class="nav-link" href="aboutus.html" style="color: white;"> About Us</a></li>
                    <li class="navbar-item"> <a class="nav-link" href="login_page.php" style="color: white;"> Login/Sign Up</a></li>
                </ul>
            </div>       
        </div>
    </nav>
   </br></br>

<?php 

$searchterm=isset($_POST['search_str'])?$_POST['search_str']:"none";
include 'delete.php';

$output = null;
$retval = null;
exec("C:\Users\parth\AppData\Local\Programs\Python\Python311\python.exe C:\\xampp\htdocs\Medbazaar\pharmeasy_scraper.py '$searchterm'", $output, $retval);
// echo "Returned with status $retval and output:\n";
// print_r($output);


?>

   <div>
        <h2 style="margin-left: 100px;"> Search Results for: <?php echo $searchterm; ?> </h2>


<?php

// include 'dbconnection.php';

// $query="SELECT * FROM `medicines`";
// $result=mysqli_query($conn, $query);
// if(mysqli_num_rows($result) > 0)
// {
//     while($row = mysqli_fetch_assoc($result))
//     {
//         $med_name=$row["Name"]!="To be Updated"?$row["Name"]:"";
//         $comp_name=$row["Comp Name"]!="To be Updated"?$row["Comp Name"]:"";
//         $quan=$row["Quantity"]!="To be Updated"?$row["Quantity"]:"";
//         $price=$row["Price"]!="To be Updated"?$row["Price"]:"";
//         $link=$row["Link"];
//         // $link="https://www.pharmeasy.in".$link;

        $json = file_get_contents('C:\\xampp\htdocs\Medbazaar\pharmeasy.json');

        // Decode JSON data into PHP array
        $data = json_decode($json, true);

        // Iterate through the array and display the cards
        if ($data != null) {
        foreach ($data as $item) {
            $med_name = $item["med_name"];
            $comp_name = $item["comp_name"];
            $quan = $item["quantity"];
            $price = $item["price"];
            $link = $item["link"];
        ?>

    
        <div class="card-body">
            <a href="<?= $link ?>">
                    <p class="headnam" style="color:#28a745;"><strong><?php if($med_name!="") echo $med_name; else echo "Name Unavailable. Click for More Details."; ?></strong></p>
                
                    <p class="compnam" style="color:grey;"><?php echo $comp_name ?></p>
                
                    <p class="info" style="color:black;"><?php echo $quan ?></p>
                
                    <p class="price" style="color: black;"><?php if($price!="") echo "Rs. $price"; else echo "Price Unavailable. Click for More Details."; ?></p>
            </a>    
        </div>
    
<?php 
    }
        }
else
    echo "<h5 style='margin-left: 100px; margin-top:20px;'> Sorry :( We couldn't find what you were looking for. Please check for any spelling errors or try searching a different item. </h5>";
?>
    
    
    </div>

    </br></br></br></br>
    <div class="footer">
        <h2>Contact Us</h2>
        <p>
            Phone No: +91 8095589795, +91 9739160724</br>
            Email ID: <a href="https://accounts.google.com/signin/v2/identifier?continue=https%3A%2F%2Fmail.google.com%2Fmail%2F&service=mail&sacu=1&rip=1&flowName=GlifWebSignIn&flowEntry=ServiceLogin">medbazaarofficial@gmail.com</a></br>
            For Any Feedback & Suggestions, <a href="feedback_page.php">Click Here!</a>
        </p>
    </div>
    </br></br></br></br></br>
 

</body>
</html>