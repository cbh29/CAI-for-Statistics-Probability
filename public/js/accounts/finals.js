$(function(e){
    
    let isTimeRunning = false;
    
    $('#message').modal('show');
    
    $('#btnStartTest').on('click', function(){
        isTimeRunning = true;
        $('#message').modal('hide');
        $('.finals-container').css('filter', 'blur(0)');
    })
    
    //Timer
    var sec = 0;
    function pad ( val ) { return val > 9 ? val : "0" + val; }
    setInterval( function(){
        if(isTimeRunning){
            $("#seconds").html(pad(++sec%60));
            $("#minutes").html(pad(parseInt(sec/60,10)));
        }
    }, 1000);
    
    function submit(){
        let parts = {
            "I": {},
            "II": {},
            "III": {}
        };
        
        let partKeys = ["I", "II", "III"];
        for(let i = 0; i < partKeys.length; i++){
            if(partKeys[i] == "II"){
                for(let j = 1; j <= 20; j++){
                    let val = $(`input[type="radio"][data-part="${partKeys[i]}"][data-num="${j}"]:checked`).val() || "";
                    parts[partKeys[i]][j] = val;
                }
            }
            else{
                for(let j = 1; j <= 20; j++){
                    let val = $(`input[type="text"][data-part="${partKeys[i]}"][data-num="${j}"]`).val();
                    parts[partKeys[i]][j] = val;
                }
            }
        }
        
        $.ajax({
            url: $('#urlroot').val() + '/accounts/recordUserFinalTest',
            type: 'POST',
            data:{
                'answers': parts,
                'timeTaken': $('#timer').text(),
                
            },
            cache: false,
            success: function(e){
                window.location.replace($('#urlroot').val() + '/accounts/finalsResult');
            }
        });
    }
    
    $('#btnSubmitFinals').on('click', function(){
        if(confirm("Are you sure you want to submit your answers?")){
            submit();
        }
    });
    
    $('#btnCancelFinals').on('click', function(e){
        if(confirm("Are you sure you want to cancel the final test? The system will automatically submit your answers")){
            submit();
            window.location.replace($('#urlroot').val() + '/accounts/dashboard');
        }
    });
    
    $('input[data-part="III"][data-num="10"]').prop('readonly', true);
    $('input[data-part="III"][data-num="9"]').on('input', function(){
        $('input[data-part="III"][data-num="10"]').val($(this).val())
    });
    
    $('input[data-part="III"][data-num="20"]').prop('readonly', true);
    $('input[data-part="III"][data-num="19"]').on('input', function(){
        $('input[data-part="III"][data-num="20"]').val($(this).val())
    });
    
});