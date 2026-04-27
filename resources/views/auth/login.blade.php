<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8" />
		<title>Koperasi Pemasaran Fadillah</title>

		<!-- Site favicon -->

		<link
			rel="apple-touch-icon"
			sizes="180x180"
			href="{{env('APP_URL')}}/favicon.ico"
		/>
		<link
			rel="icon"
			type="image/png"
			sizes="32x32"
			href="{{env('APP_URL')}}/favicon.ico"
		/>
		<link
			rel="icon"
			type="image/png"
			sizes="16x16"
			href="{{env('APP_URL')}}/favicon.ico"
		/>

		<!-- Mobile Specific Metas -->
		<meta
			name="viewport"
			content="width=device-width, initial-scale=1, maximum-scale=1"
		/>

		<!-- Google Font -->
		<link
			href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
			rel="stylesheet"
		/>
		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}/assets/styles/core.css" />
		<link
			rel="stylesheet"
			type="text/css"
			href="{{env('APP_URL')}}/assets/styles/icon-font.min.css"
		/>
		<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}/assets/styles/style.css" />

		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script
			async
			src="https://www.googletagmanager.com/gtag/js?id=G-GBZ3SGGX85"
		></script>
		<script
			async
			src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2973766580778258"
			crossorigin="anonymous"
		></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag() {
				dataLayer.push(arguments);
			}
			gtag("js", new Date());

			gtag("config", "G-GBZ3SGGX85");
		</script>
		<!-- Google Tag Manager -->
		<script>
			(function (w, d, s, l, i) {
				w[l] = w[l] || [];
				w[l].push({ "gtm.start": new Date().getTime(), event: "gtm.js" });
				var f = d.getElementsByTagName(s)[0],
					j = d.createElement(s),
					dl = l != "dataLayer" ? "&l=" + l : "";
				j.async = true;
				j.src = "https://www.googletagmanager.com/gtm.js?id=" + i + dl;
				f.parentNode.insertBefore(j, f);
			})(window, document, "script", "dataLayer", "GTM-NXZMQSS");
		</script>
		<!-- End Google Tag Manager -->
	</head>
	<body class="login-page">
		<div class="login-header box-shadow">
			<div class="container-fluid d-flex justify-content-between align-items-center">
				<div class="brand-logo">
					<a href="/login">
						<img src="{{env('APP_URL')}}/img/logo_kpf.jpg" alt="" />
                        <h3 class="title" style="margin-left:15px;">Koperasi Pemasaran Fadillah</h3>
					</a>
				</div>
				<div class="brand-logo">
					<a href="/login">
						<img src="{{env('APP_URL')}}/img/logo-koperasi-indonesia.png" class="img img-responsive" alt="" style="height: 90%;"/>
					</a>
				</div>

			</div>
		</div>
		<div
			class="login-wrap d-flex align-items-center flex-wrap justify-content-center"
		>
			<div class="container">
				<div class="row align-items-center">
					<div class="col-md-6 col-lg-7">
						<img src="{{env('APP_URL')}}/assets/images/login-page-img.png" alt="" />
					</div>
					<div class="col-md-6 col-lg-5">
						<div class="login-box bg-white box-shadow border-radius-10">
							<div class="login-title">
								<h2 class="text-center text-primary">Login</h2>
							</div>
							@if (session()->has('no_roles'))
							<div class="alert alert-warning alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> {{session()->get('no_roles')}}
							</div>
							@endif
                            <form action="{{ route('auth.authenticate') }}" method="post">
                            @csrf
								<div class="input-group custom">
									<input
										type="email"
										class="form-control form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                        name="email"
										placeholder="Email"
									/>
									<div class="input-group-append custom">
										
									</div>
									@if ($errors->has('email'))
									<span class="error invalid-feedback">
										<strong>{{ $errors->first('email') }}</strong>
									</span>
									@endif
								</div>
								<div class="input-group custom">
									<input
										type="password"
										class="form-control form-control-lg {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                        name="password"
										placeholder="**********"
									/>
									<div class="input-group-append custom">
										
									</div>
									@if ($errors->has('password'))
									<span class="error invalid-feedback">
										<strong>{{ $errors->first('password') }}</strong>
									</span>
									@endif
								</div>
								<div class="row pb-30">
									<div class="col-6">
										<div class="custom-control custom-checkbox">
											<input
												type="checkbox"
												class="custom-control-input"
												id="customCheck1"
												name="remember"
											/>
											<label class="custom-control-label" for="customCheck1"
												>Remember</label
											>
										</div>
									</div>
									<div class="col-6">
										<div class="forgot-password">
											<a href="{{route('password.email.reset')}}">Forgot Password</a>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="input-group mb-0">
											<!--
											use code for form submit
											<input class="btn btn-primary btn-lg btn-block" type="submit" value="Sign In">
										-->
											<button type="submit"
												class="btn btn-primary btn-lg btn-block"
												>Sign In</button
											>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- welcome modal end -->
		<!-- js -->
		<script src="{{env('APP_URL')}}/assets/scripts/core.js"></script>
		<script src="{{env('APP_URL')}}/assets/scripts/script.min.js"></script>
		<script src="{{env('APP_URL')}}/assets/scripts/process.js"></script>
		<script src="{{env('APP_URL')}}/assets/scripts/layout-settings.js"></script>
		<!-- Google Tag Manager (noscript) -->
		<noscript
			><iframe
				src="https://www.googletagmanager.com/ns.html?id=GTM-NXZMQSS"
				height="0"
				width="0"
				style="display: none; visibility: hidden"
			></iframe
		></noscript>
		<!-- End Google Tag Manager (noscript) -->
	</body>
</html>
