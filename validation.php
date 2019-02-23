<?php
        
        $nameErr = $lastnameErr = $fileErr ="";
        $name = $lastname =  "";
    
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["name"])) {
                $nameErr = "*Name is required";
            } else {
                $name = test_input($_POST["name"]);
            }
            
            if (empty($_POST["lastname"])) {
                $lastnameErr = "*Lastname is required";
            } else {
                $lastname = test_input($_POST["lastname"]);
            }
            
        }
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        ?>