//if the quiz has ended then display score otherwise display question, display choices and display progress
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

    displayQuestion: function () {
        // call insertTextInHTML method
        this.insertTextInHTML('question', quiz.getCurrentQuestion().text);
    },

    displayChoices: function () {
        //get the choices of current question
        var choices = quiz.getCurrentQuestion().choices;

        for (var i = 0; i < choices.length; i++) {
            this.insertTextInHTML("guess" + i, choices[i]);
            this.guessHandler("guess" + i, choices[i]);
            document.getElementById("guess"+[i]).className="btn";
        }
        
    },

    // display <h1>game Over</h1> , <h2>your score is: quiz.score</h2>
    // call insertTextInHTML method. and pass "quiz and gameOverHTML";
    displayScore: function () {
        document.body.className = "black";
        var gameOverHTML = '<h2 id="continue"><a class="animated infinite flash" href="index.html">Continue?</a></h2>';
        gameOverHTML += '<h2 class="your-score">Yor Score is: ' + quiz.score + '</h2>';
        this.insertTextInHTML('quiz', gameOverHTML);
        var win = new Audio('./media/You Win Perfect.mp3');
        var loose = new Audio('./media/You Loose.mp3');
        if (quiz.score === 10) {
            win.play();
            var image = new Image;
            image.src = "./img/winner.png";
            document.body.appendChild(image);
            document.getElementById('continue').className = "hidden";
        } else {
            loose.play();
            //Add the video
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


    insertTextInHTML: function (id, text) {
        var element = document.getElementById(id);
        element.innerHTML = text;
    },

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

    displayProgress: function () {
        var currentQuestionNumber = quiz.indexOfCurrentQuestion + 1;
        // get the index number of current question
        //call insertTextInHTML method
        this.insertTextInHTML('progress', 'Question ' + currentQuestionNumber + ' of ' + questions.length);
    },

    progressBar: function () {
        var percent = quiz.indexOfCurrentQuestion;
        document.getElementById("progress-bar").style.width = percent + "0%";
    },

    showCurrentScore: function () {
        if (quiz.score === 0 && quiz.wrong ===0) {
            document.getElementById("score").innerHTML = "You can do it!";
            document.getElementById("wrong").innerHTML = "Don't loose!";
        } else {
            document.getElementById("score").innerHTML = "You've got " + quiz.score + " right so far!";
            document.getElementById("wrong").innerHTML = "You've got " + quiz.wrong + " wrong so far!";
        }
    }

};