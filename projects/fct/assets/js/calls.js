$(document).ready(function () {

    console.log('calls.js loaded');

    // Add call, show modal for add call
    $('#btn_add_call').on('click', function () {
        $('#modal_add_call').css('display', 'block');
    });

    // Cancel modal add class
    $('#btn_modal_cancel_call').on('click', function () {
        $('#modal_add_call').css('display', 'none');
    });

    // Exit modal add class
    $('#btn_modal_exit_call').on('click', function () {
        $('#modal_add_call').css('display', 'none');
    });

    //Confirm modal add class
    $('#btn_modal_confirm_call').on('click', function () {
        $('#modal_add_call').css('display', 'none');

        // Send form values to php
        $('#form_add_call').addEeventListener('submit'), function (e) {
        e.preventDefault();
        }
    });

    /**
     * Search calls box
     */
    $("#input_search_call").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#table_body_calls tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    /**
     * Fetch to get all the calls
     */

    fetch(
        "http://localhost/dwes/projects/fct/public/index.php/calls_table"
    )
        .then((response) => response.json())
        .then((data) => {
            if ($("#input_search_call").length == 1) {
                data.forEach((element) => {
                    $("#table_body_calls").append(
                        `<tr>
                <td>${element["ayear_date"]}</td>
                <td>${element["term_name"]}</td>
                <td>
                <a href="http://localhost/dwes/projects/fct/public/index.php/calls/call_assignments/${element["call_id"]}">
                <span class="material-symbols-outlined">join_inner</span></a>
                </td>
            </tr>`
                    );
                });
            }
        });

});
