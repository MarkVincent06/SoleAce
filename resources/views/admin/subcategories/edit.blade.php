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

   <title>SoleAce - Edit Subcategory</title>
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
               <div class="card">
                  <div class="card-header">
                     <h4>Edit Subcategory</h4>
                  </div>
                  <div class="card-body">
                     <form action="{{route('admin.sub-category.update', ['id' => $subCategory->id])}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row mb-2">
                           <div class="col-md-6">
                              <label class="mb-0" for="name">Name</label>
                              <input type="text" class="form-control" id="name" name="name" placeholder="Enter sub-category name" value="{{$subCategory->name}}" required>
                           </div>
                           <div class="col-md-6">
                              <label class="mb-0" for="name">Category</label>
                              <select class="form-select form-control" aria-label="Default select example" name="category" disabled>
                                 @php
                                    $categories = ["men", "women", "kid"];
                                 @endphp
                                 @foreach ($categories as $category)
                                    @php
                                          $selectedCategory = ($category === $subCategory->category) ? "selected" : "";
                                    @endphp
                                    <option {{ $selectedCategory }} value="{{ $category }}">{{ ucfirst($category) }}'s Shoes</option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                        <div class="row mb-2">
                           <div class="col-md-6">
                              <label class="mb-0" for="status">Status</label> </br>
                              <input type="checkbox" id="status" name="status" {{$subCategory->status ? "checked" : ""}}>
                           </div>
                        </div>

                        <div class="col-md-12">
                           <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                     </form>
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