<?php
    include 'cvs';
    if(isset($cvs)){
        foreach($cvs as $CV){
            echo $CV->infoInstance->profession;
        }
    }
    else{
        echo "accune cv trouvée";
    }
?>