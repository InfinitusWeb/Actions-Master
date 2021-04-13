<?php

namespace sys;

use Exception;
use stdClass;
use PHPMailer\vendor\phpmailer\src;
use actions_master;


//require_once 'IWDBMaint.class.php';

class IWMailer {
    /** @var PHPmailer */
    private $mail;

    /** @var stdClass */
    private $data;

    /** @var Exception */
    private $error;

    public function __construct () {
        $this->mail = new PHPMailer();
        $this->data = new stdClass();

        $this->mail->isSMTP();
        //$this->mail->isHtml();
        $this->mail->setLanguage("pt_br");


    }
}
