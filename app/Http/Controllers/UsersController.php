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

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('user');
    }
    /**
     * 
     * this function returns all the packages
     */
    public function allPackages(Request $request)
    {
        $packages = Package::allPackages(config('admin.packages-paginate'));
        // print_r($packages);
        if(!(isset($request->header()['content-type'][0]) && $request->header()['content-type'][0] === "application/json")){
            return view('user.packages', compact('packages'));
        }else{
            $data['packages'] = $packages;

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
            return view('user.managePackage');
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
}
