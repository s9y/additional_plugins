$(function() {  
  $('#browserid').click(function() {  
    navigator.id.get(gotAssertion);  
    return false;  
  });  
});
