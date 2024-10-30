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
    <li class="{{ request()->is('/') ? 'active' : '' }}">
      <a href="/">
        <i class="nc-icon nc-bank"></i>
        <p>Dashboard</p>
      </a>
    </li>
    <li class="{{ request()->is('tb_barang') ? 'active' : '' }}">
      <a href="{{ route('barang.index') }}">
        <i class="nc-icon nc-app"></i>
        <p>Data Barang</p>
      </a>
    </li>
    <li class="{{ request()->is('tb_user') ? 'active' : '' }}">
      <a href="{{ url('tb_user') }}">
        <i class="nc-icon nc-badge"></i>
        <p>Data User</p>
      </a>
    </li>
    <li class="{{ request()->is('tb_peminjaman') ? 'active' : '' }}">
      <a href="{{ url('tb_peminjaman') }}">
        <i class="nc-icon nc-share-66"></i>
        <p>Data Peminjaman</p>
      </a>
    </li>
  </ul>
</div>
