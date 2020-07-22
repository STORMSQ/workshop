<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))
            <script type="text/javascript">
                alert('{{ Session::get('alert-' . $msg) }}');
            </script>
        @endif
    @endforeach
</div>