    <nav>
         <a href="/" class="business-logo-container">
            <img class="business-logo" src="{{asset('images/business-logo.png')}}" alt="An image of a business logo">
         </a>

         <ul class="categories">
            <li>
               New & Featured
               <ul class="dropdown-menu">
                  <li><a href="{{route('new-arrivals')}}">New Arrivals</a></li>
                  <li><a href="{{route('featured-shoes')}}">Featured Shoes</a></li>
               </ul>
            </li>

            <li>
               Men

               <ul class="dropdown-menu">
                  <li><a href="{{route('men-shoes', ['subcategory' => 'all'])}}">All Shoes For Men</a></li>
                  @if(count($subcategories) > 0)
                     @foreach($subcategories as $subcategory)
                        @if($subcategory->category === "men")
                           <li><a href="{{route('men-shoes', ['subcategory' => strtolower($subcategory->name)])}}">{{$subcategory->name}}</a></li>
                        @endif
                     @endforeach
                  @endif
               </ul>
            </li>

            <li>
               Women

               <ul class="dropdown-menu">
                  <li><a href="{{route('women-shoes', ['subcategory' => 'all'])}}">All Shoes For Women</a></li>
                  @if(count($subcategories) > 0)
                     @foreach($subcategories as $subcategory)
                        @if($subcategory->category === "women")
                           <li><a href="{{route('women-shoes', ['subcategory' => strtolower($subcategory->name)])}}">{{$subcategory->name}}</a></li>
                        @endif
                     @endforeach
                  @endif
               </ul>
            </li>

            
            <li>
               Kids

               <ul class="dropdown-menu">
                  <li><a href="{{route('kid-shoes', ['subcategory' => 'all'])}}">All Shoes For Kids</a></li>
                  @if(count($subcategories) > 0)
                     @foreach($subcategories as $subcategory)
                        @if($subcategory->category === "kid")
                           <li><a href="{{route('kid-shoes', ['subcategory' => strtolower($subcategory->name)])}}">{{$subcategory->name}}</a></li>
                        @endif
                     @endforeach
                  @endif
               </ul>
            </li>
         </ul>

         @auth
            <div class="account-logged-in">
                  <h3 class="username">Hi, {{auth()->user()->firstname}}</h3>

                  <div class="account-dropdown-menu">
                     <a href="{{route('myOrder.render')}}" class="sign-out-link">My Orders</a>
                     <form action="{{route('user.signOut')}}" method="post">
                        @csrf
                        <button class="sign-out-link" type="submit">Sign Out</button>
                     </form>
                  </div>
               </div>
         @else
            <a class="sign-in-link" href="{{route('sign-in.render')}}">
               <h3>Sign in</h3>
            </a>
         @endauth

         <a href="{{route('cart.render')}}" class="shopping-cart-link" id="shopping-cart-link">
            <i class="fa-solid fa-cart-shopping shopping-cart"></i>
         </a>

      </nav>