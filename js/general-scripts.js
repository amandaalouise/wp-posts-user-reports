(function ($) {

	$(document).ready(function () {

		$(document).on('click', '.nav-tab-wrapper a', function () {
			$('section').hide();
			$('section').eq($(this).index()).show();
			return false;
		});
	});

	window.downloadCSV = function (csv, filename) {
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

	window.exportTableToCSV = function (filename, selector) {
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

	window.drawTable = function (data, header_id, body_id) {

		drawHeader(data[0], header_id);

		for (var i = 0; i < data.length; i++) {
			drawRow(data[i], body_id);
		}
	}

	window.drawRow = function (rowData, body_id) {
		var row = $("<tr />")
		$("#" + body_id).append(row); //this will append tr element to table... keep its reference for a while since we will add cels into it
		$.each(rowData, function (key, value) {
			row.append($("<td>" + value + "</td>"));
		});
	}

	window.drawHeader = function (rowData, header_id) {
		var row = $("<tr />")
		$("#" + header_id).append(row);
		$.each(rowData, function (key, value) {
			row.append($("<th>" + key + "</th>"));
		});
	}


})(jQuery);