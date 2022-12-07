<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SMSProvider;
class SMSProviderController extends Controller
{
    public function SmsProvider(){
    	$sms_provider = SMSProvider::first();
    	return view('sms.provider.index',compact('sms_provider'));
    }

    public function SmsProviderStore(Request $request){
    	$this->validate($request, [
            'sms_provider' => 'required',
          ]);

    	// SMSProvider::truncate();

    	if($request->sms_provider == 'Twilio'){
    		$sms_provider = new SMSProvider();
	        $sms_provider->provider_name = $request->sms_provider;
	        $sms_provider->client_id = $request->client_id;
	        $sms_provider->client_secret = $request->client_secret;
			$sms_provider->twilio_number = $request->twilio_number;
			$sms_provider->mobile_prefix = $request->tmob_prefix;
			$sms_commission = \config('cost_commission.sms_commission');
			$sms_provider->sms_commission = $sms_commission;
	        $sms_provider->save();
    	}
    	if($request->sms_provider == 'Nexmo'){
    		$sms_provider = new SMSProvider();
	        $sms_provider->provider_name = $request->sms_provider;
	        $sms_provider->client_id = $request->Nexmo_client_id;
			$sms_provider->client_secret = $request->Nexmo_client_secret;
			$sms_provider->twilio_number = NULL;
			$sms_commission = \config('cost_commission.sms_commission');
			$sms_provider->sms_commission = $sms_commission;
			$sms_provider->mobile_prefix = $request->nmob_prefix;
	        $sms_provider->save();
    	}
        if($request->sms_provider == 'Ez4U_SMS'){
            $sms_provider = new SMSProvider();
            $sms_provider->provider_name = $request->sms_provider;
            $sms_provider->client_id = $request->ez4u_client_id;
			$sms_provider->client_secret = $request->ez4u_client_secret;
			$sms_provider->twilio_number = NULL;
			$sms_commission = \config('cost_commission.sms_commission');
			$sms_provider->sms_commission = $sms_commission;
			$sms_provider->ez4u_url = $request->ez4u_url;
			$sms_provider->mobile_prefix = $request->mob_prefix;
            $sms_provider->save();
        }


    	return redirect()->route('SmsProvider');
    }
}
