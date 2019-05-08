<html>

<body>
    <?php
    session_start();
    include("_sessionCheck.php");
    if (!checkSession("index.php")) exit();
    if ($_SESSION['UserID'] == "") {
        echo "<a href=\"login.php\">Please Login!</a>";
        session_destroy();
        exit();
    }
    //reset permission
    $_SESSION['isNoteEditable'] = false;
    $_SESSION['isLnEditable'] = false;

    //clear NoteID LineID
    $_SESSION['NoteID'] = "";
    $_SESSION['LineID'] = "";

    include("i.php");

    //get username
    $sqlStr = "SELECT Username FROM user WHERE UserID = '" . $_SESSION['UserID'] . "'";
    $_username = mysqli_fetch_array(mysqli_query($dbConnect, $sqlStr))['Username'];

    //get note list
    $sqlStr = "SELECT notelist.NoteID_FK, note.NoteName FROM notelist INNER JOIN note ON notelist.NoteID_FK = note.NoteID AND notelist.UserID_FK = '" . $_SESSION['UserID'] . "'";
    $sqlQuery = mysqli_query($dbConnect, $sqlStr);
    ?>
    <a href="logout.php">Logout</a>
    <br>
    <h1>Note List</h1>
    <?php echo "Username: " . $_username . "(ID: " . $_SESSION['UserID'] . ")" ?>
    <br>
    <table border="1">
        <tr>
            <th>Note</th>
            <th>Open</th>
            <th>Leave</th>
        </tr>
        <?php
        while ($sqlResult = mysqli_fetch_array($sqlQuery)) { ?>
            <tr>
                <td><?php echo $sqlResult["NoteName"] ?></td>
                <td><a href="openNote.php?NoteID=<?php echo $sqlResult["NoteID_FK"] ?>">Open</a></td>
                <td><a href="leaveNote.php?NoteID=<?php echo $sqlResult["NoteID_FK"] ?>" onclick="return confirm('Are you sure?')">Leave</a></td>
            </tr>
        <?php } ?>
    </table>
    <a href="addNote.php">Add Note</a> <br>
    <form name="joinNote" method="post" action="joinNote.php">
        Join NoteID: <input type="text" name="joinNote" id="joinNote">
        <input type="submit" name="" id="">
        <br>
    </form>
    <?php mysqli_close($dbConnect) ?>
</body>

</html>