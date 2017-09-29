<?php

function openDB()
{
    return new PDO(\config()["DB"]["DSN"], \config()["DB"]["Username"], \config()["DB"]["Password"], \config()["DB"]["Options"]);
}

?>

