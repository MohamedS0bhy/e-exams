function getExamInstance(examId) {
    return {
        name: "Physics exam",
        token: "123"

    }
}



function getQuestions(examId) {
    return [
        {
            question: "what is the sum of 1+1?",
            choices: `[
                {
                    "content":"6","IsCorrect":1
                },
                {
                  "content":"2","IsCorrect":0
                }
          ]`,
            grade: 2
        },
        {

            question: "what is the sum of 1+5?",
            choices: `[
            {
                "content":"6","IsCorrect":1
            },
            {
              "content":"2","IsCorrect":0
            }
        ]`,

            grade: 1
        },
        {

            question: "what is the sum of 1+2?",
            choices: `[
                {
                    "content":"6","IsCorrect":0
                },
                {
                  "content":"2","IsCorrect":1
                }
        ]`,

            grade: 1
        }
    ]
}


function getParameterFromUrl(name) {
    var queryStr = window.location.href.split('?');
    console.log('queryStr -> ' + queryStr[0]);

    if (queryStr.length == 2) {
        var queryStrSubs = queryStr[1].split('&&');

        for (var element of queryStrSubs) {
            var subs = element.split('=');

            if (subs[0] == name && subs[1]) {
                return subs[1];
            }
        }
    }

    return undefined;
}




function Main() {
    var examId = getParameterFromUrl("examId");
    console.log('examid -> ' + examId);
    var isEditable = checkIsEditable();
console.log('editable -> ' + isEditable);
    if (isEditable) {
        $(".buildButton").show();
        $("#submitBtn").hide();
            }
    else {

        $("#submitBtn").show();
        $(".buildButton").hide();
    }

    if (examId) {
        var exam = getExamInstance(examId);
        var questions = getQuestions(examId);

        $("#examTitle").html(exam.name);


        var questionsHtml = "";

        var counter = 0;

        for (var question of questions) {
            questionsHtml += `<div id='question${++counter}' class='questionSection'>
            <span class='questionNumLbl'>${counter}</span> 
            <div class='questionContent'>${isEditable ? 
                '<input type="text" class="questionText" value="' + question.question 
                + '"/><input type="text" placeholder="gradde" class="questionegree" id="qgrade' 
                + counter + '" value="' + question.grade + ' grade"/>' : question.question 
                + " <span class='questionegree'>" + question.grade + " degrees</span>"}
                </div>
                <div id='questionOption${counter}'>`;

            var choices = JSON.parse(question.choices);

            var choiceCounter = 0;
            for (var choice of choices) {
                questionsHtml += `<div class='choice' id='choice${counter + '-' + ++choiceCounter}'>
                <input type='radio' name='questionCh${counter}' value='${choiceCounter}' class='choiceRad'/>
                ${isEditable ? '<input type="text" class="choiceTxt" value="' + choice.content + '"></input>' : choice.content}`

                questionsHtml += `${isEditable ? '<button class="buildButton" onclick="RemoveChoice(' + counter + ',' + choiceCounter + ')">Remove</button></div>' : '</div>'}`;
            }

            questionsHtml += `</div>${isEditable ? '<button class="buildButton" onclick="AddNewOption(' + counter + ')">Add Choice</button><button class="buildButton" onclick="RemoveQuestion(' + counter + ')">Remove Question</button></div>' : '</div>'}`;


        }

        $("#examQuestions").html(questionsHtml);
    }
}



function RemoveQuestion(index) {
    $(`#question${index}`).remove();

    $(".questionSection").each(function (index, el) {

        console.log($(el).attr("id"));
        $(el).attr("id", `question${index + 1}`);


        $(el).find("span").html(index + 1);
    });
}


function AddNewOption(questionIndex) {
    var lastChild = $(`#questionOption${questionIndex}`).children()[$(`#questionOption${questionIndex}`).children().length - 1];

    var lastChoiceCounter = $(lastChild).attr("id") ? $(lastChild).attr("id").split("-")[1] : 1;

    $(`#questionOption${questionIndex}`).append(`<div id='choice${questionIndex + '-' + ++lastChoiceCounter}' class='choice'><input name='questionCh${questionIndex}' value='${lastChoiceCounter}' class='choiceRad' type='radio'><input class='choiceTxt' type='text'></input>
    
    '<button class="buildButton" onclick="RemoveChoice(${questionIndex} , ${lastChoiceCounter})">Remove</button>
    </div>`);
}

function RemoveChoice(questionIndex, optionIndex) {
    $(`#choice${questionIndex + '-' + optionIndex}`).remove();

    var choiceCounter = 1;

    $(`#questionOption${questionIndex}`).children().each(function (index, el) {

        $(el).attr("id", `choice${questionIndex}-${choiceCounter}`);

        $(el).children().each(function (index, childEl) {

            if (index == 0) {
                $(childEl).attr("value", choiceCounter);
            }
        });

        choiceCounter++;
    });
}

function checkIsEditable() {
    let isEditable = getParameterFromUrl("isEditable");
    

    return isEditable && isEditable != "false" && isEditable != "0";
}


function AddQuestion() {

    var questionCounter = $(".questionSection").length + 1;

    let questionsHtml = `<div id="question${questionCounter}" class='questionSection'> <div class='questionContent'><span class='questionNumLbl'>${questionCounter}</span><input type='text' class="questionText"/><input class='questionegree' type='text'/></div><div id='questionOption${questionCounter}'>`;

    questionsHtml += `</div><button class="buildButton" onclick="AddNewOption(${questionCounter})">Add Choice</button>'`;

    questionsHtml += `</div><button class="buildButton" onclick="RemoveQuestion(${questionCounter})">Remove Question</button>'`;
    $("#examQuestions").append(questionsHtml);
}

function getAllQuestions() {
    $(".questionSection").each(function (index, el) {
        var children = $(el).children();

        var questionContent = $(children[0]).val();

        console.log(questionContent);
    });
}

$(document).ready(function () {
    ResetControl();
    Main();
});



function SaveExam() {

    var questionsArr=getQuestionsArray();
}

function GetExamInstance() {

}

function ResetControl() {
    $("#result").html("");
    $("#examQuestions").html("");
}


function CorrectExam() {
    var questions = getQuestions();

    var totalDegree = 0;

    var totalSum = 0;

    for (var index = 0; index < questions.length; index++) {

        totalSum += questions[index].grade;

        var choices = JSON.parse(questions[index].choices);

        for (var counter = 0; counter < choices.length; ++counter) {
            if (choices[counter].IsCorrect) {
                $(`#choice${index + 1}-${counter + 1}`).addClass('correct');

                var userAnswer = $(`[name='questionCh${index}']:checked`).val();

                if (userAnswer == (counter + 1)) {
                    totalDegree += questions[index].grade;
                }
            }
        }
    }


    $("#result").html(`You got ${totalDegree} out of ${totalSum}`);

}


function getQuestionsArray() {

    var questions = [];

    var children = $(".questionSection");

    for (var counter = 0; counter < children.length; counter++) {
        var el = children[counter];

        var choices = [];

        var choicesDom = $(el).find(".choice");

        for (var chCounter = 0; chCounter < choicesDom.length; chCounter++) {
            var ch = choicesDom[chCounter];
            choices.push({ content: $(ch).find(".choiceTxt").val(), IsCorrect: $(ch).find(".choiceRad").is(":checked") });
        }

        questions.push({
            content: $(el).find(".questionText").val(),
            choices: JSON.stringify(choices),
            grade:$(el).find(".questionegree").val().match(/\d+/).toString()
        });
    }

    return questions;
}


function switchToViewMode()
{
    $("input[type='text']").addClass("withOutBorder");
    
    $("input[type='text']").prop("disabled");

    $(".buildButton").hide();

    $("#backBtn").show();
}

function switchToBuildMode()
{
    $("input[type='text']").removeClass("withOutBorder");
    
    $("input[type='text']").prop("disabled",false);

    $(".buildButton").show();

    $("#backBtn").hide();
}
