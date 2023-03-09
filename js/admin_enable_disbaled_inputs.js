
let edit_btn = document.getElementById("edit_details");
let update_profile = document.getElementById("update_profile");
let cancel_btn = document.getElementById("cancel_update");

edit_btn.onclick = function(){
    let firstname = document.getElementById("first_name").readOnly = false;
    let lastname = document.getElementById("last_name").readOnly = false;
    let middlename = document.getElementById("middle_name").readOnly = false;
    let birthdate = document.getElementById("birthdate").readOnly = false;
    let sex = document.getElementById("sex").disabled = false;
    let nationality = document.getElementById("nationality").disabled = false;
    let religion = document.getElementById("religion").disabled = false;
    let specialization = document.getElementById("specialization").disabled = false;
    let contact_number = document.getElementById("contact_number").readOnly = false;
    let email_address = document.getElementById("email_address").disabled = false;
    let address = document.getElementById("address").readOnly = false;
    update_profile.hidden = false;
    cancel_btn.hidden = false;
};



cancel_btn.onclick = function(){
    let firstname = document.getElementById("first_name").readOnly = true;
    let lastname = document.getElementById("last_name").readOnly = true;
    let middlename = document.getElementById("middle_name").readOnly = true;
    let birthdate = document.getElementById("birthdate").readOnly = true;
    let sex = document.getElementById("sex").disabled = true;
    let nationality = document.getElementById("nationality").disabled = true;
    let religion = document.getElementById("religion").disabled = true;
    let specialization = document.getElementById("specialization").disabled = true;
    let contact_number = document.getElementById("contact_number").readOnly = true;
    let email_address = document.getElementById("email_address").disabled = true;
    let address = document.getElementById("address").readOnly = true;
    this.hidden = true;
    update_profile.hidden = true;
    location.reload(true);
}





