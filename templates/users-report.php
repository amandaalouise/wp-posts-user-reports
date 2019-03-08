<?php global $wp_roles;?>

<table id="table_general">
	<tr>
		<td colspan="2">
			<h2>Estatísticas de Usuários</h2>
		</td>
	</tr>
	<tr>
		<th scope="row" style="text-align: left">
			<label for="roles">Roles</label>
		</th>
		<td>
			<select name="roles" id="roles">
				<?php foreach ($wp_roles->roles as $key => $value): ?>
				<option value="<?php echo $key; ?>"><?php echo $value['name']; ?></option>
				<?php endforeach;?>
			</select>
		</td>
	</tr>
	<tr id="user_fields_row">
		<th scope="row" style="text-align: left">
			<label for="user_fields">Fields</label>
		</th>
		<td>
			<select id="user_fields" multiple name="user_fields">

			</select>
		</td>
	</tr>
	<tr>
		<td>
			<button type="button" id="get_userdata" class="button-primary" style="margin-top: 25px;">Buscar
				Dados</button>
		</td>
	</tr>
</table>

<div class="table-width">

	<table id="usertable" class="widefat" border="1" border-color="#eee">
		<thead id="user_header_result">
		</thead>
		<tbody id="user_body_result">
		</tbody>
	</table>

	<button class="button" id="user_exporttocsv" style="float: right">Exportar dados</button>

</div>