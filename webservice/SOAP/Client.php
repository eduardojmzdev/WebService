<?php

class Client
{
    public $_soapClient = null;

    public function __construct()
    {
        require_once(getcwd() . '/lib/nusoap.php');
        // $this->_soapClient= new nusoap_client("http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'/Server.php?wsdl');
        $wsdl="http://localhost:8000/webservice/SOAP/Server.php?wsdl";
        $this->_soapClient = new nusoap_client($wsdl,false);
        $this->_soapClient->soap_defencoding = 'UTF-8';

        //set the header to authenticate function
        $auth_params=new stdClass();
        $auth_params->username="lalo";
        $auth_params->password="123";
        $header_params = new SoapVar($auth_params, SOAP_ENC_OBJECT);
        $header = new SoapHeader($wsdl, "authenticate", $header_params, false);
        $this->_soapClient->setHeaders(array($header));
        // end authenticate


        $this->_soapClient->setCredentials("lalo", "123");
        //setCredentials() establece $_SERVER['PHP_AUTH_USER'] y $_SERVER['PHP_AUTH_PW']
    }

    public function users()
    {
        try
        {
            $result = $this->_soapClient->call('Service.getUsers', array());
            // print_r($result);
            $this->_soapResponse($result);
        }
        catch (SoapFault $fault)
        {
            trigger_error("SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})", E_USER_ERROR);
        }
    }

    public function sum($a,$b)
    {
        try
        {
            $result = $this->_soapClient->call('Service.sum', array('a' => $a, 'b' => $b));
            $this->_soapResponse($result);
            // return $this->_soapClient->responseData;
        }
        catch (SoapFault $fault)
        {
            trigger_error("SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})", E_USER_ERROR);
        }
    }

    public function getName($nombre)
    {
        try
        {
            $result = $this->_soapClient->call('Service.getName', array('name' => $nombre));
            $this->_soapResponse($result);

        }
        catch (SoapFault $fault)
        {
            trigger_error("SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})", E_USER_ERROR);
        }
    }

    private function _soapResponse($result)
    {
    	echo "<pre>";
        echo '<h2>Result</h2>';
        print_r($result);
        // echo '<h2>XML Response</h2>';
        // echo $this->_soapClient->responseData;
        // echo '<h2>Request</h2>' . htmlspecialchars($this->_soapClient->request, ENT_QUOTES);
        // echo '<h2>Response</h2>' . htmlspecialchars($this->_soapClient->response, ENT_QUOTES);
        // echo '<h2>Debug</h2>' . htmlspecialchars($this->_soapClient->debug_str, ENT_QUOTES);
    }
}

 ?>
