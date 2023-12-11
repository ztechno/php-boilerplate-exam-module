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
        <div class="card-content">
            <h2 align="center">
                DAFTAR HADIR PESERTA<br>
                PENILAIAN AKHIR SEMESTER<br>
                TAHUN PELAJARAN 2023/2024
            </h2>
            <table cellpadding="5">
                <tr>
                    <td>Nama Sekolah</td>
                    <td>:</td>
                    <td>SMK Negeri 1 Pulau Rakyat</td>
                </tr>
                <tr>
                    <td>Hari</td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Kelas</td>
                    <td>:</td>
                    <td><?=$member[0]->group_name?></td>
                </tr>
                <tr>
                    <td>Mata Pelajaran</td>
                    <td>:</td>
                    <td></td>
                </tr>
            </table>
            <table cellpadding="5" cellspacing="0" width="100%" align="center" border="1" style="margin:0">
                <tr>
                    <th width="20px">NO</th>
                    <th width="100px">NIS</th>
                    <th width="350px">NAMA</th>
                    <th colspan="2" width="350px">TANDA TANGAN</th>
                    <th width="100px">KET</th>
                </tr>
                <?php foreach($member as $no => $_member): ?>
                <tr>
                    <td><?=$no+1?></td>
                    <td><?=$_member->username?></td>
                    <td><?=$_member->name?></td>
                    <td><?=$no%2==0?($no+1).'.':''?></td>
                    <td><?=$no%2!=0?($no+1).'.':''?></td>
                    <td></td>
                </tr>
                <?php endforeach ?>
            </table>

            <div style="width:300px;margin-left:auto;text-align:center;margin-top:50px;">
            <b>DIKETAHUI</b><br>
            <b>PENGAWAS</b>
            <br><br>
            <br><br>
            __________________________
            </div>
        </div>
    </div>
</div>
<script>
window.print()
</script>