<style>
    body {
        background: #b9d0fa ;
    }
</style>
<?php
require_once('appvars.php');
require_once('connectvars.php');
session_start();
$page_title = 'College Top 10';
require_once('header.php');
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (isset($_SESSION['username']))
    {
        $query = "SELECT pgm_id,pgm_name FROM programme order by pgm_name";
        $pgms = mysqli_query($dbc, $query);
    }
?>
<div class="filterform">
    <?php require_once('navmenu.php'); ?>
    <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="login-form">
    <table align=center>  
    <tr><th><label for="yearofadmn">Year of Admission</label></th>
            <th>:</th>
            <td><select name="yearofadmn">
            <?php
                if(empty($yearofadmn))
                {
                    for ($i = 2010; $i <= 2050; $i++) : ?>
                        <option value="<?php echo  $i; ?>" <?php if ($i==date("Y")) echo "selected"; ?>><?php echo $i; ?></option>
            <?php   endfor;
                }
                else
                {
                    for ($i = 2010; $i <= 2050; $i++) : ?>
                    <option value="<?php echo  $i; ?>" <?php if ($i==$yearofadmn) echo "selected"; ?>><?php echo $i; ?></option>
            <?php   endfor;
                } ?>
           <tr>
                <th ><label>Semester:</label></th><th>:</th>
                <td><input type = "text " id="sem" name = "sem" value="<?php echo isset($_POST['sem']) ? htmlspecialchars($_POST['sem']) : ''; ?>" style="text-align: center;"/></td>
            </tr> 
        </table>  
        <button type="submit" value="Log In" name="submit">SEARCH</button><br/>
          </form>
    </div>