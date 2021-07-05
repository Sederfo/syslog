<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="index.css">
    <title>JSON Table</title>
  </head>
  <body>
<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Allow certain file formats
if($imageFileType != "json") {
  echo "Sorry, only JSON files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file and render table
} else {
  if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
    ///////////////// DECODE JSON FILE /////////////////
    $string = file_get_contents($target_file);
    $data = json_decode($string, TRUE);

    //get keys to render table header
    $keys = array_keys($data);
    
    //open table
    echo "<table>";
    
    //draw header row
    echo "<tr>";
    foreach ($keys as $row)
      echo "<th>" . $row . "</th>";
    echo "</tr>";

    //fill in values
    echo "<tr>";
    foreach($data as $row)
      if (!is_array($row)){
        echo "<td> " . $row . "</td>";
      }
      //if json value is an array, iterate through it and draw all its elements in a single <td> tag
      else{
        echo "<td>";
        foreach($row as $el){
          echo $el . ", ";
        }
        echo "</td>";
      }
    echo "</tr>";
    
    //close table
    echo "</table>";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
?>
  </body>
</html>