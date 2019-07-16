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
                $model->brand = '';
                $model->save();
            }
            catch(\Illuminate\Database\QueryException $e){
                print_r($e->getMessage());
            }
        }

        $models = Feed::all();

        foreach ($models as $model) {
            $service = new PrestaShopServiceProvider('GET', 'https://nemo.kz/api/products/'.$model->ps_id);

            $response = $service->response;

            $arrRes = $this->result($response);

            $model->title = $arrRes->product->name->language;
            $model->description = $this->description($arrRes->product);
            $model->image_link = ((is_string($arrRes->product->id_default_image)) ? 'https://nemo.kz/'.$arrRes->product->id_default_image.'-large_default/'.$arrRes->product->link_rewrite->language.'.jpg' : '');
            $model->link = 'https://nemo.kz/'.$model->ps_id.'-'.$arrRes->product->link_rewrite->language.'.html';
            $model->price = $arrRes->product->price;
            $model->brand = $this->brand($arrRes->product->associations->product_features);
            $model->is_active = intval($arrRes->product->active);
            $model->quantity = intval($arrRes->product->quantity);
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

    /**
     * @param $features
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function brand($features)
    {
        foreach ($features as $feature) {
            if (is_array($feature)) {
                foreach ($feature as $item) {
                    if ($item->id === '11') {
                        $service = new PrestaShopServiceProvider('GET', 'https://nemo.kz/api/product_feature_values/'.$item->id_feature_value);
                        $response = $this->result($service->response);
                        return $response->product_feature_value->value->language;
                    }
                }
            }
        }
        return 'now brand names';

    }

    public function description($product = false)
    {
        $description = $product->description->language;
        if (is_string($description)) {
            if (!empty(trim(strip_tags($description)))) {
                return trim(strip_tags($description));
            } else {
                return $product->name->language;
            }
        } else {
            return $product->name->language;
        }
    }
}
