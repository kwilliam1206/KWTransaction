
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

    <h4 class="header-title m-t-0">{{$widget->title}}</h4>

    <div class="widget-chart text-center">
        <div id="widget-{{$widget->id}}" style="height: {{isset($widget->height)? $widget->height : (isset($widget->label)? '172px' : '208px')}};"></div>
        <ul class="list-inline chart-detail-list m-b-0">
            @foreach ($widget->data as $dp)
            <li>
                <h5 style="color:{{$dp->color}};"><i class="fa fa-circle m-r-5"></i>{{$dp->label}}</h5>
            </li>
            @endforeach
            @if (isset($widget->label))
            <li><h5 style="color:#f05050">{{$widget->label}}</h5></li>
            @endif
        </ul>
    </div>

    <script>
        $(document).ready(function () {
            Morris.Donut({
                element: 'widget-{{ $widget->id }}',
                data: {!! json_encode($widget->data) !!},
                resize: true, //defaulted to true
                colors: {!! json_encode($widget->colors) !!}
            });
        });
    </script>
</div>