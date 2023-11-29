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

   @if(session('success'))
   <script>
      alert('{{ session('success') }}');
   </script>
   @endif

   @if(session('error'))
   <div class="alert alert-danger">
      {{ session('error') }}
   </div>
   @endif

   <div class="container">
      <div class="row">
         <div class="col-md-5 mx-auto py-5">
            <div id="first" class="border p-4">
               <div class="myform form ">
                  <div class="logo mb-3">
                     <div class="col-md-12 text-center">
                        <h2><b>Login</b></h2>
                        <h6>Enter Login details to get access</h6>
                     </div>
                  </div>
                  <form action="{{ route('postLogin') }}" method="POST">
                     @csrf

                     <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp"
                           placeholder="Enter email">
                        @if ($errors->has('email'))
                        <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                        @endif
                     </div>
                     <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" id="password" class="form-control"
                           placeholder="Enter Password">
                        @if ($errors->has('password'))
                        <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                        @endif
                     </div>

                     <div class="col-auto">
                        <p class="text-right"> <a href="{{ route('forgetPassword') }}" id="forgetpassword"
                              style="color:red;">Forget Password</a>
                        </p>
                     </div>
                     <div class="col-md-8 text-center   mb-1 mx-auto"">
                        <button type=" submit" class=" btn btn-block mybtn btn-success tx-tfm">Login</button>
                     </div>
                     <div class="form-group">
                        <p class="text-left">Don't have account? <a href="{{ route('register') }}" id="signup"
                              style="color:red;">Sign up</a>
                           here</p>
                     </div>

                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>

</body>
<script src="{{ asset('login.js') }}"></script>
<script src="{{ asset('login.css') }}"></script>
@endsection