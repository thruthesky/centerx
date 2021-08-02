<?php
include '../boot.php';

if ( ! is_numeric(in(IDX, 0) ) ) {
    debug_log('ERROR; etc/phpthumbnail.php, input idx is not a number; ', in(IDX));
}
$file = files(in(IDX, 0));
$path = zoomThumbnail($file->path, in('w', 200), in('h', 200), in('q', 95));

header('Pragma: public');
header('Cache-Control: max-age=31536000'); // 365 days
header('Expires: '. gmdate('D, d M Y H:i:s \G\M\T', time() + 31536000)); // 365 days


$filename = basename($path);


$file_extension = strtolower(substr(strrchr($filename,"."),1));
if ( $file_extension == 'webp' ) {
    header('Content-Type: image/webp');
} else {
    header('Content-Type: image/jpeg');
}
readfile($path);

exit;
