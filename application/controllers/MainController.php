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
class MainController extends CI_Controller
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
        // $address = $this->session->userdata('address');

		// if (!$address || $address == '') {
		// 	$data['sliced_address'] = '';
		// } else {
		// 	$data['sliced_address'] = $this->main_model->ellipseAddress($address, ADDRESS_SLICE);
		// }

        $this->load->view('header');
        $this->load->view('mainpage');
        $this->load->view('footer');

    }

    public function dragdrop_upload()
    {
        if (!empty($_FILES['file']['name'])) {

            // Set preference
            $config['upload_path'] = 'uploads/';
            $config['allowed_types'] = '*';//'jpg|jpeg|png|gif';
            $config['max_size'] = '1024'; // max_size in kb
            $config['file_name'] = $_FILES['file']['name'];

            //Load upload library
            $this->load->library('upload', $config);

            // File upload
            if ($this->upload->do_upload('file')) {
                // Get data about the file
                $uploadData = $this->upload->data();
                // log_message('debug', '****************' + $uploadData);
            }
        }

        // if(!empty($_FILES)){
        //     // File upload configuration
        //     $uploadPath = 'uploads/';
        //     $config['upload_path'] = $uploadPath;
        //     $config['allowed_types'] = '*';

        //     // Load and initialize upload library
        //     $this->load->library('upload', $config);
        //     $this->upload->initialize($config);

        //     // Upload file to the server
        //     if($this->upload->do_upload('file')){

        //         $uploadData['file_name'] = $fileData['file_name'];
        //         $uploadData['uploaded_on'] = date("Y-m-d H:i:s");

        //         // Insert files info into the database
        //         $insert = $this->main_model->insert($uploadData);

        //         log_message('debug', $insert);
        //     }
        // }
    }

    public function connectWallet()
    {
        $address = $this->input->post('address');
        log_message('debug', '****************' . $address . "**************");

		$session_data = array(
			'address' => $address,
		);
		$this->session->set_userdata($session_data);

		$data['success'] = true;
		$data['address'] = $address;
        echo json_encode($data);
    }

    public function uploadandshare()
    {
        log_message('debug', '****************');
		$address = $this->input->post('address');
		$desc = $this->input->post('desc');
		$info = $this->input->post('info');
		$price = $this->input->post('price');
		$count = $this->input->post('count');
		$filelist = $this->input->post('filelist');

		if (!$count) {
			$count = 20;
		}

		$filenames = '';
		// foreach ($filelist as $item) {
		// 	$filenames .= $item . ',';
		// }

		$filenames = substr($filenames, 0, -1);
		$filenames = json_encode($filelist);

		log_message('debug', '****************'. $address . '***' . $desc . '***' . $info . '***' . $price . '***', $count . '***' . $filenames . '*******');

		$data = array(
			"wallet_address"   	=> $address,
			"desc"		=> $desc,
			"info"		=> $info,
			"price" 	=> $price,
			"count"		=> $count,
			"file_list"	=> $filenames
		);
		/**
		 * Create the user in the table using the index_model
		 *
		 * @var array $query  Create the user
		 */
		$last_id = $this->main_model->insert_data($data);
		echo json_encode($last_id);
    }
}
