<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Contato extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

    }

    function index(){
        $this->load->view('test.html');
    }

    public function formulario()
    {


        $_SESSION['CRF_TOKEN'] = uniqid('SPL');
        $data['token']= $_SESSION['CRF_TOKEN'];
        $this->layout->view('/contato/formulario', $data);


    }

    public function enviacontato()
    {
       /*if($_POST['crf']!=@$_SESSION['CRF_TOKEN']){
            die("<script>self.location='formulario'</script>");
       }
        unset($_SESSION['CRF_TOKEN']);
        */
        $this->form_validation->set_rules('nome', 'Nome', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('assunto', 'Assunto', 'required');
        $this->form_validation->set_rules('mensagem', 'Mensagem', 'required');

        $this->form_validation->set_message('valid_email', 'Informe um email válido');


        if ($this->form_validation->run() == FALSE) {
            $_SESSION['CRF_TOKEN'] = uniqid('SPL');
            $data['token']= $_SESSION['CRF_TOKEN'];
            $this->layout->view('/contato/formulario',$data);
        } else {
            $this->load->library('Emailmanager');
            $this->emailmanager->enviaContato($_POST);
            $this->layout->view('/contato/enviacontato');
        }

    }


    public function localizacao(){
        $this->layout->view('/contato/localizacao');
    }


    private function _create_captcha()
    {
        $this->load->helper('captcha');

        $vals = array(
            'word' => 'Random word',
            'img_path' => './files/captcha/',
            'img_url' => site_url() . 'files/captcha/',
            'font_path' => site_url() . 'assets/css/fonts/texb.ttf',
            'img_width' => '100',
            'img_height' => 30,
            'expiration' => 7200,
            'word_length' => 50,
            'font_size' => 120,
            'img_id' => 'Imageid',
            'pool' => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',

            // White background and border, black text and red grid
            'colors' => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(255, 40, 40)
            )
        );

        $cap = create_captcha($vals);
        $image = $cap['image'];
        $_SESSION['captchaword'] = $cap['word'];
        /*array (size=4)
          'word' => string 'Random word' (length=11)
          'time' => float 1420818412.6056
          'image' => string '<img src="http://uniten2015.dev/files/captcha/1420818412.6056.jpg" style="width: 150; height: 30; border: 0;" alt=" " />' (length=120)
          'filename' => string '1420818412.6056.jpg' (length=19)
        */

        return $image;
    }

    public function check_captcha($string)
    {
        if ($string == $_SESSION['captchaword']) {
            return TRUE;
        } else {
            $this->form_validation->set_message('check_captcha', 'Código de segurança inválido');
            return FALSE;
        }
    }


}

