<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;

$userController = new UserController();
$user = $userController->GetUserByName($name);
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
            <div class="d-flex justify-content-between align-items-end m-3">
                <div class="d-flex">
                    <div class="rounded-circle ratio ratio-1x1 overflow-hidden" style="width: 3em;">
                        <img src="{{ $user['picture'] }}" alt="">
                    </div>
                    <h2>{{ $user['name'] }}</h2>
                </div>
                <?php
                switch ($user['gender']) {
                    case 'male':
                        $gender = 'male';
                        break;
                    case 'female':
                        $gender = 'female';
                        break;
                    default:
                        $gender = 'help';
                        break;
                }
                ?>
                <img src="https://img.icons8.com/office/32/null/{{ $gender }}.png"/>
            </div>
            @if (Auth::check())
            <hr>
                <form name="post_form" class="w-75 mx-auto p-5 py-0" action="{{ route('api.make_post') }}">
                    <div class="input-group d-flex justify-content-center">
                        <textarea class="form-control" name="message" id="post_message"></textarea>
                    </div>
                    <div class="d-flex justify-content-end p-3">
                        <input type="submit" class="btn btn-primary" value="Submit">
                    </div>
                </form>
            @endif
            <hr>
            <div name="feed-list" class="w-75 mx-auto">
                <div name="list-post">
                    <?php
                    $postController = new PostController();

                    foreach ($postController->getPostsFromUser($user['id']) as $key => $value) {
                        ?>
                    @include('components.post')
                    <?php
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</body>

</html>
