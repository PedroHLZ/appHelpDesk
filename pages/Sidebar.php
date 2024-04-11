        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo $enderecodosite; ?>">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-life-ring me-2"></i>
                </div>
                <div class="sidebar-brand-text mx-3"> <?php echo $nome_do_site; ?></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo $enderecodosite; ?>/pages/suportdashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Gerenciamento
            </div>

            <!-- Nav Item - Tickets Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#Tickets" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-ticket-alt me-1"></i>
                    <span>Tickets</span>
                </a>
                <div id="Tickets" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="#" id="ticketsAbertos">Abertos</a>
                        <a class="collapse-item" href="#" id="ticketsFechados">Fechados</a></a>
                        <a class="collapse-item" href="#" id="todosTickets">Todos</a></a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Usuários Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#Usuarios" aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-user"></i>

                    <span>Usuários</span>
                </a>
                <div id="Usuarios" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <!-- <h6 class="collapse-header">Custom Utilities:</h6> -->
                        <a href="#" id="editarUsuario" class="collapse-item">Usuários</a>
                        <a href="#" id="adicionarUsuario" class="collapse-item">Adicionar Novo</a>
                    </div>
                </div>
            </li>
            <!-- Nav Item - Relatórios e Estatísticas Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#EstatisticasRelatorios" aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-chart-bar"></i>

                    <span>Estatísticas e Relatórios </span>
                </a>
                <div id="EstatisticasRelatorios" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Estatísticas:</h6>
                        <a href="#" id="estatisticastickets" class="collapse-item">Estatísticas de Tickets</a>
                        <h6 class="collapse-header"></h6>
                        <h6 class="collapse-header">Relatórios:</h6>
                        <a href="#" id="relatorioDesempenho" class="collapse-item">Relatório de Desempenho</a>
                    </div>
                </div>
            </li>

   
           

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>



        </ul>
        <!-- End of Sidebar -->