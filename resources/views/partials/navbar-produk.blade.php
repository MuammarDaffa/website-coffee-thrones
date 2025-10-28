<nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
    <div class="container-fluid d-flex justify-content-between align-items-center">

        <!-- 🔍 Search bar -->
        <div class="flex-grow-1 me-3">
            {{-- Form ini hanya untuk tampilan, tidak perlu submit --}}
            <form class="navbar-form nav-search w-100" onsubmit="return false;">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-search pe-1">
                            <i class="fa fa-search search-icon"></i>
                        </button>
                    </div>
                    <input 
                        type="text" 
                        id="search" 
                        name="search" 
                        placeholder="Search ..." 
                        class="form-control"
                        autocomplete="off"
                    />
                </div>
            </form>
        </div>

        <!-- 🔘 Tombol kanan -->
        <ul class="navbar-nav topbar-nav align-items-center">
            <li class="nav-item">
                <button id="btnTambah" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle"></i> Tambah Produk
                </button>
            </li>
        </ul>
    </div>
</nav>
