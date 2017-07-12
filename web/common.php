<?php
require_once('de_phrases.php');
require_once('ro_phrases.php');
session_start();

if(!isset($_SESSION["lang"])) {
    $_SESSION["lang"] = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
}

function translate($phrase) 
{
    global $ro_phrases, $de_phrases;
    if($_SESSION["lang"] == "de") {
        if(isset($de_phrases[$phrase])) {
            return $de_phrases[$phrase];
        } else {
            return $phrase;
        }
    } else if($_SESSION["lang"] == "ro") {
        if(isset($ro_phrases[$phrase])) {
            return $ro_phrases[$phrase];
        } else {
            return $phrase;
        }
    } else {
        return $phrase;
    }
}

?>