<?php
function dbconnect(){
    $bdd= mysqli_connect('localhost','root','','employees');
    if(!$bdd){
        die("erreur");
    }
    return $bdd;
}
?>