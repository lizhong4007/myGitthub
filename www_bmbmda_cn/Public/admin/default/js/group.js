function checkForm()
{
    var name = $('#name');
    if(name.val() == '')
    {
      name.next('.input-group-addon').html('<i class="fa  fa-close"></i>');
      return false;
    }
    return true;
}
$('#name').focus(function(){
  $('#name').next('.input-group-addon').html('<i class="fa  fa-pencil"></i>');
});
//check All
$("#checkAlls").on('ifChecked',function () {
 if ($(this).is(':checked') == true) { 
    $(":checkbox").each(function () {
        $(this).prop("checked", true);
        $(this).parent("div").addClass("checked");
        });
    }
});
//not check All
$("#checkAlls").on('ifUnchecked',function () {
   if ($(this).is(':checked') == false) { 
       $(":checkbox").each(function () {
           $(this).prop("checked", false);
           $(this).parent("div").removeClass("checked");
           });
        }
});
