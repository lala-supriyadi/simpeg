<?php

class Auth extends CI_Controller {

    function __construct() {
        parent::__construct();
        define('CURRENT_CONTEXT', base_url() . 'auth/');
        init_generic_dao();
        $this->load->helper(array('form', 'url', 'html'));
        $this->load->model(array('m_user'));
        // $this->load->model('m_user', '', TRUE);
        $this->load->library('session');
        $this->data['page_title'] = "Login";
        $this->data['current_context'] = CURRENT_CONTEXT;
    }

    function index() {
        if (($this->session->userdata('logged_in') == TRUE)) {
            redirect('admin/dashboard');
        } else {
            $this->data['message'] = "";
            $this->load->view('login', $this->data);
        }
    }

    function Login() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $result = $this->m_user->check_login($username, $password);

        if ($result == TRUE) {
            $user = $this->m_user->by_id(array('username'=>$username));
            $newdata = array(
                'username' => $username,
                'role_id' => $user->role_id,
                'id_user' => $user->id_user,
                'logged_in' => TRUE
            );
            $this->session->set_userdata($newdata);
            redirect('dashboard');
        } else {
            $this->data['message'] = "Login Unsuccessfull, Please try Again!";
            $this->load->view('login', $this->data);
        }
    }

    function logout() {
        $newdata = array(
            'username' => '',
            'logged_in' => FALSE
        );
        $this->session->unset_userdata($newdata);
        $this->session->sess_destroy();
        redirect('auth');
    }

}

?>