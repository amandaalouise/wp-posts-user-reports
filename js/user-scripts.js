
(function ($) {

	$(document).ready(function () {

		$("#roles").chosen({ width: '450px' });
		$('#roles').val('administrator');
		loadUserFields();

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
				console.log(resposta);

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

		$("#roles").on("change", function () {

			$('#user_fields').chosen("destroy");
			$("#user_fields option").remove();

			loadUserFields();

		})

	});

})(jQuery);