@if (in_array('bootstrap', $required))
    <script src='{{ URL::asset('/js/bootstrap.bundle.min.js') }}'></script>
    <link rel='stylesheet' href='{{ URL::asset('/css/bootstrap.css') }}' />
@endif

@if (in_array('noty', $required))
    <script src='{{ URL::asset('/js/noty.js') }}'></script>
    <link rel='stylesheet' href='{{ URL::asset('/css/noty.css') }}' />
@endif


@if (in_array('font-awesome', $required))
    <link rel='stylesheet' href='{{ URL::asset('/css/font-awesome.css') }}' />
@endif


@if (in_array('jquery', $required))
    <script src='{{ URL::asset('/js/jquery.js') }}'></script>
    <script src='{{ URL::asset('/js/jquery.cookie.js') }}'></script>
@endif


@if (in_array('textarea', $required))
    <script src='{{ URL::asset('js/textarea.js') }}' defer></script>
@endif

@if (in_array('make_post', $required))
    <script src='{{ URL::asset('js/make_post.js') }}' defer></script>
@endif

@if (in_array('post_action', $required))
    <script src='{{ URL::asset('js/post_action.js') }}' defer></script>
@endif


@if (in_array('textarea', $required))
    <link rel='stylesheet' href='{{ URL::asset('css/textarea.css') }}'>
@endif
