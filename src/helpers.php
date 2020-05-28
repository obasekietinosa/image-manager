<?php

function convertHexToRgb(string $hex) {
    list($r,$g,$b) = sscanf('#'.implode('',array_map('str_repeat',str_split(str_replace('#','',$hex)), [2,2,2])), "#%02x%02x%02x");
    return compact('r','g', 'b');
}

function resolvePosition(string $position, float $containerDimension, float $contentDimension)
{
  switch ($position) {
    case 'center':
      return ($containerDimension / 2) - ($contentDimension / 2);
      break;
    
    default:
      break;
  }
}