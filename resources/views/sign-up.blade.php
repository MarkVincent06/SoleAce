<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   {{-- CSS LINK --}}
   <link rel="stylesheet" href="{{ asset('css/sign-up.css') }}">
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

   <title>Sign up | SoleAce</title>
</head>

<body>
   <!-- This session will handle the SweetAlert2 toast messages -->
    @if (session('error'))
      <!-- THIS HIDDEN INPUT WILL BE USED IN JS -->
      <input id="toastMsg-input" type="hidden" value="{{session('error')}}">
    @endif

   <!-- NAVIGATION -->
   <nav>
      <div class="business-logo-container">
         <a href="/">
            <img class="business-logo" src="{{asset('images/business-logo.png')}}" alt="An image of a business logo">
         </a>
      </div>
   </nav>

   {{-- SIGN UP FORM --}}
   <main>
      <form action="{{route('user.register')}}" method="POST" class="signup-container" id="signup-form">
         @csrf

         <h1 class="form-title">Create account</h1>

         <!-- FIRST NAME INPUT -->
         <div class="text-input-container form-control">
            <label for="firstname">First name</label>
            <input class="@error('firstname') error @enderror" type="text" name="firstname" id="firstname" placeholder="Enter first name" value="{{ old('firstname') }}">
            @error('firstname')
               <div class="alert-container">
                  <i class="fa-solid fa-exclamation"></i>
                  <small>{{$message}}</small>
               </div>
            @enderror
         </div>

         <!-- LAST NAME INPUT -->
         <div class="text-input-container form-control">
            <label for="lastname">Last name</label>
            <input class="@error('lastname') error @enderror" type="text" name="lastname" id="lastname" placeholder="Enter last name" value="{{ old('lastname') }}">
            @error('lastname')
               <div class="alert-container">
                  <i class="fa-solid fa-exclamation"></i>
                  <small>{{$message}}</small>
               </div>
            @enderror
         </div>

         <!-- EMAIL INPUT -->
         <div class="text-input-container form-control">
            <label for="email">Email</label>
            <input class="@error('email') error @enderror" type="text" name="email" id="email" placeholder="Enter email address" value="{{ old('email') }}">
            @error('email')
               <div class="alert-container">
                  <i class="fa-solid fa-exclamation"></i>
                  <small>{{$message}}</small>
               </div>
            @enderror
         </div>

         <!-- NUMBER INPUT -->
         <div class="number-input-container form-control">
            <label for="phone">Phone number</label>
            <input class="@error('phone') error @enderror" type="number" name="phone" id="phone" placeholder="Enter phone number" value="{{ old('phone') }}">
            @error('phone')
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
            @unless($errors->has('password'))
               <small class="password-tip"><i class="fa-solid fa-lightbulb"></i>Password must contain at least 6 characters</small>
            @endunless
            @error('password')
               <div class="alert-container">
                  <i class="fa-solid fa-exclamation"></i>
                  <small>{{$message}}</small>
               </div>
            @enderror
         </div>

         <!-- CONFIRM PASSWORD INPUT -->
         <div class="password-input-container form-control">
            <label for="confirm-password">Confirm password</label>
            <input class="@error('password_confirmation') error @enderror" type="password" name="password_confirmation" id="confirm-password" placeholder="Re-enter password">
            @error('password_confirmation')
               <div class="alert-container">
                  <i class="fa-solid fa-exclamation"></i>
                  <small>{{$message}}</small>
               </div>
            @enderror
         </div>

         <button type="submit" class="signup-btn" name="signup">Sign up</button>

         <p class="account-action">Already have an account? <a href="{{route('sign-in.render')}}">Sign in</a></p>
      </form>
   </main>

   {{-- FOOTER --}}
   @include('partials._footer')
</body>

</html>