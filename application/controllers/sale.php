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

        // if (!$address || $address == '') {
        //     $data['sliced_address'] = '';
        // } else {
        //     $data['sliced_address'] = $this->main_model->ellipseAddress($address, ADDRESS_SLICE);
        // }

        redirect(base_url());
    }

    public function loading($tokenId = null, $pageId = null)
    {
        // print_r($a . $b);

        if ($tokenId == null) {
            redirect(base_url());
            return;
        }

        $address = $this->session->userdata('address');

        // if (!$address || $address == '') {
        //     $data['sliced_address'] = '';
        // } else {
        //     $data['sliced_address'] = $this->main_model->ellipseAddress($address, ADDRESS_SLICE);
        // }
        $data['tokenId'] = $tokenId;
        $data['pageId'] = $pageId ? $pageId : 0;
        $this->load->view('header');
        $this->load->view('loadpage', $data);
        $this->load->view('footer');
    }

    public function info()
    {
        // log_message('error', 'kg:' . $id);
        $tokenId = $this->input->get('t');
        $dbId = $this->input->get('d');
        $price = $this->input->get('p');
        $limit = $this->input->get('l');
        $count = $this->input->get('c');

		if (!$tokenId || !$dbId) {
			return;
		}

        // log_message('error', '***upload*** : ' . $tokenId . ',' . $dbId . ',' . $price . ',', $limit . ',' . $count);
        // log_message('error', print_r($limit, true));
        // log_message('error', print_r($count, true));

        $address = $this->session->userdata('address');

        // if (!$address || $address == '') {
        //     $data['sliced_address'] = '';
        // } else {
        //     $data['sliced_address'] = $this->main_model->ellipseAddress($address, ADDRESS_SLICE);
        // }

        $fileInfo = $this->main_model->getRows($dbId);

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
            $tokenData['bnbVal'] = $price;
            $tokenData['limit'] = $limit == 'true' ? 1 : 0;
            $tokenData['saleCount'] = $fileInfo['count'];

            $data['tokenData'] = $tokenData;
            $data['tokenId'] = $tokenId;
			$data['dbId'] = $dbId;
            $data['toaddress'] = $address;

            // log_message('error', print_r($data, true));

            $this->load->view('header');
            $this->load->view('salepage', $data);
            $this->load->view('footer');
        }

    }

    public function download($id = null)
    {
        // $id = $this->input->get('id');
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
                $file = $fileList[0];
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
                    force_download($file[0], $data, "application/octet-stream");
                } else {
                    log_message('error', '------------------ file not exist.');
                    // Redirect to base url
                    redirect(base_url());
                }
            }

        } else {

        }
    }

    public function buy()
    {
        $id = $this->input->post('id');
        $toaddress = $this->input->post('address');

        $address = $this->session->userData('address');

        if (!$toaddress) {
            return;
        }

        $fileInfo = $this->main_model->getRows($id);
        if ($fileInfo && sizeof($fileInfo) == 1) {
            $data = array(
                "count" => $fileInfo['count'] - 1,
            );

            $result = $this->main_model->update_data($id, $data);
            echo $result;
        }

        echo 'error';
    }

}
