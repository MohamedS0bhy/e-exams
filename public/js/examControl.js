var examId=undefined;

function getParameterFromUrl(name) {
    var queryStr = window.location.href.split('?');

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


$(document).ready(function()
{
   var canEdit=canUserEdit();

   if(!canEdit)
   {

    $("#tokenSection").show();
    $("#examSection").hide();
       $(".buildButton").hide();
       $("#backBtn").hide();
   }
   else
   {
       
    $("#tokenSection").hide();
    $("#examSection").show();
    $(".buildButton").show();
   }

   $("#result").html("");
$("#examToken").html("");

   examId=getParameterFromUrl("examId");

   if(examId)
   {
       viewExam(examId);

       $("#generateToken").prop("disabled",false);
   }
   else
   {

    $("#generateToken").prop("disabled",true);
   }

   
   getAllSubjects();
});

var questionsRec=[];
var examInstance=null;

function viewExam(examId){

    ResetControl();
    $.ajax({
        type : 'GET' ,
        url : api_url + 'exam/find/' + examId,
        dataType : 'json'
    }).done(function(data){
        console.log('yes');
        console.log(data);

        if(data.success){


            var isEditable=canUserEdit();
           

            examInstance=data.result;

            $('#exam-name').val(data.result.exam_name);
            $('#exam-desc').val(data.result.desc);
            $("#subjCmb").val(data.result.subject_id);
            $('#duration').val(data.result.duration);
            $('#completed-exam-btn').show();
            var questionsHtml = `<div class="panel-group"><div class="panel">`;
            var counter = 0;
            var questions = shuffleArray(data.result.questions);
            for(var question of questions){
             
             //   questionsHtml += `<div class="panel-heading questionSection" id='question${++counter}'><span class='questionNumLbl'>${counter}</span> <div class='questionContent'>${isEditable ? '<input type="text" class="questionText" value="' + question.question + '"/><input type="text" placeholder="gradde" class="questionegree" id="qgrade' + counter + '" value="' + question.grade + ' grade"/>' : question.question + " <span class='questionegree'>" + question.grade + " degrees</span>"}</div><div id='questionOption${counter}'>`;
               
             
             AddQuestion(isEditable,question);

                            var choices = JSON.parse(question.choices);
                
                            var choiceCounter = 0;
                            for (var choice of choices) {

                                AddNewOption(isEditable,counter+1,choice);
                                         }

                            counter++;
                
            }
            if(!canUserEdit())
            {
                switchToViewMode();
                $("#submitBtn").show();
  
                $("#tokenSection").show();
                $("#examSection").hide();
            
            }
            else
            {

                var userId=getParameterFromUrl("userId");

                if(userId)
                {
                    switchToViewMode();
                    getUserSubmission(examId,userId);
                }
                else
                {

                    switchToBuildMode(); 
                    $("#submitBtn").hide();
    
                    $("#tokenSection").hide();
                    $("#examSection").show();
                
                }

            }
            $("#backBtn").hide();

            
        questionsRec=data.result.questions;
        }else
            alert(data.result);
    }).fail(function(){
        console.log('no');
        alert(data);
    });
}

$('button#completed-exam-btn').on('click' , function(){

    let answers = $('input[type="radio"]:checked');
    if(confirm('You\'ve answered ' + answers.length + ' submit your exam?')){

    }
    for(var t of answers){
        console.log(t.value);
    }
    // console.log($('input[type="radio"]').prop("checked" , true));
    
});

function shuffleArray(array) {
    return array.sort(() => 0.5 - Math.random());
}
function SaveSubmission(obj)
{
    let token= Math.floor(1000 + Math.random() * 9000);
    //$("#examToken").html(`Exam token is ${token}`);
obj.token=$.cookie('token');

    $.ajax({
        type : 'POST',
        url : api_url + 'exam/addAns',
        data :obj,
        dataType : 'json'
    }).done(function(data){
        console.log('success');
        if(data.success){
            
          alert("Submission is saved in the database");
        }
        else
            alert(data.result);
    }).fail(function(data){
        console.log('fail');
        console.log(data);
    });
    return token;
}


function generateToken()
{
    let token= Math.floor(1000 + Math.random() * 9000);
    //$("#examToken").html(`Exam token is ${token}`);


    $.ajax({
        type : 'POST',
        url : api_url + 'exam/addToken',
        data : {
            "id":examId,
            'examToken' : token,
            'token' : $.cookie('token')
        },
        dataType : 'json'
    }).done(function(data){
        console.log('success');
        if(data.success){
            
    window.open(`token/${token}`,"_blank");
        }
        else
            alert(data.result);
    }).fail(function(data){
        console.log('fail');
        console.log(data);
    });
    return token;
}

function canUserEdit()
{

    if(!localStorage.userRole || !$.cookie('token'))
    {
        window.location.href="login";
        return;
    }
    return localStorage.userRole!=0;
    
}

function getMinsDiff()
{
    var time=new Date(examInstance.token_creation_time).getTime();

    var current=new Date().getTime();

    var diff=(current-time)/1000/60;

    return diff;
}


function CheckExamToken()
{

//    var diff=getMinsDiff();
   
//    if(diff>180)
//    {
//        alert("Exam token exceeds two hours");
//        return;
//    }

if($("#examTokenTxt").val()==examInstance.token)
{
    $("#tokenSection").hide();
    $("#examSection").show();

    getSubmission(examId);
}
else
{
    alert("Invalid token");
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


function AddNewOption(isEditable,questionIndex,choice) {
    var lastChild = $(`#questionOption${questionIndex}`).children()[$(`#questionOption${questionIndex}`).children().length - 1];

    var lastChoiceCounter = $(lastChild).attr("id") ? $(lastChild).attr("id").split("-")[1] : 0;

    $(`#questionOption${questionIndex}`).append(`<div id='choice${questionIndex + '-' + ++lastChoiceCounter}' class='panel-body choice row'><input name='questionCh${questionIndex}' id='rd${questionIndex}${lastChoiceCounter}' value='${lastChoiceCounter}' class='choiceRad' type='radio' ${choice.correct=='1' && canUserEdit()?'checked':''}/><label class='col-xs-11 radio' for='rd${questionIndex}${lastChoiceCounter}'><textarea class='choiceTxt ${!isEditable?'withOutBorder':''} col-xs-10' type='text'>${choice.content||''}</textarea></label>
    
    '<button class="btn btn-danger buildButton col-xs-1" onclick="RemoveChoice(${questionIndex} , ${lastChoiceCounter})"><i class="fa fa-trash"></i>Remove</button>
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
            else if(index==2)
            {
                $(childEl).attr("onclick",`RemoveChoice(${questionIndex},${choiceCounter})`);
            }
        });

        choiceCounter++;
    });
}

function checkIsEditable() {
    let isEditable = getParameterFromUrl("isEditable");

    return isEditable && isEditable != "false" && isEditable != "0";
}


function AddQuestion(isEditable,question) {

    if(!isEditable)
    {
        isEditable=canUserEdit();
    }

    if(!question)
    {
        question={question:"",grade:0};
    }

    var questionCounter = $(".questionSection").length + 1;

    let questionsHtml = `<div id="question${questionCounter}" class='panel-heading questionSection'><div class='row'> <div class='questionContent'><span class='col-xs-1 questionNumLbl'>${questionCounter}</span><textarea placeholder='Insert question content' class="col-xs-10 questionText ${!isEditable?'withOutBorder':''}">${question.question}</textarea><input value="${question.grade}" class='col-xs-1 questionegree ${!isEditable?'withOutBorder':''}' type='text'/></div></div><div id='questionOption${questionCounter}'>`;

    questionsHtml += `</div><div class='row text-center'><button class="btn btn-primary buildButton" onclick="AddNewOption(${canUserEdit()},${questionCounter},{})"><i class="fa fa-plus"></i>Add Choice</button>'`;

    questionsHtml += `<button class="btn btn-danger buildButton" onclick="RemoveQuestion(${questionCounter})"><i class="fa fa-trash"></i>Remove Question</button></div>'`;
    $("#examQuestions").append(questionsHtml);
}

function getAllQuestions() {
    $(".questionSection").each(function (index, el) {
        var children = $(el).children();

        var questionContent = $(children[0]).val();

        console.log(questionContent);
    });
}



function SaveExam() {

    var questionsArr=getQuestionsArray();
    var examInstance=getExamInstance(questionsArr);
    examInstance.token= $.cookie('token');

    if(examId)
    {
       
    $.ajax({
        type : 'POST',
        url : api_url + 'exam/update',
        data :examInstance,
        dataType : 'json'
    }).done(function(data){
        console.log('success');
        if(data.success){
          SaveQuestions();
        }
        else
            alert(data.result);
    }).fail(function(data){
        console.log('fail');
        console.log(data);
    });


    }
    else
    {
        $.ajax({
            type : 'POST',
            url : api_url + 'exam/create',
            data :examInstance,
            dataType : 'json'
        }).done(function(data){
            console.log('success');
            if(data.success){

                examId=data.result.id;
                console.log(examId);
              SaveQuestions();
            }
            else
                alert(data.result);
        }).fail(function(data){
            console.log('fail');
            console.log(data);
        });
    
    }
}


function SaveQuestions()
{
   var questions=getQuestionsArray();
   
   $.ajax({
    type : 'POST',
    url : api_url + 'question/update',
    data :{questions:questions,token:$.cookie('token'),examId:examId},
    dataType : 'json'
}).done(function(data){
    console.log('success');
    if(data.success){
      alert("Exam is saved with number"+examId);
      window.location.href="login";
    }
    else
        alert(data.result);
}).fail(function(data){
    console.log('fail');
    console.log(data);
});
}


function ResetControl() {
    $("#result").html("");
    $("#examQuestions").html("");
}

var quesSubmission=[];


function getUserSubmission(examId,userId)
{

    $.ajax({
        type : 'POST' ,
        url : api_url + 'exam/getUserAns',
        dataType : 'json',
        data:{examId:examId,token:$.cookie('token'),userId:userId}
    }).done(function(data){
        
        if(data.success)
        {
  quesSubmissions =JSON.parse(data.result.answers);
       
  for(var index in questionsRec)
  {
      var value=quesSubmissions[questionsRec[index].id];

      var qinex=parseInt(index)+1;

    $(`[name='questionCh${qinex}'][value="${value}"]`).prop("checked",true);
  }

  CorrectExam(false);
        }
        else
        {
            StartTimer();
        }
    
    }).fail(function(){
        console.log('no');
        alert(data);
    });
}







function getSubmission(examId)
{
    var userId=localStorage.userId;
    $.ajax({
        type : 'POST' ,
        url : api_url + 'exam/getAns',
        dataType : 'json',
        data:{examId:examId,token:$.cookie('token')}
    }).done(function(data){
        
        if(data.success)
        {
  quesSubmissions =JSON.parse(data.result.answers);
       
  for(var index in questionsRec)
  {
      var value=quesSubmissions[questionsRec[index].id];

      var qinex=parseInt(index)+1;

    $(`[name='questionCh${qinex}'][value="${value}"]`).prop("checked",true);
  }

  CorrectExam(false);
        }
        else
        {
            StartTimer();
        }
    
    }).fail(function(){
        console.log('no');
        alert(data);
    });
}

var elapsedTime=0;

function StartTimer()
{
    elapsedTime=parseFloat(examInstance.duration)*60;

   var internval= setInterval(function()
{
    elapsedTime--;

    let mins=parseInt(elapsedTime/60);
    let seconds=elapsedTime-(mins*60);

    $("#duration").val(`${mins}:${seconds}`);

    if(elapsedTime<=0)
    {
        clearInterval(internval);
       CorrectExam(true);    
    }
},1000);
}

function CorrectExam(saveSumbit) {
     var totalDegree = 0;
var submissionObj={};

var answersObj=[];

submissionObj.examId=examId;

    var totalSum = 0;

    for (var index = 0; index < questionsRec.length; index++) {

        totalSum += questionsRec[index].grade;

        var choices = JSON.parse(questionsRec[index].choices);
        
        answersObj[questionsRec[index].id]=$(`[name='questionCh${index+1}']:checked`).val();

        for (var counter = 0; counter < choices.length; ++counter) {
            if (choices[counter].correct=="1") {
                $(`#choice${index + 1}-${counter + 1}`).addClass('correct');

                var userAnswer = $(`[name='questionCh${index+1}']:checked`).val();
          
                if (userAnswer == (counter + 1)) {
                    totalDegree += questionsRec[index].grade;
                }
            }
        }
    }
    submissionObj.grade=totalDegree;
    submissionObj.answers=JSON.stringify(answersObj);

    if(saveSumbit)
    SaveSubmission(submissionObj);

    $("#result").html(`You got ${totalDegree} out of ${totalSum}`);
$("#submitBtn").prop("disabled",true);
}


function getAllSubjects()
{
    var userId=localStorage.userId;
    $.ajax({
        type : 'GET' ,
        url : api_url + 'subject/findByDoctor/'+userId,
        dataType : 'json'
    }).done(function(data){
        var subjects=data.result;

        var html="";

        for(var subject of data.result)
        {
            html+=`<option value='${subject.id}'>${subject.subject_name}</option>`;
        }

        $("#subjCmb").html(html);
    }).fail(function(){
        console.log('no');
        alert(data);
    });
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
            choices.push({ content: $(ch).find(".choiceTxt").val(), correct: $(ch).find(".choiceRad").is(":checked") });
        }

        questions.push({
            question: $(el).find(".questionText").val(),
            choices: JSON.stringify(choices),
            grade:$(el).find(".questionegree").val().match(/\d+/).toString(),
            exam_id:examId
        });
    }

    return questions;
}


function switchToViewMode()
{
    $("input[type='text'],textarea").addClass("withOutBorder");
      
    $("input[type='text'],textarea").prop("disabled",true);
    


    $(".buildButton").hide();

    $("#backBtn").show();
}

function switchToBuildMode()
{
    $("input[type='text'],textarea").removeClass("withOutBorder");
    
    $("input[type='text'],textarea").prop("disabled",false);

    $(".buildButton").show();

    $("#backBtn").hide();
}


function getExamInstance(questions)
{
  let grade=questions.reduce((acc,el)=>acc+el.grade,0);
   return {
       id:examId,
    exam_name:$("#exam-name").val(),
    desc:$("#exam-desc").val(),
    subject_id:$("#subjCmb").val(),
    open:1,
    grade:grade,
    duration:$("#duration").val()
   };
}