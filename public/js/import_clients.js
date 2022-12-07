var gl_data=[[]];
var check_final_import = 0;
var dynamci_final=[];
var dynamic_options=[]; 
var upload_path; 
$( '#up_clients' ).submit(function ( e ) {
    var formData = new FormData();
    formData.append( 'upload-file',  $( '#upload-file' )[0].files[0] ); 
         e.preventDefault();
        $.ajax({
            headers:
              {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
            url: APP_URL+'/upload_clients',
            data: formData,
            contentType: false,
            processData: false,
            type: 'POST',
        success: function(data)
        {  
            // if(data['count_check'] == 0)
            // {
                var abc ='<table class="table" style="width: 100%">'
                +'<tr>'
                +'<th style="text-align:center">Id</th>'
                +'<th style="text-align:center">Company Name</th>'       
                +'<th style="text-align:center">Vat No.</th>'
                +'<th style="text-align:center">Tax value</th>'
                +'<th style="text-align:center">Email</th>'
                +'<th style="text-align:center">Address</th>'
                +'<th style="text-align:center">location</th>'
                +'<th style="text-align:center">Zip code</th>'
                +'<th style="text-align:center">Country</th>'
                +'<th style="text-align:center">Economic Area</th>'
                +'<th style="text-align:center">Quantity</th>'
                +'<th style="text-align:center">Product </th>'
                +'<th style="text-align:center">Unit price </th>'
                +'<th style="text-align:center">Entry Date</th>'
                +'<th style="text-align:center">status</th>'
                +'</tr>'
                +'</thead>'
                +'<tbody>';
                var runcycle;
                if(data['other_rows'].length > 1000)
                {
                    runcycle = 1000;
                }else
                {
                    runcycle = data['other_rows'].length;
                }
                           //console.log(data['columns']);

                            dynamci_final = data['columns'].slice(0);
                            //console.log( dynamci_final,data['other_rows']);
                     for(var i=0;i<runcycle;i++)
                     {
                            abc+='<tr>'
                            +'<td style="border:1px solid;">'+data['other_rows'][i][0]+'</td>'
                            +'<td style="border:1px solid;">'+data['other_rows'][i][1]+'</td>'
                            +'<td style="border:1px solid;">'+data['other_rows'][i][2]+'</td>'
                            +'<td style="border:1px solid;">'+data['other_rows'][i][3]+'</td>'
                            +'<td style="border:1px solid;">'+data['other_rows'][i][4]+'</td>'
                            +'<td style="border:1px solid;">'+data['other_rows'][i][5]+'</td>'
                            +'<td style="border:1px solid;">'+data['other_rows'][i][6]+'</td>'
                            +'<td style="border:1px solid;">'+data['other_rows'][i][7]+'</td>'
                            +'<td style="border:1px solid;">'+data['other_rows'][i][8]+'</td>'
                            +'<td style="border:1px solid;">'+data['other_rows'][i][9]+'</td>'
                            +'<td style="border:1px solid;">'+data['other_rows'][i][10]+'</td>'
                            +'<td style="border:1px solid;">'+data['other_rows'][i][11]+'</td>'
                            +'<td style="border:1px solid;">'+data['other_rows'][i][12]+'</td>'
                            +'<td style="border:1px solid;">'+data['other_rows'][i][13]+'</td>'
                            if(data['other_rows'][i][14] != 0)
                            {
                                abc += '<td style="border:1px solid;"><i style="color:red;" class="fas fa-times"></i></td>';
                                check_final_import = 1;
                            }
                            else
                            {
                                abc += '<td style="border:1px solid;"><i style="color:green;" class="fas fa-check"></i></td>';
                            }
                           abc +='</tr>';
                     }
                          abc+='<tbody></table>';
                    $('#aaa').html(abc);
                    if(check_final_import != 0)
                    {
                        $('#imp').html('<button  type="button"  class="btn btn-primary" disabled> Next </button>');
                        $('#er_msg').html('<h5 class="text-danger">Invalid entries</h5>');
                    }
                    else
                    {
                        $('#imp').html('<button id="dynamic_next" onclick="dynamic_next()" type="button" class="btn btn-primary">Next</button>');
                    }
                    gl_data = data['other_rows'];
                if(data['path'] != 'ok')
                {
                    upload_path = data['path'];
                    data['path'] = "/"+data['path'];
                    console.log(data['path'])
                    // $('#er_msg').append('<a style="float:left" href="'+flagsUrl+data['path']+'" download>'+
                    // 'Download Info'+
                    // '</a>');
                }

            // }
            // else{
            //     $('#aaa').html('<h3>please upload the csv with less than 1000 rows</h3>');
            // }
        },
        error:function (err)
        {
            $('#aaa').html("Oops something went wrong");   
            console.log(err);
        }
        });
});
function dynamic_next()
{
    for(var i=0; i<dynamci_final.length;i++)
    {
        
       dynamic_options.push([dynamci_final[i],dynamci_final[i]]);
    }
    var a1= '<table class="table" style="width: 100%">'
                +'<tr>'
                +'<th style="text-align:center">Data</th>'
                +'<th style="text-align:center">Columns</th>'
                +'</tr>'
                +'</thead>'
                +'<tbody>';
                
    for(var i =0 ;i<gl_data[0].length-1;i++)
    {
        var sel0;
        if(i == 9) 
        {
            sel0 ="disabled";
        }else
        {
            sel0 ="disabled";
        }
        // if(i != 11)
        // {
        //     if(i != 12)
        //     {
        a1+='<tr></select>'
        +'<td>'+gl_data[0][i]+'</td>';
        a1 +='<td>'
        +'<select id="jjj,'+i+'" '+sel0+' onchange="abc(this.id,this.value);">';
         for(var j=0;j<dynamic_options.length;j++)
        {
           // console.log(dynamic_options[j][0]);
                if(dynamic_options[j][0] === "not_map")
                {
                    var sel;
                    if(j==i)
                    {
                        sel ="selected";
                    }else
                    {
                        sel ="";
                    }
                    a1+='<option value="'+dynamic_options[j][0]+'" '+sel+' disabled>'+dynamic_options[j][1]+'</option>';
                    continue;
                }
                if(dynamic_options[j][0] === "uid")
                {
                    a1+='<option value="'+dynamic_options[j][0]+'" disabled>'+dynamic_options[j][1]+'</option>';
                    continue;
                }
                // if(dynamic_options[j][0] === "file_name")
                // {
                //     a1+='<option value="'+dynamic_options[j][0]+'" disabled>'+dynamic_options[j][1]+'</option>';
                //     continue;
                // }

            if(j==i)
            {
                a1+='<option value="'+dynamic_options[j][0]+'" selected>'+dynamic_options[j][1]+'</option>';
            }else{
                a1+='<option value="'+dynamic_options[j][0]+'" >'+dynamic_options[j][1]+'</option>';
            }
        }
        a1 +='</td></tr>'
        // }
        // }
    }
    a1+='<tbody></table>';
    $('#aaa').html(a1);
    $('#imp').html('<button id="import_clients" onclick="import_clients()" type="button" class="btn btn-primary">Import</button>');
    //$('#aaa').html(abc);
//console.log(a1);
}
function abc(id,val)
{
    var i;
    i = id.split(',')[1];
    dynamci_final[i]=val;
    //console.log(dynamci_final);
   if((new Set(dynamci_final)).size != dynamci_final.length)
    {
        $("#import_clients").prop('disabled', true);
        $('#er_msg').html('<h5 class="text-danger">Two or more records selected for one column</h5>');
        console.log("disabled");
    }
    else
    {
    $("#import_clients").prop('disabled', false);
    $('#er_msg').html("");  
    console.log("enabled");
    }
    }
function import_clients()
{
    //console.log(gl_data);
    $.ajax({
        headers:
              {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
            url: APP_URL+'/clients/store_csv',
            data: {arr:JSON.stringify(dynamci_final),path:upload_path},
            //data: {data: JSON.stringify(gl_data),arr:JSON.stringify(dynamci_final)},
            // data: {data:gl_data,arr:dynamci_final},
            type: 'POST',
        success: function(data)
        {  
            //console.log(data);
            if(data['result'] === "success")
            {
                $('#aaa').html(data['msg']);   
            }else if(data['result'] === "error")
            {
                var msg = "following ids contain invalid data or invalid format </br>";
                $('#aaa').html(msg);
                
                for(var i=0 ;i<data['msg'].length;i++)
                {
                    $('#aaa').append(data['msg'][0][0]+ '<br>');
                    //$('#aaa').append(data['client_ids'][0]);
                }   
            }
            else
            {
                $('#aaa').html("Oops something went wrong");   
            }
          
           // console.log(data);
        },
        error:function (err)
        {
            $('#aaa').html("Oops something went wrong");   
            console.log(err);
        }
        });
}