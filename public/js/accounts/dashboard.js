$(function(){
    
    function getNumberWithOrdinal(n) {
        var s = ["th", "st", "nd", "rd"],
            v = n % 100;
        return (n + (s[(v - 20) % 10] || s[v] || s[0])) + " Attempt";
    }

    let urlroot = $('#urlroot').val();
    
    //Pre test/post test chart
    $.getJSON(urlroot + '/accounts/lessonScores', function(data){
        new Chart($('#testsChart'), {
            type: 'line',
            data:{
                labels: data.lessons,
                datasets: [
                    {
                        label: 'Post Test Scores',
                        backgroundColor: 'rgba(212, 123, 207, 0.44)',
                        borderColor: '#d37bce',
                        fill: true,
                        cubicInterpolationMode: 'monotone',
                        data: data.postScores
                    },
                    {
                        label: 'Pre Test Scores',
                        backgroundColor: 'rgba(40, 18, 64, 0.67)',
                        borderColor: '#281240',
                        fill: true,
                        cubicInterpolationMode: 'monotone',
                        data: data.preScores
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    });


    //Achievement Progress
    $.getJSON(urlroot + '/accounts/achievementProgress', function(data){
        $('#achievementProgress .text-container h1').text(data[0] + "%");
        new Chart($('#achievementProgress canvas'), {
            type: 'doughnut',
            data:{
                labels: ["progress"],
                datasets: [
                    {
                        data: data,
                        backgroundColor: ['#d37bce', "transparent"]
                    }
                ]
            },
            options: {
                cutout: '85%',
                borderRadius: 100
            }
        });
    });
    
    //Drill Score
    let userID = $('#userID').val();
    $.getJSON(urlroot + '/data/drills-status.json?v=' + new Date().getTime())
    .then(data => {
        $.getJSON(urlroot + "/data/second-drill.json?v=" + new Date().getTime(), secondData => {
            if(data[userID] === undefined){
                data[userID] = [];
            }
            
            if(secondData[userID] !== undefined){
                $('#drillScore').text(secondData[userID].answered.length + data[userID].length + "/15");
            }
        })
    });
    
    
    let finalTestAttempts = JSON.parse($('#finalTestAttempts').val());
    let strAttempts = [];
    let dataScore = [];
    
    for(let i = 0; i < finalTestAttempts.length; i++){
        strAttempts.push(getNumberWithOrdinal(i+1));
    }
    for(let i = 0; i < finalTestAttempts.length; i++){
        dataScore.push(finalTestAttempts[i].Score);
    }
    
    //Final test data
    new Chart($('#finalTestChart'), {
        type: 'line',
        data:{
            labels: strAttempts,
            datasets:[
                {
                    label: "Score per attempt",
                    backgroundColor: "rgba(2, 117, 216, .3)",
                    borderColor: "#0275d8",
                    fill: true,
                    data: dataScore
                }
            ]
        },
        options:{
            scales: {
                y: {
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});