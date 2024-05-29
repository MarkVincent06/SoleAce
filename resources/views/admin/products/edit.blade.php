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

   <title>SoleAce - Edit Product</title>
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
                     <h4>Edit Product</h4>
                  </div>
                  <div class="card-body">
                     <form action="{{ route('admin.products.update', ['id' => $product->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mb-2">
                           <div class="col-md-6">
                              <label class="mb-0" for="category">Category</label>
                              <select class="form-select form-control @error('category') is-invalid @enderror" name="category" id="category">
                                    <option selected disabled>Please choose a category</option>
                                    @php
                                       $categories = ["men", "women", "kid"];
                                    @endphp
                                    @foreach ($categories as $category)
                                       <option value="{{ $category }}" {{ old('category', $product->category) == $category ? 'selected' : '' }}>
                                          {{ ucfirst($category) }}'s Shoes
                                       </option>
                                    @endforeach
                              </select>
                              @error('category')
                                    <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                    </span>
                              @enderror
                           </div>
                           <div class="col-md-6">
                              <label class="mb-0" for="subcategory">Subcategory</label>
                              <select class="form-select form-control @error('subcategory_id') is-invalid @enderror" name="subcategory_id" id="subcategory">
                                    <option selected disabled>Please choose a subcategory</option>
                                    <!-- Subcategories will be populated dynamically -->
                              </select>
                              @error('subcategory_id')
                                    <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                    </span>
                              @enderror
                           </div>
                        </div>

                     <script>
                        document.addEventListener('DOMContentLoaded', function() {
                           const categorySelect = document.getElementById('category');
                           const subcategorySelect = document.getElementById('subcategory');
                           const selectedCategory = "{{ old('category', $product->category) }}";
                           const selectedSubcategory = "{{ old('subcategory_id', $product->sub_category_id) }}";
                           console.log(selectedSubcategory)

                           function fetchSubcategories(category) {
                              fetch(`/admin/get-subcategories/${category}`)
                                    .then(response => response.json())
                                    .then(subcategories => {
                                       console.log(subcategories)
                                       subcategorySelect.innerHTML = '<option selected disabled>Please choose a subcategory</option>';
                                       subcategories.forEach(subcategory => {
                                          const isSelected = subcategory.id == selectedSubcategory ? 'selected' : '';
                                          subcategorySelect.innerHTML += `<option value="${subcategory.id}" ${isSelected}>${subcategory.name}</option>`;
                                       });
                                       subcategorySelect.disabled = false;
                                    })
                                    .catch(error => console.error('Error fetching subcategories:', error));
                           }

                           categorySelect.addEventListener('change', function() {
                              const category = this.value;
                              fetchSubcategories(category);
                           });

                           if (selectedCategory) {
                              fetchSubcategories(selectedCategory);
                           }
                        });
                     </script>

                        <div class="row mb-2">
                           <div class="col-md-6">
                                 <label class="mb-0" for="name">Name</label>
                                 <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name) }}" placeholder="Enter product name">
                                 @error('name')
                                    <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                    </span>
                                 @enderror
                           </div>
                           <div class="col-md-6">
                                 <label class="mb-0" for="slug">Slug</label>
                                 <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $product->slug) }}" placeholder="Enter slug">
                                 @error('slug')
                                    <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                    </span>
                                 @enderror
                           </div>
                        </div>

                        <div class="col-md-12 mb-2">
                           <label class="mb-0" for="small-description">Small Description</label>
                           <textarea rows="3" class="form-control @error('small-description') is-invalid @enderror" id="small-description" name="small-description" placeholder="Enter small description">{{ old('small-description', $product->small_description) }}</textarea>
                           @error('small-description')
                                 <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                 </span>
                           @enderror
                        </div>

                        <div class="col-md-12 mb-2">
                           <label class="mb-0" for="description">Description</label>
                           <textarea rows="3" class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Enter description">{{ old('description', $product->description) }}</textarea>
                           @error('description')
                                 <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                 </span>
                           @enderror
                        </div>

                        <div class="row mb-2">
                           <div class="col-md-6">
                                 <label class="mb-0" for="original-price">Original Price</label>
                                 <input type="text" class="form-control @error('original-price') is-invalid @enderror" id="original-price" name="original-price" value="{{ old('original-price', $product->original_price) }}" placeholder="Enter original price">
                                 @error('original-price')
                                    <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                    </span>
                                 @enderror
                           </div>
                           <div class="col-md-6">
                                 <label class="mb-0" for="selling-price">Selling Price</label>
                                 <input type="text" class="form-control @error('selling-price') is-invalid @enderror" id="selling-price" name="selling-price" value="{{ old('selling-price', $product->selling_price) }}" placeholder="Enter selling price">
                                 @error('selling-price')
                                    <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                    </span>
                                 @enderror
                           </div>
                        </div>

                        <div class="col-md-12 mb-2">
                           <input type="hidden" name="old-image" value="{{$product->image}}">
                           <label class="mb-0" for="image">Upload Image</label>
                           <input type="file" class="form-control mb-1" id="image" name="image">
                           <label class="mb-0 me-1" for="image">Current Image:</label>
                           <img src="{{ Storage::url('uploads/' . $product->image) }}" alt="Current image of a product" width="50px" height="50px">
                           @error('image')
                                 <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                 </span>
                           @enderror
                        </div>

                        <div class="row mb-2">
                           <div class="col-md-3">
                                 <label class="mb-0" for="quantity">Quantity</label>
                                 <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity', $product->quantity) }}" placeholder="Enter quantity">
                                 @error('quantity')
                                    <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                    </span>
                                 @enderror
                           </div>
                           <div class="col-md-3">
                                 <label class="mb-0" for="status">Status</label><br>
                                 <input type="checkbox" id="status" name="status" {{ old('status', $product->status) ? 'checked' : '' }}>
                                 @error('status')
                                    <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                    </span>
                                 @enderror
                           </div>
                           <div class="col-md-3">
                                 <label class="mb-0" for="featured">Feature Product</label><br>
                                 <input type="checkbox" id="featured" name="featured" {{ old('featured', $product->featured) ? 'checked' : '' }}>
                                 @error('featured')
                                    <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                    </span>
                                 @enderror
                           </div>
                           <div class="col-md-3">
                                 <label class="mb-0" for="trending">Trending</label><br>
                                 <input type="checkbox" id="trending" name="trending" {{ old('trending', $product->trending) ? 'checked' : '' }}>
                                 @error('trending')
                                    <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                    </span>
                                 @enderror
                           </div>
                        </div>

                        <div class="col-md-12 mb-2">
                           <label class="mb-0" for="meta-title">Meta Title</label>
                           <input type="text" class="form-control @error('meta-title') is-invalid @enderror" id="meta-title" name="meta-title" value="{{ old('meta-title', $product->meta_title) }}" placeholder="Enter meta title">
                           @error('meta-title')
                                 <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                 </span>
                           @enderror
                        </div>

                        <div class="col-md-12 mb-2">
                           <label class="mb-0" for="meta-description">Meta Description</label>
                           <textarea rows="3" class="form-control @error('meta-description') is-invalid @enderror" id="meta-description" name="meta-description" placeholder="Enter meta description">{{ old('meta-description', $product->meta_description) }}</textarea>
                           @error('meta-description')
                                 <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                 </span>
                           @enderror
                        </div>

                        <div class="col-md-12 mb-2">
                           <label class="mb-0" for="meta-keywords">Meta Keywords</label>
                           <textarea rows="3" class="form-control @error('meta-keywords') is-invalid @enderror" id="meta-keywords" name="meta-keywords" placeholder="Enter meta keywords">{{ old('meta-keywords', $product->meta_keywords) }}</textarea>
                           @error('meta-keywords')
                                 <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                 </span>
                           @enderror
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