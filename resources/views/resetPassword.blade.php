<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bootstrap 5 Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    @extends('sidebar.customer')
    @section('navbar')
    <div class="container d-flex flex-column">
        <div class="row align-items-center justify-content-center
          min-vh-100">
            <div class="col-12 col-md-8 col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="mb-4">
                            <h5> Create your new password</h5>
                            <p class="mb-2">Set a new password. After creating the password you’ll stay logged in.
                            </p>
                        </div>
                        <form action="/reset" class="auth-form" method="POST">
                            @csrf
                            <div class="form-group py-2">
                                {{-- <input type="hidden" name="id" value="{{ $id }}"> --}}
                                <label for="exampleInputEmail1">New Password</label>
                                <input type="password" name="Password" class="form-control" id="Password"
                                    aria-describedby="" placeholder="Enter password">
                                <span class="err" style="color: red">
                                    @error('Password')
                                    {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-group py-3">

                                <label for="exampleInputEmail1">Confirm Password</label>
                                <input type="Password" name="CPassword" id="CPassword" class="form-control"
                                    aria-describedby=" " placeholder="Enter confirm password">
                                <span class="err" style="color: red">@error('CPassword')
                                    {{ $message }}
                                    @enderror </span>
                            </div>

                            <div class="mb-3 d-grid">
                                <button type="submit" class="btn btn-primary">
                                    Change Password
                                </button>
                            </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    @endsection
</body>

</html>