<html>

<head>
    <style>
        div.overflow_auto {
            height: 100px;
            width: 800px;
            overflow: auto;
        }
    </style>
</head>

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

    $sqlStr = "SELECT EditID, LnNum, Text, Time FROM lnedit WHERE LineID_FK = '" . $_SESSION['LineID'] . "' ORDER BY Time DESC ";
    $sqlQuery = mysqli_query($dbConnect, $sqlStr);
    ?>
    <a href="editLn.php">Back</a>
    <br>
    <table width="800" border="1">
        <tr>
            <th width="30">Num</th>
            <th width="800">Text</th>
            <th>Time</th>
            <th>Edit</th>
        </tr>
        <?php
        //loop to print all user
        $count = 0;
        while ($sqlResult = mysqli_fetch_array($sqlQuery)) { ?>
            <tr>
                <td><?php echo $sqlResult["LnNum"] ?></td>
                <td>
                    <div class="overflow_auto">
                        <?php echo "<pre>" . $sqlResult["Text"] . "</pre>" ?>
                    </div>
                </td>
                <td><?php echo $sqlResult["Time"] ?></td>
                <td><a href="<?php if ($count != 0) echo "delLnHistory.php?EditID=". $sqlResult["EditID"] ?>" onclick="return confirm('Are you sure?')"><?php if ($count != 0) echo "DEL" ?></a></td>
            </tr>
        <?php $count++; } ?>
    </table>
    <?php mysqli_close($dbConnect) ?>
</body>

</html>