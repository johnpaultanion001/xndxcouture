<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 my-3 fixed-start ms-3   bg-white" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0 text-center" href="/admin/dashboard">
      <!-- <img class="bi me-2" src="/assets/img/logo.jpg" alt="logo" width="50" height="42"> -->
      {{ trans('panel.site_title') }} 
    </a>
  </div>
  <hr class="horizontal light mt-0 mb-2">
  <div class="collapse navbar-collapse  w-auto  max-height-vh-100" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link text-dark {{ request()->is('admin/dashboard') || request()->is('admin/dashboard/*') ? 'bg-gradient-dark text-white' : '' }}" href="{{ route("admin.dashboard") }}">
          <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10 {{ request()->is('admin/dashboard') || request()->is('admin/dashboard/*') ? 'text-white' : '' }}">dashboard</i>
          </div>
          <span class="nav-link-text ms-1 text-uppercase">Dashboard</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link text-dark {{ request()->is('admin/products') || request()->is('admin/products/*') ? 'bg-gradient-dark text-white' : '' }}" href="{{ route("admin.products.index") }}">
          <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-list {{ request()->is('admin/products') || request()->is('admin/products/*') ? 'text-white' : '' }}" style="font-size: 17px"></i>
          </div>
          <span class="nav-link-text ms-1 text-uppercase">Inventories</span>
        </a>
      </li>
      

      <li class="nav-item">
        <a class="nav-link text-dark {{ request()->is('admin/orders') || request()->is('admin/orders/*') ? 'bg-gradient-dark text-white' : '' }}" href="{{ route("admin.orders") }}">
          <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-shopping-cart  {{ request()->is('admin/orders') || request()->is('admin/orders/*') ? 'text-white' : '' }}" style="font-size: 17px"></i>
          </div>
          <span class="nav-link-text ms-1 text-uppercase">Orders</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark {{ request()->is('admin/categories') || request()->is('admin/categories/*') ? 'bg-gradient-dark text-white' : '' }}" href="{{ route("admin.categories.index") }}">
          <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-tag {{ request()->is('admin/categories') || request()->is('admin/categories/*') ? 'text-white' : '' }}" style="font-size: 17px"></i>
          </div>
          <span class="nav-link-text ms-1 text-uppercase">Categories</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark {{ request()->is('admin/customer_list') || request()->is('admin/customer_list/*') ? 'bg-gradient-dark text-white' : '' }}" href="{{ route("admin.customer") }}">
          <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10 {{ request()->is('admin/customer_list') || request()->is('admin/customer_list/*') ? 'text-white' : '' }}">person</i>
          </div>
          <span class="nav-link-text ms-1 text-uppercase">Customers</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark {{ request()->is('admin/sales_reports') || request()->is('admin/sales_reports/*') ? 'bg-gradient-dark text-white' : '' }}" href="/admin/sales_reports/daily/daily/daily">
          <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-list {{ request()->is('admin/sales_reports') || request()->is('admin/sales_reports/*') ? 'text-white' : '' }}" style="font-size: 17px"></i>
          </div>
          <span class="nav-link-text ms-1 text-uppercase">Sales Reports</span>
        </a>
      </li>
  
   
    </ul>
  </div>

</aside>