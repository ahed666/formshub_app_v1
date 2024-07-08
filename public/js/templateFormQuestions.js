
// elements
var btn_next;
var agreement_section;
var question_section;
var thanks_section;
var question;
var question_text;
var answers_sections
var answers;
var progressbar=document.getElementById('progressbar');
var progressbar_value=document.getElementById('progressbar_value');
var ConnectionError=false;
import { getCountries } from './countries.js';


// sounds
var successAudio = document.getElementById('SuccessAudio');
var StartAudio = document.getElementById('StartAudio');

var countires_div;
// end elements
var finished=false;
var displayScore=false;
var current_question_no=0;
var current_question;
var step=null;
var language;
var text_question_value;
var current_message;
var totalScore=0;
var totalSubmitedScore=0;
var ratingScore;
var answerschecked=[];
var questions=[];
var submitedquestions=[];
var countires=[];
var comments;
var ControlButtons;
var drawingPad;
var idleTime = 0;
var aggremantbuttontext={
    "en":{"1":"Agree","0":"Disagree"},
    "ar":{"1":"موافق",
        "0":"غير موافق"},
    "tl":{"1":"sumang-ayon","0":"hindi sumasang-ayon"},
    "ur":{"1":"متفق",
        "0":"متفق نہیں"}
};
var alarmtext={
    "en":{"warning":"Do you need more time?","button":"Yes"},
    "ar":{"warning":"هل تريد المزيد من الوقت؟",
            "button":"نعم"},
    "tl":{"warning":"Kailangan mo ba ng mas maraming oras?","button":"Oo"},
    "ur":{"warning":"کیا آپ کو مزید وقت کی ضرورت ہے؟",
    "button":"جی ہاں"}
};
var buttonsLang={
    "en":{"clear":"Clear"},
    "ar":{"clear":"مسح"},
    "tl":{"clear":"malinaw"},
    "ur":{"clear":"صاف"}
};
var hinttext={
    "en":{"date":"Press here to choose date"},
    "ar":{"date":"اضغط هنا لاختيار التاريخ"},
    "tl":{"date":"Pindutin dito para pumili ng petsa"},
    "ur":{"date":"تاریخ منتخب کرنے کے لیے یہاں دبائیں۔"}
};
var HintText = JSON.parse(JSON.stringify(hinttext));
var buttonsLanguages=JSON.parse(JSON.stringify(buttonsLang));
//    function setagrement(btn){
//       btn==='0'?step=4:step=3;
//       btn_next=document.getElementById('next');
//       btn_next.removeAttribute('disabled');

//     }

//    functions for arguments section
//
//
//  if click on back button
async function fetchAndLogCountries() {
    try {
        const response = await fetch('./countries.json');
        const data = await response.json();
        return data;
        console.log(data);
    } catch (error) {
        console.error('Error fetching countries:', error);
    }
}

function DisagreeArguments(){
    document.getElementById('next').disabled = true;
    reload();
}
//  if click on next button
function AgreeArguments(){
    document.getElementById('cancel').disabled = true;
    step=3;
    agreement_section.classList.add("hidden");
    next();
}

// set animate class to next button
function SetNextInnerText(value)
{

    btn_next=document.getElementById('next_question');
    var animate=btn_next.disabled?"":"animate-ping";
    value==true?btn_next.innerHTML=`${ControlButtons[language]['next']} <span class="${animate} text-4xl ml-8">➝</span>`:btn_next.innerHTML=`${ControlButtons[language]['skip']} <span class="text-4xl ml-4"> ↷</span>`;
}

// initialization new question
function initialquestion(){
    // hidden keyboard
    // keyboard=document.getElementById('keyboard');
    // keyboard.classList.add('hidden');
    //
    // hidden or show back
    back_button=document.getElementById('back');
    align=language=='en'||language=='tl'?"text-left justify-start":"text-right justify-end";
    // comment=document.getElementById('comment');
    if(current_question_no>0){
        back_button.classList.remove('opacity-0');
        back_button.classList.add('opacity-100');
    }
    else{
        back_button.classList.add('opacity-0');
        back_button.classList.remove('opacity-100');
    }

    // comment.innerText=comments[current_question.type][language];
    // current_question_no>0?buttons.style.display="flex":buttons.style.display="grid";
    // current_question_no>0?buttons.classList.add('justify-between'):buttons.classList.remove('justify-between');
    btn_next=document.getElementById('next_question');
   question_text=document.getElementById('question_text');
   question_text.innerHTML="";
  question_text.innerHTML=current_question.question_details;

  current_question.optional==0?btn_next.disabled =true:btn_next.disabled = false;;
  current_question.optional==0?SetNextInnerText(true):SetNextInnerText(false);
  //   checkbox question
    if(current_question.type=="checkbox"){
        answers_section=document.getElementById('answers_section');
        answers_section.innerHTML="";
        answers_section.innerHTML+=`<div  class="mx-16  mt-4   flex justify-center">
            <div id="answers"  class="justify-center items-center mt-2 w-full p-4   h-full   grid grid-cols-12  gap-4 " >`;
        answers=document.getElementById('answers');
        current_question.answers.forEach(element => {

        answers.innerHTML+=`

        <div id="list-${element.id}" class="col-span-4 mt-2 ">
                            <input   class="hidden peer" onclick="setanswer_checkbox(${element.id},${element.score})"  value="" name="answer" id="answer${element.id}" type="checkbox" >
                                    <label for="answer${element.id}" class="border-[1px] border-gray-300 whitespace-normal select-none peer-checked:drop-shadow-lg peer-checked:bg-blue-100
                                    peer-checked:text-secondary_blue peer-checked:font-bold  min-h-24 h-24 max-h-24   flex items-center px-2
                                     ${align} w-full  text-gray-500 bg-formbutton border-[2px] rounded-lg cursor-pointer
                                     peer-checked:border-blue-400
                                    hover:text-gray-600 hover:bg-gray-100  ">
                                    <span class="pointer-events-none text-black"  >${element.answer_details}</span>

                                </label>


                        </div>`
     });
     answers_section.innerHTML+=`</div></div>`;
    }

    //   radio question
    else if(current_question.type=="mcq")
    {
        answers_section=document.getElementById('answers_section');
        answers_section.innerHTML="";

        answers_section.innerHTML+=`<div  class="mx-16  mt-4   flex justify-center">
            <div id="answers"  class="justify-center items-center mt-2 w-full p-4   h-full   grid grid-cols-12  gap-4 " >`;
        answers=document.getElementById('answers');
        current_question.answers.forEach(element => {
            answers.innerHTML+=`<div id="list-${element.id}" class="col-span-4 mt-2 ">
                            <input   class="hidden peer" onclick=" setanswer_mcq(${element.id},${element.score})"  value="" name="answer" id="answer${element.id}" type="radio" >
                                    <label for="answer${element.id}" class="border-[1px] border-gray-300 whitespace-normal select-none peer-checked:drop-shadow-lg peer-checked:bg-blue-100
                                    peer-checked:text-secondary_blue peer-checked:font-bold  min-h-24 h-24 max-h-24    flex items-center px-2
                                     ${align} w-full  text-gray-500 bg-formbutton border-[2px] rounded-lg cursor-pointer
                                     peer-checked:border-blue-400
                                    hover:text-gray-600 hover:bg-gray-100 ">
                                    <span class="pointer-events-none text-black"  >${element.answer_details}</span>

                                </label>


                        </div>`;
        });
        answers_section.innerHTML+=`</div></div>`;
    }
    // list
    else if(current_question.type=="list")
    {
        answers_section=document.getElementById('answers_section');
        answers_section.innerHTML="";
        answers_section.innerHTML+=`<div  class="mx-16   mt-4   flex justify-center">
            <div id="answers" class="mt-2 w-[65%] p-4  h-full text-center    grid grid-cols-6    " >`;
        answers=document.getElementById('answers');
        current_question.answers.forEach(element => {
            answers.innerHTML+=`<div id="list-${element.id}" class="col-span-6 mt-1 ">
                            <input   class="hidden peer" onclick="setanswer_mcq(${element.id},${element.score})"  value="" name="answer" id="answer${element.id}" type="radio" >
                                    <label for="answer${element.id}" class="border-[1px] border-gray-300 select-none peer-checked:drop-shadow-lg peer-checked:bg-blue-100 peer-checked:text-blue-600 peer-checked:font-bold  min-h-16 h-16 max-h-16   flex items-center px-2 ${align} w-full  text-gray-500 bg-formbutton border-[2px] rounded-lg cursor-pointer
                                     peer-checked:border-blue-400
                                    hover:text-gray-600 hover:bg-gray-100 ">
                                    <span class="pointer-events-none text-black"  >${element.answer_details}</span>

                                </label>


                        </div>`;
        });
        answers_section.innerHTML+=`</div></div>`;
    }
    // radio with image question
    else if(current_question.type=="mcq_pic")
    {
        answers_section=document.getElementById('answers_section');
        answers_section.innerHTML="";
        answers_section.innerHTML+=`<div  class="mx-16 flex justify-center">
            <div id="answers" class="justify-center items-center mt-2 w-full   pr-2 h-full text-center    grid grid-cols-12  gap-4" >`;
        answers=document.getElementById('answers');
        current_question.answers.forEach(element => {

        answers.innerHTML+=`
        <div id="list${element.id}" class="col-span-3 h-[220px]   mt-2 ">
        <input   class="hidden peer " onclick="setanswer_mcq(${element.id},${element.score})"  value="" name="answer" id="answer${element.id}" type="radio" >
                <label for="answer${element.id}" class="border-[1px] border-gray-300 select-none h-[220px] peer-checked:drop-shadow-lg peer-checked:bg-blue-100
                 peer-checked:text-blue-600 peer-checked:font-bold
                block items-center px-2
                w-full  text-gray-500 bg-formbutton border-[2px] rounded-lg cursor-pointer
                peer-checked:border-blue-400
                hover:text-gray-600 hover:bg-gray-100 ">

                <div class=" p-[2px]  rounded-lg mt-2 flex justify-center  ">
                        <img  class="border-[1px] border-gray-200 h-[120px] w-[120px]"
                        src="${app_url}/${element.picture}" alt="">
                </div>
                <div  class=" mt-2 flex justify-center  " >
                    <span class="pointer-events-none text-black "  >${element.answer_details}</span>
                </div>
            </label>
        </div>`
        });
        answers_section.innerHTML+=`</div></div>`;

    }
    // checkbox with image question
    else if(current_question.type=="checkbox_pic")
    {
        answers_section=document.getElementById('answers_section');
        answers_section.innerHTML="";
        answers_section.innerHTML+=`<div  class="mx-16 flex justify-center">
            <div id="answers" class="justify-center items-center mt-2 w-full   pr-2 h-full
            grid grid-cols-12  gap-4" >`;
        answers=document.getElementById('answers');
        current_question.answers.forEach(element => {

        answers.innerHTML+=`
        <div id="list${element.id}" class="col-span-3 h-[220px]   mt-2 ">
        <input   class="hidden peer " onclick="setanswer_checkbox(${element.id},${element.score})"  value="" name="answer" id="answer${element.id}" type="checkbox" >
                <label for="answer${element.id}" class="border-[1px] border-gray-300 select-none h-[220px] peer-checked:drop-shadow-lg peer-checked:bg-blue-100
                 peer-checked:text-blue-600 peer-checked:font-bold
                block items-center px-2
                w-full  text-gray-500 bg-formbutton border-[2px] rounded-lg cursor-pointer
                peer-checked:border-blue-400
                hover:text-gray-600 hover:bg-gray-100 ">

                <div class=" p-[2px]  rounded-lg mt-2 flex justify-center  ">
                        <img  class="border-[1px] border-gray-200 h-[120px] w-[120px]"
                        src="${app_url}/${element.picture}" alt="">
                </div>
                <div  class=" mt-2 flex justify-center  " >
                    <span class="pointer-events-none text-black"  >${element.answer_details}</span>
                </div>
            </label>
        </div>`
        });
        answers_section.innerHTML+=`</div></div>`;

    }
    // text question
    else if(current_question.type=="number"||current_question.type=="date_question"||current_question.type=="long_text_question"||current_question.type=="email"||current_question.type=="short_text_question")
    {
        current_question.type=='email'?align="text-left":(language=="ar"||language=="ur"?align="text-right":"text-left");
        answers=document.getElementById('answers_section');
        answers.innerHTML="";
        // if question is date..                    <button id="openDatePicker" class="bg-secondary_blue w-20 p-1 rounded text-white text-sm uppercase">Choose Date</button>
        if(current_question.type=="date_question"){

            answers.innerHTML=`<div class="flex justify-center  items-center mt-8 pt-10">

                        <input placeholder="${HintText[language]['date']}" onchange="updatedate(event)" data-role="calendarpicker" class="select-none rounded-[0.5rem]"  inputmode="none" style="text-align:center;width:30%;font-size:1.5rem;"  type="text" name="text_question" id="question-date" >
                    </div>`;

        }
        // if question is number
        else if(current_question.type=="number")
        {
            answers.innerHTML=`<div  class="flex justify-center mt-8 ">
                <select  onchange="resetnumber()" id="countries_select" class="rounded-[0.5rem] mr-2" >
                   name="countries">
                </select>
                <input readonly onmousedown="return false" onselectstart="return false"
                style=" -moz-user-select: none;  -ms-user-select: none;  -khtml-user-select: none; -webkit-user-select:none" disabled
                 inputmode='none' placeholder="" maxlength="10" name="text_question_num" class="${align} select-none rounded-[0.5rem]" data-virtual-element type="text" class="form-control"
                  id="InputArea"></div>`;
                countires_select=document.getElementById('countries_select');

                    countires_select.innerHTML=countires_div;



        }
        // if question is short text or email
        else if(current_question.type=="email"||current_question.type=="short_text_question")
        {  current_question.type=="email"?placeholder=`placeholder="example@domain.com"`:placeholder="";

            answers.innerHTML=` <div class=" flex justify-center mt-8"><input ${placeholder}  maxlength="65" minlength="1" readonly disabled inputmode='none' name="text_question" class="w-1/2 select-none rounded-[0.5rem]"
                data-virtual-element type="text" class="form-control ${align}" id="InputArea"></div>`;

        }
        else if(current_question.type=="long_text_question")
        {
            answers.innerHTML=`<div class="flex justify-center mt-8 ">
            <textarea maxlength="500" minlength="1"    inputmode='none' class="w-1/2 select-none ${align} rounded-[0.5rem]" cols="200" rows="3" name="text_question" data-virtual-element type="text" class="form-control" id="InputArea" ></textarea>
            </div>
            `;
        }

        // set keyboard if question need keyboard
        if(current_question.type!="date_question")
        {
            // keyboard.classList.remove('hidden');
            answers.innerHTML+=`<div id="keyboard" class=" mt-4 flex justify-center">
                <div class="mt-4" wire:ignore    id='tabular-virtual-keyboard'></div>
            </div>`;

            const elements = document.getElementsByClassName("virtual-keyboard-row");
            while(elements.length > 0){
            elements[0].parentNode.removeChild(elements[0]);}


            // initialization the keyboard
            if(current_question.type=="number")
            createkeyboard(true);
            else if(current_question.type=="email")
            createEmailkeyboard();
            else
            createkeyboard(false,language);

        }
        // to listen to input text if user typeing
        //  text_question=document.getElementsByName("text_question")[0];
        //  input.addEventListener('input',setanswer_text());
    }
    // yes no question .......
    else if(current_question.type=="satisfaction"||current_question.type=="rating"||current_question.type=="yes_no"||current_question.type=="like_dislike"||current_question.type=="Agree_Disagree")
    {
        answers_section=document.getElementById('answers_section');
        answers_section.innerHTML="";
        answers_section.innerHTML+=`<div id="answers" class=" max-h-[400px] h-[400px] min-h-[400px] flex justify-center items-center mt-2 mx-16  relative    ">`;
        answers=document.getElementById('answers');

        // yes or on `+((i==0)?'text-red-400 ':'text-green-400 ')+`
        if(current_question.type=="yes_no")
        {
            for(i=1;i>=0;i--)
                {
                answers.innerHTML+=`
                <div class="ml-4 mr-4">
                                <input   class="hidden peer pointer-events-none" onclick="setanswer_mcq(${current_question.answers[i].id},${current_question.answers[i].score})"  value="answerchecked.${i}" name="answer-agree_disagree" id="answer-yes_no-${i}" type="radio" >
                                <label for="answer-yes_no-${i}" class="border-[1px] border-gray-300 select-none peer-checked:drop-shadow-lg peer-checked:bg-blue-100 peer-checked:text-blue-600 peer-checked:font-bold peer-checked:text-xl w-48 max-w-[48] min-w-[48] h-24
                                        flex justify-center items-center p-2   text-gray-500 bg-formbutton border-[2px] rounded-lg cursor-pointer
                                     peer-checked:border-blue-400
                                    hover:text-gray-600 hover:bg-gray-100">

                                    <span class="text-black text-xl  pointer-events-none">
                                        ${current_question.answers[i].answer_details}
                                    </span>


                                </label>

                        </div>
                `;

            }

        }
        // agree or dis agree
        else if(current_question.type=="Agree_Disagree")
        {
            for(i=1;i>=0;i--)
            {

                answers.innerHTML+=`
                <div class="ml-4 mr-4">
                                <input   class="hidden peer pointer-events-none" onclick="setanswer_mcq(${current_question.answers[i].id},${current_question.answers[i].score})"  value="answerchecked.${i}" name="answer-yes_no" id="answer-yes_no-${i}" type="radio" >
                                <label for="answer-yes_no-${i}" class="border-[1px] border-gray-300 select-none peer-checked:drop-shadow-lg peer-checked:bg-blue-100 peer-checked:text-blue-600 peer-checked:font-bold peer-checked:text-xl w-48 max-w-[48] min-w-[48] h-24
                                        flex justify-center items-center p-2   text-gray-500 bg-formbutton border-[2px] rounded-lg cursor-pointer
                                     peer-checked:border-blue-400
                                    hover:text-gray-600 hover:bg-gray-100">

                                    <span class="text-black  text-xl  text-center pointer-events-none">
                                        ${current_question.answers[i].answer_details}
                                    </span>


                                </label>

                        </div>
                `;

            }

        }
        // like or dislike
        else if(current_question.type=="like_dislike")
        {  var urls=['images/icons/like.png','images/icons/dislike.png'];

            for(i=1;i>=0;i--)
            {

            //     if(current_question.answers[i].answer_details=="يحب"||current_question.answers[i].answer_details=="Like"||current_question.answers[i].answer_details=="Gaya ng"||current_question.answers[i].answer_details=="پسند")
            //     {path="images/icons/like.png";}
            //     else
            //    { path="images/icons/dislike.png";}
                answers.innerHTML+=`
                <div class="ml-4 mr-4">
                                <input   class="hidden peer pointer-events-none" onclick="setanswer_mcq(${current_question.answers[i].id},${current_question.answers[i].score})"  value="answerchecked.${i}" name="answer-like_dislike" id="answer-yes_no-${i}" type="radio" >
                                <label for="answer-yes_no-${i}" class="border-[1px] border-gray-300 peer-checked:drop-shadow-lg peer-checked:bg-blue-100 peer-checked:text-blue-600 peer-checked:font-bold peer-checked:text-xl w-48 max-w-[48] min-w-[48] h-24
                                        flex justify-center items-center p-2   text-gray-500 bg-formbutton border-[2px] rounded-lg cursor-pointer
                                     peer-checked:border-blue-400
                                    hover:text-gray-600 hover:bg-gray-100">
                                    <span class=" text-xl text-black pointer-events-none">${current_question.answers[i].answer_details}</span>
                                    <img class="object-contain w-14  ml-1 mr-1 " src="${app_url}/${urls[i]}" alt="">




                                </label>

                        </div>
                `;

            }

        }


        // rating
        else if(current_question.type=="rating")
        {
            for(i=4;i>=0;i--)
            {
                answers.innerHTML+=`
                <div class="ml-4 mr-4">
                    <input   class="hidden peer"
                        onclick="setanswer_mcq(${current_question.answers[i].id},${current_question.answers[i].score})"
                        value="answerchecked.${i}" name=" answer-rating" id="answer-yes_no-${i}" type="radio" >
                    <label for="answer-yes_no-${i}" class="border-[1px] border-gray-300 peer-checked:drop-shadow-lg peer-checked:bg-blue-100 peer-checked:text-blue-600
                        peer-checked:font-bold  w-40 min-w-40 max-w-40 min-h-40 max-h-40  h-40 flex justify-center items-center p-2
                        text-gray-500 bg-formbutton border-[2px] rounded-lg cursor-pointer
                         peer-checked:border-blue-400 hover:text-gray-600 hover:bg-gray-100 ">
                        <span class="text-black  text-4xl pointer-events-none">${current_question.answers[i].answer_details}</span>
                    </label>
                </div>`;
            }
        }
            //  satisfaction
            //  <img class="object-contain w-24 min-w-24 max-w-24 min-h-24 max-h-24  h-24" src="{{ asset('${path}') }}" alt="">
        else
        {
            for(i=4;i>=0;i--)
            {
                    path='images/emoji/'+(i+1)+'.png';
                answers.innerHTML+=`
                <div class="ml-4 mr-4">
                        <input   class="hidden peer" onclick="setanswer_mcq(${current_question.answers[i].id},${current_question.answers[i].score})"  value="answerchecked.${i}" name="answer-yes_no" id="answer-yes_no-${i}" type="radio" >
                        <label for="answer-yes_no-${i}" class="border-[1px] border-gray-300 select-none grid peer-checked:drop-shadow-lg peer-checked:bg-blue-100
                            peer-checked:text-blue-600 bg-formbutton peer-checked:font-bold  w-40 min-w-40 max-w-40 min-h-40 max-h-40  h-40   flex
                            justify-center items-center p-2 text-gray-500  border-[2px] rounded-lg cursor-pointer
                             peer-checked:border-blue-400 hover:text-gray-600 hover:bg-gray-100
                            ">

                                <div class="  flex justify-center items-center">
                                 ${renderSVG(current_question.answers[i].answer_details)}
                                </div>
                                <div class=" min-h-12 max-h-12  h-12 block text-center">
                                    <span class="text-lg text-black  pointer-events-none">${current_question.answers[i].answer_details}</span>
                                </div>


                        </label>
                </div>`;

            }

        }
        answers_section.innerHTML+=`</div>`;

    }
    else if(current_question.type=="satisfaction_image"||current_question.type=="rating_image")
    {
        answers_section=document.getElementById('answers_section');
        answers_section.innerHTML="";
        answers_section.innerHTML+=`
        <div class="max-h-[180px] h-[180px] min-h-[180px]    flex justify-center items-center mt-2 mx-16  relative">
            <div class="border-[1px] border-gray-300 p-1">
                <img class="object-contain  w-[180px] h-[180px]" src="${app_url}/${current_question.question_image}" alt="">
            </div>
        </div>
        `;
        answers_section.innerHTML+=`<div id="answers" class=" max-h-[180px] h-[180px] min-h-[180px] flex justify-center items-center mt-12 mx-16  relative"></div>`;

        answers=document.getElementById('answers');

        if(current_question.type=="rating_image")
        {
            for(i=4;i>=0;i--)
            {
                answers.innerHTML+=`
                <div class="ml-4 mr-4">
                    <input   class="hidden peer"
                        onclick="setanswer_mcq(${current_question.answers[i].id},${current_question.answers[i].score})"
                        value="answerchecked.${i}" name=" answer-rating" id="answer-yes_no-${i}" type="radio" >
                    <label for="answer-yes_no-${i}" class="border-[1px] border-gray-300 peer-checked:drop-shadow-lg peer-checked:bg-blue-100 peer-checked:text-blue-600
                        peer-checked:font-bold  w-40 min-w-40 max-w-40 min-h-40 max-h-40  h-40 flex justify-center items-center p-2
                        text-gray-500 bg-formbutton border-[2px] rounded-lg cursor-pointer
                        peer-checked:border-blue-400 hover:text-gray-600 hover:bg-gray-100 ">
                        <span class="text-black  text-4xl pointer-events-none">${current_question.answers[i].answer_details}</span>
                    </label>
                </div>`;
            }
        }
            //  satisfaction
        else
        {
            for(i=4;i>=0;i--)
            {
                    path='images/emoji/'+(i+1)+'.png';
                answers.innerHTML+=`
                <div class="ml-4 mr-4">
                        <input   class="hidden peer" onclick="setanswer_mcq(${current_question.answers[i].id},${current_question.answers[i].score})"  value="answerchecked.${i}" name="answer-yes_no" id="answer-yes_no-${i}" type="radio" >
                        <label for="answer-yes_no-${i}" class="border-[1px] border-gray-300 select-none grid peer-checked:drop-shadow-lg peer-checked:bg-blue-100
                            peer-checked:text-blue-600 bg-formbutton peer-checked:font-bold  w-40 min-w-40 max-w-40 min-h-40 max-h-40  h-40   flex
                            justify-center items-center p-2 text-gray-500  border-[2px] rounded-lg cursor-pointer
                             peer-checked:border-blue-400 hover:text-gray-600 hover:bg-gray-100
                            ">

                                <div class="  flex justify-center items-center">
                                    ${renderSVG(current_question.answers[i].answer_details)}
                                </div>
                                <div class=" min-h-12 max-h-12  h-12 block text-center">
                                    <span class="text-lg text-black  pointer-events-none">${current_question.answers[i].answer_details}</span>
                                </div>


                        </label>
                </div>`;

            }

        }

    }
    // drawing
    else if(current_question.type=="drawing")
    {
        answers_section=document.getElementById('answers_section');
        answers_section.innerHTML="";
        answers_section.innerHTML+=`
        <div id="drawing-pad" class="grid justify-center items-center">
            <div class="flex justify-end items-center mb-4">
                <button onclick="clearDrawing()" class="px-2 py-4 flex bg-gray-300 rounded-[0.5rem] " type="button"  >
                    ${buttonsLanguages[language]['clear']}
                    <?xml version="1.0" standalone="no"?><!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd"><!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                     <svg fill="#000000" class="w-6 h-6" viewBox="0 0 1024 1024" t="1569683368540" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="9723" xmlns:xlink="http://www.w3.org/1999/xlink"><defs><style type="text/css"></style></defs><path d="M899.1 869.6l-53-305.6H864c14.4 0 26-11.6 26-26V346c0-14.4-11.6-26-26-26H618V138c0-14.4-11.6-26-26-26H432c-14.4 0-26 11.6-26 26v182H160c-14.4 0-26 11.6-26 26v192c0 14.4 11.6 26 26 26h17.9l-53 305.6c-0.3 1.5-0.4 3-0.4 4.4 0 14.4 11.6 26 26 26h723c1.5 0 3-0.1 4.4-0.4 14.2-2.4 23.7-15.9 21.2-30zM204 390h272V182h72v208h272v104H204V390z m468 440V674c0-4.4-3.6-8-8-8h-48c-4.4 0-8 3.6-8 8v156H416V674c0-4.4-3.6-8-8-8h-48c-4.4 0-8 3.6-8 8v156H202.8l45.1-260H776l45.1 260H672z" p-id="9724"></path></svg>

                </button>
            </div>
            <canvas class="bg-formbutton border-secondary_blue  bg-primary_blue border-2 rounded-[0.5rem]" width="600" height="300"></canvas>

        </div>`;
        createDrawing();

    }

}

// update answer of date question
function updatedate(e)
{
      answerschecked=[];
    if(e.target.value==null||e.target.value==""||/^\s+$/.test(e.target.value))
    answerschecked.pop();
    else
    answerschecked.push(e.target.value);

    answerschecked.length==0&&current_question.optional==0?btn_next.disabled =true:btn_next.disabled =false;
    answerschecked.length==0&&current_question.optional==1?SetNextInnerText(false):SetNextInnerText(true);
}
// validation email
function validateEmail(text){

        return String(text)
            .toLowerCase()
            .match(
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            );

}

// update the answer of text question while user typing
function updateValue(text)
{
    text_question_value=text;
    input_f=document.getElementById('InputArea');
    btn_next.disabled =true;
    // text_question_value.length==0&&current_question.optional==0?btn_next.setAttribute('disabled'):btn_next.removeAttribute('disabled');
    text_question_value.length==0&&current_question.optional==1?SetNextInnerText(false):SetNextInnerText(true);

    // // if text of field is null of all space =>disalble next
    // if(text_question_value==null||text_question_value==""||/^\s+$/.test(text_question_value))
    // {btn_next.setAttribute('disabled');answerschecked.pop();

    // }

        // type email
        if(current_question.type=="email"){

            if(text.length>0)
            {

                if(validateEmail(text))
                { input_f.classList.add('border-secondary_blue'); btn_next.disabled =false;SetNextInnerText(true);
                answerschecked.pop();answerschecked.push(text_question_value);
                }
                else
                {
                    input_f.classList.remove('border-secondary_blue');answerschecked.pop();
                }
            }
            else
            {
                btn_next.disabled =false;
                input_f.classList.remove('border-secondary_blue');
            }
        }
        //type number
        else if(current_question.type=="number")
        {


            code=document.getElementById('countries_select').value;
            if(text.length>0)
            {

                let validation = libphonenumber.parsePhoneNumber(text, code);
                if(validation.isValid())
                {
                    input_f.classList.add('border-secondary_blue');
                    btn_next.disabled =false;
                    answerschecked.pop();
                    SetNextInnerText(true);
                    dail=validation.countryCallingCode;
                    number="+"+dail+formatNumber(text_question_value);
                    answerschecked.push(number);

                }
                else
                {
                    input_f.classList.remove('border-secondary_blue'); answerschecked.pop();
                }
            }
           else
           {
                btn_next.disabled =false;
           }


        }
        else if(current_question.type=="long_text_question"||current_question.type=="short_text_question")
        {
            if(text.length>0)
            {
                btn_next.disabled =false;
                SetNextInnerText(true);
                answerschecked.pop();
                answerschecked.push(text_question_value);
                input_f.classList.add('border-secondary_blue');
            }
            else
            {    current_question.optional==1?btn_next.disabled =false:btn_next.disabled =true;
                input_f.classList.remove('border-secondary_blue');
            }
        }


    // answerschecked.length==0&&current_question.optional==0?btn_next.setAttribute('disabled'):btn_next.removeAttribute('disabled');
    // answerschecked.length==0&&current_question.optional==1?btn_next.innerHTML="skip":btn_next.innerHTML="next";


}
function formatNumber(number) {
    if (typeof number === 'number') {
        number = number.toString(); // Convert number to string
    }

    if (number.charAt(0) === '0') {
        return number.slice(1); // Remove first character ('0')
    }

    return number;
}
// set answer by it id for custom question
function setanswer_custom_mcq(question_id,answer_id,score){
    let question={
        id:question_id,answer:answer_id,score:score,
    };
    if(answerschecked.length==0){answerschecked.push(question);}
    else{
    for (let i = 0; i <  answerschecked.length; i++) {
        // if question checked =>pop it and set new answer
        if(answerschecked[i].id==question_id)
        {
            answerschecked.splice(answerschecked.indexOf(answerschecked[i]), 1);
            break;
        }
    }
        //add new question answer
       answerschecked.push(question);


    }



       answerschecked.length==0&&current_question.optional==0?btn_next.disabled =true:btn_next.disabled =false;
       answerschecked.length==0&&current_question.optional==1?SetNextInnerText(false):SetNextInnerText(true);

}
// set answer by it id mcq answer
function setanswer_mcq(id,score)
{
       let answer={
        answer_id:id,score:score,
       };
        answerschecked=[];
       answerschecked.push(answer);

       answerschecked.length==0&&current_question.optional==0?btn_next.disabled =true:btn_next.disabled =false;

       answerschecked.length==0&&current_question.optional==1?SetNextInnerText(false):SetNextInnerText(true);

}
// set answer by it id checkbox
function setanswer_checkbox(id,score)
{
    let answer={
        answer_id:id,score:score,
       };
    if( containsObject(answer.answer_id,answerschecked))
     {
        answerschecked.splice(getindex(answer,answerschecked), 1);


    }
    else{
        answerschecked.push(answer);
       }

       answerschecked.length==0&&current_question.optional==0?btn_next.disabled =true:btn_next.disabled =false;

       answerschecked.length==0&&current_question.optional==1?SetNextInnerText(false):SetNextInnerText(true);

}
/*get index =>get the index of object answer in answeredchecked array*/
function getindex(ans,answers)
{  idx=-1;
    answers.forEach(function(value,i) {

     if(value.answer_id===ans.answer_id)
     {     idx=i;

        }
    });
    return idx;
}
/*check if array answeredchecked have on answer by it id */
function containsObject(id, list) {
    var i;
    for (i = 0; i < list.length; i++) {

        if (list[i].answer_id === id) {

            return true;
        }
    }

    return false;
}
// to initialization the countries code select div
function initCountriesDiv()
{
            countires_div="";
            countires.forEach(element => {

                element.code=="AE"? countires_div+=` <option selected  value="${element.code}">${element.name}&#160(${element.dial_code})</option>`:countires_div+=` <option  value="${element.code}">${element.name}&#160(${element.dial_code})</option>`;
            });
}
// reset input value of number phone when user change country
function resetnumber()
{
    input_f=document.getElementById('InputArea');
    text=input_f.value="";
    updateValue(text);
    input_f.classList.remove('border-green-400');

}
// set progress bar on each a new  question
function setprogressbar()
{
    progressbar.classList.remove("hidden");

    value=submitedquestions.length==0?0:Math.round(submitedquestions.length*100/questions.length);
    ratio=progressbar.getBoundingClientRect().width/100;
    if(submitedquestions.length==0)
    {
        progressbar_value.classList.remove("flex");
        progressbar_value.classList.add("hidden");


    }
    else
    {
        progressbar_value.classList.remove("hidden");
        progressbar_value.classList.add("flex");

    }
    progressbar_value.style.width=value*ratio+"px";
    // progressbar_text.innerText=value+'%';



}
// to skip next question
function skipnextquestion()
{
    resetvalue();

    current_question_no+=1;
    current_question=questions[current_question_no];
    const question = new Map([['question_id',current_question.question_id],['question_details',current_question.question_details],['skipbyuser',false],['skipbyanswer',true],['order',current_question.order],['optional',current_question.optional],['type',current_question.type],['answerchecked',answerschecked]]);
    submitedquestions.push(question);
    current_question_no+=1;
}
// for disblay score
function init_Score()
{   score=document.getElementById('score');
    score.classList.remove('hidden');
    const rating = document.getElementById('rating');

    ratingScore=((totalSubmitedScore/totalScore)*100).toFixed(1);
    console.log('score'+ratingScore);
    console.log(totalSubmitedScore+'/'+totalScore+'='+ratingScore);
    totalScore==0||totalSubmitedScore==0?ratingScore=0:ratingScore=ratingScore;

    const scoreClass = ratingScore< 40 ? "bad" : ratingScore < 60 ? "meh" : "good";
    rating.classList.add(scoreClass);
    // After adding the class, get its color
    const ratingColor = window.getComputedStyle(rating, null).getPropertyValue("background-color");
     // Define the background gradient according to the score and color
    const gradient = `background: conic-gradient(${ratingColor} ${ratingScore}%, #F1F3E7 0 100%)`;

    // Set the gradient as the rating background
    rating.setAttribute("style", gradient);

    // Wrap the content in a tag to show it above the pseudo element that masks the bar
    rating.innerHTML = `<span class="text-black pointer-events-none">${ratingScore}%</span>`;

}
// calculate the score of response
function  calculatesubmittedquestion(){
    totalSubmitedScore=0;
    response_items=convert_response_to_json();//here we will convert response(questions with answers) to json
    response_items.forEach(question => {

        if(question.type!="number"&&question.type!="drawing"&&question.type!="date_question"&&question.type!="long_text_question"&&question.type!="email"&&question.type!="short_text_question")
        {   if( question.answerchecked){
            question.answerchecked.forEach(function(answer,i) {
                totalSubmitedScore += parseInt(answer.score, 10);

            });
        }
        }
    });
}
// to finish form
function finishform()
{   finished=true;
    // calculate finish score
    calculatesubmittedquestion();
    if(agreement_section!=null)
    agreement_section.classList.add('hidden');
    if(question_section!=null)
    question_section.classList.add('hidden');
    submit();



}
// to resetvalue;
function resetvalue()
{  answerschecked=[];
    skip=false;
    terminate=false;

}
// save each question on next button click
function save()
{
    // keyboard=document.getElementById('keyboard');
    //     keyboard.classList.add('hidden');
     //if question not have answers =>text question
    if(current_question.type=="number"||current_question.type=="date_question"||current_question.type=="long_text_question"||current_question.type=="email"||current_question.type=="short_text_question")
    {     answerschecked.length==0?skipbyuser=true:skipbyuser=false;
        const question = new Map([['question_id',current_question.question_id],['question_details',current_question.question_details],['skipbyuser',skipbyuser],['skipbyanswer',false],['order',current_question.order],['optional',current_question.optional],['type',current_question.type],['answerchecked',answerschecked]]);
        submitedquestions.push(question);
    }
    else if(current_question.type=="drawing")
    {
        if(drawingPad.isEmpty())
        skipbyuser=true
       else{
         dataURL = drawingPad.toDataURL("image/png");
        var blob= dataURLToBlob(dataURL);
        skipbyuser=false;
        answerschecked.push(dataURL);
        }

        const question = new Map([['question_id',current_question.question_id],['question_details',current_question.question_details],['skipbyuser',skipbyuser],['skipbyanswer',false],['order',current_question.order],['optional',current_question.optional],['type',current_question.type],['answerchecked',answerschecked]]);
        submitedquestions.push(question);
    }


    else
    {
        var skip=false;
        var terminate=false;
        if(current_question.answers!=null)
        {    current_question.answers.forEach(element => {

                if(containsObject(element.id,answerschecked))//check if each each answer is in answerschecked by containObject function
                {
                element.conditional==1?skip=true:"";
                element.terminate==1?terminate=true:"";


                }


            });

        }
        // // calculate submited score each question by add each score of answered checked
        // answerschecked.forEach(element => {
        //         totalSubmitedScore+=element.score;
        //     });

        answerschecked.length==0?skipbyuser=true:skipbyuser=false;
        const question = new Map([['question_id',current_question.question_id],['question_details',current_question.question_details],['skipbyuser',skipbyuser],['skipbyanswer',false],['order',current_question.order],['optional',current_question.optional],['type',current_question.type],['answerchecked',answerschecked]]);
        submitedquestions.push(question);
        if(terminate)
        return "terminate";
        else
        {
            if(skip)
            return "skip";
            else
            return " ";
        }
    }

}
// back to previous question
function back(){
   answerschecked=[];
    var found=false;

    var question;
    var i=submitedquestions.length;
    while(found==false&&i>0)
    {
        ques=submitedquestions.pop();

        // ques.get('type')=="custom_rating"||ques.get('type')=="custom_satisfaction"?length=ques.get('childs').length:length=ques.get('answerchecked').length;

        length=ques.get('answerchecked').length;

        if(length>0||ques.get('skipbyanswer')==false||ques.get('skipbyuser')==true)
        {found=true; question=ques;}

        i-=1;
        current_question_no-=1;
    }


    questions.forEach(element => {

        if(question.values().next().value==element.question_id)
           current_question=element;
    });

    setprogressbar();
    initialquestion();

}
// next question function to save current question and get new question
// 3 status
//1)first question, 2)skip next question by user (skip button),3)answerd&next
function next()
{



    if(step==4)
    {
        finishform();
    }
    else
    {
    //   if skip
    if(answerschecked==0&&current_question!=null)
    {

        if(submitedquestions.length+1==questions.length)//last question
        {
            //1) save
            save();
            resetvalue();
            setprogressbar();
            //2) finish form => submiting
            finishform();

        }
        else //  middle question
        {
            //1)save
            save();
            resetvalue();
            setprogressbar();
            //2)get next question
            current_question_no+=1;
            current_question=questions[current_question_no];

            initialquestion();

        }
    }
    else
    {

        if(current_question==null)//first question
        {
            // 1) get next question
            current_question=questions[current_question_no];

            question_section=document.getElementById('question_section');

            question_section.classList.remove('hidden');
            setprogressbar();
            initialquestion();

        }

        else if (submitedquestions.length+1==questions.length) //last question
        {
            //1)save
            save();
            resetvalue();
            setprogressbar();
            //2)finish form=>submiting
            finishform();

        }
        else //middle question
        {

            //1 save
            save_result=save();

            resetvalue();
            setprogressbar();
            //2 if finish or skip

            //3 if finish =>finish form with save
            if(save_result=="terminate")
            {finishform();}
            //4 if skip =>skip current question and get the next question
            else if(save_result=="skip")
            {
                //skip current question=>save
                skipnextquestion();
                resetvalue();
                setprogressbar();
                //get next question
                if(submitedquestions.length==questions.length)
                finishform();
                else{
                current_question=questions[current_question_no];
                initialquestion();
                }


            }
             //5 no skip and no finish=> get next question
            else //no terminate and no skip
            {
                current_question_no+=1;

                current_question=questions[current_question_no];
                initialquestion();
            }


        }


    }}



}
// conver to json
function convert_response_to_json(){
    var response_items=[];
        submitedquestions.forEach(element => {
        var item= Object.fromEntries(element);
        //     if(item['type']=="custom_rating"||item['type']=="custom_satisfaction")
        //     {    childs=[];
        //         item['childs'].forEach(element => {
        //             var child= Object.fromEntries(element);
        //             childs.push(child);
        //         });
        //         item['childs']=childs;
        //     }
        // var item = JSON.stringify(item);
            response_items.push(item);
        });
        return response_items;
}
// show error connection
function ShowErrorConeccction(){

}
// check on server status
// if ok send save request with response items
// else if no then show error of connection and start timer to try reload page when connection avilable
function submit(){
    savingdiv=document.getElementById('saving');
    savingdiv.classList.remove('hidden');
    savingdiv.classList.add('flex');
    // errordiv=document.getElementById('error');
    // errordiv.classList.add('hidden');
    //set timeout for fetch about 8 seconds
    const timeout=8000;
    const signal = AbortSignal.timeout(timeout);
    fetch(app_url,{
    method: "GET",
    signal,
    }).then(response => response)
    .then(data => { //if connection



        response_items=convert_response_to_json();

      net_score = ((parseInt(totalSubmitedScore,10)/ parseInt(totalScore, 10))*100).toFixed(1);
      if (isNaN(net_score)) {
        net_score = 0;
        }
        const eventData = {
            response_items: response_items,
            score: net_score
        };

        emitLivewireEventWithTimeout('saveResponse',eventData, 15000)
        .then((message) => {

            // Handle a successful Livewire event
        })
        .catch((error) => {
            savingdiv.classList.remove('flex');
            savingdiv.classList.add('hidden');
            reload();
        });

    })
    .catch((error) => { // if catch error
    savingdiv.classList.remove('flex');
    savingdiv.classList.add('hidden');
    // errordiv.classList.remove('hidden');
    reload();
    });
}
// server error
function emitLivewireEventWithTimeout(eventName, eventData, timeout) {
    return new Promise((resolve, reject) => {
        // Emit the Livewire event
        Livewire.emit(eventName,eventData['response_items'],eventData['score']);

        // Set a timeout for the response
        const timeoutId = setTimeout(() => {

            reject(new Error('no connection'));

        }, timeout);

        // Listen for the Livewire response
        Livewire.hook('message.processed', () => {
            clearTimeout(timeoutId); // Clear the timeout if the response is received
            resolve('Livewire event successful'); // Resolve with a success message
        });
  });
}





// }
// to calculate total score
function  calculatetotalscore()
{
    questions.forEach(function(value,i) {

        if(value.type!="number"&&value.type!="date_question"&&value.type!="long_text_question"&&value.type!="email"&&value.type!="short_text_question"){
        if(value.type=="checkbox"||value.type=="checkbox_pic")
        {
            value.answers.forEach(function(answer,i) {
            totalScore+=parseInt(answer.score, 10);
            console.log(totalScore);

         });
        }
        else{
            max=0;
            value.answers.forEach(function(answer,i) {
                answer.score>max?max=parseInt(answer.score, 10):max=max;
         });

         totalScore+=parseInt(max, 10);;

        }

        }
    });
}
// start form
document.addEventListener('startform',(e)=>{
    StartAudio.play();
    //  set the step,language and questions
    step=e.detail.step;

    questions=e.detail.questions;
    ControlButtons=e.detail.ControlButtons;

    language=e.detail.lang;
    displayScore=Boolean(e.detail.score);
    current_message=e.detail.current_message;
    comments=e.detail.comments;
    countires=fetchAndLogCountries();
    initCountriesDiv();
    calculatetotalscore();


    start();
    //  end of set

    question=document.getElementById("question");
    //  language=="en"||language=="tl"?question.classList.add("text-left","justify-start"):question.classList.add("text-right","justify-end");
    if(step==2)
    {
        agreement_section=document.getElementById('agreement_section');
        agreement_section.classList.remove("hidden");
        var textButtons = JSON.parse(JSON.stringify(aggremantbuttontext));
        // var disagreeButton=document.getElementById('disagree_label');
        // var agreeButton=document.getElementById('agree_label');
        // disagreeButton.innerHTML=`<span class="text-black  text-xl  text-center pointer-events-none">${textButtons[language][0]}</span>`;
        // agreeButton.innerHTML=`<span class="text-black  text-xl  text-center pointer-events-none">${textButtons[language][1]}</span>`;

    }
    else if(step==3){
        next();
    }

});

//    after submitted success
document.addEventListener('submitted',(e)=>{
    savingdiv=document.getElementById('saving');

    // playSound()

    successAudio.play();// Play the audio


    savingdiv.classList.remove('flex');
    savingdiv.classList.add('hidden');
    thanks_section=document.getElementById('thanks_section');
    thanks_section.classList.remove('hidden');
    thanks_section.innerHTML=`
        <div class=" flex justify-center items-center mt-10">
            <img class="animate-pulse" src="${app_url}/images/checked1.png" width="100px" height="100px">
        </div>
        <div class="min-h-[300px] max-h-[300px] h-[300px] pointer-events-none px-4 grid justify-center items-center">
            <div><h1 class="font-bold text-5xl mb-5 select-none">${ current_message.form_end_header }</h1>
            <span class="font-weight-bolder text-3xl select-none ">${current_message.form_end_text }</span></div>
        </div>
        <div id="score" class="hidden grid justify-center items-center mt-10 bottom-0 pointer-events-none ">
            <div><span class="text-lg select-none text-secondary_blue pointer-events-none ">${ControlButtons[language]['score']}</span></div>
            <div id="rating"  class="rating select-none"></div>
        </div>
    `;
    //   if form have display score
    if(displayScore)
        init_Score();

    // start timer of thanks page
    finish();
});
function renderSVG(selectedValue) {



    switch (selectedValue) {
        case 'راضي تماماٌ':
        case 'Very Satisfied':
        case 'مکمل طور پر مطمئن':
        case 'Ganap na Nasiyahan':
            return `<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                    <svg class="object-contain w-16 min-w-16 max-w-16 min-h-16 max-h-16  h-16"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                    <g id="SVGRepo_iconCarrier"> <path d="M6.70504 10.7092C6.8501 10.5689 7.01205 10.4438 7.1797 10.3321C7.50489 10.1153 7.80058 10 8 10C8.19942 10 8.49511 10.1153 8.8203 10.3321C9.07494 10.5018 9.26866 10.6837 9.2931 10.7074C9.68451 11.0859 10.3173 11.0969 10.7071 10.7071C11.0976 10.3166 11.0976 9.68342 10.7071 9.29289C10.4723 9.05848 10.2052 8.85164 9.9297 8.66795C9.50489 8.38475 8.80058 8 8 8C7.19942 8 6.49511 8.38475 6.0703 8.66795C5.79505 8.85145 5.52844 9.05816 5.29363 9.29216C4.90926 9.67754 4.90613 10.3203 5.29289 10.7071C5.68258 11.0968 6.31431 11.0972 6.70504 10.7092Z" fill="#1ba211"/> <path d="M8.88875 13.5414C8.63822 13.0559 8.0431 12.8607 7.55301 13.1058C7.05903 13.3528 6.8588 13.9535 7.10579 14.4474C7.18825 14.6118 7.29326 14.7659 7.40334 14.9127C7.58615 15.1565 7.8621 15.4704 8.25052 15.7811C9.04005 16.4127 10.2573 17.0002 12.0002 17.0002C13.7431 17.0002 14.9604 16.4127 15.7499 15.7811C16.1383 15.4704 16.4143 15.1565 16.5971 14.9127C16.7076 14.7654 16.8081 14.6113 16.8941 14.4485C17.1387 13.961 16.9352 13.3497 16.4474 13.1058C15.9573 12.8607 15.3622 13.0559 15.1117 13.5414C15.0979 13.5663 14.9097 13.892 14.5005 14.2194C14.0401 14.5877 13.2573 15.0002 12.0002 15.0002C10.7431 15.0002 9.96038 14.5877 9.49991 14.2194C9.09071 13.892 8.90255 13.5663 8.88875 13.5414Z" fill="#1ba211"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 23C18.0751 23 23 18.0751 23 12C23 5.92487 18.0751 1 12 1C5.92487 1 1 5.92487 1 12C1 18.0751 5.92487 23 12 23ZM12 20.9932C7.03321 20.9932 3.00683 16.9668 3.00683 12C3.00683 7.03321 7.03321 3.00683 12 3.00683C16.9668 3.00683 20.9932 7.03321 20.9932 12C20.9932 16.9668 16.9668 20.9932 12 20.9932Z" fill="#1ba211"/> <path d="M14.705 10.7092C14.8501 10.5689 15.0121 10.4438 15.1797 10.3321C15.5049 10.1153 15.8006 10 16 10C16.1994 10 16.4951 10.1153 16.8203 10.3321C17.0749 10.5018 17.2687 10.6837 17.2931 10.7074C17.6845 11.0859 18.3173 11.0969 18.7071 10.7071C19.0976 10.3166 19.0976 9.68342 18.7071 9.29289C18.4723 9.05848 18.2052 8.85164 17.9297 8.66795C17.5049 8.38475 16.8006 8 16 8C15.1994 8 14.4951 8.38475 14.0703 8.66795C13.795 8.85145 13.5284 9.05816 13.2936 9.29216C12.9093 9.67754 12.9061 10.3203 13.2929 10.7071C13.6826 11.0968 14.3143 11.0972 14.705 10.7092Z" fill="#1ba211"/> </g>
                    </svg>`;
            break;

        case 'راضي':
        case 'Satisfied':
        case 'مطمئن':
        case 'Nasiyahan':
            return `<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
            <svg class="object-contain w-16 min-w-16 max-w-16 min-h-16 max-h-16  h-16"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
            <g id="SVGRepo_iconCarrier"> <path d="M8.5 11C9.32843 11 10 10.3284 10 9.5C10 8.67157 9.32843 8 8.5 8C7.67157 8 7 8.67157 7 9.5C7 10.3284 7.67157 11 8.5 11Z" fill="#0c6006"/> <path d="M17 9.5C17 10.3284 16.3284 11 15.5 11C14.6716 11 14 10.3284 14 9.5C14 8.67157 14.6716 8 15.5 8C16.3284 8 17 8.67157 17 9.5Z" fill="#0c6006"/> <path d="M8.88875 13.5414C8.63822 13.0559 8.0431 12.8607 7.55301 13.1058C7.05903 13.3528 6.8588 13.9535 7.10579 14.4474C7.18825 14.6118 7.29326 14.7659 7.40334 14.9127C7.58615 15.1565 7.8621 15.4704 8.25052 15.7811C9.04005 16.4127 10.2573 17.0002 12.0002 17.0002C13.7431 17.0002 14.9604 16.4127 15.7499 15.7811C16.1383 15.4704 16.4143 15.1565 16.5971 14.9127C16.7076 14.7654 16.8081 14.6113 16.8941 14.4485C17.1387 13.961 16.9352 13.3497 16.4474 13.1058C15.9573 12.8607 15.3622 13.0559 15.1117 13.5414C15.0979 13.5663 14.9097 13.892 14.5005 14.2194C14.0401 14.5877 13.2573 15.0002 12.0002 15.0002C10.7431 15.0002 9.96038 14.5877 9.49991 14.2194C9.09071 13.892 8.90255 13.5663 8.88875 13.5414Z" fill="#0c6006"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 23C18.0751 23 23 18.0751 23 12C23 5.92487 18.0751 1 12 1C5.92487 1 1 5.92487 1 12C1 18.0751 5.92487 23 12 23ZM12 20.9932C7.03321 20.9932 3.00683 16.9668 3.00683 12C3.00683 7.03321 7.03321 3.00683 12 3.00683C16.9668 3.00683 20.9932 7.03321 20.9932 12C20.9932 16.9668 16.9668 20.9932 12 20.9932Z" fill="#0c6006"/> </g>
            </svg>`;
            break;
        case 'محايد':
        case 'Natural':
        case 'غیر جانبدار':
        case 'Natural':
            return `<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
            <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
            <svg class="object-contain w-16 min-w-16 max-w-16 min-h-16 max-h-16  h-16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
            <g id="SVGRepo_iconCarrier"> <path d="M8.5 11C9.32843 11 10 10.3284 10 9.5C10 8.67157 9.32843 8 8.5 8C7.67157 8 7 8.67157 7 9.5C7 10.3284 7.67157 11 8.5 11Z" fill="#c2a800"/> <path d="M17 9.5C17 10.3284 16.3284 11 15.5 11C14.6716 11 14 10.3284 14 9.5C14 8.67157 14.6716 8 15.5 8C16.3284 8 17 8.67157 17 9.5Z" fill="#c2a800"/> <path d="M8 14C7.44772 14 7 14.4477 7 15C7 15.5523 7.44772 16 8 16H15.9991C16.5514 16 17 15.5523 17 15C17 14.4477 16.5523 14 16 14H8Z" fill="#c2a800"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 23C18.0751 23 23 18.0751 23 12C23 5.92487 18.0751 1 12 1C5.92487 1 1 5.92487 1 12C1 18.0751 5.92487 23 12 23ZM12 20.9932C7.03321 20.9932 3.00683 16.9668 3.00683 12C3.00683 7.03321 7.03321 3.00683 12 3.00683C16.9668 3.00683 20.9932 7.03321 20.9932 12C20.9932 16.9668 16.9668 20.9932 12 20.9932Z" fill="#c2a800"/> </g>
            </svg>`;
            break;
        case 'غير راضي':
        case 'Unsatisfied':
        case 'غیر مطمئن':
        case 'Hindi Nasisiyahan':
            return `<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
            <svg class="object-contain w-16 min-w-16 max-w-16 min-h-16 max-h-16  h-16"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
            <g id="SVGRepo_iconCarrier"> <path d="M8.5 11C9.32843 11 10 10.3284 10 9.5C10 8.67157 9.32843 8 8.5 8C7.67157 8 7 8.67157 7 9.5C7 10.3284 7.67157 11 8.5 11Z" fill="#a21111"/> <path d="M17 9.5C17 10.3284 16.3284 11 15.5 11C14.6716 11 14 10.3284 14 9.5C14 8.67157 14.6716 8 15.5 8C16.3284 8 17 8.67157 17 9.5Z" fill="#a21111"/> <path d="M15.1091 16.4588C15.3597 16.9443 15.9548 17.1395 16.4449 16.8944C16.9388 16.6474 17.1391 16.0468 16.8921 15.5528C16.8096 15.3884 16.7046 15.2343 16.5945 15.0875C16.4117 14.8438 16.1358 14.5299 15.7473 14.2191C14.9578 13.5875 13.7406 13 11.9977 13C10.2547 13 9.03749 13.5875 8.24796 14.2191C7.85954 14.5299 7.58359 14.8438 7.40078 15.0875C7.29028 15.2348 7.1898 15.3889 7.10376 15.5517C6.85913 16.0392 7.06265 16.6505 7.55044 16.8944C8.04053 17.1395 8.63565 16.9443 8.88619 16.4588C8.9 16.4339 9.08816 16.1082 9.49735 15.7809C9.95782 15.4125 10.7406 15 11.9977 15C13.2547 15 14.0375 15.4125 14.498 15.7809C14.9072 16.1082 15.0953 16.4339 15.1091 16.4588Z" fill="#a21111"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 23C18.0751 23 23 18.0751 23 12C23 5.92487 18.0751 1 12 1C5.92487 1 1 5.92487 1 12C1 18.0751 5.92487 23 12 23ZM12 20.9932C7.03321 20.9932 3.00683 16.9668 3.00683 12C3.00683 7.03321 7.03321 3.00683 12 3.00683C16.9668 3.00683 20.9932 7.03321 20.9932 12C20.9932 16.9668 16.9668 20.9932 12 20.9932Z" fill="#a21111"/> </g>
            </svg>`;
            break;



        default:
            return `<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                <svg class="object-contain w-16 min-w-16 max-w-16 min-h-16 max-h-16  h-16"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                <g id="SVGRepo_iconCarrier"> <path d="M15.1091 16.4588C15.3597 16.9443 15.9548 17.1395 16.4449 16.8944C16.9388 16.6474 17.1391 16.0468 16.8921 15.5528C16.8096 15.3884 16.7046 15.2343 16.5945 15.0875C16.4117 14.8438 16.1358 14.5299 15.7473 14.2191C14.9578 13.5875 13.7406 13 11.9977 13C10.2547 13 9.03749 13.5875 8.24796 14.2191C7.85954 14.5299 7.58359 14.8438 7.40078 15.0875C7.29028 15.2348 7.1898 15.3889 7.10376 15.5517C6.85913 16.0392 7.06265 16.6505 7.55044 16.8944C8.04053 17.1395 8.63565 16.9443 8.88619 16.4588C8.9 16.4339 9.08816 16.1082 9.49735 15.7809C9.95782 15.4125 10.7406 15 11.9977 15C13.2547 15 14.0375 15.4125 14.498 15.7809C14.9072 16.1082 15.0953 16.4339 15.1091 16.4588Z" fill="#d92626"/> <path d="M6.29289 7.29289C6.68342 6.90237 7.31658 6.90237 7.70711 7.29289L9.70711 9.29289C10.0976 9.68342 10.0976 10.3166 9.70711 10.7071C9.31658 11.0976 8.68342 11.0976 8.29289 10.7071L6.29289 8.70711C5.90237 8.31658 5.90237 7.68342 6.29289 7.29289Z" fill="#d92626"/> <path d="M17.7071 8.70711C18.0976 8.31658 18.0976 7.68342 17.7071 7.29289C17.3166 6.90237 16.6834 6.90237 16.2929 7.29289L14.2929 9.29289C13.9024 9.68342 13.9024 10.3166 14.2929 10.7071C14.6834 11.0976 15.3166 11.0976 15.7071 10.7071L17.7071 8.70711Z" fill="#d92626"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 23C18.0751 23 23 18.0751 23 12C23 5.92487 18.0751 1 12 1C5.92487 1 1 5.92487 1 12C1 18.0751 5.92487 23 12 23ZM12 20.9932C7.03321 20.9932 3.00683 16.9668 3.00683 12C3.00683 7.03321 7.03321 3.00683 12 3.00683C16.9668 3.00683 20.9932 7.03321 20.9932 12C20.9932 16.9668 16.9668 20.9932 12 20.9932Z" fill="#d92626"/> </g>
                </svg>`;
    }


}

// reload page action from webapp
window.addEventListener('ReloadPage', event => {

    if(current_question_no==0)
    reload();
});

//    reload page function
// this function will test connection with server if ok the refresh page
// if no then will show error connection and trigger wait error function to refresh page automaticlly
function reload()
{
    const timeout=3000;
    const signal = AbortSignal.timeout(timeout);
    fetch(app_url, {
        method: "GET",
        signal,
        }).then(response => response)
        .then(data => {
        window.location.reload();
        })
        .catch((error) => {
            formSection=document.getElementById('form_section');
        errorreload=document.getElementById('errorReload');
        header=document.getElementById('header');
        header.classList.add('hidden');
        formSection.classList.add('hidden');
        errorreload.classList.remove('hidden');
        errorreload.classList.add('grid');
        // document.getElementById('svg_reload').classList.remove('animate-spin');
        waiterror();
        });
}

// try to  start form after user select langauge
function trystartform(langCode)
{

    homepage=document.getElementById('homepage');
    label=document.getElementById(`language_button_label-${langCode}`);
    var x = document.getElementsByClassName("language_button");
        var i;
        for (i = 0; i < x.length; i++) {x[i].disabled = true;}
    homepage.setAttribute('disabled');
    label.innerHTML=`
        <div class="flex items-center">
            <svg class="animate-spin h-14 w-14 mr-1 text-secondary_blue" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"></path>
            </svg>
        </div>
    `;

    homepage.style.opacity = "0.5";
    const timeout=8000;
    const signal = AbortSignal.timeout(timeout);
    fetch(app_url, {
        method: "GET",
        signal,
        })
        .then(data => {

                livewire.emit('startform',langCode);
        })
        .catch((error) => {
            homepage.removeAttribute('disabled');
            homepage.style.opacity = "1";

        formSection=document.getElementById('form_section');
        errorreload=document.getElementById('errorReload');
        header=document.getElementById('header');
        header.classList.add('hidden');
        formSection.classList.add('hidden');
        errorreload.classList.remove('hidden');
        errorreload.classList.add('grid');
        waiterror();
        });


}

// slider for welcome message at start of form
$('.owl-carousel').owlCarousel({
        loop:true,
        nav:false,
        autoplay:true,
        autoplayTimeout: 6000,

        smartSpeed: 450,

        // animateOut: 'slideOutDown',
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        items:1,
        margin:30,
        center:true,
        stopOnHover : false,
        autoPlayHoverPause:false,
        touchDrag  : false,
        mouseDrag  :false,
        onTranslate: function (event) {
        $('.owl-item').removeClass('animated');},
        //    onTranslated:function (event) {
        //     $('.owl-item').addClass('animated');
        //    },
})

// to recheck if there error in survey like (no question or expiry or no responses )
function RecheckPage(){
    const timeout=8000;
    const signal = AbortSignal.timeout(timeout);
    document.getElementById('recheckText').innerHTML=`<svg class="animate-spin h-10 w-10 mr-1 text-secondary_blue" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"></path>
  </svg`;
    fetch(app_url, {
        method: "GET",
        signal,
        })
        .then(data => {
           window.location.reload();
        })
        .catch((error) => {

            ConnectionError=true;
        formSection=document.getElementById('form_section');
        errorreload=document.getElementById('errorReload');
        header=document.getElementById('header');
        header.classList.add('hidden');
        formSection.classList.add('hidden');
        errorreload.classList.remove('hidden');
        errorreload.classList.add('grid');
        waiterror();
        });
}

// this script to control in timer of start form (fire function if there is no action )=>start
//,end form(reload form after submit response)=>finish
//and refresh page after any error=>wait error



// to start alarm (no action) message
function start(){

    var start=true;
    if(start==true){
    $(document).ready(function () {
        // Increment the idle time counter every minute.
        var idleInterval = setInterval(timerIncrementStart, 20000); // 1 minute

        // Zero the idle timer on mouse movement.
        $(this).mousemove(function (e) {

            idleTime = 0;

        });
        $(this).click(function (e) {

        idleTime = 0;

        });
        $(this).keypress(function (e) {

            idleTime = 0;
        });


    });
    }

    function timerIncrementStart() {
        idleTime = idleTime + 1;

        if (idleTime == 3&&finished==false&&ConnectionError==false) {// 1 minutes
            var text = JSON.parse(JSON.stringify(alarmtext));

            let timerInterval
            Swal.fire({

            html:`<div class="pointer-events-none grid">
                    <h1>${ text[language]['warning']}</h1>
                    <h1><b></b></h1>
                </div>`,
            icon: 'warning',
            showConfirmButton:true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: text[language]['button'],
            timer: 30000,
            allowOutsideClick: false,
            timerProgressBar: true,
            didOpen: () => {
                // Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                timerInterval = setInterval(() => {
                    b.textContent =parseInt(Swal.getTimerLeft()/1000)
                }, 100)
            },
            willClose: () => {
                clearInterval(timerInterval)
            }
            }).then((result) => {
            if (result.isConfirmed) {
                idleTime=0;
                start=true;

            }
            else
            finishform();
            })


        }
        // // else if(idleTime == 6&&finished==false){
        // //     // here i will save form review if the user do not action for 40s idletime+=1 == 10s when idletime =6 -> 40s left with 20 to show message of issue
        // //     window.location.reload();
        // }
    }
}
function resetidletime()
{
          idleTime = 0;
}
function resetidletimeonscroll()
{
    reload();
    idleTime = 0;

}

function finish()
{
    var idleTime = 0;
    var start=true;
    if(start==true){
    $(document).ready(function () {
        // Increment the idle time counter every minute.
        var idleInterval = setInterval(timerIncrementFinish, 7000);



    });
    }
    function timerIncrementFinish() {
        idleTime = idleTime + 1;

        if (idleTime == 1) {// 10 seconds
            reload();
        }

    }
}
// wait error connection to refresh
function waiterror()
{
    $(document).ready(function () {
        // Increment the idle time counter every minute.
        var idleInterval = setInterval(timerIncrementFinish, 10000); // 10 seconds
    });
    function timerIncrementFinish()
    {reload();}
}

// auto refresh to handle session expiry
function AutoRefresh(){

        if(step==null)
        window.location.reload();
}
//interval eery hour to auto refresh page by use autorefresh function
setInterval(AutoRefresh, 3600000);//3600000


// drawing section
function createDrawing()
{
    var wrapper = document.getElementById("drawing-pad");
    var canvas = wrapper.querySelector("canvas");
    drawingPad = new SignaturePad(canvas, {backgroundColor: 'rgb(255, 255, 255)'});
    canvas.addEventListener('touchstart', handleTouch);
    canvas.addEventListener('touchmove', handleTouch);
    canvas.addEventListener('click', handleTouch);
    canvas.width = canvas.scrollWidth;
    canvas.height = canvas.scrollHeight;
    window.addEventListener('resize', function() {canvas.width = canvas.scrollWidth;canvas.height = canvas.scrollHeight;});

}
function handleTouch()
{
    idleTime = 0;

        if(drawingPad.isEmpty()==false)
        {btn_next.disabled =false;}
        else
        current_question.optional==1?btn_next.disabled =false:btn_next.disabled =true;
        drawingPad.isEmpty()&&current_question.optional==1?SetNextInnerText(false):SetNextInnerText(true);

}
function clearDrawing()
{
    drawingPad.clear();
        if(drawingPad.isEmpty()==false)
        {btn_next.disabled =false;}
        else
        current_question.optional==1?btn_next.disabled =false:btn_next.disabled =true;
        drawingPad.isEmpty()&&current_question.optional==1?SetNextInnerText(false):SetNextInnerText(true);
}



function dataURLToBlob(dataURL)
{
    var parts = dataURL.split(';base64,');
    var contentType = parts[0].split(":")[1];
    var raw = window.atob(parts[1]);
    var rawLength = raw.length;
    var uInt8Array = new Uint8Array(rawLength);

    for (var i = 0; i < rawLength; ++i) {
        uInt8Array[i] = raw.charCodeAt(i);
    }
    return new Blob([uInt8Array], { type: contentType });
}

