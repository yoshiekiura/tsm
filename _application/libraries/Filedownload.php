<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * File Download Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Downloads
 * @version		1.0
 * @author		Matthew Glinski
 * @link		---- Not Yet Documented or Hosted ----
 */
class FileDownload {

    // Public Vars
    var $file = null;
    var $resume = true;
    var $filename = null;
    var $mime = null;
    var $speed = 0;
    // Private Vars, Do NOT Set!!
    var $CI;
    var $file_len = 0;
    var $file_mod = 0;
    var $file_type = 0;
    var $file_section = 0;
    var $bufsize = 1024;
    var $seek_start = 0;
    var $seek_end = -1;
    var $setup = false;

    /**
     * File Download Constructor
     *
     * The constructor sets up the download system as ready for files
     */
    function FileDownload() {
        $this->CI = & get_instance();
        log_message('debug', "Download Class Initialized");
    }

    /**
     * Set Config
     *
     * Sets Config Vars
     *
     * @access	public
     * @param	Config Array
     * @return	null
     */
    function set_config($config = array()) {
        if (count($config) > 0) {
            $this->_initialize($config);
        }
    }

    /**
     * Send Download
     *
     * Begins download
     *
     * @access	public
     * @param	Config Array
     * @return	integer OR false
     */
    function send_download($config = array()) {
        $this->CI = & get_instance();
        // Setup the download, or die on error.
        $this->_initialize($config);


        // Grab some vars
        $seek = $this->seek_start;
        $speed = $this->speed;
        $bufsize = $this->bufsize;
        $packet = 1;

        // Make sure we dont timeout wheil serving the download
        @set_time_limit(0);
        $this->bandwidth = 0;

        // Get the filesize and filename
        $size = filesize($this->file);
        if ($seek > ($size - 1))
            $seek = 0;
        if ($this->filename == null)
            $this->filename = basename($this->file);

        // Open a file pointer to the file
        $res = fopen($this->file, 'rb');

        // If partial request skip to the part we want
        if ($seek)
            fseek($res, $seek);
        if ($this->seek_end < $seek)
            $this->seek_end = $size - 1;

        $this->_send_headers($size, $seek, $this->seek_end); //always use the last seek
        $size = $this->seek_end - $seek + 1;

        $packet = 0;
        ignore_user_abort(true);

        // While the user is connected
        while (!($user_aborted = connection_aborted() || connection_status() == 1) && $size > 0) {
            // Serv the download, in chunks
            if ($size < $bufsize) {
                echo fread($res, $size);
                $this->bandwidth += $size;
            } else {
                echo fread($res, $bufsize);
                $this->bandwidth += $bufsize;
            }

            $size -= $bufsize;
            flush();

            // sleep for one second to control download speed, if needed
            if ($this->speed > 0 && ($this->bandwidth > ($this->speed * $packet * $this->bufsize))) {
                sleep(1);
                $packet++;
            }
        }
        fclose($res);

        // restore old status
        @ignore_user_abort($old_status);
        @set_time_limit(ini_get("max_execution_time"));

        return $this->bandwidth;
    }

    /**
     * Initialize the user preferences
     *
     * Accepts an associative array as input, containing display preferences
     *
     * @access	private
     * @param	array of config preferences
     * @return	void
     */
    function _initialize($config = array()) {
        if ($this->setup) {
            return true;
        }
        // Set Each Config Value
        foreach ($config as $key => $val) {
            $this->$key = $val;
        }

        if ($this->mime == NULL) {
            // Grab the file extension
            $x = explode('.', $this->file);
            $extension = end($x);

            // Load the mime types
            @include(APPPATH . 'config/mimes' . EXT);

            // Set a default mime if we can't find it
            if (!isset($mimes[$extension])) {
                $this->mime = 'application/octet-stream';
            } else {
                $this->mime = (is_array($mimes[$extension])) ? $mimes[$extension][0] : $mimes[$extension];
            }
        }

        // Is the client requesting a partial download?
        if ($this->CI->input->server('HTTP_RANGE')) {
            // What part of the file is the client requesting
            $seek_range = substr($this->CI->input->server('HTTP_RANGE'), strlen('bytes='));
            $range = explode('-', $seek_range);

            if ($range[0] > 0) {
                $this->seek_start = intval($range[0]);
            }

            if ($range[1] > 0) {
                $this->seek_end = intval($range[1]);
            } else {
                $this->seek_end = -1;
            }

            // Do we want to serve a partial request?
            if (!$this->resume) {
                $this->seek_start = 0;
            } else {
                $this->file_section = 1;
            }
        } else {
            // Serve the whole file, from the beginning
            $this->seek_start = 0;
            $this->seek_end = -1;
        }
    }

    /**
     * Send Headers
     *
     * Sends Download Headers to the client, describing the download
     *
     * @access	private
     * @param	size of file
     * @param	begining of file
     * @param	end of file
     * @return	void
     */
    function _send_headers($size, $seek_start=null, $seek_end=null) {
        // Generate the server headers
        header('Content-type: ' . $this->mime);
        header('Content-Disposition: attachment; filename="' . $this->filename . '"');
        header("Content-Transfer-Encoding: binary");
        header('Expires: 0');

        if ($this->file_section && $this->resume) {
            header("HTTP/1.0 206 Partial Content");
            header("Status: 206 Partial Content");
            header("Accept-Ranges: bytes");
            header("Content-Range: bytes $seek_start-$seek_end/$size");
            header("Content-Length: " . ($seek_end - $seek_start + 1));
        } else {
            header("Content-Length: $size");
        }

        if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")) {
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
        } else {
            header('Pragma: no-cache');
        }
    }

}

?>