<?php
    function validate_artID($field){
        if ($field == "") 
            return "No artist ID entered";
        else if (preg_match("/[^0-9]/", $field))
            return "Only numbers in artID's<br>";
        return "";
    }
    function validate_artName($field){
        if ($field == "") 
            return "No name entered";
        else if (preg_match("/[^a-zA-Z0-9-.\s!()]/", $field))
            return "Character not allowed for name...<br>";
        return "";
    }    
    function validate_trackName($field){
        if ($field == "") 
            return "No name entered";
        else if (preg_match("/[^a-zA-Z0-9-.\s]/", $field))
            return "Character not allowed for name...<br>";
        return "";
    }
?>