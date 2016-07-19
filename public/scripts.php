<!--Core js-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.smooth-scroll.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/jquery.nicescroll.min.js"></script>
<script src="js/jquery.countdown.min.js"></script>
<!--common script init for all pages-->
<script src="js/script.js"></script>
<script>
    /* ==============================================
     Ajax Submiting For Email Subscriber Form.
     =====================================================================*/
    $("#subscriber_form").submit(function(e)
    {
        $('#show_subscriber_msg').html('<div class=gen>Submiting..</div>');
        var subscriberemail = $('#subscriberemail').val();
        var formURL = $(this).attr("action");
        var data = {
            subscriberemail:subscriberemail
        }
        $.ajax(
            {
                url : formURL,
                type: "POST",
                data : data,

                success: function (res) {
                    if(res=='1'){
                        $('#show_subscriber_msg').html('<div class=gen>Thank you very much, We will notify you when we lunch</div>');
                    }

                    if(res=='5'){
                        $('#show_subscriber_msg').html('<div class=err>Please enter a valid email address</div>');
                    }
                }
            });
        e.preventDefault();	//STOP default action
    });
    /* ==============================================
     Ajax Submiting For Email Contact Form.
     =====================================================================*/
    $("#contact_form").submit(function(e)
    {
        $('#show_contact_msg').html('<div class=gen>Submiting..</div>');
        var username = $('#contact_name').val();
        var useremail = $('#contact_email').val();
        var commenttext = $('#contact_text').val();
        var formURL = $(this).attr("action");
        var data = {
            username:username,
            useremail:useremail,
            commenttext:commenttext,
        }
        $.ajax(
            {
                url : formURL,
                type: "POST",
                data : data,

                success: function (res) {
                    if(res=='1'){
                        $('#show_contact_msg').html('<div class=gen>Thank you very much, We will notify you when we lunch</div>');
                    }

                    if(res=='5'){
                        $('#show_contact_msg').html('<div class=err>Please enter a valid email address</div>');
                    }
                }
            });
        e.preventDefault();	//STOP default action
    });
</script>