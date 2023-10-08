<style>
  
ul {
    list-style-type: none;
    margin: 0;
    padding: 0px 10px 0px 0px;
    overflow: hidden;
    background-color: #b9d0fa;
   width: auto;
   height:10%;
   
}

li {
    float: right;
}

li a {
    display: block;
    color: black;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
    font-weight:bold;
}

li a:hover {
    background-color: #A3ABBD;
}
</style>
<?php
  // Generate the navigation menu
  if (isset($_SESSION['username'])) { ?>
  <li><img src="/result/images/graph.png" width="70" height="70"></li>
	<ul class="no-print">
    
		<?php 
    
    echo '<li><a href="logout.php">Log Out (' . $_SESSION['username'] . ')</a></li>'; ?>
		<li><a href="index.php">Home</a></li>
    <!--<li><img src="/result/images/analy.png" width=10% height=2%></li>-->
	</ul>
  <?php }
  else {
    echo '<a href="login.php">Log In</a> ';
  }
?>