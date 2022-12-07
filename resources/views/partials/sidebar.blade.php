@php $modules = explode(',', Auth::user()->access_modules);
$inv_type = ($inv_type ?? null);
@endphp
<div class="scrollbar-sidebar">
    <div class="app-sidebar__inner">
        <ul class="vertical-nav-menu">
            <li
                    class="mm-{{Request::is('/')  ? 'active open' : ''}}">

                <a href="{{route('/')}}">
                    <i class="metismenu-icon fas fa-home"></i>
                    {{trans('menu.dashboard')}}
                </a>
            <li
                    class="mm-{{Request::is('brands*')    ||
                                           Request::is('invoices/home')        || 

                                           Request::is('invoices*') ||
                                           Request::is('clients*')  || 
                                           Request::is('tax-authority*')  ||
                                           Request::is('items*') ||
                                          //Request::is('digital_signature*') ||
                                           Request::is('fee*') ? 'active open' : ''}}">

                @if(in_array('2', $modules) || in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
                    <a href="#">
                        <i class="metismenu-icon fas fa-file-invoice"></i>
                            {{trans('menu.invoicing')}}
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="{{route('invoices.home')}}"
                               class="mm-{{ Request::is('invoices/home') ? 'active open' : '' }}" href="{{route('invoices.home')}}">
                                <i class="metismenu-icon">
                                </i>{{trans('menu.home')}}
                            </a>
                        </li>

                    <!-- @can('View Brands') -->
                        <li>
                            <a
                                    class="mm-{{ Request::is('brands*') ? 'active open' : '' }}"
                                    href="{{route('brands')}}">
                                <i class="metismenu-icon"></i>
                                {{trans('menu.brands')}}
                            </a>
                        </li>
                    <!-- @endcan -->


                    <!-- @can('View Invoice') -->
                        <li
                                class="mm-{{   Request::is('invoices')
                                                 ||Request::is('invoices/invoice_receipt')
                                                 ||Request::is('invoices/add')
                                                 ||Request::is('invoices/invoice_simplified')
                                                 ||Request::is('invoices/credit_note')
                                                 ||Request::is('invoices/add_credit_note')
                                                   ? 'active open' : ''}}"
                        >

                            <a href="#">
                                <i class="metismenu-icon fas fa-cog">
                                </i>{{trans('menu.documents')}}
                                <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                            </a>
                            <ul>
                                <li>

                                    <a href="{{route('invoices')}}" class="mm-{{ Request::is('invoices') || $inv_type==('invoice') ? 'active open' : '' }}">

                                        <i class="metismenu-icon"></i>
                                        {{trans('menu.invoices')}}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('invoice_receipt')}}" class="mm-{{ Request::is('invoices/invoice_receipt') || $inv_type==('receipt')? 'active open' : '' }} ">
                                        <i class="metismenu-icon"></i>
                                        {{trans('menu.invoice_receipt')}}
                                    </a>
                                </li>
                                <li>

                                    <a href="{{route('invoice_simplified')}}" class="mm-{{ Request::is('invoices/invoice_simplified') || $inv_type==('simplified') ? 'active open' : '' }} ">
                                        <i class="metismenu-icon"></i>
                                        {{trans('menu.invoice_simplified')}}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('credit_note')}}" class="mm-{{ Request::is('invoices/credit_note') || Request::is('invoices/add_credit_note')? 'active open' : '' }}">
                                        <i class="metismenu-icon"></i>
                                        {{trans('menu.credit_note')}}
                                    </a>
                                </li>
                            </ul>
                        <li
                                class="mm-{{ Request::is('tax-authority/saf-t*')
                                                   ? 'active open' : ''}}"
                        >
                            <a href="#">
                                <i class="metismenu-icon fas fa-cog">
                                </i>{{trans('menu.tax_auth')}}
                                <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                            </a>
                            <ul>
                                <li>
                                    <a href="{{route('tax-authority.saf-t')}}"
                                       class="mm-{{ Request::is('tax-authority/saf-t*') ? 'active open' : ''}}">
                                        <i class="metismenu-icon">
                                        </i>SAF-T PT
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <!-- @endcan -->



                    <!-- @can('View Client') -->
                        <li>
                            <a href="{{route('clients')}}"
                               class="mm-{{ Request::is('clients*') ? 'active open' : '' }}" href="{{route('clients')}}">
                                <i class="metismenu-icon">
                                </i>{{trans('menu.clients')}}
                            </a>
                        </li>
                    <!-- @endcan -->



                    <!-- @can('View Items') -->
                        <li>
                            <a href="{{route('items')}}"
                               class="mm-{{ Request::is('items*') ? 'active open' : '' }}" href="{{route('items')}}">
                                <i class="metismenu-icon">
                                </i>{{trans('menu.items')}}
                            </a>
                        </li>
                    <!-- @endcan -->
                        <li
                                class="mm-{{ //Request::is('digital_signature*')||
                                                    Request::is('fee*')||
                                                    Request::is('billing-alerts*')
                                                   ? 'active open' : ''}}"
                        >
                            <a href="#">
                                <i class="metismenu-icon fas fa-cog">
                                </i>{{trans('menu.configuration')}}
                                <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                            </a>
                            <ul>
                                {{--<li>
                                    <a
                                            class="mm-{{ Request::is('digital_signature*') ? 'active open' : '' }}"
                                            href="{{ route('digital_signature')}}">
                                        <i class="metismenu-icon">
                                        </i>{{trans('menu.digital_signature')}}
                                    </a>
                                </li>--}}
                                <li>
                                    <a
                                            class="mm-{{ Request::is('fee*') ? 'active open' : '' }}"
                                            href="{{ route('showFees')}}">
                                        <i class="metismenu-icon">
                                        </i>{{trans('menu.fee')}}
                                    </a>
                                </li>
                                <li>
                                    <a class="mm-{{ Request::is('billing-alerts*')? 'active open' : '' }}"
                                       href="{{route('billing-alerts')}}">
                                        <i class="metismenu-icon">
                                        </i>{{trans('menu.billing_alerts')}}
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
            </li>
            @endif
            <li>

            @if(in_array('3', $modules)  || in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))

                <li
                        class="mm-{{ Request::is('sms/submit')
                                                   
                                                   || Request::is('sms/list')
                                                   || Request::is('sms/sender')
                                                   || Request::is('sms/sender/add')
                                                   || Request::is('sms/template/add')
                                                   || Request::is('sms/template')
                                                   || Request::is('sms/template/edit/*')
                                                
                                                   || Request::is('sms/home')
                                                   ? 'active open' : ''}}"

                >
                    <a href="#">
                        <i class="metismenu-icon fas fa-sms " ></i>
                        {{trans('menu.SMS')}}
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        @if(in_array('3', $modules))
                            <li>
                                <a
                                        class="mm-{{ Request::is('sms/home') ? 'active open' : '' }}"
                                        href="{{ route('sms.home')}}">
                                    <i class="metismenu-icon">
                                    </i>{{trans('menu.home')}}
                                </a>
                            </li>
                        @endif
                        <li>
                            <a
                                    class="mm-{{ Request::is('sms/submit') ? 'active open' : '' }}"
                                    href="{{route('sms.submit')}}">
                                <i class="metismenu-icon">
                                </i>{{trans('menu.Submit')}}
                            </a>
                        </li>
                        <li>
                            <a
                                    class="mm-{{ Request::is('sms/list') ? 'active open' : '' }}"
                                    href="{{ route('sms.list')}}">
                                <i class="metismenu-icon">
                                </i>{{trans('menu.List')}}
                            </a>
                        </li>
                    <!-- @if ( Auth::user()->roles()->pluck('name')->implode(' ')  == 'Administrator')
                        <li>
                            <a
                            class="mm-{{ Request::is('sms/listAll') ? 'active open' : '' }}"

                                                href="{{ route('sms.listAll')}}">
                                                    <i class="metismenu-icon">
                                                    </i>{{trans('menu.ListAll')}}
                                </a>
                            </li>
                        @endif -->
                        <li
                                class="mm-{{ Request::is('sms/sender')
                                                        || Request::is('sms/sender/add')
                                                         ? 'active open' : ''}}">
                            <a href="#">
                                <i class="metismenu-icon fas fa-cog "></i>
                                {{trans('menu.Sender')}}
                                <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                            </a>
                            <ul>
                                <li>
                                    <a
                                            class="mm-{{ Request::is('sms/sender/add') ? 'active open' : '' }}"
                                            href="{{route('sender.add')}}">
                                        <i class="metismenu-icon">
                                        </i>{{trans('menu.Create')}}
                                    </a>
                                </li>
                                <li>
                                    <a
                                            class="mm-{{ Request::is('sms/sender') ? 'active open' : '' }}"
                                            href="{{ route('sender')}}">
                                        <i class="metismenu-icon">
                                        </i>{{trans('menu.List')}}
                                    </a>
                                </li>
                            </ul>

                        </li>
                        <li
                                class="mm-{{ Request::is('sms/template')
                                                        || Request::is('sms/template/add')
                                                        || Request::is('sms/template/edit/*')
                                                         ? 'active open' : ''}}">
                            <a href="#">
                                <i class="metismenu-icon fas fa-cog "></i>
                                {{trans('menu.Templates')}}
                                <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                            </a>
                            <ul>
                                <li>
                                    <a
                                            class="mm-{{ Request::is('sms/template/add') ? 'active open' : '' }}"
                                            href="{{route('template.add')}}">
                                        <i class="metismenu-icon">
                                        </i>{{trans('menu.Create')}}
                                    </a>
                                </li>
                                <li>
                                    <a
                                            class="mm-{{ Request::is('sms/template') ? 'active open' : '' }}"
                                            href="{{ route('template')}}">
                                        <i class="metismenu-icon">
                                        </i>{{trans('menu.List')}}
                                    </a>
                                </li>
                            </ul>
                        </li>


                    </ul>
                </li>
                <!--@endif-->
                </li>
                <li
                        class="mm-{{Request::is('users/developer') ||
                            Request::is('sms/apiLogs')
                                        ? 'active open' : ''}}">
                    <a href="#">
                        <i class="metismenu-icon fas fa-chart-area "></i>
                        {{trans('menu.report')}}
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                    @if(in_array('3', $modules))
                        <li>
                            <a href="{{route('report.sms.index')}}"
                               class="mm-{{ Request::is('reports/report_sms') ? 'active open' : '' }}">
                                <i class="metismenu-icon">
                                </i>{{trans('menu.report_sms')}}
                            </a>
                        </li>
                        @endif
                        @if(in_array('2', $modules))
                        <li>
                            <a href="{{route('report.invoice.index')}}"
                               class="mm-{{ Request::is('reports/report_invoice') ? 'active open' : '' }}">
                                <i class="metismenu-icon">
                                </i>{{trans('menu.report_invoicing')}}
                            </a>
                        </li>  
                        @endif    
                    </ul>
                
                @if(in_array('5', $modules)  || in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
                    <li
                            class="mm-{{Request::is('human_resource*') ||
                                Request::is('human_resource/company_settings*')
                                        ? 'active open' : ''}}">
                        <a href="#">
                            <i class="metismenu-icon lnr-users "></i>
                            Human Resources

                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>

                            <li>
                                <a href="{{route('hr.dashboard')}}"
                                    class="mm-{{ Request::is('human_resource') ? 'active open' : '' }}" href="{{route('hr.dashboard')}}">
                                    <i class="metismenu-icon">
                                    </i>Home
                                </a>
                            </li>
                            @if(in_array("Employee" , Auth::user()->roles()->pluck('name')->toArray()) ||  in_array("Manager" , Auth::user()->roles()->pluck('name')->toArray()))
                                <li>
                                    <a href="{{route('hr.request_status')}}"
                                        class="mm-{{ Request::is('human_resource/request-status') ? 'active open' : '' }}" href="{{route('hr.request_status')}}">
                                        <i class="metismenu-icon">
                                        </i>Request statuses
                                    </a>
                                </li>
                            @endif

                                @if(in_array("Manager" , Auth::user()->roles()->pluck('name')->toArray()) || Auth::user()->is_hr_admin=='admin' || in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))   
                                    <li>
                                        <a href="{{route('hr.create_employee')}}"
                                            class="mm-{{ Request::is('human_resource/add_employee') ? 'active open' : '' }}" href="{{route('hr.create_employee')}}">
                                            <i class="metismenu-icon">
                                            </i>Add Employee
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('hr.all_teams')}}"
                                            class="mm-{{ Request::is('human_resource/all-teams') ? 'active open' : '' }}" href="{{route('hr.all_teams')}}">
                                            <i class="metismenu-icon">
                                            </i>All Teams
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('hr.create_team')}}"
                                            class="mm-{{ Request::is('human_resource/create_team') ? 'active open' : '' }}" href="{{route('hr.create_team')}}">
                                            <i class="metismenu-icon">
                                            </i>Create Teams
                                        </a>
                                    </li>                                    
                                    <li>
                                        <a href="{{route('hr.all_requests')}}"
                                            class="mm-{{ Request::is('human_resource/all-requests') ? 'active open' : '' }}" href="{{route('hr.all_requests')}}">
                                            <i class="metismenu-icon">
                                            </i>All Requests
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('hr.company.settings.alerts')}}"
                                            class="mm-{{ Request::is('human_resource/company_settings/*') ? 'active open' : '' }}" href="{{route('hr.company.settings.alerts')}}">
                                            <i class="metismenu-icon">
                                            </i>Company Settings
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('hr.calender_days_off')}}"
                                            class="mm-{{ Request::is('human_resource/calender-days-off') ? 'active open' : '' }}" href="{{route('hr.calender_days_off')}}">
                                            <i class="metismenu-icon">
                                            </i> View Celender
                                        </a>
                                    </li>
                                    @if(in_array("Manager" , Auth::user()->roles()->pluck('name')->toArray()))
                                        <li>
                                            <a href="{{route('hr.manager.add_days_off')}}"
                                                class="mm-{{ Request::is('human_resource/days-off/add') ? 'active open' : '' }}" href="{{route('hr.manager.add_days_off')}}">
                                                <i class="metismenu-icon">
                                                </i>Add Request 
                                            </a>
                                        </li>
                                    @endif
                                @endif
                                {{-- @if ( in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
                                    <li class="mm-{{Request::is('balance-movements') ||
                                                Request::is('balance-movements/list')  ? 'active open' : ''}}">
                                        <a href="#">
                                            <i class="metismenu-icon fas fa-cog "></i>
                                            Balance Movements
                                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                        </a>
                                        <ul>
                                            <li>
                                                <a href="{{route('balance-movements')}}"
                                                class="mm-{{ Request::is('balance-movements') ? 'active open' : '' }}" >
                                                    <i class="metismenu-icon">
                                                    </i>Create Movements
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{route('balance-movements.list')}}"
                                                class="mm-{{ Request::is('balance-movements/list') ? 'active open' : '' }}" >
                                                    <i class="metismenu-icon">
                                                    </i>List Movements
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                @endif --}}
                            </ul>
                        </li>
                @endif

               {{-- Admin Module --}}

                @if(in_array('4', $modules)  || in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
                    @if ( in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
                        <li
                                class="mm-{{Request::is('users') || Request::is('modules*')
                                       || Request::is('roles*') 
                                       || Request::is('permissions*')
                                       || Request::is('accounts/details')
                                       || Request::is('sms/SmsProvider')
                                       || Request::is('sms_rates*')
                                       || Request::is('contact_client_via_email')
                                        ? 'active open' : ''}}">
                            <a href="#">
                                <i class="metismenu-icon lnr-user "></i>
                                {{trans('menu.admin')}}
                                <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                            </a>
                            <ul>


                                <li>
                                    <a href="{{route('contact_client_via_email')}}"
                                       class="mm-{{ Request::is('contact_client_via_email') ? 'active open' : '' }}" href="{{route('roles.index')}}">
                                        <i class="metismenu-icon">
                                        </i>{{trans('menu.contact_client')}}
                                    </a>
                                </li>

                                <li>
                                    <a href="{{route('roles.index')}}"
                                       class="mm-{{ Request::is('roles*') ? 'active open' : '' }}" href="{{route('roles.index')}}">
                                        <i class="metismenu-icon">
                                        </i>{{trans('menu.roles')}}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('permissions.index')}}"
                                       class="mm-{{ Request::is('permissions*') ? 'active open' : '' }}" href="{{route('permissions.index')}}">
                                        <i class="metismenu-icon">
                                        </i>{{trans('menu.permissions')}}
                                    </a>
                                </li>


                                {{-- <li>
                                      <a href="{{route('modules')}}"
                                         class="mm-{{ Request::is('modules*') ? 'active open' : '' }}" href="{{route('modules')}}">
                                          <i class="metismenu-icon">
                                          </i>{{trans('menu.modules')}}
                                      </a>
                                  </li> --}}


                                <li>
                                    <a href="{{route('users')}}"
                                       class="mm-{{ Request::is('users*') ? 'active open' : '' }}" href="{{route('users')}}">
                                        <i class="metismenu-icon">
                                        </i>{{trans('menu.users')}}
                                    </a>
                                </li>

                                <li
                                        class="mm-{{ Request::is('SmsProvider*')
                                       || Request::is('sms_rates*') 
                                       || Request::is('sms/SmsProvider') 
                                      
									   || Request::is('sms/listAll') ? 'active open' : ''}}
                                                ">
                                    <a href="#">
                                        <i class="metismenu-icon fas fa-sms"></i>
                                        SMS
                                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                    </a>
                                    <ul>

                                        <li>
                                            <a href="{{route('SmsProvider')}}"
                                               class="mm-{{ Request::is('sms/SmsProvider') ? 'active open' : '' }}" href="{{route('SmsProvider')}}">
                                                <i class="metismenu-icon">
                                                </i>{{trans('menu.provider')}}
                                            </a>
                                        </li>



                                        <li>
                                            <a href="{{route('smsrates')}}"
                                               class="mm-{{ Request::is('sms_rates*') ? 'active open' : '' }}" href="{{route('smsrates')}}">
                                                <i class="metismenu-icon">
                                                </i>{{trans('menu.rates')}}
                                            </a>
                                        </li>

                                        @if ( in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
                                            <li>
                                                <a
                                                        class="mm-{{ Request::is('sms/listAll') ? 'active open' : '' }}"
                                                        href="{{ route('sms.listAll')}}">
                                                    <i class="metismenu-icon">
                                                    </i>{{trans('menu.ListAll')}}
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                                @if ( in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
                                    <li class="mm-{{Request::is('balance-movements') ||
                                                  Request::is('balance-movements/list')  ? 'active open' : ''}}">
                                        <a href="#">
                                            <i class="metismenu-icon fas fa-cog "></i>
                                            {{trans('menu.balance_movements')}}
                                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                        </a>
                                        <ul>
                                            <li>
                                                <a href="{{route('balance-movements')}}"
                                                   class="mm-{{ Request::is('balance-movements') ? 'active open' : '' }}" >
                                                    <i class="metismenu-icon">
                                                    </i>{{trans('menu.create_movements')}}
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{route('balance-movements.list')}}"
                                                   class="mm-{{ Request::is('balance-movements/list') ? 'active open' : '' }}" >
                                                    <i class="metismenu-icon">
                                                    </i>{{trans('menu.list_movements')}}
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                @endif
                                {{-- @if ( Auth::user()->roles()->pluck('name')->implode(' ')  == 'Administrator')
                                <li>
                                      <a href="{{route('balance-movements')}}"
                                         class="mm-{{ Request::is('balance-movements') ? 'active open' : '' }}" >
                                          <i class="metismenu-icon">
                                          </i>{{trans('menu.create_movements')}}
                                      </a>
                                  </li>
                                @endif --}}
                            </ul>
                        </li>
                    @endif


                @endif
                @if(in_array('1', $modules)  || in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
                    <li
                            class="mm-{{
                                                     Request::is('roles*') 
                                                    || Request::is('permissions*')
                                                    || Request::is('accounts/details')
                                                    || Request::is('accounts/*/billind_data')
                                                    || Request::is('SmsProvider')
                                                    || Request::is('smsrates')
                                                    || Request::is('change_module')
                                                    || Request::is('contact_client_usr')
                                                    || Request::is('sms/payments')
                                                    ? 'active open' : ''}}">
                        <a href="#">
                            <i class="metismenu-icon fas fa-cog "></i>
                            {{trans('menu.settings')}}
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>

                            <li
                                    class="mm-{{Request::is('accounts/details') ||Request::is('balance-movements/listSimpleUser')||
                                                                Request::is('accounts/*/billing_data')  ? 'active open' : ''}}">
                                <a href="#">
                                    <i class="metismenu-icon fas fa-cog "></i>
                                    {{trans('menu.Account')}}
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>
                                <ul>

                                    <li>
                                        <a href="{{route('account.user_details')}}"
                                           class="mm-{{ Request::is('accounts/user_details') ? 'active open' : '' }}" href="{{route('account.user_details')}}">
                                            <i class="metismenu-icon">
                                            </i>{{trans('accounts.account_details')}}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('account.balance')}}"
                                           class="mm-{{ Request::is('accounts/details') ? 'active open' : '' }}" href="{{route('account.balance')}}">
                                            <i class="metismenu-icon">
                                            </i>{{trans('menu.Account_balance')}}
                                        </a>
                                    </li>
                                    <li>
                                        <a
                                                class="mm-{{ Request::is('accounts/*/billing_data') ? 'active open' : '' }}"
                                                href="{{ url('accounts/'.Auth::user()->id.'/billing_data/')}}">
                                            <i class="metismenu-icon">
                                            </i>{{trans('menu.Billing_data')}}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('balance-movements.list.simpleUser')}}"
                                           class="mm-{{ Request::is('balance-movements/listSimpleUser') ? 'active open' : '' }}" >
                                            <i class="metismenu-icon">
                                            </i>{{trans('menu.list_movements')}}
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li>
                                <a
                                        class="mm-{{ Request::is('sms/payments') ? 'active open' : '' }}"
                                        href="{{ route('sms.payments')}}">
                                    <i class="metismenu-icon">
                                    </i>{{trans('menu.payments')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('clients.contact_client_usr')}}"
                                   class="mm-{{ Request::is('contact_client_usr') ? 'active open' : '' }}" href="{{route('account.balance')}}">
                                    <i class="metismenu-icon">
                                    </i>{{trans('menu.contact_client')}}
                                </a>
                            </li>

                            <li>
                                <a
                                        class="mm-{{ Request::is('change_module') ? 'active open' : '' }}"
                                        href="{{ route('change_module')}}">
                                    <i class="fas fa-tasks metismenu-icon"></i>
                                    {{-- <i class="metismenu-icon">
                                    </i> --}}
                                    {{trans('menu.change_module')}}
                                </a>
                            </li>





                            {{-- @if ( Auth::user()->roles()->pluck('name')->implode(' ')  == 'Administrator')
                            <li class="mm-{{Request::is('balance-movements*') ||
                                            Request::is('balance-movements*')  ? 'active open' : ''}}">
                                    <a href="#">
                                    <i class="metismenu-icon fas fa-cog "></i>
                                        {{trans('menu.balance_movements')}}
                                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="{{route('balance-movements')}}"
                                            class="mm-{{ Request::is('balance-movements') ? 'active open' : '' }}" >
                                                <i class="metismenu-icon">
                                                </i>{{trans('menu.create_movements')}}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('balance-movements.list')}}"
                                            class="mm-{{ Request::is('balance-movements/list*') ? 'active open' : '' }}" >
                                                <i class="metismenu-icon">
                                                </i>{{trans('menu.list_movements')}}
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif --}}
                        </ul>

                    </li>

                @endif
                <li
                        class="mm-{{Request::is('users/developer') ||
                            Request::is('sms/apiLogs')
                                        ? 'active open' : ''}}">
                    <a href="#">
                        <i class="metismenu-icon fas fa-ethernet "></i>
                        {{trans('menu.api')}}
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="{{route('users.developer')}}"
                               class="mm-{{ Request::is('users/developer') ? 'active open' : '' }}">
                                <i class="metismenu-icon">
                                </i>Usage
                            </a>
                        </li>
                        @if ( in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
                        <li>
                            <a href="{{route('sms.apiLogs')}}"
                               class="mm-{{ Request::is('sms/apiLogs') ? 'active open' : '' }}">
                                <i class="metismenu-icon">
                                </i>{{trans('menu.apiLogs')}}
                            </a>
                        </li>
                        @endif
                        
                    </ul>
                    
                    </li>
                        <li>
                            <a href="{{route('faq.index')}}"
                               class="mm-{{ Request::is('/faq') ? 'active open' : '' }}">
                                <i class="metismenu-icon fas fa-question">
                                </i>FAQ
                            </a>
                        </li>
                        </ul>


    </div>
</div>


<script>
    function abc()
    {
        var APP_URL = {!! json_encode(url('/')) !!}
        window.location.replace(APP_URL+"/ContributerDashboard");
    }
</script>
          