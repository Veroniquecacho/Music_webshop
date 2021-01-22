<?php

    function debug($info){
        if (gettype($info) === 'array') {
            print_r($info, true);
        } else {
            echo $info;
        }
        
    }

?>