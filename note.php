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
    if ($_SESSION['NoteID'] == "") {
        echo "Permission deined<br>";
        echo "<a href=\"clearNote.php\">Back</a>";
        exit();
    }
    //reset permission
    $_SESSION['isNoteEditable'] = false;
    $_SESSION['isLnEditable'] = false;

    //clear LineID
    $_SESSION['LineID'] = "";

    include("i.php");

    //get note name
    $sqlStr = "SELECT NoteName FROM note WHERE NoteID = '" . $_SESSION['NoteID'] . "'";
    $_notename = mysqli_fetch_array(mysqli_query($dbConnect, $sqlStr))['NoteName'];

    //get all line
    $sqlStr =
        "SELECT noteln.LineID, lnedit_trim.LnNum, lnedit_trim.Text, lnedit_trim.Time
        FROM noteln 
        INNER JOIN 
            (SELECT tmp.* 
            FROM lnedit tmp 
            INNER JOIN 
                (SELECT LineID_FK, MAX(Time) AS MaxDateTime 
                FROM lnedit 
                GROUP BY LineID_FK) groupedtt 
            ON tmp.LineID_FK = groupedtt.LineID_FK 
            AND tmp.Time = groupedtt.MaxDateTime) lnedit_trim
        ON noteln.LineID = lnedit_trim.LineID_FK AND LnNum >= 0 AND NoteID_FK = '" . $_SESSION['NoteID'] . "' ORDER BY LnNum DESC";
    $sqlQuery = mysqli_query($dbConnect, $sqlStr);
    ?>
    <a href="clearNote.php">Back</a>
    <a href="addLn.php">Add Line</a>
    <a href="checkNotePerm.php">Edit</a>
    <h1>Note</h1>
    <?php echo "Notename: " . $_notename . "(ID: " . $_SESSION['NoteID'] . ")" ?>
    <br>
    <table width="800" border="1">
        <tr>
            <th width="30">Num</th>
            <th width="800">Text</th>
            <th width="30">Edit</th>
        </tr>
        <?php
        while ($sqlResult = mysqli_fetch_array($sqlQuery)) { ?>
            <tr>
                <td><?php echo $sqlResult["LnNum"] ?></td>
                <td>
                    <div class="overflow_auto">
                        <?php echo "<pre>" . $sqlResult["Text"] . "</pre>" ?>
                    </div>
                </td>
                <td><a href="checkLnPerm.php?LineID=<?php echo $sqlResult["LineID"] ?>">Edit</a></td>
            </tr>
        <?php } ?>
    </table>
    <?php mysqli_close($dbConnect) ?>
</body>

</html>