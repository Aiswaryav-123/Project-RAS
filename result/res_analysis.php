<style>
    body {
        background: #b9d0fa ;
    }
</style>
<?php
  require_once('appvars.php');
  require_once('connectvars.php');
  session_start();?>
  <head>
  <link rel="stylesheet" type="text/css" href="s.css" />
 
</head>
  <h1 align=center style="color:#fffff;">RESULT ANALYSIS SYSTEM</h1>
  <?php
  
?>
<div class="filterform" align="center">
<?php require_once('navmenu.php'); ?>
    <div class="container">
        <div class="box">
            <div class='logo'>
             <img src="/result/images/top.png" >
            </div>
            <p class="text" >Department Top </p>
            
            <a href="dept_top.php" class="upload-button">VIEW</a><br>

           
        </div>
        <div class="box">
        <div class='logo'>
             <img src="result/images/top.png" >
            </div>
            <p class="text" >Student Analysis</p>
            
            <a href="studanalysis.php" class="upload-button">VIEW</a><br>

        </div>
        <div class="box">
        <div class='logo'>
             <img src="/result/images/top.png" >
            </div>
            <p class="text" >Single Subject Analysis</p>
            
            <a href="singlesub.php" class="upload-button">VIEW</a><br>

        </div>
    </div>

    <div class="container">
        <div class="box">
            <div class='logo'>
             <img src="/result/images/top.png" >
            </div>
            <p class="text" >Semester Wise Analysis</p>
            
            <a href="semwiseanalysis.php" class="upload-button">VIEW</a><br>

           
        </div>
        <div class="box">
        <div class='logo'>
             <img src="/result/images/top.png" >
            </div>
            <p class="text" >College Top 10</p>
            
            <a href="college_top.php" class="upload-button">VIEW</a><br>

        </div>
        <div class="box">
        <div class='logo'>
             <img src="/result/images/top.png" >
            </div>
            <p class="text" >Advanced Search</p>
            
            <a href="advanced_search.php" class="upload-button">VIEW</a><br>

        </div>
    </div>
    
</div>
      
   
