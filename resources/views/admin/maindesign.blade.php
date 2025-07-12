<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Dark Bootstrap Admin </title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="all,follow">
        <!-- Bootstrap CSS-->
        <link href="admin/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome CSS-->
        <link href="admin/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- Custom Font Icons CSS-->
        <link href="admin/css/font.css" rel="stylesheet">
        <!-- Google fonts - Muli-->
        <link href="https://fonts.googleapis.com/css?family=Muli:300,400,700" rel="stylesheet">
        <!-- theme stylesheet-->
        <link id="theme-stylesheet" href="admin/css/style.default.css" rel="stylesheet">
        <!-- Custom stylesheet - for your changes-->
        <link href="admin/css/custom.css" rel="stylesheet">
        <!-- Favicon-->
        <link href="admin/img/favicon.ico" rel="shortcut icon">
        <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
    </head>

    <body>
        <header class="header">
            <nav class="navbar navbar-expand-lg">
                <div class="search-panel">
                    <div class="search-inner d-flex align-items-center justify-content-center">
                        <div class="close-btn">Close <i class="fa fa-close"></i></div>
                        <form id="searchForm" action="#">
                            <div class="form-group">
                                <input name="search" type="search" placeholder="What are you searching for...">
                                <button class="submit" type="submit">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="container-fluid d-flex align-items-center justify-content-between">
                    <div class="navbar-header">
                        <!-- Navbar Header--><a class="navbar-brand" href="index.html">
                            <div class="brand-text brand-big text-uppercase visible"><strong
                                    class="text-primary">Dark</strong><strong>Admin</strong></div>
                            <div class="brand-text brand-sm"><strong class="text-primary">D</strong><strong>A</strong>
                            </div>
                        </a>
                        <!-- Sidebar Toggle Btn-->
                        <button class="sidebar-toggle"><i class="fa fa-long-arrow-left"></i></button>
                    </div>
                    <div class="right-menu list-inline no-margin-bottom">
                        <div class="list-inline-item"><a class="search-open nav-link" href="#"><i
                                    class="icon-magnifying-glass-browser"></i></a></div>
                        <div class="list-inline-item dropdown"><a class="nav-link messages-toggle"
                                id="navbarDropdownMenuLink1" data-toggle="dropdown" href="http://example.com"
                                aria-haspopup="true" aria-expanded="false"><i class="icon-email"></i><span
                                    class="badge dashbg-1">5</span></a>
                            <div class="dropdown-menu messages" aria-labelledby="navbarDropdownMenuLink1"><a
                                    class="dropdown-item message d-flex align-items-center" href="#">
                                    <div class="profile"><img class="img-fluid" src="img/avatar-3.jpg" alt="...">
                                        <div class="status online"></div>
                                    </div>
                                    <div class="content"> <strong class="d-block">Nadia Halsey</strong><span
                                            class="d-block">lorem ipsum dolor sit amit</span><small
                                            class="date d-block">9:30am</small></div>
                                </a><a class="dropdown-item message d-flex align-items-center" href="#">
                                    <div class="profile"><img class="img-fluid" src="img/avatar-2.jpg" alt="...">
                                        <div class="status away"></div>
                                    </div>
                                    <div class="content"> <strong class="d-block">Peter Ramsy</strong><span
                                            class="d-block">lorem ipsum dolor sit amit</span><small
                                            class="date d-block">7:40am</small></div>
                                </a><a class="dropdown-item message d-flex align-items-center" href="#">
                                    <div class="profile"><img class="img-fluid" src="img/avatar-1.jpg" alt="...">
                                        <div class="status busy"></div>
                                    </div>
                                    <div class="content"> <strong class="d-block">Sam Kaheil</strong><span
                                            class="d-block">lorem ipsum dolor sit amit</span><small
                                            class="date d-block">6:55am</small></div>
                                </a><a class="dropdown-item message d-flex align-items-center" href="#">
                                    <div class="profile"><img class="img-fluid" src="img/avatar-5.jpg"
                                            alt="...">
                                        <div class="status offline"></div>
                                    </div>
                                    <div class="content"> <strong class="d-block">Sara Wood</strong><span
                                            class="d-block">lorem ipsum dolor sit amit</span><small
                                            class="date d-block">10:30pm</small></div>
                                </a><a class="dropdown-item message text-center" href="#"> <strong>See All
                                        Messages
                                        <i class="fa fa-angle-right"></i></strong></a></div>
                        </div>

                        <!-- Tasks end-->

                        <!-- Log out               -->
                        <div class="list-inline-item logout"> <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    Log Out
                                </x-dropdown-link>
                            </form>
                        </div>
                    </div>
            </nav>
        </header>
        <div class="d-flex align-items-stretch">
            <!-- Sidebar Navigation-->
            <nav id="sidebar">
                <!-- Sidebar Header-->
                <div class="sidebar-header d-flex align-items-center">
                    <div class="avatar"><img class="img-fluid rounded-circle" src="img/avatar-6.jpg" alt="...">
                    </div>
                    <div class="title">
                        <h1 class="h5">Admin</h1>
                        <p>E-Commerce</p>
                    </div>
                </div>
                <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
                <ul class="list-unstyled">
                    <li class="active"><a href="index.html"> <i class="icon-home"></i>Home </a></li>

                    <li><a data-toggle="collapse" href="#exampledropdownDropdown" aria-expanded="false"> <i
                                class="icon-windows"></i>Category</a>
                        <ul class="list-unstyled collapse" id="exampledropdownDropdown">
                            <li><a href="{{ route('addcategory') }}">Add Category</a></li>

                        </ul>
                    </li>
                    <li><a data-toggle="collapse" href="#exampledropdownDropdown" aria-expanded="false"> <i
                                class="icon-windows"></i>Example dropdown </a>
                        <ul class="list-unstyled collapse" id="exampledropdownDropdown">
                            <li><a href="#">Page</a></li>
                            <li><a href="#">Page</a></li>
                            <li><a href="#">Page</a></li>
                        </ul>
                    </li>

            </nav>
            <!-- Sidebar Navigation end-->
            <div class="page-content">
                <div class="page-header">
                    <div class="container-fluid">
                        <h2 class="h5 no-margin-bottom">Admin Dashboard</h2>
                    </div>
                </div>
                <section class="no-padding-top no-padding-bottom">

                </section>
                @yield('dashboard')
                @yield('add_category')



                <footer class="footer">
                    <div class="footer__block no-margin-bottom block">
                        <div class="container-fluid text-center">
                            <!-- Please do not remove the backlink to us unless you support us at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
                            <p class="no-margin-bottom">2025 &copy; Musta GmbH. Download From <a
                                    href="https://templateshub.net" target="_blank">Templates Hub</a>.</p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <!-- JavaScript files-->
        <script src="admin/vendor/jquery/jquery.min.js"></script>
        <script src="admin/vendor/popper.js/umd/popper.min.js"></script>
        <script src="admin/vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="admin/vendor/jquery.cookie/jquery.cookie.js"></script>
        <script src="admin/vendor/chart.js/Chart.min.js"></script>
        <script src="admin/vendor/jquery-validation/jquery.validate.min.js"></script>
        <script src="admin/js/charts-home.js"></script>
        <script src="admin/js/front.js"></script>
    </body>

</html>
