<?php
file_put_contents(__DIR__ . "/debug_test_POST.txt", print_r($_POST, true));
echo "OK";
?>