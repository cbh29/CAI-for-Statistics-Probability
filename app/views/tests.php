<?php include APPROOT . '/views/includes/head.php';?>

<style>
    body{
        color: black;
    }
</style>

<div class="container py-5 px-5">
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Lesson</span>
            <input type="text" class="form-control" name="lessonID" value="5">
        </div>

        <div class="form-floating mt-3">
            <textarea class="form-control" name="question" style="height: 100px"></textarea>
            <label for="floatingTextarea2">Question</label>
        </div>

        <div class="mb-3">
            <label for="formFile" class="form-label">Image</label>
            <input class="form-control" type="file" id="formFile" name="imgFile">
        </div>

        <div class="input-group mb-3 mt-3">
            <span class="input-group-text" id="basic-addon1">No. of Choices</span>
            <input type="number" id="txtNumOfChoices" class="form-control">
        </div>

        <div class="choices pb-3">
        </div>

        <button class="btn btn-primary">Submit</button>
    </form>
</div>

<script>
    $(function(){
        
        $('#txtNumOfChoices').on('input', function(e){
            let length = this.value;
            let html = ""
            
            if(length > 5){
                alert("TOO MUCH!");
                $(this).val("");
            }
            else{
                let alpha = ['a', 'b', 'c', 'd', 'e', 'f', 'g'];
                for(let i = 0; i < length; i++){
                    html = html + `
                        <div class="input-group mt-3">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" name="choice" type="radio" aria-label="Radio button for following text input">
                                ${alpha[i]}
                            </div>
                            <input type="text" name="choices[]" class="form-control">
                        </div>
                    `
                }
                $('.choices').html(html);

                let txtChoices = $('.choices input[type="text"]');
                let rbChoices = $('.choices input[type="radio"]');
                for(let i = 0; i < txtChoices.length; i++){
                    $(txtChoices[i]).on('input', function(){
                        $(rbChoices[i]).val(this.value);
                    });
                }
            }
        });

    })

</script>

<?php include APPROOT . '/views/includes/foot.php'; ?>