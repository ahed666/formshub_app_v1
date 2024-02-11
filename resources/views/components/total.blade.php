<div class=" text-sm xs:text-xs grid justify-start  items-center text-left ">
                        <span class=" mr-[2px]  ">{{ $title }}</span>
                        <span class= "{{$subscribenum<=$total?"text-primary_red font-bold":"text-secondary_blue" }}
                            text-md text-center">{{ $total }}{{ __('/') }}{{ $subscribenum }}</span>
</div>
