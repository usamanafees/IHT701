var gl_data_items=[[]];
var check_final_import = 0;
var dynamci_final_items=[];
var dynamic_options_items=[]; 
$( '#up_items' ).submit(function ( e ) {
    var formData = new FormData();
    formData.append( 'upload-file',  $( '#upload-items' )[0].files[0] ); 
         e.preventDefault();
        $.ajax({
            headers:
              {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
            url: APP_URL+'/upload_items',
            data: formData,
            contentType: false,
            processData: false,
            type: 'POST',
        success: function(data)
        {
            console.log(data['other_rows'],data['columns']);
          
                var abc ='<table class="table" style="width: 100%">'
                +'<tr>'
                +'<th style="text-align:center">Id</th>'
                +'<th style="text-align:center">Code</th>'       
                +'<th style="text-align:center">Unit</th>'
                +'<th style="text-align:center">Price</th>'
                +'<th style="text-align:center">Tax</th>'
                +'<th style="text-align:center">RRP</th>'
                +'<th style="text-align:center">Description</th>'
                +'<th style="text-align:center">UserId</th>'
                +'<th style="text-align:center">Status</th>'
                +'</tr>'
                +'</thead>'
                +'<tbody>';
                           //console.log(data['columns']);
                           //console.log(data);
                            dynamci_final_items = data['columns'].slice(0);
                            console.log( dynamci_final_items,data['other_rows']);
                     for(var i=0;i<data['other_rows'].length;i++)
                     {
                            abc+='<tr>'
                            +'<td style="border:1px solid;">'+data['other_rows'][i][0]+'</td>'
                            +'<td style="border:1px solid;">'+data['other_rows'][i][1]+'</td>'
                            +'<td style="border:1px solid;">'+data['other_rows'][i][2]+'</td>'
                            +'<td style="border:1px solid;">'+data['other_rows'][i][3]+'</td>'
                            +'<td style="border:1px solid;">'+data['other_rows'][i][4]+'</td>'
                            +'<td style="border:1px solid;">'+data['other_rows'][i][5]+'</td>'
                            +'<td style="border:1px solid;">'+data['other_rows'][i][6]+'</td>'
                            +'<td style="border:1px solid;">'+data['other_rows'][i][10]+'</td>'
                            if(data['other_rows'][i][11] != 0)
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
                        $('#imp').html('<button id="dynamic_next" onclick="dynamic_next_items()" type="button" class="btn btn-primary">Next</button>');
                    }
                    gl_data_items = data['other_rows'];
        },
        error:function (err)
        {
            console.log(err);
        }
        });
});
function dynamic_next_items()
{
    for(var i=0; i<dynamci_final_items.length;i++)
    {
        
       dynamic_options_items.push([dynamci_final_items[i],dynamci_final_items[i]]);
    }
    var a1= '<table class="table" style="width: 100%">'
                +'<tr>'
                +'<th style="text-align:center">Data</th>'
                +'<th style="text-align:center">Columns</th>'
                +'</tr>'
                +'</thead>'
                +'<tbody>';
    for(var i =0 ;i<gl_data_items[0].length-1;i++)
    {
        if(i != 7)
        {
            if(i != 8)
            {
                if(i !=9)
                {
        a1+='<tr></select>'
        +'<td>'+gl_data_items[0][i]+'</td>';
        a1 +='<td>'
        +'<select id="jjj,'+i+'" onchange="item_col_change(this.id,this.value);">';
         for(var j=0;j<dynamic_options_items.length;j++)
        {
            console.log(dynamic_options_items[j][0]);
                if(dynamic_options_items[j][0] === "created_at")
                {
                    a1+='<option value="'+dynamic_options_items[j][0]+'" disabled>'+dynamic_options_items[j][1]+'</option>';
                    continue;
                }
                if(dynamic_options_items[j][0] === "updated_at")
                {
                    a1+='<option value="'+dynamic_options_items[j][0]+'" disabled>'+dynamic_options_items[j][1]+'</option>';
                    continue;
                }
                if(dynamic_options_items[j][0] === "deleted_at")
                {
                    a1+='<option value="'+dynamic_options_items[j][0]+'" disabled>'+dynamic_options_items[j][1]+'</option>';
                    continue;
                }
            if(j==i)
            {
                a1+='<option value="'+dynamic_options_items[j][0]+'" selected>'+dynamic_options_items[j][1]+'</option>';
            }else{
                a1+='<option value="'+dynamic_options_items[j][0]+'" >'+dynamic_options_items[j][1]+'</option>';
            }
        }
        a1 +='</td></tr>'
        }
        }
    }
    }
    a1+='<tbody></table>';
    $('#aaa').html(a1);
    $('#imp').html('<button id="import_items" onclick="import_items()" type="button" class="btn btn-primary">Import</button>');
    //$('#aaa').html(abc);
}
function item_col_change(id,val)
{
    var i;
    i = id.split(',')[1];
    dynamci_final_items[i]=val;
    console.log(dynamci_final_items);
   if((new Set(dynamci_final_items)).size != dynamci_final_items.length)
    {
        $("#import_items").prop('disabled', true);
        $('#er_msg').html('<h5 class="text-danger">Two or more records selected for one column</h5>');
    }
    else
    {
    $("#import_items").prop('disabled', false);
    $('#er_msg').html("");  
     }
}

function import_items()
{
    console.log(gl_data_items);

    $.ajax({
        
        headers:
              {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
            url: APP_URL+'/items/store_csv_items',
            data: {data: JSON.stringify(gl_data_items),arr:JSON.stringify(dynamci_final_items)},
            // data: {data:gl_data,arr:dynamci_final},
            type: 'POST',
        success: function(data)
        {  
            $('#aaa').html(data);
            console.log(data);
        },
        error:function (err)
        {
            console.log(err);
        }
        });
}