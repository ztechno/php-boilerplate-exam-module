<?php get_header() ?>
<div class="table-responsive table-hover table-sales">
    <table class="table table-bordered datatable" style="width:100%">
        <thead>
            <tr>
                <th width="20px">#</th>
                <th>Nama</th>
                <th>Nilai</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($member as $index => $user): ?>
            <tr>
                <td><?=$index+1?></td>
                <td><?=$user->name?></td>
                <td><?=$user->final_score??'<i>Belum ada nilai</i>'?></td>
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
