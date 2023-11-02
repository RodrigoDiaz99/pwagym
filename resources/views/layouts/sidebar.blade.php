 <!-- Sidebar -->
 <ul id="accordionSidebar" class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion">

     <!-- Sidebar - Brand -->
     <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
         <div class="row">
             <div class="col-md-12 px-5">
                 <img src="{{ asset('images/spacio.png') }}" alt="" class="img-fluid">
             </div>
         </div>
     </a>

     <!-- Divider -->
     <hr class="sidebar-divider my-0">

     <!-- Divider -->
     <hr class="sidebar-divider">

     <!-- Heading -->
     <div class="sidebar-heading">
         Menú principal
     </div>





     <!-- Nav Item - Tables -->
     <li class="nav-item">
         <a class="nav-link" href="{{ route('comandera.index') }}">
             <i class="fa fa-th-large"></i>
             <span>Comandera</span></a>
     </li>

     <!-- Nav Item - Tables -->
     <li class="nav-item">
         <a class="nav-link" href="{{ route('pedidos.index') }}">
             <i class="fa fa-list"></i>
             <span>Pedidos</span></a>
     </li>





     <!-- Divider -->
     <hr class="sidebar-divider d-none d-md-block">
     <!-- Nav Item - Charts -->
     <li class="nav-item">
         <a class="nav-link" href="{{ route('configuracion.index') }}">
             <i class="fa fa-cog" aria-hidden="true"></i>
             <span>Configuración</span></a>
     </li>

     <li class="nav-item">
         <a class="nav-link" href="{{ route('productos.index') }}">
             <i class="fas fa-store"></i>
             <span>Productos</span></a>
     </li>

     <hr class="sidebar-divider d-none d-md-block">

     <!-- Sidebar Toggler (Sidebar) -->
     <div class="text-center d-none d-md-inline">
         <button id="sidebarToggle" class="rounded-circle border-0"></button>
     </div>


 </ul>
 <!-- End of Sidebar -->
