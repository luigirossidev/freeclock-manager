<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DailyQuoteApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    private $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E\'', 'É'=>'E\'',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I\'', 'Í'=>'I\'', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O\'', 'Ó'=>'O\'', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U\'',
        'Ú'=>'U\'', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y\'', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a\'', 'á'=>'a\'', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
        'è'=>'e\'', 'é'=>'e\'', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i\'', 'í'=>'i\'', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o\'', 'ó'=>'o\'', 'ô'=>'o', 'õ'=>'o',
        'ö'=>'o', 'ø'=>'o', 'ù'=>'u\'', 'ú'=>'u\'', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );

    public function toArray($request)
    {
        //return parent::toArray($request);
        $quoteFormat = preg_replace('/\x{2019}/u','\'',$this->quote);
        return [
            'quote' => strtr( $quoteFormat, $this->unwanted_array ),
        ];
    }
}
