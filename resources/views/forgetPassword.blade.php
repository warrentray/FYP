<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Forgot Password</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">


<body>

    @extends('sidebar.customer')
    @section('navbar')
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    <div class="container d-flex flex-column">
        <div class="row align-items-center justify-content-center
          min-vh-100">
            <div class="col-12 col-md-8 col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="mb-4">
                            <h5>Forget Password?</h5>
                            <p class="mb-2">Enter your registered email ID to reset the password
                            </p>
                        </div>

                        <form method="POST" action="/verifyEmail">

                            @csrf
                            @method('POST')
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                {{-- <input type="hidden" name="id" value="{{ $id }}"> --}}
                                <input type="text" @error('email') is-invalid @enderror" id="email" class="form-control"
                                    name="email" required autofocus>
                                @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="mb-3 d-grid">
                                <button type="submit" class="btn btn-primary">
                                    Reset Password
                                </button>
                            </div>
                            <div class="col-md-12 px-1">
                                <div class="form-group">

                                    <p class="py-4">Already have an account? <a href="{{ route('login') }}" id="signup"
                                            style="color:red;">Login</a> here</p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection

</html>