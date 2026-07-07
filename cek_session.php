<?php
session_start();
echo "<pre>";
print_r($_SESSION);
echo "\n--- COOKIE ---\n";
print_r($_COOKIE);
echo "</pre>";