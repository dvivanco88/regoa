<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;



class Product extends Model
{
    use LogsActivity;
    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'is_active', 'price_business', 'price_wholesale', 'price_retail'];

    
    public function inventories()
    {
        return $this->hasMany('App\Inventory');
    }

    public function order_clients()
    {
        return $this->hasMany('App\OrderClient');
    }

    


    
    /**
     * Change activity log event description
     *
     * @param string $eventName
     *
     * @return string
     */
    public function getDescriptionForEvent($eventName)
    {
        return __CLASS__ . " model has been {$eventName}";
    }
}
