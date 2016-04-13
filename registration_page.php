<?php
	//Variables to hold permission details
	$servername = "localhost";
	$username = "cauPlayer";
	$password = "password1";
	$db = "caudatabase";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $db);

	// Check connection
	if (mysqli_connect_error()) {
    	die("Database connection failed: " . mysqli_connect_error());
	}
	//echo "Connected successfully";
	 
	
	//When the Save Entry button is clicked, details are entered into the DB
    	if($_SERVER['REQUEST_METHOD'] == 'POST'){

   	$username=$_POST['username'];
    	$university=$_POST['university'];
    
      	$sql = "INSERT INTO CAUUsers (FirebaseID, Username, Credits, Coins, Avatar, GamesPlayed, GamesWon, University) VALUES ('fireID', '$username', 0, 0, 'defaultavatar.jpeg', 0, 0, '$university')";

	if (mysqli_query($conn, $sql)) {
    		echo "New record created successfully";
	} else {
    		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}

	mysqli_close($conn);
	$url = "main.html";
	header('Location: '.$url);

	 
	}
?>

	




<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    
	
    <title>Registration</title>
	<link rel="stylesheet" href="cauStyle.css">

    <!-- Firebase library -->
    <script src='https://cdn.firebase.com/js/client/2.4.1/firebase.js'></script>	
	
	<!--Links for Bootstrap-->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


	<script>
	
	//JQuery to initially hide the form button
	//When register button (register with Firebase) is clicked, the form and  register button are hidden, and the login button (register with PHP) is shown
	$(document).ready(function(){
		$("#regMessage").hide();
		$("#registerPHP").hide();
		$("#registerFirebase").click(function(){
			$("#regWriting").hide();
			$("#emailDiv").hide();
			$("#passwordDiv").hide();
			$("#usernameDiv").hide();
			$("#uniDiv").hide();
			$("#registerFirebase").hide();
			$("#regMessage").show();
			$("#registerPHP").show();
		})
});
	</script>
	
  </head>
	
	
	
	
<body id="main">

	<!-- Navigation Bar
    ================================================== -->
	<nav class="navbar navbar-inverse" id="navigationColour">
	<img src="defaultlogo.png" alt="Logo" id="Logo">
	<div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#" id="name"><h1>Cards Against University</h1></a>
    </div>
	
	<!-- Log-in + Back buttons with icons -->
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="index.html"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a></li>
        <li><a href="main.html"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      </ul>
    </div>
  </div>
</nav><!-- ./navigation Bar -->



<!-- Registration Form
    ================================================== -->
<center>
  <div class="reg_container">
    <h2 id="regWriting">Registration</h2>
    <h2 id="regMessage">Congrats! </br>You made an account with Cards Against University. Login to start your gaming experience!</h2>
    </br>
	<form name="registerUser" action="registration_page.php" method="post">
      <div id="emailDiv" class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
      </div>
      <div id="passwordDiv"class="form-group">
        <label for="pwd">Password:</label>
        <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Enter password">
      </div>
      <div id="usernameDiv"class="form-group">
        <label for="username">Username:</label>
        <input type="text" class="form-control" maxlength="15" id="username" name="username" placeholder="Enter username">
      </div>
      <div id="uniDiv" class="form-group">
        <label for="uni">University</label>
        <select id="uni" name="university">
        <option value="Maynooth">Maynooth</option>
        <option value="UCD">UCD</option>
        <option value="Trinity">Trinity</option>
        </select>
      </div>
    </br>
       <div id="regPHPbtn" align="center"><button type="submit" class="btn btn-default" id="registerPHP">Login</button></div>
    </div>
	</form>
    <div><button onclick="createUser()" class="btn btn-default" id="registerFirebase">Register</button></div>
</center><!-- ./registration form -->
 <script>
    

    function createUser(){ // method to create a new user
	var result = true;
	var myDataRef = new Firebase('hhttps://cau-maynooth.firebaseio.com');
      var userEmail = document.getElementById('email').value; // extract the text from the email and password input boxes.
      var userPassword = document.getElementById('pwd').value;
       myDataRef.createUser({ // Firebase method to create a user.
       email: userEmail,
       password: userPassword

      },

    function(error, userData){
      if(error){
        console.log("Error creating user:", error);
	result=false;
      }
      else{
	var myDataRef = new Firebase('hhttps://cau-maynooth.firebaseio.com');
        console.log("You have succesfully created user account, with uid: " + userData.uid);
        myDataRef.authWithPassword({ // if registration is successful authenticate the user with this Firebase method
        email    : userEmail,
        password : userPassword
        }, 
          function(error, authData) {
            if (error) {
            console.log("Login Failed!", error);
		result=false;
          } else {
            console.log("Authenticated successfully with payload:", authData);
              // if authentication is successful save the user's details to the database
                var userName = document.getElementById('username').value; // extract the info from the remaining input boxes
                var userUni = document.getElementById('uni').value;
                var usersRef = myDataRef.child("users");
                usersRef.child(authData.uid).set({ 
                // save the user's info under their user id (uid), which is given to the user upon authenication
                     email :userEmail,
                     password : userPassword,
                     username : userName,
                     university : userUni
                });
				localStorage.setItem("Email", userEmail); //save the email in local storage (used for Welcome Username! on main page)
            }
        });
      }
    });
    }
    </script>




	
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
    <!-- Javascript for creating a new user and logging them in -->
   
  </body>
</html>