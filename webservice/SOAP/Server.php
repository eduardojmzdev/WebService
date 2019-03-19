<?php
ini_set('soap.wsdl_cache_enabled',0);
ini_set('soap.wsdl_cache_ttl',0);
require_once(getcwd() . '/lib/nusoap.php');
require_once(getcwd() . '/Service.php');

class Server
{
    public $_soapServer = null;

    public  function authenthicate(){
    	print_r("\n AUTH");
    	$auth=Array();
    	// print_r($this->_soapServer->requestHeader);
		$auth=( $this->_soapServer->requestHeader['__numeric_0']['data']['enc_value']);
		// print_r($auth);
		$username=$auth['username'];
		$password=$auth['password'];
		if ($username=="lalo" && $password=="123"){
			print_r("OK");
			return true;
		}else{
			unset($this->_soapServer);
			// print_r("NO");
			header('HTTP/1.1 401 Unauthorized');
			header('WWW-Authenticate: Basic realm="Password For Blog"');
			exit("Access Denied: Username and password required.");
			die();
		}
    }

    public function credentials(){
    	// print_r("\n\n CRED");
    	// print_r($_SERVER['PHP_AUTH_USER'] );
    	// print_r($_SERVER['PHP_AUTH_PW'] );
    	if ($_SERVER['PHP_AUTH_USER']=="lalo" && $_SERVER['PHP_AUTH_PW']=="123") {

    		return true;
    	}else{
    		try {
    		    throw new Exception('Wrong User/Pwd Combination');
    		    return false;
    		} catch (\Exception $e) {
    		    print_r($e->getMessage());
    		}
    	}
    }

    public function __construct()
    {
        $this->_soapServer = new soap_server();
        $this->_soapServer->configureWSDL("Example WSDL","http://localhost:8000/webservice/SOAP/Server.php");
        $this->_soapServer->wsdl->schemaTargetNamespace = 'http://localhost:8000/webservice/SOAP/Server.php';

        $this->credentials();

        $this->_soapServer->register(
           'Service.getUsers', // method name
           array(), // input parameters
           array('return' => 'xsd:Array'), // output parameters
           false, // namespace
           false, // soapaction
           'rpc', // style
           'encoded', // use
           'Servicio que retorna un array de usuarios' // documentation
        );

        $this->_soapServer->register(
            'Service.sum',
            array('a' => 'xsd:string', 'b' => 'xsd:string'),
            array('return' => 'xsd:int'),
            false,
            false,
            "rpc",
            "encoded",
            "Servicio que suma dos números"
        );

        $this->_soapServer->register(
            "Service.getName",
            array('name' => "xsd:string"),
            array("return" => "xsd:string"),
            false,
            false,
            "rpc",
            "encoded",
            "Servicio que retorna un string"
        );

        //procesamos el webservice
        $this->_soapServer->service(file_get_contents("php://input"));
        // $this->authenthicate();



    }
}
$server = new Server();
// $server->authenthicate();
