$(() => {
    let urlroot = $('#urlroot').val();
    let number = $('#number').val();
    let maxNumber = $('#maxDrill').val();
    
    let getRandomInt = (min, max) => {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }
    
    let onInputFunction = () => {
        let visibleInputs = [];
        let firstRow = $('.table-input td[data-row="0"]');
        let secondRow = $('.table-input td[data-row="1"]');
        let visibleAtFirstRow = [];
        let visibileAtSecondRow = [];
        for(let i = 0; i < 16; i++){
            if($(firstRow[i]).children().css('visibility') == "visible"){
                visibleAtFirstRow.push(firstRow[i]);
                visibleInputs.push(firstRow[i]);
            }
            if($(secondRow[i]).children().css('visibility') == "visible"){
                visibileAtSecondRow.push(secondRow[i]);
                visibleInputs.push(secondRow[i]);
            }
        }
        
        let firstRowLastCol = $(visibleAtFirstRow[visibleAtFirstRow.length - 1]).data('col');
        let secondRowLastCol = $(visibileAtSecondRow[visibileAtSecondRow.length - 1]).data('col');
        let firstRowFirstCol = $(visibleAtFirstRow[0]).data('col');
        let secondRowFirstCol = $(visibileAtSecondRow[0]).data('col');
        let activeRow = -1;
        let activeCol = -1;
        
        for(let i = 0; i < visibleInputs.length; i++){
            $(visibleInputs[i]).on('click', e => {
                let td = $(e.target).parent();
                activeRow = td[0].dataset.row;
                activeCol = td[0].dataset.col;
            });
            
            $(visibleInputs[i]).on('keyup', e => {
                let nonOutputKeys = [9, 13, 16, 17, 18, 19, 20, 27, 32, 33, 34, 35, 36, 38, 40, 45, 46];
                //backspace
                if(e.which === 8){
                    if(activeRow == 1 && firstRowFirstCol == activeCol){
                        activeRow = 0;
                        activeCol = firstRowLastCol;
                    }
                    else{
                        activeCol = (activeCol == firstRowFirstCol && activeRow == 0) ? firstRowFirstCol : activeCol - 1;
                    }
                }
                //left arrow
                else if(e.which == 37){
                    if(activeRow == 1 && firstRowFirstCol == activeCol){
                        activeRow = 0;
                        activeCol = firstRowLastCol;
                    }
                    else{
                        activeCol = (activeCol == firstRowFirstCol && activeRow == 0) ? firstRowFirstCol : activeCol - 1;
                    }
                }
                //right arrow
                else if(e.which == 39){
                    if(activeRow == 0 && activeCol == firstRowLastCol){
                        if(secondRowLastCol != undefined){
                            activeRow = 1;
                            activeCol = secondRowFirstCol;
                        }
                        else{
                            activeCol = firstRowLastCol;
                        }
                    }
                    else{
                        if(activeCol == secondRowLastCol && activeRow == 1){
                            activeCol = secondRowLastCol;
                        }
                        else{
                            activeCol = JSON.parse(activeCol) + 1;
                        }
                    }
                }
                //No output keys
                else if(nonOutputKeys.includes(e.which)){
                    return;
                }
                else{
                    if(activeRow == 0 && activeCol == firstRowLastCol){
                        if(secondRowLastCol != undefined){
                            activeRow = 1;
                            activeCol = secondRowFirstCol;
                        }
                        else{
                            activeCol = firstRowLastCol;
                        }
                    }
                    else{
                        if(activeCol == secondRowLastCol && activeRow == 1){
                            activeCol = secondRowLastCol;
                        }
                        else{
                            activeCol = JSON.parse(activeCol) + 1;
                        }
                    }
                }
                let input = $(`.table-input td[data-row=${activeRow}][data-col=${activeCol}]`).children()
                $(input).focus();
            });
        }
    }
    
    let submitFunction = answer => {
        $('#btnSubmit').on('click', e => {
            let inputs = $('.table-input input');
            let word = "";
            for(let i = 0; i < inputs.length; i++){
                if(inputs[i].value.length > 0){
                    word += inputs[i].value;
                }
            }
            
            if(word.toUpperCase() === answer){
                new Audio(urlroot + "/sound/correct_sound.mp3").play()
                .then(e => {
                    $.ajax({
                        url: urlroot + "/accounts/secondDrillSubmit",
                        method: "POST",
                        data:{
                            'number': number
                        },
                        success: e => {
                            if(!e.includes('error')){
                                new Audio(urlroot + "/sound/correct_sound.mp3").play()
                                    .then(e => {
                                        alert("CORRECT!");
                                        clearPlaceHolders();
                                        localStorage.removeItem('hintData');
                                        window.location.reload();
                                    });
                            }
                            else{
                                alert("We can't record your answer due to server error. Please try again later");
                            }
                        }
                    });
                });
            }
            else{
                new Audio(urlroot + "/sound/incorrect_sound.mp3").play()
                    .then(e => {
                        alert("INCORRECT!");
                    });
            }
        });
    }
    
    let hintFunction = (answerLength, letters) => {
        let hintObj = JSON.parse(localStorage.getItem('hintData'));
        if(!hintObj){
            hintObj = {
                number: number,
                hintCount: Math.round(answerLength * .30),
                hintShown: []
            }
            localStorage.setItem('hintData', JSON.stringify(hintObj));
            
        }
        
        let shownHints = hintObj.hintShown;
        for(let i = 0; i < shownHints.length; i++){
            let lettersObj = letters[shownHints[i]];
            $(`td[data-row=${lettersObj.row}][data-col=${lettersObj.col}]`).children().val(lettersObj.letter);
        }
        
        $('#btnHint').off('click');
        $('#btnHint').on('click', v => {
            //hint count update and hint shown update
            hintObj.hintCount = --hintObj.hintCount;
            if(hintObj.hintCount >= 0){
                let rndIndex = getRandomInt(0, letters.length - 1);
                while(shownHints.includes(rndIndex)){
                    rndIndex = getRandomInt(0, letters.length - 1);
                }
                
                hintObj.hintShown.push(rndIndex);
            }
            else{
                hintObj.hintCount = 0;
            }
            
            for(let i = 0; i < shownHints.length; i++){
                let lettersObj = letters[shownHints[i]];
                $(`td[data-row=${lettersObj.row}][data-col=${lettersObj.col}]`).children().val(lettersObj.letter);
            }
            
            // update local storage hint
            $('#btnHint').text("Hint (" + hintObj.hintCount + ")");
            localStorage.setItem('hintData', JSON.stringify(hintObj));
        });
        
        //Hint count initialization
        $('#btnHint').text("Hint (" + hintObj.hintCount + ")");
    }
    
    let getQuestion = num => {
        $.ajax({
            url: urlroot + "/Jsons/secondDrillQuestion/" + num,
            method: "GET",
            cache: false,
            success: e => {
                let data = JSON.parse(e);
                let answer = data.Answer;
                let answerLength = 0;
                let letters = [];
                
                for(let i = 0; i < 4; i++){
                    let item = $('.grid-container .item');
                    $(item[i]).children().attr('src', urlroot + "/uploads/" + data[i].Image);
                }
                $('#numbering').text(num + "/" + maxNumber);
                
                for(let i = 0; i < answer.length; i++){
                    let startsAt = Math.round((16 - answer[i].length) / 2);
                    
                    for(let j = 0; j < answer[i].length; j++){
                        $(`td[data-row=${i}][data-col=${startsAt + j}]`).children().css('visibility', 'visible');
                        ++answerLength;
                        
                        let lettersObj = {
                            row : i,
                            col: startsAt + j,
                            letter: answer[i][j]
                        }
                        letters.push(lettersObj);
                    }
                }
                
                hintFunction(answerLength, letters);
                submitFunction(answer.map(e => e).join(''));
                onInputFunction();
            }
        });
    }
    
    let clearPlaceHolders = () => {
        for(let i = 0; i < $('tr').length; i++){
            let row = $('tr')[i];
            for(let j = 0; j < $(row).children().length; j++){
                let col = $($(row).children()[j]).children();
                $(col).css('visibility', 'hidden');
                $(col).val("");
            }
        }
        
        for(let i = 0; i < 4; i++){
            let item = $('.item');
            $(item[i]).children().attr('src', "");
        }
    }
    
    for(let i = 0; i < $('tr').length; i++){
        let row = $('tr')[i];
        for(let j = 0; j < $(row).children().length; j++){
            let col = $(row).children()[j];
            $(col).attr('data-row', i);
            $(col).attr('data-col', j);
            
            $(col).on('input', (e) => {
                $(col).val(e.target.value.toUpperCase());
            });
        }
    }
    
    //Initial Question
    getQuestion(number);
});