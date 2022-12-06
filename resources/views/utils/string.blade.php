<?php
    function cutString($str) {
        if(strlen($str) > 50) {
            return substr($str, 0 , 50) . '...';
        }
        return $str;
    }
