<?php

$regpt = get_post_types(array(
    'public' => true,
));

?>

<table id="table_general">
	<tr>
		<td colspan="2">
			<h2>Estatísticas Gerais</h2>
		</td>
	</tr>
	<tr>
		<th scope="row" style="text-align: left">
			<label for="post_types">Post Type</label>
		</th>
		<td>
			<select id="post_types" name="post_types">
				<?php foreach ($regpt as $type) {

    if ($type != 'attachment') {

        ?>

				<option value="<?php echo $type ?>"><?php echo $type ?></option>

				<?php
}

}
?>
			</select>
		</td>
	</tr>
	<tr id="fields_row">
		<th scope="row" style="text-align: left">
			<label for="fields">Fields</label>
		</th>
		<td>
			<select id="fields" multiple name="fields">

			</select>
		</td>
	</tr>
	<tr>
		<td>
			<button type="button" id="get_data" class="button-primary" style="margin-top: 25px;">Buscar Dados</button>
		</td>
	</tr>
</table>

<div class="table-width">

	<table id="flextable" class="widefat" border="1" border-color="#eee">
		<thead id="header_result">
		</thead>
		<tbody id="body_result">
		</tbody>
	</table>

	<button class="button" id="exporttocsv" style="float: right">Exportar dados</button>

</div>