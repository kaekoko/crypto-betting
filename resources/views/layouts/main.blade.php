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
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-blank.html" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

	<title>Lucky 8 | Crypto</title>

	<link href="../css_admin/app.css" rel="stylesheet">
	<link href="../css_admin/custom.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.css">
	<link href="https://fonts.googleapis.com/css2?family=Spectral+SC&display=swap" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css2?family=PT+Serif:wght@700&display=swap" rel="stylesheet">
	<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">

</head>

<body>
	<div class="wrapper">
		<input type="text" value="{{ Request::segment(1) }}" id="segment" hidden>
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="/home">
          			<span class="align-middle"><img src="../img/lucky8.png" class="img-fluid" alt=""></span>
        		</a>

				<ul class="sidebar-nav">
					<li class="sidebar-item">
						<a class="sidebar-link home" href="{{ route('home') }}">
							<i class="fa-solid fa-chart-line"></i><span class="align-middle">Dashboard</span>
            			</a>
					</li>
					<li class="sidebar-item">
						<a class="sidebar-link agent" href="{{ route('agent') }}">
							<i class="fa-solid fa-people-roof"></i><span class="align-middle">Agent</span>
            			</a>
					</li>
					<li class="sidebar-item">
						<a class="sidebar-link slips-arrange" href="{{ route('slips-arrange') }}">
							<i class="fa-solid fa-burst"></i><span class="align-middle">Bet Histories</span>
            			</a>
					</li>
					<li class="sidebar-item">
						<a class="sidebar-link lucky-number" href="{{ route('luckynumber') }}">
							<i class="fa-solid fa-burst"></i><span class="align-middle">2D Numbers</span>
            			</a>
					</li>
					<li class="sidebar-item">
						<a class="sidebar-link customers" href="{{ route('customers') }}">
							<i class="fa-solid fa-people-group"></i><span class="align-middle">Customers</span>
            			</a>
					</li>
					<li class="sidebar-item">
						<a class="sidebar-link cash" href="{{ route('cash') }}">
							<i class="fa-solid fa-arrow-down-up-across-line"></i>
							<span class="align-middle">Cash In/Out</span>
							<span class="badge bg-danger" id="cashcount"></span>
            			</a>
					</li>
					<li class="sidebar-item">
						<a class="sidebar-link notification" href="{{ route('notification') }}">
							<i class="fa-solid fa-bullhorn"></i><span class="align-middle">Notification</span>
            			</a>
					</li>
					<li class="sidebar-item">
						<a class="sidebar-link block-number" href="{{ route('blocknumber') }}">
							<i class="fa-solid fa-ban"></i><span class="align-middle">Block Number</span>
            			</a>
					</li>
					<li class="sidebar-item">
						<a class="sidebar-link payment-method" href="{{ route('payment') }}">
							<i class="fa-solid fa-money-check"></i><span class="align-middle">Payment</span>
            			</a>
					</li>
					<li class="sidebar-item">
						<a class="sidebar-link banner-support" href="{{ route('bannersupport') }}">
							<i class="fa-solid fa-money-check"></i><span class="align-middle">Page Setting</span>
            			</a>
					</li>
					<li class="sidebar-item">
						<a class="sidebar-link setting" href="{{ route('setting') }}">
							<i class="fa-solid fa-screwdriver-wrench"></i>Setting
            			</a>
					</li>
				</ul>
			</div>
		</nav>

		<div class="main">
			<input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
					<i class="hamburger align-self-center"></i>
				</a>

				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                				<i class="align-middle" data-feather="settings"></i>
							</a>
							<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
								<img src="img/avatars/avatar.jpg" class="avatar img-fluid rounded me-1" alt="Charles Hall" /> <span class="text-dark">{{ Auth::user()->name }}</span>
							</a>
							<div class="dropdown-menu dropdown-menu-end">
								<a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="pie-chart"></i> Change Password</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="{{ route('logout') }}"
								onclick="event.preventDefault();
											  document.getElementById('logout-form').submit();">
								 {{ __('Logout') }}
							 	</a>

								<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
									@csrf
								</form>							
							</div>
						</li>
					</ul>
				</div>
			</nav>

			<main class="content">
				<div class="container-fluid p-0">

					<h1 class="h3 mb-3 title-card"></h1>

					<div class="row">
						<div class="col-12">
							<div class="card" id="main-card">
								<div class="card-body">
                                        @yield('content')
								</div>
							</div>
						</div>
					</div>

				</div>
			</main>

			{{-- <footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-6 text-start">
							<p class="mb-0">
								<a class="text-muted" href="" target="_blank"><strong>Crypto Statics</strong></a> &copy;
							</p>
						</div>
					</div>
				</div>
			</footer> --}}
		</div>
	</div>
	{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css"> --}}

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>
	<script src="../js_admin/app.js"></script>
	<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
	<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
	@yield('script')
	<script>
		const firebaseConfig = {
			apiKey: "AIzaSyBzypNw6h62u-IOCnyBobMPfBVOzbeez_4",
			authDomain: "crypto-da28a.firebaseapp.com",
			databaseURL: "https://crypto-da28a-default-rtdb.asia-southeast1.firebasedatabase.app",
			projectId: "crypto-da28a",
			storageBucket: "crypto-da28a.appspot.com",
			messagingSenderId: "873556556575",
			appId: "1:873556556575:web:6dcf8f681a301bfb1bce2a",
			measurementId: "G-851JLKQ5K5"
		};

		firebase.initializeApp(firebaseConfig);
		const messaging = firebase.messaging();
		function startFCM() {
			messaging
				.requestPermission()
				.then(function () {
					return messaging.getToken()
				})
				.then(function (response) {
					console.log(response);
					$.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
					});
					$.ajax({
						url: 'store-admin-token',
						type: 'POST',
						data: {
							token: response
						},
						dataType: 'JSON',
						success: function (response) {
							// alert('Token stored.');
							console.log(response);
						},
						error: function (error) {
							alert(error);
						},
					});
				}).catch(function (error) {
					alert(error);
				});
		}
		startFCM();

		messaging.onMessage(function (payload) {
			console.log(payload);
			const type = payload.data['gcm.notification.type'];
			const title = payload.notification.title;
			const body = payload.notification.body;
			const icon = payload.notification.icon;
			const options = {
				body: payload.notification.body,
				icon: payload.notification.icon,
			};
			new Notification(title, options);
			cashset(type, title, body);
		});

		function cashset(type,topic,body){
			var cash_notifications = localStorage.getItem("cash");
			if (cash_notifications) {
				var notiarr = JSON.parse(cash_notifications);
			} else {
				var notiarr = [];
			}
			var read = 0;
			var mylist = {
				topic: topic,
				body: body,
				read: read
			};
			if (notiarr.length == 0) {

				notiarr.push({
					[type]: [mylist]
				});
			} else {
				$.each(notiarr, function(index, value) {

					$.each(value, function(i, v) {

						if (i == type) {
							var arr = v;
							arr.push(mylist);
						}
					})

				})
			}

			var myobj = JSON.stringify(notiarr);
			localStorage.setItem("cash", myobj);

			cashnoti();
		}


		function cashnoti() {
			var cashin_notifications = localStorage.getItem('cash');
			var notiarr = JSON.parse(cashin_notifications);
			var count = 0;
			$.each(notiarr, function(key, value) {

				$.each(value, function(i, v) {

					for (let k = 0; k < v.length; k++) {
						if (v[k].read == 0) {
							count++;
						}
					}
				})
			})
			$('#cashcount').html(count);
		}

		$('.cash').click(function(){
			localStorage.removeItem("cash");
		});

		$(".sidebar-link").on("mouseover", function () {
			$(this).find('i').attr('style', 'color: #ecca6e !important;');
		});
		
		$(".sidebar-link").mouseleave(function() {
			if ($(this).hasClass("active") != true) {
				$(this).find('i').attr('style', 'color: rgb(0,0,0,0.7) !important;');
			} 
		});

		var seg = $('#segment').val();
		console.log(seg);
		$('.' + seg).addClass('active');
		$('.' + seg).find('i').attr('style', 'color: #ecca6e !important;');
		var title = seg.replace("-", " ");
		$('.title-card').text(title);
	</script>
</body>

</html>