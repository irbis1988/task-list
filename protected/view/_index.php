<div class="col-md-offset-1 col-sm-offset-0 col-md-10 col-sm-12 col-xs-12">
	<div class="container-fluid">
		<div class="page-header">
			<h1 class="text-center text-info">Список задач</h1>
		</div>
		<?php if($act->message!==''):?>
		<div class="alert alert-success" role="alert">
			<?php echo $act->message;?><br>
		</div>
		<?php endif;?>
		<table class="table table-striped">
			<thead>
				<th><a href="?o=username<?=($act->data['o']=='username' && !$act->data['d'])?'&d=1':'';?>"><?=($act->data['o']=='username' && !$act->data['d'])?'&darr;&nbsp;':(($act->data['o']=='username' && $act->data['d'])?'&uarr;&nbsp;':'');?>Имя<br>пользователя</a></th>
				<th><a href="?o=email<?=($act->data['o']=='email' && !$act->data['d'])?'&d=1':'';?>"><?=($act->data['o']=='email' && !$act->data['d'])?'&darr;&nbsp;':(($act->data['o']=='email' && $act->data['d'])?'&uarr;&nbsp;':'');?>e-mail</a></th>
				<th>Текст задачи</th>
				<th>Изображение</th>
				<th><a href="?o=status<?=($act->data['o']=='status' && !$act->data['d'])?'&d=1':'';?>"><?=($act->data['o']=='status' && !$act->data['d'])?'&darr;&nbsp;':(($act->data['o']=='status' && $act->data['d'])?'&uarr;&nbsp;':'');?>Выполнено</a></th>
				
				<?php if($act->isAuth()):?>
					<th></th>
				<?php endif;?>
			</thead>
			<tbody>
				<?php if(is_array($act->data['tasks']) && count($act->data['tasks'])):?>
				<?php foreach($act->data['tasks'] as $task):?>
				<?php if($act->isAuth()):?>
				<form action="/" method="post">
				<?php endif;?>
				<tr>					
					<td><?=$task->username;?></td>
					<td><?=$task->email;?></td>
					<td>
					<?php if(!$act->isAuth()):?>
						<?=$task->text;?>
					<?php else:?>
						<textarea class="form-control" maxlength="3000" required="required" rows="6" name="upd[text]"><?=$task->text;?></textarea>
					<?php endif;?>
					</td>
					<td>
						<?php if($task->image):?>
						<img src="/upload/<?php echo $task->image;?>" alt="" class="img-thumbnail">
						<?php else:?>
						-нет изображения-
						<?php endif;?>
					</td>
					<td>	
					<?php if(!$act->isAuth()):?>
						<span class="status-<?=$task->status;?>"></span>
					<?php else:?>
						<input type="checkbox" name="upd[status]" value="1" <?=($task->status)?'checked="checked"':'';?>>
					<?php endif;?>
					</td>
					
					<?php if($act->isAuth()):?>
					<td>
						<button type="submit" class="task-update-btn btn btn-primary btn-sm" name="upd[send]" value="<?=$task->id;?>">Изменить</button>		
					</td>
					<?php endif;?>
				</tr>
				<?php if($act->isAuth()):?>	
				</form>	
				<?php endif;?>	
				<?php endforeach;?>
				<?php else:?>
				<tr>
					<td colspan="5" class="text-center">В списке нет задач.</td>
				</tr>
				<?php endif;?>
			</tbody>
		</table>
		
		<hr>
	</div>
</div>
