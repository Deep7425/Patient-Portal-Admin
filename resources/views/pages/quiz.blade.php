<html>
<head>
	<title>Health Assessment By Health Gennie</title>
	<meta name="description" content="To learn more about your well-being, participate in this health assessment here."/>
	<meta name="keywords" content="health assessment, self health assessment, health impact assessment, health needs assessment"/>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/quiz.css" type="text/css" media="all"  />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
     <link rel="shortcut icon" href="/img/favicon.ico"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700&display=swap" rel="stylesheet">

  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body class="quiz-registration" onLoad="NextQuestion(0) ">
    <main>
	<?php $qid = app("request")->input("id");
		$quizQues = getQuizQues();
	?>
	<input type="hidden" id="quiz_id" value="{{$qid}}"/>
	<input type="hidden" id="quiz_question" value="{{$quizQues}}"/>
        <!-- creating a modal for when quiz ends -->
        <div class="modal-container" id="score-modal">
          
            <div class="modal-content-container">
              
                <h1>Congratulations, Quiz Completed.</h1>
              
                <div class="grade-details">
                    <p>Attempts : 25</p>
                    <!--<p>Wrong Answers : <span id="wrong-answers"></span></p>
                    <p>Right Answers : <span id="right-answers"></span></p>
                    <p>Grade : <span id="grade-percentage"></span>%</p>
                    <p ><span id="remarks"></span></p>-->
                </div>
                <div class="modal-button-container">
                    <button onClick="closeScoreModal()">Continue</button>
                </div>
            </div>
        </div>

        <div class="game-quiz-container">
          
            <div class="game-details-container">
                <!--<h1>Score : <span id="player-score"></span> / 10</h1>-->
                <h1> Item : <span id="question-number"></span> / 25</h1>
            </div>

            <div class="game-question-container">
                <h1 id="display-question"></h1>
                <span id="display-question-hindi" class="hindi-question"></span>
            </div>

            <div class="game-options-container">
              
               <div class="modal-container" id="option-modal">
                 
                    <div class="modal-content-container">
                         <h1>Please Pick An Option</h1>
                      
                         <div class="modal-button-container">
                            <button onClick="closeOptionModal()">Continue</button>
                        </div>
                      
                    </div>
                 
               </div>
              
                <span>
                    <input type="radio" id="option-one" name="option" class="radio" value="optionA" />
                    <label for="option-one" class="option" id="option-one-label"></label>
                   
                </span>
              

                <span>
                    <input type="radio" id="option-two" name="option" class="radio" value="optionB" />
                    <label for="option-two" class="option" id="option-two-label"></label>
                    
                </span>
              

                <span>
                    <input type="radio" id="option-three" name="option" class="radio" value="optionC" />
                    <label for="option-three" class="option" id="option-three-label"></label>
                    
                </span>
              

                <span>
                    <input type="radio" id="option-four" name="option" class="radio" value="optionD" />
                    <label for="option-four" class="option" id="option-four-label"></label>
                    
                </span>


            </div>

            <div class="next-button-container">
                <button onClick="handleNextQuestion()" id="next_ques">Next</button>
            </div>

        </div>
    </main>
	
	<!-- Modal -->
<div class="modal fade student-detail" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <div class="modal-body">
         <h2>Let's get to know more about yourself with a<span> few interesting items.</span></h2>
         <ul>
         	<li>Choose the option that describes you honestly for a better understanding of yourself. </li>
            <li>You can choose your desired response without putting any judgement on yourselves.</li>
            <li>We will keep your responses confidential. </li>
            <li>There is no right or wrong answers.</li>
            <li>You can take as much time as you want to go through each statement and tick against the option that fits you well.</li>
         </ul>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          Let's Begin
        </button>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function(){
$("#exampleModal").modal("show");
// slight update to account for browsers not supporting e.which
function disableF5(e) { if ((e.which || e.keyCode) == 116) console.log(e.keyCode+'---'+e.which); e.preventDefault(); };
// To disable f5
    /* jQuery < 1.7 */
$(document).bind("keydown", disableF5);
/* OR jQuery >= 1.7 */
$(document).on("keydown", disableF5);
// To re-enable f5
    /* jQuery < 1.7 */
$(document).unbind("keydown", disableF5);
/* OR jQuery >= 1.7 */
$(document).off("keydown", disableF5);
});

let answerObject = [];	
const questions = JSON.parse($("#quiz_question").val());
console.log(questions);

let shuffledQuestions = questions; //empty array to hold shuffled selected questions
/*function handleQuestions() { 
    //function to shuffle and push 10 questions to shuffledQuestions array
    while (shuffledQuestions.length <= 24) {
        const random = questions[Math.floor(Math.random() * questions.length)]
        if (!shuffledQuestions.includes(random)) {
            shuffledQuestions.push(random)
        }
    }
}
*/

let questionNumber = 1
let playerScore = 0  
let wrongAttempt = 0 
let indexNumber = 0

// function for displaying next question in the array to dom
function NextQuestion(index) {
	console.log(questionNumber);
    // handleQuestions()
    const currentQuestion = shuffledQuestions[index]
    document.getElementById("question-number").innerHTML = questionNumber;
    // document.getElementById("player-score").innerHTML = playerScore;
    document.getElementById("display-question").innerHTML = currentQuestion.question;
    document.getElementById("display-question-hindi").innerHTML = currentQuestion.question_hindi;
    document.getElementById("option-one-label").innerHTML = currentQuestion.optionA;
    document.getElementById("option-two-label").innerHTML = currentQuestion.optionB;
    document.getElementById("option-three-label").innerHTML = currentQuestion.optionC;
    document.getElementById("option-four-label").innerHTML = currentQuestion.optionD;
	
	// document.getElementById("option-one-label-hindi").innerHTML = currentQuestion.optionHA;
    // document.getElementById("option-two-label-hindi").innerHTML = currentQuestion.optionHB;
    // document.getElementById("option-three-label-hindi").innerHTML = currentQuestion.optionHC;
    // document.getElementById("option-four-label-hindi").innerHTML = currentQuestion.optionHD;

}

function checkForAnswer() {
    const currentQuestion = shuffledQuestions[indexNumber] //gets current Question 
    const currentQuestionAnswer = currentQuestion.correctOption //gets current Question's answer
    const options = document.getElementsByName("option"); //gets all elements in dom with name of 'option' (in this the radio inputs)
    let correctOption = null
	console.log(currentQuestionAnswer);
    options.forEach((option) => {
        if (option.value === currentQuestionAnswer) {
            //get's correct's radio input with correct answer
            correctOption = option.labels[0].id
        }
    })
   
    //checking to make sure a radio input has been checked or an option being chosen
    if (options[0].checked === false && options[1].checked === false && options[2].checked === false && options[3].checked == false) {
        document.getElementById('option-modal').style.display = "flex"
    }
	let choosedAns = '';
    //checking if checked radio button is same as answer
    options.forEach((option) => {
        if (option.checked === true && option.value === currentQuestionAnswer) { 
			choosedAns = option.value;
            // document.getElementById(correctOption).style.backgroundColor = "green"
            playerScore++
            indexNumber++
            //set to delay question number till when next question loads
            setTimeout(() => {
                questionNumber++
            }, 200)
        }

        else if (option.checked && option.value !== currentQuestionAnswer) {
            const wrongLabelId = option.labels[0].id
			choosedAns = option.value;
            // document.getElementById(wrongLabelId).style.backgroundColor = "red"
            // document.getElementById(correctOption).style.backgroundColor = "green"
            wrongAttempt++
            indexNumber++
            //set to delay question number till when next question loads
            setTimeout(() => {
                questionNumber++
            }, 200)
        }
    })
	if (options[0].checked === true || options[1].checked === true || options[2].checked === true || options[3].checked == true) {
        // console.log(questionNumber+"___ddd");
		answerObject.push({'ques':indexNumber,'ans':choosedAns});
		console.log(answerObject);
    }	
}


//called when the next button is called
function handleNextQuestion() {
    checkForAnswer()
    unCheckRadioButtons()
    //delays next question displaying for a second
	if(indexNumber == 24) {
		document.getElementById("next_ques").innerHTML = 'Submit';
	}
    setTimeout(() => {
        if (indexNumber <= 24) {
            NextQuestion(indexNumber)
        }
        else {
            handleEndGame()
        }
        resetOptionBackground()
    }, 300);
}

//sets options background back to null after display the right/wrong colors
function resetOptionBackground() {
    const options = document.getElementsByName("option");
    options.forEach((option) => {
        document.getElementById(option.labels[0].id).style.backgroundColor = ""
    })
}

// unchecking all radio buttons for next question(can be done with map or foreach loop also)
function unCheckRadioButtons() {
    const options = document.getElementsByName("option");
    for (let i = 0; i < options.length; i++) {
        options[i].checked = false;
    }
}

// function for when all questions being answered
function handleEndGame() {
	submitForm();
    let remark = null
    let remarkColor = null

    // condition check for player remark and remark color
    if (playerScore <= 3) {
        remark = "Bad Grades, Keep Practicing."
        remarkColor = "red"
    }
    else if (playerScore >= 4 && playerScore < 7) {
        remark = "Average Grades, You can do better."
        remarkColor = "orange"
    }
    else if (playerScore >= 7) {
        remark = "Excellent, Keep the good work going."
        remarkColor = "green"
    }
    const playerGrade = (playerScore / 10) * 100

    //data to display to score board
    /*document.getElementById('remarks').innerHTML = remark
    document.getElementById('remarks').style.color = remarkColor
    document.getElementById('grade-percentage').innerHTML = playerGrade
    document.getElementById('wrong-answers').innerHTML = wrongAttempt
    document.getElementById('right-answers').innerHTML = playerScore
    document.getElementById('score-modal').style.display = "flex"*/
	
}

//closes score modal and resets game
function closeScoreModal() {
    questionNumber = 1
    playerScore = 0
    wrongAttempt = 0
    indexNumber = 0
    shuffledQuestions = []
    NextQuestion(indexNumber)
    document.getElementById('score-modal').style.display = "none"
}

//function to close warning modal
function closeOptionModal() {
    document.getElementById('option-modal').style.display = "none"
}

function submitForm() {
	answerObject = JSON.stringify(answerObject);
	console.log(answerObject);
	var quiz_id = $("#quiz_id").val();
	jQuery.ajax({
		url: "{!! route('quiz') !!}",
		type : "POST",
		dataType : "JSON",
		data:{"_token": "{{ csrf_token() }}",'answerObject':answerObject,'quiz_id':quiz_id},
		success: function(result) {
		if(result == 1) {
			window.location = 'https://www.healthgennie.com/mental/success';
		}
		else {
			alert("Oops Something Problem");
		}
	  },
	  error: function(error){
			if(error.status == 401 || error.status == 419){
				//alert("Session Expired,Please logged in..");
				// location.reload();
			}
			else{
				//alert("Oops Something goes Wrong.");
			}
		}
	});
}
</script>
</body>
</html>