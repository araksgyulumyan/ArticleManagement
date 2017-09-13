<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_Client extends CI_Controller
{
    public static function login($data)
    {
        $curl = curl_init();
        $username = !empty($data) ? $data['username'] : null;
        $password = !empty($data) ? $data['password'] : null;
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://articlemanagement.dev/api/users/login",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "username=" . $username . "&password=" . $password,
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return json_decode($response);
        }
    }

    public static function register($data)
    {
        $curl = curl_init();
        $username = !empty($data) ? $data['username'] : null;
        $password = !empty($data) ? $data['password'] : null;
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://articlemanagement.dev/api/users/register",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "username=" . $username . "&password=" . $password,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return json_decode($response);
        }
    }
}