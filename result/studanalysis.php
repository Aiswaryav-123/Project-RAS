<?php
function calculateGrade($GP) {
    if ($GP >= 9.00) {
        return "A+";
    } else if ($GP >= 8.00 && $GP <= 8.99) {
        return "A";
    } else if ($GP >= 7.00 && $GP <= 7.99) {
        return "B";
    } else if ($GP >= 6.00 && $GP <= 6.99) {
        return "C";
    } else if ($GP >= 5.00 && $GP <= 5.99) {
        return "D";
    } else {
        return "F"; // Add a default grade or error handling if needed
    }
} ?>
<style>
    body {
        background: #b9d0fa ;
    }
    #percentageChart {
    width: 200px; 
    height: 100px; 
}
</style>

<?php
require_once('appvars.php');
require_once('connectvars.php');
session_start();
$page_title = 'Student Analysis';
require_once('header.php');
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$selected_semesters = array();
if (isset($_SESSION['username']))
{
    $query = "SELECT pgm_id,pgm_name FROM programme order by pgm_name";
    $pgms = mysqli_query($dbc, $query);
    if (isset($_POST['submit']))
        {
            $year = 2019;
            $year2 = 2020;
            $credit = 0;
            $all_per=[];
            $all_sem=[];
            $name_reg = mysqli_real_escape_string($dbc, trim($_POST['name_reg']));
            $graph = mysqli_real_escape_string($dbc, trim($_POST['graph']));
            $overallresult = mysqli_real_escape_string($dbc, trim($_POST['overallresult']));
            $registration_number_pattern = '/^[A-Za-z0-9]+$/';  
        }
}
?>
<div class="filterform">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php require_once('navmenu.php'); ?>
    <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="login-form">
    <table align=center> 
    <tr>
        <th>Reg No.</th><th>:</th>
        <td>
            <input type="text" id="name_reg" name="name_reg" value="<?php if (!empty($name_reg)) echo $name_reg; ?>" />
        </td>
    </tr>
        <th>Semester</th>
        <th>:</th>
   
        <td>
            <label style="display: inline-block; margin-right: 10px;">
                <input type="checkbox" name="sem[]" value="1" <?php if (in_array('1', $selected_semesters) || (isset($_POST['sem']) && in_array('1', $_POST['sem']))) echo 'checked'; ?> style="width: 20px; height: 20px;"> 1
            </label>
            <label style="display: inline-block; margin-right: 10px;">
                <input type="checkbox" name="sem[]" value="2" <?php if (in_array('2', $selected_semesters) || (isset($_POST['sem']) && in_array('2', $_POST['sem'])))echo 'checked'; ?> style="width: 20px; height: 20px;"> 2
            </label>
            <label style="display: inline-block; margin-right: 10px;">
                <input type="checkbox" name="sem[]" value="3" <?php if (in_array('3', $selected_semesters) || (isset($_POST['sem']) && in_array('3', $_POST['sem']))) echo 'checked'; ?> style="width: 20px; height: 20px;"> 3
            </label>
            <label style="display: inline-block; margin-right: 10px;">
                <input type="checkbox" name="sem[]" value="4" <?php if (in_array('4', $selected_semesters) || (isset($_POST['sem']) && in_array('4', $_POST['sem']))) echo 'checked'; ?> style="width: 20px; height: 20px;"> 4
            </label>
            <label style="display: inline-block; margin-right: 10px;">
                <input type="checkbox" name="sem[]" value="5" <?php if (in_array('5', $selected_semesters) || (isset($_POST['sem']) && in_array('5', $_POST['sem']))) echo 'checked'; ?> style="width: 20px; height: 20px;"> 5
            </label>
            <label style="display: inline-block; margin-right: 10px;">
                <input type="checkbox" name="sem[]" value="6" <?php if (in_array('6', $selected_semesters) || (isset($_POST['sem']) && in_array('6', $_POST['sem'])))echo 'checked'; ?> style="width: 20px; height: 20px;"> 6
            </label>
        </td>
    </tr>
    <tr>
        <th>Overall Result </th> <th>:</th>
        <td>
        <input type="checkbox" name="overallresult" <?php if (isset($_POST['overallresult']) && $_POST['overallresult'] == "on") echo "checked"; else echo "unchecked"; ?> />
        </td>
    </tr>
    <tr>
        <th>Include Graph </th> <th>:</th>
        <td>
        <input type="checkbox" name="graph" <?php if (isset($_POST['graph']) && $_POST['graph'] == "on") echo "checked"; else echo "unchecked"; ?> />
        </td>
    </tr> 
    </table>  
        <button type="submit" value="Log In" name="submit">SEARCH</button><br/>
            </div>
<?php
if (isset($_POST['submit']))
{ 
    echo '<div class="filterform">';
    if (preg_match($registration_number_pattern, $name_reg)) 
    {
        $pgm_id=0;
        $yearofadmn=0;
        $query = "SELECT * FROM stud_master WHERE  uty_reg_no = '" . $name_reg . "'";
        $studs = mysqli_query($dbc, $query);
        foreach ($studs as $a) 
        {         
            $name = $a['name'];
            $stud_id =$a['stud_id'];             
            echo '<table align="center"><tr><th>Name</th><th>:</th><th>'.strtoupper($name).'<td></tr>';  
            echo '<tr><th>Reg No.</th><th>:</th><th>'.$name_reg.'<td></table><br><br>'; 
           
            $query = "SELECT pgm_id FROM stud_master WHERE uty_reg_no = '" . $name_reg . "'";

            $pgm_id=mysqli_query($dbc, $query);
            foreach($pgm_id as $a)
            {
                $pgm_id = $a['pgm_id'];
                
            }
            $query2 = "SELECT course_id FROM pgm_course WHERE pgm_id = " . $pgm_id;
            $course_ids = mysqli_query($dbc, $query2);
        }
    } 
    else 
    {
        $pgm_id = mysqli_real_escape_string($dbc, trim($_POST['programme']));
            $yearofadmn = mysqli_real_escape_string($dbc, trim($_POST['yearofadmn']));
        $query = "SELECT * FROM stud_master WHERE year_of_admn = " . $yearofadmn . " AND pgm_id = " . $pgm_id . " AND name = '" . $name_reg . "'";
        $studs = mysqli_query($dbc, $query);
        foreach ($studs as $a) 
        {         
            $uty = $a['uty_reg_no'];
            $stud_id =$a['stud_id'];   
            echo '<table align="center"><tr><th>Name</th><th>:</th><th>'.strtoupper($name_reg).'<td>';
            echo '<tr><th>Reg No.</th><th>:</th><th>'.$uty.'<td></tr></table><br><br>'; 

            $query2 = "SELECT course_id FROM pgm_course WHERE pgm_id = " . $pgm_id;
            $course_ids = mysqli_query($dbc, $query2);
             
        }
    }
  
    $selected_semesters = isset($_POST['sem']) ? $_POST['sem'] : array();
    $semester_filter = implode(',', $selected_semesters);?>

    <?php
        foreach ($studs as $a) 
        {         
            $stud_id =$a['stud_id'];   
        }
        $query = "SELECT language_id,name FROM stud_master WHERE stud_id=" . $stud_id;
        $l_ids = mysqli_query($dbc, $query);
        foreach ($l_ids as $a) 
        {
            $l_id = $a['language_id'];
        }
       

        $query = "SELECT dept_id FROM common_course_type WHERE common_course_type_id=" . $l_id;
        $d_ids = mysqli_query($dbc, $query);
        foreach ($d_ids as $a) 
        {
            $d_id = $a['dept_id'];
        }
        foreach ($selected_semesters as $semester) 
        {
            echo '<table align=center id=csv border="solid" >';?>
            <tr><th colspan="6">SEMESTER <?php echo $semester?>
            <tr><th>Papers</th>
                <th>CE</th>
                <th>ESE</th>
                <th>Total</th>
                <th>Grade</th>
                <th>Status</th></tr><?php
            $totalCredit=0;
            $SGPA = 0;
            $percentage =0;
            $TotalCreditPoint=0;
       
            foreach ($course_ids as $a) 
            {
                $course_id = $a['course_id'];
                $query = "SELECT course_title, course_type_id, dept_id, total_internal,total_external,credits FROM course
                            WHERE course_id = " . $course_id . "  AND semester =".$semester."
                            AND credits <> " . $credit . " AND  syllabus_intro_year
                            IN (" . $year . ", " . $year2 . ")";
                
                $courses = mysqli_query($dbc, $query);
          
                foreach ($courses as $a)
                {
                    $i=0;
                    $p="P";
                    $f="F";
              
                    $CreditPoint=0;
                    $course_type_id = $a['course_type_id'];
                    $dept_id = $a['dept_id'];
                    $total_internal =$a['total_internal'];
                    $total_external =$a['total_external'];
                    $credits = $a['credits'];
                            
              
                    if ($course_type_id == 4 && $dept_id != 2) 
                    {
                        if ($dept_id == $d_id) 
                        {
                            $course_title = $a['course_title'];
                        } 
                        else 
                        {
                            continue;
                        }
                    }
                    else 
                    {
                        $course_title = $a['course_title'];
                    }?>
                    <tr><th> <?php echo $course_title; '<br>'; ?> </th>
                    <?php
                        $query3 = "SELECT ce,ese FROM sem_exam WHERE stud_id = " . $stud_id . " AND course_id = " . $course_id;
                                $marks = mysqli_query($dbc, $query3);
                        
                        while ($row = mysqli_fetch_assoc($marks)) 
                        {
                            $ce = $row['ce'];
                            echo "<td> {$ce} </td>";
                        
                            $ese = $row['ese'];
                            echo "<td> {$ese} </td>";
                            
                        }  
                            $mark = $ese + $ce;
                            echo "<td> {$mark} </td>";
                            $GP = ($mark/($total_external+$total_internal)) * 10 ;
                            
                            $CreditPoint=$credits * $GP;
                            
                            $TotalCreditPoint = $TotalCreditPoint+$CreditPoint;
                            
                            $totalCredit = $totalCredit + $credits;
                            if($GP >= 9.00)
                            {
                                echo "<td> A+ </td>";
                            }
                            else if($GP >= 8.00 && $GP <= 8.99)
                            {
                                echo "<td> A </td>";
                            }
                            else if($GP >= 7.00 && $GP <= 7.99)
                            {
                                echo "<td> B </td>";
                            }
                            else if($GP >= 6.00 && $GP <= 6.99)
                            {
                                echo "<td> C </td>";
                            }
                            else if($GP >= 5.00 && $GP <= 5.99)
                            {
                                echo "<td> D</td>";
                            }
                            else
                            {
                                if($total_external == 40)
                                {
                                    if(($ese >= 16) && ($ce + $ese >=20))
                                    {   
                                        echo "<td> E </td>";
                                    }
                                    else
                                    {
                                        echo "<td> - </td>";
                                    }
                                }
                                if($total_external == 20)
                                {
                                    if(($ese >= 8) && ($ce + $ese >=10))
                                    {   
                                        echo "<td> E </td>";
                                    }
                                    else
                                    {
                                        echo "<td> - </td>";
                                    }
                                }
                            }
                            if($total_external == 40)
                            {
                                if(($ese >= 16) && ($ce + $ese >=20))
                                {
                                    $i=$i;
                                }
                                else
                                {
                                    $i=$i+1;
                                }
                                
                            }
                            else
                            {
                                if(($ese >= 8) && ($ce + $ese >=10))
                                {
                                    $i=$i;
                                }
                                else
                                {
                                    $i=$i+1;
                                }
                            }
                            if($i>0)
                            {
                                echo "<td>" .$f. "</td>";
                            }
                            else
                            {
                                echo "<td>" .$p. "</td>";
                            }
                }
            }
            ?>
                </tr><tr><th colspan="1">Percentage</th>
                <?php  
                    $SGPA= $TotalCreditPoint/ $totalCredit;
                    $percentage = $SGPA *10;
                    $all_per[] = $percentage; 
                    $all_sem[] = $semester; 
                    $formatted_percentage = number_format($percentage, 2);
                    echo "<td colspan=5>" . $formatted_percentage. "</td></tr>";
                    echo '</table>';
                    echo '<br>'; 
        }
            if($overallresult=="on")
            {
                $i=true;
                $credit=0;
                $query = "SELECT course_id FROM sem_exam WHERE stud_id = ".$stud_id." ";
                $course_ids = mysqli_query($dbc,$query);
                foreach ($course_ids as $a)
                {
                    $course_id = $a['course_id'];
                    $query = "SELECT semester FROM course WHERE course_id = ".$course_id." ";
                    $semesters = mysqli_query($dbc,$query);
                    foreach($semesters as $a)
                    {
                        $semester = $a['semester'];
                        if($semester==6)
                        {
                            $i=false;
                        }
                    }
                }
                if($i==true)
                {
                ?>
                    <table>
                        <tr>
                            <td>Marks in all semester are not uploaded yet</td>
                        </tr>
                    </table>
                <?php
                }
                else
                {
                    $common_course_mark_1=0;
                    $common_course_mark_1=0;
                    $core_course_mark=0;
                    $complimentary_elective_mark1=0;
                    $complimentary_elective_mark2=0;
                    $common_course_credit_1=$common_course_credit_2=$core_course_credit=$complimentary_elective_credit_1=$complimentary_elective_credit_2=0;          
                    $complimentary_total_max1=$complimentary_total_max2=$core_course_total_max=0;

                    $query = "SELECT cct.common_course_type_dec
                              FROM stud_master sm
                              INNER JOIN common_course_type cct ON sm.language_id = cct.common_course_type_id
                              WHERE sm.stud_id = " . $stud_id;
                    $common_courses = mysqli_query($dbc, $query);
                    foreach($common_courses as $a)
                    {
                        $common_course_2 = $a['common_course_type_dec'];
                    }
                    
                    $query = "SELECT d.dept_name 
                              FROM programme p
                              INNER JOIN department d ON p.dept_id = d.dept_id
                              WHERE p.pgm_id = " . $pgm_id;
                    $dept_names = mysqli_query($dbc,$query);
                    foreach($dept_names as $a)
                    {
                        $dept_name = $a['dept_name'];
                    }

                    $complimentary = [];
                    $depts = [];
                    $query = "SELECT course_id FROM sem_exam WHERE stud_id = ".$stud_id." ";
                    $course_ids = mysqli_query($dbc,$query);
                    foreach($course_ids as $a) 
                    {
                        $course_id = $a['course_id'];
                        $query = "SELECT course_type_id,dept_id,credits,course_title,total_internal,total_external FROM course WHERE course_id=".$course_id;
                        $course_type_ids = mysqli_query($dbc,$query);
                        foreach($course_type_ids as $a)
                        {
                            $course_type_id = $a['course_type_id'];
                            if($course_type_id==3)
                            {
                                $course_name = $a['course_title'];
                                $credit = $a['credits'];
                                $total_internal=$a['total_internal'];
                                $total_external=$a['total_external'];

                                
                                $dept_id = $a['dept_id'];
                                $query = "SELECT dept_name FROM department WHERE dept_id = ".$dept_id;
                                $dept_names = mysqli_query($dbc,$query);
                                foreach($dept_names as $a)
                                {
                                    $complimentary_elective = $a['dept_name'];
                                    $complimentary[] = $complimentary_elective;
                                    $depts[] = $dept_id;
                                    if($dept_id==$depts[0])
                                    {

                                        $complimentary_elective_credit_1=$complimentary_elective_credit_1+$credit;
                                        $query = "SELECT ce,ese FROM sem_exam WHERE stud_id = " . $stud_id . " AND course_id = " . $course_id;
                                        $marks = mysqli_query($dbc,$query);
                                        $ce_values = [];
                                        $ese_values = [];
                                        while ($row = mysqli_fetch_assoc($marks)) 
                                        {
                                            $ce = $row['ce'];
                                            $ce_values[] = $ce;
                                            $ese = $row['ese'];
                                            $ese_values[] = $ese;
                                            $total = $ese + $ce;
                                            
                                        }
                                        
                                        $complimentary_elective_mark1=$complimentary_elective_mark1+$total;
                                        
                                        $complimentary_elective_1_GP = number_format((($total/($total_external+$total_internal))*10),1);
                                        $complimentary_elective_1_CP = $complimentary_elective_1_CP+($credit*$complimentary_elective_1_GP);
                                        $complimentary_elective__1_OGPA=$complimentary_elective_1_CP/$complimentary_elective_credit_1;
                                    }
                                    else if($dept_id==$depts[1])
                                    {
                                        $complimentary_elective_credit_2=$complimentary_elective_credit_2+$credit;
                                        $query = "SELECT ce,ese FROM sem_exam WHERE stud_id = " . $stud_id . " AND course_id = " . $course_id;
                                        $marks = mysqli_query($dbc,$query);
                                        $ce_values = [];
                                        $ese_values = [];
                                        while ($row = mysqli_fetch_assoc($marks)) 
                                        {
                                            $ce = $row['ce'];
                                            $ce_values[] = $ce;
                                            $ese = $row['ese'];
                                            $ese_values[] = $ese;
                                            $total = $ese + $ce;
                                        }
                                        $complimentary_elective_mark2=$complimentary_elective_mark2+$total;
                                        
                                        $complimentary_elective_2_GP = number_format((($total/($total_external+$total_internal))*10),1);
                                        $complimentary_elective_2_CP = $complimentary_elective_2_CP+($credit*$complimentary_elective_2_GP);
                                        $complimentary_elective__2_OGPA=$complimentary_elective_2_CP/$complimentary_elective_credit_2;
                                    }
                                }
                            }
                            else if($course_type_id==1)
                            {
                                
                                    $total_internal=$a['total_internal'];
                                    $total_external=$a['total_external'];
                                    $credit = $a['credits'];
                                    $core_course_credit = $core_course_credit+$credit;
                                    $query = "SELECT ce,ese FROM sem_exam WHERE stud_id = " . $stud_id . " AND course_id = " . $course_id;
                                    $marks = mysqli_query($dbc,$query);
                                    foreach($marks as $a)
                                    {
                                        $ce = $a['ce'];
                                        $ese = $a['ese'];
                                        $total = $ese + $ce; 
                                    }  
                                    $core_course_mark=$core_course_mark+$total;

                                    $core_course_GP = number_format((($total/($total_external+$total_internal))*10),1);
                                    $core_course_CP = $core_course_CP+($credit*$core_course_GP);
                                    $core_course_OGPA=$core_course_CP/$core_course_credit;
                            }
                            else if($course_type_id==4)
                            {
                                    $dept_id = $a['dept_id'];
                                    if($dept_id==2)
                                    {
                                        $credit = $a['credits'];
                                        $total_internal=$a['total_internal'];
                                        $total_external=$a['total_external'];
                                        $common_course_credit_1 = $common_course_credit_1+$credit;
                                        $query = "SELECT ce,ese FROM sem_exam WHERE stud_id = " . $stud_id . " AND course_id = " . $course_id;
                                        $marks = mysqli_query($dbc,$query);
                                        foreach($marks as $a)
                                        {
                                            $ce = $a['ce'];
                                            $ese = $a['ese'];
                                            $total = $ese + $ce; 
                                            
                                        }  
                                        $common_course_1_GP = number_format((($total/($total_external+$total_internal))*10),1);
                                        $common_course_1_CP = $common_course_1_CP+($credit * $common_course_1_GP);
                                        $common_course_1_OGPA = $common_course_1_CP/$common_course_credit_1;
                                        
                                        $common_course_mark_1=$common_course_mark_1+$total;
                                    }
                                    
                                    else
                                    {
                                        $credit = $a['credits'];
                                        $total_internal=$a['total_internal'];
                                        $total_external=$a['total_external'];
                                        $common_course_credit_2=$common_course_credit_2+$credit;
                                        $query = "SELECT ce,ese FROM sem_exam WHERE stud_id = " . $stud_id . " AND course_id = " . $course_id;
                                        $marks = mysqli_query($dbc,$query);
                                        foreach($marks as $a)
                                        {
                                            $ce = $a['ce'];
                                            $ese = $a['ese'];
                                            $total = $ese + $ce; 
                                        } 
                                        $common_course_2_GP = number_format((($total/($total_external+$total_internal))*10),1);
                                        $common_course_2_CP = $common_course_2_CP+($credit * $common_course_2_GP);
                                        $common_course_2_OGPA = $common_course_2_CP/$common_course_credit_2;

                                        $common_course_mark_2=$common_course_mark_2+$total;  
                                        
                                    }
                                    
                            }
                            else
                            {
                                $open_credit = $a['credits'];
                                $total_internal=$a['total_internal'];
                                $total_external=$a['total_external'];
                                $query = "SELECT ce,ese FROM sem_exam WHERE stud_id = " . $stud_id . " AND course_id = " . $course_id;
                                $marks = mysqli_query($dbc,$query);
                                foreach($marks as $a)
                                {
                                    $ce = $a['ce'];
                                    $ese = $a['ese'];
                                    $total = $ese + $ce; 
                                } 
                                $opencourseGP = number_format((($total/($total_external+$total_internal))*10),2);
                                $opencourseCP = $credit*$opencourseGP;
                                $opencourseOGPA = $opencourseCP/$credit;
                            }
                        }
                        
                        $totalcredit=$common_course_credit_1+$common_course_credit_2+$core_course_credit+ $complimentary_elective_credit_1+$complimentary_elective_credit_2+$open_credit;
                        $totalcp=($complimentary_elective_1_CP+$core_course_CP+$complimentary_elective_2_CP+ $common_course_1_CP+ $common_course_2_CP+$opencourseCP)/$totalcredit;
                        
                    }

                    echo "<center><b>TOTAL RESULT<b><center><br>";
                    echo '<table align=center id=csv border="solid">
                        <tr>
                            <th colspan="2">Course</th>
                            <th>Credit</th>
                            <th>OGPA</th>
                            <th>Grade</th>
                            <th>Percentage</th>
                        </tr>
                        <tr>
                            <th>Common Course-I</th>
                            <th>English</th>
                            <td>'.$common_course_credit_1.'</td>
                            <td>'.number_format($common_course_1_OGPA, 3).'</td>
                            <td>'.calculateGrade($common_course_1_OGPA).'</td>
                            <td>'.number_format($common_course_1_OGPA * 10,2).'</td>
                        </tr>
                    
                        <tr>
                            <th>Common Course-II</th>
                            <th>'.$common_course_2.'</th>
                            <td>'.$common_course_credit_2.'</td>

                            <td>'.number_format($common_course_2_OGPA, 3).'</td>
                            <td>'.calculateGrade($common_course_2_OGPA).'</td>
                            <td>'.number_format($common_course_2_OGPA * 10,2).'</td>
                           
                        </tr>
                        <tr>
                            <th>Core Course </th>
                            <th>'.$dept_name.'</th>
                            <td>'.$core_course_credit.'</td>
                           
                            <td>'.number_format($core_course_OGPA,3).'</td>
                            <td>'.calculateGrade($core_course_OGPA).'</td>
                            <td>'.number_format($core_course_OGPA * 10,2).'</td>
                            
                        </tr>
                        <tr>
                            <th>Complementary Elective Course - I</th>
                            <th>'.$complimentary[0].'</th>
                            <td>'.$complimentary_elective_credit_1.'</td>
                           
                            <td>'.number_format($complimentary_elective__1_OGPA,3).'</td>
                            <td>'.calculateGrade($complimentary_elective__1_OGPA).'</td>
                            <td>'.number_format($complimentary_elective__1_OGPA * 10,2).'</td>
                        </tr>
                        <tr>
                            <th>Complementary Elective Course-II</th>
                            <th>'.$complimentary[1].'</th>
                            <td>'.$complimentary_elective_credit_2.'</td>
                            
                            <td>'.number_format($complimentary_elective__2_OGPA,3).'</td>
                            <td>'.calculateGrade($complimentary_elective__2_OGPA).'</td>
                            <td>'.number_format($complimentary_elective__2_OGPA * 10,2).'</td>
                        </tr>
                        <tr>
                            <th>Generic Elective Course</th>
                            <td> </td>
                            <td>2</td>
                            <td>'.number_format($opencourseOGPA,3).'</td>
                            <td>'.calculateGrade($opencourseOGPA).'</td>
                            <td>'.number_format($opencourseOGPA * 10,2).'</td>
                        </tr>
                        <tr><th colspan="2">Total for Programme</th>
                        
                        <td><b>'.$totalcredit.'<b></td>
                       <td><b>'.number_format($totalcp,3).'<b></td>
                       <td><b>'.calculateGrade($totalcp).'<b></td>
                       <td><b>'.number_format($totalcp * 10,2).'<b></td>
                       </tr>

                    </table>';
                }
            }
           



            if($graph=="on") 
            {   
            ?>
                <canvas id="percentageChart" style="width: 200px; height: 100px;"></canvas>
            <?php
            }
}           
?>


<script>

var percentages = <?php echo json_encode($all_per); ?>;
var semesters = <?php echo json_encode($all_sem); ?>;

var ctx = document.getElementById('percentageChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar', 
    data: {
        labels: semesters,
        datasets: [{
            label: 'Percentage',
            data: percentages,
            backgroundColor: 'rgba(75, 192, 192, 0.5)', 
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1,
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                max: 100, 
                title: {
                    display: true,
                    text: 'Percentage',
                    fontSize: 14 
                },
                ticks: {
                    fontSize: 12 
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Semester',
                    fontSize: 14 
                },
                ticks: {
                    fontSize: 12 
                }
            }
        }
    }
});

</script>