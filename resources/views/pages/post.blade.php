<?php
use App\Http\Controllers\PostController;
$postController = new PostController();

$value = $postController->show($id);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>{{ config('app.name') }}</title>
    @include('imports/cdns')
    <script src="{{ URL::asset('js/textarea.js') }}" defer></script>
    <script src="{{ URL::asset('js/make_post.js') }}" defer></script>
    <script src="{{ URL::asset('js/post_action.js') }}" defer></script>
    <link rel="stylesheet" href="{{ URL::asset('css/textarea.css') }}">
</head>

<body>
    <div class="d-flex">
        @include('components/header')
        <div class="w-75 mx-auto d-flex flex-column align-content-center" style="margin-left: 300px !important;">
            <div name="feed-list" class="w-75 mx-auto">
                <div name="new-post"></div>
                <div name="list-post">
                    @include('components.post')
                    @if (Auth::check())
                        <form name="post_form" class="w-100 mx-auto p-5 pt-0" action="{{ route('api.make_post') }}">
                            <input type="hidden" name="parent" value="{{ $value['id'] }}">
                            <h4>Response</h4>
                            <div class="input-group d-flex justify-content-center">
                                <textarea class="form-control" name="message" id="post_message"></textarea>
                            </div>
                            <div class="d-flex justify-content-end p-3">
                                <input type="submit" class="btn btn-primary" value="Submit">
                            </div>
                        </form>
                    @endif
                    <?php
                    if (count($value['comment']) != 0):
                    ?>
                    <b>Responses:</b>
                    <div class="ms-4">
                    <?php foreach ($value['comment'] as $key => $value): ?>
                        @include('components.post')
                    <?php endforeach; endif;?>
                </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
