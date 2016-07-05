//functions for form varification
function validateMe() {

    function addEvent(obj, type, fn) {
      if (obj.attachEvent) {
        obj['e'+type+fn] = fn;
        obj[type+fn] = function(){obj['e'+type+fn]( window.event);}
        obj.attachEvent('on'+type, obj[type+fn]);
      } else
        obj.addEventListener(type, fn, false );
    }

    function validateName() {
        if(regName.value.length <= 3 || regName.value.length > 8){
            nameError.classList.remove("hidden");
            return false;
        }else{
            nameError.classList.add("hidden");
            return true;
        }
    }

    function validateEmail() {
        var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
        if (filter.test(regEmail.value)) {
            emailError.classList.add("hidden");
            return true;
        } else {
            emailError.classList.remove("hidden");
            return false;
        }
    }

    function validatePassLength() {
        if(passLength.value.length < 8) {
            passErrorLength.classList.remove("hidden");
            return false;
        }else{
            passErrorLength.classList.add("hidden");
            passMatch.classList.remove("hidden");
            return true;
        }

    }

    function validatePassMatch() {
        if(passLength.value == passMatch.value) {
            passErrorMatch.classList.add("hidden");
            return true;       
        }else{
            passErrorMatch.classList.remove("hidden");
            return false;
        }
    }

    function enableSubmit() {
        if(validateName() == true && validateEmail() == true && validatePassLength() == true && validatePassMatch() == true){
            submit.disabled = false;
        }else{
            submit.disabled = true;
        }
    }

    //variables for input fields & errors
    var regName = document.getElementById("reg-name");
    var regEmail = document.getElementById("reg-email");
    var nameError = document.getElementById("name-length-error");
    var emailError = document.getElementById("email-error");
    var passLength = document.getElementById("pass-length");
    var passMatch = document.getElementById("pass-match");
    var passErrorLength = document.getElementById("pass-error-length");
    var passErrorMatch = document.getElementById("pass-error-match");
    var submit = document.getElementById("submit");


    //add event handlers
    addEvent(regName, 'change', function(event) {
        validateName();
    });

    addEvent(regName, 'focus', function(event) {
        validateName();
    });

    addEvent(regName, 'keydown', function(event) {
        validateName();
    });

    addEvent(regName, 'keyup', function(event) {
        validateName();
    });

    addEvent(regEmail, 'change', function(event) {
        validateEmail();
    });

    addEvent(regEmail, 'focus', function(event) {
        validateEmail();
    });

    addEvent(regEmail, 'keydown', function(event) {
        validateEmail();
    });

    addEvent(regEmail, 'keyup', function(event) {
        validateEmail();
    });

    addEvent(passLength, 'change', function(event) {
        validatePassLength();
    });

    addEvent(passLength, 'focus', function(event) {
        validatePassLength();
    });

    addEvent(passLength, 'keydown', function(event) {
        validatePassLength();
    });

    addEvent(passLength, 'keyup', function(event) {
        validatePassLength();
    });

    addEvent(passMatch, 'change', function(event) {
        validatePassMatch();
        enableSubmit();
    });

    addEvent(passMatch, 'focus', function(event) {
        validatePassMatch();
        enableSubmit();
    });

    addEvent(passMatch, 'keydown', function(event) {
        validatePassMatch();
        enableSubmit();
    });

    addEvent(passMatch, 'keyup', function(event) {
        validatePassMatch();
        enableSubmit();
    });
}