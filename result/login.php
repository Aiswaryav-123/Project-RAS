<?php
  require_once('connectvars.php');

  // Start the session
  session_start();

  // Clear the error message
  $error_msg = "";

  // If the user isn't logged in, try to log them in
  if (!isset($_SESSION['user_id'])) {
    if (isset($_POST['submit'])) {
      // Connect to the database
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	echo "hi";
      // Grab the user-entered log-in data
      $user_username = mysqli_real_escape_string($dbc, trim($_POST['username']));
      $user_password = mysqli_real_escape_string($dbc, trim($_POST['password']));

      if (!empty($user_username) && !empty($user_password)) {
        // Look up the username and password in the database
        $query = "SELECT user_id,username,role_id FROM staff_login WHERE username = '$user_username' AND pwd = SHA('$user_password')";
        $data = mysqli_query($dbc, $query);

        if (mysqli_num_rows($data) == 1) {
          // The log-in is OK so set the user ID and username session vars (and cookies), and redirect to the home page
          $row = mysqli_fetch_array($data);
          $_SESSION['user_id'] = $row['user_id'];
          $_SESSION['username'] = $row['username'];
    		  $_SESSION['role_id'] = $row['role_id'];
          $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php?'.SID;
          header('Location: ' . $home_url);
        }
        else {
          // The username/password are incorrect so set an error message
          $error_msg = 'Sorry, you must enter a valid username and password to log in.';
        }
      }
      else {
        // The username/password weren't entered so set an error message
        $error_msg = 'Sorry, you must enter your username and password to log in.';
      }
    }
  }
?>

<html>
  
<head>
  <title>NASC Result Analysis</title>
  <link rel="stylesheet" type="text/css" href="s.css" />
  <style>
    body{
      background-image: url('images/bg.png');
      background-repeat: no-repeat; /* Prevent image from repeating */
      background-size: 300px 300px; 
      
  
    /*background: linear-gradient(to bottom, #3a86ff, #8c60ff); */
    background: linear-gradient(to bottom, #6495ED, #FFFFFF);
  
    /*background: linear-gradient(to right bottom,  #6495ED 50%, #FFFFFF 50%);*/
  
  }
  </style>
  
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
  <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />-->
</head>
<body>
<h1 align=center style="color:#fffff;">NEHRU ARTS AND SCIENCE COLLEGE KANHANGAD, KASARAGOD</h1>
      <h2 align=center style="color:#fffff;">RESULT ANALYSIS</h2>
<?php
  // If the session var is empty, show any error message and the log-in form; otherwise confirm the log-in
  if (empty($_SESSION['user_id'])) {
    echo '<p class="error" align=center>' . $error_msg . '</p>';
?>
  
   <div class="form" style="height:auto">
  <form method="post" class="login-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
 
  <div align=center>
    <img src="/result/images/nehru.png" align="center" width=70px ><br/><br/>
  </div>
<div class="input-container">
  <i class="fa fa-user" ></i>
  <input type="text" name="username" placeholder="username" value="<?php if (!empty($user_username)) echo $user_username; ?>" /><br />
</div>

<div class="input-container">
  <i class="fa fa-lock"></i>
  <input type="password" name="password" placeholder="password" required=""/><br/>
</div>
      <!--<i class="bi bi-eye-slash" id="togglePassword"></i>-->
      <button type="submit" value="Log In" name="submit">Login</button><br/>
  </form>

  </div> 
<?php
  }
  else {
    // Confirm the successful log-in
    echo('<p class="login" align=center>You are logged in as ' . $_SESSION['username'] . '.</p>');
    echo '<p align=center><a href="index.php">Go Home</a></p>';
  }
?>

</body>
</html>
