<?php
$msg = $_POST["msg"];
//execute python script by command line with $msg argument
$result = shell_exec('syslog_msg_formatter.py "'. $msg .'"');

//return error message if exception occured
if (strcmp($result, "Message successfully processed!\n")!=0){
    header(sprintf("Location: index.php?error=%s", $result));
}
//return 'none' error code if everything is ok
else{
    header("Location: index.php?error=none");
}
?>