// (function($){

//     $(document).ready(function() {

//         /**
//          * On the addon page ttry and activate an addon using ajax so that
//          * it's sanboxed.
//          */
//         $('.toggle-addon').click(function(e){
//             console.log('toggle click');
//             e.preventDefault();
//             let href = $(location).attr('href');
//             let delim = href.substring('?') > 0 ? '&' : '&';
//             $.ajax({
//                 type : "post",
//                 dataType : "json",
//                 url : fofobec_addon.ajaxurl,
//                 data : {action: "fofo_bec_toggle_addon", addon_name : $(this).attr('data-addon_name'), nonce: $(this).attr('data-nonce') },
//                 success: function(response) {
//                    if(response == "success") {
                        
//                         $(location).attr('href', href);
//                    }                   
//                 },
//                 error : function(jqXHR, textStatus, errorThrown){
//                     $(location).attr('href',href + delim + 'activate_result=problem_activating_addon');
//                 }
//              });
//         });

//     });

// })(jQuery);