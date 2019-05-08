<?php
session_start();
include("_sessionCheck.php");
if (!checkSession("index.php")) exit();
//get UserID NoteID LineID 
//check isLogin and edit permission
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

//get lastest line data from lnedit
$sqlStr = "SELECT EditID, LineID_FK, Text, LnNum FROM lnedit WHERE LineID_FK = '" . $_SESSION['LineID'] . "' ORDER BY Time DESC LIMIT 1";
$sqlQuery = mysqli_query($dbConnect, $sqlStr);
$sqlResult = mysqli_fetch_array($sqlQuery);
if (!$sqlQuery) {
    printf("Error: %s\n", mysqli_error($dbConnect));
    exit();
}

function isSelected($selected_option, $list_option_value)
{
    if ($selected_option == $list_option_value) {
        return 'selected';
    }
}
?>

<html>

<body>
    <!-- print from fill in -->
    <a href="clearEditPerm.php">Back</a> <br>
    <form name="editLn" method="post" action="saveEditLn.php">
        Editing Line <br>
        <table width="800" border="1">
            <tbody>
                <tr>
                    <th width="30">
                        <center>Old</center>
                    </th>
                    <th width="30">
                        <center>Num</center>
                    </th>
                    <th width="800">
                        <center>Text</center>
                    </th>
                </tr>
                <tr>
                    <td>
                        <center><?= $sqlResult['LnNum']; ?></center>
                    </td>
                    <td>
                        <select name="LnNum" id="LnNum">
                            <option value="1" <?php echo isSelected($sqlResult['LnNum'], '1') ?>>1</option>
                            <option value="0" <?php echo isSelected($sqlResult['LnNum'], '0') ?>>0</option>
                            <option value="2" <?php echo isSelected($sqlResult['LnNum'], '2') ?>>2</option>
                            <option value="3" <?php echo isSelected($sqlResult['LnNum'], '3') ?>>3</option>
                            <option value="4" <?php echo isSelected($sqlResult['LnNum'], '4') ?>>4</option>
                            <option value="5" <?php echo isSelected($sqlResult['LnNum'], '5') ?>>5</option>
                        </select>
                    </td>
                    <td><textarea name="LnText" id="LnText" cols="120" rows="5"><?= $sqlResult['Text']; ?></textarea></td>
                </tr>
            </tbody>
        </table>
        <input type="submit" name="" id="">
    </form>
    <a href="editLnPerm.php">Edit Permission</a>
    <a href="viewLnHistory.php">View History</a>
    <br>
    <a href="delLn.php?EditID=<?php echo $sqlResult['EditID'] ?>" onclick="return confirm('Are you sure?')">DEL Ln</a>
</body>

</html>

<?php mysqli_close($dbConnect); ?>