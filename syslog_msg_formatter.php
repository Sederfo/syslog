<?php
$msg = $_POST["msg"];
$result = shell_exec('syslog_msg_formatter.py "'. $msg .'"');

echo $result;
if (strcmp($result, "Message successfully processed!\n")!=0){
    header(sprintf("Location: index.php?error=%s", $result));
    echo 1;
}
else{
    header("Location: index.php?error=none");
    echo 0;
}
?>