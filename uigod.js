/* 
UiGod is a  HTML, JS, CSS and PHP library for creating user interfaces, Building Scalable 
Web Apps Fast, and interacting with various third party utilities out of the box.
We first have to start with the io object which is the main object of the UiGod library.
The io object has the following methods:-
1. io.in() - This method is used to select an element from the DOM and perform an action on it.
2. io.createEl() - This method is used to create an element and append it to the DOM.
3. io.addAtt() - This method is used to add attributes to an element.
4. io.out() - This method is used to output data to the DOM.

*/
const currentScriptUrl = document.currentScript.src;
const isUigodFile = currentScriptUrl && currentScriptUrl.includes('uigod.js');
    
// Get the caller function name
const callerName = (new Error().stack.split('\n')[2] || '').trim().split(' ')[0];
    

io = {
    createEl : function (param1, param2, param3) {
        // Create an element
        const newElement = document.createElement(param2);
        // Add attributes to the element
        if (typeof param3 === 'object') {
            for (let key in param3) {
                newElement.setAttribute(key, param3[key]);
            }
        }
        // Append the element to the DOM
        if (typeof param1 === 'string') {
            document.querySelector(param1).appendChild(newElement);
        } else {
            param1.appendChild(newElement);
        }
    },
    in : function (param1, param2, param3, param4) {
        // Switch case
        switch(param1){
            case 'select' :
            const sElement = document.querySelector(param2);
            if (typeof param3 === 'function' && sElement) {
                param3.call(sElement); 
            }
            if(!param3){
                return sElement;
            }
            return sElement;
            case 'pick' :
            const pElement = document.querySelectorAll(param2);
            if (typeof param3 === 'number' && typeof param4 === 'function' && pElement.length >= param3) {
                const selectedElement = elements[param3 - 1];
                param4.call(selectedElement);
                return selectedElement;
            }
            else if(!param4){
                return document.querySelectorAll(param2)[param3 - 1];
            }
            break;
            case 'all' :
            const aElement = document.querySelectorAll(param2);
            
            if (typeof param3 === 'function' && aElement.length > 0) {
                aElement.forEach(function(param2) {
                    param3.call(param2);
                });
                return aElement;
            }
            break;
            case "getValue" :
            const myElement = document.querySelector(param2);
            if(myElement.tagName.toLowerCase() === "input"){
                return myElement.value;
            }else{
                return myElement.textContent;
            }
            case "getURL" :
            const currentUrl = window.location.href;
        
            if (currentUrl.includes(param2) && typeof param3 === "function") {
                param3.call();
            } else {
                io.out("bad", "Your String is not in the URL, please debug your Links and try again.");
            }
            break;
            case "copy" :
            document.querySelectorAll('[copy]').forEach(function (copyElement) {
                if (copyElement.hasAttribute('copy')) {
                    const textToCopy = copyElement.getAttribute('copy').replace(/</g, '&lt;').replace(/>/g, '&gt;');
                    const originalText = copyElement.textContent; // Store the original text
            
                    copyElement.addEventListener('click', function () {
                        navigator.clipboard.writeText(textToCopy)
                            .then(function () {
                                console.log('Text successfully copied to clipboard:', textToCopy);
            
                                // Add a CSS class to smoothly transition the text change
                                copyElement.classList.add('copied-success');
            
                                // Change the text to "Copied successfully"
                                copyElement.textContent = 'Copied successfully';
            
                                // Revert to the original text after 3 seconds
                                setTimeout(function () {
                                    copyElement.textContent = originalText;
                                    // Remove the CSS class to reverse the transition
                                    copyElement.classList.remove('copied-success');
                                }, 3000); // 3 seconds in milliseconds
                            })
                            .catch(function (err) {
                                console.error('Unable to copy text: ', err);
                            });
                    });
                }
            });
        }
    }    
}
io.in('event', 'DOMContentLoaded', function () {
    io.in('copy');
});

document.addEventListener('DOMContentLoaded', function () {
    
// select all the elements in hero
const slide = document.querySelectorAll('.hero li');
const bottom = document.querySelectorAll('.bottom li');
// set them in an array
const slideArray = Array.from(slide);
const bottomArray = Array.from(bottom);
// set the index of the current slide
let currentSlide = 0;
let currentBottom = 0;
// get the index of the whole array
const slideLength = slideArray.length;
const bottomLength = bottomArray.length;

// Function to display the current slide and hide others
function displaySlide() {
    for (let i = 0; i < slideLength; i++) {
        if (i !== currentSlide) {
            slideArray[i].style.opacity = '0';
        }
        else {
            slideArray[i].style.opacity = '1';
            slideArray[i].querySelector('h2, p').style.zIndex = '4';
            
        }
    }
}

function displayBottom() {
    for (let i = 0; i < bottomLength; i++) {
        if (i !== currentBottom) {
            bottomArray[i].style.opacity = '0';
        }
        else {
            bottomArray[i].style.opacity = '1';
            bottomArray[i].querySelector('h2, p').style.zIndex = '4';
            
        }
    }
}

// Display the initial slide
displaySlide();
displayBottom();

// Move to the next slide every 5 seconds
setInterval(() => {
    // Increment currentSlide, wrapping back to 0 if it exceeds the number of slides
    currentSlide = (currentSlide + 1) % slideLength;
    displaySlide();
}, 5000);

setInterval(() => {
    // Increment currentSlide, wrapping back to 0 if it exceeds the number of slides
    currentBottom = (currentBottom + 1) % bottomLength;
    displayBottom();
}, 5000);
});

io.createEl('head', 'link', { rel: "stylesheet", href: "https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto+Flex:opsz,wght@8..144,100;8..144,200;8..144,300;8..144,400;8..144,500;8..144,600;8..144,700;8..144,800;8..144,900;8..144,1000&display=swap"});
io.createEl('head', 'link', { rel: "stylesheet", href: "https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"});
io.createEl('head', 'link', { rel: "preconnect", href: "https://fonts.googleapis.com"});
io.createEl('head', 'link', { rel: "preconnect", href: "https://fonts.gstatic.com"});
io.createEl('head', 'link', { rel: "stylesheet", href: "uigod.css"});