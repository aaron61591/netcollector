<?php

class Collector_log {

    private $log;
    private $complete_date;
    private $date;

    public function __construct() {

        $this->log = fopen(__LOGS__ . $_SESSION['username'] . "_log.txt", "a");
        $this->date = date("H:i:s", time());
        $this->complete_date = date("M j,Y A g:i:s", time());
        fwrite($this->log, "=================================== Collect_type: Images ===================================\r\n\r\nClient Address: " . $_SERVER['REMOTE_ADDR'] . "\r\n\r\nStart Time: $this->complete_date\r\n");
    }

    public function page_log($current_url) {

        fwrite($this->log, "\r\n".$this->date . "  Current Page: " . $current_url."\r\n");
        fwrite($this->log, "-----------------------------------------\r\n");
    }

    public function content_log($content, $status) {

        if ($status) {
            fwrite($this->log, $this->date . "  " . $content . "  success\r\n");
        } else {
            fwrite($this->log, $this->date . "  " . $content . "  fail\r\n");
        }
    }

    public function __destruct() {

        fwrite($this->log, "\r\nTerminal Time: $this->date\r\n\r\n\r\n");
        fclose($this->log);
    }

}

?>
