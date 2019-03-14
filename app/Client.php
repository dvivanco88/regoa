<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use LogsActivity;
    use SoftDeletes;
    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'clients';

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
    protected $fillable = ['name', 'contact', 'adress', 'email', 'telephone1', 'ext1', 'telephone2', 'type_business', 'rfc', 'email2', 'contact_position', 'is_active', 'type_sale', 'type_client_id'];

    public function type_client()
    {
        return $this->belongsTo(TypeClient::class);
    }

    public function order_clients()
    {
        return $this->hasMany('App\OrderClient');
    }  

    public function public_sales()
    {
        return $this->hasMany(PublicSale::class);
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
