<?php
require('included.php');



print CITY . "<br/>";

for ($i = 1; $i <= 3; $i++) {
	include('included-' . $i . '.php');
}

print $city1 . "<br/>";
print $city2 . "<br/>";
print $city3 . "<br/>";