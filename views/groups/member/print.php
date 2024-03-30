<style>
* {
    font-family: arial;
    margin:0;
    padding:0;
    font-size:12px;
}
.card-container {
    display: flex;
    flex-wrap: wrap;
}

.card-item {
    width: 50%;
    box-sizing: border-box;
    border:1px solid #000;
    /* float:left; */
}

.card-content {
    padding:20px;
}
</style>
<div class="card-container">
    <?php foreach($member as $_member): ?>
    <div class="card-item">
        <img src="<?=asset('assets/exam/top.jpg')?>" alt="" width="100%">
        <div class="card-content">
            <h4 align="center"><u>KARTU PESERTA UJIAN</u></h4>
            <table cellpadding="5" cellspacing="0" width="100%" align="center">
                <tr>
                    <td rowspan="3" width="80px">
                        <img src="<?=asset('assets/exam/image-placeholder.jpeg')?>" alt="" width="80px">
                    </td>
                    <td>
                    <table cellpadding="5" cellspacing="0" width="100%" align="center" style="margin-left:8px">
                        <tr>
                            <td width="100px"><b>Nama</b></td>
                            <td><?= $_member->name?></td>
                        </tr>
                        <tr>
                            <td width="100px"><b>Kelas</b></td>
                            <td><?= $_member->group_name?></td>
                        </tr>
                        <tr>
                            <td width="100px"><b>Ruangan</b></td>
                            <td><?= $_member->exam_room?></td>
                        </tr>
                        <tr>
                            <td><b>Username</b></td>
                            <td><?= $_member->username?></td>
                        </tr>
                        <tr>
                            <td><b>Password</b></td>
                            <td><?= $passwords[$_member->user_id] ?></td>
                        </tr>
                    </table>
                    </td>
                </tr>
            </table>
            <br>
            <p align="center">NB : Jika tidak bisa digunakan, silahkan hubungi petugas.</p>
        </div>
    </div>
    <?php endforeach ?>
</div>
<script>
window.print()
</script>