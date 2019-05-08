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

$sqlStr = "SELECT NoteID, NoteName FROM note WHERE NoteID = '" . $_SESSION['NoteID'] . "'";
$sqlQuery = mysqli_query($dbConnect, $sqlStr);
$sqlResult = mysqli_fetch_array($sqlQuery);
if (!$sqlResult) {
    printf("Error: %s\n", mysqli_error($dbConnect));
    exit();
}
?>

<html>

<body>
    <a href="clearEditPerm.php">Back</a> <br>
    <form name="editNote" method="post" action="saveEditNote.php">
        <input type="text" name="NoteName" id="NoteName" value="<?php echo $sqlResult['NoteName'] ?>">
        <input type="submit" name="" id="">
    </form>
    <br>
    <a href="editNotePerm.php">Edit Permission</a>
</body>

</html>