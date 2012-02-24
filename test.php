<?php
$rand = rand();
$uniqid = uniqid($rand, true);
$md5 = md5($uniqid);

echo "rand:$rand<br>";
echo "uniqid:$uniqid<br>";
echo "md5:$md5";