<style>
* {
    font-family: arial;
    font-size:12px;
}

.card-container {
    max-width: 1000px;
    margin:auto;
}

.card-content {
    padding:20px;
}
</style>
<div class="card-container">
    <div class="card-item">
        <center>
            <img src="<?=asset('assets/exam/top.jpg')?>" alt="" width="100%" height="180px">
        </center>
        <div class="card-content">
            <h4 align="center"><u>DAFTAR HADIR</u></h4>
            <table cellpadding="5" cellspacing="0" width="100%" align="center" border="1" style="margin:0">
                <tr>
                    <th width="20px">NO</th>
                    <th width="100px">NIS</th>
                    <th width="350px">NAMA</th>
                    <th>KELAS</th>
                    <th>TANDA TANGAN</th>
                </tr>
                <?php foreach($member as $no => $_member): ?>
                <tr>
                    <td><?=$no+1?></td>
                    <td><?=$_member->username?></td>
                    <td><?=$_member->name?></td>
                    <td><?=$_member->group_name?></td>
                    <td></td>
                </tr>
                <?php endforeach ?>
            </table>
        </div>
    </div>
</div>
<script>
window.print()
</script>