function checkfile(sender) {
    var validExts = new Array(".xlsx", ".xls");
    var fileExt = sender.value;
    fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
    if (validExts.indexOf(fileExt) < 0) {
      alert("Invalid file selected, valid files are of " +
               validExts.toString() + " types.");
      return false;
    }
    else return true;
}

//ADD THIS PIECE OF CODE IN YOUR JS OR HTML PAGE UNDER SCRIPT
$(window).load(function(){
//uncomment the code below to hide the loading screen in response to window on load
  $(".loading").hide();
});

$(document).ready(function() {
  $('#btn_import_data').on('click', function() {
    const selectedFile = document.getElementById('uploadexcelform-file').files[0];
    if(!selectedFile)
      return;
      
    $(".loading").show();
  });


  var success_flag = $('#success_flag').val();
  if(success_flag == '1'){
    $('#msg_modal .alert-error').css('display', 'none');
    $('#msg_modal').modal();
  }
  if(success_flag == '2'){
    $('#msg_modal .alert-success').css('display', 'none');
    $('#msg_modal').modal();
  }
});