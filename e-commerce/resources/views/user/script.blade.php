
    <!-- Bootstrap core JavaScript -->
    <script src="{{asset("user")}}/vendor/jquery/jquery.min.js"></script>
    <script src="{{asset("user")}}vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


    <!-- Additional Scripts -->
    <script src="{{asset("user/assets")}}/js/custom.js"></script>
    <script src="{{asset("user/assets")}}/js/owl.js"></script>
    <script src="{{asset("user/assets")}}/js/slick.js"></script>
    <script src="{{asset("user/assets")}}/js/isotope.js"></script>
    <script src="{{asset("user/assets")}}/js/accordions.js"></script>


    <script language = "text/Javascript"> 
      cleared[0] = cleared[1] = cleared[2] = 0; //set a cleared flag for each field
      function clearField(t){                   //declaring the array outside of the
      if(! cleared[t.id]){                      // function makes it static and global
          cleared[t.id] = 1;  // you could use true and false, but that's more typing
          t.value='';         // with more chance of typos
          t.style.color='#fff';
          }
      }
    </script>