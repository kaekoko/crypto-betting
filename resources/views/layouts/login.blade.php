<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="../img/lucky8.png" />

	{{-- <link rel="canonical" href="https://demo-basic.adminkit.io/pages-sign-in.html" /> --}}

	<title>Sign In | Lucky 8</title>

	<link href="css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
	<main class="d-flex w-100">
		@yield('content')
	</main>
	<style>
		body{
			background-image: url('https://i.pinimg.com/236x/f1/17/4d/f1174d7a278b15dfecc1aa99548ae7e1.jpg');
		}

		.img-card{
			margin-top: 10% !important;
		}

		/* .img{
			background: #fffc00;
			background: -webkit-linear-gradient(to right, #ecca6e, #a0722b); 
			background: linear-gradient(to right, #ecca6e, #a0722b) !important;
		} */

		.logincard {
			background: #fffc00;
			background: -webkit-linear-gradient(to right, #ecca6e, #a0722b); 
			background: linear-gradient(to right, #ecca6e, #a0722b) !important;
			border: none !important;
			border-radius: 25px;
			margin-top: 30% !important;
			-webkit-transform-style: preserve-3d; 
			box-shadow: 0 0 1px rgba(255,255,255,0);
			transform: perspective(400px) rotateY(-4deg);
		}
		.form-label, .form-check-label{
			color: #000 !important;
			font-family: 'PT Serif', serif;
			letter-spacing: 2px	
		}
		.form-control:focus{
			box-shadow: none !important;
			border: none !important;
			border-radius: 25px;
			transition    : all 0.5s ease-in-out; 
			-o-transition       : all 0.5s ease-in-out;
			-moz-transition     : all 0.5s ease-in-out;
			-webkit-transition  : all 0.5s ease-in-out;
		}

		.form-control{
			border: none !important;
			/* border: 4px solid rgb(0,0,0,0.7) !important; */
		}

		::placeholder{
			font-family: 'PT Serif', serif;
			letter-spacing: 2px;
		}

		.lucky-btn{
			font-family: 'PT Serif', serif;
			font-weight: bold;
			box-shadow: 2px 2px 5px rgb(0,0,0,0.7) !important;
			background: #494a4b !important;  /* fallback for old browsers */
			color: #fff !important;
			border-color: rgb(0,0,0,0.7) !important;
		
		}

		.lucky-btn:focus{
			box-shadow: none !important;
		}

		.lucky-btn:hover{
			color: rgb(0,0,0,0.7) !important;
			background: #fffc00;  /* fallback for old browsers */
			letter-spacing: 2px;
			border-radius: 25px;
			background: -webkit-linear-gradient(to right, #ecca6e, #a0722b); 
			background: linear-gradient(to right, #ecca6e, #a0722b) !important; 
			transition    : all 0.5s ease-in-out; 
			-o-transition       : all 0.5s ease-in-out;
			-moz-transition     : all 0.5s ease-in-out;
		-webkit-transition  : all 0.5s ease-in-out;
		}

	</style>
	<script src="js/app.js"></script>
</body>
</html>