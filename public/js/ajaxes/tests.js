$(function(){

    function renderQuestionAndChoices(index){
        $('#modalTests #itemCount').text((index + 1) + "/" + (questions.length));
        $('#modalTests .question p').text(questions[index].Question);

        $('#modalTests .question img').hide();
        if(questions[index].Image.length > 0){
            $('#modalTests .question img').attr('src', urlroot + '/public/uploads/' + questions[index].Image);
            $('#modalTests .question img').show();
        }
        
        let choices = questions[index].Choices;
        let htmlChoices = choices.map(e => {
            let radioChecked = "";
            if(e.ChoiceID == answers[index]['answer-id']){
                radioChecked = "checked";
            };

            return `
                <label class="radio-choice">
                    <input type="radio" name="choices" value="${e.ChoiceID}" ${radioChecked}>
                    <span>${e.Choice}</span>
                </label>
            `;
        });
        $('#modalTests .choices').html(htmlChoices);
        
        answers[index]['test-id'] = questions[index]['TestID'];
        $('#modalTests .radio-choice input[name="choices"]').on('change', function(){
            answers[index]['answer-id'] = $(this).val();
        });

        if(index == questions.length - 1){
            $('#modalTests .modal-footer button:nth-child(2)').show();
        }
        else{
            $('#modalTests .modal-footer button:nth-child(2)').hide();
        }
    }

    let type = $('#type').val();
    let answers = [];
    let urlroot = $('#urlroot').val(); 
    let index, questions
    try{
        index = 0;
        questions = JSON.parse($("#questions").val());
    }catch(e){
        questions = [];
    }

    //Initialize array of answers
    for(let i = 0; i < questions.length; i++){
        answers[i] = {
            "test-id": "",
            "answer-id": ""
        };
    }

    //Initialize question
    renderQuestionAndChoices(index);

    //Previous button
    $('#modalTests #btnPrev').on('click', function(){
        index--;
        if(index < 0){ index = questions.length - 1; }
        renderQuestionAndChoices(index);
    });

    //Next button
    $('#modalTests #btnNext').on('click', function(){
        if(index < questions.length - 1){ index++; }
        else{ index = 0; }
        renderQuestionAndChoices(index);
    });

    //Submit test
    $('#modalTests .modal-footer #btnSubmit').on('click', function(){
        if(confirm("Are you sure you want to submit your answers?")){
            $.ajax({
                url: urlroot + '/ajaxes/submitTests',
                method: 'POST',
                data: {
                    'answers': answers,
                    'lessonID': $('#lessonID').val(),
                    'type': type
                },
                success: function(e){
                    if(e.includes("error")){
                        alert("Make sure that you answered all the questions");
                    }
                    else{
                        $('#modalTests').modal('hide');
                        $('#modalTestResults').modal('show');
                    }
                }
            });
        }
    });
    
    $('#modalTestResults').on('show.bs.modal', function(){
        $('#modalTestResults .modal-content').load(urlroot + '/ajaxes/testResult', {
            'total-items' : questions.length,
            'lesson-id' : $('#lessonID').val(),
            'type': type
        });
    })


    //Cancel test
    $('#modalTests .modal-footer #btnCancelTest').on('click', function(){
        if(confirm("Are you sure you want to cancel your test? All your answers will not be saved")){
            if(type == "pre"){
                $('#modalTests').modal('hide');
                $('#modalMessage').modal('show');
            }
            else{
                $('#modalTests').modal('hide');
            }
        }
    });

});