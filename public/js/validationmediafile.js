
var maxSizeInBytes= 10 * 1024 * 1024;//10MB
var duration =180;
function validateVideo() {
    console.log('test');
    var input = document.getElementById('file');
    var file = input.files[0];

    if (file) {
        // Check video file type
        if (file.type.startsWith('video/')) {
            

            // Check video file size (adjust the limit as needed)

            if (file.size <= maxSizeInBytes) {
                console.log('Valid video file size:', file.size);
                var reader = new FileReader();
                reader.onload = function (e) {
                    var video = document.createElement('video');
                    video.addEventListener('loadedmetadata', function () {
                        var durationInSeconds = Math.round(video.duration);
                        console.log('Video duration in seconds: ', durationInSeconds);
                        if(durationInSeconds>duration)
                        errorWarning(translations.maxvideodurationwarning.replace(':duration',duration));



                    });
                    video.src = e.target.result;
                };
                reader.readAsDataURL(file);

            } else {
                errorWarning(translations.maxfilesizewarning.replace(':size',maxSizeInBytes/(1024*1024)));

                // Optionally reset the file input to clear the selected file
                input.value = '';
            }
        }
         else if (file.type.startsWith('image/')) {
               
        }
        
        else {
            console.log('Valid error ');
            errorWarning(translations.errorinfile);

            // Optionally reset the file input to clear the selected file
            input.value = '';
        }
    } else {
        console.error('No video file selected.');
    }
}

function errorWarning(errorMessage){
    Swal.fire({
        icon: 'error',
        title: 'error',
        text: errorMessage,
        confirmButtonColor:'#1277D1',
        })
}
