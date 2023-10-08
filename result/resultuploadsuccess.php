<style>
    body {
        background: #b9d0fa ;
    }
</style>
<?php
    require_once('appvars.php');
    require_once('connectvars.php');
    session_start();
    $page_title = 'Mark Entry Success';
    require_once('header.php');
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    
    
    if (isset($_SESSION['username']))
    {
        if (isset($_GET['roll_no'])) 
        {
            $roll_no = $_GET['roll_no'];
            $roll_no=$roll_no+1;
        } 
        if (isset($_GET['stud_id'])) 
        {
            $stud_id = $_GET['stud_id'];
        } 
            
        if (isset($_GET['year_of_admn'])) 
        {
            $year_of_admn = $_GET['year_of_admn'];
        }
        if (isset($_GET['sem'])) 
        {
            $semester = $_GET['sem'];
        }
               
?>
    <div class="filterform" align=center>
        <?php require_once('navmenu.php'); ?>
        <div class="cont">
                <div class="b">
                  <br /><br/></br><br /><br/></br><br /><br/><b>Mark Added Successfully</b>
            <br />
            <br />
        <?php
        $query = "SELECT pgm_id FROM stud_master WHERE stud_id=".$stud_id;
        $pgm_ids = mysqli_query($dbc, $query);
        foreach($pgm_ids as $a)
        {
           $pgm_id = $a['pgm_id'];
        }
        $query = "SELECT stud_id FROM stud_master WHERE roll_no=$roll_no AND pgm_id=$pgm_id AND year_of_admn=".$year_of_admn;
        $stud_ids = mysqli_query($dbc, $query);
        foreach($stud_ids as $a)
        {
           $stud_id = $a['stud_id'];
        }

        echo '<a href="resultupload.php?stud_id='.$stud_id.'&pgm_id='.$pgm_id.'&sem='.$semester.'&roll_no='.$roll_no.'&year_of_admn='.$year_of_admn.'" class="upload-button">Next</a>';
        ?>
        </div>
    </div>
    </div>
    
<?php
    }    
?>