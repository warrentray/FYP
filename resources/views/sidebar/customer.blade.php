<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <style>
        .navbar {
            padding: 0rem;
        }

        div.container-fluid {
            background-color: #FEBE58;
            height: 100px;
        }

        a#logo {
            color: limegreen;
            margin-left: 3%;
        }

        b#logo {
            color: black;
            margin-left: 2%;
        }

        div#navbarNav {
            color: black;
            font-size: 18px;
            margin-left: 10%;
        }

        li.nav-item {
            padding-left: 10%;
            font-weight: bold;
        }

        li.nav-item a {
            color: black;
            font-size: 20px;
            border-radius: 15px;
        }

        li.nav-item a:hover {
            color: white;
            background-color: black;
            border-radius: 20px;
            transition: 0.7s;
        }

        a#user {
            margin-left: auto;
            /* Move user to the right */
            margin-right: 3%;
            /* Add some right margin */
            margin-top: 3%;
            display: flex;
            align-items: center;
            /* Align items vertically */
            color: black;
            font-size: 18px;
        }

        a#logout {
            margin-left: 1%;
            margin-top: 3%;
            color: black;
            font-size: 18px;
        }

        a#user:hover,
        a#logout:hover {
            color: white;
            background-color: black;
            border-radius: 25px;
            transition: 0.7s;
        }

        .user-info {
            margin-left: 10px;
            /* Add some left margin to separate image and name */
        }

        .img-profile {
            width: 30px;
            /* Adjust the width as needed */
            height: 30px;
            /* Adjust the height as needed */
            border-radius: 50%;
            margin-right: 10px;
            /* Add some right margin */
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a id="logo" class="navbar-brand" href="#">
                <i class="fa-solid fa-gas-pump fa-2xl"></i>
                <b id="logo">KP Station</b>
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">Fuel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Feedback</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Membership</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">FAQ</a>
                    </li>
                    <div class="collapse navbar-collapse " id="navbarNav">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item" style="padding-left:0 ">
                                <?php $customer = session('customer'); ?>

                                @if($customer)
                                <a id="user" class="navbar-brand" href="#">
                                    <img class=" img-profile rounded-circle"
                                        src="{{asset('admin/img/undraw_profile_2.svg')}}" alt="Profile Image">
                                    <div class="user-info">{{ $customer['name'] }}</div>
                                </a>
                            </li>
                            <li class="nav-item" style="padding-left:10">

                                <a id="logout" class="navbar-brand" href="{{ route('logout') }}">
                                    <i class="fa-solid fa-arrow-right-from-bracket fa-xl"></i> Logout
                                </a>
                            </li>
                            @else

                            <li class="nav-item" style="padding-left:4; margin-left:4px ">
                                <a id="user" class="navbar-brand"
                                    style="padding-left:4; margin-left:5%; flex-direction: row-reverse;  ">
                                    Guest
                                    <img class="img-profile rounded-circle"
                                        src="{{asset('admin/img/undraw_profile_2.svg')}}" alt="Guest Image">
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
            </div>
    </nav>

    <main class="py-4">
        @yield('navbar')
    </main>

    <!-- Include Bootstrap and FontAwesome JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>