
$(function(){$(document).ready(function(){var dropMenuId=document.getElementById('mmenu-user');if(dropMenuId){function dropDownMenu(){var dropCont=$(dropMenuId+'> #mmenu-user-content');$(dropMenuId).hover(function(){dropCont.addClass('active').fadeIn(300);},function(){dropCont.removeClass('active').fadeOut();})}
dropDownMenu();}});});