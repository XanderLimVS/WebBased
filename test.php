<?php 

include("includes/base.php");

echo "based load";


if (!$_user){
    echo "your are guest";
}else{
    echo "succesful login";
}

?>