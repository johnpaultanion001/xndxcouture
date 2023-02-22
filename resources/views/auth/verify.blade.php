@extends('../layouts.site')
@section('sub-title','Verify Email')

@section('navbar')
    @include('../partials.site.navbar')
@endsection

@section('content')
<div class="main main-raised">
    <div class="profile-content">
       <div class="container">
            <div class="row">
            <div class="col-md-6 ml-auto mr-auto">
                <div class="profile">
                <br><br><br>
                
                </div>
            </div>
            </div>
        
            <div class="row">
                <div class="col-lg-6 col-md-6 ml-auto mr-auto">
                    <div class="card card-login">
                            
                        <form method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                                <div class="card-header card-header-primary text-center">
                                    <h4 class="card-title">Verify Your Email Address</h4>
                                    @if (session('resent'))
                                    <div class="alert alert-success" role="alert">
                                    {{ __('A fresh verification link has been sent to your email address.') }}
                                    </div>
                                    @endif
                                </div>

                            <div class="card-footer text-center">
                                <button type="submit" class="btn btn-primary">{{ __('click here to request another') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 
@endsection


@section('footer')
    @include('../partials.site.footer')
@endsection


@section('script')
<script> 
// script
</script>
@endsection
