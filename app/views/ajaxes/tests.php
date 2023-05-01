<input type="hidden" value='<?php echo json_encode($data['tests'])?>' id="questions">
<input type="hidden" value="<?php echo $data['lessonID']?>" id="lessonID">
<input type="hidden" value="<?php echo $data['type']?>" id="type">
<input type="hidden" value="<?php echo URLROOT?>" id="urlroot">

<div class="modal-header">
    <h5 class="modal-title" id="staticBackdropLabel"><?php echo $data['lessonNo']?>'s <?php echo ucfirst($data['type'])?>-Test</h5>
</div>

<div class="modal-body">
    <div class="d-flex align-items-center justify-content-between">
        <i class="fas fa-chevron-left ms-5" id="btnPrev"></i>
        <h6 class="m-0" id="itemCount"></h6>
        <i class="fas fa-chevron-right me-5" id="btnNext"></i>
    </div>

    <h6 class="mt-3">Question</h6>
    <div class="question">
        <p></p>
        <img width="100%">
    </div>

    <h6 class="mt-3">Choices</h6>
    <div class="choices">
    </div>
</div>

<div class="modal-footer">
    <button class="btn btn-secondary" id="btnCancelTest">Cancel</button>
    <button class="btn btn-primary" id="btnSubmit">Submit</button>
</div>

<script>
    $.getScript($('#urlroot').val() + '/public/js/ajaxes/tests.js');
</script>