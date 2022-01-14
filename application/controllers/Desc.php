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
class Desc extends CI_Controller
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

    }

    public function faq()
    {
        $this->load->view('header');
        $this->load->view('faqpage');
        $this->load->view('footer');

    }

    public function rule()
    {
        $this->load->view('header');
        $this->load->view('rulepage');
        $this->load->view('footer');
    }

}
