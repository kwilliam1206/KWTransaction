
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
            @if (isset($widget->data['count']))
            <span class="badge pull-left m-t-10" style="background-color:{{$widget->bgColor}};font-size:24px;">{{$widget->data['count']}}</span>
            @endif

            <h2 class="m-b-0"> {{ $widget->data['value'] }} </h2>

            <p class="text-muted m-b-25">{{$widget->data['label']}}</p>
        </div>
    </div>

</div>