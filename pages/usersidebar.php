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
                <a class="nav-link" href="<?php echo $enderecodosite; ?>/dashboard">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
            Tickets
            </div>

            <!-- Nav Item - Tickets Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" id="meusticketabertos" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-ticket-alt me-1"></i>
                    <span>Abertos</span>
                </a>

                <a class="nav-link collapsed"  href="#" id="meusticketfechados" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-ticket-alt me-1"></i>
                    <span>Fechados</span>
                </a>

                <a class="nav-link collapsed" href="#" id="meusticket" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-ticket-alt me-1"></i>
                    <span>Todos</span>
                </a>  
            </li>

     

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
             <!-- Heading -->
             <div class="sidebar-heading">
             Mensagens
            </div>
       <!-- Nav Item - Tickets Collapse Menu -->
       <li class="nav-item">

                <a class="nav-link collapsed" href="#" id="meuschats_abertos" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-comments  me-1"></i>
                    <span>Chats</span>
                </a>
               
            </li>
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>



        </ul>
        <!-- End of Sidebar -->