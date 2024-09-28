<?php get_header() ?>
<div class="card mt-3">
    <div class="card-body">
        <h1><?=$title?></h1>
        <a href="<?=routeTo('exam/schedules/groups/reset-all', ['schedule_group_id' => $_GET['schedule_group_id']])?>" class="btn btn-warning mb-2" onclick="if(confirm('Apakah anda yakin akan me-reset semua jawaban peserta ?')){return true}else{return false}">Reset All</a>
        <a href="<?=routeTo('exam/schedules/groups/export', ['schedule_group_id' => $_GET['schedule_group_id']])?>" class="btn btn-primary mb-2" target="_blank">Cetak</a>
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
                        <td><?=$user->final_score?ceil($user->final_score):'<i>Belum ada nilai</i>'?></td>
                        <td><?=$user->status??'-'?></td>
                        <td>
                            <?php if($user->status): ?>
                                <a href="<?=routeTo('exam/schedules/groups/result-detail',['user_id' => $user->id, 'schedule_id' => $user->schedule_id])?>" class="btn btn-info"><i class="fa fa-eye"></i> Detail</a>
                                <a href="<?=routeTo('exam/schedules/groups/reset',['user_id' => $user->id, 'schedule_id' => $user->schedule_id])?>" class="btn btn-warning" onclick="if(confirm('Apakah anda yakin akan mereset ujian pada siswa ini ?')){ return true }else{ return false }">Reset</a>
                            <?php endif ?>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php get_footer() ?>
