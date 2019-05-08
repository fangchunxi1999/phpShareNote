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
    echo "<a href=\"clearNote.php\">Back</a>";
    exit();
}
include("i.php");

$LineID = (string)(int)mysqli_real_escape_string($dbConnect, trim($_GET['LineID']));
if (!is_int((int)$LineID)) {
    echo "Permission deined<br>";
    echo "<a href=\"clearEditPerm.php\">Back</a>";
    mysqli_close($dbConnect);
    exit();
}

$NoteID = $_SESSION['NoteID'];
//Check noteln(ownner)
$sqlStr = "SELECT OwnID_FK FROM noteln WHERE LineID = '" . $LineID . "'";
if (mysqli_fetch_array(mysqli_query($dbConnect, $sqlStr))['OwnID_FK'] == $_SESSION['UserID']) {
    $_SESSION['isLnEditable'] = true;
} else {
    //Check lnperm
    $sqlStr = "SELECT LnPermID FROM lnperm WHERE LineID_FK = '" . $LineID . "' AND UserID_FK = '" . $_SESSION['UserID'] . "'";
    if (mysqli_fetch_array(mysqli_query($dbConnect, $sqlStr))) {
        $_SESSION['isLnEditable'] = true;
    } else {
        //Check note(ownner)
        $sqlStr = "SELECT OwnID_FK FROM note WHERE NoteID = '" . $NoteID . "'";
        if (mysqli_fetch_array(mysqli_query($dbConnect, $sqlStr))['OwnID_FK'] == $_SESSION['UserID']) {
            $_SESSION['isLnEditable'] = true;
        } else {
            //Check noteperm
            $sqlStr = "SELECT NotePermID FROM noteperm WHERE NoteID_FK = '" . $NoteID . "' AND UserID_FK = '" . $_SESSION['UserID'] . "'";
            if (mysqli_fetch_array(mysqli_query($dbConnect, $sqlStr))) {
                $_SESSION['isLnEditable'] = true;
            } else {
                $_SESSION['isLnEditable'] = false;
            }
        }
    }
}
mysqli_close($dbConnect);
if ($_SESSION['isLnEditable'] == false) {
    echo "Permission deined<br>";
    echo "<a href=\"clearEditPerm.php\">Back</a>";
    exit();
}
$_SESSION['LineID'] = $LineID;
header("Location: editLn.php");
