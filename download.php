<?php
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename=data.csv');
    header('Pragma: no-cache'); 
    readfile("data.csv");
?>

