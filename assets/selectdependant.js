//var id = "{{ demandeur.emploi.id}}";
$(function() {
    $('#cadre').change(function(e) {
        alert("t")
            // var id = e.target.value;
            // $('#corps').empty();
            // // Request the neighborhoods of the selected city.
            // $.ajax({
            //     url: "/admin/region/regions/departements",
            //     type: "GET",
            //     dataType: "JSON",
            //     data: {
            //         id: id
            //     },
            //     success: function(neighborhoods) {
            //         $('#dn').append('<option value="">--Emploi--</option>');
            //         $.each(neighborhoods, function(key, neighborhood) {
            //             //alert(neighborhood.libelle);
            //             $('#dn').append('<option value="' + neighborhood.id + '">' + neighborhood.name + '</option>');
            //         });
            //     },
            //     error: function(err) {
            //         alert("An error ocurred while loading data ...");
            //     }
            // });
    });

    // $('#rr').change(function(e) {
    //     //alert("t")
    //     var id = e.target.value;
    //     $('#dr').empty();
    //     // Request the neighborhoods of the selected city.
    //     $.ajax({
    //         url: "/admin/region/regions/departements",
    //         type: "GET",
    //         dataType: "JSON",
    //         data: {
    //             id: id
    //         },
    //         success: function(neighborhoods) {
    //             $('#dr').append('<option value="">--Emploi--</option>');
    //             $.each(neighborhoods, function(key, neighborhood) {
    //                 //alert(neighborhood.libelle);
    //                 $('#dr').append('<option value="' + neighborhood.id + '">' + neighborhood.name + '</option>');
    //             });
    //         },
    //         error: function(err) {
    //             alert("An error ocurred while loading data ...");
    //         }
    //     });
    // });

});