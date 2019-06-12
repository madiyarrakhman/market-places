<?php
/**
 * Created by PhpStorm.
 * User: madiyar
 * Date: 2019-06-12
 * Time: 22:29
 */

namespace App\Providers;


use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class PrestaShopServiceProvider extends ServiceProvider
{
    /**
     * @var mixed
     */
    public $response;

    /**
     * PrestaShopServiceProvider constructor.
     * @param string $method
     * @param string $url
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function __construct($method = 'GET', $url = '')
    {
        $client = new Client();

        $this->response = $client->request($method, $url, [
            'auth' => ['ino.coder@gmail.com', 'Make2281324!']
        ]);
    }

}
