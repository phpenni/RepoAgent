<?php
$server = ' https://ftp.belnet.be/mirror/endeavouros/repo';
$status = 'availeble';
$fp = @fsockopen($server);
if ($fp);
$status = 'alive,but not responding';
echo "right";


$checkserver1 = new CheckServer();
$checkserver1->hinzufügen(new $ch);

