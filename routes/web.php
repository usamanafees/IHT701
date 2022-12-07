<?php
// URL::forceScheme('https');


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/








Route::any('common/setlanguage','CommonController@setlanguage')->name('language.switch');

Route::group(['middleware' => ['auth','Language','EmailVerify']], function(){

            Route::any('event',function(){
                return view('Hr.add_messages');
            });
            Route::get('/','DashboardController@index')->name('/');
            Route::post('/choose_module','DashboardController@choose_module')->name('choose_module');
            Route::get('/change_module','DashboardController@change_module')->name('change_module');

	        Route::group(['middleware' => 'Generic_middleware:Invoicing'], function(){
			Route::get('/AdminDashboard','DashboardController@AdminDashboard')->name('AdminDashboard');
			Route::any('/upload_clients', 'Import_wizardController@upload_clients')->name('import_wizard.upload_clients');
			Route::any('/export_clients', 'Import_wizardController@export_clients')->name('import_wizard.export_clients');
			Route::any('/upload_items', 'Import_wizardController@upload_items')->name('import_wizard.upload_items');
			Route::any('/items/store_csv_items', 'Import_wizardController@store_csv_')->name('items.store_csv');
			Route::any('/upload_clients_eupago', 'Import_wizardController@upload_clients_eupago')->name('import_wizard.upload_clients_eupago');
            Route::any('/sample/excel', 'Import_wizardController@sample_excel')->name('import_wizard.sample_excel');
            
			Route::group(['prefix' => 'fee'], function(){
				Route::any('/', 'InvoicesController@showFees')->name('showFees');
				Route::any('/add/{id}', 'InvoicesController@fee_add')->name('fee.add');
				Route::any('/store_fee', 'InvoicesController@store_fee')->name('fee.store');
				//Route::any('add', 'ClientsController@create')->name('clients.add');
			   });

			Route::group(['prefix' => 'clients'], function(){
				Route::any('/', 'ClientsController@index')->name('clients');
				Route::any('add', 'ClientsController@create')->name('clients.add');
				Route::any('store', 'ClientsController@store')->name('clients.store');
				Route::any('store_csv', 'ClientsController@store_csv')->name('clients.store_csv');
                Route::any('store_csv_eupago', 'ClientsController@store_csv_eupago')->name('clients.store_csv_eupago');
				Route::any('edit/{id}', 'ClientsController@edit')->name('clients.edit');
				Route::any('update/{id}', 'ClientsController@update')->name('clients.update');
				Route::any('destroy', 'ClientsController@destroy')->name('clients.destroy');



			   });
			   Route::group(['prefix' => 'items'], function(){
				Route::any('/', 'ItemsController@index')->name('items');
				Route::any('add', 'ItemsController@create')->name('items.add');
				Route::any('store', 'ItemsController@store')->name('items.store');
				Route::any('edit/{id}', 'ItemsController@edit')->name('items.edit');
				Route::any('update/{id}', 'ItemsController@update')->name('items.update');
				Route::any('destroy', 'ItemsController@destroy')->name('items.destroy');
			   });
			   Route::group(['prefix' => 'invoices'], function(){
                Route::get('/home','InvoicesController@home')->name('invoices.home');
				Route::any('/', 'InvoicesController@index')->name('invoices');
				Route::any('add', 'InvoicesController@create')->name('invoices.add');
				Route::any('store', 'InvoicesController@store')->name('invoices.store');
				Route::any('edit/{id}', 'InvoicesController@edit')->name('invoices.edit');
				Route::any('update/{id}', 'InvoicesController@update')->name('invoices.update');
				Route::any('destroy', 'InvoicesController@destroy')->name('invoices.destroy');
				Route::any('credit_note', 'InvoicesController@credit_note')->name('credit_note');
				Route::any('delete_credit_note', 'InvoicesController@delete_credit_note')->name('delete_credit_note');
				Route::any('edit_credit_note/{id}', 'InvoicesController@edit_credit_note')->name('edit_credit_note');

				Route::any('add_credit_note', 'InvoicesController@add_credit_note')->name('add_credit_note');
				Route::any('store_credit_note', 'InvoicesController@store_credit_note')->name('store_credit_note');
                Route::any('update_credit_note', 'InvoicesController@update_credit_note')->name('update_credit_note');

				Route::any('invoice_paid/{id}','InvoicesController@invoices_paid')->name('invoices.paid');
				Route::any('cancel','InvoicesController@invoices_cancel')->name('invoices.cancel');
                Route::any('register_payment/{id}','InvoicesController@register_payment')->name('invoices.register_payment');

				Route::any('add_credit_note', 'InvoicesController@add_credit_note')->name('add_credit_note');
				Route::any('store_credit_note', 'InvoicesController@store_credit_note')->name('store_credit_note');

				Route::any('credit_note_line_items', 'InvoicesController@credit_note_line_items')->name('credit_note_line_items');
				
				Route::any('createNewInvoiceAJAX', 'InvoicesController@createNewInvoiceAJAX')->name('invoices.createNewInvoiceAJAX');
				Route::any('template/GetInvoice', 'InvoicesController@GetInvoice')->name('Get.Invoice');
				Route::any('invoice_receipt', 'InvoicesController@index_receipt')->name('invoice_receipt');
                Route::any('invoice_simplified', 'InvoicesController@index_simplified')->name('invoice_simplified');


				
			   });
	
			   Route::any('client_list','ClientsController@client_list')->name('client_list');
			   Route::any('client_live_Search','ClientsController@client_live_Search')->name('client.live.search');
			   Route::any('get_client_fee_list','ClientsController@get_client_fee_list')->name('get_client_fee_list');
  
			   
			   Route::any('item_list','ItemsController@item_list')->name('item_list');
			   Route::any('item_live_Search','ItemsController@item_live_Search')->name('items.live.search');
		   
			   Route::any('print_invoice','InvoicesController@print_invoice')->name('print.invoice');
			   Route::any('download_invoice/{id}','InvoicesController@download_invoice')->name('download.invoice');
		   
			//    Route::any('download_invoice_pdf/{id}','InvoicesController@download_invoice_pdf')->name('download.invoice.pdf');
			   Route::any('download_invoice_pdf/{id}/{digital}','InvoicesController@download_invoice_pdf')->name('download.invoice.pdf');
		   
			   
		   
					Route::group(['prefix' => 'brands'], function(){
					Route::any('/', 'BrandsController@index')->name('brands');
					Route::any('add', 'BrandsController@create')->name('brands.add');
					Route::any('store', 'BrandsController@store')->name('brands.store');
					Route::any('store_with_template', 'BrandsController@store_with_template')->name('brands.store_with_template');
					Route::any('edit/{id}', 'BrandsController@edit')->name('brands.edit');
					Route::any('update', 'BrandsController@update')->name('brands.update');
					Route::any('destroy/{id}', 'BrandsController@destroy')->name('brands.destroy');
				   });
			   
               Route::any('default_brand', 'BrandsController@default_brand')->name('brands.default_brand');
               Route::any('default_brand_template', 'BrandsController@default_brand_template')->name('brands.default_brand_template');
               Route::any('brands_show_templates', 'BrandsController@brands_show_templates')->name('brands.show.templates');
			   Route::any('brands_templates_get', 'BrandsController@brands_templates_get')->name('brands.templates.get');
			   Route::any('store_template_with_brand', 'BrandsController@store_template_with_brand')->name('brands.store_template_with_brand');
			   Route::any('remove_template', 'BrandsController@remove_template')->name('remove_template');
			   Route::any('edit_template', 'BrandsController@edit_template')->name('edit_template');
			   Route::any('brands_template_update', 'BrandsController@brands_template_update')->name('brands.template.update');
			   Route::any('brands_template_selected', 'BrandsController@brands_template_selected')->name('brands.template.selected');
			   Route::any('preview_template', 'BrandsController@preview_template')->name('preview_template');
		   
			   Route::any('preview_template_invoice', 'InvoicesController@preview_template_invoice')->name('preview_template_invoice');
		   
		   
			   Route::any('store_with_template_previous_selected', 'BrandsController@store_with_template_previous_selected')->name('store_with_template_previous_selected');
			   Route::any('store_template_with_brand_previous_selected', 'BrandsController@store_template_with_brand_previous_selected')->name('store_template_with_brand_previous_selected');
		   
			   Route::any('brand_template_module_list', 'BrandsController@brand_template_module_list')->name('brand.template.module_list');
		});

		Route::group(['middleware' => 'Generic_middleware:SMS'], function(){
			Route::get('/ContributerDashboard','DashboardController@ContributerDashboard')->name('contributerDashboard');

			Route::group(['prefix' => 'sms'], function(){
                Route::get('/home','SMSController@home')->name('sms.home');
				Route::any('submit', 'SMSController@submit')->name('sms.submit');
				Route::any('ez4u/{sms_id}', 'SMSController@ez4u_estado_sms')->name('sms.ez4u');
				Route::any('store', 'SMSController@store')->name('sms.store');
				Route::any('list', 'SMSController@list')->name('sms.list');
				 Route::any('listAll', 'SMSController@listAll')->name('sms.listAll');
				Route::any('apiLogs', 'SMSController@apiLogs')->name('sms.apiLogs');
				Route::any('apiLogsajax', 'SMSController@apiLogsajax')->name('sms.apiLogsajax');
				Route::any('listAllajax', 'SMSController@listAllajax')->name('sms.listAllajax');
				Route::any('listajax', 'SMSController@listajax')->name('sms.listajax');
				Route::any('getModel', 'SMSController@getModel')->name('sms.getModel');
				Route::any('getApiLogs', 'SMSController@getApiLogs')->name('sms.getApiLogs');
				Route::any('searchlist', 'SMSController@searchList')->name('sms.searchlist');
				Route::any('searchlistall', 'SMSController@searchListAll')->name('sms.searchlistall');
				Route::any('get_rate/{country_code}', 'SMSController@get_rate')->name('sms.get_rate');
	  
				//SMS Sender
				Route::group(['prefix' => 'sender'], function(){
				Route::any('/', 'SMS_SenderController@index')->name('sender');
				Route::any('add', 'SMS_SenderController@create')->name('sender.add');
				Route::any('store', 'SMS_SenderController@store')->name('sender.store');
				Route::any('edit/{id}', 'SMS_SenderController@edit')->name('sender.edit');
				Route::any('update/{id}', 'SMS_SenderController@update')->name('sender.update');
				Route::any('approve/{id}', 'SMS_SenderController@approve')->name('sender.approve');
				Route::any('disapprove/{id}', 'SMS_SenderController@disapprove')->name('sender.disapprove');
			   });
			   
			   // Route::any('sender_list_ajax', 'SMS_SenderController@sender_list_ajax')->name('sender.list.ajax');
	  
	  
				//SMS Templates
				Route::group(['prefix' => 'template'], function(){
				Route::any('/', 'SMS_TemplateController@index')->name('template');
				Route::any('add', 'SMS_TemplateController@create')->name('template.add');
				Route::any('store', 'SMS_TemplateController@store')->name('template.store');
				Route::any('edit/{id}', 'SMS_TemplateController@edit')->name('template.edit');
				Route::any('update/{id}', 'SMS_TemplateController@update')->name('template.update');
			   });
	  
	  
			  });
		});




		Route::group(['middleware' => 'Generic_middleware:Configuration'], function(){
		Route::any('Accounts/Edit/{id}','AccountSettingsController@company_info')->name('company.info');
	 Route::any('accounts/details','AccountSettingsController@account_balance')->name('account.balance');
	 Route::any('accounts/{id}/billing_data','AccountSettingsController@Billing_data')->name('billing.data');
	 Route::any('accounts/Billing_store','AccountSettingsController@Billing_store')->name('billing.store');
	 Route::get('accounts/manage-plans','AccountSettingsController@manage_plan')->name('account.manage_plan');


	 Route::get('order/new/{id}','AccountSettingsController@payment_plan')->name('payment.plan');
	 Route::get('paypal_order/{id}','AccountSettingsController@paypal_order')->name('paypal_order');
											

	 Route::any('process_paypal','AccountSettingsController@process_paypal')->name('process.paypal'); 
 	 Route::any('process_paypal_cancel','AccountSettingsController@process_paypal_cancel')->name('process.paypal.cancel'); 
	
     Route::any('contact_client_usr', 'ClientsController@contact_client_usr')->name('clients.contact_client_usr');
     Route::any('contact_client_usr_post', 'ClientsController@contact_client_usr_post')->name('clients.contact_client_usr_post');

		});
	    //   Route::group(['prefix' => 'clients'], function(){
	    //   Route::any('/', 'ClientsController@index')->name('clients');
	    //   Route::any('add', 'ClientsController@create')->name('clients.add');
	    //   Route::any('store', 'ClientsController@store')->name('clients.store');
	    //   Route::any('edit/{id}', 'ClientsController@edit')->name('clients.edit');
	    //   Route::any('update/{id}', 'ClientsController@update')->name('clients.update');
	    //   Route::any('destroy/{id}', 'ClientsController@destroy')->name('clients.destroy');
	    //  });

	    //   Route::group(['prefix' => 'items'], function(){
	    //   Route::any('/', 'ItemsController@index')->name('items');
	    //   Route::any('add', 'ItemsController@create')->name('items.add');
	    //   Route::any('store', 'ItemsController@store')->name('items.store');
	    //   Route::any('edit/{id}', 'ItemsController@edit')->name('items.edit');
	    //   Route::any('update/{id}', 'ItemsController@update')->name('items.update');
	    //   Route::any('destroy/{id}', 'ItemsController@destroy')->name('items.destroy');
		//  });
        Route::group(['middleware' => 'Generic_middleware:Human Resource'], function(){
            Route::group(['middleware' => 'Hr_middleware'], function(){
                Route::group(['prefix' => 'human_resource'], function(){
                    Route::any('/', 'HRController@index')->name('hr.dashboard');
                    Route::any('add_employee', 'HRController@create_employee')->name('hr.create_employee');
                    Route::any('store_employee', 'HRController@store_employee')->name('hr.store_employee');
                    Route::any('edit_employee', 'HRController@edit_employee')->name('hr.edit_employee');
                    Route::any('delete_employee', 'HRController@delete_employee')->name('hr.delete_employee');
                    Route::any('set_region', 'HRController@set_region')->name('hr.set_region');
                    Route::any('manager_emp/{id}', 'HRController@manager_emp')->name('hr.manager_emp');
                    Route::any('create_team', 'HRController@create_team')->name('hr.create_team');
                    Route::any('store_team', 'HRController@store_team')->name('hr.store_team');
                    Route::any('all-teams', 'HRController@all_teams')->name('hr.all_teams');
                    Route::any('edit-team/{id}', 'HRController@edit_team')->name('hr.edit_team');
                    Route::any('store-edit-team', 'HRController@store_edit_team')->name('hr.store_edit_team');
                    Route::any('store-request-days-off', 'HRController@store_request_days_off')->name('hr.store_request_days_off');
                    Route::any('store_dayoff_attachments', 'HRController@store_dayoff_attachments')->name('hr.store_dayoff_attachments');
                    Route::any('delete_dayoff_attachments', 'HRController@delete_dayoff_attachments')->name('hr.delete_dayoff_attachments');
                    Route::any('all-requests', 'HRController@all_requests')->name('hr.all_requests');
                    Route::any('approve-request', 'HRController@approve_request')->name('hr.approve_request');
                    Route::any('request-status', 'HRController@request_status')->name('hr.request_status');
                    Route::any('delete-team', 'HRController@delete_team')->name('hr.delete_team');
                    // manager
                   

                    Route::any('days-off/add', 'HRController@add_days_off')->name('hr.manager.add_days_off');
                    Route::any('calender-days-off', 'HRController@calender_days_off')->name('hr.calender_days_off');
                    Route::any('monthly-days-off', 'HRController@monthly_days_off')->name('hr.monthly_days_off');
                    Route::any('calender-event-action', 'HRController@calender_event_action')->name('hr.calender_event_action');
                    Route::any('add-monthly-daysoff/{token}', 'HRController@add_monthly_daysoff')->name('hr.add_monthly_daysoff');
                    Route::any('monthly-days-off-store', 'HRController@monthly_days_off_store')->name('hr.monthly_days_off_store');
                    Route::any('employee-month-days-off/{id}', 'HRController@employee_month_days_off')->name('hr.employee_month_days_off');
                    Route::any('approve-employye-month-days-off', 'HRController@approve_employye_month_days_off')->name('hr.approve_employye_month_days_off');
                    Route::any('days-off/add', 'HRController@add_days_off')->name('hr.manager.add_days_off');

                    Route::any('days-off/add', 'HrController@add_days_off')->name('hr.manager.add_days_off');
                    Route::any('calender-days-off', 'HrController@calender_days_off')->name('hr.calender_days_off');
                    Route::any('monthly-days-off', 'HrController@monthly_days_off')->name('hr.monthly_days_off');
                    Route::any('calender-event-action', 'HrController@calender_event_action')->name('hr.calender_event_action');
                    Route::any('add-monthly-daysoff/{token}', 'HrController@add_monthly_daysoff')->name('hr.add_monthly_daysoff');
                    Route::any('monthly-days-off-store', 'HrController@monthly_days_off_store')->name('hr.monthly_days_off_store');
                    Route::any('employee-month-days-off/{id}', 'HrController@employee_month_days_off')->name('hr.employee_month_days_off');
                    Route::any('approve-employye-month-days-off', 'HrController@approve_employye_month_days_off')->name('hr.approve_employye_month_days_off');
                    Route::any('days-off/add', 'HrController@add_days_off')->name('hr.manager.add_days_off');
		    Route::any('broadcast-message', 'HRController@broadcast_message')->name('hr.broadcast_message');
                });

            });
        });
    
    Route::group(['middleware' => 'Generic_middleware:Admin'], function () {
        Route::group(['prefix' => 'users'], function () {
            Route::any('/', 'UsersController@index')->name('users');
            Route::any('add', 'UsersController@create')->name('users.add');
            Route::any('store', 'UsersController@store')->name('users.store');
            Route::any('edit/{id}', 'UsersController@edit')->name('users.edit');
            Route::any('update/{id}', 'UsersController@update')->name('users.update');
            Route::any('destroy/{id}', 'UsersController@destroy')->name('users.destroy');
            Route::any('user_based_login/{id}', 'UsersController@user_based_login')->name('users.user_based_login');
            Route::any('user_field_search', 'UsersController@user_field_search')->name('users.field_search');
        });
        Route::any('contact_client_via_email', 'AccountSettingsController@contact_client_via_email')->name('contact_client_via_email');
        Route::any('contact_client_via_email_s', 'AccountSettingsController@contact_client_via_email_s')->name('contact_client_via_email_s');
    });
    Route::any('contact_client_via_email', 'AccountSettingsController@contact_client_via_email')->name('contact_client_via_email');
    Route::any('contact_client_via_email_s', 'AccountSettingsController@contact_client_via_email_s')->name('contact_client_via_email_s');

    //     Route::group(['prefix' => 'invoices'], function(){
    // 	Route::any('/', 'InvoicesController@index')->name('invoices');
    // 	Route::any('add', 'InvoicesController@create')->name('invoices.add');
    // 	Route::any('store', 'InvoicesController@store')->name('invoices.store');
    // 	Route::any('edit/{id}', 'InvoicesController@edit')->name('invoices.edit');
    // 	Route::any('update/{id}', 'InvoicesController@update')->name('invoices.update');
    // 	Route::any('destroy/{id}', 'InvoicesController@destroy')->name('invoices.destroy');
    // 	Route::any('createNewInvoiceAJAX', 'InvoicesController@createNewInvoiceAJAX')->name('invoices.createNewInvoiceAJAX');
    // 	Route::any('template/GetInvoice', 'InvoicesController@GetInvoice')->name('Get.Invoice');
    //    });

    Route::group(['prefix' => 'sms_rates'], function () {
        Route::any('/', 'SMSRateController@index')->name('smsrates');
        Route::any('add', 'SMSRateController@create')->name('smsrates.add');
        Route::any('store', 'SMSRateController@store')->name('smsrates.store');
        Route::any('price/{country_id}/{provider_id}', 'SMSRateController@sms_price')->name('smsrates.price');
        Route::any('edit/{id}', 'SMSRateController@edit')->name('smsrates.edit');
        Route::any('update/{id}', 'SMSRateController@update')->name('smsrates.update');
        Route::any('destroy/{id}', 'SMSRateController@destroy')->name('smsrates.destroy');
    });



    // Route::any('client_list','ClientsController@client_list')->name('client_list');
    // Route::any('client_live_Search','ClientsController@client_live_Search')->name('client.live.search');

    // Route::any('item_list','ItemsController@item_list')->name('item_list');
    // Route::any('item_live_Search','ItemsController@item_live_Search')->name('items.live.search');

    // Route::any('print_invoice','InvoicesController@print_invoice')->name('print.invoice');
    // Route::any('download_invoice/{id}','InvoicesController@download_invoice')->name('download.invoice');

    // Route::any('download_invoice_pdf/{id}','InvoicesController@download_invoice_pdf')->name('download.invoice.pdf');



    //      Route::group(['prefix' => 'brands'], function(){
    //      Route::any('/', 'BrandsController@index')->name('brands');
    //      Route::any('add', 'BrandsController@create')->name('brands.add');
    //      Route::any('store', 'BrandsController@store')->name('brands.store');
    //      Route::any('store_with_template', 'BrandsController@store_with_template')->name('brands.store_with_template');
    //      Route::any('edit/{id}', 'BrandsController@edit')->name('brands.edit');
    //      Route::any('update', 'BrandsController@update')->name('brands.update');
    //      Route::any('destroy/{id}', 'BrandsController@destroy')->name('brands.destroy');
    //     });

    // Route::any('brands_show_templates', 'BrandsController@brands_show_templates')->name('brands.show.templates');
    // Route::any('brands_templates_get', 'BrandsController@brands_templates_get')->name('brands.templates.get');
    // Route::any('store_template_with_brand', 'BrandsController@store_template_with_brand')->name('brands.store_template_with_brand');
    // Route::any('remove_template', 'BrandsController@remove_template')->name('remove_template');
    // Route::any('edit_template', 'BrandsController@edit_template')->name('edit_template');
    // Route::any('brands_template_update', 'BrandsController@brands_template_update')->name('brands.template.update');
    // Route::any('brands_template_selected', 'BrandsController@brands_template_selected')->name('brands.template.selected');
    // Route::any('preview_template', 'BrandsController@preview_template')->name('preview_template');

    // Route::any('preview_template_invoice', 'InvoicesController@preview_template_invoice')->name('preview_template_invoice');


    // Route::any('store_with_template_previous_selected', 'BrandsController@store_with_template_previous_selected')->name('store_with_template_previous_selected');
    // Route::any('store_template_with_brand_previous_selected', 'BrandsController@store_template_with_brand_previous_selected')->name('store_template_with_brand_previous_selected');

    // Route::any('brand_template_module_list', 'BrandsController@brand_template_module_list')->name('brand.template.module_list');


    //Roles controller
    Route::resource('roles', 'RoleController');
    //Permissions controller
    Route::resource('permissions', 'PermissionController');
    //Route::resource('permissions/create', 'PermissionController@create');

    // Route::any('Accounts/Edit/{id}','AccountSettingsController@company_info')->name('company.info');
    // Route::any('accounts/details','AccountSettingsController@account_balance')->name('account.balance');
    // Route::any('accounts/{id}/billing_data','AccountSettingsController@Billing_data')->name('billing.data');
    // Route::any('accounts/Billing_store','AccountSettingsController@Billing_store')->name('billing.store');
    // Route::get('accounts/manage-plans','AccountSettingsController@manage_plan')->name('account.manage_plan');

    // Route::get('order/new/{id}','AccountSettingsController@payment_plan')->name('payment.plan');
    // Route::get('paypal_order/{id}','AccountSettingsController@paypal_order')->name('paypal_order');


    // Route::any('process_paypal','AccountSettingsController@process_paypal')->name('process.paypal');
    // Route::any('process_paypal_cancel','AccountSettingsController@process_paypal_cancel')->name('process.paypal.cancel');

    Route::group(['prefix' => 'balance-movements'], function () {
        Route::any('/', 'AccountSettingsController@balanceMovements')->name('balance-movements');
        Route::any('/save', 'AccountSettingsController@savebalanceMovements')->name('balance-movements.save');
        Route::any('/list', 'AccountSettingsController@listbalanceMovements')->name('balance-movements.list');
        Route::any('/listbalanceMovementsAjax', 'AccountSettingsController@listbalanceMovementsAjax')->name('balance-movements.listbalanceMovementsAjax');
    });



    //Modules Section
    Route::group(['prefix' => 'modules'], function () {
        Route::any('/', 'ModulesController@index')->name('modules');
        Route::any('add', 'ModulesController@create')->name('modules.add');
        Route::any('store', 'ModulesController@store')->name('modules.store');
        Route::any('edit/{id}', 'ModulesController@edit')->name('modules.edit');
        Route::any('update/{id}', 'ModulesController@update')->name('modules.update');
        // Route::any('destroy/{id}', 'ModulesController@destroy')->name('modules.destroy');
    });

    Route::group(['prefix' => 'sms'], function () {
        Route::any('submit', 'SMSController@submit')->name('sms.submit');
        Route::any('ez4u/{sms_id}', 'SMSController@ez4u_estado_sms')->name('sms.ez4u');
        Route::any('store', 'SMSController@store')->name('sms.store');
        Route::any('list', 'SMSController@list')->name('sms.list');
        Route::any('listAll', 'SMSController@listAll')->name('sms.listAll');
        Route::any('apiLogs', 'SMSController@apiLogs')->name('sms.apiLogs');
        Route::any('apiLogsajax', 'SMSController@apiLogsajax')->name('sms.apiLogsajax');
        Route::any('listAllajax', 'SMSController@listAllajax')->name('sms.listAllajax');
        Route::any('listajax', 'SMSController@listajax')->name('sms.listajax');
        Route::any('getModel', 'SMSController@getModel')->name('sms.getModel');
        Route::any('getApiLogs', 'SMSController@getApiLogs')->name('sms.getApiLogs');
        Route::any('searchlist', 'SMSController@searchList')->name('sms.searchlist');
        Route::any('searchlistall', 'SMSController@searchListAll')->name('sms.searchlistall');
        Route::any('get_rate/{country_code}', 'SMSController@get_rate')->name('sms.get_rate');


        Route::any('payments', 'SMSController@payments')->name('sms.payments');
        Route::any('addPayments', 'SMSController@addPayments')->name('sms.addPayments');

        //SMS Sender
        Route::group(['prefix' => 'sender'], function () {
            Route::any('/', 'SMS_SenderController@index')->name('sender');
            Route::any('add', 'SMS_SenderController@create')->name('sender.add');
            Route::any('store', 'SMS_SenderController@store')->name('sender.store');
            Route::any('update_sender', 'SMS_SenderController@update_sender')->name('sender.update_sender'); // new one
            Route::any('edit/{id}', 'SMS_SenderController@edit')->name('sender.edit');
            Route::any('update/{id}', 'SMS_SenderController@update')->name('sender.update');
            Route::any('approve/{id}', 'SMS_SenderController@approve')->name('sender.approve');
            Route::any('disapprove/{id}', 'SMS_SenderController@disapprove')->name('sender.disapprove');
        });
        // Route::group(['prefix' => 'sms'], function(){
        //   Route::any('submit', 'SMSController@submit')->name('sms.submit');
        //   Route::any('ez4u/{sms_id}', 'SMSController@ez4u_estado_sms')->name('sms.ez4u');
        //   Route::any('store', 'SMSController@store')->name('sms.store');
        //   Route::any('list', 'SMSController@list')->name('sms.list');
        //   Route::any('listAll', 'SMSController@listAll')->name('sms.listAll');
        //   Route::any('apiLogs', 'SMSController@apiLogs')->name('sms.apiLogs');
        //   Route::any('apiLogsajax', 'SMSController@apiLogsajax')->name('sms.apiLogsajax');
        //   Route::any('listAllajax', 'SMSController@listAllajax')->name('sms.listAllajax');
        //   Route::any('listajax', 'SMSController@listajax')->name('sms.listajax');
        //   Route::any('getModel', 'SMSController@getModel')->name('sms.getModel');
        //   Route::any('getApiLogs', 'SMSController@getApiLogs')->name('sms.getApiLogs');
        //   Route::any('searchlist', 'SMSController@searchList')->name('sms.searchlist');
        //   Route::any('searchlistall', 'SMSController@searchListAll')->name('sms.searchlistall');
        //   Route::any('get_rate/{country_code}', 'SMSController@get_rate')->name('sms.get_rate');

        //   //SMS Sender
        //   Route::group(['prefix' => 'sender'], function(){
        //   Route::any('/', 'SMS_SenderController@index')->name('sender');
        //   Route::any('add', 'SMS_SenderController@create')->name('sender.add');
        //   Route::any('store', 'SMS_SenderController@store')->name('sender.store');
        //   Route::any('edit/{id}', 'SMS_SenderController@edit')->name('sender.edit');
        //   Route::any('update/{id}', 'SMS_SenderController@update')->name('sender.update');
        //   Route::any('approve/{id}', 'SMS_SenderController@approve')->name('sender.approve');
        //   Route::any('disapprove/{id}', 'SMS_SenderController@disapprove')->name('sender.disapprove');
        //  });


        //  // Route::any('sender_list_ajax', 'SMS_SenderController@sender_list_ajax')->name('sender.list.ajax');


        //   //SMS Templates
        //   Route::group(['prefix' => 'template'], function(){
        //   Route::any('/', 'SMS_TemplateController@index')->name('template');
        //   Route::any('add', 'SMS_TemplateController@create')->name('template.add');
        //   Route::any('store', 'SMS_TemplateController@store')->name('template.store');
        //   Route::any('edit/{id}', 'SMS_TemplateController@edit')->name('template.edit');
        //   Route::any('update/{id}', 'SMS_TemplateController@update')->name('template.update');
        //  });
        // });

        Route::get('SmsProvider', 'SMSProviderController@SmsProvider')->name('SmsProvider');
        Route::post('Sms/provider/store', 'SMSProviderController@SmsProviderStore')->name('sms.provider.store');
    });

    Route::any('/digital_signature', 'AccountSettingsController@add_digi_signature')->name('digital_signature');
    Route::any('/delete_digital_signature/{id}', 'AccountSettingsController@delete_digi_signature')->name('delete_digital_signature');

    Route::any('/reports/report_sms/sent', 'ReportController@reportSmsSent')->name('report.sms.sent');
    Route::any('/reports/report_invoice/BillingByItem', 'ReportController@reportBillingByItem')->name('report.invoice.BillingByItem');
    Route::any('/reports/report_invoice/InvoicesPerBrand', 'ReportController@InvoicesPerBrand')->name('report.invoice.InvoicesPerBrand');

    Route::any('/reports/report_sms', 'ReportController@reportSms')->name('report.sms.index');
    Route::any('/reports/report_invoice', 'ReportController@reportInvoice')->name('report.invoice.index');
    Route::any('/faq', 'FaqController@Faq')->name('faq.index');

    Route::any('billing-alerts', 'CommonController@billingalerts')->name('billing-alerts');
    Route::any('billing-alerts/add', 'CommonController@add_billing_alerts')->name('billing-alerts.add');
    Route::any('billing-alerts/delete', 'CommonController@del_billing_alerts')->name('billing-alerts.delete');
    Route::any('billing-alerts/edit/{id}', 'CommonController@edit_billing_alerts')->name('billing-alerts.edit');
    Route::any('billing-alerts/store-edit', 'CommonController@store_edit_billing_alerts')->name('billing-alerts.store-edit');


    Route::any('billing-alerts/send-before', 'CommonController@billingalertsbefore')->name('billing-alerts.before');
    Route::any('billing-alerts/send-after', 'CommonController@billingalertsafter')->name('billing-alerts.after');


    Route::any('balance-movements/listSimpleUser', 'AccountSettingsController@listbalanceMovementsUser')->name('balance-movements.list.simpleUser');
    Route::any('balance-movements/listbalanceMovementsAjaxSimpleUser', 'AccountSettingsController@listbalanceMovementsAjaxSimpleUser')->name('balance-movements.listbalanceMovementsAjax.simpleuser');

    Route::any('tax-authority/saf-t/download', 'CommonController@saftdownload')->name('tax-authority.saf-t-download');
    Route::any('tax-authority/saf-t', 'CommonController@saft')->name('tax-authority.saf-t');

    Route::any('accounts/user_details', 'AccountSettingsController@user_account_settings')->name('account.user_details');
    Route::any('/changePassword', 'AccountSettingsController@changePassword')->name('changePassword');
    Route::any('tax-authority/saf-t/scheduling', 'CommonController@saft_scheduling')->name('tax-authority.saft-schedule');
});


//Ajax Calls
Route::post('checkEmail', 'CustomRegisterControler@checkEmail');
Route::post('verifyEmail', 'CustomRegisterControler@verifyEmail');
Route::get('search/{val}', 'HomeController@searchajax')->name("admin.search");

Route::get('user_based_login_home', 'HomeController@user_based_login')->name('home.user_based_login_home');
Route::get('template_text/{val}', 'SMSController@template_text')->name('sms.template_text');

//


Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
Route::post('/New/register/', 'CustomRegisterControler@store')->name('custom_register.register');
Route::any('/Account/setup/{id}', 'CustomRegisterControler@account_Setup')->name('setup.account');
// Route::any('/Account/setup/{id}','CustomRegisterControler@account_Setup')->name('setup.account');

Route::any('/users/developer', 'HomeController@developer')->name('users.developer');

Route::any('/Account/setup/complete/{id}', 'CustomRegisterControler@account_Setup_done')->name('custom_register.update');

Route::any('/Account/setup/email_verification/{id}', 'CustomRegisterControler@email_verification')->name('custom_register.email_verification');

Route::any('/email_confirmation/{token}', 'CustomRegisterControler@email_confirmation')->name('custom_register.email_confirmation');

Route::any('/hr_module_confirmation/{token}', 'CustomRegisterControler@hr_module_confirmation')->name('hr_module_confirmation');

Route::any('/resend_email', 'CustomRegisterControler@resend_email')->name('resend_email');
Route::post('/resend_email_submit', 'CustomRegisterControler@resend_email_submit')->name('resend_email_submit');

//Recover Password
Route::any('forgotpassword', 'CustomRegisterControler@forgotPassword')->name('forgotpassword');
Route::any('varify', 'CustomRegisterControler@varify')->name('varify');
Route::any('/recover_password/{token}', 'CustomRegisterControler@reset_password')->name('custom_register.reset_password');
Route::any('updates_password', 'CustomRegisterControler@updates_password')->name('custom_register.updates_password');

// Route::get('eupago_callback/{eupago_id}','SMSController@eupago_callback')->name('eupago_callback');


Route::any('human_resource/employee_edit/personal_data/{id}', 'HRController@employee_edit_personal_data')->name('employee_edit.personal_data');
Route::post('human_resource/employee_make_edit/personal_data/{id}', 'HRController@employee_make_edit_personal_data')->name('employee_make_edit.personal_data');
Route::any('human_resource/employee_edit/professional_data/{id}', 'HRController@employee_edit_professional_data')->name('employee_edit.professional_data');
Route::post('human_resource/employee_make_edit/professional_data/{id}', 'HRController@employee_make_edit_professional_data')->name('employee_make_edit.professional_data');


Route::any('/human_resource/company_settings/work_days','HRController@company_settings_workdays')->name('hr.company.settings.workdays');

//Alerts Company Settings HR Module
Route::any('/human_resource/company_settings/alerts','HRController@company_settings_alerts')->name('hr.company.settings.alerts');
Route::any('/human_resource/company_settings/alerts/edit/{id}','HRController@company_settings_alerts_edit')->name('hr.company.settings.alerts.edit');
Route::any('/human_resource/company_settings/alerts/edit/update/{id}','HRController@company_settings_alerts_update')->name('hr.company.settings.alerts.edit.update');

//Vacations Company Settings HR Module
Route::any('/human_resource/company_settings/vacations','HRController@company_settings_vacations')->name('hr.company.settings.vacations');
Route::any('/human_resource/company_settings/vacations/edit/{id}','HRController@company_settings_vacations_edit')->name('hr.company.settings.vacations.edit');
Route::any('/human_resource/company_settings/vacations/edit/update/{id}','HRController@company_settings_vacations_edit_update')->name('hr.company.settings.vacations.edit.update');

Route::any('/human_resource/company_settings/vacations/show-create','HRController@company_settings_vacations_showcreate')->name('hr.company.settings.vacations.showcreate');
Route::any('/human_resource/company_settings/vacations/create','HRController@company_settings_vacations_create')->name('hr.company.settings.vacations.create');
Route::any('/human_resource/company_settings/vacations/delete','HRController@company_settings_vacations_delete')->name('hr.company.settings.vacations.delete');

//Extra Days Settings HR Module

Route::any('/human_resource/company_settings/extra_days','HRController@company_settings_extradays')->name('hr.company.settings.extradays');
Route::any('/human_resource/company_settings/extra_days/add','HRController@company_settings_extradays_add')->name('hr.company.settings.extradays.add');
Route::any('/human_resource/company_settings/extra_days/add/create','HRController@company_settings_extradays_add_create')->name('hr.company.settings.extradays.add.create');
Route::any('/human_resource/company_settings/extra_days/deleted','HRController@company_settings_extradays_delete')->name('hr.company.settings.extradays.delete');

//Holidays Settings HR Module

Route::any('/human_resource/company_settings/holidays','HRController@company_settings_holidays')->name('hr.company.settings.holidays');
Route::any('/human_resource/company_settings/holidays/delete','HRController@company_settings_holidays_delete')->name('hr.company.settings.holidays.delete');
Route::any('/human_resource/company_settings/holidays/add','HRController@company_settings_holidays_add')->name('hr.company.settings.holidays.add');
Route::any('/human_resource/company_settings/holidays/add/create','HRController@company_settings_holidays_add_create')->name('hr.company.settings.holidays.add.create');

// General Settings HR Module

Route::any('/human_resource/company_settings/general','HRController@company_settings_general')->name('hr.company.settings.general');
Route::any('/human_resource/company_settings/general/edit/default-filters/{id}','HRController@company_settings_general_edit_filters')->name('hr.company.settings.general.edit.filters');
Route::any('/human_resource/company_settings/general/edit/my-profile-menus/{id}','HRController@company_settings_general_edit_menus')->name('hr.company.settings.general.edit.menus');
Route::any('/human_resource/company_settings/general/edit/price-km/{id}','HRController@company_settings_general_edit_km')->name('hr.company.settings.general.edit.km');
Route::any('/human_resource/company_settings/general/edit/default-filters/update/{id}','HRController@company_settings_general_edit_filters_update')->name('hr.company.settings.general.edit.filters.update');
Route::any('/human_resource/company_settings/general/edit/my-profile-menus/update/{id}','HRController@company_settings_general_edit_menus_update')->name('hr.company.settings.general.edit.menus.update');
Route::any('/human_resource/company_settings/general/edit/price-km/update/{id}','HRController@company_settings_general_edit_km_update')->name('hr.company.settings.general.edit.km.update');


Route::any('/human_resource/resend-email/{id}','HRController@hr_resend_invite')->name('hr.resend_email.confirmation');

Auth::routes();
