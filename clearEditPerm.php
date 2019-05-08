<?php
session_start();
include("_sessionCheck.php");
if (!checkSession("index.php")) exit();
$_SESSION['isNoteEditable'] = false;
$_SESSION['isLnEditable'] = false;
header("Location: note.php");
