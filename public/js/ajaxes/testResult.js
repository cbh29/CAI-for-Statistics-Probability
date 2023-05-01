$(function(){
    let score = $('#score').val();
    let totalItems = $('#items').val();
    let urlroot = $('#urlroot').val();
    
    let audio;
    let sub = totalItems - score;
    if(sub > score){
        audio = new Audio(urlroot + "/sound/incorrect_sound.mp3");
    }
    else{
        audio = new Audio(urlroot + "/sound/correct_sound.mp3");
    }
    audio.play();

    let data = {
        datasets: [
            {
                data: [score, score - totalItems],
                backgroundColor: ['green', 'white']
            }
        ]
    }

    let config = {
        type: 'doughnut',
        data: data,
        options: {
            cutout: 70
        }
    }

    var myChart = new Chart(
        document.getElementById('myChart'),
        config
    );

    $('#modalTestResults #btnProceedToLesson').on('click', function(){
        $('.container').css('filter', 'blur(0)');
        window.location.reload();
    })

})