<?php

class Widget {

    public $module_path;

    function run($file = '') {
        $args = func_get_args();
        $module = '';

        if (($pos = strrpos($file, '/')) !== FALSE) {
            $module = substr($file, 0, $pos);
            $file = substr($file, $pos + 1);
        }

        list($path, $file) = Modules::find($file, $module, 'widgets/');

        if ($path === FALSE) {
            $path = APPPATH . 'widgets/';
        }

        Modules::load_file($file, $path);

        /*
        $path = APPPATH . 'widgets/' . $user . '/';
        self::load_file($file, $path);
        */

        $file = ucfirst($file);
        $widget = new $file();

        $widget->module_path = $path;

        return call_user_func_array(array($widget, 'run'), array_slice($args, 1));
    }

    function render($view, $data = array()) {
        extract($data);
        include $view . EXT;
    }

    function load($object) {
        $this->$object = load_class(ucfirst($object));
    }

    function __get($var) {
        global $CI;
        return $CI->$var;
    }

    function load_file($file, $path, $type = 'other', $result = TRUE) {

        $file = str_replace(EXT, '', $file);
        $location = $path . $file . EXT;

        if ($type === 'other') {
            if (class_exists($file, FALSE)) {
                log_message('debug', "File already loaded: {$location}");
                return $result;
            }
            include_once $location;
        } else {

            /* load config or language array */
            include $location;

            if (!isset($$type) OR !is_array($$type))
                show_error("{$location} does not contain a valid {$type} array");

            $result = $type;
        }
        log_message('debug', "File loaded: {$location}");
        return $result;
    }

}
?>
