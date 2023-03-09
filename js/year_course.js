  
$(document).ready(function() {
    //create arrays to store option and values
    var firsttofourtyear = [
        {display: "BS Accountacy", value: "1" }, 
        {display: "BS Architecture", value: "2" }, 
        {display: "BSBA Major in Financial Management", value: "3" }, 
        {display: "BSBA Major in Marketing Management", value: "4" }, 
        {display: "BS Civil Engineering", value: "5" }, 
        {display: "BS Computer Engineering", value: "6" }, 
        {display: "BS Hospitality Management", value: "7" }, 
        {display: "BS Psychology", value: "8" }, 
        {display: "BS Tourism Management", value: "9" }, 
        {display: "BS Information Technology", value: "10" }, 
        {display: "Master in Management with Specialization in Bussiness Analytics", value: "11" }    
    ];
       
    var grade11and12 = [
        {display: "ABM", value: "12" },
        {display: "HUMSS", value: "13" },
        {display: "STEM", value: "14" },
    ];

    //If parent option is changed
    $("#parent_selection").change(function() {
        var parent = $(this).val(); //get option value from parent       
        switch(parent){ //using switch compare selected option and populate child
            case 'Grade 11':
                $('#child_selection').attr('disabled', false);
                list(grade11and12);
                break;
            case 'Grade 12':
                $('#child_selection').attr('disabled', false);
                list(grade11and12);
                break;
            case '1st Year':
                $('#child_selection').attr('disabled', false);
                list(firsttofourtyear);
                break;
            case '2nd Year':
                $('#child_selection').attr('disabled', false);
                list(firsttofourtyear);
                break;
            case '3rd Year':
                $('#child_selection').attr('disabled', false);
                list(firsttofourtyear);
                break;
            case '4th Year':
                $('#child_selection').attr('disabled', false);
                list(firsttofourtyear);
                break;
            default: //default child option is blank
                $("#child_selection").html('');
                $('#child_selection').attr("disabled", true);
                break;
        }
    });

    //function to populate child select box
    function list(array_list) {
        $("#child_selection").html(""); //reset child options
        $(array_list).each(function (i) { //populate child options
            $("#child_selection").append("<option value='" + array_list[i].value + "'>" + array_list[i].display + "</option>");
        });
    }
});
