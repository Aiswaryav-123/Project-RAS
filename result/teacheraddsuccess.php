<style>
    body {
        background: #b9d0fa;
    }
</style>
<?php
    require_once('appvars.php');
    require_once('connectvars.php');
    session_start();
    $page_title = 'Teacher Entry Success';
    require_once('header.php');
    require_once('navmenu.php');
    $name = $_GET['name'];
    if (isset($_SESSION['username']))
    {
?>
    <div class="login-page" align=center>
    <div class="form" align=center">
        <b>Teacher Added Successfully</b>
        <br />
        <br />
       
        <h3><?php echo $name; ?></h3>
        <p><a href="addteacher.php">Add More Teachers</a></p>
    </div>
    </div>
<?php
    }    
?>