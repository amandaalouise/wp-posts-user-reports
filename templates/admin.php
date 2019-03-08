 <div class="wrap">

 	<h2 style="margin: 20px 0; font-size: 25px !important">Relatórios do Sistema</h2>

 	<h2 class="nav-tab-wrapper">
 		<a class="nav-tab nav-tab-active" href="<?php echo admin_url() ?>/index.php?page=Posts">Posts</a>
 		<a class="nav-tab nav-tab-active" href="<?php echo admin_url() ?>/index.php?page=Usuários">Usuários</a>
 	</h2>

 	<div id='sections'>
 		<section><?php require 'general-report.php'?></section>
 		<section><?php require 'users-report.php'?></section>
 	</div>

 </div><!-- /.wrap -->