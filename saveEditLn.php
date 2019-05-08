<?php
session_start();
include("_sessionCheck.php");
if (!checkSession("index.php")) exit();
if ($_SESSION['UserID'] == "") {
    echo "<a href=\"login.php\">Please Login!</a>";
    session_destroy();
    exit();
}
if ($_SESSION['isLnEditable'] != true || $_SESSION['LineID'] == "") {
    echo "Permission deined<br>";
    echo "<a href=\"clearEditPerm.php\">Back</a>";
    exit();
}
include("i.php");

//read old data
$sqlStr = "SELECT LnNum, Text FROM lnedit WHERE LineID_FK = '" . $_SESSION['LineID'] . "' ORDER BY Time DESC LIMIT 1 ";
$sqlQuery = mysqli_query($dbConnect, $sqlStr);
$sqlResult = mysqli_fetch_array($sqlQuery);
if (!$sqlQuery) {
    printf("Error1: %s\n", mysqli_error($dbConnect));
    exit();
}

//clean up input data
$lnNum_Save = mysqli_real_escape_string($dbConnect, trim($_POST['LnNum']));
$text_Save = mysqli_real_escape_string($dbConnect, trim($_POST['LnText']));

$lnNum_Old = mysqli_real_escape_string($dbConnect, $sqlResult['LnNum']);
$text_Old = mysqli_real_escape_string($dbConnect, $sqlResult['Text']);

//check is data changed 
if (!($lnNum_Old == $lnNum_Save && $text_Old  == $text_Save)) {
    $sqlStr = "INSERT INTO lnedit (LineID_FK, Text, LnNum) VALUE ('" . $_SESSION['LineID'] . "', '" . $text_Save . "', '" . $lnNum_Save . "')";
    $sqlQuery = mysqli_query($dbConnect, $sqlStr);
    echo "Line Updated! <br>";
    echo "<br><a href=\"clearEditPerm.php\">Back</a>";
} else {
    echo "Same Data, Update Cancel!\n";
    echo "<br><a href=\"clearEditPerm.php\">Back</a>";
}
mysqli_close($dbConnect);
