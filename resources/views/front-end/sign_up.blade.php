@extends('front-end.layout')

@section('content')

<div class="login_form">
	<<div class="container">
		<div class="row" style="display: flex;justify-content: center;align-items: center;width:100%">
			<div class="col-md-6">
				<div class="content_div">
					 <div class="text-center">
                        <h2 class="text-center">Sign Up</h2>
                    </div>

                    @if(Session::has('failure'))
                        <div class="alert alert-danger" style="margin-top: 10px;">
                            <i class="fa fa-ban-circle"></i><strong>Failure!</strong> {{Session::get('failure')}}
                        </div>
                    @endif

                    @if(Session::has('success'))
                        <div class="alert alert-success">
                            <i class="fa fa-ban-circle"></i><strong>success!</strong> {{Session::get('success')}}
                        </div>
                    @endif
                     {{ Form::open(array('url' => '/postSignUp','class' => 'login-form',"method"=>"POST", "autocomplete"=>"off")) }}
                    <div class="row">
                    	<div class="col-md-6">
                    		 <div class="form-group">
                            <label>First Name</label>
                            {{Form::text('first_name','',["class"=>"form-control placeholder-no-fix","autocomplete"=>"off","required"=>"true"])}}
                        </div>
                    	</div>
                    	<div class="col-md-6">
                    		 <div class="form-group">
                            <label>Last Name</label>
                            {{Form::text('last_name','',["class"=>"form-control placeholder-no-fix","autocomplete"=>"off"])}}
                        </div>
                    	</div>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        {{Form::email('email','',["class"=>"form-control placeholder-no-fix","autocomplete"=>"off","required"=>"true"])}}
                    </div>
                     <div class="form-group">
                        <label>Redeem Code</label>
                        {{Form::text('code','',["class"=>"form-control placeholder-no-fix","autocomplete"=>"off","required"=>"true","placeholder" => ""])}}
                    </div>
                    <div style="margin-top: 10px;">
					    <input type="checkbox" name="termAndCondition"  style="accent-color: #DE3163;" required="required">&nbsp; By Signing up, I agree with the <a href="https://www.hdfcbank.com/personal/useful-links/terms-and-conditions" target="_blank">Terms & Conditions</a> and <a href="https://www.hdfcbank.com/personal/useful-links/privacy" target="_blank">Privacy Policy</a>

 					</div>
 					<div class="mt-4">
                        <button type="Submit" class="btn_submit">Submit</button>
                    </div>
                    <div class="sign_with">
                        <p>Already have an account?<a href="{{url('/login')}}">Login</a></p>
                    </div>
				</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>


@endsection