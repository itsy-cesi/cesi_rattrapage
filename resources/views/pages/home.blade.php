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
    <script src="{{ URL::asset('js/post_action.js') }}" defer></script>
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
                        if (($value['parent'] ?? null) == null):
                        ?>
                    <div class="card mx-auto my-5" message-id="{{ $value['id'] }}" share-link="{{ route('post', $value['id']) }}">
                        <div class="card-body">
                            <h5 class="card-title d-flex justify-content-between">
                                <a href="{{ '/user/' . $value['author']['name'] }}"
                                    class="d-flex align-items-center link-dark text-decoration-none">
                                    <img src="https://robohash.org/{{ $value['author']['name'] }}.png?set=set5" alt=""
                                        width="32" height="32" class="rounded-circle me-2" />
                                    <strong>{{ $value['author']['name'] }}</strong>
                                </a>
                                @if ($value['author']['name'] == (Auth::user()->name ?? ''))
                                <div class="dropdown">
                                    <a class="btn" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                      <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                      <li><a class="dropdown-item bg-danger text-white" action="delete_post" target="{{ route('api.delete_post') }}" post_id="{{ $value['id'] }}"><i class="fa fa-trash" aria-hidden="true"></i><span class="ms-3">Delete post</span></a></li>
                                    </ul>
                                  </div>
                                @endif
                            </h5>
                            <p class="card-text">{{ $value['message'] }}</p>
                            <form action="#" method="get" type="post_action">
                                <ul class="list-unstyled d-flex w-50 ms-3">
                                    <li class="me-3">
                                        <a class="text-decoration-none {{ $value['is_liked'] ? 'text-danger': 'text-dark' }}" action="post_button" name="like">
                                            <i class="fa fa-heart" aria-hidden="true"></i>
                                            <span class="ms-2">Like</span>
                                            <span name="count_like" class="badge text-bg-secondary">{{ $value['likes'] }}</span>
                                        </a>
                                    </li>
                                    <li class="me-3">
                                        <a class="text-decoration-none text-dark" action="post_button" name="share">
                                            <i class="fa fa-share" aria-hidden="true"></i>
                                            <span class="ms-2">Share</span>
                                        </a>
                                    </li>
                                    <li class="me-3">
                                        <a class="text-decoration-none text-dark" action="post_button" name="comment">
                                            <i class="fa fa-comment" aria-hidden="true"></i>
                                            <span class="ms-2">Comment</span>
                                            <span name="count_like" class="badge text-bg-secondary">{{ $value['comments'] }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </form>
                        </div>
                    </div>
                    <?php
                    endif;
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</body>

</html>
