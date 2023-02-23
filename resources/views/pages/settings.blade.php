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

</head>

<body>
    <div class="d-flex">
        @include('components/header')
        <div class="w-75 mx-auto d-flex flex-column align-content-center" style="margin-left: 300px !important;">
            <div class="align-items-end m-3">
                <h3>Password</h3>
                <form action="" name="change_password" class="d-flex flex-column w-50 mx-auto my-5">
                    <h5>Change Password</h5>
                    <div class="form-group">
                        <label for="old_password">Old password</label>
                        <input type="password" class="form-control" name="old_password">
                        <div class="invalid-feedback" name="valid-old_password"></div>
                    </div>
                    <div class="form-group">
                        <label for="new_password">New password</label>
                        <input type="password" class="form-control" name="new_password">
                        <div class="invalid-feedback" name="valid-new_password"></div>
                    </div>
                    <div class="form-group">
                        <label for="new_password_confirmation">Confirm new password</label>
                        <input type="password" class="form-control" name="new_password_confirmation">
                        <div class="invalid-feedback" name="valid-new_password_confirmation"></div>
                    </div>
                    <input class="btn btn-primary mt-5" type="submit" value="Change password">
                </form>
                <hr>

            </div>
        </div>
    </div>
</body>

</html>
<script defer>
    $('form[name="change_password"]').submit((event) => {
        event.preventDefault();

        const form = $('form[name="change_password"]');
        formInputs = $(this).serializeArray().reduce((obj, item) => (obj[item.name] = item.value, obj), {});
        $.ajax({
            url: '{{ route('api.change_password') }}',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: JSON.stringify({
                old_password: $('input[name="old_password"]').val(),
                new_password: $('input[name="new_password"]').val(),
                new_password_confirmation: $('input[name="new_password_confirmation"]').val()
            }),
            contentType: 'application/json',
            success: function(data) {
                $(':input').removeClass('is-invalid');
                new Noty({
                        timeout:3000,
                        type:'success',
                        theme:'mint',
                        text:data.success
                    }).show();
                    $('input').val('');
            },
            statusCode:{
                422:function(xhr){
                    console.log(xhr.responseText);
                    $(':input').removeClass('is-invalid');
                    Object.entries(JSON.parse(xhr.responseText).error).forEach(([field,message])=>{
                        console.log($(form).find(`div[name="valid-${field}"]`));
                        $(form).find(`input[name="${field}"]:not([class*="is-invalid"])`).addClass('is-invalid'),
                        $(form).find(`div[name="valid-${field}"]`).html(message.join('</br>'))
                    });
                },
                401:function(xhr){
                    new Noty({
                        timeout:3000,
                        type:'error',
                        theme:'mint',
                        text:JSON.parse(xhr.responseText).error
                    }).show();
                },
                500:function(xhr){
                    console.log(xhr);
                }
            }
        })
    })
</script>
