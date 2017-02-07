<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH . "third_party/MX/Loader.php";

class MY_Loader extends MX_Loader {

    public function _ci_load_custom($_ci_data, $default = false) {
        
        extract($_ci_data);
        
        //alihkan path jika setting default false
        if ($default == false) {
            $this->_ci_view_paths = array($custom_path => 1);
        }

        if (isset($_ci_view)) {
            $_ci_path = '';
            $_ci_file = strpos($_ci_view, '.') ? $_ci_view : $_ci_view . EXT;
            foreach ($this->_ci_view_paths as $path => $cascade) {
                if (file_exists($view = $path . $_ci_file)) {
                    $_ci_path = $view;
                    break;
                }

                if (!$cascade) {
                    break;
                }
            }
        } elseif (isset($_ci_path)) {
            $_ci_file = basename($_ci_path);
            if (!file_exists($_ci_path)) {
                $_ci_path = '';
            }
        }

        if (empty($_ci_path)) {
            show_error('Unable to load the requested file: ' . $_ci_file);
        }
        
        if (isset($_ci_vars)) {
            $this->_ci_cached_vars = array_merge($this->_ci_cached_vars, (array) $_ci_vars);
        }

        extract($this->_ci_cached_vars);
        ob_start();

        if ((bool) @ini_get('short_open_tag') === FALSE AND CI::$APP->config->item('rewrite_short_tags') == TRUE) {
            echo eval('?>' . preg_replace("/;*\s*\?>/", "; ?>", str_replace('<?=', '<?php echo ', file_get_contents($_ci_path))));
        } else {
            include($_ci_path);
        }

        log_message('debug', 'File loaded: ' . $_ci_path);

        if ($_ci_return == TRUE) {
            return ob_get_clean();
        }

        if (ob_get_level() > $this->_ci_ob_level + 1) {
            ob_end_flush();
        } else {
            CI::$APP->output->append_output(ob_get_clean());
        }
    }

    public function custom_view($template_path, $view, $vars = array(), $return = FALSE) {

        list($path, $_view) = Modules::find_custom($view, $this->_module, 'views/');
        if ($path != FALSE) {
            $this->_ci_view_paths = array($path => TRUE) + $this->_ci_view_paths;
            $view = $_view;
        }

        return $this->_ci_load_custom(
                        array(
                            'custom_path' => $template_path,
                            '_ci_view' => $view,
                            '_ci_vars' => $this->_ci_object_to_array($vars),
                            '_ci_return' => $return
                        )
        );
    }

}