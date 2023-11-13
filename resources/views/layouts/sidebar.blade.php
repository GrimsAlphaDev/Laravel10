<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-secondary navbar-dark">
        <a href="index.html" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary">Kencana Motor</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="ms-3">
                <h6 class="mb-0">Management Bengkel</h6>
                <span>Admin</span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <a href="{{ route('home') }}" class="nav-item nav-link {{ (Request::is('/') ? 'active' : '') }}"><i
                    class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
            <a href="{{ route('stok.index') }}" class="nav-item nav-link {{ (Request::is('stok') ? 'active' : '') }}">
                <i class="fa fa-box me-2"></i>
                Stok Barang
            </a>
            <a href="{{ route('jenis.index') }}" class="nav-item nav-link {{ (Request::is('jenis') ? 'active' : '') }}">
                <i class="fa fa-tools me-2"></i>
                Jenis Barang
            </a>
            <a href="{{ route('transaksi.index') }}" class="nav-item nav-link {{ (Request::is('transaksi') ? 'active' : '') }}">
                <i class="fa fa-shopping-cart me-2"></i>
                Penjualan
            </a>
            <a href="{{ route('pembelian.index') }}" class="nav-item nav-link {{ (Request::is('pembelian') ? 'active' : '') }}">
                <i class="fa fa-dollar-sign me-2"></i>
                Pembelian
            </a>
        </div>
    </nav>
</div>