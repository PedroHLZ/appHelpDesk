// Adicione um ouvinte de evento de clique para cada link do menu
document.getElementById("meusticket").addEventListener("click", function() {
    carregarPagina("conteudoPagina", "meus_ticket.php");
});

document.getElementById("meusticketabertos").addEventListener("click", function() {
    carregarPagina("conteudoPagina", "meus_ticket_abertos.php");
});

document.getElementById("meusticketfechados").addEventListener("click", function() {
    carregarPagina("conteudoPagina", "meus_ticket_fechados.php");
});

document.getElementById("settings").addEventListener("click", function() {
    carregarPagina("conteudoPagina", "settings.php");
});

document.getElementById("meuschats_abertos").addEventListener("click", function() {
    carregarPagina("conteudoPagina", "meuschats_abertos.php");
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
    // Corrija o caminho para os arquivos PHP se necessário
    xmlhttp.open("GET", "pages/" + pagina, true);
    xmlhttp.send();
}
