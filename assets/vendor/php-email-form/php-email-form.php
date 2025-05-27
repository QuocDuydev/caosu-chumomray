<?php
class PHP_Email_Form {
    public $ajax = false;
    public $to = '';
    public $from_name = '';
    public $from_email = '';
    public $subject = '';
    private $messages = [];
    private $smtp = null;

    public function add_message($content, $name, $limit = 0) {
        $content = trim($content);
        if ($limit && strlen($content) > $limit) {
            $content = substr($content, 0, $limit) . '...';
        }
        $this->messages[$name] = $content;
    }

    public function send() {
        $headers = 'From: ' . $this->from_name . ' <' . $this->from_email . '>' . "\r\n";
        $headers .= 'Reply-To: ' . $this->from_email . "\r\n";
        $headers .= 'Content-Type: text/html; charset=UTF-8' . "\r\n";

        $message = '<html><body>';
        foreach ($this->messages as $name => $content) {
            $message .= '<p><strong>' . htmlspecialchars($name) . ':</strong> ' . htmlspecialchars($content) . '</p>';
        }
        $message .= '</body></html>';

        if ($this->smtp) {
            // SMTP code here if needed
            return 'SMTP not configured.';
        } else {
            if (mail($this->to, $this->subject, $message, $headers)) {
                return 'OK';
            } else {
                return 'Email sending failed.';
            }
        }
    }
}
?>