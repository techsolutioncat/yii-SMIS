// Projct : Management Information System
// file: mashal.js
// Developer: Figar Ali (figarali.com)
// Version: 1.0
 
//Figar JS
$(document).ready(function(){

//Add Exam
$("#add_exam").click(function(){
	$("#subject-wrap").addClass("hide");
	$("h1.p_title").addClass("out");
	$(".subject-dd").addClass("in");
	$("#close_exam_d").removeClass("hide").addClass("show");
	$("#add_exam").removeClass("show").addClass("hide");
});
$("#close_exam_d").click(function(){ 
	$("#subject-wrap").removeClass("hide");
	$("h1.p_title").removeClass("out");
	$(".subject-dd").removeClass("in");
	$("#close_exam_d").removeClass("show").addClass("hide");
	$("#add_exam").removeClass("hide").addClass("show");
});
//Student Profile Popup 
$("#attendance-detail").click(function(){
	$("#attendance-pop").toggle('blind');
	$(".container-wrap").addClass("open"); 
});
$("#close-detail").click(function(){
	$("#attendance-pop").toggle('blind');
	$(".container-wrap").removeClass("open");  
}); 
	
//Navigation Menu
/*$(".nav_inn li.dropdown").hover(function () {
	//$(".overlay-menu").toggle("blind");
	//$(this).toggleClass("hover");
	//$(this).children('.dropdown-menu').toggle();
});*/

//fixed navigation on scroll 
$(window).scroll(function(){
  var sticky = $('.header-in'), scroll = $(window).scrollTop(); 
  var wrap = $('.wrap');
  if (scroll >= 58){
	 sticky.addClass('fix-nav');
	 wrap.addClass('adpading');
  }
  else
  {
    sticky.removeClass('fix-nav');
	wrap.removeClass('adpading');  
  }
});

//defult tabs
$(".nav-tabs a").click(function(){
	$(this).tab('show');
});

//Custom SCroller
$(window).on("load",function(){
	$(".cscroll").mCustomScrollbar({theme:"minimal-dark"});
});




});
