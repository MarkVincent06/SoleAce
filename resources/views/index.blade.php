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

   <title>Home | SoleAce</title>
</head>
<body>
   {{-- NAVIGATION --}}
   @include('partials._navigation')
   
   <main>
      {{-- HERO --}}
      <section class="hero">
         <h1 class="hero--slogan">Unleash Your Sole<br> Power With<br> <span>SoleAce</span></h1>
         <img class="hero--shoe-item" src="{{asset('images/hero-shoe-item.png')}}" alt="A picture of a big shoe">
      </section>

      {{-- FEATURED PRODUCTS --}}
   </main>

   {{-- FOOTER --}}
   @include('partials._footer')
</body>
</html>
