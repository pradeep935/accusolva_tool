<header>
	<div class="container" >
		<div class="row">
			<div class="col-md-2 d-none d-md-block">
				<a class="logo" href="{{url('home')}}">
					<img src="{{url('/assets/front-end/images/logo.png')}}">
				</a>
			</div>
			<div class="col-md-4 col-3">
				<div class="menu">
					
				</div>
			</div>
			<div class="col-md-1 d-none d-md-block"></div>
			<div class="col-md-2 d-none d-md-block">
				<div class="chat-us">
					<!-- <div class=""><a href="tel:9878987656"><i class="fa-solid fa-phone" style="font-size: 14px;"></i>&nbsp;&nbsp;<span>9876789656</span></a></div>
					 <div>
						<span><a href="">Free Shipping</a></span>
					</div> --> 
				</div>
			</div>
			<div class="col-md-3 col-6">
				<div class="header-input">
					
					@if(Auth::id())

						<div class="user-div">
							<div class="user-box">
								<span class="image"><i class="fa-solid fa-circle-user" style="font-size:16px"></i></span>
								<span class="name">{{Auth::user()->user_name}}</span>
								<span><i class="fa-solid fa-chevron-right"></i></span>
							</div>
							<div class="logout">
								<span class="mb-10"><a href="{{url('admin/dashboard')}}">My Account</a></span><br>
								<span><a href="{{url('logout')}}">Logout</a></span>
							</div>
						</div>
					@else
						<div class="user-div">
							<a href="{{url('/')}}" class="login-btn">Login</a>&nbsp;/
							<a href="{{url('/signup')}}" class="login-btn bg-green">Signup</a>
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</header>