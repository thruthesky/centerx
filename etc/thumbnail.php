<?php
include '../boot.php';
$file = files(in(IDX));
$path = zoomThumbnail($file->path, in('w', 150), in('h', 150));

header('Pragma: public');
header('Cache-Control: max-age=86400');
header('Expires: '. gmdate('D, d M Y H:i:s \G\M\T', time() + 86400));
header('Content-Type: image/jpeg');



$filename = basename($path);
$file_extension = strtolower(substr(strrchr($filename,"."),1));

switch( $file_extension ) {
    case "gif": $ctype="image/gif"; break;
    case "png": $ctype="image/png"; break;
    case "jpeg":
    case "jpg": $ctype="image/jpeg"; break;
    case "svg": $ctype="image/svg+xml"; break;
    default:
}

header('Content-type: ' . $ctype);

readfile($path);

exit;