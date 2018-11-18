$(document).ready(function() {
	$("#ingredients").keyup(function() {
		if($("#ingredients").val().length == 0 && $("#search").val().length == 0) {
			$("#subsearch").prop("disabled", true);
		} else {
			$("#subsearch").prop("disabled", false);
		}
	});

	$("#search").keyup(function() {
		if($("#ingredients").val().length == 0 && $("#search").val().length == 0) {
			$("#subsearch").prop("disabled", true);
		} else {
			$("#subsearch").prop("disabled", false);
		}
	});

	if($("#ingredients").val().length > 0 || $("#search").val().length > 0) {
		$("#subsearch").prop("disabled", false);
	}
});