<?php
$db = new PDO('mysql:host=localhost;dbname=bd_feelfinds', 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>