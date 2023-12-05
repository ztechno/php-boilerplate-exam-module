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

/* input[type="radio"]:checked+label { font-weight: bold; color: green !important; } */
input[type="radio"] ~ span {
    border-radius: 50%;
    padding: 5px;
    height: 25px;
    width: 25px;
    line-height: 14px;
    background: #FFF;
    text-align: center;
    font-weight:bold;
}
input[type="radio"]:checked ~ span { 
    font-weight: bold;
    color: #FFF;
    background: green;
}
/* input[type="radio"]:checked ~ label { 
    font-weight: bold;
    color: #FFF;
    background: green;
} */
input[type="radio"] {
    margin-right: -10px;
    opacity: 0;
}
</style>
<div class="badge bg-danger" style="position:absolute;top:46px;z-index:999999;left:calc(50% - calc(68.6px / 2))">
    <span id="hours">00</span> :
    <span id="minutes">00</span> :
    <span id="seconds">00</span>
</div>
<form action="" method="post" name="exam_form">
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
                <?php foreach($data->answers as $key => $answer): ?>
                <li>
                    <div style="display:flex;flex-direction: row-reverse;align-items:center">
                        <input type="radio" style="opacity: 0;" id="answer_<?=$data->id?>_<?=$answer->id?>" name="answer[<?=$data->id?>]" value="<?=$answer->id?>">
                        <label for="answer_<?=$data->id?>_<?=$answer->id?>">
                            <?=$answer->description?>
                        </label>
                        <span class="me-3 cursor-pointer"  onclick="document.querySelector('#answer_<?=$data->id?>_<?=$answer->id?>').click()">
                            <?=chr($key+65)?>
                        </span>
                    </div>
                </li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
</div>
<?php endforeach ?>
<button class="btn btn-block btn-primary w-100">Selesai</button>
</form>
<script>
(function(){
    var countDownDate = <?=strtotime($schedule->end_at)-strtotime('now')?>;
    window.countdownInterval = setInterval(function() {

        const h = Math.floor((countDownDate % (60 * 60 * 24)) / (60 * 60))
        const m = Math.floor((countDownDate % (60 * 60)) / (60))
        const s = Math.floor((countDownDate % (60)))
        document.getElementById("hours").innerText = h < 10 ? `0${h}` : h;
        document.getElementById("minutes").innerText = m < 10 ? `0${m}` : m;
        document.getElementById("seconds").innerText = s < 10 ? `0${s}` : s;
        if (countDownDate == 0)
        {
            // location.reload();
            exam_form.submit()
            clearInterval(window.countdownInterval)
        }

        countDownDate--
    }, 1000);
})();


window.onfocus = function () { 
    window.location.reload()
};

// document.onclick = function(){
//     doFullScreen()
// }

// function doFullScreen()
// {
//     if(!document.fullscreen)
//     {
//         document.documentElement.requestFullscreen()
//     }
// }
</script>
<?php get_footer() ?>
