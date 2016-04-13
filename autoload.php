<?php

spl_autoload_register(
    function ($className) {
        array_filter(['inc', 'spec'], function($dir) use($className) {
            $filename = $dir
                . DIRECTORY_SEPARATOR
                . join(DIRECTORY_SEPARATOR, explode('\\', $className))
                . ".php";
            if (file_exists($filename)) {
//                echo "Loading $filename\n";
                include($filename);
            }
        });
    }
);
