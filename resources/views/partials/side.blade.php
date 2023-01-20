<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav mt-3">
                <a class="nav-link {{ Route::currentRouteNamed('dashboard') ? 'active' : '' }}"
                    href="{{ route('dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <a class="nav-link {{ Route::currentRouteNamed(['purchase', 'selling']) ? 'active' : 'collapsed' }}"
                    href="#" data-bs-toggle="collapse" data-bs-target="#collapseTransactions"
                    aria-expanded="false" aria-controls="collapseTransactions">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Transaksi
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ Route::currentRouteNamed(['purchase', 'selling']) ? 'show' : '' }}"
                    id="collapseTransactions" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ Route::currentRouteNamed('purchase') ? 'active' : '' }}"
                            href="{{ route('purchase') }}">Pembelian</a>
                        <a class="nav-link {{ Route::currentRouteNamed('selling') ? 'active' : '' }}"
                            href="{{ route('selling') }}">Penjualan</a>
                    </nav>
                </div>
                <a class="nav-link {{ Route::currentRouteNamed(['product.index', 'product.edit', 'product.create']) ? 'active' : 'collapsed' }}"
                    href="{{ route('product.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Produk
                </a>
                <a class="nav-link {{ Route::currentRouteNamed(['report.purchase', 'report.purchase.detail', 'report.selling']) ? 'active' : 'collapsed' }}"
                    href="#" data-bs-toggle="collapse" data-bs-target="#collapseReports" aria-expanded="false"
                    aria-controls="collapseReports">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Laporan
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ Route::currentRouteNamed(['report.purchase', 'report.purchase.detail', 'report.selling']) ? 'show' : '' }}"
                    id="collapseReports" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ Route::currentRouteNamed('report.purchase', 'report.purchase.detail') ? 'active' : '' }}"
                            href="{{ route('report.purchase') }}">Pembelian</a>
                        <a class="nav-link {{ Route::currentRouteNamed('report.selling') ? 'active' : '' }}"
                            href="{{ route('report.selling') }}">Penjualan</a>
                    </nav>
                </div>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            {{ auth()->user()->name }}
        </div>
    </nav>
</div>
