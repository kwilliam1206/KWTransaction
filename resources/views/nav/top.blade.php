<header id="topnav">
    <div class="topbar-main">
        <div class="container">

            <!-- LOGO -->
            <div class="topbar-left">
                <a href="{{ route('dashboard') }}" class="logo"><span>KW<span>FrontDoor</span></span></a>
            </div>
            <!-- End Logo container-->


            <div class="menu-extras">

                <ul class="nav navbar-nav navbar-right pull-right">
                    <li>
                        <form class="navbar-left app-search pull-left hidden-xs" action="{{ route('office.change') }}">
                            <select name="office_id" class="select2 form-control" onchange="this.form.submit()">
                                @foreach (Auth::user()->offices as $office)
                                    <option value="{{ $office->id }}" @if ($office->id == Cookie::get('kw_office')) selected @endif>{{ $office->name }}</option>
                                @endforeach
                            </select>
                        </form>
                    </li>
                    <li>
                        <!-- Notification -->
                        <div class="notification-box">
                            <ul class="list-inline m-b-0">
                                <li>
                                    <a href="javascript:void(0);" class="right-bar-toggle">
                                        <i class="zmdi zmdi-notifications-none" style=""></i>
                                    </a>

                                    <div class="noti-dot">
                                        <span class="dot"></span>
                                        <span class="pulse"></span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- End Notification bar -->
                    </li>

                    <li class="dropdown user-box">
                        <a href="" class="dropdown-toggle waves-effect waves-light profile " data-toggle="dropdown"
                           aria-expanded="true">
                            <img src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="user-img"
                                 class="img-circle user-img">

                            <div class="user-status away"><i class="zmdi zmdi-dot-circle"></i></div>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a href="{{ route('profile_edit') }}"><i
                                            class="ti-user m-r-5"></i> {{ trans('nav.profile') }}</a></li>
                            <li><a href="javascript:void(0)"><i
                                            class="ti-settings m-r-5"></i> {{ trans('nav.settings') }}</a></li>
                            <li><a href="javascript:void(0)"><i
                                            class="ti-lock m-r-5"></i> {{ trans('nav.lock_screen') }}</a></li>
                            <li><a href="{{ route('logout') }}"><i
                                            class="ti-power-off m-r-5"></i> {{ trans('nav.logout') }}</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="menu-item">
                    <!-- Mobile menu toggle-->
                    <a class="navbar-toggle">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                    <!-- End mobile menu toggle-->
                </div>
            </div>

        </div>
    </div>

    <div class="navbar-custom">
        <div class="container">
            <div id="navigation">
                <!-- Navigation Menu-->
                <ul class="navigation-menu">
                    <li class="{{Request::is('dashboard') ? 'active' : ''}}">
                        <a href="{{ route('dashboard') }}"><i class="zmdi zmdi-view-dashboard"></i>
                            <span> {{ trans('nav.dashboard') }} </span> </a>
                    </li>
                    <li class="has-submenu {{Request::is('transaction/*') ? 'active' : ''}}">
                        <a href="#"><i class="zmdi zmdi-collection-text"></i>
                            <span> {{ trans('nav.transactions') }} </span> </a>
                        <ul class="submenu">
                            @if (Auth::user()->can('freeze_mc'))
                            <li>
                                <a href="{{route('period.freeze')}}">{{ trans('nav.close') }}</a>
                            </li>
                            <li class="divider"></li>
                            @endif

                            @foreach (\KW\Transactions\Models\TransactionStatus::orderBy('id', 'ASC')->get() as $status)
                            <li>
                                <a href="{{route('transaction.index.filter',['status'=>$status->rawname])}}">{{ $status->name }}</a>
                            </li>
                            @endforeach
                            <li class="divider"></li>
                            <li>
                                <a class="btn btn-success waves-effect waves-light"
                                   href="{{route('transaction.create')}}">{{ trans('general.new') }} {{ trans('general.transaction') }}
                                    <i class="fa fa-plus m-l-5 text-white"></i></a>
                            </li>

                        </ul>
                    </li>

                    <li class="has-submenu {{Request::is('payment/*') ? 'active' : ''}}">
                        <a href="#"><i class="zmdi zmdi-money"></i><span> {{ trans('nav.payments') }} </span> </a>
                        <ul class="submenu">
                            @foreach (\KW\Transactions\Models\PaymentStatus::orderBy('id', 'ASC')->get() as $status)
                            <li>
                                <a href="{{route('payment.index.filter',['status'=>$status->rawname])}}">{{ $status->name }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </li>

                    <li class="has-submenu {{Request::is('listing/*') ? 'active' : ''}}">
                        <a href="#"><i class="zmdi zmdi-pin"></i><span> {{ trans('general.listings') }} </span> </a>
                        <ul class="submenu">
                            @foreach (\KW\Transactions\Models\ListingStatus::orderBy('id', 'ASC')->get() as $status)
                            <li>
                                <a href="{{ route('listing.index.filter',['status'=>$status->rawname]) }}">{{ $status->name }}</a>
                            </li>
                            @endforeach
                            <li class="divider"></li>
                            <li>
                                <a class="btn btn-success waves-effect waves-light"
                                   href="{{route('listing.create')}}">{{ trans('general.new') }} {{ trans('general.listing') }}
                                    <i class="fa fa-plus m-l-5 text-white"></i></a>
                            </li>
                        </ul>
                    </li>

                    <li class="has-submenu {{Request::is('report/*') ? 'active' : ''}}">
                        <a href="#"><i class="zmdi zmdi-view-list"></i> <span> {{ trans('nav.reports') }} </span> </a>
                        <!--<ul class="submenu">
                            <li><a href="tables-basic.html">Basic Tables</a></li>
                            <li><a href="tables-datatable.html">Data Table</a></li>
                            <li><a href="tables-editable.html">Editable Table</a></li>
                        </ul>-->
                    </li>
                    <li class="has-submenu {{Request::is('contact/*') ? 'active' : ''}}">
                        <a href="#"><i class="zmdi zmdi-phone"></i> <span> {{ trans('nav.contacts') }} </span> </a>
                        <ul class="submenu">
                            <?php $contactTypes = \KW\Transactions\Models\ContactType::whereIn('name', ['client', 'agent', 'referral', 'other'])->orderBy('id', 'ASC')->get(); ?>
                            @foreach ($contactTypes as $type)
                            <li>
                                <a href="{{route('contact.index.filter',['type'=>$type->rawname])}}">{{ $type->name }}</a>
                            </li>
                            @endforeach
                            <li class="divider"></li>
                            @foreach ($contactTypes as $type)
                            <li>
                                <a class="btn btn-success waves-effect waves-light m-b-5"
                                   href="{{route('contact.create.filter',['type'=>$type->rawname])}}">
                                    @unless ($type->rawname == 'other') {{ trans('general.new') }} @endunless {{ $type->name }}
                                    <i class="fa fa-plus m-l-5 text-white"></i></a>
                            </li>
                            @endforeach
                        </ul>
                    </li>

                    @if (Auth::user()->can(['manage_region', 'manage_mc', 'manage_user']))
                        <li class="has-submenu {{Request::is('admin/*') ? 'active' : ''}}">
                            <a href="#"><i class="zmdi zmdi-layers"></i><span> {{ trans('nav.admin') }} </span> </a>
                            <ul class="submenu">

                                @if (Auth::user()->can('manage_user'))
                                    <li>
                                        <a href="{{ route('user.index') }}">{{ trans('nav.users') }}</a>
                                    </li>
                                @endif
                                @if (Auth::user()->can('manage_mc'))
                                    <li>
                                        <a href="{{ route('office.index') }}">{{ trans('nav.offices') }}</a>
                                    </li>
                                @endif
                                @if (Auth::user()->can('manage_region'))
                                    <li>
                                        <a href="{{ route('region.index') }}">{{ trans('nav.regions') }}</a>
                                    </li>
                                @endif

                                    <li class="divider"></li>

                                @if (Auth::user()->can('manage_user'))
                                    <li>
                                        <a class="btn btn-success waves-effect waves-light m-b-5" href="{{ route('user.create') }}">{{ trans('nav.add_user') }}
                                            <i class="fa fa-plus m-l-5 text-white"></i></a>
                                    </li>
                                @endif
                                @if (Auth::user()->can('manage_mc'))
                                    <li>
                                        <a class="btn btn-success waves-effect waves-light m-b-5" href="{{ route('office.create') }}">{{ trans('nav.add_office') }}
                                            <i class="fa fa-plus m-l-5 text-white"></i></a>
                                    </li>
                                @endif
                                @if (Auth::user()->can('manage_region'))
                                    <li>
                                        <a class="btn btn-success waves-effect waves-light m-b-5" href="{{ route('region.create') }}">{{ trans('nav.add_region') }}
                                            <i class="fa fa-plus m-l-5 text-white"></i></a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                </ul>
                <!-- End navigation menu  -->
            </div>
        </div>
    </div>
</header>