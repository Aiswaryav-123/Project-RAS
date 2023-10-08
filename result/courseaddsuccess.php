<style>
    body {
        background: #b9d0fa;
    }
</style>
<?php
    require_once('appvars.php');
    require_once('connectvars.php');
    session_start();
    $page_title = 'Course Entry Success';
    require_once('header.php');
    require_once('navmenu.php');
    $name = $_GET['name'];
    if (isset($_SESSION['username']))
    {
?>
    <div class="login-page" align=center>
    <div class="form" align=center">
        <b>Course Added Successfully</b>
        <br />
        <br />
        <p><a href="addcourse.php">Add More Courses</a></p>
    </div>
    </div>
<?php
    }    
?>