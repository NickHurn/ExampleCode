$('.refreshCoData').click(function () {
    var request = $.ajax({
        url: '/companieshouse/refreshCompanyData',
        type: 'get',
        data: {coNo: $(this).data('id')}
    });
    request.done(function (data) {
        if (data.status == 'ok'){
            alert (data.message)
            location.reload();
        }
    });
});

$('.chsub').click(function () {
    if ($('.chouse').val()!='') {
        $('.companySelectList').empty();
        var request = $.ajax({
            url: '/companieshouse/companySearch',
            type: 'get',
            data: {search: $('.chouse').val()}
        });
        request.done(function (data) {
            if (data.status == 'ok') {
                $('.coSelect').slideDown();
                let result = data.data
                $('.companySelectList').append(
                    '<option value=0" class="schemeDetails">Please Select</option>'
                );
                for (var i = 0; i < result.length; i++) {
                    if (result[i].company_number) {
                        if (result[i].company_number) {
                            // your code here
                            $('.companySelectList').append(
                                '<option value="' + result[i].company_number + '" class="schemeDetails">' + result[i].title + '</option>'
                            );
                        }
                    }
                }
            }
        });
    }
});

$(".companySelectList").on("change", function(){
    var request = $.ajax({
        url: '/companieshouse/getCompaniesHouseRecord',
        type: 'get',
        data: {search: $(".companySelectList option:selected").val()}
    });
    request.done(function (data) {
        if (data.status == 'ok'){
            let result = data.data
            $('.companyDetailDiv').fadeIn();
            $('#client_company').val(result.companyName);
            $('.client_companyNumber').val(result.companyNumber);
            $('#companyNumber').val(result.companyNumber);
            //set registered address
            $('#rLine1').val(result.addLine1);
            if (result.addLine2) {$('#rLine2').val(result.addLine2);}
            $('#rTown').val(result.addTown);
            if (result.rAddCounty) {$('#rCounty').val(result.addCounty);}
            $('#rPostcode').val(result.addPostcode);

            //set postal address
            $('#line1').val(result.addLine1);
            if (result.addLine2) {$('#line2').val(result.addLine2);}
            $('#town').val(result.addTown);
            if (result.addCounty) {$('#county').val(result.addCounty);}
            $('#postcode').val(result.addPostcode);
        }
    });

});
