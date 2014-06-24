<?php
require 'settings.php';
require 'Methods.php';
require 'Connector.php';
require 'Node.php';
require 'User.php';
require 'File.php';

// $cms = new File($options);
$cms = new Node($options);
$node = $cms->node_load(2);
// $node = $cms->user_list();
// $node->field_time_long['und'][0]['value'] = 15; // field_time_long should in your content type
// print_r($cms->node_save(2, $node));
// file_put_contents('/home/silas/Desktop/wind_rise.torrent', base64_decode($node->file));
print_r($node);
?>
