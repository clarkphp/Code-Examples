<?php
//$EOLN = "\n";
$EOLN = '<br />';

/**
 * Establish database connection
 */
$conn = mysql_connect('localhost', 'divasoft', 'p2b7dqa83');
if (!$conn) {
    exit('Could not connect: ' . mysql_error() . $EOLN);
}

$db_selected = mysql_select_db('divasoft', $conn);
if (!$db_selected) {
    exit ('Can\'t use this db : ' . mysql_error() . $EOLN);
}

/**
 * Display course catalog
 */
$result = mysql_query('select courses.name, instructors.first_name, last_name'
        . ' from courses, instructors where'
        . ' instructor_id = instructors.id'
        . ' order by courses.id');
if (!$result) {
    exit ('Can\'t select from table : ' . mysql_error() . $EOLN);
}
?>
<table border="1">
<caption>Course Catalog</caption>
<tr><th>Course</th><th>Instructor</th></tr>
<?php
while ($row = mysql_fetch_assoc($result)) :
?>
    <tr>
        <td><?php echo $row['name'] ?></td>
        <td><?php echo $row['first_name'] . ' ' . $row['last_name'] ?></td>
    </tr>
<?php
endwhile;
mysql_free_result($result);
?>
</table>

<?php
/**
 * Display Instructor list
 */
$result = mysql_query('select first_name, last_name from instructors'
                    . ' order by last_name, first_name asc');
if (!$result) {
    exit ('Can\'t select from table : ' . mysql_error() . $EOLN);
}
?>
<table border="1">
<caption>Our Instructors</caption>
<tr><th>Name</th></tr>
<?php
while ($row = mysql_fetch_assoc($result)) {
?>
    <tr>
        <td><?php echo $row['first_name'] . ' ' . $row['last_name'] ?></td>
    </tr>
<?php
}
mysql_free_result($result);
?>
</table>

<?php
/**
 * Display Student list
 */
$result = mysql_query('select first_name, last_name from students'
                    . ' order by last_name desc, first_name asc');
if (!$result) {
    exit ('Can\'t select from table : ' . mysql_error() . $EOLN);
}
?>
<table border="1">
<caption>Current Students</caption>
<tr><th>Name</th></tr>
<?php
while ($row = mysql_fetch_assoc($result)) {
?>
    <tr>
        <td><?php echo $row['first_name'] . ' ' . $row['last_name'] ?></td>
    </tr>
<?php
}
mysql_free_result($result);
?>
</table>

<?php
/**
 * Display Registrations
 */
$query = 'select courses.name as cn, students.first_name as sfn, students.last_name as sln,'
       . ' instructors.first_name as ifn, instructors.last_name as iln'
       . ' from courses_students, courses, students, instructors'
       . ' where courses_students.course_id = courses.id'
       . ' and courses_students.student_id = students.id'
       . ' and courses.instructor_id = instructors.id';

// mysql_real_escape_string()

$result = mysql_query($query);
if (!$result) {
    exit ('Can\'t select from table : ' . mysql_error() . $EOLN);
}
?>

<table border="1">
<caption>Registrations</caption>
<tr><th>Student</th><th>Course</th><th>Instructor</th></tr>
<?php
while ($row = mysql_fetch_assoc($result)) {
?>
    <tr>
        <td><?php echo $row['sfn'] . ' ' . $row['sln'] ?></td>
        <td><?php echo $row['cn'] ?></td>
        <td><?php echo $row['ifn'] . ' ' . $row['iln'] ?></td>
    </tr>
<?php
}
mysql_free_result($result);
?>
</table>

<?php
mysql_close($conn);