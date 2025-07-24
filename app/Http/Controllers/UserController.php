<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Auth;

class UserController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name'     => 'required|min:3|max:30',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        
    if ($validator->fails()) {
        return response()->json($validator->errors(), 422); 
    }

        $data = [
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ];

        $user = User::create($data);
        return response()->json($user,201);
    }
    public function getdata(){
        $data=User::all()->toArray();
        return $data;
    }
    public function login(Request $request){
        $validator=Validator::make($request->all(),[
            'email'=>'required',
            'password'=>'required',
        ]);
        if( $validator->fails()){
            return response()->json($validator->errors(),422);
        }
        $data['email']=$request->email;
        $data['password']=$request->password;
        $user=Auth::attempt($data);
        if($user){
            return response()->json(['status'=>true,'message'=>'login successfull','data'=>$user,'code'=>200]);
        }else{
           return response()->json(['status'=>false,'message'=>'Email or Password does not match','data'=>null,'code'=>400]);
        }
    }
    public function update(Request $request){
        $validator=Validator::make($request->all(),[
            'name'=>'required|min:3|max:30',
            'email'=>'required|email',

        ]);
        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }
        $id=$request->id;
        $data['name']=$request->name;
        $data['email']=$request->email;
        $user=User::where('id',$id)->update($data);
        if($user){
            return response()->json([
                'status'=>true,
                'message'=>'Record Updated',
                'user'=>$user,
                'code'=>200
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'message'=>'Record Not Updated',
                'user'=>null,
                'code'=>400
            ]);
        }
    }
    public function delete($id){
        $dlt=User::where('id',$id)->delete();
        if ($dlt) {
            return response()->json([
                'status'=>true,
                'message'=>"Record deleted",
                'code'=>200,
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'message'=>"Record not deleted",
                'code'=>400,
            ]);

        }
    }
}
