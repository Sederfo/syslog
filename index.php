<?php
if (isset($_GET["error"])){
  $error = $_GET["error"];
  //dispay error message if error is returned by python script
  if ($error != "none")
    echo sprintf("
    
      <script>
          alert(%s);
          window.location = 'index.php';
      </script>
      
      ", "'". $error. "'");
  else 
  //display success message if python script successfully executed
    echo sprintf("
    
      <script>
          alert(%s);
          window.location = 'index.php';
      </script>
      
      ", "'". "Message successfully processed!" . "'");
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="index.css">
    <title>Syslog Message Formatter</title>
  </head>
  <body>
    <form method="POST" action="syslog_msg_formatter.php">
      <label for="msg"> Message: </label><br />
      <input type="text" name="msg" />
      <button type="submit"> Send </button>
    </form>

    <form method="POST" action="json_to_table.php" enctype="multipart/form-data"> 
      <label for="file"> File: </label><br />
      <input type="file" name="file"/>
      <button type="submit"> Send </button>
    </form>
  </body>
</html>
