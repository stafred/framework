<?php
namespace Stafred\Controller;

use Stafred\Exception\Routing\RoutingNotFoundException;
use Stafred\Utils\Arr;

/**
 * Class SearchRoute
 * @package Stafred\Controller
 */
final class SearchRoute
{
    /**
     * @var array
     */
    private $request = [];
    /**
     * @var array
     */
    private $routes = [];
    /**
     * @var string
     */
    private $link = '';

    /**
     * SearchRoute constructor.
     * @param string $link
     * @param $request
     * @param array $routes
     * @throws \Exception
     */
    public function __construct(string $link, array $request, array $routes)
    {
        /*собираем все необходимые данные для проверки марштура*/
        $this->link = $link;
        $this->routes = $routes;
        $this->request = $request;

        $this->start();
    }

    /**
     * @throws \Exception
     */
    private function start()
    {
        $this->methodSelection();
        $this->linkSelection();
        $this->majorSelection();
        $this->checkRoute();
        $this->checkArgs();
    }

    /**
     * отбираем маршруты по методам запроса
     */
    private function methodSelection()
    {
        foreach ($this->routes as $key => $value) {
            if (strtolower($value['method']) !== strtolower($_SERVER['REQUEST_METHOD'])) {
                unset($this->routes[$key]);
                continue;
            }
        }
    }

    /**
     * ищем соответствия по ссылкам
     */
    private function linkSelection()
    {
        foreach ($this->routes as $key => $value) {
            if (strtolower($value["uri"]) === strtolower($this->link)) {
                $this->routes = []; //clean array routes
                $this->routes[] = $value; //new data for array routes
                break;
            }
        }
    }

    /**
     * @warning проверить ошибку при мажорной селекции
     * @throws RoutingNotFoundException
     */
    private function majorSelection()
    {
        $result = [];
        $parse = new ParseLinkRoute();

        foreach ($this->routes as $key => $value) {
            if (strtolower($value["uri"]) === strtolower($this->link)) {

                $result[] = array_merge($this->routes[$key], ['args' => ['name' => [], 'value' => []]]);
                break;
            }

            $parseUri = $parse->bindRUrl($value['uri'])->getResult();

            if (count($parseUri[0]) != count($this->request['resource'])) {
                continue;
            }

            $redirect = $this->searchRedirect($parseUri, $key);

            if ($redirect === $this->link) {
                $result[] = $this->routes[$key];
                unset($redirect);
                break;
            }
        }

        if(empty($result)) {
            throw new RoutingNotFoundException();
        }

        $this->routes = $result;
    }

    /**
     * @param array $uri
     * @param int $key
     * @return string
     */
    private function searchRedirect(array $uri, string $key): string
    {

        $cPath = count($uri[0]);
        $redirect = '';

        for ($i = 0; $i < $cPath; $i++) {
            $res = ltrim($uri[0][$i], "/");

            if($res === $uri["path"][$i]) {
                $redirect .= '/' . $res;
                continue;
            }
            else if(array_key_exists("args", $uri) && $res === '{$'. $uri["args"][$i] . '}') {
                $this->routes[$key]['args']['value'][] = (string)$this->request["resource"][$i];
                $this->routes[$key]['args']['name'][] = (string)$uri["args"][$i];
                $redirect .= '/' . $this->request["resource"][$i];
            }
        }

        return $redirect;
    }

    /**
     * Only Linux Ubuntu
     * @throws \Exception
     */
    private function checkRoute()
    {
        if (empty($this->routes) OR !is_array($this->routes) OR count($this->routes) !== 1){
			throw new RoutingNotFoundException();
		}
    }

    /**
     * @throws \Exception
     */
    private function checkArgs()
    {
        if (!array_key_exists('args', $this->routes[0]))
            throw new \Exception("error in creating an array of arguments [args]", 500);
        if (!array_key_exists('name', $this->routes[0]['args']))
            throw new \Exception("error in creating an array of arguments [name]", 500);
        if (!array_key_exists('value', $this->routes[0]['args']))
            throw new \Exception("error in creating an array of arguments [value]", 500);
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        return $this->routes[0];
    }
}