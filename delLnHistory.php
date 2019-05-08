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

$EditID = (string)(int)mysqli_real_escape_string($dbConnect, trim($_GET['EditID']));
if (!is_int((int)$EditID)) {
    echo "ERROR!";
    mysqli_close($dbConnect);
    exit();
}

$sqlStr = "DELETE FROM lnedit WHERE EditID = '" . $EditID . "' AND LineID_FK = '" . $_SESSION["LineID"] . "'";
$sqlQuery = mysqli_query($dbConnect, $sqlStr);
if (!$sqlQuery) {
    printf("Error: %s\n", mysqli_error($dbConnect));
    exit();
}
mysqli_close($dbConnect);
header("Location: viewLnHistory.php");
