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

	function upload() { 
        // log_message('error', 'kg:' . $id);
        $tokenId = $this->input->get('t');
        $dbId = $this->input->get('d');
        $price = $this->input->get('p');
        $limit = $this->input->get('l');
        $count = $this->input->get('c');

        log_message('error', '***upload*** : ' . $tokenId . ',' . $dbId . ',' . $price . ',', $limit . ',' . $count);
        log_message('error', print_r($limit, true));
        log_message('error', print_r($count, true));

		$address = $this->session->userdata('address');

		// if (!$address || $address == '') {
		// 	$data['sliced_address'] = '';
		// } else {
		// 	$data['sliced_address'] = $this->main_model->ellipseAddress($address, ADDRESS_SLICE);
		// }

        $fileInfo = $this->main_model->getRows($dbId);

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
            $tokenData['bnbVal'] = $price;
            $tokenData['limit'] = $limit == 'true' ? 1 : 0;
            $tokenData['saleCount'] = $fileInfo['count'];
            
            $data['tokenData'] = $tokenData;
            $data['tokenId'] = $tokenId;
            $data['address'] = $address;

            // log_message('error', print_r($data, true));
    
            $this->load->view('header');
            $this->load->view('cartpage', $data);
            $this->load->view('footer');
        }
	
    } 

}
