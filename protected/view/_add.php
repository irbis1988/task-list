<div class="col-md-offset-3 col-sm-offset-2 col-md-6 col-sm-8 col-xs-12">
	<div class="container-fluid">
		<div class="page-header">
			<h1 class="text-center text-info">Новая задача</h1>
		</div>
		<div class="alert alert-info" role="alert">Поля помеченные <span class="text-danger">*</span> обязательны для заполнения</div>
		<?php if($act->message!==''):?>
		<div class="alert alert-success" role="alert">
			<?php echo $act->message;?><br>
		</div>
		<?php elseif(isset($act->data['error']) && is_array($act->data['error'])):?>
		<div class="alert alert-danger" role="alert">
			<?php foreach($act->data['error'] as $err){
				echo $err.'<br>';
			}?>
		</div>
		<?php endif;?>
			
		<form action="/add-task" method="post" class="form-horizontal" enctype="multipart/form-data">
			
			<div class="form-group">
				<label class="col-sm-4 control-label col-xs-12">Имя пользователя <span class="text-danger">*</span></label>
				<div class="col-sm-8 col-xs-12">
					<input class="form-control" maxlength="250" type="text" required="required" name="add[username]" placeholder="user123" value="<?php echo @$act->data['username'];?>" />
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-4 control-label col-xs-12">E-mail <span class="text-danger">*</span></label>
				<div class="col-sm-8 col-xs-12">
					<input placeholder="user@mail.com" maxlength="250" class="form-control" type="email" required="required" name="add[email]" value="<?php echo @$act->data['email'];?>" />
				</div>
			</div>			
			
			<div class="form-group">
				<label class="col-sm-4 control-label col-xs-12">Текст задачи <span class="text-danger">*</span></label>
				<div class="col-sm-8 col-xs-12">
					<textarea class="form-control" maxlength="3000" required="required" name="add[text]" rows="7"><?php echo @$act->data['text'];?></textarea>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-4 control-label col-xs-12"><div id="for-image" class="loader pull-left"></div>Изображение</label>
				<div class="col-sm-8 col-xs-12">
					<input class="form-control" type="file" accept="image/jpeg, image/png, image/gif" name="add[image]" />
					<input type="hidden" name="add[altImage]" />
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-offset-4 col-xs-offset-0 col-sm-5 col-xs-12">
					<input type="button" class="btn btn-default form-control" value="Предварительный просмотр" id="preview-but"/>
				</div>
				<div class="col-sm-3 col-xs-12">
					<input type="submit" class="btn btn-primary form-control" value="Отправить" name="add[send]"/>
				</div>
			</div>
			<hr>
		</form>
	</div>
</div>

<div class="modal fade" id="preview-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Предварительный просмотр</h4>
			</div>
			<div class="modal-body">
				<table class="text-center table table-striped">
					<tbody>
						<tr>
							<th>Имя пользователя</th>
							<td id="pre-username"></td>
						</tr>
						<tr>
							<th>E-mail</th>
							<td id="pre-email"></td>
						</tr>
						<tr>
							<th>Текст задачи</th>
							<td id="pre-text"></td>
						</tr>
						<tr>
							<th>Изображение</th>
							<td><img src="" id="pre-image" alt="" class="img-thumbnail"></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="/js/main.js"></script>
<script>
	window.onload = App.addFormValidate({
		maxWidth: <?=$act->cfg['max-image-width'];?>,
		maxHeight: <?=$act->cfg['max-image-height'];?>,
		fSize :  <?=$act->cfg['max-file-size'];?>,
		types : ['image/png','image/jpeg','image/gif'],
		typeMess : 'Допустимые форматы изображения: jpeg, png, gif'
	});
</script>

