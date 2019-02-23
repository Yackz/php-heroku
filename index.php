<?php
    include './validation.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
    <title>Calculate GPA</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">  
    <link rel="stylesheet" href="home.css">  
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
</head>
<body>
    <div class="container" style="text-align:center;">
            <h1 style="color:red;text-align:center;font-size:40px;font-family: 'Roboto+Condensed', cursive;
            word-spacing:5px;text-shadow: 3px 2px brown;border-style: dashed;border-width: 5px;">Your have problem with calculate GPA?</h1>
            <h2>This web will help you from that!!!!</h2>  
            <form class="flex-container2" action="index.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label style = "font-family: 'Roboto+Condensed', cursive;font-size:33px; color:red;" for="name">First Name:</label>
                    <br>
                    <input type="text" name="name" placeholder="  Name" aria-describedby="name">
                    <small id="name" class="form-text text-muted" style="color: red;">
                        <?php echo $nameErr;?>                  
                    </small>
                </div>
                <div class="form-group">
                    <label style = "font-family: 'Roboto+Condensed', cursive;font-size:33px; color:red;" for="lastname">Last Name:</label>
                    <br>
                    <input type="text" name="lastname" placeholder="  Lastname" aria-describedby="lastname">
                    <small id="lastname" class="form-text text-muted" style="color: red;">
                        <?php echo $lastnameErr;?>
                    </small>
                </div>
                <div class="file">
                    <h3>Image :</h3>
                    <input style="margin-left:22%;" type="file" name="img" id="img" accept=".jpg" ><br>
                    <H3>CSV File :</H3>
                    <input style="margin-left:22%;" type="file" name="csv" id="file" accept=".csv"><br><br>
                    <button type="submit" name="submit" class="btn btn-success" style="width:120px;height:50px;margin-left:7%;" >Calculate</button>&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                
            </form>
            <br>
            <form method="post" action="download.php">
                <button type="submit" class="btn btn-success"style="width:150px;height:50px;margin-left:1%;" >&nbsp;Download CSV</i></button>
            </form> 
            
        </div>
        <?php
        if (isset($_POST['submit'])){
            $file = $_FILES['csv'];
            $fileName = $_FILES['csv']['name'];
            $fileTmp = $_FILES['csv']['tmp_name'];
            $fileDest = 'Data/'. 'data.csv';
            move_uploaded_file($fileTmp, $fileDest);
            $img = $_FILES['img'];
            $imgName = $_FILES['img']['name'];
            $imgTmp = $_FILES['img']['tmp_name'];
            $imgDest = 'Data/'. 'img.jpg';
            move_uploaded_file($imgTmp, $imgDest);
            echo "<br>" . "<br>" . "<div style=\"text-align:center;font-size:32px;\">" . '<img width = "200px" height = "200px"  src="./Data/img.jpg" alt="">'."</div>";
            $correct = true;
            if ($_POST["name"] == ""){
                // echo '<br><br> "style = text-align:"center" font-size:"32px"" Please enter your name.' . "<br>";
                echo "<div style=\"text-align:center;font-size:32px;\">" . ' <br> Please enter your name.' . "<br>"."</div>";
            }
            if ($_POST["lastname"] == ""){
                echo "<div style=\"text-align:center;font-size:32px;\">" . "Please enter your surname.". "<br>" ."</div>";
                
            }   
            elseif (($handle = fopen($fileDest, "r")) !== FALSE) {
                echo "<div style=\"text-align:center;font-size:32px;\">" . "<br>Welcome " . $_POST["name"] . "  "  . $_POST["lastname"] ."</div>";
                // echo "<div style=\"text-align:center;font-size:32px;\">" . $_POST["lastname"] ."</div>" . "<br>";
                $total = 0.0;
                $user = 0.0;
                fgetcsv($handle);
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if ($data[1] == ""){
                        if ($data[0] == ""){
                            $correct = true;
                        }else{
                            $correct = FALSE;
                            echo "<div style=\"text-align:center;font-size:32px;\">" . $data[0] . " have blank in credit." . "<br>" ."</div>";
                            break;
                        }
                    }
                    if ($data[2] == ""){
                        if ($data[0] == ""){
                            $correct = true;
                        }else{
                            $correct = FALSE;
                            echo "<div style=\"text-align:center;font-size:32px;\">". $data[0] . " have blank in grade." . "<br>" ."</div>";
                            break;
                        }
                    }
                    if ($data[2] > 4 ) {
                        echo "<div style=\"text-align:center;font-size:32px;\">" . "Data Error Subject " . $data[0] . " grade more than 4 " . "<br>"."</div>";
                        $correct = FALSE;
                    }
                    elseif ($data[2] < 0 ) {
                        echo "<div style=\"text-align:center;font-size:32px;\">" ."Data Error Subject " . $data[0] . " grade less than 0 " . "<br>"."</div>";
                        $correct = FALSE;
                    }
                    $total += (float) $data[1];
                    $user = $user + ((float) $data[1] * (float) $data[2]); 

                }
                if ($correct == true){
                    echo "<div style=\"text-align:center;font-size:32px;color:red;\">" . "Your GPA = " . round($user / $total,2) ."</div>";
                }else{
                    echo "<div style=\"text-align:center;font-size:32px;\">" . "Please Correct the ERROR!!."."</div>";
                }   
                fclose($handle);
            }
        }
        ?>
        </div>
    </body>
</html>