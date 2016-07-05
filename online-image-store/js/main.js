function canSubmitPost(){
    function addEvent(obj, type, fn) {
      if (obj.attachEvent) {
        obj['e'+type+fn] = fn;
        obj[type+fn] = function(){obj['e'+type+fn]( window.event);}
        obj.attachEvent('on'+type, obj[type+fn]);
      } else
        obj.addEventListener(type, fn, false );
    }
    
    function validatePost(){
        if(postSubmit.value.length == 1 || postSubmit.value.length > 1){
        grabIt.disabled = false;
        }else{
        grabIt.disabled = true;
    }  
}

var grabIt = document.getElementById('submitbtn');
var postSubmit = document.getElementById('post-submit');
grabIt.disabled = true;

    addEvent(postSubmit, 'change', function(event) {
        validatePost();
    });

    addEvent(postSubmit, 'focus', function(event) {
        validatePost();
    });

    addEvent(postSubmit, 'keydown', function(event) {
        validatePost();
    });

    addEvent(postSubmit, 'keyup', function(event) {
        validatePost();
    });
}
canSubmitPost();