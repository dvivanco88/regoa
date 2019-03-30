<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;



class Order extends Model
{
    use LogsActivity;
    use SoftDeletes;
    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orders';

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
    protected $fillable = ['stat_id', 'date_delivery', 'date_pay', 'cost', 'type_pay', 'observations', 'advance', 'due', 'user_id', 'discount'];
     //protected $appends = ['client_id', 'array_product_id','quantity'];

    public function stat()
    {
        return $this->belongsTo('App\Stat');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
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
