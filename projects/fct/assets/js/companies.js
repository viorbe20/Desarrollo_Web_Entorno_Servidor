function deleteCompany(companyId) {
    $('#delete_message').append('Se ha eliminado la empresa con id ' + companyId);
    $("#modal_delete_company").css("display", "block");
}

function showAllCompanies() {
    $tableBody.empty();
    fetch(
        "http://localhost/dwes/projects/fct/public/index.php/companies_table"
    )
        .then((response) => response.json())
        .then((data) => {
            for (let i = 0; i < $shownCompanies; i++) {
                $("#table_body_companies").append(
                    `<tr>
                                <td><img src="http://localhost/dwes/projects/fct/assets/img/logos/${data[i]["c_logo"]}" alt='Logo de la empresa' width='50px' height='50px'></td>
                                <td>${data[i]["c_name"]}</td>
                                <td>${data[i]["c_phone"]}</td>
                                <td>
                <a href="http://localhost/dwes/projects/fct/public/index.php/companies/company_employees/${data[i]["c_id"]}">
                <span class="material-symbols-outlined">group</span></a>
                </td>
                <td>
                <a href="#" target="_self" onclick="deleteCompany(${data[i]["c_id"]})">
                <span class="material-symbols-outlined" id="company_delete_icon_${data[i]['c_id']}">
                delete
                </span></a>
                <a href="http://localhost/dwes/projects/fct/public/index.php/home/edit_company/${data[i]["c_id"]} class="company_href"">
                <span class="material-symbols-outlined">edit</span></a>
                </td>
                </tr>`
                );
            }
        }
        )
}

function showMatchingCompanies() {
    $tableBody.empty();
    fetch(
        "http://localhost/dwes/projects/fct/public/index.php/companies_table"
    )
        .then((response) => response.json())
        .then((data) => {
            let query = $inputSearch.val().toLowerCase();
            let filteredCompanies = data.filter(function (company) {
                return company.c_name.toLowerCase().indexOf(query) > -1;
            });

            filteredCompanies.forEach(function (company) {
                $tableBody.append(
                    `<tr>
                            <td><img src="http://localhost/dwes/projects/fct/assets/img/logos/${company["c_logo"]}" alt='Logo de la empresa' width='50px' height='50px'></td>
                            <td>${company["c_name"]}</td>
                            <td>${company["c_phone"]}</td>
                            <td>
                            <a href="http://localhost/dwes/projects/fct/public/index.php/companies/company_employees/${company["c_id"]}">
                            <span class="material-symbols-outlined">group</span></a>
                            </td>
                            <td>
                            <a href="#" target="_self" onclick="deleteCompany(${company["c_id"]})">
                            <span class="material-symbols-outlined" id="company_delete_icon_${company['c_id']}">
                            delete
                            </span></a>
                            <a href="http://localhost/dwes/projects/fct/public/index.php/home/edit_company/${company["c_id"]} class="company_href"">
                            <span class="material-symbols-outlined">edit</span></a>
                        </tr>`
                );
            });
        }
        )
}

$(document).ready(function () {

    console.log('companies.js loaded');

    $inputSearch = $('#input_search_company');
    $shownCompanies = 5;
    $tableBody = $('#table_body_companies');

    showAllCompanies();

    $inputSearch.on('keyup', function () {
        if (($inputSearch.val() == '') || ($inputSearch.val().indexOf(' ') > -1)) {
            showAllCompanies();
        } else { //If $inputsearch has value, show the companies that match with the input value
            showMatchingCompanies();
        }
    });


    /**
    * Modal delete company
    * Click on X button
    */
    $("#modal_delete_company #span_modal_exit").click(function () {
        $("#modal_delete_company").css("display", "none");
    });

    /**
     * Modal delete company
     * Click on close button, close modal.
     */
    $("#modal_delete_company #btn_modal_exit").click(function () {
        $("#modal_delete_company").css("display", "none");
        window.location.href =
            "http://localhost/dwes/projects/fct/public/index.php/companies";
    });

    /**
     * Modal delete company
     * Click on create another company
     */
    $("#modal_delete_company #btn_modal_reload").click(function () {
        $("#modal_delete_company").css("display", "none");
        window.location.reload();
    });
});
