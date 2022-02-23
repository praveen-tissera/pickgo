<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon;
use DB;

class Package extends Model
{
    //using soft delete
    use SoftDeletes;

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
        'num', 'weight', 'delivers_date', 'from', 'to', 'description', 'status', 'lat', 'lng'
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
     * The attributes that are datetime type
     *
     * @var array
     */
    protected $dates = [
        'delivers_date'
    ];

    /**
     * 
     * this function return one package
     * @param mixed p (int|string)
     * @return Package package
     */
    public static function package($p)
    {
        $package = Package::where('id', $p)->first();

        if(!isset($package)){
            $package = Package::where('num', $p)->first();
        }

        return $package;
    }

    /**
     * this function return all undelivered packages with pagination
     * @param int paginate
     * @return Collection packages
     */
    public static function packages($paginate)
    {
        return Package::where('status', 1)->orderBy('created_at', 'ASC')->paginate($paginate);
    }

    /**
     * this function return all packages with pagination
     * @param int paginate
     * @return Collection packages
     */
    public static function allPackages($paginate)
    {
        return Package::orderBy('created_at', 'ASC')->orderBy('status', 'ASC')->paginate($paginate);
    }

    /**
     * 
     * this function creates a new package
     * @param string num
     * @param string weight
     * @param Carbon delivery date
     * @param string from
     * @param string to
     * @param string phone
     * @param string description
     * @return Package
     */
    public static function add($num, $weight, $ddate, $from, $to, $lat, $lng, $desc = null)
    {
        //generate a num if it's null
        if(!isset($num)){
            $num = substr(md5(\Carbon\Carbon::now()), 0, 10);
        }

        return Package::create([
            'num' => $num,
            'weight' => $weight,
            'delivers_date' => $ddate,
            'from' => $from,
            'to' => $to,
            'lat' => $lat,
            'lng' => $lng,
            'description' => $desc
        ]);
    }

    /**
     * 
     * this function updates a specific package
     * @param int id
     * @param string weight
     * @param Carbon delivery date
     * @param string from
     * @param string to
     * @param string phone
     * @param string description
     * @return Package
     */
    public static function edit($id, $num, $weight, $ddate, $from, $to, $desc = null)
    {
        $str = 'id';
        //test the data
        if(!isset($id)){
            $str = 'num';
            $id = $num;
        }

        return Package::where($str, $id)->update([
            //'num' => $num,
            'weight' => $weight,
            'delivers_date' => $ddate,
            'from' => $from,
            'to' => $to,
            'description' => $desc
        ]);
    }

    /**
     * 
     * this function deletes a specific package
     * @param int id
     * @param string num
     * @return Package package
     * @return bool
     */
    public static function deletePackage($id, $num = null)
    {
        if(isset($id)){
            return Package::where('id', $id)->delete();
        }else if(isset($num)){
            return Package::where('num', $num)->delete();
        }

        return false;
    }

    /**
     * 
     * this function marks a package as delivered
     * @param string num
     * @return Package package
     */
    public static function delivered($id, $num = null)
    {
        if(isset($id)){
            return Package::where('id', $id)->update([
                'status' => 3,
            ]);
        }else if(isset($num)){
            return Package::where('num', $num)->update([
                'status' => 3,
            ]);
        }
    }

    /**
     * 
     * this function returns the undelivered packages with a limit
     * @param int limit
     * @return Collection package
     */
    public static function undeliveredPackages($limit)
    {
        return Package::where([
            ['status', 1]
        ])->limit($limit)->get();
    }

    /**
     * 
     * this function updates a package status
     * @param int package
     * @param int status
     * @return Package
     */
    public static function updatePackageStatus($package, $status)
    {
        $p = Package::where('id', $package)->first();
        
        if(!isset($p->code)){
            $p = Package::where('num', $package)->first();
           
        }

        if(gettype($status) === "string"){
            $status = DB::table('delivery_status')->where('status', $status)->first()->code;
        }
        // print_r($package); 
        return Package::where('id', $package)->update([
            'status' => $status,
        ]);
        
    }

    /**
     * 
     * this function return the packages that have the status 2 (delivering)
     * @return Package
     */
    public static function onDeliveryPackages()
    {
        return Package::join('delivery', 'packages.num', '=', 'delivery.package')
                            ->where([
                                ['packages.status', 2],
                                ['delivery.deleted_at', null]
                            ])->select("delivery.*", "packages.*", "delivery.id as d_id", "packages.id as p_id", "delivery.created_at as d_create_at", "delivery.updated_at as d_updated_at", "packages.created_at as p_create_at", "packages.updated_at as p_updated_at")
                            ->get();
    }

    /**
     * 
     * this function returns a bootstrap color based on the package delivery date
     * @param Carbon date
     * @return string
     */
    public static function packageColor($date, $status)
    {
        if($status == 2){ //package is beign delivered
            return 'info';
        }else if($status == 3){ //package is delivered
            return 'secondary';
        }

        //package is still undelivered
        switch ($date) {
            //package
            //package has less than 1 day to be delivered
            case $date->gt(Carbon::now()) == false || $date->diffInDays(Carbon::now()) <= 1 :
                return 'danger';
                break;
            // less than 2 days
            case $date->diffInDays(Carbon::now()) <= 2 :
                return 'warning';
                break;
            // less than 5 days
            case $date->diffInDays(Carbon::now()) <= 5 :
                return 'primary';
                break;
            default:
                return 'light';
                break;
        }
    }
}
