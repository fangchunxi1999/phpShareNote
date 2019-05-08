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

$NoteID = (string)(int)mysqli_real_escape_string($dbConnect, trim($_GET['NoteID']));
if (!is_int((int)$NoteID)) {
    echo "Permission deined<br>";
    echo "<a href=\"clearNote.php\">Back</a>";
    mysqli_close($dbConnect);
    exit();
}

$sqlStr = "DELETE FROM notelist WHERE NoteID_FK = '" . $NoteID . "' AND UserID_FK = '" . $_SESSION['UserID'] . "'";
$sqlQuery = mysqli_query($dbConnect, $sqlStr);
if (!$sqlQuery) {
    printf("Error1: %s\n", mysqli_error($dbConnect));
    exit();
}

mysqli_close($dbConnect);
header("Location: notelist.php");
