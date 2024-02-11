var create_acc = document.querySelector(".create_acc");
var main_pages = document.querySelectorAll(".main");
var next_page = document.querySelector(".next_page");
var back_page = document.querySelectorAll(".back_page");
var submit_page = document.querySelector(".submit_page");
var user_name = document.querySelector(".user_name");
var shown_name = document.querySelector(".shown_name");
let formnumber=0;
create_acc.onclick=function(){
    if(!validateform()){
        return false;
    }
    formnumber++;
    updateform();
}
next_page.onclick=function(){
    if(!validateform()){
        return false;
    }
    formnumber++;
    updateform();
}
back_page.forEach(function(back){
    back.onclick=function(){

    formnumber--;
    updateform();
}
});
submit_page.onclick=function(){
    if(!validateform()){
        return false;
    }
    formnumber++;
    updateform();
    shown_name.innerHTML=user_name.value;
}

function updateform(){
    main_pages.forEach(function(page){
        page.classList.add('hidden');
        page.classList.remove('block');
    });
    main_pages[formnumber].classList.remove('hidden');
    main_pages[formnumber].classList.add('block');
}
function validateform(){
    var validate=true;
    var inputs=document.querySelectorAll(".main.block input");
    inputs.forEach(function(e){
       e.classList.remove('warning');
       if(e.hasAttribute('require')){
           if(e.value.length=="0"){
               validate=false;
               e.classList.add('warning')
           }
       }

    });
    return validate;
}

var eye=document.querySelector(".fa-eye-slash");
var pass=document.querySelector(".pass");
var seteye=document.querySelector(".fa-eye-slash");

eye.onclick=function(){
    alert("sdff");
    if(pass.type=="password"){
        pass.type="text";
        seteye.classList.remove('fa-eye-slash');
        seteye.classList.add('fa-eye');
    }
    else{
        pass.type="password";
        seteye.classList.add('fa-eye-slash');
        seteye.classList.remove('fa-eye');
    }
}
