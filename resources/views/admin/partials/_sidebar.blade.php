@php
   $currentCategory = Request::segment(3); // The category (e.g., men, women, kid)
   $currentSection = Request::segment(2); // The section (e.g., sub-category, products)
@endphp
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark" id="sidenav-main">
   <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="/admin/dashboard">
         <img src="{{asset('admin/images/admin-logo.png')}}" class="navbar-brand-img h-100" alt="main_logo">
         <span class="ms-1 font-weight-bold text-white">SoleAce - Admin</span>
      </a>
   </div>
   <hr class="horizontal light mt-0 mb-2">
   <div class="collapse navbar-collapse  w-auto  max-height-vh-100" id="sidenav-collapse-main">
      <ul class="navbar-nav">
         <li class="nav-item">
            <a class="nav-link text-white {{ Request::is('admin/dashboard') ? 'active bg-gradient-secondary' : '' }}" href="/admin/dashboard">
               <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="fa-solid fa-chart-line"></i>
               </div>
               <span class="nav-link-text ms-1">Dashboard</span>
            </a>
         </li>

         <!-- START OF SUBCATEGORIES SECTION -->
         <li class="nav-item">
            <a class="nav-link text-white" data-bs-toggle="collapse" data-bs-target="#sub-category-submenu" aria-controls="sub-category-submenu" aria-expanded="{{ in_array($currentCategory, ['men', 'women', 'kid']) ? 'true' : 'false' }}" aria-label="Toggle navigation" style="cursor: pointer">
               <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                     <i class="fa-solid fa-layer-group"></i>
               </div>
               <span class="nav-link-text ms-1">All Categories</span>
            </a>
         </li>
         <ul class="nav collapse ms-2 {{ $currentSection == 'subcategory' ? 'show' : '' }}" id="sub-category-submenu">
            <li class="nav-item">
               <a class="nav-link text-white {{ $currentCategory == 'men' ? 'active bg-gradient-secondary' : '' }}" href="{{ route('admin.sub-category.index', ['category' => 'men']) }}">
                  <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                     <i class="fa-solid fa-shop"></i>
                  </div>
                  <span class="nav-link-text ms-1">Men's Shoes</span>
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link text-white {{ $currentCategory == 'women' ? 'active bg-gradient-secondary' : '' }}" href="{{ route('admin.sub-category.index', ['category' => 'women']) }}">
                  <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                     <i class="fa-solid fa-shop"></i>
                  </div>
                  <span class="nav-link-text ms-1">Women's Shoes</span>
               </a>
            </li>
            <li class="nav-item">   
               <a class="nav-link text-white {{ $currentCategory == 'kid' ? 'active bg-gradient-secondary' : '' }}" href="{{ route('admin.sub-category.index', ['category' => 'kid']) }}">
                  <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                     <i class="fa-solid fa-shop"></i>
                  </div>
                  <span class="nav-link-text ms-1">Kid's Shoes</span>
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link text-white {{ Request::is('admin/subcategory/create') ? 'active bg-gradient-secondary' : '' }}" href="{{ route('admin.sub-category.create') }}">
                  <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                     <i class="fa-solid fa-plus"></i>
                  </div>
                  <span class="nav-link-text ms-1">Add Subcategory</span>
               </a>
            </li>
         </ul>
         <!-- END OF SUBCATEGORIES SECTION -->

         <!-- START OF PRODUCTS SECTION -->
         <li class="nav-item">
            <a class="nav-link text-white" data-bs-toggle="collapse" data-bs-target="#product-submenu" aria-controls="product-submenu" aria-expanded="{{ Request::is('admin/products*', 'admin/add-product*') ? 'true' : 'false' }}" aria-label="Toggle navigation" style="cursor: pointer">
               <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="fa-solid fa-tags"></i>
               </div>
               <span class="nav-link-text ms-1">All Products</span>
            </a>
         </li>
         <ul class="nav collapse ms-2 {{ $currentSection == 'products' ? 'show' : '' }}" id="product-submenu">
            <li class="nav-item">
               <a class="nav-link text-white {{ $currentCategory == 'men' ? 'active bg-gradient-secondary' : '' }}" href="{{ route('admin.products.index', ['category' => 'men']) }}">
                  <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                     <i class="fa-solid fa-shop"></i>
                  </div>
                  <span class="nav-link-text ms-1">Men's Shoes</span>
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link text-white {{ $currentCategory == 'women' ? 'active bg-gradient-secondary' : '' }}" href="{{ route('admin.products.index', ['category' => 'women']) }}">
                  <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                     <i class="fa-solid fa-shop"></i>
                  </div>
                  <span class="nav-link-text ms-1">Women's Shoes</span>
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link text-white {{ $currentCategory == 'kid' ? 'active bg-gradient-secondary' : '' }}" href="{{ route('admin.products.index', ['category' => 'kid']) }}">
                  <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                     <i class="fa-solid fa-shop"></i>
                  </div>
                  <span class="nav-link-text ms-1">Kid's Shoes</span>
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link text-white {{ Request::is('admin/products/create') ? 'active bg-gradient-secondary' : '' }}" href="{{route('admin.products.create')}}">
                  <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                     <i class="fa-solid fa-plus"></i>
                  </div>
                  <span class="nav-link-text ms-1">Add Product</span>
               </a>
            </li>
         </ul>
         <!-- END OF PRODUCTS SECTION -->
   </div>
   <div class="sidenav-footer position-absolute w-100 bottom-0 ">
      <form class="mx-3" action="{{route('user.signOut')}}" method="POST">
         @csrf
         <button class="btn bg-gradient-primary mt-4 w-100" type="submit">Sign out</button>
      </form>
   </div>
</aside>
