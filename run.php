<?php
require 'settings.php';
require 'Methods.php';
require 'Service.php';
require 'Node.php';

$cms = new Node($options);
$node = $cms->node_load(1);
print_r($node);
?>
