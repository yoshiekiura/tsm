<?php

/*
 * Excel Libraries
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once _doc_root . 'addons/phpexcel/PHPExcel.php';
require_once _doc_root . 'addons/phpexcel/PHPExcel/IOFactory.php';

class Excel extends PHPExcel {

    function __construct() {
        parent::__construct();
    }

}

?>
