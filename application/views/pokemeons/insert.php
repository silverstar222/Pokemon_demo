<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Welcome to CodeIgniter</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div id="container" style="position: fixed; top: 40%; left: 45%; ">
    <h3>Insert Pokemons</h3>
    <button id="insertPokemons" class="btn btn-success btn-lg"><b>Insert Pokemons</b></button>
</div>
<div id="error" style="position: fixed; top: 40%; left: 30%; display: none; ">
    <h3>Something went wrong, please refresh the page and try again.</h3>
</div>

<div class="modal fade" id="insertingPokemons" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header-bg">
                <h5 class="modal-title" id="exampleModalLongTitle">INSERTING POKEMONS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div style="height: 200px; line-height: 200px; text-align: center;">
                    Please wait, reading pokemons.json and inserting pokemons to database...
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('#insertPokemons').click(function () {
            $.ajax({
                url: "<?= base_url() ?>index.php/pokemons/insert",
                type: "POST",
                dataType: "json",
                beforeSend:function(){$('#insertingPokemons').modal('show');},
                success: function (response) {
                    if (response.status == "done") {
                        window.location.reload();
                    } else {
                        $('#container').hide();
                        $('#error').fadeIn();
                    }

                    $('#insertingPokemons').modal('hide');
                },
                error: function (jqXHR, exception) {
                    $('#container').hide();
                    $('#error').fadeIn();
                    $('#insertingPokemons').modal('hide');
                }

            });
        });
    });

</script>
</body>
</html>