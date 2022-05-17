// (function ($) {
// 	"use strict";
$('.add_new_row').on('click',function(){
    var id= $(this).data('id');
    $('#row_id').val(id);
 });

 $('.option_delete').on('click',function(){
    var id= $(this).data('id');
    Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, Do It!'
      }).then((result) => {
          if (result.value == true) {
              $('#option_id').val(id);
          $('.option'+id).remove();
          $('.delete_from').submit();
          }
      })
 });
 
 $('.row_update_form').on('submit',function() {
    var name=$('#edit_name').val();
    var id=$('#edit_id').val();
    $('#option_name'+id).text(name);
 });

 
// })(jQuery);