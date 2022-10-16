<?php

/**
 * @return resource|false
 */
function fileResource()
{
    return fopen(__DIR__.'/MyFile.json', 'r');
}
