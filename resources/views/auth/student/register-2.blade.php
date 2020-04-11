@include('includes.errors.custom')
<!DOCTYPE html>
<html lang="en">
<head>
	<title>{{ config('app.name','Patient Flow System')}}</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="{!! asset('login-page/Login_v1/images/icons/favicon.ico') !!}"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{!! asset('login-page/Login_v1/vendor/bootstrap/css/bootstrap.min.css') !!}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{!! asset('login-page/Login_v1/fonts/font-awesome-4.7.0/css/font-awesome.min.css') !!}">
<!--===============================================================================================-->
	<link rel="stylesheet') !!}" type="text/css" href="{! asset('login-page/Login_v1/vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{!! asset('login-page/Login_v1/vendor/css-hamburgers/hamburgers.min.css') !!}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{!! asset('login-page/Login_v1/vendor/select2/select2.min.css') !!}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{!! asset('login-page/Login_v1/css/util.css') !!}">
	<link rel="stylesheet" type="text/css" href="{!! asset('login-page/Login_v1/css/main.css') !!}">
<!--===============================================================================================-->
</head>
<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
                    <img src="{!! asset('login-page/Login_v1/images/logo/MMUST.jpg" alt="IMG') !!}"><br>
                    {{ config('app.name')}}
				</div>

                <form class="login100-form validate-form" method="post" action="{{ route('student.register') }}">
                    {{ csrf_field() }}
					<span class="login100-form-title">
						{{ __('STUDENT REGISTRATION') }}
					</span>
                    <div class="wrap-input100 validate-input $errors->has('reg_number')? 'has-error':''">
                        <input class="input100 @error('reg_number') is-invalid @enderror" name="reg_number" value="{{ old('reg_number') }}" required autocomplete="reg_number" autofocus type="text" placeholder="Reg No/ Adm">
                                @error('reg_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('reg_number') }}</strong>
                                    </span>
                                @enderror
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
                    </div>
					<div class="wrap-input100 validate-input $errors->has('email')? 'has-error':''">
                        <input class="input100 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus type="email" placeholder="Email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @enderror
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>
					<div class="wrap-input100 validate-input">
                        <input class="input100 @error('password') is-invalid @enderror" name="password" required autocomplete="password" type="password" placeholder="Password" >
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
                    <div class="wrap-input100 validate-input">
                        <input class="input100 @error('confirm_password') is-invalid @enderror" name="confirm_password" required autocomplete="confirm_password" type="password" placeholder="Confirm Password" >
                            @error('confirm_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							{{ __('Register') }}
						</button>
					</div>
					 <div class="text-center p-t-5">
						<a class="txt2" href="{{ route('student.login') }}">
							Login Here
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
<!--===============================================================================================-->
	<script src="{!! asset('login-page/Login_v1/vendor/jquery/jquery-3.2.1.min.js') !!}"></script>
<!--===============================================================================================-->
	<script src="{!! asset('login-page/Login_v1/vendor/bootstrap/js/popper.js') !!}"></script>
	<script src="{!! asset('login-page/Login_v1/vendor/bootstrap/js/bootstrap.min.js') !!}"></script>
<!--===============================================================================================-->
	<script src="{!! asset('login-page/Login_v1/vendor/select2/select2.min.js') !!}"></script>
<!--===============================================================================================-->
	<script src="{!! asset('login-page/Login_v1/vendor/tilt/tilt.jquery.min.js') !!}"></script>
	<script>
		$('.js-tilt').tilt({
			scale: 1.1
		});
	</script>
<!--=============================================================================================== -->
	<script src="{!! asset('login-page/Login_v1/js/main.js') !!}"></script>

</body>
</html>
