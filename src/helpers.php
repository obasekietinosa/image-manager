<?php

function convertHexToRgb(string $hex) {
    list($r,$g,$b) = sscanf('#'.implode('',array_map('str_repeat',str_split(str_replace('#','',$hex)), [2,2,2])), "#%02x%02x%02x");
    return compact('r','g', 'b');
}