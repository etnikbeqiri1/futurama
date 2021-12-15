<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once 'model/Route.php';
require_once 'core/Web.php';


function arrayContains($contains, $array)
{
    if (strpos($contains, "?"))
        $contains = explode("?", $contains)[0];

    foreach ($array as $arr) {
        $route = $arr;
        if ($route->getUrl() == $contains) {
            return $route;
        }
    }
    return null;
}

function getView()
{
    $whatToReplace = str_replace('index.php', '', $_SERVER['PHP_SELF']);
    $url = str_replace($whatToReplace, '', $_SERVER['REQUEST_URI']);

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $route = arrayContains($url, Route::getArrayOfRoutesGET());
    } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $route = arrayContains($url, Route::getArrayOfRoutesPOST());
    } else {
        throw new Exception("Unsupported protocol");
    }

    if ($route != null) {
        require_once(__DIR__ . '/controllers/' . $route->getController() . '.php');
        $controllerName = $route->getController();
        $methodName = $route->getFunction();
        $controller = new $controllerName();
        $controller->$methodName();
    } else {
        include(__DIR__ . "/view/Error404View.php");
    }

}

try {
    getView();
} catch (Exception $e) {
    echo $e->getMessage();
}

?>