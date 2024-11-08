@include("user.head")

@yield('title')

  <body>

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>  
    <!-- ***** Preloader End ***** -->

    <!-- Header -->
    @include("user.header")

    <!-- Page Content -->
    <!-- Banner Starts Here -->
   @include("user.banner")
    <!-- Banner Ends Here -->

    @yield('latest')
    {{-- @include("user.latest") --}}

   {{-- @include("user.body") --}}

    
    @include("user.footer")

    @include("user.script")


  </body>

</html>