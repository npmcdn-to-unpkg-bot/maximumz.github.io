//play the fight sound at the start
var fight = new Audio('./media/fight.mp3');
fight.play();

//Ken's actions & classes applied when buttons are clicked using jQuery

var $ken = $('.ken');
var $kenPos, $fireballPos;

var hadoken = function () {
    $ken.addClass('hadoken');
    setTimeout(function () {
        $ken.removeClass('hadoken');
    }, 500);
    setTimeout(function () {
        var $fireball = $('<div/>', {
            class: 'fireball'
        });
        $fireball.appendTo($ken);

        var isFireballColision = function () {
            return $fireballPos.left + 75 > $(window).width() ? true : false;
        };

        var explodeIfColision = setInterval(function () {

            $fireballPos = $fireball.offset();

            if (isFireballColision()) {
                $fireball.addClass('explode').removeClass('moving').css('marginLeft', '+=22px');
                clearInterval(explodeIfColision);
                setTimeout(function () {
                    $fireball.remove();
                }, 500);
            }

        }, 50);

        setTimeout(function () {
            $fireball.addClass('moving');
        }, 20);

        setTimeout(function () {
            $fireball.remove();
            clearInterval(explodeIfColision);
        }, 3020);

    }, (250));
};

//declare the properties for Quiz constructor object

function Quiz(questions) {
    //questions
    this.questions = questions;
    //indexOf
    this.indexOfCurrentQuestion = 0;
    //score
    this.score = 0;
    //wrong answers
    this.wrong = 0;
}

// will return the current question form questions array
Quiz.prototype.getCurrentQuestion = function () {
    var currentQuestion = this.questions[this.indexOfCurrentQuestion];
    return currentQuestion;
};

// if the user's answer for the current question is correct then this.score++, and after currentQuestionIndex++;
Quiz.prototype.guessIsCorrect = function (userAnswer) {
    if (this.getCurrentQuestion().isCorrectAnswer(userAnswer)) {
        this.score++;
    } else {
        this.wrong++;
    }
    this.indexOfCurrentQuestion++;
};

//will return if currentQuestionIndex is bigger or equal to size of questions array
Quiz.prototype.hasEnded = function () {
    return this.indexOfCurrentQuestion >= this.questions.length;
};

// set the counter for the continue or game over, if game over hide the continue option
function countDown() {
    var counter = 15;
    var interval = setInterval(function () {
        counter--;
        if (counter == 0) {
            document.getElementById('continue').className = "hidden";
        }
    }, 1000);
};

//declare properties of text, choices and answer for question constructor object (don't forget this keyword, it's a constructor object)
function Question(text, choices, answer) {
    //text
    this.text = text;
    //choices
    this.choices = choices;
    //answer
    this.answer = answer;
}

//will return if user's choice is === to answer
Question.prototype.isCorrectAnswer = function (guess) {
    return this.answer === guess;
};

//If the quiz has ended then display score otherwise display question, display choices and display progress
var QuizUI = {
    displayNext: function () {
        if (quiz.hasEnded()) {
            this.displayScore();
            countDown();
        } else {
            this.displayQuestion();
            this.displayChoices();
            this.displayProgress();
            this.progressBar();
            this.showCurrentScore();
        }

    },
    //Show the question above the multi choice
    displayQuestion: function () {
        // call insertTextInHTML method
        this.insertTextInHTML('question', quiz.getCurrentQuestion().text);
    },


    //Populate the multi choice
    displayChoices: function () {
        //get the choices of current question
        var choices = quiz.getCurrentQuestion().choices;

        for (var i = 0; i < choices.length; i++) {
            this.insertTextInHTML("guess" + i, choices[i]);
            this.guessHandler("guess" + i, choices[i]);
            document.getElementById("guess" + [i]).className = "btn";
        }

    },

    //Once the quiz is finished display results
    displayScore: function () {
        //Change the body background to black
        document.body.className = "black";
        //Give the option to continue for another chance, if not "Game Over"
        var gameOverHTML = '<h2 id="continue"><a class="animated infinite flash" href="quiz.html">Continue?</a></h2>';
        gameOverHTML += '<h2 class="your-score">Yor Score is: ' + quiz.score + '</h2>';
        this.insertTextInHTML('quiz', gameOverHTML);
        //Create variables for the audio tracks
        var win = new Audio('./media/You Win Perfect.mp3');
        var loose = new Audio('./media/You Loose.mp3');
        //If the score is 10 out of 10, play the winning audio & display the winning image
        if (quiz.score === 10) {
            win.play();
            var image = new Image;
            image.src = "./img/winner.png";
            document.body.appendChild(image);
            document.getElementById('continue').className = "hidden";
        } else {
            //If the user scores less then 10 out of 10 play the loser audio & the video
            loose.play();

            function addSourceToVideo(element, src, type) {
                var source = document.createElement('source');

                source.src = src;
                source.type = type;

                element.appendChild(source);
            }

            var video = document.createElement('video');

            document.body.appendChild(video);

            addSourceToVideo(video, './media/looser.mp4', 'video/mp4');

            video.play();
        }
    },

    //Insert the text into the HTML element
    insertTextInHTML: function (id, text) {
        var element = document.getElementById(id);
        element.innerHTML = text;
    },

    //Collect what answer the user selected & play the Hadoken sound
    guessHandler: function (id, guess) {
        var hadokenSound = new Audio('./media/Hadoken.mp3');
        var button = document.getElementById(id);
        button.onclick = function () {
            quiz.guessIsCorrect(guess);
            QuizUI.displayNext();
            hadoken();
            hadokenSound.play();
        }
    },

    //Display the progress to the user i.e Question 2 of 10
    displayProgress: function () {
        var currentQuestionNumber = quiz.indexOfCurrentQuestion + 1;
        // get the index number of current question
        //call insertTextInHTML method
        this.insertTextInHTML('progress', 'Question ' + currentQuestionNumber + ' of ' + questions.length);
    },

    //Increase the progress bar after each choice
    progressBar: function () {
        var percent = quiz.indexOfCurrentQuestion;
        document.getElementById("progress-bar").style.width = percent + "0%";
    },

    //Display how many the user has right & wrong during the quiz
    showCurrentScore: function () {
        if (quiz.score === 0 && quiz.wrong === 0) {
            document.getElementById("score").innerHTML = "You can do it!";
            document.getElementById("wrong").innerHTML = "Don't loose!";
        } else {
            document.getElementById("score").innerHTML = "You've got " + quiz.score + " right so far!";
            document.getElementById("wrong").innerHTML = "You've got " + quiz.wrong + " wrong so far!";
        }
    }

};

//The questions & answers of the quiz
var questions = [
    new Question('What does CSS stand for?', ['Cascading CSS', 'Cascading style sheets', 'Cascading separate style'], 'Cascading style sheets'),
    new Question('Which attribute can set text to bold?', ['Text-decoration', 'Font style', 'Font weight'], 'Font weight'),
    new Question('Which tag is used to link an external CSS file?', ['Script', 'Link', 'Rel'], 'Link'),
    new Question('Which attribute sets the underline property?', ['Font style', 'Text-decoration', 'Font weight'], 'Text-decoration'),
    new Question('Which measurement is NOT relative?', ['Px', 'Cm', '%', 'Em'], 'Cm'),
    new Question('Which measurement unit IS relative?', ['Em', 'Cm', 'MM', 'Inch'], 'Em'),
    new Question('What attribute is used move an elements content away from its border?', ['Margin', 'Padding', 'Border', 'Width'], 'Padding'),
    new Question('Which attribute does not contribute to a block elements total width?', ['Width', 'Border', 'Background-image', 'Padding'], 'Background-image'),
    new Question('What property changes positioned elements display order?', ['Width', 'Background', 'Z-index', 'Azimuth'], 'Z-index'),
    new Question('Which value of background-repeat will cause a background to repeat vertically?', ['Repeat-x', 'Repeat', 'Repeat-y', 'No-repeat'], 'Repeat-y'),
];

//Quiz instance
var quiz = new Quiz(questions);

//Display the quiz
QuizUI.displayNext();