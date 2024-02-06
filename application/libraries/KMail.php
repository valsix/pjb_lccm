<?

class KMail {

    var $ci;
    var $Subject;
    var $to;

    function __construct() {

        $this->ci = get_instance();       
        $this->ci->load->library('email');
        $config['protocol']    = 'smtp';
        $config['smtp_host']    = 'smtp.gmail.com';
        $config['smtp_port']    = '465';
        $config['smtp_crypto'] = 'ssl';
        $config['smtp_timeout'] = '7';
        $config['smtp_user']    = 'aangsullivan@gmail.com';
        $config['smtp_pass']    = 'uynfqruletrzdjtj';
        $config['charset']    = 'utf-8';
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'text'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not   
        $this->ci->email->initialize($config);
        $this->ci->email->set_newline("\r\n");  
        $this->ci->email->set_mailtype("html");
        $this->to = array();  

    }

    function AddAddress($reqEmail="",$reqNama="")
    {
        $this->to[] = $reqEmail; 
    }

    function MsgHTML($message="")
    {
        $this->ci->email->message($message);
    }

    function Send()
    {
        $this->ci->email->from('aangsullivan@gmail.com', 'LCCM - PLN Nusantara Power'); 
        $this->ci->email->to($this->to); 
        $this->ci->email->subject($this->Subject);

        $this->ci->email->send();
        // echo $this->ci->email->print_debugger();
        return 1;
    }
}

?>
