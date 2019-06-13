<?php
/**
 * Created by PhpStorm.
 * User: madiyar
 * Date: 2019-06-12
 * Time: 22:25
 */

namespace App\Console\Commands;


use App\Models\Facebook\Feed;
use App\Providers\PrestaShopServiceProvider;
use Illuminate\Console\Command;

class ProductCommand extends Command
{
    protected $name = 'Product';

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        $service = new PrestaShopServiceProvider('GET', 'https://nemo.kz/api/products');

        $response = $service->response;

        $arrRes = $this->result($response);

        foreach ($arrRes->products->product as $product) {
            try
            {
                $model = new Feed();
                $model->ps_id = intval(get_object_vars($product)['@attributes']->id);
                $model->description = '';
                $model->save();
            }
            catch(\Illuminate\Database\QueryException $e){
                // do what you want here with $e->getMessage();
            }
        }

        $models = Feed::all();

        foreach ($models as $model) {
            $service = new PrestaShopServiceProvider('GET', 'https://nemo.kz/api/products/'.$model->ps_id);

            $response = $service->response;

            $arrRes = $this->result($response);

            $model->title = $arrRes->product->name->language;
            $model->description = ((is_string($arrRes->product->description->language)) ? strip_tags($arrRes->product->description->language) : '');
            $model->image_link = ((is_string($arrRes->product->id_default_image)) ? 'https://nemo.kz/'.$arrRes->product->id_default_image.'-large_default/'.$arrRes->product->link_rewrite->language.'.jpg' : '');
            $model->link = 'https://nemo.kz/'.$model->ps_id.'-'.$arrRes->product->link_rewrite->language.'.html';
            $model->price = $arrRes->product->price;
            $model->update();
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
