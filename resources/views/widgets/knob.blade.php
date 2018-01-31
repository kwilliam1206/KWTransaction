
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

    <div class="widget-chart-1">
        <div class="widget-chart-box-1">
            <input data-plugin="knob" data-width="80" data-height="80" data-fgColor="{{$widget->fgColor}} "
                   data-bgColor="{{$widget->bgColor}}" value="{{$widget->data['percentage']}}%"
                   data-skin="tron" data-angleOffset="180" data-readOnly=true
                   data-thickness=".15"/>
        </div>

        <div class="widget-detail-1">
            <h2 class="p-t-10 m-b-0"> {{$widget->data['value']}} </h2>

            <p class="text-muted">{{$widget->data['label']}}</p>
        </div>
    </div>
</div>