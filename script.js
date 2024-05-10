$(function() {
    $("#start-date").datepicker({
        dateFormat: 'dd.mm.yy',
    });
    $("#deposit-amount-slider").slider({
        range: "min",
        min: 1000,
        max: 3000000,
        value: 1000,
        slide: function(event, ui) {
            $("#deposit-amount").val(ui.value);
        }
    });
    $("#replenishment-amount-slider").slider({
        range: "min",
        min: 1000,
        max: 3000000,
        value: 1000,
        slide: function(event, ui) {
            $("#replenishment-amount").val(ui.value);
        }
    });

    $("#calculate-btn").click(function() {
        var depositAmount = $("#deposit-amount").val();
        var replenishmentAmount = $("#replenishment-amount").val();
        var date = $("#start-date").val();

        if (depositAmount == "" || isNaN(depositAmount) || depositAmount < 1000 || depositAmount > 3000000) {
            alert("Введите корректную начальную сумму (от 1000 до 3000000)");
            return;
        }
        if (date == "") {
            alert("Введите корректную дату оформления вклада");
            return;
        }
        if ($("#replenishment").val() == "yes" && (replenishmentAmount == "" || isNaN(replenishmentAmount))) {
            alert("Введите корректную сумму пополнения вклада");
            return;
        }

        var formData = $("#calc-form").serialize();

        $.ajax({
            type: "POST",
            url: "calc.php",
            data: formData,
            success: function(response) {
                $("#result").text("Результат: " + response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });

    });
});