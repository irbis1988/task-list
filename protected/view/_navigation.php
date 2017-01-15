<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container-fluid">

		<div class="col-md-offset-1 col-sm-offset-0 col-md-10 col-sm-12 col-xs-12">
			<ul class="nav navbar-nav">
				<?php foreach($act->nav as $item):?>
				<?php if($item['auth']==0 || ($item['auth']==1 && $act->isAuth()) || ($item['auth']==-1 && !$act->isAuth())):?>
				<li<?=($act->view==$item['view'])?' class="active"':'';?>><a href="/<?=$item['url'];?>"><?=$item['caption'];?></a></li>
				<?php endif;?>
				<?php endforeach;?>
			</ul>

		</div>	
	</div><!-- /.container-fluid -->
</nav>
<br><br>