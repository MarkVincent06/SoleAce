<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   {{-- CSS LINK --}}
   <link rel="stylesheet" href="{{ asset('css/category.css') }}">
   <link rel="stylesheet" href="{{ asset('css/navigation.css') }}">
   <link rel="stylesheet" href="{{ asset('css/footer.css') }}">

   {{-- GOOGLE FONTS LINK --}}
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Saira+Condensed:wght@300;400;600;700;900&display=swap" rel="stylesheet">

   {{-- FONTAWESOME CDN --}}
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

   <!-- SWAL-TOAST-MESSAGE JS -->
   <script src="{{asset('js/swalToastMsg.js')}}" type="module"></script>

   <!-- SWEETALERT CDN -->
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>

   {{-- ADD TO CART JS --}}
   <script src="{{ asset('js/addToCart.js') }}" defer></script>

   <title>{{$categoryWebTitle}} | SoleAce</title>
</head>
<body>
   <!-- This session will handle the SweetAlert2 toast messages -->
   @if (session('message'))
      <!-- THESE HIDDEN INPUTS WILL BE USED IN JS -->
      <input id="toastMsg-input" type="hidden" value="{{ session('message') }}">
      <input id="toastType-input" type="hidden" value="{{ session('type') }}">
   @endif

   {{-- NAVIGATION --}}
   @include('partials._navigation')
   
   <main>
     <div class="subcategories">
         <ul class="subcategories--links">
            @if($categoryName === "new" || $categoryName === "featured")
               <li>
                  <a 
                     href="{{route('new-arrivals')}}" 
                     @class(['active' => $categoryName === 'new'])>
                     New Arrivals
                  </a>
               </li>
               <li>
                  <a 
                     href="{{route('featured-shoes')}}" 
                     @class(['active' => $categoryName === 'featured'])>
                     Featured Shoes
                  </a>
               </li>
            @else
               <li>
                  <a 
                     href="{{route($categoryName . '-shoes', ['subcategory' => 'all'])}}" 
                     @class(['active' => $subcategoryName === 'all'])>
                     All Shoes For {{ucfirst($categoryName)}}
                  </a>
               </li>
               @if(count($subcategories) > 0)
                        @foreach($subcategories as $subcategory)
                           @if($categoryName === "men" && $subcategory->category === "men")
                              <li>
                                 <a 
                                    href="{{route('men-shoes', ['subcategory' => strtolower($subcategory->name)])}}"
                                    @class(['active' => $subcategoryName === strtolower($subcategory->name)])>
                                    {{$subcategory->name}}
                                 </a>
                              </li>
                           @elseif($categoryName === "women" && $subcategory->category === "women")
                              <li>
                                 <a 
                                    href="{{route('women-shoes', ['subcategory' => strtolower($subcategory->name)])}}"
                                    @class(['active' => $subcategoryName === strtolower($subcategory->name)])>
                                    {{$subcategory->name}}
                                 </a>
                              </li>
                           @elseif($categoryName === "kid" && $subcategory->category === "kid")
                              <li>
                                 <a 
                                    href="{{route('kid-shoes', ['subcategory' => strtolower($subcategory->name)])}}"
                                    @class(['active' => $subcategoryName === strtolower($subcategory->name)])>
                                    {{$subcategory->name}}
                                 </a>
                              </li>
                           @endif
                        @endforeach
                     @endif
               @endif
         </ul>
      </div>

      <section class="subcategory-container">
         <div class="subcategory--header">
            <h2 class="subcategory--header-title">{{$categoryWebTitle}} <span>[{{count($categorizedProducts)}}]</span></h2>
         </div>

         <form id="add-to-cart-form" class="products-container" method="POST">
         @csrf
            @foreach($categorizedProducts as $product)
               <div class="product-container">
                  <a class="more-details-link" href="{{route('product.render', ['productSlug' => $product->slug])}}">
                     <img class="product--image" src="{{ Storage::url('uploads/' . $product->image) }}" />
                     <h3 class="product--name">{{$product->name}}</h3>
                     <p class="product--sub-category">
                        @if($product->subCategory->name === "Boys" || $product->subCategory->name === "Girls")
                           Kid's Shoes
                        @elseif($product->subCategory->name === "Sneakers")
                           {{ ucfirst($product->category) }}'s {{ $product->subCategory->name }}
                        @else
                           {{ ucfirst($product->category) }}'s {{ $product->subCategory->name }} Shoes
                        @endif
                     </p>

                     @php
                        $tagName = null;
                        $tagType = null;
                        if ($product->quantity) {
                           if ($product->featured && $product->trending) {
                              $tagType = "product--tag featured-trending";
                              $tagName = "FEATURED & HOT";
                           } elseif ($product->featured) {
                              $tagType = "product--tag featured";
                              $tagName = "FEATURED";
                           } else if ($product->trending) {
                              $tagType = "product--tag trending";
                              $tagName = "HOT";
                           }
                        } else {
                           $tagType = "product--tag soldout";
                           $tagName = "SOLD OUT";
                        }
                     @endphp
                     
                     @if($tagType && $tagName)
                        <p class="{{$tagType}}">{{$tagName}}</p>
                     @endif
                  </a>
                     <div class="product-selection">
                     <div>
                        <label for="product-size-{{ $product->id }}">Size</label>
                        <select name="product_size" id="product-size-{{ $product->id }}" data-product-id="{{ $product->id }}">
                           <option value="9">9</option>
                           <option value="10">10</option>
                           <option value="11">11</option>
                           <option value="12">12</option>
                           <option value="13">13</option>
                        </select>
                     </div>
                     <div>
                        <label for="product-quantity-{{ $product->id }}">Quantity</label>
                        <select name="product_quantity" id="product-quantity-{{ $product->id }}" data-product-id="{{ $product->id }}">
                           <option value="1">1</option>
                           <option value="2">2</option>
                           <option value="3">3</option>
                           <option value="4">4</option>
                           <option value="5">5</option>
                        </select>
                     </div>
                  </div>

                  <p class="product--selling-price">
                     ₱ {{ number_format($product->selling_price, 2) }}

                     @if ($product->original_price > $product->selling_price)
                        <span class="product--original-price">
                           ₱ {{ number_format($product->original_price, 2) }}
                        </span>
                     @endif
                  </p>
                  <div class="product--buttons-container">
                    <button type="button" class="product--button add-to-cart-btn" style="background-color: #BB0000;" data-product-id="{{ $product->id }}">
                        ADD TO CART
                        <i class="fa-solid fa-cart-plus" style="margin-left: 7px"></i>
                     </button>
                  </div>
               </div>
            @endforeach
         </form>
      </section>
   </main>

   {{-- FOOTER --}}
   @include('partials._footer')
</body>
</html>
