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
    echo "<a href=\"clearNote.php\">Back</a>";
    exit();
}
include("i.php");

//clean up input data
$NoteName = mysqli_real_escape_string($dbConnect, trim($_POST['NoteName']));

$sqlStr = "UPDATE note SET NoteName = '" . $NoteName . "' WHERE NoteID = '" . $_SESSION['NoteID'] . "'";
$sqlQuery = mysqli_query($dbConnect, $sqlStr);

echo "Note Updated! <br>";
echo "<br><a href=\"clearEditPerm.php\">Back</a>";
mysqli_close($dbConnect);