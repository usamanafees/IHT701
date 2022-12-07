var gl_data=[[]];
var check_final_import = 0;
var dynamci_final_eupago=[];
var dynamic_options=[];
var upload_path;
$( '#up_clients_eupago' ).submit(function ( e ) {
    var formData = new FormData();
    formData.append( 'upload_file_eupago',  $( '#upload_file_eupago' )[0].files[0] );
    e.preventDefault();
    $.ajax({
        headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        url: APP_URL+'/upload_clients_eupago',
        data: formData,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(data)
        {
            var abc ='<table class="table" style="width: 100%">'
                +'<tr>'
                +'<th style="text-align:center">Id</th>'
                +'<th style="text-align:center">Company Name</th>'
                +'<th style="text-align:center">Vat No.</th>'
                +'<th style="text-align:center">Tax</th>'
                +'<th style="text-align:center">Email</th>'
                +'<th style="text-align:center">Address</th>'
                +'<th style="text-align:center">Location</th>'
                +'<th style="text-align:center">Zip code</th>'
                +'<th style="text-align:center">Country</th>'
                +'<th style="text-align:center">Economic Area</th>'
                +'<th style="text-aling:center">Document Type</th>'
                +'<th style="text-align:center">Product</th>'
                +'<th style="text-align:center">Value</th>'
                +'<th style="text-align:center">Date</th>'
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

            dynamci_final_eupago = data['columns'].slice(0);
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
                if(data['other_rows'][i][10] != 0)
                {
                    abc += '<td style="border:1px solid;">Fatura-Recibo</td>';
                    check_final_import = 0;
                }
                else
                {
                    abc += '<td style="border:1px solid;">Fatura</td>';
                    check_final_import = 0;
                }

                abc +='<td style="border:1px solid;">'+data['other_rows'][i][11]+'</td>'
                    +'<td style="border:1px solid;">'+data['other_rows'][i][12]+'</td>'
                    +'<td style="border:1px solid;">'+data['other_rows'][i][13]+'</td>'
                    +'</tr>';
            }
            abc+='<tbody></table>';
            $('#ddd').html(abc);
            if(check_final_import != 0)
            {
                $('#imp_eupago').html('<button  type="button"  class="btn btn-primary" disabled> Next </button>');
                $('#er_msg_eupago').html('<h5 class="text-danger">Invalid entries</h5>');
            }
            else
            {
                $('#imp_eupago').html('<button id="dynamic_next" onclick="dynamic_next()" type="button" class="btn btn-primary">Next</button>');
            }
            gl_data = data['other_rows'];
            if(data['path'] != 'ok')
            {
                upload_path = data['path'];
                data['path'] = "/"+data['path'];
            }
            else{
                $('#ddd').html('<h3>please upload the csv with less than 1000 rows</h3>');
            }
        },
        error:function (err)
        {
            $('#ddd').html("Oops something went wrong");
            console.log(err);
        }
    });
});
function dynamic_next()
{
    /*for(var i=0; i<dynamci_final_eupago.length;i++)
    {

        dynamic_options.push([dynamci_final_eupago[i],dynamci_final_eupago[i]]);
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
            sel0 ="";
        }else
        {
            sel0 ="";
        }
        a1+='<tr></select>'
            +'<td>'+gl_data[0][i]+'</td>';
        a1 +='<td>'
            +'<select id="jjj,'+i+'" '+sel0+' onchange="abc(this.id,this.value);">';
        for(var j=0;j<dynamic_options.length;j++)
        {
            //console.log(dynamic_options[j][0]);
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
                a1+='<option value="'+dynamic_options[j][0]+'" '+sel+'>'+dynamic_options[j][1]+'</option>';
                continue;
            }
            if(dynamic_options[j][0] === "uid")
            {
                a1+='<option value="'+dynamic_options[j][0]+'" >'+dynamic_options[j][1]+'</option>';
                continue;
            }
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
    a1+='<tbody></table>';*/

    var added_values=gl_data.length;
    $('#ddd').html('<h5 class="text-info">Will be added '+added_values+' records to the system! </h5>');
    $('#imp_eupago').html('<button id="import_clients_eupago" onclick="import_clients_eupago()" type="button" class="btn btn-primary">Import</button>');
}
function abc(id,val)
{
    var i;
    i = id.split(',')[1];
    dynamci_final_eupago[i]=val;
    if((new Set(dynamci_final_eupago)).size != dynamci_final_eupago.length)
    {
        $("#imp_eupago").prop('disabled', true);
        $('#er_msg_eupago').html('<h5 class="text-danger">Two or more records selected for one column</h5>');
        //console.log("disabled");
    }
    else
    {
        $("#imp_eupago").prop('disabled', false);
        $('#er_msg_eupago').html("");
        //console.log("enabled");
    }
}
function import_clients_eupago()
{
    $.ajax({
        headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        url: APP_URL+'/clients/store_csv_eupago',
        data: {arr:JSON.stringify(dynamci_final_eupago),path:upload_path},
        type: 'POST',
        success: function(data)
        {
            $("#imp_eupago").hide();
            if(data['result'] === "success")
            {
                $('#ddd').html(data['msg']);
            }else if(data['result'] === "error")
            {
                var msg = "following ids contain invalid data or invalid format </br>";
                $('#ddd').html(msg);

                for(var i=0 ;i<data['msg'].length;i++)
                {
                    $('#ddd').html('<h1>Summary</h1><br><h5 class="text-info">'+data['msg'][0][0]+'</h5><br>');
                }
            }
            else
            {
                $('#ddd').html("Oops something went wrong");
                console.log(err);

            }
        },
        error:function (err)
        {
            $('#ddd').html("Oops something went wrong");
            console.log(err);

        }
    });
}
