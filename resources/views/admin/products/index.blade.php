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

   <title>{{$webTitle}}</title>
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
                     <h4>All Products - {{$categoryTitle}}</h4>
                  </div>
                  <div class="card-body" style="overflow-x: auto;" id="products-table">
                     <table class="table table-bordered table-striped">
                        <thead>
                           <tr>
                              <th>No.</th>
                              <th>Name</th>
                              <th>Subcategory</th>
                              <th>Image</th>
                              <th>Status</th>
                              <th>Featured</th>
                              <th>Trending</th>
                              <th>No. of Stocks</th>
                              <th>Edit</th>
                              <th>Delete</th>
                           </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $index => $product)
                              <tr>
                                 <td>{{$index + 1}}</td>
                                 <td>{{$product->name}}</td>
                                 <td>{{$product->subcategory->name}}</td>
                                 <td>
                                    <img src="{{ Storage::url('uploads/' . $product->image) }}" width="50px" height="50px" alt="Product image">
                                 </td>
                                 <td>
                                    {{$product->status ? "Visible" : "Hidden"}}
                                 </td>
                                 <td>
                                    {{$product->featured ? "Yes" : "No"}}
                                 </td>
                                 <td>
                                    {{$product->trending ? "Yes" : "No"}}
                                 </td>
                                 <td>
                                    {{$product->quantity}}
                                 </td>
                                 <td>
                                    <a href="{{route('admin.products.edit', ['id' => $product->id])}}" class="btn btn-primary">Edit</a>
                                 </td>
                                 <td>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                          @csrf
                                          @method('DELETE')
                                          <button type="submit" class="btn btn-danger delete-delete-product">Delete</button>
                                    </form>
                                 </td>
                              </tr>
                           @endforeach
                        </tbody>
                     </table>
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