$(document).ready(function(){
  $("#playerform").validate({
    rules: {
      name: {
        required: true
      },
      points: {
        required: true,
        number: true
      }
    }
  });
  $("#submitplayer").click(function(){
    if($("#playerform").valid()){
      var name = $("#name").val();
      var points = $("#points").val();
      var dataset = {'name': name, 'points': points};
    	$.ajax({
    		type: "POST",
    		url: "add_player.php",
    		data: dataset,
    		success: function(data){
            $("#playerstable").append('<tr id="yes" style="background-color: #FFEC8B;"><td class="name">'+name+'</td><td class="points">'+points+'</td><td class="def"><a href="" class="defa" id="'+data+'" ><img src="images/checkgr.gif" /></a></td><td class="del"><a href="" class="dela" id="'+data+'" >Delete?</a></td></tr>');
            $('#'+data).parents('tr').animate({backgroundColor: "white"},1000);
    	  }
    	});
    	$('#name').val('');
      $('#points').val('');
      $('#name').focus();
    }
    return false;
  });
  $(".defa").live("click",function(){
    var id = $(this).attr("id");
    var changer = $(this).contents().attr("src");
    if(changer == 'images/check.gif'){
      abismark = 0;
      gobbledygook = 'checkgr.gif';
    }
    else{
      abismark = 1;
      gobbledygook = 'check.gif';
    }
    var dataset = {'id': id,'change': abismark};
  	$.ajax({
  		type: "POST",
  		url: "definite_player.php",
  		data: dataset,
  		success: function(){
          $("#"+id+' img').attr("src",'images/'+gobbledygook);
   			}
  	});
  	return false;
  });  
  
  $(".dela").live("click",function(){
    var id = $(this).attr("id");
    var dataset = {'id': id};
  	$.ajax({
  		type: "POST",
  		url: "delete_player.php",
  		data: dataset,
  		success: function(){
          $("#"+id).parents('tr').fadeOut("fast",function(){$(this).remove();});
   			}
  	});	
  	return false;
  });
});