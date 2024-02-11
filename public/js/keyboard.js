// const { indexOf } = require("lodash");

/* VIRTUAL KEYBOARD DEMO - https://github.com/Mottie/Keyboard */
var activeColor="#1277D1";
var activeTextColor="#ffffff";
var normalColor="transparent";
var normalTextColor="#000000";
var borderColor="";
function createkeyboard(num=false,surveyLanguage) {
    let inputfeild=document.getElementById('InputArea');
    inputfeild.addEventListener('select', function() {
        this.selectionStart = this.selectionEnd;
      }, false);
      if(!num)
        {
            var VirtualKeyboard = {
                generate: function(target, matrix, language, uppercase = false,prevlang) {
                var owner = this;

                for(var i = 0; i < matrix.length; i++) {
                    var position = matrix[i];

                    var vkr = document.createElement('div');
                    vkr.setAttribute('class', 'virtual-keyboard-row');

                    var vkc = document.createElement('div');
                    vkc.setAttribute('class', 'virtual-keyboard-column');

                    for (var j = 0; j < position.length; j++) {
                    var button = document.createElement('button');
                    button.classList.add('pointer-event-none');
                    switch(matrix[i][j]) {
                        case '+backspace':
                        button.innerHTML = '<span class="pointer-events-none">&#9003</span>';
                        button.setAttribute('data-trigger', 'backspace');
                        button.setAttribute('title', 'Backspace');
                        /* the slicing using timer */
                        var mouseTimerHandler = null;
                        button.addEventListener("mousedown", function(event) {

                            mouseTimerHandler = setInterval(function(){
                            if (event.which == 1) {
                                _lastElementFocused.value = _lastElementFocused.value.slice(0, -1);
                            }
                            }, 200);
                        }, false);
                        button.addEventListener("mouseup", function() {
                            clearTimeout(mouseTimerHandler);
                        });
                        button.style.width = '108px';
                        break;
                        case '+ar':
                        button.innerHTML =`<span id="lang" >العربية</span>`;
                        button.setAttribute('data-trigger', 'ar');
                        button.setAttribute('title', 'Ar');
                        button.style.width = '15%';
                        button.style.maxWidth="15%";
                        button.style.minWidth="15%";
                        language==="ar"?button.style.backgroundColor=activeColor:button.style.backgroundColor=normalColor;
                        language==="ar"?button.style.color=activeTextColor:button.style.color=normalTextColor;
                        break;
                        case '+en':
                        button.innerHTML =`<span id="lang" >English</span>`;
                        button.setAttribute('data-trigger', 'en');
                        button.setAttribute('title', 'En');
                        button.style.width = '15%';
                        button.style.maxWidth="15%";
                        button.style.minWidth="15%";
                        language==="en"?button.style.backgroundColor=activeColor:button.style.backgroundColor=normalColor;
                        language==="en"?button.style.color=activeTextColor:button.style.color=normalTextColor;
                        break;
                        case '+tl':
                        button.innerHTML =`<span id="lang" >Tagalog</span>`;
                        button.setAttribute('data-trigger', 'tl');
                        button.setAttribute('title', 'Tl');
                        button.style.width = '15%';
                        button.style.maxWidth="15%";
                        button.style.minWidth="15%";
                        language==="tl"?button.style.backgroundColor=activeColor:button.style.backgroundColor=normalColor;
                        language==="tl"?button.style.color=activeTextColor:button.style.color=normalTextColor;
                        break;
                        case '+ur':
                        button.innerHTML =`<span id="lang" >اردو</span>`;
                        button.setAttribute('data-trigger', 'ur');
                        button.setAttribute('title', 'Ur');
                        button.style.width = '15%';
                        button.style.maxWidth="15%";
                        button.style.minWidth="15%";
                        language==="ur"?button.style.backgroundColor=activeColor:button.style.backgroundColor=normalColor;
                        language==="ur"?button.style.color=activeTextColor:button.style.color=normalTextColor;
                        break;
                        case '+shift':
                        button.innerHTML = 'shift';
                        button.setAttribute('data-trigger', 'shift');
                        button.setAttribute('title', 'Shift');
                        button.style.width = '20%';
                        break;
                        case '+123?':
                        button.innerHTML = '123?';
                        button.setAttribute('data-trigger', '123?');
                        button.setAttribute('title', '123?');

                        button.style.width = '15%';
                        break;
                        case '+abc':
                        button.innerHTML = 'abc';
                        prevlang===null?prevlang="en":prevlang=prevlang;
                        console.log(prevlang);
                        button.setAttribute('data-trigger', prevlang);

                        button.setAttribute('title', 'abc');
                        button.style.width = '15%';
                        break;
                        case '+space':
                        button.innerHTML = '&nbsp;';
                        button.setAttribute('data-trigger', 'space');
                        button.setAttribute('title', 'Space');
                        button.style.width = '50%';
                        break;

                        default:

                        // button.innerHTML = `<span class="pointer-events-none">${(matrix[i][j]).toUpperCase()}</span>`;
                        button.innerHTML = uppercase ?  `<span class="pointer-events-none">${(matrix[i][j]).toUpperCase()}</span>` : `<span class="pointer-events-none">${matrix[i][j]}</span>`;
                        break;
                    }

                    SetButtonClass(button,matrix[i][j]);
                    button.addEventListener('click', function () {
                        _lastElementFocused.focus();
                        var x = this.getAttribute('data-trigger');
                        var idx=0;
                          idx=inputfeild.value.slice(0,inputfeild.selectionStart).length;



                        if (x != null) {
                        switch(x) {
                            case 'backspace':
                                _lastElementFocused.value = _lastElementFocused.value.slice(0, -1);

                                updateValue( _lastElementFocused.value);

                                resetidletime();
                                // var val=[];
                                // val=_lastElementFocused.value.split("");
                                // val.splice(val.indexOf(val[idx-1]), 1);
                                // _lastElementFocused.value=val.join("");
                                // updateValue( _lastElementFocused.value);
                                // resetidletime();
                                break;
                            case 'ar':
                                var reversed='ar';

                                target.innerHTML = '';


                                owner.generate(target,owner.getMatrix(reversed), reversed);

                                    inputfeild.classList.remove('text-left')
                                    inputfeild.classList.add('text-right');
                                    resetidletime();
                                break;
                            case 'en':
                                var reversed='en';
                                target.innerHTML = '';
                                owner.generate(target,owner.getMatrix(reversed), reversed);
                                    inputfeild.classList.remove('text-right')
                                    inputfeild.classList.add('text-left');
                                    resetidletime();
                                break;
                            case 'tl':
                                var reversed='tl';
                                target.innerHTML = '';
                                owner.generate(target,owner.getMatrix(reversed), reversed);
                                inputfeild.classList.remove('text-right')
                                inputfeild.classList.add('text-left');
                                resetidletime();
                                break;
                            case 'ur':
                                var reversed='ur';
                                target.innerHTML = '';
                                owner.generate(target,owner.getMatrix(reversed), reversed);
                                inputfeild.classList.remove('text-left')
                                inputfeild.classList.add('text-right');
                                resetidletime();
                                break;

                            case 'space':
                                _lastElementFocused.value = _lastElementFocused.value + ' ';
                                updateValue( _lastElementFocused.value);
                                resetidletime();
                                break;
                            case 'shift':
                                var u = uppercase === true ? false : true;
                                target.innerHTML = '';
                                owner.generate(target,owner.getMatrix(language), language, u);
                                resetidletime();
                                break;
                            case '123?':
                                target.innerHTML = '';
                                console.log(language);
                                owner.generate(target,owner.getMatrix('ch'), 'ch',false,language);
                                resetidletime();
                                break;
                                }
                        }
                        else {
                        //     var val=[];
                        //    val=_lastElementFocused.value.split("");
                        //     val.splice(idx, 0, this.innerText);
                        // _lastElementFocused.value=val.join("");
                        if(_lastElementFocused.value.length<inputfeild.maxLength)
                       {_lastElementFocused.value=_lastElementFocused.value+this.innerText;
                        updateValue( _lastElementFocused.value);}
                        resetidletime();

                        }
                    });
                    vkc.appendChild(button);

                    vkr.appendChild(vkc);
                    target.appendChild(vkr);
                    }
                }
                },
                getMatrix: function(language) {
                var matrix = {
                    en: [
                    ['+ar','q','w','e','r','t','y','u','i','o','p'],
                    ['+en','a','s','d','f','g','h','j','k','l'],
                    ['+tl','z','x','c','v','b','n','m','+backspace'],
                    ['+ur','+shift','+space','+123?']
                ],
                tl: [
                    ['+ar','q','w','e','r','t','y','u','i','o','p'],
                    ['+en','a','s','d','f','g','h','j','k','l'],
                    ['+tl','z','x','c','v','b','n','m','+backspace'],
                    ['+ur','+shift','+space','+123?']
                ],
                ur: [
                    ['+ar','ط','ظ','ص','ض','ہ','ذ','د','ڈ','ث','ٹ','پ','ب','س'],
                    ['+en','ت','ج','چ','ح','خ','م','ژ','و','ز','ن','ل','ہ','ش'],
                    ['+tl','آ','ا','ک','گ','ی','ے','ق','ف','غ','ع','+backspace'],
                    ['+ur','+shift','+space','+123?']
                    ],
                    ar: [
                        ['+ar','ذ','ض','ص','ث','ق','ف','غ','ع','ه','خ','ح','ج','د'],
                        ['+en','ش','س','ي','ب','ل','ا','ت','ن','م','ك','ط'],
                        ['+tl','ئ','ء','ؤ','ر','أ','ى','ة','و','ز','ظ','+backspace'],
                        ['+ur','+shift','+space','+123?']
                    ],

                    ch:[['1','2','3','4','5','6','7','8','9','0','+'],
                        ['-','*','^','&',':',';','<','>',')','.','('],
                        ['%','!','#','\\','$','/','?','"','\'',',','.'],
                        ['+abc','_','+space','@','+backspace']
                        ]
                            };
                return matrix[language];
                },
                init: function(args) {
                if (args != undefined && args != null) {
                    if (Object.keys(args).length > 0) {
                    var owner = this;

                    window._lastElementFocused = null;

                    var target = document.getElementById(args['targetId']);
                    var language = args['defaultLanguage'];
                    var elements = document.querySelectorAll(args['inputSelector']);

                    _lastElementFocused = elements[0];

                    for (var i = 0; i < elements.length; i++) {
                        elements[i].addEventListener('focus', function () {
                        _lastElementFocused = this;
                        });
                    }
                    owner.generate(target,owner.getMatrix(language), language);
                    }
                }
                }
            }

            VirtualKeyboard.init({targetId: 'tabular-virtual-keyboard', defaultLanguage:surveyLanguage, inputSelector: '[data-virtual-element]'});
        }
        else{
            document.getElementById('tabular-virtual-keyboard').style.minWidth ="250px";
             var VirtualKeyboardNum = {
            generate: function(target, matrix, language, uppercase = false) {
            var owner = this;

            for(var i = 0; i < matrix.length; i++) {
                var position = matrix[i];

                var vkr = document.createElement('div');
                vkr.setAttribute('class', 'virtual-keyboard-row');

                var vkc = document.createElement('div');
                vkc.setAttribute('class', 'virtual-keyboard-column');

                for (var j = 0; j < position.length; j++) {
                var button = document.createElement('button');
                button.classList.add('pointer-event-none');
                switch(matrix[i][j]) {
                    case '+backspace':
                    button.innerHTML = '<span class="pointer-events-none"><--</span>';
                    button.setAttribute('data-trigger', 'backspace');
                    button.setAttribute('title', 'Backspace');
                    /* the slicing using timer */
                    var mouseTimerHandler = null;
                    button.addEventListener("mousedown", function(event) {

                        mouseTimerHandler = setInterval(function(){
                        if (event.which == 1) {
                            _lastElementFocused.value = _lastElementFocused.value.slice(0, -1);
                        }
                        }, 200);
                    }, false);
                    button.addEventListener("mouseup", function() {
                        clearTimeout(mouseTimerHandler);
                    });
                    button.style.width = '108px';
                    break;
                    // case '+ar':
                    //   button.innerHTML =`<span id="lang" >العربية</span>`;
                    //   button.setAttribute('data-trigger', 'ar');
                    //   button.setAttribute('title', 'Ar');
                    //   button.style.width = '15%';
                    //   break;
                    //   case '+en':
                    //   button.innerHTML =`<span id="lang" >English</span>`;
                    //   button.setAttribute('data-trigger', 'en');
                    //   button.setAttribute('title', 'En');
                    //   button.style.width = '15%';
                    //   break;
                    //   case '+tl':
                    //   button.innerHTML =`<span id="lang" >Tagalog</span>`;
                    //   button.setAttribute('data-trigger', 'tl');
                    //   button.setAttribute('title', 'Tl');
                    //   button.style.width = '15%';
                    //   break;
                    //   case '+ur':
                    //   button.innerHTML =`<span id="lang" >Urdu</span>`;
                    //   button.setAttribute('data-trigger', 'ur');
                    //   button.setAttribute('title', 'Ur');
                    //   button.style.width = '15%';
                    //   break;
                    // case '+shift':
                    //   button.innerHTML = 'shift';
                    //   button.setAttribute('data-trigger', 'shift');
                    //   button.setAttribute('title', 'Shift');
                    //   button.style.width = '20%';
                    //   break;
                    //   case '+123?':
                    //   button.innerHTML = '123?';
                    //   button.setAttribute('data-trigger', '123?');
                    //   button.setAttribute('title', '123?');
                    //   button.style.width = '15%';
                    //   break;
                    //   case '+abc':
                    //   button.innerHTML = 'abc';
                    //   button.setAttribute('data-trigger', 'en');
                    //   button.setAttribute('title', 'abc');
                    //   button.style.width = '15%';
                    //   break;
                    // case '+space':
                    button.innerHTML = '&nbsp;';
                    button.setAttribute('data-trigger', 'space');
                    button.setAttribute('title', 'Space');
                    button.style.width = '50%';
                    break;

                    default:

                    // button.innerHTML = `<span class="pointer-events-none">${(matrix[i][j]).toUpperCase()}</span>`;
                    button.innerHTML = uppercase ?  `<span class="pointer-events-none">${(matrix[i][j]).toUpperCase()}</span>` : `<span class="pointer-events-none">${matrix[i][j]}</span>`;
                    break;
                }

                SetButtonClass(button,matrix[i][j]);
                button.style.width="105px";
                button.addEventListener('click', function () {
                    _lastElementFocused.focus();
                    var x = this.getAttribute('data-trigger');
                    if (x != null) {
                    switch(x) {
                        case 'backspace':
                        _lastElementFocused.value = _lastElementFocused.value.slice(0, -1);
                        console.log(_lastElementFocused.value.length);
                        updateValue( _lastElementFocused.value);
                        resetidletime();
                        break;
                        // case 'ar':
                        //   var reversed='ar';

                        //   target.innerHTML = '';
                        //   owner.generate(target,owner.getMatrix(reversed), reversed);

                        //     inputfeild.classList.remove('text-left')
                        //     inputfeild.classList.add('text-right');
                        //     resetidletime();
                        //   break;
                        //   case 'en':
                        //   var reversed='en';
                        //   target.innerHTML = '';
                        //   owner.generate(target,owner.getMatrix(reversed), reversed);
                        //     inputfeild.classList.remove('text-right')
                        //     inputfeild.classList.add('text-left');
                        //     resetidletime();
                        //   break;
                        //   case 'tl':
                        //   var reversed='tl';
                        //   target.innerHTML = '';
                        //   owner.generate(target,owner.getMatrix(reversed), reversed);
                        //     inputfeild.classList.remove('text-right')
                        //     inputfeild.classList.add('text-left');
                        //     resetidletime();
                        //   break;
                        //   case 'ur':
                        //   var reversed='ur';
                        //   target.innerHTML = '';
                        //   owner.generate(target,owner.getMatrix(reversed), reversed);
                        //     inputfeild.classList.remove('text-left')
                        //     inputfeild.classList.add('text-right');
                        //     resetidletime();

                        //   break;

                        // case 'space':
                        //   _lastElementFocused.value = _lastElementFocused.value + ' ';
                        //   updateValue( _lastElementFocused.value);
                        //   resetidletime();
                        //   break;
                        // case 'shift':
                        //   var u = uppercase === true ? false : true;
                        //   target.innerHTML = '';
                        //   owner.generate(target,owner.getMatrix(language), language, u);
                        //   resetidletime();
                        //   break;
                        //   case '123?':
                            target.innerHTML = '';
                            owner.generate(target,owner.getMatrix('ch'), 'ch');
                            resetidletime();
                            break;
                            }
                    }
                    else {
                    _lastElementFocused.value = _lastElementFocused.value + this.innerText;
                    updateValue( _lastElementFocused.value);
                    resetidletime();

                    }
                });
                vkc.appendChild(button);

                vkr.appendChild(vkc);
                target.appendChild(vkr);
                }
            }
            },
            getMatrix: function(language) {
            var matrix = {
            //     en: [
            //     ['+ar','q','w','e','r','t','y','u','i','o','p'],
            //     ['+en','a','s','d','f','g','h','j','k','l'],
            //     ['+tl','z','x','c','v','b','n','m','+backspace'],
            //     ['+ur','+shift','+space','+123?']
            //   ],
            //   tl: [
            //     ['+ar','q','w','e','r','t','y','u','i','o','p'],
            //     ['+en','a','s','d','f','g','h','j','k','l'],
            //     ['+tl','z','x','c','v','b','n','m','+backspace'],
            //     ['+ur','+shift','+space','+123?']
            //   ],
            //  ur: [
            //      ['+ar','ط','ظ','ص','ض','ہ','ذ','د','ڈ','ث','ٹ','پ','ب','س'],
            //      ['+en','ت','ج','چ','ح','خ','م','ژ','و','ز','ن','ل','ہ','ش'],
            //      ['+tl','آ','ا','ک','گ','ی','ے','ق','ف','غ','ع','+backspace'],
            //      ['+ur','+shift','+space','+123?']
            //     ],
            //     ar: [
            //         ['+ar','ذ','ض','ص','ث','ق','ف','غ','ع','ه','خ','ح','ج'],
            //         ['+en','ش','س','ي','ب','ل','ا','ت','ن','م','ك','ط'],
            //         ['+tl','ئ','ء','ؤ','ر','أ','ى','ة','و','ز','ظ','+backspace'],
            //         ['+ur','+shift','+space','+123?']
            //        ],

                ch:[['1','2','3'],
                    ['4','5','6'],
                    ['7','8','9'],
                    ['+','0','+backspace']
                    ]
                        };
            return matrix[language];
            },
            init: function(args) {
            if (args != undefined && args != null) {
                if (Object.keys(args).length > 0) {
                var owner = this;

                window._lastElementFocused = null;

                var target = document.getElementById(args['targetId']);
                var language = args['defaultLanguage'];
                var elements = document.querySelectorAll(args['inputSelector']);

                _lastElementFocused = elements[0];

                for (var i = 0; i < elements.length; i++) {
                    elements[i].addEventListener('focus', function () {
                    _lastElementFocused = this;
                    });
                }
                owner.generate(target,owner.getMatrix(language), language);
                }
            }
            }
        }

        VirtualKeyboardNum.init({targetId: 'tabular-virtual-keyboard', defaultLanguage: 'ch', inputSelector: '[data-virtual-element]'});}
  }
//   email keyboard
  function createEmailkeyboard() {
    let inputfeild=document.getElementById('InputArea');
    inputfeild.addEventListener('select', function() {
        this.selectionStart = this.selectionEnd;
      }, false);

            var VirtualKeyboard = {
                generate: function(target, matrix, language, uppercase = false,prevlang) {
                var owner = this;

                for(var i = 0; i < matrix.length; i++) {
                    var position = matrix[i];

                    var vkr = document.createElement('div');
                    vkr.setAttribute('class', 'virtual-keyboard-row');

                    var vkc = document.createElement('div');
                    vkc.setAttribute('class', 'virtual-keyboard-column');

                    for (var j = 0; j < position.length; j++) {
                    var button = document.createElement('button');
                    button.classList.add('pointer-event-none');
                    switch(matrix[i][j]) {
                        case '+backspace':
                        button.innerHTML = '<span class="pointer-events-none">&#9003</span>';
                        button.setAttribute('data-trigger', 'backspace');
                        button.setAttribute('title', 'Backspace');
                        /* the slicing using timer */
                        var mouseTimerHandler = null;
                        button.addEventListener("mousedown", function(event) {

                            mouseTimerHandler = setInterval(function(){
                            if (event.which == 1) {
                                _lastElementFocused.value = _lastElementFocused.value.slice(0, -1);
                            }
                            }, 200);
                        }, false);
                        button.addEventListener("mouseup", function() {
                            clearTimeout(mouseTimerHandler);
                        });
                        button.style.width = '108px';
                        break;
                        case '+ar':
                        button.innerHTML =`<span id="lang" >العربية</span>`;
                        button.setAttribute('data-trigger', 'ar');
                        button.setAttribute('title', 'Ar');
                        button.style.width = '15%';
                        button.style.maxWidth="15%";
                        button.style.minWidth="15%";
                        language==="ar"?button.style.backgroundColor=activeColor:button.style.backgroundColor=normalColor;
                        language==="ar"?button.style.color=activeTextColor:button.style.color=normalTextColor;
                        break;
                        case '+en':
                        button.innerHTML =`<span id="lang" >English</span>`;
                        button.setAttribute('data-trigger', 'en');
                        button.setAttribute('title', 'En');
                        button.style.width = '15%';
                        button.style.maxWidth="15%";
                        button.style.minWidth="15%";
                        language==="en"?button.style.backgroundColor=activeColor:button.style.backgroundColor=normalColor;
                        language==="en"?button.style.color=activeTextColor:button.style.color=normalTextColor;
                        break;
                        case '+tl':
                        button.innerHTML =`<span id="lang" >Tagalog</span>`;
                        button.setAttribute('data-trigger', 'tl');
                        button.setAttribute('title', 'Tl');
                        button.style.width = '15%';
                        button.style.maxWidth="15%";
                        button.style.minWidth="15%";
                        language==="tl"?button.style.backgroundColor=activeColor:button.style.backgroundColor=normalColor;
                        language==="tl"?button.style.color=activeTextColor:button.style.color=normalTextColor;
                        break;
                        case '+ur':
                        button.innerHTML =`<span id="lang" >اردو</span>`;
                        button.setAttribute('data-trigger', 'ur');
                        button.setAttribute('title', 'Ur');
                        button.style.width = '15%';
                        button.style.maxWidth="15%";
                        button.style.minWidth="15%";
                        language==="ur"?button.style.backgroundColor=activeColor:button.style.backgroundColor=normalColor;
                        language==="ur"?button.style.color=activeTextColor:button.style.color=normalTextColor;
                        break;
                        case '+shift':
                        button.innerHTML = 'shift';
                        button.setAttribute('data-trigger', 'shift');
                        button.setAttribute('title', 'Shift');
                        button.style.width = '20%';
                        break;
                        case '+123?':
                        button.innerHTML = '123?';
                        button.setAttribute('data-trigger', '123?');
                        button.setAttribute('title', '123?');

                        button.style.width = '15%';
                        break;
                        case '+abc':
                        button.innerHTML = 'abc';
                        prevlang===null?prevlang="en":prevlang=prevlang;
                        console.log(prevlang);
                        button.setAttribute('data-trigger', prevlang);

                        button.setAttribute('title', 'abc');
                        button.style.width = '15%';
                        break;
                        case '+space':
                        button.innerHTML = '&nbsp;';
                        button.setAttribute('data-trigger', 'space');
                        button.setAttribute('title', 'Space');
                        button.style.width = '50%';
                        break;

                        default:

                        // button.innerHTML = `<span class="pointer-events-none">${(matrix[i][j]).toUpperCase()}</span>`;
                        button.innerHTML = uppercase ?  `<span class="pointer-events-none">${(matrix[i][j]).toUpperCase()}</span>` : `<span class="pointer-events-none">${matrix[i][j]}</span>`;
                        break;
                    }

                    SetButtonClass(button,matrix[i][j]);
                    button.addEventListener('click', function () {
                        _lastElementFocused.focus();
                        var x = this.getAttribute('data-trigger');
                        var idx=0;
                          idx=inputfeild.value.slice(0,inputfeild.selectionStart).length;



                        if (x != null) {
                        switch(x) {
                            case 'backspace':
                                _lastElementFocused.value = _lastElementFocused.value.slice(0, -1);
                                updateValue( _lastElementFocused.value);
                                resetidletime();
                                // var val=[];
                                // val=_lastElementFocused.value.split("");
                                // val.splice(val.indexOf(val[idx-1]), 1);
                                // _lastElementFocused.value=val.join("");
                                // updateValue( _lastElementFocused.value);
                                // resetidletime();
                                break;
                            case 'ar':
                                var reversed='ar';

                                target.innerHTML = '';


                                owner.generate(target,owner.getMatrix(reversed), reversed);

                                    inputfeild.classList.remove('text-left')
                                    inputfeild.classList.add('text-right');
                                    resetidletime();
                                break;
                            case 'en':
                                var reversed='en';
                                target.innerHTML = '';
                                owner.generate(target,owner.getMatrix(reversed), reversed);
                                    inputfeild.classList.remove('text-right')
                                    inputfeild.classList.add('text-left');
                                    resetidletime();
                                break;
                            case 'tl':
                                var reversed='tl';
                                target.innerHTML = '';
                                owner.generate(target,owner.getMatrix(reversed), reversed);
                                inputfeild.classList.remove('text-right')
                                inputfeild.classList.add('text-left');
                                resetidletime();
                                break;
                            case 'ur':
                                var reversed='ur';
                                target.innerHTML = '';
                                owner.generate(target,owner.getMatrix(reversed), reversed);
                                inputfeild.classList.remove('text-left')
                                inputfeild.classList.add('text-right');
                                resetidletime();
                                break;

                            case 'space':
                                _lastElementFocused.value = _lastElementFocused.value + ' ';
                                updateValue( _lastElementFocused.value);
                                resetidletime();
                                break;
                            case 'shift':
                                var u = uppercase === true ? false : true;
                                target.innerHTML = '';
                                owner.generate(target,owner.getMatrix(language), language, u);
                                resetidletime();
                                break;
                            case '123?':
                                target.innerHTML = '';
                                console.log(language);
                                owner.generate(target,owner.getMatrix('ch'), 'ch',false,language);
                                resetidletime();
                                break;
                                }
                        }
                        else {
                        //     var val=[];
                        //    val=_lastElementFocused.value.split("");
                        //     val.splice(idx, 0, this.innerText);
                        // _lastElementFocused.value=val.join("");
                        _lastElementFocused.value=_lastElementFocused.value+this.innerText;
                        updateValue( _lastElementFocused.value);
                        resetidletime();

                        }
                    });
                    vkc.appendChild(button);

                    vkr.appendChild(vkc);
                    target.appendChild(vkr);
                    }
                }
                },
                getMatrix: function(language) {
                var matrix = {
                    en: [
                    ['q','w','e','r','t','y','u','i','o','p'],
                    ['a','s','d','f','g','h','j','k','l'],
                    ['z','x','c','v','b','n','m','+backspace'],
                    ['+shift','+space','@','.com','+123?']
                ],

                    ch:[['1','2','3','4','5','6','7','8','9','0','+'],
                        ['-','*','^','&',':',';','<','>',')','.','('],
                        ['%','!','#','\\','$','/','?','"','\'',',','.'],
                        ['+abc','_','+space','@','+backspace']
                        ]
                            };
                return matrix[language];
                },
                init: function(args) {
                if (args != undefined && args != null) {
                    if (Object.keys(args).length > 0) {
                    var owner = this;

                    window._lastElementFocused = null;

                    var target = document.getElementById(args['targetId']);
                    var language = args['defaultLanguage'];
                    var elements = document.querySelectorAll(args['inputSelector']);

                    _lastElementFocused = elements[0];

                    for (var i = 0; i < elements.length; i++) {
                        elements[i].addEventListener('focus', function () {
                        _lastElementFocused = this;
                        });
                    }
                    owner.generate(target,owner.getMatrix(language), language);
                    }
                }
                }
            }

            VirtualKeyboard.init({targetId: 'tabular-virtual-keyboard', defaultLanguage: 'en', inputSelector: '[data-virtual-element]'});

  }
function SetButtonClass(button,value){
    if(value=="+ar"||value=="+ur"||value=="+tl"||value=="+en")
    button.setAttribute('class', 'virtual-keyboard-button-langauge');
   else
   button.setAttribute('class', 'virtual-keyboard-button');
}
