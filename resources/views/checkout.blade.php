<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   {{-- CSS LINK --}}
   <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
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

   <title>Checkout | SoleAce</title>
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
      <h1 class="checkout-summary-title">Checkout Summary</h1>
      <form class="container" method="POST" action="{{route('order.placeOrder')}}">
         @csrf
         <div class="billing-details">
            <h2 class="checkout-title">Billing Details</h2>
            <div class="form-group">
               <label for="name">Name:</label>
               <input type="text" id="name" placeholder="Enter your name" name="name" required>
            </div>
            <div class="form-group">
               <label for="email">Email:</label>
               <input type="text" id="email" placeholder="Enter your email" name="email" required>
            </div>
            <div class="form-group">
               <label for="contact-no">Contact No:</label>
               <input type="text" id="contact-no" placeholder="Enter your contact number" name="contact_no" required>
            </div>
            <div class="form-group">
               <label for="address">Address:</label>
               <input type="text" id="address" placeholder="Enter your address" name="address" required>
            </div>
            <div class="form-group">
               <label for="zip">Zip Code:</label>
               <input type="text" id="zip" placeholder="Enter your zip code" name="zip" required>
            </div>
            <div class="form-group">
               <label for="payment">Payment Method:</label>
               <select id="payment" name="payment" required>
                  <option value="cod">Cash on Delivery (COD)</option>
                  <option value="card">Credit/Debit Card</option>
                  <option value="netbanking">Net Banking</option>
               </select>
            </div>
         </div>
         <div class="cart-items">
            <h2 class="checkout-title">Cart Items</h2>
            <hr style="margin-bottom: 20px; margin-top: -10px">

            @foreach ($cartItems as $citem)
               <div class="cart-item">
                  <img src="{{Storage::url('uploads/' . $citem->product->image)}}" alt="An image of a product">
                  <div class="item-details">
                     <h3 class="item-name">{{$citem->product->name}}</h3>
                     <p class="item-subcategory">
                        @if($citem->product->subCategory->name === "Boys" || $citem->product->subCategory->name === "Girls")
                           Kid's Shoes
                        @elseif($citem->product->subCategory->name === "Sneakers")
                           {{ ucfirst($citem->product->category) }}'s {{ $citem->product->subCategory->name }}
                        @else
                           {{ ucfirst($citem->product->category) }}'s {{ $citem->product->subCategory->name }} Shoes
                        @endif
                     </p>
                     <div class="item-selecton">
                        <p>Size: {{$citem->product_size}}</p>
                        <p>Quantity: {{$citem->product_quantity}}</p>
                     </div>
                     <p class="item-price">₱ {{number_format($citem->product->selling_price, 2)}}</p>
                  </div>
               </div>
            @endforeach
            <hr style="margin-top: 20px;">
            <p class="total-price"><b>Total Price:</b> <span>₱ {{number_format($totalPrice, 2)}}</span></p>
            <button type="submit" class="checkout-button" style="background-color: #F6BF31;" name="place-order">Place Order</button>
         </div>
      </form>
   </main>

   {{-- FOOTER --}}
   @include('partials._footer')
</body>
</html>
