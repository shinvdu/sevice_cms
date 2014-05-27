<?php
require 'settings.php';
require 'Methods.php';
require 'Service.php';
require 'Node.php';

$cms = new Node($options);
$node = $cms->node_load(2);
$node->field_time_long['und'][0]['value'] = 15; // field_time_long should in your content type
print_r($cms->node_save(2, $node));
// print_r($node);
?>
