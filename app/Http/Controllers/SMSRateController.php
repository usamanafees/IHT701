<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SMSRate;
use App\Countries;
use Auth;
use App\SMSProvider;

class SMSRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $smsrates = SMSRate::get();
        $sms_provider = SMSProvider::get();
        $countries = Countries::All();
        // dd($smsrate);
        return view('smsrate.index',compact('smsrates','sms_provider','countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sms_provider = SMSProvider::get();
        $countries = Countries::All();
        $smsrates = SMSRate::get();
        return view('smsrate.create', ['smsrates'=>$smsrates,'provider'=>$sms_provider, 'countries'=>$countries]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'country_name' => 'required|string|max:255',
            'provider_name' => 'required|string|max:255',
            "rate"  =>  "required|numeric",
          ]);

        $sms_rate = New SMSRate();
        $sms_rate->sms_provider_id = $request->provider_name;
        $sms_rate->country_id  = $request->country_name;
        $sms_rate->rate = $request->rate;
        $sms_rate_check =SMSRate::where('sms_provider_id',$request->provider_name)->where('country_id',$request->country_name)->pluck('id');
        if(count($sms_rate_check)>0){
        $sms_rate_check1 =SMSRate::where('sms_provider_id',$request->provider_name)->first();
        $sms_rate_check1->sms_provider_id = $request->provider_name;
        $sms_rate_check1->country_id  = $request->country_name;
        $sms_rate_check1->rate = $request->rate;
        $sms_rate_check1->save();
        return redirect()->route('smsrates')->with('success','Rate is updated');
        }
        else{
        $sms_rate->save();
        return redirect()->route('smsrates')->with('success','Rate is added');
        }
    
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
        $sms_rate = SMSRate::find($id);
        $provider = SMSProvider::get();
        $countries = Countries::All();
        return view('smsrate.edit',compact('sms_rate','provider','countries'));
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
        $sms_rate = SMSRate::find($id);
        $sms_rate->sms_provider_id = $request->provider_name;
        $sms_rate->country_id  = $request->country_name;
        $sms_rate->rate = $request->rate;
        $sms_rate->save();
        $sms_rate->update();

        return redirect()->route('smsrates');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SMSRate::find($id)->delete();
        return redirect()->route('smsrates');
    }

    public function sms_price($country_id,$provider_id){
    $sms_rate = SMSRate::where('country_id',$country_id )->min('rate');
    return $sms_rate;
    
    }
}
