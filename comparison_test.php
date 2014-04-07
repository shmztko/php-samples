<?php
$hoge = "";
$foo = TRUE;

print("Strict comparison.<br/>");
var_dump($hoge === $foo);
print("<br/>");

print("Loose comparison.<br/>"); 
var_dump($hoge == $foo);
