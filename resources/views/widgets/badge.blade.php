
<div class="card-box">
    <div class="dropdown pull-right">
        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
           aria-expanded="false">
            <i class="zmdi zmdi-more-vert"></i>
        </a>
        @if (count($widget->actions))
            <ul class="dropdown-menu" role="menu">
                @foreach ($widget->actions as $cta)
                    <li><a href="{{$cta->url}}">{{$cta->action}}</a></li>
                @endforeach
            </ul>
        @endif
    </div>

    <h4 class="header-title m-t-0 m-b-30">{{$widget->title}}</h4>

    <div class="widget-box-2">
        <div class="widget-detail-2">
            <span class="badge badge-success pull-left m-t-20">{{$widget->data['trendingValue']}}% <i class="zmdi zmdi-trending-{{$widget->data['trendingValue']<0?'down':'up'}}"></i> </span>

            <h2 class="m-b-0"> {{ $widget->data['value'] }} </h2>

            <p class="text-muted m-b-25">{{$widget->data['label']}}</p>
        </div>
        @if (isset($widget->data['progress']))
        <div class="progress progress-bar-success-alt progress-sm m-b-0" style="background-color:{{$widget->data['progressColor']}}">
            <div class="progress-bar progress-bar-success" role="progressbar"
                 style="width:{{$widget->data['progress']}}%;background-color:{{$widget->bgColor}};">
                <span class="sr-only">{{$widget->data['progress']}}% Complete</span>
            </div>
        </div>
        @endif
    </div>

</div>