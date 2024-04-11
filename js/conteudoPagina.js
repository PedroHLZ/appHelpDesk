
// Adicione um ouvinte de evento de clique para cada link do menu
document.getElementById("todosTickets").addEventListener("click", function() {
    carregarPagina("conteudoPagina", "tickets.php");
});

document.getElementById("ticketsAbertos").addEventListener("click", function() {
    carregarPagina("conteudoPagina", "tickets_abertos.php");
});

document.getElementById("ticketsFechados").addEventListener("click", function() {
    carregarPagina("conteudoPagina", "tickets_fechados.php");
});


document.getElementById("adicionarUsuario").addEventListener("click", function() {
    carregarPagina("conteudoPagina", "adicionar_usuario.php");
});

document.getElementById("editarUsuario").addEventListener("click", function() {
    carregarPagina("conteudoPagina", "editar_usuario.php");
});



// Função para carregar o conteúdo da página
function carregarPagina(idDiv, pagina) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4) {
            if (this.status == 200) {
                document.getElementById(idDiv).innerHTML = this.responseText;
            } else {
                console.log("Erro ao carregar a página: " + pagina);
            }
        }
    };
    xmlhttp.open("GET", pagina, true);
    xmlhttp.send();
}
