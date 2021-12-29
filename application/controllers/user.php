<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once "lib/Keccak/Keccak.php";
require_once "lib/Elliptic/EC.php";
require_once "lib/Elliptic/Curves.php";
require_once "lib/JWT/jwt_helper.php";
$GLOBALS['JWT_secret'] = '4Eac8AS2cw84easd65araADX';

use Elliptic\EC;
use kornrunner\Keccak;

require_once 'config.php';

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

        /**
         * Select all users from the database using the index_model
         *
         * @var array $query  Select all the users
         */
        // $query = $this->main_model->get_all();

        /**
         * Save the query result in a new variable
         *
         * @var array $data  Create a key and save all the results
         */
        // $data = array(
        //     "all"   => $query
        // );

        /**
         * Load all the views and send the data variable
         */
        $this->load->model('user_model');

        $address = $this->session->userdata('address');
    }

    public function login()
    {
        $address = $this->input->post('address');
        if (!empty($address)) {
            $address = strtolower($address);
        }

        $session_data = array(
            'address' => $address,
        );
        $this->session->set_userdata($session_data);

        // Prepared statement to protect against SQL injections
        $result = $this->user_model->get_user($address);
        log_message('error', '****************' . print_r($result, true));

        $nonce = $result['nonce'];

        if ($nonce) {
            // If user exists, return message to sign
            echo ("Sign this message to validate that you are the owner of the account. Random string: " . $nonce);
        } else {
            // If user doesn't exist, register new user with generated nonce, then return message to sign
            $nonce = uniqid();

            $data = array(
                "nonce" => $nonce,
                "address" => $address,
            );

            $last_id = $this->user_model->insert_user($data);

            if ($last_id) {
                echo ("Sign this message to validate that you are the owner of the account. Random string: " . $nonce);
            } else {
                echo "Error";
            }
        }
    }

    public function auth()
    {
        $address = $this->input->post($address);
        $signature = $this->input->post($signature);

        $result = $this->user_model->get_user($address);
        log_message('error', '****************' . print_r($result, true));

        $nonce = $result['nonce'];
        $message = "Sign this message to validate that you are the owner of the account. Random string: " . $nonce;

        // Check if the message was signed with the same private key to which the public address belongs
        function pubKeyToAddress($pubkey)
        {
            return "0x" . substr(Keccak::hash(substr(hex2bin($pubkey->encode("hex")), 1), 256), 24);
        }

        function verifySignature($message, $signature, $address)
        {
            $msglen = strlen($message);
            $hash = Keccak::hash("\x19Ethereum Signed Message:\n{$msglen}{$message}", 256);
            $sign = ["r" => substr($signature, 2, 64),
                "s" => substr($signature, 66, 64)];
            $recid = ord(hex2bin(substr($signature, 130, 2))) - 27;
            if ($recid != ($recid & 1)) {
                return false;
            }

            $ec = new EC('secp256k1');
            $pubkey = $ec->recoverPubKey($hash, $sign, $recid);

            return $address == pubKeyToAddress($pubkey);
        }

        // If verification passed, authenticate user
        if (verifySignature($message, $signature, $address)) {

            $result = $this->user_model->get_user($address);
            log_message('error', '****************' . print_r($result, true));

            $publicName = $result['publicName'];
            $publicName = htmlspecialchars($publicName, ENT_QUOTES, 'UTF-8');

            // Create a new random nonce for the next login
            $nonce = uniqid();

            $data = array(
                "nonce" => $nonce
            );
            $this->user_mode->update_user($address, $data);

            // Create JWT Token
            $token = array();
            $token['address'] = $address;
            $JWT = JWT::encode($token, $GLOBALS['JWT_secret']);

            echo (json_encode(["Success", $publicName, $JWT]));
        } else {
            echo "Fail";
        }
    }

    public function updatePublicName()
    {
        $publicName = $this->input->post('publicName');
        $address = $this->input->post('address');
        $JWT = $this->input->post('JWT');

        // Check if the user is logged in
        try { $JWT = JWT::decode($JWT, $GLOBALS['JWT_secret']);} catch (\Exception $e) {echo 'Authentication error';exit;}

        // Prepared statement to protect against SQL injections
        $data = array(
            "publicName" => $publicName
        );

        $this->user_model->update_user($address, $data);
        echo "Public name for $address updated to $publicName";
    }
}
