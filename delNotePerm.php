<?php
session_start();
include("_sessionCheck.php");
if (!checkSession("index.php")) exit();
if ($_SESSION['UserID'] == "") {
    echo "<a href=\"login.php\">Please Login!</a>";
    session_destroy();
    exit();
}
if ($_SESSION['isNoteEditable'] != true || $_SESSION['NoteID'] == "") {
    echo "Permission deined<br>";
    echo "<a href=\"clearEditPerm.php\">Back</a>";
    exit();
}
include("i.php");

$UserID = (string)(int)mysqli_real_escape_string($dbConnect, trim($_GET['UserID']));
if (!is_int((int)$UserID)) {
    echo "Permission deined<br>";
    echo "<a href=\"editNotePerm.php\">Back</a>";
    mysqli_close($dbConnect);
    exit();
}

$sqlStr = "DELETE FROM noteperm WHERE UserID_FK = '" . $UserID . "' AND NoteID_FK = '" . $_SESSION['NoteID'] . "'";
$sqlQuery = mysqli_query($dbConnect, $sqlStr);
if (!$sqlQuery) {
    printf("Error: %s\n", mysqli_error($dbConnect));
    exit();
}
mysqli_close($dbConnect);
header("Location: editNotePerm.php");
