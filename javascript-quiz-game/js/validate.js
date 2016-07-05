// hide all the hints
$('span').hide();
//validate password
$name = $('#name');
$email = $('#email');

//load & play background music
var intro = new Audio('./media/intro.mp3');
intro.play();

function validateName() {
    if ($name.val().length >= 4) {
        $name.next().hide();
        return true;
    } else {
        $name.next().show();
        return false;
    }
}
// Function that validates email address through a regular expression.
function validateEmail() {
    var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
    if (filter.test($email.val())) {
        $email.next().hide();
        return true;
    } else {
        $email.next().show();
        return false;
    }
}


function canSubmit() {
    if (validateName() && validateEmail()) {
        return true;
    } else {
        return false;
    }
}

function enableSubmitButton() {
    $('#submit').prop('disabled', !canSubmit());
}

//add events to name & email

$email.focus(validateEmail).keyup(validateEmail).keyup(enableSubmitButton).change(validateEmail).change(enableSubmitButton);
$name.focus(validateName).keyup(validateName).keyup(enableSubmitButton).change(validateName).change(enableSubmitButton);
enableSubmitButton();