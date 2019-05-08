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
    ?>

    <a href="clearNote.php">Back</a>
    <form name="addNote" method="post" action="saveAddNote.php">
        Add Note <br>
        Note Name: <input type="text" name="NoteName" id="NoteName">
        <input type="submit" name="" id="">
    </form>
</body>

</html>