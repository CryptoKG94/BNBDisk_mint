<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Index
 *
 * @package     Controllers
 * @subpackage  null
 * @category    Controllers
 * @author      Guilherme Gatti
 * @link        null
 */
class Cart extends CI_Controller {

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

	function upload($id){ 
        // log_message('error', 'kg:' . $id);
		$address = $this->session->userdata('address');

		if (!$address || $address == '') {
			$data['sliced_address'] = '';
		} else {
			$data['sliced_address'] = $this->main_model->ellipseAddress($address, ADDRESS_SLICE);
		}

        $fileInfo = $this->main_model->getRows($id);

        // log_message('error', print_r($fileInfo, true));
		
        if (sizeof($fileInfo) > 0) {

            $fileList = json_decode($fileInfo['file_list']);
            $tokenData['files'] = array();

            foreach($fileList as $file) {
                $tmp['name'] = $file[0];
                $tmp['size'] = formatSize($file[1]);
                $tokenData['files'][] = $tmp;
            }
            
            $tokenData['saleText'] = $fileInfo['desc'];
            $tokenData['bnbVal'] = $fileInfo['price'];
            $tokenData['limit'] = $fileInfo['count'] > 100 ? 1 : 0;
            $tokenData['saleCount'] = $fileInfo['count'];
            
            $data['tokenData'] = $tokenData;
            $data['tokenId'] = $id;
            $data['address'] = $address;

            // log_message('error', print_r($data, true));
    
            $this->load->view('header', $data);
            $this->load->view('cartpage', $data);
            $this->load->view('footer');
        }
	
    } 

}
