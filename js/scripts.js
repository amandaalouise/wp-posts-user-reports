
(function ($) {

	$(document).ready(function () {

		$('#post_types').val('post');
		loadOptions();

		$(".table-width").hide();

		$("#exporttocsv").on("click", function () {
			exportTableToCSV('export.csv', 'flextable');
		});

		$("#post_types").chosen({ width: '450px' });

		$("#post_types").on("change", function () {
			loadOptions();
		});

		$("#get_data").on("click", function () {

			let posttype = $("#post_types").val();
			let fields = $("#fields").val();

			$.ajax({
				method: 'POST',
				url: ajaxurl,
				data: {
					'action': 'getFieldsData',
					'post_type': posttype,
					'post_fields': fields
				},
			}).done(function (resposta) {

				var obj = JSON.parse(resposta);

				$("#header_result tr").remove();
				$("#body_result tr").remove();

				drawTable(obj, 'header_result', 'body_result');
				$(".table-width").show();


			}).error(function (err) {
				console.log(err);
			});

		});
	});

	function loadFields(id) {
		$.ajax({
			method: 'POST',
			url: ajaxurl,
			data: {
				'action': 'loadfields',
				'post_id': id
			},
		}).done(function (resposta) {

			var obj = JSON.parse(resposta);

			obj.forEach(element => {
				if (!element.startsWith("_")) {
					$("#fields").append(
						"<option value=" + element + ">" + element + "</option>"
					);
				}
			});

			$("#fields").chosen({ width: '450px' });

		}).error(function (err) {

			console.log(err);

		});
	}

	function loadOptions() {
		let posttype = $('#post_types').val();

		console.log("carregando campos");

		$('#fields').chosen("destroy");

		$.ajax({
			method: 'POST',
			url: ajaxurl,
			data: {
				'action': 'reportpost',
				'post_type': posttype
			},
		}).done(function (resposta) {

			var obj = JSON.parse(resposta);
			var postId = obj[0].ID;
			console.log(postId);

			loadFields(postId);


		}).error(function (err) {

			console.log(err);

		});
	}

})(jQuery);