<meta name='viewport' content='width=device-width, initial-scale=1'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
<ul class="navbar-nav bg-warning   sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon  ">
            <i class='fas fa-gas-pump text-dark' style='font-size:36px'></i>
        </div>
        <div class="sidebar-brand-text mx-3 text-dark ">KP Station </div>
    </a>

    <!-- Divider -->
    <hr class=" sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="index.html">
            <i class="fas fa-fw fa-tachometer-alt text-dark"></i>
            <span class=" text-dark">Dashboard</span></a>
    </li>

    <!-- Divider -->

    <div class="dropdown-divider"></div>
    <!-- Heading -->
    <div class="sidebar-heading text-dark ">
        Management Module
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" bg-dark href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog text-dark"></i>
            <span class=" text-dark">Station Management</span>
        </a>
        <div id="collapseTwo" class="collapse text-dark" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded   text-dark ">
                <h6 class="collapse-header">Station </h6>
                <a class="collapse-item" href=" ">Station Detail</a>
                <a class="collapse-item" href=" "> </a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fa fa-line-chart  text-dark"></i>
            <span class=" text-dark">Report and Analytics Management</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Report and Analytics:</h6>
                <a class="collapse-item" href=" "> View Report</a>
                <a class="collapse-item" href=" "> Create Report</a>
                <a class="collapse-item" href=" "> Create Report</a>
            </div>
        </div>
    </li>




    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
            aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder text-dark"></i>
            <span class=" text-dark">Payroll Management</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"> </h6>
                <a class="collapse-item" href="{{ route('DashboardPayslip') }}">Dashboard payslip</a>
                <a class="collapse-item" href="{{ route('viewStock') }}">Upload Payslip </a>
                <a class="collapse-item" href="{{ route('viewStock') }}">Delete Payslip</a>

            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true"
            aria-controls="collapseThree">
            <i class="fas fa-comment-dots	 text-dark"></i>
            <span class=" text-dark">Feedback and Rating Management</span>
        </a>
        <div id="collapseThree" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"> </h6>
                <a class="collapse-item" href=" ">View Feedback & Rating </a>
                <a class="collapse-item" href=" ">Create Feedback & Rating </a>
                <a class="collapse-item" href=" ">Delete Feedback & Rating</a>
                <a class="collapse-item" href=" ">Update Feedback & Rating</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true"
            aria-controls="collapseFour">
            <i class="fa fa-trophy text-dark" aria-hidden="true"></i>
            <span class=" text-dark">Lucky Draw & Chop Management</span>
        </a>
        <div id="collapseFour" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"> </h6>
                <a class="collapse-item" href=" ">Create Lucky Draw</a>
                <a class="collapse-item" href=" ">Display ChopChop </a>
                <a class="collapse-item" href=" ">Delete Lucky Draw</a>
                <a class="collapse-item" href=" ">Update Lucky Draw</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="true"
            aria-controls="collapseSeven">
            <i class="fas fa-award text-dark" aria-hidden="true"></i>
            <span class=" text-dark">Reward Management</span>
        </a>
        <div id="collapseSeven" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"> </h6>
                <a class="collapse-item" href=" ">Create Reward</a>
                <a class="collapse-item" href=" ">Display Reward </a>
                <a class="collapse-item" href=" ">Delete Reward</a>
                <a class="collapse-item" href=" ">Update Reward</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true"
            aria-controls="collapseFive">
            <i class="far fa-id-badge	 text-dark" aria-hidden="true"></i>
            <span class=" text-dark">Staff Management</span>
        </a>
        <div id="collapseFive" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"> </h6>
                <a class="collapse-item" href="  {{ route('manageStaff') }}">Dashboard Staff</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEight" aria-expanded="true"
            aria-controls="collapseEight">
            <img width="10.2" height="13.6" src="https://img.icons8.com/ios/50/leave.png" alt="leave" />
            <span class=" text-dark">Leave Management</span>
        </a>
        <div id="collapseEight" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"> </h6>
                <a class="collapse-item" href="{{ route('dashApply') }}">Dashboard Leave</a>

            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseNine" aria-expanded="true"
            aria-controls="collapseNine">
            <img width="20.2" height="20.6 " src="https://img.icons8.com/windows/32/oil-transportation.png"
                alt="oil-transportation" />
            <span class=" text-dark">Stock Management</span>
        </a>
        <div id="collapseNine" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"> </h6>
                <a class="collapse-item" href=" {{ route('petrolDetail') }}">Dashboard Petrol</a>
                <a class="collapse-item" href="{{ route('viewStock') }}">Dashboard Stock</a>

            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTen" aria-expanded="true"
            aria-controls="collapseTen">
            <img width="20" height="20" src="https://img.icons8.com/dotty/80/training.png" alt="training" />
            <span class=" text-dark">Training Management</span>
        </a>
        <div id="collapseTen" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"> </h6>
                <a class="collapse-item" href=" ">Create Training</a>
                <a class="collapse-item" href=" ">Display Training </a>
                <a class="collapse-item" href=" ">Delete Training</a>
                <a class="collapse-item" href=" ">Update Training</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#logoutModal" aria-expanded="true"
            aria-controls="collapse11">

            <i class="fa fa-sign-out  text-dark" style="font-size:20px"></i>
            <span class=" text-dark">Log Out</span>

        </a>

        <div id="logoutModal" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="nav-link text-dark" href="{{ route('logout') }}">Log Out</a>
            </div>
        </div>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->


</ul>