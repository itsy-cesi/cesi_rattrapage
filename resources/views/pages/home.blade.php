<?php
use App\Http\Controllers\PostController;
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
    <link rel="stylesheet" href="{{ URL::asset('css/textarea.css') }}">
</head>

<body>
    <div class="d-flex">
        @include('components/header')
        <div class="w-75 mx-auto d-flex flex-column align-content-center">
            @if (Auth::check())
                <form name="post_form" class="w-75 mx-auto p-5" action="{{ route('api.make_post') }}">
                    <h4>New Post</h4>
                    <div class="input-group d-flex justify-content-center">
                        <textarea class="form-control" name="message" id="post_message"></textarea>
                    </div>
                    <div class="d-flex justify-content-end p-3">
                        <input type="submit" class="btn btn-primary" value="Submit">
                    </div>
                </form>
            @endif
            <div name="feed-list" class="w-75 mx-auto">
                <div name="new-post"></div>
                <div name="list-post">
                    <?php
                    $postController = new PostController();
                    $posts = $postController->getAllPosts();

                    foreach ($posts as $key => $value) {
                        ?>
                    <div class="card mx-auto my-5" message-id="{{ $value['id'] }}">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ '/user/' . $value['author'] }}"
                                    class="d-flex align-items-center link-dark text-decoration-none">
                                    <img src="https://robohash.org/{{ $value['author'] }}.png?set=set5" alt=""
                                        width="32" height="32" class="rounded-circle me-2" />
                                    <strong>{{ $value['author'] }}</strong>
                                </a>
                            </h5>
                            <p class="card-text">{{ $value['description'] }}</p>
                            <form action="#" method="get" type="post_action">
                                <ul class="list-unstyled d-flex w-25 justify-content-between ms-3">
                                    <li>
                                        <a action="post_button" for="like">
                                            <i class="fa fa-heart text-dark" aria-hidden="true"></i>
                                            <span class="ms-2">Like</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a action="post_button" for="share">
                                            <i class="fa fa-share text-dark" aria-hidden="true"></i>
                                            <span class="ms-2">Share</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a action="post_button" for="comment">
                                            <i class="fa fa-comment text-dark" aria-hidden="true"></i>
                                            <span class="ms-2">Comment</span>
                                        </a>
                                    </li>
                                </ul>
                            </form>
                        </div>
                    </div>
                    <?php
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</body>

</html>
