<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AllProduct;
use App\Models\Order;
use Validator;
use Carbon\Carbon; 
use Mail; 
use Hash;
use DB;

class AdminController extends Controller
{
        public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: *');
        header('Access-Control-Allow-Headers: *');  
    }
     public  function getProductCount(Request $request){
        $getproductCount = AllProduct::ProductCount();
        if($getproductCount<=0){
            return response()->json([
                'messgae'=>$getproductCount,
            ],204);
        }
        return $getproductCount;
     }
     public  function getRecentAddedProduct(Request $request){
        $getrecentProduct = AllProduct::RecentAddedProduct();
        return $getrecentProduct;
        if($getrecentProduct<=0){
            return response()->json([
                'messgae'=>$getrecentProduct,
            ],204);
        }
        return response()->json([
            'message'=>$getrecentProduct,
        ],201);

        
     }
     public function getRecentCustomer(Request $request){
        $recentUsers = User::with('roles')
        ->whereHas('roles', function ($query) {
            $query->where('name', 'customer');
        })
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();
            if($recentUsers){
                return response()->json([
                    "status"=>"200",
                    'message'=>"customer recently joined",
                    "data"=>$recentUsers,
                ],200);
            }else{
                return response()->json([
                    'eroor'=>"no customer with thi role",
                
                    "status"=>"204"
                ],204);
            }
     }
     
    public function getCustomerCount(Request $request){
        $userCount = User::with('roles')->get()->filter(
            fn ($user) => $user->roles->where('name', 'customer')->toArray()
        )->count();
        if($userCount>0){
            return response()->json([
                'message'=>"Total customer ",
                    'data'=>$userCount,
                "status"=>"200"
            ],200);
        }else{
            return response()->json([
                "status"=>"204",
                'eroor'=>"no customer",
                "status"=>"204"
            ],204);

        }

    }
    public function getAllorder(Request $request){ 
        $allOrder  = Order::countOrderAll();
        if($allOrder>0){
            return $allOrder;
        }  
    }
    public function getcountTotalSale(Request $request){ 
        $allSale  = Order::countTotalSale();
        return $allSale;
        if($allSale>0){
            return $allSale; 
        }  

    }

    public function count(Request $request ){
        $allSale = Order::countTotalSale() ?? null;
        $getproductCount = AllProduct::ProductCount()??null;
        $allOrder  = Order::countOrderAll()??null;
        $userCount = User::with('roles')->get()->filter(
            fn ($user) => $user->roles->where('name', 'customer')->toArray()
        )->count() ?? null;

        return response()->json([
            'message'=>"all count data",
            "data"=>[
                'allSaleCount'=>$allSale,
                'allProductCount'=>$getproductCount,
                'allOrderCount'=>$allOrder,
                'allCustomerCount'=>$userCount
            ]
            ],200);
    


    }

    //users
    public function getDeleteUser(Request $request){  
        $validator = Validator::make($request->all(), [
            'id' => 'required|Int'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422); 
        }
            $userDelete = User::DeleteUser($request->id);
            if($userDelete==TRUE){
                return response()->json([
                    "messgae"=>"User deleted Sucessfully",
                     "status"=>200
                ]);
            }else{
                return response()->json([
                    "messgae"=>"No user found ",
                     "status"=>204
                ]);

            }   
    }

    
    public function getSingleUserDetails(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|Int'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422); 
        }
        $userData = User::singleUserDetails($request->id);
        if($userData==false){
            return response()->json([
                "status"=>204,
                "messgae"=>"No user found "     
            ],204);
        }
        return response()->json([
            "status"=>200,
            "messgae"=>"User data ",
            "data"=>$userData   
        ],200);


    


        
        
    }
    
    //Important to note that send the data in the json fromat 
    public function getEditSingleUserDetails(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422); 
        }
        $userData = User::EditSingleUserDetails($request->all());
        if($userData==false){
            return response()->json([
                "status"=>204,
                "messgae"=>"No user found "     
            ],204);
        }
        return response()->json([
            "status"=>201,
            "messgae"=>"User data updated Sucessfully",
        ],201);


    


        
        
    }
    

    public function editStarProduct(Request $request)
    {
        $ids = $request->input('ids');
        // Check if the array has exactly ten IDs
        if (count($ids) !== 3) {
            return response()->json(['message' => 'Incomplete data. Please provide exactly  3 IDs.'], 400);
        }
        // Check if all IDs exist in the database
        $existingIds = AllProduct::whereIn('id', $ids)->pluck('id')->toArray();
        $missingIds = array_diff($ids, $existingIds);
    
        if (!empty($missingIds)) {
            return response()->json(['message' => 'One or more IDs do not exist in the database.'], 400);
        }
        AllProduct::where('starproduct',1)->update(['starproduct' => 0]);
        // Proceed with the update
        AllProduct::whereIn('id', $ids)->update(['starproduct' => 1]);
        return response()->json(['message' => 'Update successful.']);
    }
    


    




}
    


