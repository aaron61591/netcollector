<?php

class collector_core {

    private $url;
    private $collect_type;
    private $content_matches;
    private $result_page;
    private $collect_status;
    private $dir;
    private $curl;
    private $url_handler;
    private $log;
    private $layer_limit;
    private $page_content;
    private $content;
    private $pages_container;
    private $images_container;

    public function __construct($url, $collect_type) {

        $this->collect_type = $collect_type;
        $this->dir = new Dir_handler($this->collect_type);
        $this->dir->initialize_dir();
        $this->curl = new Curl_transfer();
        $this->url_handler = new Url_hanler();
        $this->log = new Collector_log();
        $this->url = $url;
        $this->result_page = __ROOT__ . '/result_page.php';
        $this->collect_status = false;
        $this->page_content = '';
        $this->layer_limit = 10;
        $this->pages_container = array();
        $this->images_container = array();
    }

    public function go_collecting() {

        $this->collecting_expand(0);
        return 0;
    }

    private function collecting_expand($layer_now) {

        ++$layer_now;
        $this->pages_container[] = $this->url;
        $this->url_handler->initialize_url($this->url);
        $format_url = $this->url_handler->get_format_url();
        $match_url = $this->url_handler->get_match_url();
        $this->log->page_log($this->url);
        $this->curl->initialize_url($this->url);
        $this->page_content = $this->curl->get_content();
        $this->collect_content($format_url, $match_url);
        if ($layer_now < $this->layer_limit) {
            preg_match_all("/<a[^>]+href=\"([^\"]+)\"[^>]*>/i", $this->page_content, $page_matches);
            for ($i = 0; $i < count($page_matches[1]); $i++) {
                if (strlen($page_matches[1][$i]) > 2 && !in_array($page_matches[1][$i], $this->pages_container)) {
                    if (!preg_match("/http|$match_url|[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}/", $page_matches[1][$i])) {
                        $page_matches[1][$i] = $format_url . $page_matches[1][$i];
                    }
                    $this->url = $page_matches[1][$i];
                    $this->collecting_expand($layer_now);
                }
            }
        }
        if ($layer_now == 1) {
            echo 'finish';
            die();
            $this->_finish_collect();
        }
        return 0;
    }

    private function collect_content($format_url, $match_url) {

        $this->curl->initialize_url($this->url);
        $this->content = $this->curl->get_content();
        switch ($this->collect_type) {
            case 'images':
                preg_match_all("/<img[^>]+src=\"([^\"]+)\"[^>]*>/i", $this->content, $this->content_matches);
                for ($i = 0; $i < count($this->content_matches[1]); $i++) {
                    if (!preg_match("/http|$match_url|[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}/", $this->content_matches[1][$i])) {
                        $this->content_matches[1][$i] = $format_url . $this->content_matches[1][$i];
                    }
                }
                break;
            default:
                echo 'The function is under building';
                break;
        }
        if (isset($this->content_matches[0][0])) {
            $this->_download_content();
        }
        return 0;
    }

    private function _download_content() {

        switch ($this->collect_type) {
            case 'images':
                for ($i = 0; $i < count($this->content_matches[1]); $i++) {
                    if (!in_array($this->content_matches[1][$i], $this->images_container)) {
                        $this->images_container[] = $this->content_matches[1][$i];
                        $this->curl->initialize_url($this->content_matches[1][$i]);
                        $this->content = $this->curl->get_content();
                        $this->log->content_log($this->content_matches[1][$i], file_put_contents($this->dir->create_dir($this->content_matches[1][$i]), $this->content));
                    }
                }
                break;
        }
        return 0;
    }

    private function _finish_collect() {

        Header('Location: ' . $this->result_page);
    }

}

?>