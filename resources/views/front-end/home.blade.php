@extends('front-end.layout')

@section('content')

	
<div class="main">
	<div class="owl-carousel banner-slider nav-slider">
		<section class="banner" style=" background-image: url('assets/front-end/images/banner3.jpg');">
			<!-- <div class="container">
				<div>
					<h1 class="banner-title">Gift for your skin</h1>
					<p >Aliquip fugiat ipsum nostrud ex et eu incididunt quis minim dolore excepteur voluptate</p>
					<div>
						<a href="" class="link">Shop Now</a>
					</div>
				</div>
			</div> -->
		</section>
		
	</div>

	<!-- <section>
		<a href="{{url('purchase_history')}}" target="_blank">Purchase-history</a><br>
		<a href="{{url('product')}}" target="_blank">product</a><br>
		<a href="{{url('order_reviews')}}" target="_blank">order_reviews</a><br>
		<a href="{{url('all-products')}}"  target="_blank">products</a>
	</section> -->
	<section class="section product-section">
		<div class="container">
			<div class="row justify-content-center ">
				<div class="product-head">
					<h2 class="section-title">Our Products</h2>
					
					<span class="view-all"><a href="{{url('/products')}}">View All</a></span>
				</div>
			</div>
			<div ng-controller="homeCtrl" class="ng-cloak">
				<div class="row">
					<div ng-repeat="products in products_data" class="col-md-3 col-4">
						@include('front-end.inc.product')
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- <section class="section event">
		<div class="container ">
			<div class=" row justify-content-center">
				<h2 class="section-title">Event promotion</h2>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="image-div image-div1">
						<div>
							<h3>Relaxing & <br>Pampering</h3>
							<p>Pariatur ad nisi ex tempor ea</p>
							<a href="" class="link event-btn">Explore</a>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="image-div image-div2">
						<h3>Smooth & <br>Bright Skin</h3>
						<p>Pariatur ad nisi ex tempor ea</p>
						<a href="" class="link event-btn">Explore</a>
					</div>
				</div>
			</div>
		</div>
	</section> -->
	<section class="event2 section">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-6">
					<div class="image">
						<img src="{{url('/assets/front-end/images/img6.jpg')}}">
						<div class="inner-div">
							<h3>Smooth & <br>Bright Skin</h3>
							<p>Pariatur ad nisi ex tempor ea</p>
							<a href="" class="link event-btn">Explore</a>
						</div>
					</div>
					
				</div>
				<div class="col-md-6 col-6">
					<div class="image">
						<img src="{{url('/assets/front-end/images/img7.jpg')}}">
						<div class="inner-div">
							<h3>Smooth & <br>Bright Skin</h3>
							<p>Pariatur ad nisi ex tempor ea</p>
							<a href="" class="link event-btn">Explore</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="section our-story">
		<div class="container">
			<div class="row justify-content-center">
				<h2 class="section-title">Our Story</h2>
			</div>
		</div>
		<div class="story-banner">
		</div>
	</section>
	<section class="whats-new section" >
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<div class="text-div">
						<h2 class="section-title text-start">Read what’s new</h2>
						<p>Sint consequat in ipsum irure adipisicing dolore culpa incididunt. Veniam elit magna anim ipsum eiusmod eu</p>
						<!-- <div class="arrow">
							<a href="" class="link white">Explore More</a>
						</div> -->
					</div>
				</div>
				<div class="col-md-8">
					<div class="owl-carousel whats-new-slider  nav-slider">
						<?php for ($i=0; $i <6 ; $i++) {  ?>
						<div class="item">
							<div class="image-box">
								<div>
									<img src="{{url('/assets/front-end/images/img8.jpg')}}">
								</div>
								<div class="content">
									<p>Anim sint Lorem excepteur commodo </p>
									<span>oct 12, 2022</span>
								</div>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="section instagram">
		<div class="container">
			<div class="row justify-content-center">
				<h2 class="section-title insta-head">Instagram</h2>
				<p class="text-center">@yourinstagram_offical</p>
			</div>
			<div class="row">
				<div class="grid-wrapper">
					<div class="grid-item">
						<img src="{{url('/assets/front-end/images/img10.jpg')}}">
					</div>
					<div class="grid-item">
						<img src="{{url('/assets/front-end/images/img11.jpg')}}">
					</div>
					<div class="grid-item">
						<img src="{{url('/assets/front-end/images/img13.jpg')}}">
					</div>
					<div class="grid-item">
						<img src="{{url('/assets/front-end/images/img10.jpg')}}">
					</div>
					<div class="grid-item">
						<img src="{{url('/assets/front-end/images/img11.jpg')}}">
					</div>
					<div class="grid-item">
						<img src="{{url('/assets/front-end/images/img13.jpg')}}">
					</div>
					<div class="grid-item">
						<img src="{{url('/assets/front-end/images/img10.jpg')}}">
					</div>
					<div class="grid-item">
						<img src="{{url('/assets/front-end/images/img11.jpg')}}">
					</div>
					<div class="grid-item">
						<img src="{{url('/assets/front-end/images/img11.jpg')}}">
					</div>
					<div class="grid-item">
						<img src="{{url('/assets/front-end/images/img13.jpg')}}">
					</div>
					<div class="grid-item">
						<img src="{{url('/assets/front-end/images/img10.jpg')}}">
					</div>
					<div class="grid-item">
						<img src="{{url('/assets/front-end/images/img11.jpg')}}">
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="clients section">
		<div class="container">
			<!-- <div class="row justify-content-center">
				<h2 class="section-title text-center">Clients</h2>
			</div> -->
			<div>
				<div class="owl-carousel clients-slider ">
					<div class="item">
						<img src="{{url('assets/front-end/images/logo.png')}}">
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="section facilities">
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<div class="items">
						<div>
							<span class="image"><img src="{{url('assets/front-end/images/delivery-truck.png')}}"></span>
						</div>
						<div>
							<span class="heading">FREE DELIVERY</span>
							<span>When odering from $500</span>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="items">
						<div>
							<span class="image"><img src="{{url('assets/front-end/images/delivery-truck.png')}}"></span>
						</div>
						<div>
							<span class="heading">FREE DELIVERY</span>
							<span>When odering from $500</span>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="items">
						<div>
							<span class="image"><img src="{{url('assets/front-end/images/delivery-truck.png')}}"></span>
						</div>
						<div>
							<span class="heading">FREE DELIVERY</span>
							<span>When odering from $500</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>



@endsection
 
