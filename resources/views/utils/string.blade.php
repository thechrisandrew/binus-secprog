<?php
    function cutString($str) {
        if(strlen($str) > 200) {
            return substr($str, 0 , 200) . '...';
        }
        return $str;
    }
