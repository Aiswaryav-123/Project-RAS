<style>
    body{
     background: #EAF4FC;
    }
  </style>
<?php
 error_reporting(E_ALL);
 ini_set('display_errors', 1);
require_once('appvars.php');
require_once('connectvars.php');
session_start();
$page_title = 'Single Subject Analysis';
require_once('header.php');
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (isset($_SESSION['username']))
    {
        /*if (isset($_GET['pgm_id'])) {
            $pgm_id = $_GET['pgm_id'];
            echo $pgm_id;
        }  */
        if (isset($_GET['semester'])) {
            $semester = $_GET['semester']; 
        }
        if (isset($_GET['year_of_admn'])) {
            $year_of_admin = $_GET['year_of_admn'];
        }
    }

?>
 <div class="filterform">
    <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="hidden" name="pid" id="pid" value="<?php echo $_GET['pgm_id']; ?>">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php require_once('navmenu.php'); 
     $year = 2019;
     $year2 = 2020;
     $credit = 0;
     $pgm_id = $_GET['pgm_id'];
     $query2 = "SELECT course_id FROM pgm_course WHERE pgm_id = " . $pgm_id;
     $course_ids = mysqli_query($dbc, $query2);
     echo '<table align="center">';
     foreach ($course_ids as $a) {
        $course_id = $a['course_id'];
        $query = "SELECT course_title FROM course
                  WHERE course_id = " . $course_id . " AND semester = " . $semester."  AND credits <> " . $credit . " AND  syllabus_intro_year
                      IN (" . $year . ", " . $year2 . ")";
        $courses = mysqli_query($dbc, $query);
        while ($row = mysqli_fetch_assoc($courses)) {
            $course_title = $row['course_title'];
            $unique_course_titles[] = $course_title; 
        }
    }
    foreach ($unique_course_titles as $course_title) : ?>
   <tr>
    <th><input type="radio" name="course_title" value="<?php echo htmlspecialchars($course_title); ?>"></th>
    <td><label><?php echo $course_title; ?></label></td>
    
    </tr>
   
    <?php endforeach; ?>
    </table>  
    <br><button type="submit" value="Log In" name="submit" class="upload-button1">SEARCH</button><br/>
    </form><?php
        if (isset($_POST['submit']))
        {

            if (isset($_POST['course_title'])) {
                $selectedCourseTitle = $_POST['course_title'];
                echo "Selected Course Title: " . htmlspecialchars($selectedCourseTitle);
            } 
            
            $pgm_id = $_POST['pgm_id'];
            echo $pgm_id;
            echo '<h3 align=center>Analysis</h3>';
            echo '<table align="center" border="solid">';
            echo '<tr><th>Register No.</th><th>Name</th';
        }?>
    </div>
   
           
    