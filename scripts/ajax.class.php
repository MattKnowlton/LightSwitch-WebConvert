<?php

class ajax{
    public $init = false;
    private $Message = false;
    private $function = null;
    private $arguments = null;
    private $post = null;
    private $Return = null;
    private $ajaxI = null;

    public function __construct(){
        if(!isset($_POST['ajaxRequest'], $_POST['ajaxFunction'])) return;

        if(defined('RequireCSRFToken') && RequireCSRFToken == true) {
            if (session_status() != 2) session_start();
            if (!isset($_POST['_token']) || $_POST['_token'] != $_SESSION['_token']) {
                error_log(sprintf('Invalid request for %s with token %s (expected %s)', $_POST['ajaxFunction'], $_POST['_token'],
                    $_SESSION['_token']));
                $_SESSION['_token'] = generate_csrf_token();
                return;
            }
        }

        $this->init = true;

        ob_start();
        $this->post = $this->sanitizeArr((array)$_POST, 'htmlspecialchars');
        $this->arguments = $_REQUEST['Input'] = $this->sanitizeArr((array)@($_POST['arguments']), 'htmlspecialchars');
        $this->function = $_POST['ajaxFunction'];
        $this->ajaxI = $_POST['ajaxI'];
    }

    public function __destruct(){
        if($this->init != true) return false;
        if($this->Message == 'Success') return false;
        ob_clean();
        echo json_encode(['Message' => 'Failed', 'function' => $this->function]);
        ob_flush();
        exit();
    }

    public function addFunction($functionName, $functionCode){
        $this->addModule($functionName, $functionCode);
    }

    public function addModule($functionName, $functionCode){
        if(!$this->init || !isset($functionName, $functionCode) || $functionName != $this->function) return $this;
        $this->Message = 'Success';
        $this->Return = call_user_func($functionCode, $this->arguments);
        unset($this->post);
        $returnVars = get_object_vars($this);
        ob_clean();
        echo json_encode($returnVars);
        ob_flush();
        exit();
    }

    private function sanitizeArr($returnArr, $sanitizer = 'sanitize_sql_string') {
        array_walk_recursive($returnArr, function (&$value) use ($sanitizer) {
            $value = $sanitizer($value);
        });

        return $returnArr;
    }
}
