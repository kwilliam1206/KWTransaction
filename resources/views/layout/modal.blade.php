
<div class="custom-modal">
    <button type="button" class="close" onclick="Custombox.close();">
        <span>×</span><span class="sr-only">{{ trans('general.close') }}</span>
    </button>

    <h4 class="custom-modal-title">
        @yield('modal.title')
    </h4>

    <div class="custom-modal-text">

        @yield('modal.content')

    </div>
</div>


@yield('modal.scripts')
