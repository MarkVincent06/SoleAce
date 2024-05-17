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

   <title>Sign in | SoleAce</title>
</head>

<body>
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
       <form action="/" method="post" class="signin-container" id="signin-form">
         <h1 class="form-title">Sign in</h1>

         <!-- EMAIL INPUT -->
         <div class="text-input-container form-control">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" placeholder="Enter email address">
            <div class="alert-container">
               <i class="fa-solid fa-exclamation"></i>
               <small></small>
            </div>
         </div>

         <!-- PASSWORD INPUT -->
         <div class="password-input-container form-control">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Enter password">
            <div class="alert-container">
               <i class="fa-solid fa-exclamation"></i>
               <small></small>
            </div>
         </div>

         <button type="submit" class="signin-btn" name="signin">Sign in</button>

         <p class="account-action">Don't have an account? <a href="{{route('sign-up.render')}}">Sign up</a></p>
      </form>
   </main>

   {{-- FOOTER --}}
   @include('partials._footer')
</body>

</html>