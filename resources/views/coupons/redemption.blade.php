@extends('spark::layouts.redemption')

@section('content')
<redemptions :funnel="{{$funnel}}" :validations="{{$validations}}" :coupon-bank="{{$couponBank}}" inline-template>
    <div class="container">
        <div class="app">
            <!-- START APP CONTAINER -->
            <div class="app-container">
                <div class="app-login-box">
                    <div class="app-login-box-user"><img src="{{asset('img/funnelcodes-logo.png')}}" alt="John Doe"></div>
                    
                    
                    <div v-if="!redemedCuponCode">
                        <div class="app-login-box-title">
                            <div class="title">Hurry offer expires in ..</div>
                            <div class="subtitle" style="font-size: 55px; font-weight: bolder;margin: 30px 0;">@{{countDown}}</div>
                        </div>
                        <div class="app-login-box-container">
                            @include('spark::shared.errors')
                            <form role="form" method="POST" action="/">
                                {{ csrf_field() }}
                                @foreach($validations as $key=>$validation)
                                <div class="form-group">
                                    <input type="{{$validation->field_type}}" class="form-control" id="{{$validation->field_type.'_'.$key}}" class="{{$validation->required?'1':'0'}}"  placeholder="{{$validation->name}}" >
                                    @if($validation->required)
                                    <span class="help-block">Required</span>
                                    @endif
                                </div>
                                @endforeach
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="button" @click="getCode" class="btn btn-success btn-block">Get you coupon code now</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div v-else>
                        <div class="app-login-box-title">
                            <div class="title">Coupon Code</div>
                            <div class="subtitle" style="font-size: 55px; font-weight: bolder;margin: 30px 0;">@{{redemedCuponCode}}</div>
                        </div>
                        
                    </div>


                    <div class="app-login-box-footer">
                        &copy; Funnel Codes {{date('Y')}}. All rights reserved.
                        <p><a href="{{url('/')}}"> Back to website </a></p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</redemptions>
@endsection
