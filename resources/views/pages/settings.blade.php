<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;

$userController = new UserController();
$user = $userController->GetUserByName(Auth::user()->name);
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
    <script defer>
        $('form[name="change_password"]').submit((event) => {
            event.preventDefault();
            formInputs = $(this).serializeArray().reduce((obj, item) => (obj[item.name] = item.value, obj), {});
            $.ajax({
                url: '{{ route('api.change_password') }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: JSON.stringify(formInputs),
                contentType: 'application/json',
                success: function(data) {
                    console.log(data);
                    data.type === 'redirect' && (document.location = data.redirect);
                },
                error: function(error) {
                    console.log(error);
                }
            })
        })
    </script>
</head>

<body>
    <div class="d-flex">
        @include('components/header')
        <div class="w-75 mx-auto d-flex flex-column align-content-center" style="margin-left: 300px !important;">
            <div class="align-items-end m-3">
                <h3>Picture</h3>
                <div class="d-flex flex-column w-50 my-5">
                    <img src="{{ $user['picture'] }}" class="w-25" alt="">
                    <label for="profile_picture">
                        <h5>Change profile_picture</h5>
                    </label>
                    <input type="file" name="profile_picture" id="">
                </div>
                <br>
                <hr>
                <h3>Password</h3>
                <form action="" name="change_password" class="d-flex flex-column w-50 mx-auto my-5">
                    <h5>Change Password</h5>
                    <div class="form-group">
                        <label for="old_password">Old password</label>
                        <input type="password" class="form-control" id="old_password">
                    </div>
                    <div class="form-group">
                        <label for="new_password">New password</label>
                        <input type="password" class="form-control" id="new_password">
                    </div>
                    <div class="form-group">
                        <label for="confirm_new_password">Confirm new password</label>
                        <input type="password" class="form-control" id="confirm_new_password">
                    </div>
                    <input class="btn btn-primary mt-5" type="submit" value="Change password">
                </form>
                <hr>

            </div>
        </div>
    </div>
</body>

</html>
