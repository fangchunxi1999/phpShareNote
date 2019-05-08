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
    if ($_SESSION['isLnEditable'] != true || $_SESSION['LineID'] == "") {
        echo "Permission deined<br>";
        echo "<a href=\"clearEditPerm.php\">Back</a>";
        exit();
    }
    include("i.php");

    //get all user
    $sqlStr = "SELECT lnperm.UserID_FK, user.Username FROM lnperm INNER JOIN user ON lnperm.UserID_FK = user.UserID AND lnperm.LineID_FK = '" . $_SESSION['LineID'] . "' ORDER BY UserID_FK ASC";
    $sqlQuery = mysqli_query($dbConnect, $sqlStr);
    ?>
    <a href="editLn.php">Back</a>
    <br>
    <table border="1">
        <tr>
            <th>UserID</th>
            <th>Username</th>
            <th>DEL</th>
        </tr>
        <?php
        //loop to print all user
        while ($sqlResult = mysqli_fetch_array($sqlQuery)) { ?>
            <tr>
                <td><?php echo $sqlResult["UserID_FK"] ?></td>
                <td><?php echo $sqlResult["Username"] ?></td>
                <td><a href="delLnPerm.php?UserID=<?php echo $sqlResult["UserID_FK"] ?>" onclick="return confirm('Are you sure?')">DEL</a></td>
            </tr>
        <?php } ?>
    </table>
    <form name="addUser" method="post" action="addLnPerm.php">
        Add UserID: <input type="text" name="addUser" id="addUser">
        <input type="submit" name="" id="">
        <br>
    </form>
    <?php mysqli_close($dbConnect) ?>
</body>

</html>