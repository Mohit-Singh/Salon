    $(document).ready(function() {
         
         var time = 1300;                             // Global duration
         var easing = 'easeOutBounce';                 // Global jQuery Easing Effect
                 
         // Adds a hover class to the active element
 
             $('ul#formMenu li').click(function() {
                 $('ul#formMenu li').removeClass('active');
                     $(this).addClass('active');
             });
 
         // Show the Client Form on page load, always
     
             $("#client").slideDown(time, easing)
                 
         // Effects when browsing through the Form
                 
             $("a.admin").hover(function() {
                 $("#admin").slideDown(time, easing);
                 $("#client, #visitor, #contact, #requestAccount, #forgotPassword").slideUp(time, easing);
             return false
             });
             
             $("a.client").hover(function() {
                 $("#client").slideDown(time, easing);
                 $("#admin, #visitor, #contact, #requestAccount, #forgotPassword").slideUp(time, easing);
             return false
             });
             
             $("a.requestAccount").click(function() {
                 $("#requestAccount").slideDown(time, easing);
                 $("#admin, #client, #visitor, #contact, #forgotPassword").slideUp(time, easing);
             return false
             });
             
             $("a.forgotPassword").click(function() {
                 $("#forgotPassword").slideDown(time, easing);
                 $("#admin, #client, #visitor, #contact, #requestAccount").slideUp(time, easing);
             return false
             });
             
             $("a.visitor").hover(function() {
                 $("#visitor").slideDown(time, easing);
                 $("#admin, #client, #contact, #requestAccount, #forgotPassword").slideUp(time, easing);
             return false
             });
             
             $("a.contact").click(function() {
                 $("#contact").slideDown(time, easing);
                 $("#admin, #client, #visitor, #requestAccount, #forgotPassword").slideUp(time, easing);
             return false
             });
     });