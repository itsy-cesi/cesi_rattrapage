<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    @include('imports/cdns')
    <script src="{{ URL::asset('js/register_form.js') }}" defer></script>
    <script src="{{ URL::asset('js/post_action.js') }}" defer></script>
</head>

<body>
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home"
                type="button" role="tab" aria-controls="pills-home" aria-selected="true">Login</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile"
                type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Register</button>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <form id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0" name="login_form"
            action="{{ route('api.login') }}" class="p-4 tab-pane fade show active">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <!-- Include Laravel's CSRF token -->

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="form-control">
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                <label for="remember" class="form-check-label">Remember me</label>
            </div>
            <div class="alert alert-danger d-none" role="alert"></div>
            <button type="submit" class="btn btn-primary">Submit</button>

        </form>
        <form role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0" id="pills-profile" name="register_form"
            action="{{ route('api.register') }}" class="p-4 tab-pane fade" novalidate>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <!-- Include Laravel's CSRF token -->

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" class="form-control">
                <div class="invalid-feedback" name="valid-name"></div>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control">
                <div class="invalid-feedback" name="valid-email"></div>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control">
                <div class="invalid-feedback" name="valid-password"></div>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                <div class="invalid-feedback" name="valid-password_confirmation"></div>
            </div>

            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" class="form-control">
                <div class="invalid-feedback" name="valid-dob"></div>
            </div>

            <div class="form-group">
                <label for="gender">Gender:</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="gender" value="male">
                    <label class="form-check-label" for="male">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="gender" value="female">
                    <label class="form-check-label" for="female">Female</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="gender" value="other">
                    <label class="form-check-label" for="other">Other</label>
                </div>
                <div class="invalid-feedback" name="valid-gender"></div>
            </div>
            <div class="alert alert-danger d-none" role="alert"></div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>
</body>

</html>
