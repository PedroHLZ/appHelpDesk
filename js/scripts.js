
function showSuccessModal() {
    // Código para exibir o modal de sucesso
    $('#successModal').modal('show');
    // Após 2 segundos, fecha o modal
    setTimeout(function() {
        $('#successModal').modal('hide');
    }, 2000);
}