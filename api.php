<?php
declare(strict_types=1);

require_once("./Utils/debug.php");
require_once("./Utils/autoload.php");

use Api\View\View;

$token = "ljNTdKmx805GSm1kUDy4FI1";
$requestMethod = $_SERVER["REQUEST_METHOD"];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$scriptName = "api.php";  // filename api actual script

$params = new GetParamsFromUrl ($uri, $scriptName);
$arrayParams = $params->transformation();

$operator = isset($arrayParams['operator'])?$arrayParams['operator']:"none";
$x = isset($arrayParams['x'])?$arrayParams['x']:0;
$x = (float) $x; // settype($x, 'float');
$y =  isset($arrayParams['y'])?$arrayParams['y']:0;
$y = (float) $y; // settype($y, 'float');
$tokenCheck = isset($arrayParams['token'])?$arrayParams['token']:0;

 if (!($token===$tokenCheck)) {
    header("HTTP/1.1 401 Unauthorized");
    exit();	 
 }

$calculator = new Calculator($x,$y);

if ($calculator->existOperator($operator)) {
	$result = $calculator->$operator();
} else {
    header("HTTP/1.1 404 Not Found");
    exit();
}

settype ($result, 'string');
echo $result;

# ------------------------------ Class -------------------------------------------------
class GetParamsFromUrl
{
	private string $uri;
	private string $scriptName;
	private array $parameterKeys  = [ 'script','operator','x','y','token'];

	public function __construct (string $uri, string $scriptName) {
		$this->uri = $uri;
		$this->scriptName = $scriptName;
	}

	public function transformationToString () : string
	{
		$array = $this->transformation();
		$result = "";
		foreach ($array as $key => $value) {
			$result .= "$key: $value<br />";	
		}

		return $result;

	}

	public function transformation () : array
	{
		$result = "";
		$array_return = [];
		$found = "";
		$array = explode( '/', $this->uri );

		foreach ($array as $key => $value) {
			if ($value == $this->scriptName) $found="found";
			if (!($found=="found")) 
			{
				array_splice($array, $key, 1);
			} else {
				$array_return[]=$value;
			}
		}

		$array = [];

		foreach ($array_return as $key => $value) {
			$array[$this->parameterKeys[$key]] = $value;
		}

		return $array;
	}

}

class Calculator {

	private float $x;
	private float $y;
	// allowed methods:
	private array $method = [
								'divide', 
								'multiply',
								'add',
								'sub',
								'test'
							];

	public function __construct (float $x, float $y) {
		$this->x = $x;
		$this->y = $y;
	}

	public function test () : string
	{
		$template = (string) "./template/result_tpl.php";
		$table = [];
		$table = [
			'x' 			=> $this->x,
			'y' 			=> $this->y,
			'addition'		=> $this->add(),
			'subtraction'	=> $this->sub(),
			'multiply'		=> $this->multiply(),
			'divide'		=> $this->divide()
		];
        $content = View::templateToHtml($template, $table);	

		$template = (string) "./template/Index_tpl.php";
        $table = [
            'content' => $content
        ];                       
        $content = View::templateToHtml($template, $table);	
		return $content;
	}

	public function multiply () : float
	{
		return ($this->x)*($this->y);
	}

	public function divide() : float
	{
		if (($this->y)>0) return $this->x/$this->y;
		return 0;
	}

	public function add() : float
	{
		return ($this->x)+($this->y);
	}
	
	public function sub() : float
	{
		return ($this->x)-($this->y);
	}

	public function existOperator ($method) : bool
	{
		if (in_array( $method, $this->method)) return true;
		return false;
	} 
}

# --------------------------------------------------------------------------------------