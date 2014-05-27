<?php
require 'settings.php';
require 'service.php';

$cms = new Service($options);
$node = $cms->node_load(1);
print_r($node);
?>
