<?php get_header() ?>
<a href="<?=routeTo('exam/schedules/groups/reset-all', ['schedule_group_id' => $_GET['schedule_group_id']])?>" class="btn btn-warning mb-2" onclick="if(confirm('Apakah anda yakin akan me-reset semua jawaban peserta ?')){return true}else{return false}">Reset All</a>
<div class="table-responsive table-hover table-sales">
    <table class="table table-bordered datatable" style="width:100%">
        <thead>
            <tr>
                <th width="20px">#</th>
                <th>Nama</th>
                <th>Nilai</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($member as $index => $user): ?>
            <tr>
                <td><?=$index+1?></td>
                <td><?=$user->name?></td>
                <td><?=$user->final_score??'<i>Belum ada nilai</i>'?></td>
                <td><?=$user->status??'-'?></td>
                <td>
                    <?php if($user->final_score): ?>
                    <a href="<?=routeTo('exam/schedules/groups/reset',['user_id' => $user->id, 'schedule_id' => $user->schedule_id])?>" class="btn btn-warning">Reset</a>
                    <?php endif ?>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?php get_footer() ?>
