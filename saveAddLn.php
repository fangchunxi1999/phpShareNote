<?php
session_start();
include("_sessionCheck.php");
if (!checkSession("index.php")) exit();
if ($_SESSION['UserID'] == "") {
    echo "<a href=\"login.php\">Please Login!</a>";
    session_destroy();
    exit();
}
if ($_SESSION['NoteID'] == "") {
    echo "Permission deined<br>";
    echo "<a href=\"clearEditPerm.php\">Back</a>";
    exit();
}
include("i.php");

//clean up text
$lnNum_Save = mysqli_real_escape_string($dbConnect, trim($_POST['LnNum']));
$text_Save = mysqli_real_escape_string($dbConnect, trim($_POST['LnText']));

//Add new line to noteln
$sqlStr = "INSERT INTO noteln (NoteID_FK, OwnID_FK) VALUE ('" . $_SESSION['NoteID'] . "', '" . $_SESSION['UserID'] . "')";
$sqlQuery = mysqli_query($dbConnect, $sqlStr);
//get LineID
$lastLineID = mysqli_insert_id($dbConnect);
if (!$sqlQuery) {
    printf("Error1: %s\n", mysqli_error($dbConnect));
    exit();
}

//Add new text to LnEdit
$sqlStr = "INSERT INTO lnedit (LineID_FK, Text, LnNum) VALUE ('" . $lastLineID . "', '" . $text_Save . "', '" . $lnNum_Save . "')";
$sqlQuery = mysqli_query($dbConnect, $sqlStr);
if (!$sqlQuery) {
    printf("Error2: %s\n", mysqli_error($dbConnect));
    exit();
}
echo "Add Line!";
echo "<br><a href=\"clearEditPerm.php\">Back</a>";

mysqli_close($dbConnect);
