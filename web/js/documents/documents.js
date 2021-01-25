
$('.deleteDoc').click(function () {
    let answer = window.confirm("Are you sure you wish to delete this document?");
    if (answer) {
        let request = $.ajax({
            url: '/documentStorage/delete',
            type: 'get',
            data: {id: $(this).data('id')}
        });
        request.done(function (data) {
            if (data.status == 'ok'){
                location.reload();
            }
            if (data.status == 'error'){
                alert(data.error);
            }
        });
    }
});
$('.emailDoc').click(function () {
    $('#emailModal').modal();
    let docId = $(this).data('id');
    let docName = $(this).data('name');
    $('.docNameToSend').html(docName);
    $("#docIdToSend").val(docId);
});

$('#client_search_form_client').on('change', function() {
    let e = document.getElementById("client_search_form_client");
    let clientId = e.value;

    let request = $.ajax({
        url: '/getallclientcontacts',
        type: 'get',
        data: {id: clientId}
    });
    request.done(function (data) {
        if (data.status == 'ok'){
            for (var i = 0; i < data.data.length; i++) {
                $('#contact_search_form_contact').append($('<option>', {
                    value: data.data[i].id,
                    text : data.data[i].firstname+' '+data.data[i].surname,
                }));
            }
        }
    });

});

$('.saveDocument').on('click', function() {

    let request = $.ajax({
        url: '/documentstorage/savedocumenttoclient',
        type: 'get',
        data: {id: $(this).data('id')}
    });
    request.done(function (data) {
        if (data.status == 'ok'){
            alert('This document has been saved.');
        }else{
            alert('This document has already been saved.');
        }
    });

});