
<?php 

require __DIR__ . '/../vendor/autoload.php';

use ClassyPhp\Classy\Classes\Request;
use ClassyPhp\Classy\Classes\Router;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$request = new Request();

// Add ?name=Yourself to the request URL to test
if ($request->has('name')) {
	echo 'Hello, ' . $request->paramStr('name') . '!';
} else {
	echo 'Hello, World!';
}

// Early router development
$router = new Router();
$router->setDefaultRoute('Home', 'index');
$router->addRoute('About', 'index');
$controller = $router->getController();
$method = $router->getMethod();
// Methods don't have args. Instead pass $_GET params and pick them up in the controller method

echo '<br>Controller: ' . $controller . '<br>';
echo 'Method: ' . $method . '<br>';

echo '<pre>';

echo '$_GET'."\n\n";
print_r($_GET);
echo "\n\n";
echo '$_POST'."\n\n";
print_r($_POST);
echo "\n\n";
echo '$_SERVER'."\n\n";
print_r($_SERVER);

echo '</pre>';