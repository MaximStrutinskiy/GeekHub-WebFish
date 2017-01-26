$(function () {
	$(document).ready(function () {


		//drop down menu
		var dropMenuId = document.getElementById('mmenu-user');
		if (dropMenuId) {
			function dropDownMenu() {
				// var dropButton = $('#mmenu-user');
				var dropContent = $('#mmenu-user > #mmenu-user-content');
				$('#mmenu-user').hover(
					function () {
						dropContent.addClass('active').stop(true, true).fadeIn(300);
					},
					function () {
						dropContent.removeClass('active').stop(true, true).fadeOut();
					}
				)
			}

			dropDownMenu();
		}

	});
});
