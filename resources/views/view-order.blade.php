<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   {{-- CSS LINK --}}
   <link rel="stylesheet" href="{{ asset('css/view-order.css') }}">
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

   <title>View Order | SoleAce</title>
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
      <div class="order-summary-header">
         <h1 class="order-summary-title">Order Summary</h1>
         <a class="back-button" href="{{route('myOrder.render')}}">Back <i class="fa fa-reply" style="margin-left: 7px"></i></a>
      </div>
      <div class="container">

         <div class="delivery-details">
            <h2 class="order-title">Delivery Details</h2>
            <div class="form-group">
               <label for="name">Name:</label>
               <input type="text" id="name" value="{{$order->name}}" disabled>
            </div>
            <div class="form-group">
               <label for="email">Email:</label>
               <input type="text" id="email" value="{{$order->email}}" disabled>
            </div>
            <div class="form-group">
               <label for="contact-no">Contact No:</label>
               <input type="text" id="contact-no" value="{{$order->phone}}" disabled>
            </div>
            <div class="form-group">
               <label for="contact-no">Tracking No:</label>
               <input type="text" id="contact-no" value="{{$order->tracking_no}}" disabled>
            </div>
            <div class="form-group">
               <label for="address">Address:</label>
               <input type="text" id="address" value="{{$order->address}}" disabled>
            </div>
            <div class="form-group">
               <label for="zip">Zip Code:</label>
               <input type="text" id="zip" value="{{$order->zip_code}}" disabled>
            </div>
            <div class="form-group">
               <label for="payment">Payment Method:</label>
               @php
               if ($order->payment_method === "cod") {
                  $selectedPaymentMethod = "Cash on Delivery (COD)";
               } elseif ($order->payment_method === "card") {
                  $selectedPaymentMethod = "Credit/Debit Card";
               } elseif ($order->payment_method === "netbanking") {
                  $selectedPaymentMethod = "Net Banking";
               }
               @endphp
               <input type="text" id="zip" value="{{$selectedPaymentMethod}}" disabled>
            </div>
            <div class="form-group">
               <label for="status">Status:</label>
                @php
                  if ($order->status == 0) {
                     $status = "Pending";
                  } elseif ($order->status == 1) {
                     $status = "Delivered";
                  } elseif ($order->status == 2) {
                     $status = "Cancelled";
                  }
               @endphp
               <input type="text" id="status" value="{{$status}}" disabled>
            </div>
         </div>

         <div class="order-items">
            <h2 class="order-title">Ordered Items</h2>
            <hr style="margin-bottom: 20px; margin-top: -10px">

           @foreach($orderItems as $item)
               <div class="order-item">
                  <img src="{{ asset('images/' . $item->product->image) }}" alt="An image of a product">
                  <div class="item-details">
                     <h3 class="item-name">{{$item->product->name}}</h3>
                     <p class="item-subcategory">
                       @if($item->product->subCategory->name === "Boys" || $item->product->subCategory->name === "Girls")
                           Kid's Shoes
                        @elseif($item->product->subCategory->name === "Sneakers")
                           {{ ucfirst($item->product->category) }}'s {{ $item->product->subCategory->name }}
                        @else
                           {{ ucfirst($item->product->category) }}'s {{ $item->product->subCategory->name }} Shoes
                        @endif
                     </p>
                     <div class="item-selecton">
                        <p>Size: {{$item->product_size}}</p>
                        <p>Quantity: {{$item->product_quantity}}</p>
                     </div>
                     <p class="item-price">₱ {{number_format($item->product_price, 2)}}</p>
                  </div>
               </div>
            @endforeach
            <hr style="margin-top: 20px;">
            <p class="total-price"><b>Total Price:</b> <span>₱ {{number_format($order->total_price, 2)}}</span></p>

         </div>
      </div>
   </main>

   {{-- FOOTER --}}
   @include('partials._footer')
</body>
</html>
