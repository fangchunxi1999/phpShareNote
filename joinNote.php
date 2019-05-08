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

$NoteID = (string)(int)mysqli_real_escape_string($dbConnect, trim($_POST["joinNote"]));
if (!is_int((int)$NoteID)) {
    echo "Permission deined<br>";
    echo "<a href=\"clearNote.php\">Back</a>";
    mysqli_close($dbConnect);
    exit();
}

//Check Note exist
$sqlStr = " SELECT NoteID FROM note WHERE NoteID = '" . $NoteID . "'";
if (!mysqli_fetch_array(mysqli_query($dbConnect, $sqlStr))) {
    echo "Note not exist!";
    echo "<br><a href=\"clearNote.php\">Back</a>";
    mysqli_close($dbConnect);
    exit();
}

//Check Note is added
$sqlStr = " SELECT NoteListID FROM notelist WHERE NoteID_FK = '" . $NoteID . "' AND UserID_FK = '" . $_SESSION['UserID'] . "'";
if (mysqli_fetch_array(mysqli_query($dbConnect, $sqlStr))) {
    echo "This note had been added!";
    echo "<br><a href=\"clearNote.php\">Back</a>";
    mysqli_close($dbConnect);
    exit();
}

$sqlStr = " INSERT INTO notelist (NoteID_FK, UserID_FK) VALUE ('" . $NoteID . "', '" . $_SESSION['UserID'] . "') ";
$sqlQuery = mysqli_query($dbConnect, $sqlStr);
if (!$sqlQuery) {
    printf("Error2: %s\n", mysqli_error($dbConnect));
    exit();
}
mysqli_close($dbConnect);
header("Location: notelist.php");
