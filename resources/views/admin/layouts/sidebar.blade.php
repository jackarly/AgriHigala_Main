<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar-Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin')}}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">
            Agri-Higala
        </div>
    </a>

    <div class="sidebar-group">
        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="{{route('admin')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">
    </div>

    <div class="sidebar-group">
        <!-- Heading -->
        <div class="sidebar-heading">
            User
        </div>
        <!--Users -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#userCollapse" aria-expanded="true" aria-controls="userCollapse">
            <i class="fas fa-sitemap"></i>
            <span>User</span>
            </a>
            <div id="userCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">User Options:</h6>
                <a class="collapse-item" href="{{route('admin.users.index')}}">Users</a>
                <a class="collapse-item" href="{{route('admin.users.create')}}">Add User</a>
            </div>
            </div>
        </li>
        <!--Messages -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-envelope"></i>
                <span>Messages</span>
            </a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">
    </div>

    <div class="sidebar-group">
        <!-- Heading -->
        <div class="sidebar-heading">
            Products
        </div>
        <!--Products -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#productCollapse" aria-expanded="true" aria-controls="productCollapse">
              <i class="fas fa-cubes"></i>
              <span>Products</span>
            </a>
            <div id="productCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
              <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Product Options:</h6>
                <a class="collapse-item" href="#">Products</a>
                <a class="collapse-item" href="#">Add Product</a>
              </div>
            </div>
        </li>
        <!--Product Types -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#productTypeCollapse" aria-expanded="true" aria-controls="productTypeCollapse">
            <i class="fas fa-sitemap"></i>
            <span>Product Type</span>
            </a>
            <div id="productTypeCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Product Type Options:</h6>
                <a class="collapse-item" href="#">Product Type</a>
                <a class="collapse-item" href="#">Add Product Type</a>
            </div>
            </div>
        </li>
        <!--SRPs -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#srpCollapse" aria-expanded="true" aria-controls="srpCollapse">
            <i class="fas fa-sitemap"></i>
            <span>SRP</span>
            </a>
            <div id="srpCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">SRP Options:</h6>
                <a class="collapse-item" href="#">SRP</a>
                <a class="collapse-item" href="#">Add SRP</a>
            </div>
            </div>
        </li>
        <!--Stocks -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#stockCollapse" aria-expanded="true" aria-controls="stockCollapse">
            <i class="fas fa-sitemap"></i>
            <span>Stock</span>
            </a>
            <div id="stockCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Stock Options:</h6>
                <a class="collapse-item" href="#">Stock</a>
                <a class="collapse-item" href="#">Add Stock</a>
            </div>
            </div>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">
    </div>

    <div class="sidebar-group">
        <!-- Heading -->
        <div class="sidebar-heading">
            Order
        </div>
        <!--Orders -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-box"></i>
                <span>Orders</span>
            </a>
        </li>
        <!--Return Orders -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-box-open"></i>
                <span>Return Orders</span>
            </a>
        </li>
        <!--History -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fa fa-history"></i>
                <span>History</span>
            </a>
        </li>
        <!--Reviews -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-hammer"></i>
                <span>Reviews</span>
            </a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">
    </div>

    <div class="sidebar-group">
        <!-- Heading -->
        <div class="sidebar-heading">
            General Settings
        </div>
        <!--Announcements -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-hammer"></i>
                <span>Announcements</span>
            </a>
        </li>
        <!--Feedbacks -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-hammer"></i>
                <span>Feedbacks</span>
            </a>
        </li>
        <!--Settings -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-hammer"></i>
                <span>Settings</span>
            </a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">
    </div>

</ul>