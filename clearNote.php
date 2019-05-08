<?php
session_start();
include("_sessionCheck.php");
if (!checkSession("index.php")) exit();
$_SESSION['NoteID'] = "";
header("Location: notelist.php");