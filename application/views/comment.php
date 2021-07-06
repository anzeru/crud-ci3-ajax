<!DOCTYPE html>
<html>

<head>
    <title>Notification using PHP Ajax Bootstrap</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
    <br /><br />
    <div class="container">
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">PHP Notification Tutorial</a>
                </div>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count" style="border-radius:10px;"></span> <span class="glyphicon glyphicon-bell" style="font-size:18px;"></span></a>
                        <ul class="dropdown-menu"></ul>
                    </li>
                </ul>
            </div>
        </nav>
        <br />
        <form method="post" id="comment_form">
            <div class="form-group">
                <label>Enter Name</label>
                <input type="text" name="comment_name" id="comment_name" class="form-control">
                <?= form_error('comment_name', '<small class="text-danger pl-3">', '</small>'); ?>
            </div>
            <div class="form-group">
                <label>Enter Comment</label>
                <textarea name="comment_content" id="comment_content" class="form-control" rows="5"></textarea>
                <?= form_error('comment_content', '<small class="text-danger pl-3">', '</small>'); ?>
            </div>
            <div class="form-group">

                <input type="hidden" name="comment_id" id="comment_id" value="0" />
                <input type="submit" name="submit" id="submit" class="btn btn-info" value="Submit" />
            </div>
        </form>
        <span id="comment_message"></span>
        <br />
        <div id="display_comment"></div>
    </div>
</body>

</html>

<script>
    $(document).ready(function() {
        // updating the view with notifications using ajax
        // jika notif belum dilihat
        // function load_unseen_notification(view = '') // utk line 51,
        // {
        //     $.ajax({
        //         url: "fetch.php",
        //         method: "POST",
        //         data: {
        //             views: view
        //         }, // variable views diisi view dan kirim ke fetch.php dengan metode post 
        //         dataType: "json",
        //         success: function(data) {
        //             $('.dropdown-menu').html(data.notifications);
        //             if (data.unseen_notification > 0) // jika ada notif yang belum dilihat
        //             {
        //                 $('.count').html(data.unseen_notification);
        //             }
        //         }
        //     });
        // }
        // load_unseen_notification();
        // submit form and get new records
        $('#comment_form').on('submit', function(event) {
            event.preventDefault();
            if ($('#comment_name').val() != '' && $('#comment_content').val() != '') {
                var form_data = $(this).serialize();
                $.ajax({
                    url: "<?= base_url('comment/addComment') ?>",
                    method: "POST",
                    data: form_data,
                    success: function(data) {
                        if (data.error != '') {
                            $('#comment_form')[0].reset();
                            $('#comment_message').html(data.error);
                            $('#comment_id').val('0');
                            // load_comment();
                            // load_unseen_notification();
                        }
                    }
                    // success: function(data) {
                    //     $('#comment_form')[0].reset();
                    //     $('#comment_message').html(data.error);
                    //     $('#comment_id').val('0');
                    //     // load_comment();
                    //     // load_unseen_notification();
                    // }
                });
            }
            // else {
            //     alert("Both Fields are Required");
            // }
        });
        // load new notifications
        // $(document).on('click', '.dropdown-toggle', function() {
        //     $('.count').html('');
        //     load_unseen_notification('yes');
        // });
        // setInterval(function() {
        //     load_unseen_notification();;
        // }, 5000);

        // load_comment();

        // function load_comment() {
        //     $.ajax({
        //         url: "fetch_comment.php",
        //         method: "POST",
        //         success: function(data) {
        //             $('#display_comment').html(data);
        //         }
        //     })
        // }

        // $(document).on('click', '.reply', function() {
        //     var comment_id = $(this).attr("id");
        //     $('#comment_id').val(comment_id);
        //     $('#comment_name').focus();
        // });

    });
</script>