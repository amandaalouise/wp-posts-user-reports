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
			<button type="button" id="get_data" class="button-primary" style="margin-top: 25px;">Buscar Dados</button>
		</td>
	</tr>
</table>