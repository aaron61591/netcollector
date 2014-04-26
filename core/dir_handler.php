<?php

class Dir_handler {

    private $userdir;
    private $imagesdir;
    private $collect_type;
    private $filename;
    private $dirname;
    private $file_count;
    private $fileprefix;

    public function __construct($collect_type) {

        $this->userdir = __DOWNLOADS__ . $_SESSION['username'];
        $this->imagesdir = $this->userdir . '/images/';
        $this->collect_type = $collect_type;
        $this->file_count = 0;
        $this->fileprefix = '';
        $this->filename = '';
        $this->dirname = '';
    }

    public function initialize_dir() {

        mkdir($this->userdir);
        switch ($this->collect_type) {
            case 'images':
                mkdir($this->imagesdir);
                break;
        }
        return 0;
    }

    public function create_dir($url) {

        $temp_dir = explode('/', $url);
        $this->filename = '';
        $this->filename = $temp_dir[(count($temp_dir) - 1)];
        if ($temp_dir[0] == 'http:' || $temp_dir[0] == 'https:') {
            $temp_dir = $temp_dir[2];
        } else {
            $temp_dir = $temp_dir[0];
        }
        $this->dirname = $this->imagesdir . $temp_dir;
        if (!is_dir($this->dirname)) {
            mkdir($this->dirname);
        }
        if (is_file($this->dirname . "/" . $this->filename)) {
            $this->fileprefix = date("ymjhis", time()) . "_" . $this->file_count++;
            $this->filepath = $this->dirname . "/" . $this->fileprefix . "_" . $this->filename;
        } else {
            $this->filepath = $this->dirname . "/" . $this->filename;
        }
        return $this->filepath;
    }

}

?>
