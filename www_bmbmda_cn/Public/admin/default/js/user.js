function checkForm()
  {
      var name = $('#name');
      var password = $('#password');
      var reg =  /^[^_]\w{5,15}$/;
      if(name.val() == '')
      {
        name.next('.input-group-addon').html('<i class="fa  fa-close"></i>');
        return false;
      }
      // alert(reg.exec(password.val()));
      if(password.val() == '' || !reg.exec(password.val()))
      {
        password.next('.input-group-addon').html('<i class="fa  fa-close"></i>');
        return false;
      }
      return true;
  }
$('#name').focus(function(){
    $('#name').next('.input-group-addon').html('<i class="fa  fa-pencil"></i>');
  });

  $('#password').focus(function(){
    $('#password').next('.input-group-addon').html('<i class="fa  fa-pencil"></i>');
  });
   $('#password').keyup(function(){
    var reg =  /^[^_]\w{5,15}$/;//字母，下划线，数字，不以下划线开始
    if(reg.exec($('#password').val()))
    {
      $('#password').next('.input-group-addon').html('<i class="fa  fa-check"></i>');
      return true;
    }else{
      if($('#password').val().length>5)
      {
        $('#password').next('.input-group-addon').html('<i class="fa  fa-close"></i>');
      }else{
        $('#password').next('.input-group-addon').html('<i class="fa  fa-pencil"></i>');
      }
    }

   });