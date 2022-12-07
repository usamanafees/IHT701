<?php

namespace App\Http\Controllers;

use App\SMS;
use App\SMS_Sender;
use Illuminate\Http\Request;
use App\Items;
use App\User;
use Auth;
use DB;
use phpDocumentor\Reflection\Types\AbstractList;

class ReportController extends Controller
{
    public function reportSms()
    {
        return view('reports.index_sms');
    }

    public function reportInvoice()
    {
        return view('reports.index_invoice');
    }
    public function reportSmsSent(Request $request)
    {
        if (in_array("Administrator", Auth::user()->roles()->pluck('name')->toArray())) {
            if (!empty(($request->get('daterange')))) {
                $request = ($request->get('daterange'));
                preg_match_all('/\d{2}\/\d{2}\/\d{4}/', $request, $request);
                $begin = (new \DateTime($request[0][0]));
                $begin = $begin->format('Y-m-d');
                $end = (new \DateTime($request[0][1]));
                $end = $end->format('Y-m-d');
                $give_result = DB::table('sms_sender')
                    ->leftJoin('sms_person', 'sms_sender.id', '=', 'sms_person.sender')
                    ->whereBetween('sms_person.created_at', [date($begin), date($end)])
                    ->select('sms_sender.sender', DB::raw('COUNT(sms_person.id) AS Total'))
                    ->groupBy('sms_sender.id')
                    ->get();
            } else {
                $give_result = DB::table('sms_sender')
                    ->leftJoin('sms_person', 'sms_sender.id', '=', 'sms_person.sender')
                    ->select('sms_sender.sender', DB::raw('COUNT(sms_person.id) AS Total'))
                    ->whereDate('sms_person.created_at',date('Y-m-d'))
                    ->groupBy('sms_sender.id')
                    ->get();
            }
        } else {
            if (!empty(($request->get('daterange')))) {
                $request = ($request->get('daterange'));
                preg_match_all('/\d{2}\/\d{2}\/\d{4}/', $request, $request);
                $begin = (new \DateTime($request[0][0]));
                $begin = $begin->format('Y-m-d');
                $end = (new \DateTime($request[0][1]));
                $end = $end->format('Y-m-d');
                $give_result = DB::table('sms_sender')
                    ->leftJoin('sms_person', 'sms_sender.id', '=', 'sms_person.sender')
                    ->where('sms_person.user_id', \Illuminate\Support\Facades\Auth::user()->id)
                    ->whereBetween('sms_person.created_at', [date($begin), date($end)])
                    ->select('sms_sender.sender', DB::raw('COUNT(sms_person.id) AS Total'))
                    ->groupBy('sms_sender.id')
                    ->get();
            } else {
                $give_result = DB::table('sms_sender')
                    ->leftJoin('sms_person', 'sms_sender.id', '=', 'sms_person.sender')
                    ->where('sms_person.user_id', \Illuminate\Support\Facades\Auth::user()->id)
                    ->whereDate('sms_person.created_at',date('Y-m-d'))
                    ->select('sms_sender.sender', DB::raw('COUNT(sms_person.id) AS Total'))
                    ->groupBy('sms_sender.id')
                    ->get();
            }
        }
        return view('reports.sms_sent', compact('give_result'));
    }
    public function reportBillingByItem(Request $request)
    {
        if (in_array("Administrator", Auth::user()->roles()->pluck('name')->toArray())) {
            if (!empty(($request->get('daterange')))) {
                $request_date = ($request->get('daterange'));
                preg_match_all('/\d{2}\/\d{2}\/\d{4}/', $request_date, $request_date);
                $begin = (new \DateTime($request_date[0][0]));
                $begin = $begin->format('Y-m-d');
                $end = (new \DateTime($request_date[0][1]));
                $end = $end->format('Y-m-d');
                if (!empty($request->get('item_id'))) {
                    $give_result = DB::table('invl_items')
                        ->leftJoin('invoices', 'invl_items.invid', '=', 'invoices.id')
                        ->where('invl_items.item_id', ($request->get('item_id')))
                        ->whereBetween('invoices.inv_date', [date($begin), date($end)])
                        ->select('invl_items.description', DB::raw('SUM(invl_items.qty) AS Total'), DB::raw('SUM(invl_items.qty)*invl_items.unit_price AS PriceTotal'))
                        ->groupBy('invl_items.description', 'invl_items.unit_price')
                        ->get();
                } else {
                    $give_result = DB::table('invl_items')
                        ->leftJoin('invoices', 'invl_items.invid', '=', 'invoices.id')
                        ->whereBetween('invoices.inv_date', [date($begin), date($end)])
                        ->select('invl_items.description', DB::raw('SUM(invl_items.qty) AS Total'), DB::raw('SUM(invl_items.qty)*invl_items.unit_price AS PriceTotal'))
                        ->groupBy('invl_items.description', 'invl_items.unit_price')
                        ->get();
                }
            } else {
                if (!empty($request->get('item_id'))) {
                    $give_result = DB::table('invl_items')
                        ->leftJoin('invoices', 'invl_items.invid', '=', 'invoices.id')
                        ->where('invl_items.item_id', $request->get('item_id'))
                        ->select('invl_items.description', DB::raw('SUM(invl_items.qty) AS Total'), DB::raw('SUM(invl_items.qty)*invl_items.unit_price AS PriceTotal'))
                        ->groupBy('invl_items.description', 'invl_items.unit_price')
                        ->get();
                } else {
                    $give_result = DB::table('invl_items')
                        ->select('invl_items.description', DB::raw('SUM(invl_items.qty) AS Total'), DB::raw('SUM(invl_items.qty)*invl_items.unit_price AS PriceTotal'))
                        ->groupBy('invl_items.description', 'invl_items.unit_price')
                        ->get();
                }
            }
        } else {
            if (!empty(($request->get('daterange')))) {
                $request_date = ($request->get('daterange'));
                preg_match_all('/\d{2}\/\d{2}\/\d{4}/', $request_date, $request_date);
                $begin = (new \DateTime($request_date[0][0]));
                $begin = $begin->format('Y-m-d');
                $end = (new \DateTime($request_date[0][1]));
                $end = $end->format('Y-m-d');
                if (!empty($request->get('item_id'))) {
                    $give_result = DB::table('invl_items')
                        ->leftJoin('invoices', 'invl_items.invid', '=', 'invoices.id')
                        ->where('invl_items.item_id', ($request->get('item_id')), 'invoices.uid', \Illuminate\Support\Facades\Auth::user()->id)
                        ->whereBetween('invoices.inv_date', [date($begin), date($end)])
                        ->select('invl_items.description', DB::raw('SUM(invl_items.qty) AS Total'), DB::raw('SUM(invl_items.qty)*invl_items.unit_price AS PriceTotal'))
                        ->groupBy('invl_items.description', 'invl_items.unit_price')
                        ->get();
                } else {
                    $give_result = DB::table('invl_items')
                        ->leftJoin('invoices', 'invl_items.invid', '=', 'invoices.id')
                        ->where('invoices.uid', \Illuminate\Support\Facades\Auth::user()->id)
                        ->whereBetween('invoices.inv_date', [date($begin), date($end)])
                        ->select('invl_items.description', DB::raw('SUM(invl_items.qty) AS Total'), DB::raw('SUM(invl_items.qty)*invl_items.unit_price AS PriceTotal'))
                        ->groupBy('invl_items.description', 'invl_items.unit_price')
                        ->get();
                }
            } else {
                if (!empty($request->get('item_id'))) {
                    $give_result = DB::table('invl_items')
                        ->where('invoices.uid', \Illuminate\Support\Facades\Auth::user()->id)
                        ->where('invl_items.item_id', $request->get('item_id'))
                        ->select('invl_items.description', DB::raw('SUM(invl_items.qty) AS Total'), DB::raw('SUM(invl_items.qty)*invl_items.unit_price AS PriceTotal'))
                        ->groupBy('invl_items.description', 'invl_items.unit_price')
                        ->get();
                } else {
                    $give_result = DB::table('invl_items')
                        ->leftJoin('invoices', 'invl_items.invid', '=', 'invoices.id')
                        ->where('invoices.uid', \Illuminate\Support\Facades\Auth::user()->id)
                        ->select('invl_items.description', DB::raw('SUM(invl_items.qty) AS Total'), DB::raw('SUM(invl_items.qty)*invl_items.unit_price AS PriceTotal'))
                        ->groupBy('invl_items.description', 'invl_items.unit_price')
                        ->get();
                }
            }
        }
        if (!empty ($request->input('search'))) {
            $search = $request->input('search');
            $names = items::select('description', 'id')->where('description', 'LIKE', "%{$search}%")->get();
            return view('reports.BillingByItem', compact('give_result', 'names'));
        } else {
            return view('reports.BillingByItem', compact('give_result'));
        }
    }
    public function InvoicesPerBrand(Request $request)
    {
        if (in_array("Administrator", Auth::user()->roles()->pluck('name')->toArray())) {
            if (!empty(($request->get('inv_type')) and !empty(($request->get('brand_id'))))) {
                $give_result = DB::table('invoices')
                    ->leftJoin('brands', 'invoices.brands_id', '=', 'brands.id')
                    ->where('invoices.brands_id', ($request->get('brand_id')))
                    ->where('invoices.is_receipt', ($request->get('inv_type')))
                    ->select('brands.name', DB::raw('count(invoices.id) AS total_invoices'))
                    ->groupBy('invoices.brands_id')
                    ->get();
            } elseif (!empty(($request->get('inv_type')))) {
                $give_result = DB::table('invoices')
                    ->leftJoin('brands', 'invoices.brands_id', '=', 'brands.id')
                    ->whereNotNull('invoices.brands_id')
                    ->where('invoices.is_receipt', ($request->get('inv_type')))
                    ->select('brands.name', DB::raw('count(invoices.id) AS total_invoices'))
                    ->groupBy('invoices.brands_id')
                    ->get();
            } elseif (!empty(($request->get('brand_id')))) {
                $give_result = DB::table('invoices')
                    ->leftJoin('brands', 'invoices.brands_id', '=', 'brands.id')
                    ->where('invoices.brands_id', ($request->get('brand_id')))
                    ->select('brands.name', DB::raw('count(invoices.id) AS total_invoices'))
                    ->groupBy('invoices.brands_id')
                    ->get();
            } else {
                $give_result = DB::table('invoices')
                    ->leftJoin('brands', 'invoices.brands_id', '=', 'brands.id')
                    ->where('invoices.brands_id', '>', 0)
                    ->select('brands.name', DB::raw('count(invoices.id) AS total_invoices'))
                    ->groupBy('invoices.brands_id')
                    ->get();
            }
            $brands_available = DB::table('brands')
                ->whereNotNull('brands.name')
                ->select('brands.id', 'brands.name')
                ->get();
            $inv_type_available = DB::table('invoices')
                ->distinct()
                ->select('invoices.is_receipt')
                ->get();
            //dd($give_result);

        }
        else{
            if (!empty(($request->get('inv_type')) and !empty(($request->get('brand_id'))))) {
                $give_result = DB::table('invoices')
                    ->leftJoin('brands', 'invoices.brands_id', '=', 'brands.id')
                    ->where('invoices.brands_id', ($request->get('brand_id')))
                    ->where('invoices.is_receipt', ($request->get('inv_type')))
                    ->where('invoices.uid', \Illuminate\Support\Facades\Auth::user()->id)
                    ->select('brands.name', DB::raw('count(invoices.id) AS total_invoices'))
                    ->groupBy('invoices.brands_id')
                    ->get();
            } elseif (!empty(($request->get('inv_type')))) {
                $give_result = DB::table('invoices')
                    ->leftJoin('brands', 'invoices.brands_id', '=', 'brands.id')
                    ->whereNotNull('invoices.brands_id')
                    ->where('invoices.is_receipt', ($request->get('inv_type')))
                    ->where('invoices.uid', \Illuminate\Support\Facades\Auth::user()->id)
                    ->select('brands.name', DB::raw('count(invoices.id) AS total_invoices'))
                    ->groupBy('invoices.brands_id')
                    ->get();
            } elseif (!empty(($request->get('brand_id')))) {
                $give_result = DB::table('invoices')
                    ->leftJoin('brands', 'invoices.brands_id', '=', 'brands.id')
                    ->where('invoices.brands_id', ($request->get('brand_id')))
                    ->where('invoices.uid', \Illuminate\Support\Facades\Auth::user()->id)
                    ->select('brands.name', DB::raw('count(invoices.id) AS total_invoices'))
                    ->groupBy('invoices.brands_id')
                    ->get();
            } else {
                $give_result = DB::table('invoices')
                    ->leftJoin('brands', 'invoices.brands_id', '=', 'brands.id')
                    ->where('invoices.uid', \Illuminate\Support\Facades\Auth::user()->id)
                    ->whereNotNull('invoices.brands_id')
                    ->select('brands.name', DB::raw('count(invoices.id) AS total_invoices'))
                    ->groupBy('invoices.brands_id')
                    ->get();
            }
            $brands_available = DB::table('brands')
                ->where('brands.user_id', \Illuminate\Support\Facades\Auth::user()->id)
                ->whereNotNull('brands.name')
                ->select('brands.id', 'brands.name')
                ->get();
            $inv_type_available = DB::table('invoices')
                ->where('invoices.uid', \Illuminate\Support\Facades\Auth::user()->id)
                ->distinct()
                ->select('invoices.is_receipt')
                ->get();
            //dd($give_result);






        }



        return view('reports.InvoicesPerBrand', compact('give_result', 'brands_available', 'inv_type_available'));
    }
}