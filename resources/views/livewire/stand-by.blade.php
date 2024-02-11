<div style="background-image: url('{{ asset($currentkiosk->standbyimage_path)}}');background-repeat: no-repeat; background-size: cover;" class="bg-white  overflow-hidden h-[100vh]  touch-manipulation">

</div>
@push('script')
    <script>
        function AutoRefresh()
        {

            window.location.reload();
        }
        //interval eery hour to auto refresh page by use autorefresh function
        setInterval(AutoRefresh, 3600000);
    </script>
@endpush
