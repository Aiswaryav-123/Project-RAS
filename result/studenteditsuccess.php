<style>
    body {
        background: #b9d0fa;
    }
</style>
<?php
    require_once('appvars.php');
    require_once('connectvars.php');
    session_start();
    $page_title = 'Suudent Update Success';
    require_once('header.php');
    require_once('navmenu.php');
    $name = $_GET['name'];
    if (isset($_SESSION['username'])) 
    {
?>
    <div class="login-page" align=center>
    <div class="form" align=center">
        <b>Student details updates successfully</b>
        <br />
        <br />
        <h3><?php echo $name; ?></h3>
        <p><a href="index.php">Go Home</a></p>
    </div>
    </div>
<?php
    }
?>