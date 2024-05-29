<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   {{-- CSS LINK --}}
   <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
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

   {{-- CART JS --}}
   <script src="{{ asset('js/cart.js') }}" defer></script>

   <title>Cart | SoleAce</title>
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
      <!-- START OF CART SUMMARY -->
      <div class='cart-summary-container' method="post">
         <section class="cart-container">
            <h2>CART</h2>

            @unless(count($cartItems) > 0)
               <p style="font-size: 18px;">There are no items in your cart.</p>
            @else
               @foreach($cartItems as $citem)
                  <div class="cart--product-container">
                     <img src="{{Storage::url('uploads/' . $citem->product->image)}}" alt="An image of a product">
                     <div class="cart--product-details">
                        <h3>{{$citem->product->name}}</h3>
                        <p>
                           @if($citem->product->subCategory->name === "Boys" || $citem->product->subCategory->name === "Girls")
                              Kid's Shoes
                           @elseif($citem->product->subCategory->name === "Sneakers")
                              {{ ucfirst($citem->product->category) }}'s {{ $citem->product->subCategory->name }}
                           @else
                              {{ ucfirst($citem->product->category) }}'s {{ $citem->product->subCategory->name }} Shoes
                           @endif
                        </p>
                        <div class="cart--product-selection">
                           <div>
                              <label for="product-size-{{ $citem->product_id }}">Size</label>
                              <select name="product_size" id="product-size-{{ $citem->product_id }}" data-product-id="{{ $citem->product_id }}">
                                 @php
                                    $sizes = ["7", "8", "9", "10", "11", "12", "13", "14", "15"];
                                 @endphp

                                 @foreach ($sizes as $size)
                                    @php
                                          $selectedSize = ($size == $citem->product_size) ? "selected" : "";
                                    @endphp
                                    <option value="{{ $size }}" {{ $selectedSize }}>{{ $size }}</option>
                                 @endforeach
                              </select>
                           </div>

                           <div>
                              <label for="product-quantity-{{ $citem->product_id }}">Quantity</label>
                              <select name="product_quantity" id="product-quantity-{{ $citem->product_id }}" data-product-id="{{ $citem->product_id }}">
                                 @php
                                    $quantities = ["1", "2", "3", "4", "5"];
                                 @endphp

                                 @foreach ($quantities as $quantity)
                                    @php
                                          $selectedQuantity = ($quantity == $citem->product_quantity) ? "selected" : "";
                                    @endphp
                                    <option value="{{ $quantity }}" {{ $selectedQuantity }}>{{ $quantity }}</option>
                                 @endforeach
                              </select>
                           </div>
                        </div>

                        <form action="{{route('cart.delete', ['id' => $citem->product_id])}}" style="margin-top: 10px;" method="POST">
                           @csrf
                           @method('delete')
                           <button class="trashcan delete-item"><i class="fa-regular fa-trash-can"></i></button>
                        </form>
                     </div>
                     <small class="cart--product-price">₱ {{number_format($citem->product->selling_price, 2)}}</small>
                  </div>
               @endforeach
            @endunless
         </section>

         <section class="summary-container">
            <h2>SUMMARY</h2>
            <div class="summary--subtotal">
               <p>Subtotal</p>
               <p>{{$cartItems ? "₱ " . number_format($totalPrice, 2) : "—"}}</p>
            </div>

            <div class="summary--shipping-fee">
               <p>Shipping Fee</p>
               <p>Free</p>
            </div>

            <div class="summary--hori-line"></div>

            <div class="summary--total">
               <p>Total</p>
               <p>{{$cartItems ? "₱ " . number_format($totalPrice, 2) : "—"}}</p>
            </div>

            <div class="summary--hori-line"></div>

            @if (count($cartItems) > 0)
               <a class="summary--checkout-button" href="{{route('order.renderCheckout')}}">Checkout</a>
            @else
               <a class="summary--disabled-checkout-button">Checkout</a>
            @endif
         </section>
      </div>
      <!-- END OF CART SUMMARY -->
   </main>

   {{-- FOOTER --}}
   @include('partials._footer')
</body>
</html>
