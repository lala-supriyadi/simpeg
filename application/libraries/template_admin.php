<?php

class Template_admin {

    public $current_user;
    private $obj_id;
    private $message;

    function __construct() {
        $this->ci = &get_instance();
        $this->ci->load->library('session');
        $this->ci->load->model(array('m_user','m_menu','m_karyawan'));
        $this->preload();
    }

    function preload(){
        $this->obj_id = array('username' => $this->ci->session->userdata('username'));
        $this->current_user = $this->ci->m_user->by_id($this->obj_id);
        $this->notif = $this->ci->m_karyawan->getnotif();
    }

    function display($template, $data = null) {
        $notif = $this->ci->m_karyawan->getnotif();
        if (!empty($this->current_user)) {
            $current_menu = $this->ci->uri->segment(2);
            //menu
            $menu_result = $this->ci->m_menu->get_active_menu($this->current_user->role_id, null,false);
            $i = 0;
            foreach ($menu_result as $menu) {
                $this->obj_id = $menu->menu_id;
                $child = $this->ci->m_menu->get_active_menu($this->current_user->role_id, $this->obj_id,false);
                $menu_result[$i]->submenu = $child;
                $i++;
            }
            $menu_master = $this->ci->m_menu->get_active_menu($this->current_user->role_id, null,true);
            $i = 0;
            foreach ($menu_master as $menu) {
                $this->obj_id = $menu->menu_id;
                $child = $this->ci->m_menu->get_active_menu($this->current_user->role_id, $this->obj_id,true);
                $menu_master[$i]->submenu = $child;
                $i++;
            }
            $data['menu_trans'] = (!empty($menu_result)) ? $menu_result : array();
            $data['menu_master'] = (!empty($menu_master)) ? $menu_master : array();
            $data['login_user'] = $this->current_user;
            $data['current_menu'] = $current_menu;
            $data['_content'] = $this->ci->load->view($template, $data, true);
            $data['notif_user'] = $notif;

            $this->ci->load->view('/template.php', $data);
        } else {
            redirect(base_url() . 'auth');
        }
    }

}

?>