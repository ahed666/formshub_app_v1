<html>
    <head>
        <title>{{ __('login') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/fav_icon/favicon.ico') }}">
    </head>
    <body>


 </div>

<x-guest-layout>
    <x-jet-validation-errors class="mb-4" />
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if (session('error'))
    <div id="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">

        <span>{{ __('The server has detected too many repeated login attempts, please try again in:') }}</span> <span id="count" ></span>
    </div>
    @else

       @if(isset($guard))
       @livewire('loginform',['guard'=>$guard])
       @else
       @livewire('loginform')
       @endif
    @endif
</x-guest-layout>
<script>

    // for disable resend button for 2 minutes
    var btn = document.getElementById("login");

    var count=120;
    var timer = null;  // For referencing the timer

    (function countDown(){
           // Display counter and start counting down


      // Run the function again every second if the count is not zero
      if(count !== 0){
        timer = setTimeout(countDown, 1000);
        count--; // decrease the timer
      } else {
        // Enable the button
        btn.removeAttribute("disabled");


      }
    }());
            </script>

@if(Session::has('error'))
<script>

     var btn = document.getElementById("login");
    var div=document.getElementById("error");

    var count = {{ Session::get('error') }};
var spn = document.getElementById("count");
    // Set count
var timer = null;  // For referencing the timer
// spn.textContent=count;
(function countDown(){
    var m = Math.floor(count/60);
    var s = count - m * 60;
    var mDisplay = m > 0 ? (m < 10 ? "0" + m  : m ) : "00";
    var sDisplay = s > 0 ? (s < 10 ? "0" + s : s) : "00";
       // Display counter and start counting down

       spn.textContent = mDisplay+" m "+sDisplay+" s";

    // Run the function again every second if the count is not zero
    if(count !== 0){
        btn.setAttribute("disabled","");
        timer = setTimeout(countDown, 1000);
        // decrease the timer
    } else {
        // Enable the button
        div.classList.add("hidden");
        btn.removeAttribute("disabled");
        spn.textContent ="";

    }
}());
</script>
@endif
@livewireScripts()

</body>
</html>
