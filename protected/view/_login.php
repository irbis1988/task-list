<div class="col-md-offset-4 col-sm-offset-3 col-xs-offset-0 col-md-4 col-sm-6 col-xs-12">
	<div class="container-fluid">
		<div class="page-header">
			<h1 class="text-center text-info">Авторизация</h1>
		</div>
		<?php if(isset($act->data['error'])):?>
		<div class="alert alert-danger" role="alert">
			<?php echo $act->data['error'];?><br>
		</div>
		<?php endif;?>
		
		<form action="/sign-in" method="post" class="form-horizontal">
			<div class="form-group">
				<label class="col-sm-5 control-label col-xs-12">Имя пользователя</label>
				<div class="col-sm-7 col-xs-12">
					<input placeholder="login" class="form-control" maxlength="250" type="text" required="required" name="auth[login]" value="<?php echo @$act->data['login'];?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 control-label col-xs-12">Пароль</label>
				<div class="col-sm-7 col-xs-12">
					<input class="form-control" type="password" maxlength="300" required="required" name="auth[pass]" placeholder="password" />
				</div>
			</div>
			<div class="row">
				<div class="col-sm-offset-5 col-xs-offset-0 col-sm-7 col-xs-12">
				<input type="submit" class="btn btn-primary form-control" value="Войти" name="auth[enter]"/>
				</div>
			</div>
			<hr>
		</form>
	</div>
</div>
