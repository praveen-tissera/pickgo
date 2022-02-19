<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Model
{
    //using soft delete (deleted_at in the database)
    use SoftDeletes;

    /**
     * The attribute that is the table
     * 
     * @var string
     */
    protected $table = 'delivery';

    /**
     * The attribute that is the primary key
     * 
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'deliverer', 'package', 'delivery_start_date', 'delivered'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        
    ];

    /**
     * 
     * this function deletes a delivery 
     * @param int delivery
     * @return Delivery
     */
    public static function deleteDelivery($delivery, $package = null)
    {
        $col = isset($package) ? 'package' : 'id';
        $val = isset($package) ? $package : $delivery;

        return Delivery::where($col, $val)->delete();
    }

    
    /**
     * 
     * this function assigns a package to a deliverer
     * @param int package
     * @param int deliverer
     * @return Delivery delivery
     */
    public static function assignPackage($package, $deliverer)
    {
        return Delivery::firstOrCreate(
        [
            'package' => $package,
            'deliverer' => $deliverer,
        ],
            ['delivery_start_date' => \Carbon\Carbon::now()]
        );


        //$flight = App\Flight::firstOrCreate(
        //    ['name' => 'Flight 10'],
        //    ['delayed' => 1, 'arrival_time' => '11:30']
        //);
    }

    /**
     * 
     * this function marks a delivery as delivered
     * @param int delivery
     * @return Delivery delivery
     */
    public static function delivered($delivery)
    {
        return Delivery::where('id', $delivery)->update([
            'delivered' => true,
        ]);
    }

    /**
     * 
     * this function returns the user delivery packages
     * @param int user id
     * @return Delivery delivery
     */
    public static function deliveryPackage($user)
    {
        return Delivery::where('deliverer', $user)
                ->orderBy('delivery_start_date', 'DESC')
                ->get();
    }

    /**
     * 
     * this function determes if the user has ongoing delivery
     * @param int user id
     * @return boolean
     */
    public static function hasDelivery($user = null)
    {
        if(isset($user)){
            $delivery = Delivery::where('deliverer', $user)->first();
        }else{
            $delivery = Delivery::where('deliverer', Auth::id())->first();
        }
        

        return isset($delivery->id) ? true : false;
    }

    /**
     * 
     * this function returns the current deliveries
     * @return Delivery 
     */
    public static function currentDeliveries()
    {
        return Delivery::join('packages', 'delivery.package', '=', 'packages.num')
                            ->where([
                                ['packages.deleted_at', null],
                                ['packages.status', 2]
                            ])->get();
    }
}
