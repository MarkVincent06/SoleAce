<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   {{-- FONTAWESOME CDN --}}
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

   {{-- MATERIAL ICONS --}}
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

   {{-- CSS FILES --}}
   <link id="pagestyle" href="{{asset('admin/css/material-dashboard.min.css')}}" rel="stylesheet" />
   <link rel="stylesheet" href="{{asset('admin/css/custom.css')}}">

   {{-- GOOGLE FONTS LINK --}}
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Saira+Condensed:wght@300;400;600;700;900&display=swap" rel="stylesheet">

   <!-- SWAL-TOAST-MESSAGE JS -->
   <script src="{{asset('js/swalToastMsg.js')}}" type="module"></script>

   <!-- SWEETALERT CDN -->
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>

   <title>SoleAce - Dashboard</title>
</head>

<body class="g-sidenav-show  bg-gray-200">
   <!-- This session will handle the SweetAlert2 toast messages -->
   @if (session('message'))
   <!-- THESE HIDDEN INPUTS WILL BE USED IN JS -->
   <input id="toastMsg-input" type="hidden" value="{{ session('message') }}">
   <input id="toastType-input" type="hidden" value="{{ session('type') }}">
   @endif

   {{-- SIDEBAR --}}
   @include('admin.partials._sidebar')

   <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
      {{-- NAVBAR --}}
      @include('admin.partials._navbar')

      <div class="container">
         <div class="row">
            <div class="col-md-12">
               <div class="row">
                  <div class="col-12 position-relative z-index-2">
                     <div class="card card-plain mb-4">
                        <div class="card-body p-3">
                           <div class="row">
                              <div class="col-lg-6">
                                 <div class="d-flex flex-column h-100">
                                    <h2 class="font-weight-bolder mb-0">
                                       General Statistics
                                    </h2>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <div class="row">
                        <div class="col-lg-3 col-sm-5 mt-sm-0 mt-4">
                           <div class="card mb-2">
                              <div class="card-header p-3 pt-2">
                                 <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">group</i>
                                 </div>
                                 <div class="text-end pt-1">
                                    <p class="text-sm mb-0">No. of Users</p>
                                    <h4 class="mb-0">{{$totalUsers}}</h4>
                                 </div>
                              </div>

                              <hr class="dark horizontal my-0" />
                              <div class="card-footer p-3">
                                 <p class="mb-0">
                                    <span class="text-success text-sm font-weight-bolder">+55% </span>than last week
                                 </p>
                              </div>
                           </div>
                        </div>

                        <div class="col-lg-3 col-sm-5 mt-sm-0 mt-4">
                           <div class="card mb-2">
                              <div class="card-header p-3 pt-2">
                                 <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary shadow text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">category</i>
                                 </div>
                                 <div class="text-end pt-1">
                                    <p class="text-sm mb-0">No. of Subcategories</p>
                                    <h4 class="mb-0">{{$totalSubCategories}}</h4>
                                 </div>
                              </div>

                              <hr class="dark horizontal my-0" />
                              <div class="card-footer p-3">
                                 <p class="mb-0">
                                    <span class="text-success text-sm font-weight-bolder">+3% </span>than last month
                                 </p>
                              </div>
                           </div>
                        </div>


                        <div class="col-lg-3 col-sm-5 mt-sm-0 mt-4">
                           <div class="card mb-2">
                              <div class="card-header p-3 pt-2 bg-transparent">
                                 <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">sell</i>
                                 </div>
                                 <div class="text-end pt-1">
                                    <p class="text-sm mb-0">No. of Products</p>
                                    <h4 class="mb-0">{{$totalProducts}}</h4>
                                 </div>
                              </div>
                              <hr class="horizontal my-0 dark" />
                              <div class="card-footer p-3">
                                 <p class="mb-0">
                                    <span class="text-success text-sm font-weight-bolder">+1% </span>than yesterday
                                 </p>
                              </div>
                           </div>
                        </div>

                        <div class="col-lg-3 col-sm-5 mt-sm-0 mt-4">
                           <div class="card">
                              <div class="card-header p-3 pt-2 bg-transparent">
                                 <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons opacity-10">pending_actions</i>
                                 </div>
                                 <div class="text-end pt-1">
                                    <p class="text-sm mb-0">Pending Orders</p>
                                    <h4 class="mb-0">{{$pendingOrders}}</h4>
                                 </div>
                              </div>

                              <hr class="horizontal my-0 dark" />
                              <div class="card-footer p-3">
                                 <p class="mb-0">Just updated</p>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         {{-- FOOTER --}}
         @include('admin.partials._footer')

      </div>
   </main>

   <script src="{{asset('admin/js/bootstrap.bundle.min.js')}}" defer></script>
   <script src="{{asset('admin/js/perfect-scrollbar.min.js')}}" defer></script>
   <script src="{{asset('admin/js/smooth-scrollbar.min.js')}}" defer></script>
</body>

</html>