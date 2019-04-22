<?php
  include("sendmail.php");
  if(sendMail("manhtoan1409@gmail.com") == 1){
    echo "Send mail OK";
  }else{
    echo "Send mail fail lòi";
  }
?>