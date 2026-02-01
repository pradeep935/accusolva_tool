<header class="mobile-header">
	<div class="container">
		<div class="row">
			<div class="col-md-2 col-3 ">
				<div class="toggle-menu-cont ">
					<a class="mobile-toggle toggle-menu" href="javascript:;">
						<i></i>
						<i></i>
						<i></i>
				    </a>
				</div>
			</div>
			<div class="col-md-2 col-2">
				<div>
					<img src="">
				</div>
			</div>
			<div class="col-md-8 col-7">
				<div class="header-input">
					<a href="{{url('add-cart')}}" class="cart-img"> 
						<img src="{{url('/assets/front-end/images/mobile-cart.png')}}">&nbsp;&nbsp;
						<span>{{Session::get('total_cart_items')? Session::get('total_cart_items') : 0 }}</span>
					</a>
					@if(Auth::id())
						<a href="{{url('/logout')}}" class="login-btn">  Logout</a>
					
					@else
						<a href="{{url('/')}}" class="login-btn bg-green">  Login</a>/
						<a href="{{url('/')}}" class="login-btn">  Signup</a>
					@endif
				</div>
			</div>
		</div>
		<div class="mobile-menu">
			<div class="">
				<div class="item-list ">
				
					<!-- <div class="cross d-block d-md-none">
						<img src="{{url('assets/front-end/images/close.png')}}">
					</div> -->
				</div>
			</div>
			<div class="home-links">
				<ul>
					<li>
						<a href="{{url('home')}}">Home</a>
					</li>
					<li>
						<a href="{{url('about')}}">About</a>
					</li>
					<li>
						<a href="{{url('contact')}}">Contact</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</header>