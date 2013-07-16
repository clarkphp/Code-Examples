<?php
if (! empty($_POST)) {
    echo 'POST: <pre>';
    print_r($_POST);
    echo nl2br("</pre>\n");
}
if (! empty($_GET)) {
    echo 'GET: <pre>';
    print_r($_GET);
    echo nl2br("</pre>\n");
}
if (! empty($_GET['options'][1])) {
    echo 'The second option value is :' . $_GET['options'][1] . '<br />';
}
?>
<p>Form submitted as HTTP POST</p>
<form method="post" action="">
Label 1<input type="checkbox" name="options1" value="opt1" /><br />
Label 2<input type="checkbox" name="options2" value="opt2" /><br />
Label 3<input type="checkbox" name="options3" value="opt3" /><br />
<input type="submit" />
</form>

<p>Form submitted as HTTP GET</p>
<form method="get">
Label 1<input type="checkbox" name="options1" value="opt1" /><br />
Label 2<input type="checkbox" name="options2" value="opt2" /><br />
Label 3<input type="checkbox" name="options3" value="opt3" /><br />
<input type="submit" />
</form>

Numerical arrays in forms<br />
<form method="get">
Label 1<input type="checkbox" name="options[]" value="opt1" checked /><br />
Label 2<input type="checkbox" name="options[]" value="opt2" checked /><br />
Label 3<input type="checkbox" name="otheroptions" value="opt3" checked /><br />
<input type="submit" />
</form>

Associative arrays in forms<br />
<form method="post">
Label 1<input type="checkbox" name="options[key1]" value="opt1" checked /><br />
Label 2<input type="checkbox" name="options[key2]" value="opt2" checked /><br />
<input type="submit" />
</form>

Multidimensional associative arrays in forms<br />
<form method="post">
Label 1<input type="checkbox" name="options[key1][]" value="opt1" checked /><br />
Label 2<input type="checkbox" name="options[key1][]" value="opt2" checked /><br />
Label 3<input type="checkbox" name="options[key2][]" value="opt3" checked /><br />
<input type="submit" />
</form>


<?php 
/*
Client side vs. Server side validation
High traffic web sites benefit from client side validation, since it catches errors before the request
is sent to the server, reducing server load and wasted bandwidth. If you can verify the content of a field before it is submitted and processed
by the server, it makes sense to do so. Also is more user friendly.

Remember that javascript can be altered by a malicious user, so server-side validation MUST still be performed on all form data!

Form Validation
Age could be checked with ctype_digit()

Phone number could be checked with preg_match, since you can have (989) 123-4567,
or 989-123-4567, or 9891234567, or (989)123-4567, or 989.123.4567, etc.

String containing "Zend" could be checked with stripos(), case-insensitive search
for one string inside another.

Less than 255, obviously strlen().

First and last name - I would use something more robust than strpos($inputString, ' ').

Form that submits both GET and POST and the same time.

*/

exit;
//echo '<pre>'. print_r($_POST, true) . '</pre>';

if (! empty($_POST['username']) && ctype_alnum($_POST['username'])) {
    echo nl2br("Processing form\n");
} elseif (empty($_POST)) {
    //
} else {
    echo nl2br("Invalid username - only letters and digits allowed.\n");
}

$value = time();

?>
Login form<br />
<form method="post" action="forms.php?variable=<?php echo $value ?>">
Username: <input type="text" name="username" /><br />
Password: <input type="password" name="password" /><br />
<input type="submit" />
</form>

