<?php get_header() ?>
<style>
.card-body img {
    max-width:300px;
    display:block;
    margin-top:10px;
}
.answers ul, .answers li {
    list-style-type: none;
    margin:0;
    padding:0;
}

.answers li label {
    display:block;
    width:100%;
    padding-top:5px;
    padding-bottom:5px;
}
</style>
<form action="" method="post">
<?= csrf_field() ?>
<?php foreach($schedule_user_data->data as $index => $data): ?>
<div class="card mb-3">
    <div class="card-header d-flex flex-grow-1 align-items-center">
        <p class="h4 m-0">Soal No. <?=$index+1?></p>
    </div>
    <div class="card-body">
        <p><?=$data->description?></p>
        <div class="answers">
            <ul>
                <?php foreach($data->answers as $answer): ?>
                <li>
                    <label for="asnwer_<?=$data->id?>_<?=$answer->id?>">
                        <input type="radio" id="asnwer_<?=$data->id?>_<?=$answer->id?>" name="answer[<?=$data->id?>]" value="<?=$answer->id?>">
                        <?=$answer->description?>
                    </label>
                </li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
</div>
<?php endforeach ?>
<button class="btn btn-block btn-primary w-100">Selesai</button>
</form>

<?php get_footer() ?>
