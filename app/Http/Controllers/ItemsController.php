<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Items;
use App\User;
use Auth;
use DB;

class ItemsController extends Controller
{

    public function __construct() {
        $this->middleware(['auth', 'clearance']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    
        $item;
        if(in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
        {
            $item = Items::all();

        }else
        {
            $item=Items::where('user_id',Auth::user()->id)->get();

        }
        return view('Items.index',compact('item'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::find(Auth::user()->id);
            if(empty($user->user_fee_list)) {
                $fee_list = json_decode($user->user_fee_list);
            }
            else{
               DB::table('users')->where('id',Auth::user()->id)->update(['user_fee_list'=>'{"1":["23","IVA"]}']);
                $user = User::find(Auth::user()->id);
                $fee_list = json_decode($user->user_fee_list);
            }
        //dd($fee_list);
        return view('Items.create',compact('fee_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $Item = new Items();
        $Item->code = $request->code;
        $Item->type = $request->type;
        $Item->unit = $request->unit;
        $Item->price = $request->price;
        $Item->tax = $request->tax;
        $Item->description = $request->description;
        $Item->user_id=Auth::user()->id;

        $Item->save();
        return redirect()->route('items');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Item = Items::find($id);
        if(isset($Item ) && !empty($Item ))
        {
            $user = User::find($Item->user_id);
            if(isset($user) && !empty($user))
            {
                $fee_list = json_decode($user->user_fee_list);
            }else
            {
                $user = User::find(Auth::user()->id);
                if(isset($user) && !empty($user))
                {
                    $fee_list = json_decode($user->user_fee_list);
                }else
                {
                    $user = User::find(Auth::user()->id);
                    $fee_list = "";
                }
            }
        }else{
            $fee_list = "";
            return redirect()->back()->with('item not found');
        }
        return view('Items.edit',compact('Item','fee_list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Item = Items::find($id);
        $Item->code = $request->code;
        $Item->type = $request->type;
        $Item->unit = $request->unit;
        $Item->price = $request->price;
        $Item->tax = $request->tax;
        $Item->description = $request->description;
        $Item->save();

        return redirect()->route('items');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        if(isset($request->item_id) && !empty($request->item_id)) {
            $items = Items::find($request->item_id)->delete();
            if ($items == 1) {
                return response()->json(['success' => 'true', 'id' => $request->item_id]);
            } else {
                return response()->json(['success' => 'false', 'id' => $request->item_id]);
            }
        }
        return response()->json(['success'=>'false','id'=>$request->item_id]);
    }

    public function item_list(Request $request){
            $items = Items::where('user_id','=',Auth::user()->id)->get();
        return json_encode($items);
    }
    public function item_live_Search(Request $request){
        $query = $request->item;
        $items = Items::where('code', 'like', '%'.$query.'%')->where('user_id','=',Auth::user()->id)->get();
        return json_encode($items);
    }
}