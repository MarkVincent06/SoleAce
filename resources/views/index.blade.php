<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   {{-- CSS LINK --}}
   <link rel="stylesheet" href="{{ asset('css/index.css') }}">
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

   <title>Home | SoleAce</title>
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
      {{-- HERO --}}
      <section class="hero">
         <h1 class="hero--slogan">Unleash Your Sole<br> Power With<br> <span>SoleAce</span></h1>
         <img class="hero--shoe-item" src="{{asset('images/hero-shoe-item.png')}}" alt="A picture of a big shoe">
      </section>

      {{-- FEATURED PRODUCTS --}}
      @if($featuredProducts->count() > 0)
         <section class="featured-container">
            <h2 class="featured--title">FEATURED ITEMS</h2>

            <form class="products-container" method="POST">
               @foreach($featuredProducts as $featuredProduct)
                  <div class="product-container">
                     <a class="more-details-link" href="/">
                        <img class="product--image" src="{{ asset('images/' . $featuredProduct->image) }}" />
                        <h3 class="product--name">{{$featuredProduct->name}}</h3>
                        <p class="product--sub-category">
                           @if($featuredProduct->subCategory->name === "Boys" || $featuredProduct->subCategory->name === "Girls")
                              Kid's Shoes
                           @elseif($featuredProduct->subCategory->name === "Sneakers")
                              {{ ucfirst($featuredProduct->category) }}'s {{ $featuredProduct->subCategory->name }}
                           @else
                              {{ ucfirst($featuredProduct->category) }}'s {{ $featuredProduct->subCategory->name }} Shoes
                           @endif
                        </p>

                        @php
                           $tagName = null;
                           $tagType = null;
                           if ($featuredProduct->quantity) {
                              if ($featuredProduct->featured && $featuredProduct->trending) {
                                 $tagType = "product--tag featured-trending";
                                 $tagName = "FEATURED & HOT";
                              } elseif ($featuredProduct->featured) {
                                 $tagType = "product--tag featured";
                                 $tagName = "FEATURED";
                              } else if ($featuredProduct->trending) {
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
                           <label for="product-size">Size</label>
                           <select name="product-size" id="product-size">
                              <option value="9">9</option>
                              <option value="10">10</option>
                              <option value="11">11</option>
                              <option value="12">12</option>
                              <option value="13">13</option>
                           </select>
                        </div>
                        <div>
                           <label for="product-quantity">Quantity</label>
                           <select name="product-quantity" id="product-quantity">
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                           </select>
                        </div>
                     </div>

                     <p class="product--selling-price">
                        ₱ {{ number_format($featuredProduct->selling_price) }}

                        @if ($featuredProduct->original_price > $featuredProduct->selling_price)
                           <span class="product--original-price">
                                 ₱ {{ number_format($featuredProduct->original_price) }}
                           </span>
                        @endif
                     </p>
                     <div class="product--buttons-container">
                        <button class="product--button" style="background-color: #F6BF31;">
                           BUY NOW
                           <i class="fa-solid fa-money-bills" style="margin-left: 7px"></i>
                        </button>
                        <button class="product--button add-to-cart-btn" style="background-color: #BB0000;" value="{{ $featuredProduct->id }}">
                           ADD TO CART
                           <i class="fa-solid fa-cart-plus" style="margin-left: 7px"></i>
                        </button>
                     </div>
                  </div>
               @endforeach
            </form>
         </section>
      @endif

      {{-- FEATURED PRODUCTS --}}
      <section class=" new-products-container">
         <div class="new-products-subcontainer">
            <h2 class="new-products--title">NEW ITEMS</h2>
            <div class="new-products--images-container">
               @foreach($newProducts as $newProduct)
                  <img src="{{asset('images/' . $newProduct->image)}}" alt="A picture of a product">
               @endforeach
            </div>
            <a href="/" class="new-products--button">SHOP NOW</a>
         </div>
      </section>
   </main>

   {{-- FOOTER --}}
   @include('partials._footer')
</body>
</html>
