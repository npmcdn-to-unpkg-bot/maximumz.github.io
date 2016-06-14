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