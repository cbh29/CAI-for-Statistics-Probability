$(function(){
    
    //Zoom in images
    let imgs = $('.lesson-content .img-content img');
    for(let i = 0; i < imgs.length; i++){
        $(imgs[i]).on('click', function(){
            let imgUrl = $(this).attr('src');
            $('.lighthouse img').attr('src', imgUrl);

            $('.lighthouse').css('visibility', 'visible');
            $('.lighthouse').css('opacity', '1');

            $('body').css('overflow', 'hidden');
        });
    }

    $('.lighthouse i, .lighthouse').on('click', function(){
        $('.lighthouse').css('visibility', 'hidden');
        $('.lighthouse').css('opacity', '0');

        $('body').css('overflow', 'auto');
    });


    //Modal message functions
    $('#modalMessage').on('show.bs.modal', function(){
        $('.container').css('filter', 'blur(3px)');
    });

    $('#modalMessage #btnContinue').on('click', function(){
        $('#modalMessage').modal('hide');
        $('#modalPreTests').modal('show');
    });

    let urlroot = $('#urlroot').val();
    let lessonID = $('#lessonID').val();

    //Pop up modal message if pre test has not been taken
    $.getJSON(`${urlroot}/jsons/scoreRowCount/${lessonID}`, function(e){
        if(e <= 0){
            $('#modalMessage').modal('show');
        }
    });

    //Continue to pre test
    $('#modalMessage #btnContinuePreTests').on('click', function(){
        $('#modalMessage').modal('hide');

        $('#modalTests').modal('show');
        $('#modalTests .modal-content').load(urlroot + '/ajaxes/tests', {
            'lessonID': lessonID,
            'type': "pre"
        });
    });

    //Modal pretest functions

    //Start the post test
    $('#modalPostTestMessage #btnStartPostTest').on('click', function(){
        $('#modalPostTestMessage').modal('hide');
        $('#modalTests').modal('show');
        $('#modalTests .modal-content').load(urlroot + '/ajaxes/tests', {
            'lessonID': lessonID,
            'type': "post"
        });
    });
    
});