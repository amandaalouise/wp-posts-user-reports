
(function ($) {

	$(document).ready(function () {

		$("#roles").chosen({ width: '450px' });
		$('#roles').val('administrator');
		$(".table-width").hide();
		loadUserFields();

		$("#user_exporttocsv").on("click", function () {
			exportTableToCSV('export.csv', 'usertable');
		});

		$("#roles").on("change", function () {

			$('#user_fields').chosen("destroy");
			$("#user_fields option").remove();

			loadUserFields();

		});

		$("#get_userdata").on("click", function () {

			let roles = $("#roles").val();
			let fields = $("#user_fields").val();

			$.ajax({
				method: 'POST',
				url: ajaxurl,
				data: {
					'action': 'getUserFieldsData',
					'user_role': roles,
					'user_fields': fields
				},
			}).done(function (resposta) {

				var obj = JSON.parse(resposta);

				// console.log(fields);
				// console.log(resposta);
				$("#user_header_result tr").remove();
				$("#user_body_result tr").remove();

				drawTable(obj, 'user_header_result', 'user_body_result');
				$(".table-width").show();


			}).error(function (err) {
				console.log(err);
			});

		});
	});

	function loadUserFields() {
		let userRole = $("#roles").val();
		$.ajax({
			method: 'POST',
			url: ajaxurl,
			data: {
				'action': 'getUserFields',
				'user_role': userRole
			},
		}).done(function (resposta) {

			let obj = JSON.parse(resposta);

			obj.forEach(element => {
				if (!element.startsWith("_") && element != 'user_pass') {
					$("#user_fields").append(
						"<option value=" + element + ">" + element + "</option>"
					);
				}
			});

			$("#user_fields").chosen({ width: '450px' });

		}).error(function (err) {

			console.log(err);

		});
	}

})(jQuery);