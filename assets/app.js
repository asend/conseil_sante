import "./styles/app.scss";
import "datatables.net";
import "datatables.net-bs4";
import "bootstrap";
import "bootstrap-datepicker";
import "./js/datepicker";
$(function() {
    $('#cadre').change(function(e) {
        //alert(e.target.value)
        var id = e.target.value;
        $('#corps').empty();
        // Request the neighborhoods of the selected city.
        $.ajax({
            url: "/cadre/corps/" + id,
            type: "GET",
            dataType: "JSON",
            data: {
                //id: id
            },
            success: function(neighborhoods) {
                $('#corps').append('<option value="">--Corps--</option>');
                $.each(neighborhoods, function(key, neighborhood) {
                    //alert(neighborhood.name);
                    $('#corps').append('<option value="' + neighborhood.id + '">' + neighborhood.name + '</option>');
                });
            },
            error: function(err) {
                $('#corps').empty();
                $('#corps').append('<option value="">--Corps--</option>');
                //alert("An error ocurred while loading data ...");
            }
        });
    });
});
$("#datatable").DataTable();
$(".js-datepicker").datepicker({
    format: "dd-mm-yyyy",
});
$(".js-datepicker-years").datepicker({
    format: "yyyy",
    viewMode: "years",
    minViewMode: "years",
    autoclose: true, //to close picker once year is selected
});

//import $ from 'jquery';
require("select2");
$("select").select2();

// $(document).ready(function() {
$("#q2").hide();
$("#r_questionnaire_q2autre").hide();
$("#datecessation").hide();
$("#datesuspension").hide();
$("#questionnaire_q1_0").click(function() {
    $("#q2").show();
    $("#r_questionnaire_q2autre").show();
});
$("#questionnaire_q1_1").click(function() {
    //questionnaire[q2][]
    $("#q2").hide();
    $("#r_questionnaire_q2autre").hide();
});
if ($("#questionnaire_q1_0").is(":checked")) {
    $("#q2").show();
    $("#r_questionnaire_q2autre").show();
}
$("#questionnaire_q3_1").click(function() {
    $("#datecessation").show();
});
$("#questionnaire_q3_0").click(function() {
    $("#datecessation").hide();
});
if ($("#questionnaire_q3_1").is(":checked")) {
    $("#datecessation").show();
}

$("#questionnaire_q4_1").click(function() {
    $("#datesuspension").show();
});
$("#questionnaire_q4_0").click(function() {
    $("#datesuspension").hide();
});
if ($("#questionnaire_q4_1").is(":checked")) {
    $("#datesuspension").show();
}

if ($("#questionnaire_q8_3").is(":checked")) {
    $("#questionnaire_lieu_de_rapprochement").show();
}
//questionnaire_q4_1
//alert(document.getElementById("questionnaire_q3_1").value);
$("#examen").hide();
$("#expertise").hide();
$("#certificat_examen_0").change(function() {
    $("#examen").show();
})
$("#certificat_examen_1").change(function() {
    $("#examen").hide();
})

$("#certificat_expertise_0").change(function() {
    $("#expertise").show();
})
$("#certificat_expertise_1").change(function() {
    $("#expertise").hide();
})





var $patient_cadre = $("#patient_cadre");
var $token = $("#patient_token");
$patient_cadre.change(function() {
    var $form = $(this).closest("form");
    var data = {};
    data[$token.attr("name")] = $token.val();
    data[$patient_cadre.attr("name")] = $patient_cadre.val();
    $.post($form.attr("action").data).then(function(response) {
        $("#patient_corps").replaceWith($(response).find("#patient_corps"));
    });
});