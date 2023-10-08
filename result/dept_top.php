<style>
    body {
        background: #b9d0fa ;
    }
</style>
<?php
require_once('appvars.php');
require_once('connectvars.php');
session_start();
$page_title = 'Department Top 10';
require_once('header.php');
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (isset($_SESSION['username']))
    {
        $query = "SELECT pgm_id,pgm_name FROM programme order by pgm_name";
        $pgms = mysqli_query($dbc, $query);
        if (isset($_POST['submit']))
        {
            $year = 2019;
            $year2 = 2020;
            $credit = 0;
            $pgm_id = mysqli_real_escape_string($dbc, trim($_POST['programme']));
            $semester = $_POST['sem'];
            $top = $_POST['top'];
            $yearofadmn = mysqli_real_escape_string($dbc, trim($_POST['yearofadmn']));
            $query1 = "SELECT stud_id,name,uty_reg_no FROM stud_master WHERE year_of_admn = ". $yearofadmn ." 
                    AND pgm_id= ". $pgm_id ." ORDER BY roll_no" ;
            $studs = mysqli_query($dbc, $query1);
            
            $query2 = "SELECT course_id FROM pgm_course WHERE pgm_id = " . $pgm_id;
            $course_ids = mysqli_query($dbc, $query2);       
        }
    }
?>
<div class="filterform">
    <?php require_once('navmenu.php'); ?>
    <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="login-form">
    <table align=center>    
    <tr>
    <th><label for="dob">Programme</label></th><th>:</th>
    <td> <select name="programme" id="programme">
            <?php foreach($pgms as $pgm)
            {?>
                <option value="<?php echo $pgm['pgm_id'];?>" <?php if(!empty($pgmid)) if($pgmid == $pgm['pgm_id']) echo "selected"; ?>><?php echo $pgm['pgm_name']; ?></option>
            <?php }?>
        </select></td></tr>
        
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
                } ?></tr><tr>
           <th><label for="semester">Semester</label></th>
            <th>:</th>
            <td>
            <label style="display: inline-block; margin-right: 10px;">
            <input type="radio" name="sem" value="1" <?php if (isset($_POST['sem']) && $_POST['sem'] == '1') echo 'checked'; ?>>1
            </label>
            <label style="display: inline-block; margin-right: 10px;">
                <input type="radio" name="sem" value="2" <?php if (isset($_POST['sem']) && $_POST['sem'] == '2') echo 'checked'; ?>>2
            </label>
            <label style="display: inline-block; margin-right: 10px;">
                <input type="radio" name="sem" value="3" <?php if (isset($_POST['sem']) && $_POST['sem'] == '3') echo 'checked'; ?>>3
            </label>
            <label style="display: inline-block; margin-right: 10px;">
                <input type="radio" name="sem" value="4" <?php if (isset($_POST['sem']) && $_POST['sem'] == '4') echo 'checked'; ?>>4
            </label>
            <label style="display: inline-block; margin-right: 10px;">
                <input type="radio" name="sem" value="5" <?php if (isset($_POST['sem']) && $_POST['sem'] == '5') echo 'checked'; ?>>5
            </label>
            <label style="display: inline-block; margin-right: 10px;">
                <input type="radio" name="sem" value="6" <?php if (isset($_POST['sem']) && $_POST['sem'] == '6') echo 'checked'; ?>>6
            </label>
            </td></tr>
            <tr>
                <th ><label>Top No</label></th><th>:</th>
                <td><input type = "number " id="top" name = "top" max=1200 min=0 value="<?php echo isset($_POST['top']) ? htmlspecialchars($_POST['top']) : ''; ?>" style="text-align: center;"/></td>
            </tr>
        </table>  
        <button type="submit" value="Log In" name="submit">SEARCH</button>
          </form>
                 
                 <?php
        if (isset($_POST['submit']))
        {   ?>
           
           <!-- <h3 align="center">Department Top <?php echo $top?></h3>-->
            <table align="center" border="solid">
                <tr><th>UTY Reg No</th><th>Name</th><th>Percentage</th></tr>
            <?php
            $all_per=[];
            $top_students = [];
            foreach ($studs as $a) {
                $TotalCreditPoint=0;
                $SGPA = 0;
                $totalCredit =0;
                $percentage =0;
                $name = $a['name'];
                $uty = $a['uty_reg_no'];
                $stud_id =$a['stud_id'];
                $unique_course_titles = [];
                foreach ($course_ids as $a) {
                    $course_id = $a['course_id'];
                    $query = "SELECT course_title, total_internal, total_external, credits FROM course
                              WHERE course_id = " . $course_id . " AND semester = " . $semester."  AND credits <> " . $credit . " AND  syllabus_intro_year
                                  IN (" . $year . ", " . $year2 . ")";
                    $courses = mysqli_query($dbc, $query);
                    while ($row = mysqli_fetch_assoc($courses)) {
                        $course_title = $row['course_title'];
                      
                        $total_internal = $row['total_internal'];
                        $total_external = $row['total_external'];
                        $credits = $row['credits'];
                       
                        $unique_course_titles[] = $course_title;     
                        $query3 = "SELECT ce,ese FROM sem_exam WHERE stud_id = " . $stud_id . " AND course_id = " . $course_id;
                        $marks = mysqli_query($dbc, $query3);
                        $ce_values = [];
                        while ($row = mysqli_fetch_assoc($marks)) {
                            $ce = $row['ce'];
                            $ce_values[] = $ce;
                            $ese = $row['ese'];
                            $ese_values[] = $ese;
                        }
                            if (empty($ce_values)) {
                                continue;
                            } else {
                                foreach ($ce_values as $ce) {
                                    $mark = $ese + $ce;
                                    $GP = ($mark/($total_external+$total_internal)) * 10 ;
                                    $CreditPoint=$credits * $GP;
                                    $TotalCreditPoint = $TotalCreditPoint+$CreditPoint;                   
                                   
                                }
                        }
                        $totalCredit = $totalCredit + $credits;
                        
                    }
                } 
                $SGPA= $TotalCreditPoint/ $totalCredit;
                $percentage = $SGPA *10;            
                $all_per[] = $percentage; 
               
                $top_students[] = ['name' => $name, 'uty_reg_no' => $uty, 'percentage' => $percentage];       
            } 
            usort($top_students, function ($a, $b) {
                return $b['percentage'] - $a['percentage'];
            });
        
 

    for ($i = 0; $i < $top && $i < count($all_per); $i++) {
        
        $student_details = $top_students[$i];
       
        $name = $student_details['name'];
        $uty_reg_no = $student_details['uty_reg_no'];
        $percentage = $student_details['percentage'];
        $formatted_percentage = number_format($percentage, 2);
        echo "<tr><td>{$uty_reg_no}</td><td>{$name}</td><td>{$formatted_percentage }</td></tr>";
      
    }

           
        }?></table>
    </div>