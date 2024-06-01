let answerIndex = 0;
let chars=["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
"AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT","AU","AV","AW","AX","AY","AZ"
];
let questionType;


let answers = [];
let questionAnswersData;
    function setData(data){
        questionAnswersData=data;

    }
    function loadJsonData(type) {
        return fetch(`/data/${type}.json`)
            .then(response => response.json())
            .then(data => {
                return data; // Return the data from the promise
            })
            .catch(error => console.error('Error loading JSON file:', error));
    }
   function initQuestion(type,local){
    questionType=type;


    console.log(questionType);
    if(questionType=="yes_no"||questionType=="like_dislike"||questionType=="Agree_Disagree"||questionType=="satisfaction"||questionType=="rating")
    {
        loadJsonData(questionType).then(data => {
            questionAnswersData = data;
            text= questionAnswersData[local];

            if(questionType=="yes_no")
                {

                    for (const key in text) {
                        if (text.hasOwnProperty(key)) {
                            console.log(`${key}: ${text[key]}`);
                            createAnswer(text[key],null);

                        }
                    }

                }
            // You can add further logic here to use questionAnswersData
        }).catch(error => {
            console.error('Error:', error);
        });



        // Use the data here




    }
    else{

    }
   }
function addAnswer(){
    createAnswer('',defaultImageSrc)
}

function createAnswer(value,image) {

    const answer = {
        id: answerIndex,
        imageSrc:image,
         hide:false,
         score:0,
         action:'None',
        value: value
    };

    answers.push(answer);
    renderAnswer(answerIndex);
    answerIndex++;
}
function logicAnswerComponent(answer){
    return `

    <div class=" border-gray-300 peer-checked:drop-shadow-lg peer-checked:bg-blue-100 peer-checked:text-blue-600 peer-checked:font-bold peer-checked:text-xl w-48 max-w-48 min-w-32 h-16
    flex justify-center items-center p-2   text-gray-500 bg-white border-[2px] rounded-lg cursor-pointer
  peer-checked:border-blue-400
 hover:text-gray-600 hover:bg-gray-100 ">
         <input type="hidden" name="answers[${answer.id}][value]" id="answers[${answer.id}][value]" value="${answer.value}" />
        <span class="text-black  text-xl  text-center pointer-events-none ">
            ${answer.value}
        </span>
    </div>

    <div class=" h-auto grid grid-cols-12  justify-center mt-[2px] pl-2 ">

       <div class="col-span-3">${scoreAnswerComponent(answer.id)}</div>
        <div class="col-span-9 px-2 py-1">${actionAnswerComponent(answer.id)}</div>
    </div>

    `;
}



function mcq_imageAnswerComponent(answer){
   return `
        <div class="flex justify-between items-center">
            <div><span class="whitespace-nowrap text-sm font-bold" id="char-${answer.id}"></span></div>
            ${deleteAnswerComponent(answer.id)}
        </div>

        <div id="answerimagediv-${answer.id}" class="mt-2 flex justify-center">
            <div class="border-[1px] border-gray-300 p-[2px] rounded-lg w-[100px] h-[100px]">
                <img id="answers[${answer.id}][imagesrc]" name="answers[${answer.id}][imagesrc]" class="w-full h-full object-contain block ml-auto mr-auto" src="${answer.imageSrc}" alt="">
                <label class="items-center w-4 relative flex bottom-[10px] right-[8px] bg-green-300 border-[1px] rounded-2xl" for="answers[${answer.id}][image]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
                    </svg>
                    <input onchange="uploadImage(event, ${answer.id})" class="image opacity-0 absolute -z-10" type="file" value="null" name="answers[${answer.id}][image]" id="answers[${answer.id}][image]" accept="image/*">
                </label>
            </div>
        </div>
        <div id="answervaluediv-${answer.id}" class="mt-2 flex justify-center w-full">
            <div class="w-full">
                <textarea maxlength="80" rows="3" class="resize-none focus:shadow-none focus:border-b-2 focus:border-t-0 focus:border-l-0 focus:border-r-0 shadow-none border-t-0 border-r-0 border-l-0 border-b-2 outline-none w-full" name="answers[${answer.id}][value]" id="answers[${answer.id}][value]" required></textarea>
            </div>
        </div>
        <div class="px-4 w-full h-auto grid grid-cols-12  justify-center mt-[1px] ">


            <div class="col-span-3 ">${scoreAnswerComponent(answer.id)}</div>

            <div class="col-span-3 ">${hideAnswerComponent(answer.id)}</div>
            <div class="col-span-6 ">${actionAnswerComponent(answer.id)}</div>


        </div>

    `;
}

function createAnswerDiv(answer){
    if(questionType=="yes_no"||questionType=="like_dislike"||questionType=="Agree_Disagree"||questionType=="satisfaction"||questionType=="rating")
    {
        let AnswerDiv = document.createElement('div');
        AnswerDiv.id = `list${answer.id}`;
        AnswerDiv.className = 'mx-4';
        AnswerDiv.innerHTML = logicAnswerComponent(answer);
        return AnswerDiv;
    }
    else{
        let AnswerDiv = document.createElement('div');
        AnswerDiv.id = `list${answer.id}`;
        AnswerDiv.className = 'p-1 col-span-3 border-[1px] border-gray-300 rounded-lg';
        AnswerDiv.innerHTML = mcq_imageAnswerComponent(answer);
        document.getElementById(`char-${answer.id}`).innerText=chars[answers.length-1];

        return AnswerDiv;
    }
}
function renderAnswer(index) {
    const answersDiv = document.getElementById('answers');
    const answer = answers.find(a => a.id === index);

    const newAnswerDiv= createAnswerDiv(answer);
    console.log(answersDiv);
    answersDiv.appendChild(newAnswerDiv);

}


function deleteAnswer(id) {
    answers = answers.filter(answer => answer.id !== id);
    document.getElementById(`list${id}`).remove();
    answerIndex-=1;
    renderAllAnswers();

}
function renderAllAnswers() {

    answers.forEach((answer, index) => {

       document.getElementById(`char-${answer.id}`).innerText=chars[index];

    });

}

// answer components
function deleteAnswerComponent(index){
    return `
    <div class="flex justify-center items-center w-[10%]">
<a onclick="deleteAnswer(${index})" class="">
    <svg class="h-4 w-4 text-svg_primary hover:text-primary_red focus:text-primary_red hover:cursor-pointer "  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <g  stroke-width="0"/>
    <g  stroke-linecap="round" stroke-linejoin="round"/>
    <g > <path d="M10 11V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M14 11V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M4 7H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M6 7H12H18V18C18 19.6569 16.6569 21 15 21H9C7.34315 21 6 19.6569 6 18V7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> </g>
    </svg>
</a>
</div>`;
}

function  scoreAnswerComponent(index){
    console.log(answers[index],answers,index);
return `
<div class=""  >
    <div class="max-h-[20px]">
      <span class="text-xs">${translations.score}</span>
    </div>
    <div   class=" ">
        <input onchange="setScore(${index})"  name="answers[${answers[index].id}][score]" id="answers[${answers[index].id}][score]" value="0"  max="10" min="0" onKeyDown="return false"   class=" p-[1px] text-xs text-center focus:ring-transparent  w-10 h-6 rounded-md" type="number" />
    </div>
</div>`;
}

function  hideAnswerComponent(index){

    selectedHideCount  =answers.filter(answer => answer.hide).length;

    return `
    <div class=""   >
        <div class="max-h-[20px]">
        <span id="hidetext-${answers[index].id}"  class="text-xs" >
        ${ answers[index].hide?translations.hide:translations.show }
        </span>
        </div>

        <label class="cursor-pointer">
            <input
            type="checkbox" name="answers[${answers[index].id}][hide]" id="answers[${answers[index].id}][hide]"   value=${answers[index].hide} class="hidden" >
            <svg id="hidesvg-${answers[index].id}" onclick="setHide(${index})" class="w-6 h-6 cursor-pointer "     viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g >
            <path  id="Vector-${index}" d="M5.75 5.75L18.25 18.25M12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12C21 16.9706 16.9706 21 12 21Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </g>
            </svg>
        </label>
    </div>



    `;
}
function setScore(index){



    answers[index].score =  document.getElementById(`answers[${answers[index].id}][score]`).value;

        console.log(answers);

 }
function setAction(index,value){



    answers[index].action = value;

        console.log(answers);

 }
 function setHide(index){
    selectedHideCount  =answers.filter(answer => answer.hide).length;
    if(answers.length-selectedHideCount>1||answers[index].hide==true)
    {answers[index].hide=! answers[index].hide;
        document.getElementById(`answers[${answers[index].id}][hide]`).value=answers[index].hide;
        console.log(answers);
        if(answers[index].hide==true){

            document.getElementById(`answervaluediv-${answers[index].id}`).classList.add('opacity-25');
            document.getElementById(`answerimagediv-${answers[index].id}`).classList.add('opacity-25');
            document.getElementById(`hidesvg-${answers[index].id}`).classList.remove('text-svg_primary');
            document.getElementById(`hidesvg-${answers[index].id}`).classList.add('text-primary_red');
            document.getElementById(`hidetext-${answers[index].id}`).innerText=translations.hide;

        }
        else{
            document.getElementById(`answervaluediv-${answers[index].id}`).classList.remove('opacity-25');
            document.getElementById(`answerimagediv-${answers[index].id}`).classList.remove('opacity-25');
            document.getElementById(`hidesvg-${answers[index].id}`).classList.remove('text-primary_red');
            document.getElementById(`hidesvg-${answers[index].id}`).classList.add('text-svg_primary');
            document.getElementById(`hidetext-${answers[index].id}`).innerText=translations.show;
        }
    }

    else return;
 }

function actionAnswerComponent(index){
    return `<div class="grid">
    <div class="">
        <label class="cursor-pointer flex justify-between items-center">
            <span class="text-xs mr-1 ml-1">${translations.skipnextquestion}</span>
            <input onclick="setAction(${index},'Skip')" name="answers[${answers[index].id}][action]" id="answers[${answers[index].id}][action]" value="Skip" data-bs-toggle="tooltip"
                data-bs-html="true" title="Skip Next Question if the answer chosen"
                class="rounded-full focus:ring-transparent text-secondary_blue bg-gray-100 w-4 h-4 " type="radio" />
        </label>
    </div>
    <div class="">
        <label class="cursor-pointer flex justify-between items-center">
            <span class="text-xs mr-1 ml-1">${translations.endform}</span>
            <input onclick="setAction(${index},'End')" name="answers[${answers[index].id}][action]" id="answers[${answers[index].id}][action]" value="End" data-bs-toggle="tooltip"
                data-bs-html="true" title="End Form if the answer chosen"
                class="rounded-full focus:ring-transparent text-secondary_blue bg-gray-100 w-4 h-4 " type="radio" />
        </label>
    </div>
    <div class="">
        <label class="cursor-pointer flex justify-between items-center">
            <span class="text-xs mr-1 ml-1">${translations.none}</span>
            <input onclick="setAction(${index},'None')" checked name="answers[${answers[index].id}][action]" id="answers[${answers[index].id}][action]" value="None" data-bs-toggle="tooltip"
                data-bs-html="true" title="End Form if the answer chosen"
                class="rounded-full focus:ring-transparent text-secondary_blue bg-gray-100 w-4 h-4 " type="radio" />
        </label>
    </div>
</div>`;
}
function toggleDropdown(id) {
    console.log(id);
    var dropdownContent = document.getElementById(`${id}`);
    dropdownContent.classList.toggle("hidden");
}

window.onclick = function (event) {
    if (!event.target.matches('.dropdown-button')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (!openDropdown.classList.contains('hidden')) {
                openDropdown.classList.add('hidden');
            }
        }
    }
}

// function actionAnswerComponent(index) {
//     return `
//     <div class="relative inline-block text-left">
//         <div>
//             <button type="button" onclick="toggleDropdown('dropdown-menu-${index}')" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-100" id="dropdown-button-${index}" aria-expanded="true" aria-haspopup="true">
//                 ${translations.answers[index].action}
//                 <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
//                     <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l5 5a1 1 0 01-1.414 1.414L10 5.414 5.707 9.707a1 1 0 01-1.414-1.414l5-5A1 1 0 0110 3zm0 14a1 1 0 01-.707-.293l-5-5a1 1 0 111.414-1.414L10 14.586l4.293-4.293a1 1 0 111.414 1.414l-5 5A1 1 0 0110 17z" clip-rule="evenodd" />
//                 </svg>
//             </button>
//         </div>

//         <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden" id="dropdown-menu-${index}" role="menu" aria-orientation="vertical" aria-labelledby="dropdown-button-${index}">
//             <div class="py-1" role="none">
//                 <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">${translations.none}</a>
//                 <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">${translations.skipnextquestion}</a>
//                 <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">${translations.endform}</a>
//             </div>
//         </div>
//     </div>
//     `;
// }

// function toggleDropdown(id) {
//     const dropdown = document.getElementById(id);
//     dropdown.classList.toggle('hidden');
// }
function validateForm() {
    const form = document.getElementById('questionForm');
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;

    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            isValid = false;
            console.log(field);
            field.classList.add('border-red-500'); // Add a red border to highlight the field
        } else {
            field.classList.remove('border-red-500');
        }
    });

    return isValid;
}




// crop image



let indexImage;
const modal=document.getElementById('cropimage-add');
const  result = document.querySelector('.result-upload-add');
let cropper;
let imageInput;
function uploadImage(event,i){

    indexImage=i;
    imageInput=event.target;
     file = imageInput.files[0];
    const reader = new FileReader();
    modal.classList.remove('hidden');
    reader.onload = (event) => {
        const img = new Image();
        img.src = event.target.result;
        img.onload = () => {
            if (cropper) {
                cropper.replace(img.src);
            } else {
                result.innerHTML = '';
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.width = 300;
                canvas.height = 300;
                context.drawImage(img, 0, 0, 300, 300);
                result.appendChild(canvas);
                cropper = new Cropper(canvas, {
                    aspectRatio: 1,
                    viewMode: 1,
                });
            }
        };
    };

    reader.readAsDataURL(file);

 }

 function cropimage(){
    image=document.getElementById(`answers[${indexImage}][imagesrc]`);
    const canvas = cropper.getCroppedCanvas();
    const croppedImage = canvas.toDataURL('image/jpeg');
    console.log(indexImage,image,croppedImage);
    image.src=croppedImage;
    canvas.toBlob((blob) => {
                    const fileInput = new File([blob], file.name, { type: 'image/jpeg' });
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(fileInput);
                    imageInput.files = dataTransfer.files;
                    answers[indexImage].imageSrc=dataTransfer.files;
                }, 'image/jpeg');
    modal.classList.add('hidden');
 }


