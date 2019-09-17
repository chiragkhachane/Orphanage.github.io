let donorid = $("input[name*='donor_id']")
donorid.attr("readonly","readonly");


$(".btnedit").click( e =>{
    let textvalues = displayData(e);
    console.log(textvalues);

    let donorid = $("input[name*='donor_id']");
    let donorname = $("input[name*='donor_name']");
    let fundamount= $("input[name*='fund_amount']");
    let transactionid = $("input[name*='transaction_id']");
    let paymentmethod= $("input[name*='payment_method']");
    let dateofdonation= $("input[name*='date_of_donation']");

    donorid.val(textvalues[0]);
    donorname.val(textvalues[1]);
    fundamount.val(textvalues[2]);
    transactionid.val(textvalues[3]);
    paymentmethod.val(textvalues[4]);
    dateofdonation.val(textvalues[5]);
});


function displayData(e) {
    let donorid = 0;
    const td = $("#tbody tr td");
    let textvalues = [];

    for (const value of td){
        if(value.dataset.donoeidid == e.target.dataset.donorid){
           textvalues[donorid++] = value.textContent;
        }
    }
    return textvalues;

}