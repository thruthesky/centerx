<?php

class File extends Entity {


    public function __construct(int $idx)
    {
        parent::__construct(FILES, $idx);
    }

    public function upload($in) {
        debug_log($in);
        debug_log($_FILES);


        $name = basename($_FILES[USERFILE]['name']);
        $name = safeFilename($name);
        $path = UPLOAD_DIR . $name;


        if (move_uploaded_file($_FILES[USERFILE]['tmp_name'], $path)) {
           $record = $this->create([
               USER_IDX => my(IDX),
               TAXONOMY => $in[TAXONOMY],
               ENTITY => $in[ENTITY] ,
               CODE => $in[CODE],
               PATH => $path,
               NAME => $_FILES[USERFILE][NAME],
               SIZE => $_FILES[USERFILE][SIZE],
               TYPE => $_FILES[USERFILE][TYPE],
           ]);
           return $record;
        } else {
            debug_log("move_uploaded_file() - Possible file upload attack!");
            return e()->move_uploaded_file_failed;
        }




    }

    public function delete() {
        parent::delete();
    }
}


/**
 * Returns File instance.
 *
 * @note the function name is `files` since `file` exists as in PHP built-in function.
 *
 * @param array|int $idx - The `posts.idx` which is considered as comment idx. Or an array of the comment record.
 * @return File
 */
function files(array|int $idx=0): File
{
    if ( is_array($idx) ) return new File($idx[IDX]);
    else return new File($idx);
}

