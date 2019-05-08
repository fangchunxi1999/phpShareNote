<?php
session_start();
include("_sessionCheck.php");
if (!checkSession("index.php")) exit();
if ($_SESSION['UserID'] == "") {
    echo "<a href=\"login.php\">Please Login!</a>";
    session_destroy();
    exit();
}
include("i.php");

//clean up text
$NoteName = mysqli_real_escape_string($dbConnect, trim($_POST['NoteName']));

//Add new Note to note
$sqlStr = "INSERT INTO note (NoteName, OwnID_FK) VALUE ('" . $NoteName . "', '" . $_SESSION['UserID'] . "')";
$sqlQuery = mysqli_query($dbConnect, $sqlStr);
//get NoteID
$lastNoteID = mysqli_insert_id($dbConnect);
if (!$sqlQuery) {
    printf("Error1: %s\n", mysqli_error($dbConnect));
    exit();
}

//Add new note to notelist
$sqlStr = "INSERT INTO notelist (NoteID_FK, UserID_FK) VALUE ('" . $lastNoteID . "', '" . $_SESSION['UserID'] . "')";
$sqlQuery = mysqli_query($dbConnect, $sqlStr);
if (!$sqlQuery) {
    printf("Error2: %s\n", mysqli_error($dbConnect));
    exit();
}
echo "Add Note!";
echo "<br><a href=\"clearNote.php\">Back</a>";

mysqli_close($dbConnect);