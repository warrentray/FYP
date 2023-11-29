<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
    integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

<body>
    @extends('sidebar.customer')
    @section('navbar')
    <div class="container">
        <div class="row">
            <div class="col-md-5 mx-auto">
                <div id="first" class="border p-4">
                    <div class="myform form">
                        <div class="col-md-12 text-center">
                            <h2><b>Sign Up</b></h2>
                            <h6>Create your account to get full access</h6>
                        </div>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Full Name</label>
                                <input type="text" name="fullname"
                                    class="form-control  @error('fullname') is-invalid @enderror" id=" fullname"
                                    aria-describedby=" " placeholder="Enter full name">
                                @error('fullname')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" id="email"
                                    aria-describedby="emailHelp" placeholder="Enter email">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label for="exampleInputPassword" class="mr-3">Password</label>
                                    </div>
                                    <div class="col-auto">
                                        <input type="checkbox" class="mr-2 " id="showPassword" onclick="myFunction()">
                                        <label class="form-check-label" for="showPassword">Show Password</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="password" name="Password"
                                    class="form-control  @error('Password') is-invalid @enderror" id="Password"
                                    aria-describedby="" placeholder="Enter password">
                                @error('Password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="Confirm Password">Confirm Password</label>
                                <input type="Confirm Password" name="Confirm Password" id="Confirm Password"
                                    class="form-control @error('CPassword') is-invalid @enderror"
                                    aria-describedby=" " placeholder="Enter confirm password">
                                @error('Confirm Password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleReferralCode">Referral Code</label>
                                <input type="Rcode" name="Rcode" id="Rcode" class="form-control" aria-describedby=" "
                                    placeholder="Enter referral code">

                                <p style="font-size: 12px"># Get 100 Bonus Points with Every Successful Referral</p>
                            </div>
                            <div class="col-md-8 text-center mb-1 mx-auto">
                                <button type="submit" class=" btn btn-block mybtn btn-success  tx-tfm">Sign Up</button>
                            </div>
                            <div class="col-md-12 px-1">
                                <div class="form-group">

                                    <p class="py-4">Already have an account? <a href="{{ route('login') }}" id="signup"
                                            style="color:red;">Login</a> here</p>
                                </div>
                            </div>
                    </div>
                    {{-- </form> --}}
                </div>
            </div>
        </div>
    </div>
</body>
<script src="{{ asset('login.js') }}"></script>
<script src="{{ asset('login.css') }}"></script>
<script>
    function myFunction() {
      var x = document.getElementById("Password");
      var y = document.getElementById("Confirm Password");
      if (x.type === "password") {
        x.type = "text";
        y.type = "text";
      } else {
        x.type = "password";
        y.type = "password";
      }
    }
</script>
@endsection