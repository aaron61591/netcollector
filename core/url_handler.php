<?php

class Url_hanler {

    private $url;
    private $match_url;
    private $format_url;

    public function initialize_url($current_url) {

        $this->url = $current_url;
    }

    public function get_format_url() {

        $this->_format_url();
        return $this->format_url;
    }

    public function get_match_url() {

        $this->_match_url();
        return $this->match_url;
    }

    private function _format_url() {

        $this->format_url = explode('?', $this->url);
        if (!preg_match('/^https?:\/\/.*/', $this->format_url[0])) {
            $this->format_url = 'http://' . $this->format_url[0];
        } else {
            $this->format_url = $this->format_url[0];
        }
        if (preg_match('/^https?:\/\/[^\/]+\/?$/', $this->format_url)) {
            if (!preg_match('/.*\/$/', $this->format_url)) {
                $this->format_url.='/';
            }
        } else {
            //if people input a invaild, what should we do?
            if (preg_match('/^https?:\/\/[^\/]+\/.+\..+/', $this->format_url)) {
                $temp_arr = explode('.', $this->format_url);
                $this->format_url = "";
                for ($i = 0; $i < count($temp_arr); $i++) {
                    if (preg_match('/[^\/]+\/[^\/]+/', $temp_arr[$i])) {
                        for ($j = 0; $j < $i + 1; $j++) {
                            $this->format_url.=$temp_arr[$j] . ".";
                        }
                        break;
                    }
                }
                $temp_arr = explode('/', $this->format_url);
                $this->format_url = "";
                for ($i = 0; $i < count($temp_arr) - 1; $i++) {
                    $this->format_url.=$temp_arr[$i] . '/';
                }
            } else {
                if (!preg_match('/.*\/$/', $this->format_url)) {
                    $this->format_url.='/';
                }
            }
        }
    }

    private function _match_url() {

        $url_head = explode('/', $this->format_url);
        $url_arr = explode('.', $url_head[2]);
        $this->match_url = '';
        for ($i = 0; $i < count($url_arr); $i++) {
            if ($i != count($url_arr) - 1) {
                $this->match_url.=$url_arr[$i] . '\.';
            } else {
                $this->match_url.=$url_arr[$i];
            }
        }
    }

}

?>
