$(function(){

    $('nav .btn-menu').on('click', function(){
        $('.aside-shadow').css('visibility', 'visible');
        $('.aside-shadow').css('opacity', '.4');
        $('aside').css('left', '0px');
        $('body').css('overflow', 'hidden');
    });

    $('.aside-shadow').on('click', function(){
        $('.aside-shadow').css('visibility', 'hidden');
        $('.aside-shadow').css('opacity', '0');
        $('aside').css('left', '-240px');
        $('body').css('overflow', 'auto');
    })

    let isProfileShown = false;
    $('.profile-container i').on('click', function(e){
        e.stopPropagation();
        if(isProfileShown){
            isProfileShown = false;
            $('.profile').css('right', '-100%');
        }
        else{
            isProfileShown = true;
            $('.profile').css('right', '0');
        }
    });
    
    $('.profile').on('click', function(e){
        e.stopPropagation();
    });

    $('body').on('click', function(){
        if(isProfileShown){
            isProfileShown = false;
            $('.profile').css('right', '-100%');
        }
    });
    
    $('#btnDownloadCert').on('click', function(e){
        e.preventDefault();
        html2pdf()
        .from($('#passerCert').clone().css('display', 'block')[0])
        .set({
            margin: [1, 0, 0, 0],
            filename: 'certificate.pdf',
            jsPDF: {
                unit: 'in',
                orientation: 'landscape',
                format: 'a4'
            }
        }).save();
    });
    
});