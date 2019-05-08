<?php
//check is session started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//redirect user back to given web (.php) if var in $_SESSION array is not set to set var correctly 
//check UserID NoteID LineID isNoteEditable isLnEditable
function checkSession(string $redirectWebPath = null, bool $isDestroy = true)
{
    if (!isset($_SESSION['UserID']) || !isset($_SESSION['NoteID']) || !isset($_SESSION['LineID']) || !isset($_SESSION['isNoteEditable']) || !isset($_SESSION['isLnEditable'])) {
        //destroy session
        var_dump($_SESSION);
        if ($isDestroy) session_destroy();
        //redirect 
        if (!$redirectWebPath == null) header("Location: " . $redirectWebPath);
        //return false if var is missing
        return false;
    }
    //return true if all var is defined
    return true;
}

function createSession()
{
    $_SESSION['UserID'] = "";
    $_SESSION['NoteID'] = "";
    $_SESSION['LineID'] = "";
    $_SESSION['isNoteEditable'] = false;
    $_SESSION['isLnEditable'] = false;
}
