function isValidEmail(email) {
    let regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    //^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$
    return regex.test(email);
}

function isValidPhoneNumber(phoneNumber) {
    let regex = /^(\+34|0034|34)?[6789]\d{8}$/;
    return regex.test(phoneNumber);
}

function isEmptyField(field) {
    if (field == "") {
        return true;
    } else {
        return false;
    }
}

$(document).ready(function () {

    $companyInputs = $("#card_company").find("input");

    // Empty fields validation
    $companyInputs.each(function () {
        $(this).prev().hide();

        $(this).blur(function () {

            $fieldValue = $.trim($(this).val());

            if (isEmptyField($fieldValue)) {
                $(this).prev().html("Este campo es obligatorio");
                $(this).prev().show();
            } else {
                $(this).prev().hide();

                // Phone number validation
                if ($(this).attr('id') == "c_phone") {
                    if (!isValidPhoneNumber($fieldValue)) {
                        $(this).prev().html("El teléfono no es válido");
                        $(this).prev().show();
                    } else {
                        $(this).prev().hide();
                        $(this).css("background-color", "#d4edda");
    
                    }
                }

                // Email validation
                if ($(this).attr('id') == "c_email") {
                    if (!isValidEmail($fieldValue)) {
                        $(this).prev().html("El email no es válido");
                        $(this).prev().show();
                    } else {
                        $(this).prev().hide();
                        $(this).css("background-color", "#d4edda");
    
                    }
                }
            }
        });
    });

    // Click on create company button
    $("#btn_create_company").click(function (e) {
        e.preventDefault();

        //All empty spans and full inputs validation
        $companySpans = $("#card_company").find("span").val() != "";
        $companyInputs = $("#card_company").find("input").val() == "";

        if (!$companySpans && !$companyInputs) {
            $("#modal_create_company").css("display", "block");
        } else {
            $("#card_company").find("span").each(function () {
                $(this).html("Este campo es obligatorio");
                $(this).show();
            });
        }

    });

    // Add employees option
    $("#btn_add_employee").click(function () {
        
        $class = $("#section_employees").attr("class");

        if ($class.indexOf("d-none") > -1) {
            $("#section_employees").removeClass("d-none");
        }

        // Clone new card
        $clone = $("#card_header").next().clone();

        //Get id for new card
        $lastId = $("#card_header").next().attr("id");
        $number = $lastId.split("_")[2];
        $idParsed = parseInt($number);
        $idParsed = $idParsed + 1;
        $newId = "card_employee_" + $idParsed.toString();
        $newCard = $clone.removeClass("d-none");
        $newCard.attr("id", $newId);
        $newCard.find("input").val(""); // Clear input values

        // Add new card
        $newCard.insertAfter("#card_header");

        //Delete an employee
        $deleteButtons = $(".delete_btn");

        $deleteButtons.each(function () {
            $(this).click(function () {
                $(this).parent().parent().remove();
            });
        });
    });

    // Search companies box
    $("#input_search_company").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#table_body_companies tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    fetch(
        "http://localhost/dwes/projects/fct_management/public/index.php/home/companies/getCompaniesTable"
    )
        .then((response) => response.json())
        .then((data) => {
            if ($("#input_search_company").length == 1) {
                data.forEach((element) => {
                    console.log(element["c_name"]);
                    $("#table_body_companies").append(
                        `<tr>
                <td><img src="http://localhost/dwes/projects/fct_management/assets/img/logos/${element["c_logo"]}" alt='Logo de la empresa' width='50px' height='50px'></td>
                <td>${element["c_name"]}</td>
                <td>${element["c_phone"]}</td>
                <td><a href="http://localhost/dwes/projects/fct_management/public/index.php//home/companies/company_profile/${element["c_id"]}"><span class="material-symbols-outlined">
                                group
                                </span></a></td>
                                <td><a href="http://localhost/dwes/projects/fct_management/public/index.php//home/companies/company_profile/${element["c_id"]}"><span class="material-symbols-outlined">
                            delete
                            </span></a><a href="http://localhost/dwes/projects/fct_management/public/index.php//home/companies/company_profile/${element["c_id"]}"><span class="material-symbols-outlined">
                        edit
                    </span></a></td>
            </tr>`
                    );
                });
            }
        });

    // When click on X, close the modal
    $("#span_modal_exit").click(function () {
        $("#modal_create_company").css("display", "none");
    });

    //When click on modal close button
    $("#btn_modal_exit").click(function () {
        $("#modal_create_company").css("display", "none");
        window.location.href =
            "http://localhost/dwes/projects/fct_management/public/index.php/home/companies";
    });

    //When click on create another company
    $("#btn_modal_reload").click(function () {
        $("#modal_create_company").css("display", "none");
        window.location.reload();
    });
});
