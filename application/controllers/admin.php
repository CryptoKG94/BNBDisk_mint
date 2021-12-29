<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Index
 *
 * @package     Controllers
 * @subpackage  null
 * @category    Controllers
 * @author      Guilherme Gatti
 * @link        null
 */
class Admin extends CI_Controller
{

    /**
     * Construct of CI_Controller
     *
     * @param  null  Do not have a param
     * @return null  Do not have a return
     */
    public function __construct()
    {
        /**
         * Instead the construct of CI_Controller
         */
        parent::__construct();

        // load download helder
        // $this->load->helper('download');
        // $this->load->library('zip');
    }

    /**
     * Index of the index page
     *
     * @param  null  Do not have a param
     * @return null  Do not have a return
     */
    public function index()
    {
        /**
         * Load all the views and send the data variable
         */

        // print_r($hash);

        $address = $this->session->userdata('address');

        // if (!$address || $address == '') {
        //     $data['sliced_address'] = '';
        // } else {
        //     $data['sliced_address'] = $this->main_model->ellipseAddress($address, ADDRESS_SLICE);
        // }

        $this->load->view('header');
        $this->load->view('adminpage');
        $this->load->view('footer');
    }
}
