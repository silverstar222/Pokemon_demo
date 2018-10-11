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
    <script src="<?= base_url() ?>assets/js/jquery.tmpl.js"></script>
</head>
<body>

<div id="container">
    <div class="row">
        <div class="col-lg-3">&nbsp;</div>
        <div class="col-lg-4">
            <h2>Pokemon List Page</h2><br/>
            <h4>Search Pokemon</h4>
            <form action="javascript:void(0);">
                <input type="text" name="search_key" id="searchKey" value="" placeholder="Search Pokemon..."
                       class="form-control"
            </form>
        </div>
        <div class="col-lg-2">
            <img src="<?= base_url() ?>assets/img/loader.gif" id="searchLoader" height="40"
                 style="margin-top: 116px; display: none;">
        </div>
        <div class="col-lg-3"><button id="clearPokemons" class="btn btn-danger btn-lg" style="margin-top: 20px;"><b>Clear Pokemons</b></button></div>
    </div>
    <br/>
    <div class="row" id="searchResults">
        <div class="col-lg-3">&nbsp;</div>
        <div class="col-lg-6">
            <table class="table">
                <thead>
                <tr>
                    <th>Pokemon</th>
                    <th>Types</th>
                </tr>
                </thead>
                <tbody id="searchedRows">
                <?php foreach ($pokemons as $i => $p) { ?>
                    <tr>
                        <td><?= $p['name'] ?></td>
                        <td><?= implode(", ", $p['types']) ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="col-lg-3">&nbsp;</div>
    </div>
    <div class="row" id="noRecordFound" style="display: none;">
        <div class="col-lg-3">&nbsp;</div>
        <div class="col-lg-6">
            <h3>No Record Found</h3>
        </div>
        <div class="col-lg-3">&nbsp;</div>
    </div>
</div>
<template id="rowTmpl">
    <tr>
        <td>${name}</td>
        <td>{%if types.length %} ${types.join(", ")}{%else%}&nbsp; {%/if%}</td>
    </tr>
</template>
<script>
    $(function () {
        var xhr = null;
        $('#searchKey').keyup(function () {
            if (xhr != null) {
                xhr.abort();
            }
            xhr = $.ajax({
                url: "<?= base_url() ?>index.php/pokemons/search",
                type: "POST",
                data: {key: $(this).val()},
                dataType: "json",
                beforeSend: function () {
                    $("#searchedRows").html('');
                    $('#searchLoader').show();
                    $('#searchResults, #noRecordFound').hide();
                },
                success: function (response) {
                    if (response.length) {
                        $.template("rowTmpl", $('#rowTmpl').html());
                        $.tmpl("rowTmpl", response).appendTo("#searchedRows");
                        $('#searchResults').fadeIn();
                    } else {
                        $('#noRecordFound').fadeIn();
                    }

                    $('#searchLoader').fadeOut();
                    xhr = null;
                },
                error: function (jqXHR, exception) {
                    console.log('Something went wrong, check it');
                }

            });

        });


        $('#clearPokemons').click(function () {
            $.ajax({
                url: "<?= base_url() ?>index.php/pokemons/clear",
                type: "POST",
                dataType: "json",
                success: function (response) {
                    window.location.reload();
                }
            });
        });
    });

</script>
</body>
</html>