
// preview wizard function
$('.input').keyup(function(){
   var $this = $(this);
   $('.'+$this.attr('id')+'').html($this.val());
});

$(document).on('change','.classprev',function(){
    var countr = $('.classprev option:selected').html();
    $('.classp').html(countr);
       
});


$(document).on('change','.groupPrev',function(){
    var countres = $('.groupPrev option:selected').html();
    $('.gid').html(countres);
       
});

$(document).on('change','.sectionPrev',function(){
    var sctn = $('.sectionPrev option:selected').html();
    $('.sid').html(sctn);
       
});

$(document).on('change','.shiftPrev',function(){
    var shftp = $('.shiftPrev option:selected').html();
    $('.shid').html(shftp);
       
});

$(document).on('change','.countryPrev',function(){
    var countP = $('.countryPrev option:selected').html();
    $('.countrid').html(countP);
       
});

$(document).on('change','.provincePrev',function(){
    var provnc = $('.provincePrev option:selected').html();
    $('.provinceid').html(provnc);
       
});

$(document).on('change','.districtPrev',function(){
    var distrct = $('.districtPrev option:selected').html();
    $('.districtid').html(distrct);
       
});

$(document).on('change','.religionPrev',function(){
    var relgn = $('.religionPrev option:selected').html();
    $('.religionid').html(relgn);
       
});

$(document).on('change','.cityPrev',function(){
    var cityp = $('.cityPrev option:selected').html();
    $('.cityid').html(cityp);
       
});

$(document).on('change','.degreePrev',function(){
    var degree = $('.degreePrev option:selected').html();
    $('.degreeid').html(degree);
       
});

$(document).on('change','.proffessionPrev',function(){
    var profesion = $('.proffessionPrev option:selected').html();
    $('.professionid').html(profesion);
       
});

$(document).on('change','.motherProf',function(){
    var motherP = $('.motherProf option:selected').html();
    $('.motherpid').html(motherP);
       
});

$(document).on('change','.zonePrev',function(){
    var zonep = $('.zonePrev option:selected').html();
    $('.zoneid').html(zonep);
       
});

$(document).on('change','.routePrev',function(){
    var routeP = $('.routePrev option:selected').html();
    $('.routeid').html(routeP);
       
});

$(document).on('change','.stopPrev',function(){
    var stopp = $('.zonePrev option:selected').html();
    $('.stopid').html(stopp);
       
});

$(document).on('change','.hostelPrev',function(){
    var hstl = $('.hostelPrev option:selected').html();
    $('.hostelid').html(hstl);
       
});

$(document).on('change','.floorPrev',function(){
    var florr = $('.floorPrev option:selected').html();
    $('.floorid').html(florr);
       
});

$(document).on('change','.roomPrev',function(){
    var hstlroom = $('.roomPrev option:selected').html();
    $('.roomid').html(hstlroom);
       
});

$(document).on('change','.bedPrev',function(){
    var beds = $('.bedPrev option:selected').html();
    $('.bedid').html(beds);
       
});



$(document).on('click','.inputes',function(){
 var $this = $(this);

   $('.'+$this.attr('id')+'').html($this.val());
});


//end of preview wizard function 