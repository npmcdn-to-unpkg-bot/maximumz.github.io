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