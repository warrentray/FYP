<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validate Email Token </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    @extends('sidebar.customer')
    @section('navbar')
    <div class="container d-flex flex-column">
        <div class="row align-items-center justify-content-center min-vh-100">
            <div class="col-12 col-md-8 col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div>
                            <p class="text-center text-success" style="font-size: 5.5rem;"><i
                                    class="fa-solid fa-envelope-circle-check"></i></p>
                            <form action="/resetPassword" class="auth-form" method="POST">
                                @csrf
                                <p class="text-center text-center h5 ">Please check your email </p>
                                <p class="text-muted text-center">We've sent a code to <b>{{ $email }}</b>.</p>
                                <input type="hidden" name="id" value="{{ $id }}">

                                {{-- <div class="mb-3">
                                    <label for="email" class="form-label">Verification Code</label>
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <input type="text" class="form-control" placeholder="Verification Code"
                                        name="token">
                                    @error('token')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3 d-grid">
                                    <button type="submit" class="btn btn-primary">Confirm</button>
                                </div> --}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
@endsection