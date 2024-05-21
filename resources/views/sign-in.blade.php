<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   {{-- CSS LINK --}}
   <link rel="stylesheet" href="{{ asset('css/sign-in.css') }}">
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

   <title>Sign in | SoleAce</title>
</head>

<body>
   <!-- This session will handle the SweetAlert2 toast messages -->
    @if (session('success'))
      <!-- THIS HIDDEN INPUT WILL BE USED IN JS -->
      <input id="toastMsg-input" type="hidden" value="{{session('success')}}">
    @endif

   <!-- NAVIGATION -->
   <nav>
      <div class="business-logo-container">
         <a href="/">
            <img class="business-logo" src="{{asset('images/business-logo.png')}}" alt="An image of a business logo">
         </a>
      </div>
   </nav>

   {{-- SIGN IN FORM --}}
   <main>
       <form action="{{route('user.signIn')}}" method="post" class="signin-container" id="signin-form">
         @csrf

         <h1 class="form-title">Sign in</h1>

         <!-- EMAIL INPUT -->
         <div class="text-input-container form-control">
            <label for="email">Email</label>
            <input class="@error('email') error @enderror" type="email" name="email" id="email" placeholder="Enter email address" value="{{ old('email') }}">
            @error('email')
               <div class="alert-container">
                  <i class="fa-solid fa-exclamation"></i>
                  <small>{{$message}}</small>
               </div>
            @enderror
         </div>

         <!-- PASSWORD INPUT -->
         <div class="password-input-container form-control">
            <label for="password">Password</label>
            <input class="@error('password') error @enderror" type="password" name="password" id="password" placeholder="Enter password">
            @error('password')
               <div class="alert-container">
                  <i class="fa-solid fa-exclamation"></i>
                  <small>{{$message}}</small>
               </div>
            @enderror
         </div>

         <button type="submit" class="signin-btn" name="signin">Sign in</button>

         <p class="account-action">Don't have an account? <a href="{{route('sign-up.render')}}">Sign up</a></p>
      </form>
   </main>

   {{-- FOOTER --}}
   @include('partials._footer')
</body>

</html>