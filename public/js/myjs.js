// $(this).val() == this.value
// 
let url = '/'; //will store base url
let api_url = 'https://examsvc.herokuapp.com/api/';//will store api url 
if(location.hostname == 'localhost'){
    url = '/examsvc/public/';
   api_url = 'http://127.0.0.1:8000/api/';
}

// will get data from login form and send request to check data
// and return with token if success
// and redirect to proper page based on user role
$("button#loginForm").click(function(){
    var email = $('input[name=email]').val();
    var password = $('input[name=password]').val();

    $.ajax({
        type : 'POST',
        url : api_url + 'login',
        data : {
            'email' : email,
            'password' : password
        },
        dataType : 'json'
    }).done(function(data){
        console.log('success');
        if(data.success){
            console.log(data.result.token);
            $.cookie("token", data.result.token, {expires: 1, path: '/'});

            localStorage.userRole=data.result.user.role;
            localStorage.userId=data.result.user.id;
            window.location = url + 'login';
        }
        else
            alert(data.result);
    }).fail(function(data){
        console.log('fail');
        console.log(data);
    });
    
});

// will get data from register form and send request to check data
// and return with token if success
// and redirect to proper page based on user role
$("button#registerForm").click(function(){
    let x = $('form#registerForm').serializeArray().reduce(function(obj, item) {
        obj[item.name] = item.value;
        return obj;
    }, {});

    if(x.password != x.confirmPass)
        alert('password doesn\'t match ');
    else{
        $.ajax({
            type : 'POST',
            url : api_url + 'register',
            data : {
                'username' : x.username,
                'email' : x.email,
                'password' : x.password,
                'phone_number' : x.phone_number,
                'date_of_birth' : x.date_of_birth
            },
            dataType : 'json'
        }).done(function(data){
            console.log('success');
            console.log(data);
            if(data.success){

                alert("User registered");
                
                console.log(data.result.token);
                // $.cookie("token", data.result.token, {expires: 1, path: '/'});
                // window.location = url + 'login';
            }
            else
                console.log(data.message);
        }).fail(function(data){
            console.log('fail');
            console.log(data);
        });
        
    }
});

// logout function will send request with token 
// and make token invalid in return
// and redirect to login page
function logout(){
    $.ajax({
        type : 'POST',
        url : api_url + 'logout',
        data : {
            'token' : $.cookie('token')
        },
        dataType : 'json'
    }).done(function(data){
        console.log('success');
        if(data.success){
            console.log(data.result);
            $.removeCookie('token', { path: '/' });
            window.location = url + 'login';
        }
        
    }).fail(function(data){
        console.log('fail');
        console.log(data);
    });
}

//there is rolemiddleware do the same job
function privilege(){
    if(typeof($.cookie('token')) != "undefined" && $.cookie('token') !== null){

        $.ajax({
            type : 'GET',
            url : api_url + 'user',
            data : {
                'token' : $.cookie('token')
            },
            dataType : 'json'
        }).done(function(data){
            console.log('success');
            if(data.user.role == '0'){
                window.location = url + 'usr/st';
            }else if(data.user.role == '1'){
                window.location = url + 'usr/dc';
            }else{
                window.location = url + 'usr/ad';
            }
            
        }).fail(function(data){
            console.log('fail');
            window.location = url + 'login';
        });

    }else{
        window.location = url + 'login';
    }
}


//update user basic data
function updData(){
    
    let x = $('form#updData').serializeArray().reduce(function(obj, item) {
        obj[item.name] = item.value;
        return obj;
    }, {});
    console.log(x);
    $.ajax({
        type:'POST',
        url : api_url + 'updateUser',
        data : { 
            'token' : $.cookie('token'),
            'username' : x.username, 
            'phone_number' : x.phone_number, 
            'date_of_birth' : x.date_of_birth
        },
        dataType : 'json'
    }).done(function(data){
        console.log('success');
        console.log(data);
        if(data.success)
            location.reload();
        else
            alert(data.message);
    }).fail(function(data){
        console.log('fail');
        console.log(data);
    });
}

$('input#confirmPass').keyup(function(){
    
    if($(this).val() != $('input#newPass').val()){
        $('small#passwordHelpInline').show();
        $('button#updButton').hide();
    }
    
    if($(this).val() == $('input#newPass').val()){
        $('small#passwordHelpInline').hide();
        $('button#updButton').show();
    }


});

//update user password
function updPass(){

    let x = $('form#updPass').serializeArray().reduce(function(obj, item) {
        obj[item.name] = item.value;
        return obj;
    }, {});
console.log(x);
    if(!(x.currentPass == '' || x.newPass =='')){
    
        $.ajax({
            type:'POST',
            url : api_url + 'updateUser',
            data : { 
                'token' : $.cookie('token'),
                'oldPass' : x.currentPass, 
                'password' : x.newPass, 
            },
            dataType : 'json'
        }).done(function(data){
            console.log('success');
            console.log(data);
            if(data.success)
            location.reload();
        else
            alert(data.message);

        }).fail(function(data){
            console.log('fail');
            console.log(data);
        });
    }
}

function viewExam(examId){
    $.ajax({
        type : 'GET' ,
        url : api_url + 'exam/find/' + examId,
        dataType : 'json'
    }).done(function(data){
        console.log('yes');
        console.log(data);
        
        if(data.success){
            $('#exam-name').text(data.result.exam_name);
            $('#exam-desc').text(data.result.desc);
            $('#duration').html('duration : <strong>' + data.result.duration + '</strong>' );
            $('#completed-exam-btn').show();
            var questionsHtml = `<div class="panel-group"><div class="panel panel-default">`;
            var counter = 0;
            var questions = shuffleArray(data.result.questions);
            for(var question of questions){
                questionsHtml += `<div class="panel-heading" id='question${++counter}'>${counter} - ${question.question}   (${question.grade})</div>`;
                console.log(question.choices);
                var choices = shuffleArray(JSON.parse(question.choices));

                var choiceCounter = 0;
                for (var choice of choices){
                    questionsHtml += `<div class="panel-body" id='choice${counter}'>`;
                    questionsHtml += `<input type='radio' name='questionCh${counter}' value='${choice.content}'/> ${choice.content}<br>`;
                    questionsHtml += `</div>`;
                }
                

                
            }

            questionsHtml += `</div></div>`;
            $('section#examView').html(questionsHtml);
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

    // console.log($('input[type="radio"]:not(:checked)'));
    // console.log(answers);
    // console.log(answers[0]);
    // console.log(answers[0].value);
    for(var t of answers){
        console.log(t.value);
    }
    // console.log($('input[type="radio"]').prop("checked" , true));
    
});

function shuffleArray(array) {
    return array.sort(() => 0.5 - Math.random());
}

function stIndex(){

    $.ajax({
        type : 'POST',
        url : api_url + 'subject/get/enrolled',
        data : {
            'token' : $.cookie('token'),
        }
    }).done(function(data){
        console.log('done');
        var subHtml= '<table class="table table-striped"><thead><tr><th>subject name</th><th>description</th><th>exams</th></tr></thead><tbody>';
        for(var sub of data.result){
            subHtml+= '<tr><td>'+sub.subject_name+'</td><td>'+sub.desc+'</td><td><a href="'+url+'subject/exams/'+sub.id+'" > exams</a></td>';
        }
        subHtml+= '</tbody></table>';
        $('section.content').html(subHtml);

    }).fail(function(data){
        console.log(data);
    });

}

function stSubExams(id){

    $.ajax({
        type : 'GET',
        url : api_url + 'subject/get/exams/'+id,
        data : {}
    }).done(function(data){
        console.log('done');
        var subHtml= '<table class="table table-striped"><thead><tr><th>exam name</th><th>description</th><th>exams</th></tr></thead><tbody>';

        for(var exam of data.result){
            var link = (exam.open == '1')? '<a href="'+url+'exam?examId='+exam.id+'" >exam page</a>': 'exam page' ;
            subHtml+= '<tr><td>'+exam.exam_name+'</td><td>'+exam.desc+'</td><td>'+link+'</td>';
        }
        subHtml+= '</tbody></table>';
        $('section.content').html(subHtml); 

    }).fail(function(data){
        console.log(data);
    });

}

function dcSubExams(id){

    $.ajax({
        type : 'GET',
        url : api_url + 'subject/get/exams/'+id,
        data : {}
    }).done(function(data){
        console.log('done');
        var subHtml = '<a class="btn btn-primary" id="newExam" href="'+url+'exam">create new exam</a><br>';
        subHtml+= '<table class="table table-striped"><thead><tr><th>exam name</th><th>description</th><th>submissions</th><th>exams</th></tr></thead><tbody>';

        for(var exam of data.result){
            var link = (exam.open == '1')? '<a href="'+url+'exam?examId='+exam.id+'" >exam page</a>': 'exam page' ;
            subHtml+= '<tr><td>'+exam.exam_name+'</td><td>'+exam.desc+'</td><td><a href="'+url+'exam/submissions/'+exam.id+'">submissions</a></td><td>'+link+'</td>';
        }
        subHtml+= '</tbody></table>';
        $('section.content').html(subHtml); 

    }).fail(function(data){
        console.log(data);
    });

}

function dcSubmissions(id){
    $.ajax({
        type : 'GET',
        url : api_url + 'exam/submissions/'+ id,
        data : {}
    }).done(function(data){
        console.log('done');
        console.log(data);
        if((data.result).length){
            var subHtml= '<table class="table table-striped"><thead><tr><th>exam name</th><th>description</th><th>Link</th></tr></thead><tbody>';
            for(var exam of data.result){
                subHtml+= '<tr><td>'+exam.exam_name+'</td><td>'+exam.desc+'</td><td><a href="'+url+'exam?examId='+exam.exam_id+'&&userId='+exam.user_id+'">Link</a></td>';
            }
            subHtml+= '</tbody></table>';
            $('section.content').html(subHtml); 
        }
        else
        $('section.content').html('there is no submissions for this exam'); 

    }).fail(function(data){
        console.log(data);
        console.log(data.statusText);
    });
}

function dcSub(doc_id){

    $.ajax({
        type : 'GET',
        url : api_url + 'subject/findByDoctor/'+doc_id,
        data : {}
    }).done(function(data){
        console.log('done');
        var subHtml = '<a class="btn btn-primary" id="newSubject" href="'+url+'subject/create">create new subject</a><br>';
        subHtml+= '<table class="table table-striped"><thead><tr><th>subject name</th><th>description</th><th>update</th><th>delete</th></tr></thead><tbody>';
        for(var sub of data.result){
            var update = '<a class="btn btn-success" href="'+url+'subject/update/'+sub.id+'" >update</button>';
            var del = '<button class="btn btn-danger" onClick="deleteSubject('+sub.id+')" >delete</button>';
            subHtml+= '<tr><td><a href="'+url+'dc/subject/exams/'+sub.id+'" >'+sub.subject_name+'</a></td><td>'+sub.desc+'</td><td>'+update+'</td><td>'+del+'</td>';
        }
        subHtml+= '</tbody></table>';
        $('section.content').html(subHtml); 

    }).fail(function(data){
        console.log(data);
    });

}

function dcSubContent(subId){
    $.ajax({
        type : 'GET',
        url : api_url + 'subject/find/'+subId,
        data : {}
    }).done(function(data){
        console.log('done');
        if(data.success){
            $('section.content-header').html('<h1>'+data.result.subject_name+'<small>update</small></h1>');

            var subHtml= '<div class="container"><div class="form-group">'+
            '<label for="subject_name">Subject Name : </label>'+
            '<input type="text" id="subjectName" class="form-control"   value="'+data.result.subject_name+'" required></div>';
            
             subHtml+= '<div class="form-group" >'+
            '<label for="desc" >Description : </label>'+
            '<input type="text" id="desc" class="form-control"   value="'+data.result.desc+'" required></div>';
                          
             subHtml+= '<div class="form-group">'+
            '<div class="col-sm-offset-2 col-sm-10">'+
            '<button id="updateSubject" type="submit" class="btn btn-danger" onclick="dcSubUpd('+data.result.id+')">Update</button></div></div>';
            
            
            $('section.content').html(subHtml);
        } 
        else
            alert(data.result);

    }).fail(function(data){
        console.log(data);
    });
}

function dcSubUpd(subId , t , tt){
    console.log(subId);
    console.log();

    $.ajax({
        type : 'POST',
        url : api_url + 'subject/update',
        data : {
            'token' : $.cookie('token'),
            'id' : subId,
            'subject_name' : $('input#subjectName').val(),
            'desc' : $('input#desc').val()
        }
    }).done(function(data){
        if(data.success){
            alert(data.result);
            window.location = url + 'usr/dc';
        }
        else
            alert(data.result);
            
    }).fail(function(data){
        console.log('fail');
        console.log(data);
    });

}

function deleteSubject(subId){

    $.ajax({
        type : 'POST',
        url : api_url + 'subject/delete',
        data : {
            'token' : $.cookie('token'),
            'id' : subId
        }
    }).done(function(data){
        if(data.success){
            alert(data.result);
            location.reload();
        }
        else
            alert(data.result);
    }).fail(function(data){
        console.log('fail');
        console.log(data);
    });

}

function createSubject(){
    $.ajax({
        type : 'POST',
        url : api_url + 'subject/create',
        data : {
            'token' : $.cookie('token'),
            'subject_name' : $('input#subjectName').val(),
            'desc' : $('input#desc').val()
        }
    }).done(function(data){
        if(data.success){
            alert('created successfully');
            window.location = url + 'usr/dc';
        }
        else
            alert('creation failed');
        console.log(data);
            
    }).fail(function(data){
        console.log('fail');
        console.log(data);
    });
}

function onTest(){
    alert('testing');
}
