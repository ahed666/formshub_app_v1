

   var slider= document.getElementById('slider');
   var index=0;
   var idleInterval;
   var media;
   var blob;
   var blobUrl;
   var owl;
   document.addEventListener('DOMContentLoaded', function () {

        Livewire.emit('startform');

   });
   // auto refresh to handle session expiry
    function AutoRefresh(){


        window.location.reload();
    }
    //interval eery hour to auto refresh page by use autorefresh function
    setInterval(AutoRefresh, 3600000);//3600000

   document.addEventListener('featched',(e)=>{
        media=e.detail.media;
        FormSettings=e.detail.FormSettings;

       if(media.length>0){
        showMedia();
        
        if(FormSettings.allow_touch==true)
            initalButtons();
       }
    //   there is no media
       else{
        slider.innerHTML=`
        <div class="grid grid-rows-4 h-full justify-center items-center bg-white  ">
        <div class="row-span-2 grid ">
            <div class="flex justify-center items-center">
                <img class="w-28 h-28 object-contain" src="${app_url}/images/exclamation_mark.gif" alt="">
            </div>

            <div class="flex justify-center items-center"><span class="text-xl text-black text-center ">No Media</span></div>
        </div>



        <div class="grid row-span-2 justify-center items-center">
            <span class="text-md text-black">No Media</span>
            <div class="row-span-1 flex justify-center items-center hover:cursor-pointer">
                <a onclick="RecheckPage()" class="text-secondary_blue font-bold ">
                <span id="recheckText">RECHECK</span>

                </a>
            </div>
        </div>

        </div>

        `;
       }
      });
     function initalButtons(){

            document.getElementById('ControlButtons').innerHTML=`
          <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                <svg onclick="backSlider()" id="prev" class="opacity-50 w-8 h-8 text-secondary_blue hover:cursor-pointer" fill="currentColor"  viewBox="0 0 24 24" id="previous" data-name="Flat Color" xmlns="http://www.w3.org/2000/svg" class="icon flat-color" transform="rotate(0)">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                <g id="SVGRepo_iconCarrier">
                                <path id="primary" d="M17.45,2.11a1,1,0,0,0-1.05.09l-12,9a1,1,0,0,0,0,1.6l12,9a1,1,0,0,0,1.05.09A1,1,0,0,0,18,21V3A1,1,0,0,0,17.45,2.11Z" style="fill: currentColor;"/>
                                </g>
                                </svg>
                                <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                <svg onclick="nextSlider()" fill="currentColor" id="next" class="opacity-50 w-8 h-8 text-secondary_blue hover:cursor-pointer" viewBox="0 0 24 24" id="previous" data-name="Flat Color" xmlns="http://www.w3.org/2000/svg" class="icon flat-color" transform="rotate(180)">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                <g id="SVGRepo_iconCarrier">
                                <path id="primary" d="M17.45,2.11a1,1,0,0,0-1.05.09l-12,9a1,1,0,0,0,0,1.6l12,9a1,1,0,0,0,1.05.09A1,1,0,0,0,18,21V3A1,1,0,0,0,17.45,2.11Z" style="fill: currentColor;"/>
                                </g>
                                </svg>`;

     }

    function showMedia(){
                clearInterval(idleInterval);

        if(index<media.length){
        
        if(media[index].type=="video"){
        videoContents= media[index].blob;
        slider.innerHTML=` <div class="item">
            <video id="video" class="w-full h-[100vh]" autoplay    >
                <source src="data:video/mp4;base64,${videoContents}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>`;
        var video=document.getElementById('video');
       video.muted = true;
        
        video.volume = getVolume(media[index].volume);
        video.muted = media[index].mute;
       video.play();
        var time=media[index].duration*1000;
    
        index+=1;
        idleInterval = setInterval(function () {showMedia();},time );}
        else if(media[index].type=="image"){
            imageContents= media[index].blob;
        slider.innerHTML=` <div class="item">
            <img  class="w-[100vw] h-[100vh] object-fit" src="data:image/png;base64,${imageContents}"></img>

        </div>`;
        var time=media[index].duration*1000;
        index+=1;
        idleInterval = setInterval(function () {showMedia();},time );
        }
        }

        else{
                index=0;
                if(FormSettings.allow_loop)
                showMedia();
        }

    }


   function backSlider(){
    
    index-=2;
    if(index<0)index=0;//or media.length-1
    showMedia();
   }

   function nextSlider(){
    

    showMedia();
   }
   
   function getVolume(volume){
       console.log(volume);
      dynamicVolume= parseInt(volume,10)/100
       if (!isNaN(dynamicVolume) && isFinite(dynamicVolume)) {
        // Set the volume with the valid value
       return dynamicVolume;
    } else {
        // Handle the case where the value is NaN or Infinite
      return 0;
    }
   }



