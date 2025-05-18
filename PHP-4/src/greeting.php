<?php 

include_once "./printer.php";
function greeting(?string $name=null) {
    if ($name == null) {
        pprint ("Hello!");
    } else {
        pprint ("Hello, $name!");
    }
}