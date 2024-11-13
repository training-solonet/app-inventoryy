<div class="logo">
    <a href="https://www.creative-tim.com" class="simple-text logo-mini">
      <div class="logo-image-small">
        <img src="../assets/img/solonetputih.png">
      </div>
    </a>
    <a href="https://www.creative-tim.com" class="simple-text logo-normal">
      Inventory
    </a>
</div>

<div class="sidebar-wrapper" id="sidebar">
    <ul class="nav">

        <!-- Link to 'scan' page for Peminjaman -->
        <li class="{{ request()->routeIs('scan') ? 'active' : '' }}">
            <a href="{{ route('scan') }}">
                <i class="nc-icon nc-badge"></i>
                <p>Peminjaman</p>
            </a>
        </li>

        <!-- Link to 'recap' page for Data Peminjaman -->
        <li class="{{ request()->routeIs('recap') ? 'active' : '' }}">
            <a href="{{ route('recap') }}">
                <i class="nc-icon nc-share-66"></i>
                <p>Data Peminjaman</p>
            </a>
        </li>
    </ul>
</div>
<style>
  
    /* Add this CSS in your custom stylesheet */
  .sidebar .nav li.active > a {
      color: #ADD8E6 !important; /* Light blue */
  }
  
  .sidebar .nav li.active > a i {
      color: #ADD8E6 !important; /* Light blue for icons */
  }
  
  </style>