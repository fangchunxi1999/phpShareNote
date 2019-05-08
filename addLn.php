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

    <a href="clearEditPerm.php">Back</a>
    <form name="addLn" method="post" action="saveAddLn.php">
        Adding Line <br>
        <table width="800" border="1">
            <tbody>
                <tr>
                    <th width="30">
                        <center>Num</center>
                    </th>
                    <th width="800">
                        <center>Text</center>
                    </th>
                </tr>
                <tr>
                    <td>
                        <select name="LnNum" id="LnNum">
                            <option value="0">0</option>
                            <option value="1" selected>1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </td>
                    <td><textarea name="LnText" id="LnText" cols="120" rows="5"></textarea></td>
                </tr>
            </tbody>
        </table>
        <input type="submit" name="" id="">
    </form>
</body>

</html>