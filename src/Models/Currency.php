<?php
namespace FaridBabayev\CBARCurrency\Models;

use FaridBabayev\CBARCurrency\Collections\CurrencyCollection;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @param array $models
     * @return CurrencyCollection
     */
    public function newCollection(array $models = []): CurrencyCollection
    {
        return  new CurrencyCollection($models);
    }
}
