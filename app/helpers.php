<?php

function get_object_id($class, $objectOrId) {
    $objectId = null;

    if (is_int($objectOrId))
        $objectId = $objectOrId;
    else if (is_object($objectOrId) && get_class($objectOrId) == $class)
        $objectId = $objectOrId->id;

//    if (!$objectId) throw new \InvalidArgumentException('Argument should be integer or '.$class.' object');

    return $objectId;
}



