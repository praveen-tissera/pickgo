<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Package;
use App\Delivery;

class DelivererController extends Controller
{
    /**
     * 
     * this function displays the packages on a map
     */
    public function packagesMap(Request $request)
    {
        return view('deliverer.packages-map');
    }

    /**
     * 
     * this function return the undelivered packages locations on the map
     */
    public function undeliveredPackages(Request $request)
    {
        $packages = Package::undeliveredPackages(config('deliverer.undelivered-packages-limit'));

        //return the results
        return response()->json([
            'packages' => $packages,
        ], 200);
    }

    /**
     * 
     * this function assign a deliverer to a package
     */
    public function deliverPackage(Request $request)
    {
        //validate the request data
        $validated = $request->validate([
            'package' => 'required',
        ]);
// print_r($request->package);
        //assign a package to a deliverer
        $delivery = Delivery::assignPackage($request->package, Auth::id());

        // //sets the package status as delivering
        $package = Package::updatePackageStatus($request->package, 2);

        // //return the results
        return response()->json([
            'delivery' => $delivery,
            'package' => $package,
            'redirect' => route('package-info'),
        ], 200);
    }

    /**
     * 
     * this function shows the informations of the boocked package
     */
    public function packageInfo(Request $request)
    {
        //get the current deliveries
        $delivery = Delivery::deliveryPackage(Auth::id());

        //abort with 500 error if there is no delivery for the user
        //if(!isset($delivery->package)){
        if(count($delivery) <= 0){
            abort(500);
        }
        //get the current on delivering packages
        //$package = Package::package($delivery->package);
        $package = array();
        foreach($delivery as $d){
            array_push($package, Package::package($d->package));
        }
        // print_r('praveen package');
        // print_r($package);
        // print_r($delivery);
//dd($package);
        //abort if the package is non existing
        //if(!isset($d->num)){
            //abort(500);
        //}

        //check the request type
        if($request->isMethod('get')){
            if(!(isset($request->header()['content-type'][0]) && $request->header()['content-type'][0] === "application/json")){ //coming from the browser
                return view('deliverer.package-info', compact('package', 'delivery'));
            }else{ // coming from the api
                $data['delivery'] = $delivery;
                $data['package'] = $package;

                return response()->json([
                    "data" => $data,
                ], 200);
            }
        }else if($request->isMethod('post')){
            return response()->json([
                "package" => $package,
                "delivery" => $delivery,
            ], 200);
        }
    }

    /**
     * 
     * this function marks a package as delivered
     */
    public function delivered(Request $request)
    {
        //validate the request data
        $validated = $request->validate([
            'package' => 'required',
        ]);

        //mark a package as delivered
        $package = Package::delivered(null, $request->package);
        //delete the delivery
        $delivery = Delivery::deleteDelivery(null, $request->package);

        return response()->json([
            'package' => $package,
            'delivery' => $delivery,
            'redirect' => route('packages-map'),
        ]);
    }

    /**
     * 
     * this function returns the current package that the deliverer is delivering
     * 
     */
    public function delivererAssignedPackages(Request $request)
    {
        //get the current deliveries
        $deliveries = Delivery::deliveryPackage(Auth::id());

        //get the current on delivering packages
        $packages = array();
        foreach($deliveries as $d){
            array_push($packages, Package::package($d->package));
        }

        $packagesLoc = array();
        foreach($packages as $p){
            array_push($packagesLoc, array('num' => $p->num, 'lat' => $p->lat, 'lng' => $p->lng));
        }

        return response()->json([
            'packages' => $packagesLoc,
        ]);
    }
}
