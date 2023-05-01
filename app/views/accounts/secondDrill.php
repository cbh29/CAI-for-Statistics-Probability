<?php
    include APPROOT . "/views/includes/head.php";
    include APPROOT . "/views/includes/account-nav.php";
?>
<link rel="stylesheet" href="<?php echo URLROOT?>/css/accounts/secondDrill.css?v=<?php echo time()?>">

<?php if($data['number'] == $data['drill-count']): ?>
    <div class="container">
        <h1 class="text-success">Complete</h1>
        
        <div class="row">
            <?php for($i = 0; $i < count($data['drill-data']); $i++): ?>
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="outer mt-5" style="max-width: 350px;">
                        <div class="grid-container">
                            <?php for($j = 0; $j < count($data['drill-data'][$i]['Images']); $j++): ?>
                                <div class="item">
                                    <img src="<?php echo URLROOT . "/uploads/" .$data['drill-data'][$i]['Images'][$j]['Image']?>">
                                </div>
                            <?php endfor?>
                        </div>
                        <h4 class="text-center text-success mt-2"><?php echo $data['drill-data'][$i]['Answer']?></h4>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
<?php else: ?>
    <div class="container">
        <div class="outer">
            <h4 id="numbering"></h4>
            <div class="grid-container">
                <div class="grid-item-1 item">
                    <img>
                </div>
                <div class="grid-item-2 item">
                    <img>
                </div>
                <div class="grid-item-3 item">
                    <img>
                </div>
                <div class="grid-item-4 item">
                    <img>
                </div>
            </div>
            
            <div class="table-input">
                <table>
                    <tr>
                        <td><input type="text" maxlength="1"></td>
                        <td><input type="text" maxlength="1"></td>
                        <td><input type="text" maxlength="1"></td>
                        <td><input type="text" maxlength="1"></td>
                        <td><input type="text" maxlength="1"></td>
                        <td><input type="text" maxlength="1"></td>
                        <td><input type="text" maxlength="1"></td>
                        <td><input type="text" maxlength="1"></td>
                        <td><input type="text" maxlength="1"></td>
                        <td><input type="text" maxlength="1"></td>
                        <td><input type="text" maxlength="1"></td>
                        <td><input type="text" maxlength="1"></td>
                        <td><input type="text" maxlength="1"></td>
                        <td><input type="text" maxlength="1"></td>
                        <td><input type="text" maxlength="1"></td>
                        <td><input type="text" maxlength="1"></td>
                    </tr>
                    <tr>
                        <td><input type="text" maxlength="1"></td>
                        <td><input type="text" maxlength="1"></td>
                        <td><input type="text" maxlength="1"></td>
                        <td><input type="text" maxlength="1"></td>
                        <td><input type="text" maxlength="1"></td>
                        <td><input type="text" maxlength="1"></td>
                        <td><input type="text" maxlength="1"></td>
                        <td><input type="text" maxlength="1"></td>
                        <td><input type="text" maxlength="1"></td>
                        <td><input type="text" maxlength="1"></td>
                        <td><input type="text" maxlength="1"></td>
                        <td><input type="text" maxlength="1"></td>
                        <td><input type="text" maxlength="1"></td>
                        <td><input type="text" maxlength="1"></td>
                        <td><input type="text" maxlength="1"></td>
                        <td><input type="text" maxlength="1"></td>
                    </tr>
                </table>
            </div>
            
            <div class="controls mt-3">
                <div class="row">
                    <div class="col-6 p-1">
                        <button class="cai-button py-1" id="btnHint">Hint (0)</button>
                    </div>
                    <div class="col-6 p-1">
                        <button class="cai-button py-1" id="btnSubmit">Submit</button>
                    </div>
                    <div class="col-12 p-1">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif;?>

<input type="hidden" value="<?php echo URLROOT?>" id="urlroot">
<input type="hidden" value="<?php echo $data['drill-count']; ?>" id="maxDrill">
<input type="hidden" value="<?php echo ($data['number'] == $data['drill-count']) ? $data['number'] : ++$data['number']; ?>" id="number">
<script src="<?php echo URLROOT?>/js/accounts/secondDrill.js?v=<?php echo time()?>"></script>
<?php
    include APPROOT . "/views/includes/foot.php";
?>