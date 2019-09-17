
let id = $("input[name*='ID']")
id.attr("readonly","readonly");


$(".btnedit").click(e =>{
    // console.log("icon clicked");
    let textvalues = displayData(e);
    console.log(textvalues);

    let id = $("input[name*='ID']");
    let firstname = $("input[name*='firstname']");
    let lastname = $("input[name*='lastname']");
    let age = $("input[name*='age']");
    let gender = $("input[name*='gender']");

    id.val(textvalues[0]);
    firstname.val(textvalues[1]);
    lastname.val(textvalues[2]);
    age.val(textvalues[3]);
    gender.val(textvalues[4])
});


function displayData(e){
    let id = 0;
    const td = $("#tbody tr td");
    let textvalues = [];

    for (const value of td){
        if(value.dataset.id == e.target.dataset.id){
            textvalues[id++] = value.textContent;
        }
    }
    return textvalues;
    
}
