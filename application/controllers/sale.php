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
class Sale extends CI_Controller
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

        if (!$address || $address == '') {
            $data['sliced_address'] = '';
        } else {
            $data['sliced_address'] = $this->main_model->ellipseAddress($address, ADDRESS_SLICE);
        }

        $this->load->view('header', $data);
        // $this->load->view('mainpage', $data);
        $this->load->view('salepage');
        $this->load->view('footer');

    }

    public function info($id = null, $toaddress = null)
    {
        // print_r($a . $b);

        if ($id == null || $toaddress == null) {
            redirect(base_url());
            return;
        }

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

            foreach ($fileList as $file) {
                $tmp['name'] = $file[0];
                $tmp['size'] = formatSize($file[1]);
                $tokenData['files'][] = $tmp;
            }

            $tokenData['saleText'] = $fileInfo['desc'];
            $tokenData['bnbVal'] = $fileInfo['price'];
            $tokenData['limit'] = $fileInfo['count'] > 100 ? 1 : 0;
            $tokenData['saleCount'] = $fileInfo['count'];
            $tokenData['fileInfoText'] = $fileInfo['info'];

            $data['id'] = $id;
            $data['tokenData'] = $tokenData;
            $data['toaddress'] = $toaddress;

            // log_message('error', print_r($data, true));

            $this->load->view('header', $data);
            $this->load->view('salepage', $data);
            $this->load->view('footer');
        }
    }

    public function download($id)
    {
        // $id = $this->input->post('id');
        // $id = 23;
        log_message('error', print_r($id, true));
        // $toaddress = $this->input->post('toaddress');

        $fileInfo = $this->main_model->getRows($id);
        // log_message('error', print_r($fileInfo, true));

        if (sizeof($fileInfo) > 0) {
            $fileList = json_decode($fileInfo['file_list']);
            // $res['files'] = $fileList;

            log_message('error', '------------------' . print_r($fileList, true));
            if (sizeof($fileList) > 1) {
                foreach ($fileList as $file) {
                    $_file = realpath("uploads/" . $file[0]);
                    $this->zip->read_file($_file);
                }

                $this->zip->download('files.zip');
            } else {
                foreach ($fileList as $file) {
                    $_file = realpath("uploads/" . $file[0]);
                    // $_file = base_url()."uploads/" . $file[0];

					log_message('error', '------------------' . print_r($_file, true));

                    // check file exists
                    if (file_exists($_file)) {

                        // header('Content-Description: File Transfer');
                        // header('Content-Type: application/octet-stream');
                        // header('Content-Disposition: attachment; filename="' . basename($_file) . '"');
                        // header('Expires: 0');
                        // header('Cache-Control: must-revalidate');
                        // header('Pragma: public');
                        // header('Content-Length: ' . filesize($_file));
                        // flush(); // Flush system output buffer
                        // readfile($_file);
                        // die();

                        $data = file_get_contents($_file);
                        //force download
                        // force_download($file[0], $data, "application/octet-stream");
                    } else {
                        log_message('error', '------------------ file not exist.');
                        // Redirect to base url
                        redirect(base_url());
                    }
                }
            }

        } else {

        }
    }

    public function buy()
    {

    }

}
