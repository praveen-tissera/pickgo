<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\DelivererAccountAcceptedEvent;
use App\User;
use App\Admin;
use App\Package;
use App\Delivery;
use App\Deliverer;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * 
     * this function list users that have registered on the website
     */
    public function users(Request $request)
    {
        $users = User::users(config('admin.users-paginate'));

        if(!isset($request->header()['authorization'][0])){ //coming from the browser
            return view('admin.users', compact('users'));
        }else{ // coming from the api
            $data['users'] = $users;

            return response()->json([
                "data" => $data,
            ], 200);
        }
        
    }

    /**
     * 
     * this function lists deliverers with the option to bann deliverer
     */
    public function deliverersList(Request $request)
    {
        $users = User::deliverers(config('admin.deliverers-paginate'));

        if(!isset($request->header()['authorization'][0])){ //coming from the browser
            return view('admin.deliverers', compact('users'));
        }else{ // coming from the api
            $data['users'] = $users;

            return response()->json([
                "data" => $data,
            ], 200);
        }
    }

    /**
     * this function changes the user role to a deliverer
     */
    public function makeDeliverer(Request $request)
    {
        //validate the request
        $validate = $request->validate([
            'user' => 'required',
        ]);

        //change the user role
        $user = Admin::makeDeliverer($request->user);
        //get the user
        $user = User::userId($request->user);

        event(new DelivererAccountAcceptedEvent($user));

        if(!isset($request->header()['authorization'][0])){
            return redirect()->back();
        }else{
            $data['user'] = $user;

            return response()->json([
                "data" => $data,
            ], 200);
        }
    }

    /**
     * 
     * this function makes a deliverers a simple user (bannes a deliverer)
     */
    public function removeDeliverer(Request $request)
    {
        //validate the request
        $validate = $request->validate([
            'user' => 'required',
        ]);

        //change the user role
        $user = Admin::removeDeliverer($request->user);

        if(!isset($request->header()['authorization'][0])){
            return redirect()->back();
        }else{
            $data['user'] = $user;

            return response()->json([
                "data" => $data,
            ], 200);
        }
    }

    /**
     * this function returns one package
     */
    public function package(Request $request)
    {
        $package = Package::package($request->package);

        return response()->json([
            "package" => $package,
        ]);

        if(!(isset($request->header()['content-type'][0]) && $request->header()['content-type'][0] === "application/json")){
            return redirect()->back();
        }else{
            $data['package'] = $package;

            return response()->json([
                "data" => $data,
            ], 200);
        }
    }

    /**
     * this function returns the packages
     */
    public function packages(Request $request)
    {
        $packages = Package::packages(config('admin.packages-paginate'));

        if(!(isset($request->header()['content-type'][0]) && $request->header()['content-type'][0] === "application/json")){
            return view('admin.packages', compact('packages'));
        }else{
            $data['packages'] = $packages;

            return response()->json([
                "data" => $data,
            ], 200);
        }
    }

    /**
     * 
     * this function returns all the packages
     */
    public function allPackages(Request $request)
    {
        $packages = Package::allPackages(config('admin.packages-paginate'));

        if(!(isset($request->header()['content-type'][0]) && $request->header()['content-type'][0] === "application/json")){
            return view('admin.packages', compact('packages'));
        }else{
            $data['packages'] = $packages;

            return response()->json([
                "data" => $data,
            ], 200);
        }
    }

    /**
     * this function mark a package as delivered
     */
    public function delivered(Request $request)
    {
        //mark the package
        $package = Package::delivered($request->package);

        if(!(isset($request->header()['content-type'][0]) && $request->header()['content-type'][0] === "application/json")){
            return redirect()->back();
        }else{
            $data['package'] = $package;

            return response()->json([
                "data" => $data,
            ], 200);
        }
    }

    /**
     * this function adds a package
     */
    public function addPackage(Request $request)
    {
        //check the request type
        if($request->isMethod('get')){
            return view('admin.managePackage');
        }else if($request->isMethod('post')){
            $validate = $request->validate([
                'weight' => 'required|numeric',
                'ddate' => 'required',
                'from' => 'required',
                'to' => 'required',
                'desc' => 'min:3',
                'lat' => 'required',
                'lng' => 'required',
            ],[
                'weight.required' => trans('admin/managePackage.weight_required'),
                'weight.numeric' => trans('admin/managePackage.weight_numeric'),
                'ddate.required' => trans('admin/managePackage.ddate_required'),
                'from.required' => trans('admin/managePackage.from_required'),
                'to.required' => trans('admin/managePackage.to_required'),
                'desc.min' => trans('admin/managePackage.dsec_min'),
                'lat.required' => trans('admin/managePackage.lat_required'),
                'lng.required' => trans('admin/managePackage.lng_required'),
            ]);
            
            //add package
            $package = Package::add($request->num, $request->weight, $request->ddate, $request->from, $request->to, $request->lat, $request->lng, $request->desc);

            if(!(isset($request->header()['content-type'][0]) && $request->header()['content-type'][0] === "application/json")){
                return redirect()->back();
            }else{
                $data['package'] = $package;
    
                return response()->json([
                    "data" => $data,
                ], 200);
            }
        }
    }

    /**
     * this function edits a package
     */
    public function editPackage(Request $request)
    {
        //check the request type
        if($request->isMethod('get')){
            //get the package for the edit
            $package = Package::package($request->package);

            return view('admin.managePackage', compact('package'));
        }else if($request->isMethod('post')){
            //validate the request
            $validate = $request->validate([
                //'package' => 'required',
                'weight' => 'required|numeric',
                'ddate' => 'required',
                'from' => 'required',
                'to' => 'required',
                'desc' => 'min:3'
            ],[
                //'package.required' => trans('admin/managePackage.package_required'),
                'weight.required' => trans('admin/managePackage.weight_required'),
                'weight.numeric' => trans('admin/managePackage.weight_numeric'),
                'ddate.required' => trans('admin/managePackage.ddate_required'),
                'from.required' => trans('admin/managePackage.from_required'),
                'to.required' => trans('admin/managePackage.to_required'),
                'desc.min' => trans('admin/managePackage.dsec_min'),
            ]);


            //edit package  
            $package = Package::edit($request->package, null, $request->weight, $request->ddate, $request->from, $request->to, $request->desc);

            if(!(isset($request->header()['content-type'][0]) && $request->header()['content-type'][0] === "application/json")){
                return redirect()->back();
            }else{
                $data['package'] = $package;
    
                return response()->json([
                    "data" => $data,
                ], 200);
            }
        }
    }

    /**
     * 
     * this function soft deletes a package (updates the deleted_at table column)
     */
    public function deletePackage(Request $request)
    {
        //validate the request (is no more needed)
        // $validate = $request->validate([
        //     'package' => 'required',
        // ],[
        //     'package.required' => trans('admin/managePackage.package_required'),
        // ]);

        //edit package
        $package = Package::deletePackage($request->package);

        if(!(isset($request->header()['content-type'][0]) && $request->header()['content-type'][0] === "application/json")){
            return redirect()->back();
        }else{
            $data['package'] = $package;

            return response()->json([
                "data" => $data,
            ], 200);
        }
    }

    /**
     * 
     * this function list users woth role deliverer
     */
    public function deliverers(Request $request)
    {
        $deliverers = User::deliverers(config('admin.deliverers-paginate'));

        $packages = Package::undeliveredPackages(10); //modal function is not done

        if(!(isset($request->header()['content-type'][0]) && $request->header()['content-type'][0] === "application/json")){
            return view('admin.deliverers', compact('deliverers', 'packages'));
        }else{
            $data['deliverers'] = $deliverers;
            $data['packages'] = $packages;

            return response()->json([
                "data" => $data,
            ], 200);
        }
    }

    /**
     * 
     * this function assigns a package to a deliverer
     */
    public function assignPackage(Request $request)
    {
        $validate = $request->validate([
            'package' => 'required|numeric',
            'deliverer' => 'required|numeric',
        ],[
            'package.required' => trans('admin/deliverers.package_required'),
            'package.numeric' => trans('admin/deliverers.package_numeric'),
            'deliverer.required' => trans('admin/deliverers.deliverer_required'),
            'deliverer.numeric' => trans('admin/deliverers.deliverer_numeric'),
        ]);

        $delivery = Delivery::assignPackage($request->package, $request->deliverer);
        $package = Package::updatePackageStatus($request->package, 2);

        if(!(isset($request->header()['content-type'][0]) && $request->header()['content-type'][0] === "application/json")){
            return redirect()->back();
        }else{
            $data['delivery'] = $delivery;
            $data['package'] = $package;

            return response()->json([
                "data" => $data,
            ], 200);
        }
    }

    /**
     * 
     * this function returns the current deliveries
     */
    public function currentDeliveries(Request $request)
    {
        $packages = Package::onDeliveryPackages();

        $deliverers = $packages->map->only(['deliverer']);
        $deliverers = Deliverer::deliverers($deliverers);
        
        if(!((isset($request->header()['content-type'][0]) && $request->header()['content-type'][0] === "application/json") || $request->isMethod('post'))){
            return view('admin.currentDeliveries', compact('packages', 'deliverers'));
        }else{
            $data['deliverers'] = $deliverers;
            $data['packages'] = $packages;

            return response()->json([
                "data" => $data,
            ], 200);
        }
        
    }

    /**
     * 
     * this function returns the deliverers
     */
    // public function deliverersOnDelivering(Request $request)
    // {
    //     $deliverers = Deliverer::deliverers();

    //     if(isset($request->deliverers)){
    //         $deliverers = Deliverer::deliverers($request->deliverers);
    //     }

    //     return response()->json([
    //         'deliverers' => $deliverers,
    //     ]);
    // }
}
