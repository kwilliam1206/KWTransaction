@extends('layout.master')
@section('title', trans('nav.dashboard'))
@section('page_heading')
    <div class="row">
            <h4 class="page-title">Dashboard</h4>
    </div>
@endsection
@section('content')
    @for ($n=0; $n<count($widgets->rows); $n++)
    <div class="row">
        @foreach ($widgets->rows[$n] as $widget)
        <div class="col-lg-{{$n==0? 3 : 4}}">
            @include('widgets.'.$widget->type, ['widget'=>$widget])
        </div><!-- end col -->
        @endforeach
    </div>
    @endfor
    <!-- end row -->

    <div class="row">
        <div class="col-lg-4">
            <div class="card-box">
                <div class="dropdown pull-right">
                    <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                       aria-expanded="false">
                        <i class="zmdi zmdi-more-vert"></i>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                    </ul>
                </div>

                <h4 class="header-title m-t-0 m-b-30">My Tasks</h4>

                <div class="inbox-widget nicescroll" style="height: 315px;">
                    @if (count($tasks))
                    @foreach ($tasks as $task)
                    <a href="{{ route('transaction.edit', [$task->transaction->id]) }}">
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="{{ asset('assets/images/users/avatar-1.jpg') }}"
                                                             class="img-circle" alt=""></div>
                            <p class="inbox-item-author">{{ $task->transaction->agent->name }}</p>

                            <p class="inbox-item-text">Transaction #{{ $task->transaction->id }}</p>

                            <p class="inbox-item-date">{{ $task->created_at->format('m/d/Y g:i A') }}</p>
                        </div>
                    </a>
                    @endforeach
                    @endif
                </div>
            </div>
        </div><!-- end col -->

        <div class="col-lg-8">
            <div class="card-box">
                <div class="dropdown pull-right">
                    <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                       aria-expanded="false">
                        <i class="zmdi zmdi-more-vert"></i>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                    </ul>
                </div>

                <h4 class="header-title m-t-0 m-b-30">Latest Transactions</h4>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Agent</th>
                            <th>Office</th>
                            <th>Submission Date</th>
                            <th>Status Change Date</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->id }}</td>
                            <td>{{ $transaction->agent->name }}</td>
                            <td>{{ $transaction->office->name }}</td>
                            <td>{{ $transaction->submit_date ? $transaction->submit_date->format('m/d/Y') : ''}}</td>
                            <td>{{ $transaction->status_change_date->format('m/d/Y') }}</td>

                            <?php $statusLabels = [
                                'draft' => 'default',
                                'submitted' => 'pink',
                                'rejected' => 'danger',
                                'accepted' => 'success',
                                'withdrawn' => 'warning',
                                'completed' => 'primary',
                                'pending' => 'purple',
                            ] ?>
                            <td><span class="label label-{{ $statusLabels[$transaction->status->rawname] }}">{{ $transaction->status->name }}</span></td>
                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- end col -->

    </div>
    <!-- end row -->
@endsection


@section('css')
    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/morris/morris.css') }}">
@endsection


@section('bottom_scripts')
    <!--Morris Chart-->
    <script src="{{ asset('assets/plugins/morris/morris.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/raphael/raphael-min.js') }}"></script>

    <!-- Dashboard init -->
    <!--<script src="{{ asset('assets/pages/jquery.dashboard.js') }}"></script>-->

@endsection
