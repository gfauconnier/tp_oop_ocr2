<?php

function loadClasses($classname)
{
    require 'entities/'.$classname.'.php';
}

spl_autoload_register('loadClasses');


function sanitizeStr($string) {
  return filter_var($string, FILTER_SANITIZE_STRING);
}
