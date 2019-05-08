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
    echo "1 Permission deined<br>";
    echo "<a href=\"clearNote.php\">Back</a>";
    exit();
}
include("i.php");

$NoteID = $_SESSION['NoteID'];
//Check note(ownner)
$sqlStr = "SELECT OwnID_FK FROM note WHERE NoteID = '" . $NoteID . "'";
if (mysqli_fetch_array(mysqli_query($dbConnect, $sqlStr))['OwnID_FK'] == $_SESSION['UserID']) {
    $_SESSION['isNoteEditable'] = true;
} else {
    //Check noteperm
    $sqlStr = "SELECT NotePermID FROM noteperm WHERE NoteID_FK = '" . $NoteID . "' AND UserID_FK = '" . $_SESSION['UserID'] . "'";
    if (mysqli_fetch_array(mysqli_query($dbConnect, $sqlStr))) {
        $_SESSION['isNoteEditable'] = true;
    } else {
        $_SESSION['isNoteEditable'] = false;
    }
}
mysqli_close($dbConnect);
if (!$_SESSION['isNoteEditable']) {
    echo "Permission deined<br>";
    echo "<a href=\"clearNote.php\">Back</a>";
    exit();
}
header("Location: editNote.php");
