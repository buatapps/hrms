<?php
function humanFileSize($size)
{
    if ($size >= 1073741824) return round($size / 1073741824, 2) . ' GB';
    if ($size >= 1048576) return round($size / 1048576, 2) . ' MB';
    if ($size >= 1024) return round($size / 1024, 2) . ' KB';
    return $size . ' B';
}
