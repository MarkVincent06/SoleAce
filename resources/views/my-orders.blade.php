<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   {{-- CSS LINK --}}
   <link rel="stylesheet" href="{{ asset('css/my-orders.css') }}">
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

   <title>My Orders | SoleAce</title>
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
      <h1>My Orders</h1>
      <table class="content-table">
         <thead>
            <tr>
               <th>No.</th>
               <th>Tracking No.</th>
               <th>Total Price</th>
               <th>Payment Method</th>
               <th>Status</th>
               <th>Date</th>
               <th></th>
            </tr>
         </thead>
         <tbody>
            @unless(count($orders) > 0)
               <tr>
                  <td colspan="6">It seems like you haven't placed any orders yet. Start exploring our products and make your first purchase today!</td>
               </tr>
            @else 
               @foreach ($orders as $index => $order)
                   <tr>
                     <td>{{ $index + 1 }}</td>
                     <td>{{$order->tracking_no}}</td>
                     <td>₱ {{number_format($order->total_price, 2)}}</td>
                     @php
                        if ($order->payment_method === "cod") {
                           $payment_method = "Cash on Delivery";
                        } elseif ($order->payment_method === "card") {
                           $payment_method = "Credit/Debit Card";
                        } elseif ($order->payment_method === "netbanking") {
                           $payment_method = "Net Banking";
                        }
                     @endphp
                     <td>{{$payment_method}}</td>
                     @php
                        if ($order->status == 0) {
                           $status = "Pending";
                        } elseif ($order->status == 1) {
                           $status = "Delivered";
                        } elseif ($order->status == 2) {
                           $status = "Cancelled";
                        }
                     @endphp
                     <td>{{$status}}</td>
                     <td>{{$order->created_at}}</td>
                     <td><a class="view-button" href="{{route('viewOrder.render', ['trackingNo' => $order->tracking_no])}}">View Details</a></td>
                  </tr>
               @endforeach
            @endunless
         </tbody>
      </table>
   </main>

   {{-- FOOTER --}}
   @include('partials._footer')
</body>
</html>
