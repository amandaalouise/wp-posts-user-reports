
(function ($) {

	$(document).ready(function () {

		$('#post_types').val('post');
		loadOptions();

		$(".table-width").hide();

		$(document).on('click', '.nav-tab-wrapper a', function () {
			$('section').hide();
			$('section').eq($(this).index()).show();
			return false;
		});

		$("#exporttocsv").on("click", function () {
			exportTableToCSV('export.csv', 'flextable');
		})

		$("#post_types").on("change", function () {
			loadOptions();
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

		$("#post_types").chosen({ width: '450px' });

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

				drawTable(obj);
				$(".table-width").show();


			}).error(function (err) {
				console.log(err);
			});

		});


		function downloadCSV(csv, filename) {
			var csvFile;
			var downloadLink;

			// CSV file
			csvFile = new Blob([csv], { type: "text/csv" });

			// Download link
			downloadLink = document.createElement("a");

			// File name
			downloadLink.download = filename;

			// Create a link to the file
			downloadLink.href = window.URL.createObjectURL(csvFile);

			// Hide download link
			downloadLink.style.display = "none";

			// Add the link to DOM
			document.body.appendChild(downloadLink);

			// Click download link
			downloadLink.click();
		}

		function exportTableToCSV(filename, selector) {
			var csv = [];
			var rows = document.querySelectorAll("table#" + selector + " tr");

			for (var i = 0; i < rows.length; i++) {
				var row = [], cols = rows[i].querySelectorAll("td, th");

				for (var j = 0; j < cols.length; j++)
					row.push(cols[j].innerText);

				csv.push(row.join(";"));
			}

			console.log(csv);

			// Download CSV file
			downloadCSV(csv.join("\n"), filename);
		}

		function drawTable(data) {

			drawHeader(data[0]);

			for (var i = 0; i < data.length; i++) {
				drawRow(data[i]);
			}
		}

		function drawRow(rowData) {
			var row = $("<tr />")
			$("#body_result").append(row); //this will append tr element to table... keep its reference for a while since we will add cels into it
			$.each(rowData, function (key, value) {
				row.append($("<td>" + value + "</td>"));
			});
		}

		function drawHeader(rowData) {
			var row = $("<tr />")
			$("#header_result").append(row);
			$.each(rowData, function (key, value) {
				row.append($("<th>" + key + "</th>"));
			});
		}


	});

})(jQuery);