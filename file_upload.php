<?php

if($_SERVER["REQUEST_METHOD"]=="POST"){
  //Salvo il percorso+nome_file dell'upload temporanmeo:
  $tempPath = $_FILES["file"]["tmp_name"];
  //Creo una cartella vuota images
  if(!is_dir("images")){
      mkdir("images", 0777);
  }
  if(!empty($_FILES["image"])) {
    //sposta un file,primo argomento:directory partenza ,secondo argomento:directory di arrivo
    $tempDir = $_FILES["image"]["tmp_name"];
    $randDir = "images/" . uniqid();// si costruisce la cartella con un nome univoco
    $endDir = $randDir . "/" . $_FILES["image"]["name"];//costruisco la destinazione
    mkdir($randDir);
    move_uploaded_file($tempDir,$endDir);d_file($tempPath, $outputPath);
  }
}

;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
</head>
<body>
    <form action="file_ipload.php" method="POST" enctype="multipart/form-data" >
    <label for="My file">Image Upload</label>
    <input type="file" name="file" id="myFile"><br><br>

    <input type="submit" value="Upload">
    </form>   
</body>
</html>