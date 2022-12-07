<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Clients;
use App\Items;
use App\LineItems;
use App\Invoices;
use Log;
use File;
use Auth;
use Illuminate\Support\Facades\Storage;
use Response;

class Import_wizardController extends Controller
{
    public function upload_items(Request $request)
    {
        $upload=$request->file('upload-file');
        $filePath=$upload->getRealPath();
        $file=fopen($filePath, 'r');
        $header= fgetcsv($file);
        $escapedHeader=[];
        $other_rows=array(array());
        $j = 0;
        while($columns=fgetcsv($file))
        {
            $check_l = 0;
            if($j<=5)
            {
                Log::info($columns);
            }
            dd("done");
            $string_version = implode(',', $columns);
            $string_version_two =str_replace(',', "", $string_version); 
            $result = explode(';',$string_version_two);
                foreach($result as $res)
                {
                    if(strlen($res) > 191)
                    {
                        $check_l = 1;
                    }
                    $other_rows[$j][] = utf8_encode($res);
                }
                if($check_l !=0)
                {
                    $other_rows[$j][] = 1;
                }
                else
                {
                    $other_rows[$j][] = 0;
                }
                $j++;
        }
        $Items=new Items();
        $Items_columns=$Items->dynamci_final_items();
        return response()->json(['other_rows'=>$other_rows,'columns'=>$Items_columns]);
    }
    function store_csv_items(Request $request)
    {
        $data = json_decode($request->data);
        $map = json_decode($request->arr);      
        for($i=0;$i<count($data);$i++)
         {  
            $items = new Items();
            for($j=0;$j<count($map);$j++)
            {
                    $col = $map[$j];
                    if(($col == "created_at") ||($col=="updated_at") ||($col == "deleted_at")||($col == "id"))
                    {
                        continue;
                    }
                    if($data[$i][$j]=="NULL")
                    {
                        $items->$col= null;
                    }else
                    {
                        $items->$col= $data[$i][$j];
                    }
            }
            $items->save();
         }
         return  response()->json("csv imported successfully");
    }
    public function upload_clients(Request $request)
    {
        //Log::info($request->file('upload-file'));
        //move_uploaded_file($request->file('upload-file'),public_path().'\temp' .$request->file('upload-file'));
        $write_file_rows = array();
        $row_count_check = 0;
        $upload=$request->file('upload-file');
        $filePath=$upload->getRealPath();
        //$filePath=public_path().'\temp'.
        //Log::info($filePath);
        $file=fopen($filePath, 'r');
        $header= fgetcsv($file);
        $er_header= $header;
        //Log::info($er_header);
        array_unshift($er_header , '');
        $write_file_rows[] = $er_header; 
        $escapedHeader=[];
       // validate
        foreach ($header as $key => $value) 
        {
            $lheader=strtolower($value);
            $escapedItem=preg_replace('[^a-z]', '', $lheader);
            array_push($escapedHeader, $escapedItem);
        }
        $other_rows=array(array());
        $j = 0;
        $error_occourd = 0;
        //looping through othe columns
        while($columns=fgetcsv($file))
        {
            
            $check_l = 0;
            $string_version = implode(',', $columns);
            $string_version_two =str_replace(',', "", $string_version); 
            $result = explode(';',$string_version_two);
                foreach($result as $res)
                {
                    if(strlen($res) > 191)
                    {
                        $check_l = 1;
                    }
                    $other_rows[$j][] = utf8_encode($res);
                }
                // $result['vat_number'] = $other_rows[$j][2];
                // $v = Validator::make($result, [
                //    'vat_number' => 'unique:clients',
                // ]);
                // if ($v->fails()) {
                //     $check_l = 1;
                // }
                if($check_l !=0)
                {
                    $error_occourd = 1;
                    $other_rows[$j][] = 1;
                   //$columns[] = 'Duplicate vat_number';
                    array_unshift($columns , 'More than 191 characters');
                }
                else
                {
                    $other_rows[$j][] = 0;
                    //$columns[] = '';
                   array_unshift($columns , '');
                }
                $j++;
                $write_file_rows[] = $columns; 
        }
        fclose($file);
        array_unshift($other_rows ,$er_header);
        // $dup = array(); 
        // for($i=0;$i<count($other_rows);$i++)
        // {
        //     if(isset($other_rows[$i][2]))
        //     {
        //          $dup[$i] = $other_rows[$i][2];
        //     }
        // }
        // $unique = array_unique($dup);
        // $diffCellUniq = array_diff_key($dup, $unique);
        // foreach ($diffCellUniq as $key => $value)
        // {
        //    $error_occourd = 1;
        //    $other_rows[$key][14]=1;
        //    $write_file_rows[$key][0]='Duplicate vat_number';
        //    //array_unshift($write_file_rows[$key] , 'Duplicate vat_number');
        // }
        array_splice($other_rows, 0, 1);
        $d_path = 'ok';

        // if($error_occourd != 0 )
        // {
            $newpath= $upload->move(public_path().'/files', "".Auth::user()->id."newcsv_file.csv");
            copy(public_path().'/files/'."".Auth::user()->id."newcsv_file.csv", public_path().'/files/'."no_err".Auth::user()->id."newcsv_file.csv");
            $d_path = ''.Auth::user()->id.'newcsv_file.csv';
            // $handle = fopen($newpath, 'w');
            // foreach ($write_file_rows as $line) 
            // {
            //   fputcsv($handle, $line);  
            // }
            // fclose($handle);
        //}
        $row_count_check = count($other_rows);
        // if($row_count_check <= 1000)
        // {
        // }
            $clients=new Clients();
            $columns=$clients->dynamci_final();
            return response()->json(['other_rows'=>$other_rows,'columns'=>$columns,'count_check'=>0,'path'=>$d_path,'count_check'=>$row_count_check]);
        
        
        // else
        // {
        //     Log::info($other_rows);
        //     return response()->json(['count_check'=>1]);
        // }
        
    }

    public function upload_clients_eupago(Request $request)
    {
        $write_file_rows = array();
        $row_count_check = 0;
        $upload=$request->file('upload_file_eupago');
        $filePath=$upload->getRealPath();
        $file=fopen($filePath, 'r');
        $header= fgetcsv($file);
        $er_header= $header;
        array_unshift($er_header , '');
        $write_file_rows[] = $er_header;
        $escapedHeader=[];

        foreach ($header as $key => $value)
        {
            $lheader=strtolower($value);
            $escapedItem=preg_replace('[^a-z]', '', $lheader);
            array_push($escapedHeader, $escapedItem);
        }
        $other_rows=array(array());
        $j = 0;
        $error_occourd = 0;
        while($columns=fgetcsv($file))
        {

            $check_l = 0;
            $string_version = implode(',', $columns);
            $string_version_two =str_replace(',', "", $string_version);
            $result = explode(';',$string_version_two);
            foreach($result as $res)
            {
                if(strlen($res) > 191)
                {
                    $check_l = 1;
                }
                $other_rows[$j][] = utf8_encode($res);
            }
            if($check_l !=0)
            {
                $other_rows[$j][] = 1;
                array_unshift($columns , 'More than 191 characters');
            }
            else
            {
                $other_rows[$j][] = 0;
                array_unshift($columns , '');
            }
            $j++;
            $write_file_rows[] = $columns;
        }
        fclose($file);
        array_unshift($other_rows ,$er_header);
        array_splice($other_rows, 0, 1);
        $d_path = 'ok';

        $newpath= $upload->move(public_path().'/files', "".Auth::user()->id."newcsv_file.csv");
        copy(public_path().'/files/'."".Auth::user()->id."newcsv_file.csv", public_path().'/files/'."no_err".Auth::user()->id."newcsv_file.csv");
        $d_path = ''.Auth::user()->id.'newcsv_file.csv';

        $row_count_check = count($other_rows);

        $clients=new Clients();
        $columns=$clients->dynamci_final_eupago();
        return response()->json(['other_rows'=>$other_rows,'columns'=>$columns,'count_check'=>0,'path'=>$d_path,'count_check'=>$row_count_check]);

    }
    
    public function export_clients()
    {
            $client = '';
            $file_name = Auth::user()->id.'exported_invoice.csv';
            $newpath=public_path().'/files/export/'.$file_name;
            $data = '';
            $aaa = File::put($newpath,$data);
            if($aaa == 0)
            {
                $invoices = Invoices::all();
                $obj = array();
                $j=0;
                foreach($invoices as $oba)
                {
                   $client = Clients::where('id',$oba->cid)->first();
                   $line_items = LineItems::where('invid',$oba->id)->get();
                    foreach($line_items as $li)
                    {           
                            $obj[$j] = $client->id.';';
                            if(isset($client) && !empty($client)){
                                $obj[$j] .= $client->name.';';
                                $obj[$j] .= $client->vat_number.';';
                                $obj[$j] .= $li->vat.';';
                                $obj[$j] .= $client->email.';';
                                $obj[$j] .= $client->address.';';
                                $obj[$j] .= $client->city.';';
                                $obj[$j] .= $client->postal_code.';';
                                $obj[$j] .= $client->country.';';
                            }else{
                                $obj[$j] .= 'NULL'.';';
                                $obj[$j] .= 'NULL'.';';
                                $obj[$j] .= 'NULL'.';';
                                $obj[$j] .= 'NULL'.';';
                                $obj[$j] .= 'NULL'.';';
                                $obj[$j] .= 'NULL'.';';
                                $obj[$j] .= 'NULL'.';';
                            }
                            $obj[$j] .= 'N/A'.';';
                            $obj[$j] .= $li->qty.';';
                            $obj[$j] .= $li->description.';';
                            $obj[$j] .= $li->unit_price.';';
                            $obj[$j] .= $oba->created_at.';';
                            $j++;
                    }
                }
                $handle = fopen($newpath, 'w');
                $arr = array();
                $arr[0]= " ";
                fputcsv($handle, $arr);
                foreach ($obj as $line) 
                {
                    
                    $arr[0]= $line;
                    fputcsv($handle, $arr);  
                }
               
                fclose($handle);
            }
            $headers = [
                'Content-Type' => 'application/csv',
            ];
            $newpath_without_name=public_path().'/files/export/';
            return Response::download(public_path('/files/export/'.$file_name));
    }
    public function sample_excel()
    {

        return Response::download(public_path('/files/sample/excel.csv'));
    }
    
    

}



