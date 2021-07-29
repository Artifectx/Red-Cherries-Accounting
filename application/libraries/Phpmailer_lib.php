<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter PHPMailer Class
 *
 * This class enables SMTP email with PHPMailer
 *
 * @category    Libraries
 * @author      CodexWorld
 * @link        https://www.codexworld.com
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PHPMailer_Lib {
    
    public function __construct() {
        log_message('Debug', 'PHPMailer class is loaded.');
    }

    public function load() {
        // Include PHPMailer library files
        require_once dirname(__FILE__) . '/PHPMailer/src/Exception.php';
        require_once dirname(__FILE__) . '/PHPMailer/src/PHPMailer.php';
        require_once dirname(__FILE__) . '/PHPMailer/src/SMTP.php';
        
        $mail = new PHPMailer;
        
        return $mail;
    }
}

