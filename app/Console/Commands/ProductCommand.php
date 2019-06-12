<?php
/**
 * Created by PhpStorm.
 * User: madiyar
 * Date: 2019-06-12
 * Time: 22:25
 */

namespace App\Console\Commands;


use App\Providers\PrestaShopServiceProvider;
use Illuminate\Console\Command;

class ProductCommand extends Command
{
    protected $name = 'Product';

    public function handle()
    {
        $service = new PrestaShopServiceProvider('GET', 'https://nemo.kz/api/products');

        $response = $service->response;

        $arrRes = $this->result($response);

        foreach ($arrRes->products->product as $product) {

        }
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return \stdClass
     */
    public function result(\Psr\Http\Message\ResponseInterface $response)
    {
        $xml = simplexml_load_string($response->getBody()->getContents(), 'SimpleXMLElement', LIBXML_NOCDATA);
        $jsonRes = json_encode($xml);
        $arrRes = json_decode($jsonRes);
        return $arrRes;
    }
}
