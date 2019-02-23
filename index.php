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
</head>
<body>
<div class="container">
            <h1>Is your have problem with calculate GPA</h1>
            <h2>This app will help you from that!!!!</h2>  
            <form class="flex-container2" action="index.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">First Name:</label>
                    <input type="text" name="name" placeholder="name" aria-describedby="name">
                    <small id="name" class="form-text text-muted" style="color: red;">
                        <?php echo $nameErr;?>                  
                    </small>
                </div>
                <div class="form-group">
                    <label for="lastname">Last Name:</label>
                    <input type="text" name="lastname" placeholder="lastname" aria-describedby="lastname">
                    <small id="lastname" class="form-text text-muted" style="color: red;">
                        <?php echo $lastnameErr;?>
                    </small>
                </div>
                <div>
                    Image :
                    <input type="file" name="img" id="img" accept=".jpg" ><br>
                    CSV File :
                    <input type="file" name="csv" id="file" accept=".csv"><br>
                    <button type="submit" name="submit">Calculate</button>
                </div>
            </form>
            <form method="post" action="download.php">
                <button type="submit" class="btn btn-success">&nbsp;Download CSV</i></button>
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
            echo '<img width = "200px" height = "200px" src="./Data/img.jpg" alt="">';
            $correct = true;
            if ($_POST["name"] == ""){
                echo "Please enter your name.". "<br>";
            }
            if ($_POST["lastname"] == ""){
                echo "Please enter your surname.". "<br>";
            }   
            elseif (($handle = fopen($fileDest, "r")) !== FALSE) {
                echo "Welcome " . $_POST["name"] . "  ";
                echo $_POST["lastname"] . "<br>";
                $total = 0.0;
                $user = 4.0;
                fgetcsv($handle);
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if ($data[1] == ""){
                        $correct = FALSE;
                        echo $data[0] . " have blank in credit." . "<br>";
                        break;
                    }
                    if ($data[2] == ""){
                        $correct = FALSE;
                        echo $data[0] . " have blank in grade." . "<br>";
                        break;
                    }
                    if ($data[2] > 4 ) {
                        echo "Data Error Subject " . $data[0] . " grade more than 4 " . "<br>";
                        $correct = FALSE;
                    }
                    elseif ($data[2] < 0 ) {
                        echo "Data Error Subject " . $data[0] . " grade less than 0 " . "<br>";
                        $correct = FALSE;
                    }
                    $total += (float) $data[1];
                    $user = $user + ((float) $data[1] * (float) $data[2]); 

                }
                if ($correct == true){
                    echo round($user / $total,2);
                }else{
                    echo "Please Correct the ERROR!!.";
                }   
                fclose($handle);
            }
        }
        ?>
        </div>
    </body>
</html>