<?php 
global $wpdb;

$myrows = $wpdb->get_results( "
	SELECT *
            FROM $wpdb->posts
            WHERE $wpdb->posts.post_type = 'demandas'
            AND $wpdb->posts.post_status = 'publish'
	", OBJECT ); 

	?>

<h2>Demandas</h2>

<table class="widefat fixed" cellspacing="0" border="1" bordercolor="#eee" id="tabledemandas">
	<thead>
		<tr>
			<th id="columnname" class="manage-column column-columnname" scope="col">ID</th>
			<th id="columnname" class="manage-column column-columnname" scope="col">Data de publicação</th>
			<th id="columnname" class="manage-column column-columnname" scope="col">Título da publicação</th>
			<th id="columnname" class="manage-column column-columnname" scope="col">Instituição Demandante</th>
			<th id="columnname" class="manage-column column-columnname" scope="col">Qtde. Acesso ao contato</th>
		</tr>
	</thead>

	<tbody>
		<?php 
		
		$i = 0;
		
		?>
		<?php foreach($myrows as $row) { 

		$contador = get_post_meta($row->ID, 'count'); 
		$ies = get_post_meta($row->ID, 'instituição_demandante'); 

		?>

		<tr>
			<td class="column-columnname"><?php echo $row->ID ?></td>
			<td class="column-columnname"><?php echo $row->post_date ?></td>
			<td class="column-columnname"><?php echo $row->post_title ?></td>
			<td class="column-columnname"><?php echo $ies->display_name ?></td>
			<td class="column-columnname"><?php echo $contador[0] ? $contador[0] : '0' ?></td>
		</tr>

		<?php

		$i++;
	} ?>

		<tr>
			<td colspan="5">&nbsp</td>
		</tr>

		<tr>
			<td colspan="4" style="font-weight: bold">Total:</td>
			<td style="font-weight: bold"><?php echo $i ?></td>
		</tr>

	</tbody>
</table>

<button class="button" id="exportdemandas">Exportar dados</button>