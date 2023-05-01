$(function(){
    
    function CorrectAnswer(number, isCorrect){
        this.Number = number;
        this.IsCorrect = isCorrect
    }
    
    let row = "";
    for(y = 0; y < 16; y++){
        row += "<tr>";
        for(let x = 0; x < 18; x++){
            row += `<td>
                        <span></span>
                        <input type="text" maxlength="1" data-x="${x}" data-y="${y}">
                    </td>`;
        }
        row +="</tr>";
    }
    $('table').html(row);
    
    let cWordsAnswers = JSON.parse($('#cWordsAnswers').val());
    let drillStatus = JSON.parse($('#drillStatus').val());
    
    for(let i = 0; i < cWordsAnswers.length; i++){
        let words = cWordsAnswers[i].Answer;
        let number = cWordsAnswers[i].Number;
        let x = cWordsAnswers[i].PlaceX;
        let y = cWordsAnswers[i].PlaceY;
        
        if(cWordsAnswers[i].Orientation == "vert"){
            for(let j = 0; j < words.length; j++){
                if(drillStatus.some(e => e.Number == number)){
                    $(`table input[data-x="${x}"][data-y="${y + j}"]`).val(words[j]).css('background', '#5eff71').prop('readonly', true);
                }
                
                $(`table input[data-x="${x}"][data-y="${y + j}"]`).css('opacity', '1').css('visibility', 'visible');
                $(`table input[data-x="${x}"][data-y="${y + j}"]`).attr("data-orientation", "vert");
            }
            let existingNumber = $(`table input[data-x="${x}"][data-y=${y}]`).parent().children('span').text();
            $(`table input[data-x="${x}"][data-y=${y}]`).parent().children('span').text(existingNumber + " " + number);
        }
        else{
            for(let j = 0; j < words.length; j++){
                if(drillStatus.some(e => e.Number == number)){
                    $(`table input[data-x="${x + j}"][data-y="${y}"]`).val(words[j]).css('background', '#5eff71').prop('readonly', true);
                }
                
                $(`table input[data-x="${x + j}"][data-y="${y}"]`).css('opacity', '1').css('visibility', 'visible');
                $(`table input[data-x="${x + j}"][data-y="${y}"]`).attr("data-orientation", "hori");
            }
            let existingNumber = $(`table input[data-x="${x}"][data-y=${y}]`).parent().children('span').text();
            $(`table input[data-x="${x}"][data-y=${y}]`).parent().children('span').text(existingNumber + " " + number);
        }
    }
    
    let inputs = $('table input');
    for(let i = 0; i < inputs.length; i++){
        $(inputs[i]).on('keyup', function(e){
            let orientation = $(this).data('orientation');
            let x = $(this).data('x');
            let y = $(this).data('y');
            
            if(!(e.keyCode == 8 || e.keyCode == 46 || e.keyCode == 37 || e.keyCode == 38 || e.keyCode == 39 || e.keyCode == 40)){
                if(orientation == "vert"){
                    y++
                }else{
                    x++
                }
            }
            
            if(e.keyCode == 37){
                x--;
            }else if(e.keyCode == 38){
                y--;
            }else if(e.keyCode == 39){
                x++;
            }else if(e.keyCode == 40){
                y++;
            }
            
            $(`table input[data-x="${x}"][data-y="${y}"]`).focus();
        });
    }
    

    $('#btnCheck').on('click', function(){
        let correct = 0;
        let numberStatus = [];
        
        for(let i = 0; i < cWordsAnswers.length; i++){
            //Vertical Checks
            for(let x = 0; x < 18; x++){
                let word = "";
                for(let y = 0; y < 16; y++){
                    let value = $(`table input[data-x="${x}"][data-y="${y}"]`).val().toLowerCase();
                    word += value;
                }
                
                if(word.includes(cWordsAnswers[i].Answer)){
                    correct++;
                    numberStatus.push(new CorrectAnswer(cWordsAnswers[i].Number, true));
                }
            }
            
            //Horizontal checks
            for(let y = 0; y < 16; y++){
                let word = "";
                for(let x = 0; x < 18; x++){
                    let value = $(`table input[data-x="${x}"][data-y="${y}"]`).val().toLowerCase();
                    word += value;
                }
                
                if(word.includes(cWordsAnswers[i].Answer)){
                    correct++;
                    numberStatus.push(new CorrectAnswer(cWordsAnswers[i].Number, true));
                }
            }
        }
        
        $.ajax({
            url: $('#urlroot').val() + '/accounts/setDrillStatus',
            method: 'POST',
            data:{
                status: JSON.stringify(numberStatus)
            },
            cache: false,
            success: function(e){
                window.location.reload();
            }
        });
    });
});