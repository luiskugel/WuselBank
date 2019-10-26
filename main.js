function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}
/*
0 => payment
1 => transfer
2 => management
3 => info
4 => balance

#-card
*/
var activePage = 3;

function reloadPage() {
    $(".card").hide();
    $(".navlink").removeClass("active")
    switch (activePage) {
        case 0:
            $("#payment-card").show();
            $('#payment').addClass('active');
            break;
        case 1:
            $("#transfer-card").show();
            $('#transfer').addClass('active');
            break;
        case 2:
            $("#management-card").show();
            $('#management').addClass('active');
            break;
        case 3:
            $("#info-card").show();
            $('#info').addClass('active');
            break;
        case 4:
            $("#balance-card").show();
            $('#balance').addClass('active');
            break;
    }
}

function executeAJAX(operation, iban, value, name, iban2) {
    $.post("http://286558.webhosting50.1blu.de/test/execute.php",
        {
            operation: operation,
            name: name,
            iban: iban,
            value: value,
            iban2: iban2
        },
        function (data, status) {
            if(operation == "balance"){
                $(".popup").find("h3").html(data)
                $(".popup").show()
            }else{
                //has to be made nicer
                console.log(data)
                alert(data)
            }
        });
}

$(document).ready(function () {
    reloadPage()
    $(".popup").hide()


    $("#payment").click(function () {
        activePage = 0
        reloadPage()
    })
    $("#transfer").click(function () {
        activePage = 1
        reloadPage()
    })
    $("#management").click(function () {
        activePage = 2
        reloadPage()
    })
    $("#info").click(function () {
        activePage = 3
        reloadPage()
    })
    $("#balance").click(function () {
        activePage = 4
        reloadPage()
    })

    $("#transfer-execute").click(function () {
        var sendIBAN = $("#transfer-send-iban").val();
        var receiveIBAN = $("#transfer-receive-iban").val();
        var value = $("#transfer-value").val();
        executeAJAX("transfer", sendIBAN, value, "", receiveIBAN)

        $("#transfer-send-iban").val("")
        $("#transfer-receive-iban").val("")
        $("#transfer-value").val("")
    })
    $("#payment-execute").click(function () {
        var IBAN = $("#payment-iban").val()
        var value = $("#payment-value").val()
        var direction = $("#payment-toggle").children(".active").index();
        executeAJAX((direction == 0 ? "payment-withdraw" : "payment-deposit"), IBAN, value)
        $("#payment-iban").val("")
        $("#payment-value").val("")
    })
    $("#management-create-execute").click(function () {
        var name = $("#management-create-name").val()
        var IBAN = $("#management-create-iban").val()
        var value = $("#management-create-value").val()
        if(IBAN === ""){
            IBAN = "WB" + Math.random() * Math.pow(10, 20)
        }
        executeAJAX("management-create", IBAN, value, name)
        $("#management-create-name").val("")
        $("#management-create-iban").val("")
        $("#management-create-value").val("")
    })
    $("#balance-execute").click(function () {
        var identifier = $("#balance-identifier").val()
        executeAJAX("balance", identifier)
        $("#balance-identifier").val("")
    })
    $("#close-button").click(function (){
        $(".popup").hide()
    })
    $("#logout").click(function (){
        window.location.href = "logout.php"
    })
});

