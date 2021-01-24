<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Sneakers | @yield('title')</title>

        <link rel="shortcut icon" href="{{ asset('img/sneaker-icon.png') }}">
        @include('aos.aos-css')

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{ asset('js/pre-loader.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

    </head>
    <body>
        <div class="loader">
            <img src="{{ asset('img/loading.gif') }}"  alt="Loading..."/>
        </div>
        <div id="app">

            <nav id='nav'>
                <ul class='menu'>
                    <li>

                        <div class="dropdown">
                            <a href="{{route('products.all')."?gender=M"}}" class="dropbtn">Man<i class="fas fa-sort-down"></i></a>
                            <div class="dropdown-content">
                                <a href="{{route('products.all')."?gender=M"}}">All our products</a>
                                <a href="{{route('products.all')."?gender=M&order=discount"}}">Offers</a>
                                <a href="#">Most sold</a>
                            </div>
                        </div> 
                    </li>

                    <li>
                        <div class="dropdown">
                            <a href="{{route('products.all')."?gender=W"}}" class="dropbtn">Woman<i class="fas fa-sort-down"></i></a>
                            <div class="dropdown-content">
                                <a href="{{route('products.all')."?gender=W"}}">All our products</a>
                                <a href="{{route('products.all')."?gender=M&order=discount"}}">Offers</a>
                                <a href="#">Most sold</a>
                            </div>
                        </div> 
                    </li>
                    <li>
                        <div class="dropdown">
                            <a href="{{route('products.all')."?gender=M&kids=1"}}" class="dropbtn">Boy<i class="fas fa-sort-down"></i></a>
                            <div class="dropdown-content">
                                <a href="{{route('products.all')."?gender=M&kids=1"}}">All our products</a>
                                <a href="{{route('products.all')."?gender=M&kids=1&order=discount"}}">Offers</a>
                                <a href="#">Most sold</a>
                            </div>
                        </div> 
                    </li>

                    <li>
                        <div class="dropdown">
                            <a href="{{route('products.all')."?gender=W&kids=1"}}" class="dropbtn">Girl<i class="fas fa-sort-down"></i></a>
                            <div class="dropdown-content">
                                <a href="{{route('products.all')."?gender=W&kids=1"}}">All our products</a>
                                <a href="{{route('products.all')."?gender=W&kids=1&order=discount"}}">Offers</a>
                                <a href="#">Most sold</a>
                            </div>
                        </div> 
                    </li>
                </ul>
                <div class="burger">
                    <div class="line1"></div>
                    <div class="line2"></div>
                    <div class="line3"></div>
                </div>

                <div id='logo'>
                    <a href="{{route('home')}}">Sneakers</a>
                </div>



                <div class='user-nav'>
                    @guest
                    @if (Route::has('login'))
                    <a class="nav-link login" href="{{ route('login') }}"><i class="fas fa-user mr-1"></i></i>{{ __('Login') }}</a>
                    @endif

                    @else

                    <div class="search-in">
                        <form method="GET" action="{{route('search')}}">
                            <input type="text" name="search-in" class="form-control" placeholder="search products...">
                            <button style="border: 0; background: none;"><i class="fas fa-search search-icon"></i></button>
                        </form>
                    </div>
                    <div class="shopping-cart" >
                        <a class="nav-link cart-icon" href="{{ route('cart.index') }}"><i class="fas fa-shopping-cart"></i></a>
                        <div class="count-cart-items">
                            <span>{{count(\CountCartItem::countItems())}}</span>
                        </div>
                    </div>
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        @if(\Auth::user()->image != null)
                        <img src="{{url('user/avatar/'.Auth::user()->image)}}" class="avatar2"/>
                        @else
                        <img src='{{ asset('img/user.png') }}' class="avatar2"/>
                        @endif
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <div class="text-center border-bottom pb-1">
                            <span class="">{{\Auth::user()->name}}</span>
                        </div>

                        @if(\Auth::user()->role == 'admin')
                        <a class="dropdown-item" href="{{ route('admin') }}"><i class="fas fa-lock mr-1"></i>Administration</a>
                        @endif
                        <a class="dropdown-item" href="{{ route('address.index') }}"><i class="fas fa-address-card mr-1"></i>My addresses</a>
                        <a class="dropdown-item" href="{{ route('order.user.all') }}"><i class="fas fa-shopping-bag mr-1"></i>My orders</a>
                        <a class="dropdown-item" href="{{ route('config') }}"><i class="fas fa-cog mr-1"></i>Settings</a>
                        <a class="dropdown-item" href="{{ route('home') }}"
                           onclick="event.preventDefault();
    document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt mr-1"></i>{{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                    @endguest
                </div>
            </nav>

            <main class="py-4">
                @yield('content')
            </main>
        </div>
        <footer id='footer'>

            <div class='column-footer'>
                <h3>Client</h3>
                <div class='column'>
                    <a href="{{ route('config') }}">My account</a>
                    <a href="{{ route('contact') }}">Contact</a>
                    <a href="{{ route('privacy') }}">Privacy Policy</a>
                    <a href="{{ route('ship-nd-returns') }}">Shipping & Returns</a>
                </div>
            </div>


            <div class='column-footer'>
                <h3>Categories</h3>
                <div class='column'>
                    @foreach(\CategoriesForHome::catsForHome() as $cat)
                    <a href="{{ route('products.category', ['id' => $cat->id]) }}">{{$cat->name}}</a>
                    @endforeach
                </div>
            </div>


            <div class='column-footer'>
                <h3>Contact us</h3>
                <div class='column'>
                    <span><strong>Telephone </strong>+34 666 666 666</span>
                    <span><strong>Email </strong>admin@sneakers.es</span>
                    <div class='social-networks'>
                        <span><i class="fab fa-facebook-f"></i></span>
                        <span><i class="fab fa-instagram"></i></span>
                        <span><i class="fab fa-twitter"></i></span>
                    </div>
                </div>
            </div>


        </footer>
        <div style="background:#fff;">
            <div class="hr"></div>

            <div class="credits">
                <span>Website created by jagcweb</span>
                <div class="credits-social">
                    <a href="https://github.com/jagcweb/" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                    <a href="https://es.linkedin.com/in/jagcweb" target="_blank"><i class="fab fa-github"></i></a>
                    
                </div>
            </div>

        </div>
        @include('aos.aos-js')
        <script src="{{ asset('js/nav-styles.js') }}" defer></script>
    </body>
</html>
