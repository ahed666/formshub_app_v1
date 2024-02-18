<div>
@if ($currentkiosk->type=="video")
<div class=" w-[100vw] h-[100vh]">

<video autoplay muted loop id="standbyVideo" class=" inset-0 w-full h-full object-contain">
    <source src="{{ asset($currentkiosk->path)}}" type="video/mp4">
  </video>
</div>
@else
<div style="background-image: url('{{ asset($currentkiosk->path)}}');background-repeat: no-repeat; background-size: cover;" class="bg-white  overflow-hidden h-[100vh]  touch-manipulation">

</div>

@endif
</div>
@push('scripts')
    <script>
        function AutoRefresh()
        {

            window.location.reload();
        }
        //interval eery hour to auto refresh page by use autorefresh function
        setInterval(AutoRefresh, 3600000);
        window.addEventListener('livewire:load', function () {
            console.log( video=document.getElementById('standbyVideo'));
            try {

                video=document.getElementById('standbyVideo');
                video.muted = false;

                } catch (error) {
                console.log(error);
                }


        })

    </script>
@endpush
