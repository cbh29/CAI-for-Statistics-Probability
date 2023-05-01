$(function(){
    
    let userScores = JSON.parse($('#userScores').val());
    
    let grade = 0;
    Object.entries(userScores).forEach((key, val) => {
        let score = key[1];
        grade += score[1];
    });
    
    let urlroot = $('#urlroot').val();
    let audio;
    if(grade >= 30){
        audio = new Audio(urlroot + "/sound/correct_sound.mp3");
    }
    else{
        audio = new Audio(urlroot + "/sound/incorrect_sound.mp3");
    }
    audio.play();
    
    let canvases = $('canvas');
    for(let i = 0; i < canvases.length; i++){
        new Chart($(canvases[i]), {
            type: 'pie',
            data: {
                labels: [],
                datasets: [
                    {
                        label: "Part I",
                        backgroundColor: [
                            '#ffffff',
                            '#0275d8'
                        ],
                        data: Object.values(userScores[$(canvases[i]).data('part')]),
                    }
                ]
            },
            options: {
                cutout: '60%'
            }
        });
        
        let scores = Object.values(userScores[$(canvases[i]).data('part')]);
        let score = scores[1] + "/" + (scores[0] + scores[1]);
        $(canvases[i]).parent().children('.text-container').children().text(score);
    }
    
});