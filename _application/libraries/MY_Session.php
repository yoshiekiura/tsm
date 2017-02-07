<?php

class MY_Session extends CI_Session {

    function __construct() {
        parent::__construct();
    }

    /**
     * Gets all the flashdata stored in CI session
     *
     * @author Mirko Mariotti
     * @return Array The flashdata array
     */
    function all_flashdata() {
        $all_flashdata = $res = array();
        foreach ($this->all_userdata() as $k => $v) {
            if (preg_match('/^flash:old:(.+)/', $k, $res)) {
                $all_flashdata[$res[1]] = $this->userdata($this->flashdata_key . ':old:' . $res[1]);
            }
        }
        return $all_flashdata;
    }

}

?>
