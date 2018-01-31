
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

    <div id="widget-{{$widget->id}}" style="height: 280px;"></div>

    <script>
        $(document).ready(function () {
            Morris.Bar({
                 element: 'widget-{{ $widget->id }}',
                 data: {!! json_encode($widget->data) !!},
                 xkey: '{{ $widget->xkey }}',
                 ykeys: {!! json_encode($widget->ykeys) !!},
                 labels: {!! json_encode($widget->labels) !!},
                 hideHover: 'auto',
                 resize: true, //defaulted to true
                 stacked: {{ $widget->stacked? 'true' : 'false' }},
                 gridLineColor: '{{ $widget->gridLineColor }}',
                 barSizeRatio: {{ $widget->barSizeRatio }},
                 barColors: {!! json_encode($widget->barColors) !!}
             });
        });
    </script>
</div>