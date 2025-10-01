<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= esc($title ?? 'Dashboard') ?></title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root{
      --brand-blue:#0a2a6b;
      --brand-blue-2:#123a8a;
      --brand-yellow:#f7c744;
      --ink:#0f172a;
      --bg:#f7f9ff;
      --sidebar-bg:#dfe9ff; /* bisa ganti ke var(--brand-blue-2) untuk sidebar biru tua */
    }

    body{ background: var(--bg); overflow-x:hidden; }
    .content{ padding:20px 24px; }

    /* SIDEBAR */
    .sidebar{
      min-height:100vh;
      background: var(--sidebar-bg);
      border-right: 1px solid rgba(10,42,107,.08);
      padding: 18px 12px 14px;
      display:flex; flex-direction:column; justify-content:space-between;
    }
    .brand{
      font-weight:800; color:var(--brand-blue);
      font-size:1.15rem; margin:2px 8px 12px;
    }
    .nav-list{ list-style:none; padding:0; margin:8px 0 0; }
    .nav-list .nav-link{
      display:flex; align-items:center; gap:.6rem;
      padding:.6rem .85rem; margin-bottom:.45rem;
      border-radius:12px; text-decoration:none; font-weight:600;
      color: var(--brand-blue);
      transition:all .18s;
    }
    .nav-list .nav-link:hover{ background: rgba(13,47,122,.07); }
    .nav-list .nav-link.active{
      background: rgba(247,199,68,.9);
      border: 1px solid rgba(247,199,68,1);
      box-shadow: 0 6px 16px rgba(247,199,68,.35);
      color: var(--brand-blue);
    }

    /* Logout link bawah */
    .side-bottom a{
      display:flex; align-items:center; gap:.55rem;
      color: var(--brand-blue); text-decoration:none;
      padding:.5rem .65rem; border-radius:8px;
      border: 1px dashed rgba(13,47,122,.25);
      font-weight:600;
    }
    .side-bottom a:hover{ background: rgba(13,47,122,.06); }

    /* Naikkan area konten dikit */
    .content { padding: 12px 24px 20px; }

    /* Baris header: jangan terbelah */
    .page-head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin: 4px 0 10px;          /* kecilkan jarak atas */
    gap: 12px;
    flex-wrap: wrap;             /* mobile boleh wrap */
    }
    .head-left{
    display:flex;
    align-items:center;
    gap: 12px;
    flex: 1 1 auto;
    min-width: 0;
    flex-wrap: wrap;             /* mobile boleh wrap */
    }

    /* Di layar ≥992px paksa satu baris (sejajar dengan role chip) */
    @media (min-width: 992px){
    .page-head, .head-left { flex-wrap: nowrap; }
    }

    /* Hilangkan margin default heading */
    .page-head h4 { margin: 0; }

    /* Lebar search: fleksibel tapi tidak mepet */
    .search-wrap{
    position:relative;
    flex: 0 1 520px;             /* boleh mengecil sampai pas */
    max-width: 600px;
    min-width: 260px;
    }
    .search-wrap .form-control{
    border-radius: 999px;
    padding-left: 2.4rem;
    border: 1px solid #e5e7eb;
    height: 44px;                /* samakan tinggi dengan chip biar center */
    }
    .search-wrap .bi-search{
    position:absolute;
    left:.9rem; top:50%; transform:translateY(-50%);
    color:#64748b;
    }

    @media (max-width: 991.98px){
      .sidebar{ position:fixed; top:0; left:-260px; width:240px; z-index:1020; transition:left .25s; }
      .sidebar.open{ left:0; }
      body.sidebar-open{ overflow:hidden; }
    }

    /* === MODAL LOGOUT GLASSY === */
    .modal-content{
      background: rgba(255,255,255,255);
      backdrop-filter: blur(16px) saturate(160%);
      -webkit-backdrop-filter: blur(16px) saturate(160%);
      border: 1px solid rgba(255,255,255,.25);
      border-radius: 1rem;
    }
    .modal-header{
      border-bottom: none;
    }
    .modal-footer{
      border-top: none;
    }
  </style>
</head>
<body>

  <div class="container-fluid">
    <div class="row">
      <!-- SIDEBAR -->
      <aside class="col-12 col-lg-2 sidebar" id="sidebar">
        <div class="side-top">
          <div class="brand">UTS Proyek3</div>
          <ul class="nav-list">
            <?php foreach (($menu ?? []) as $m): ?>
              <li>
                <a class="nav-link" id="<?= esc($m['id']) ?>" href="<?= esc($m['href']) ?>">
                  <?php if (!empty($m['icon'])): ?><i class="bi <?= esc($m['icon']) ?>"></i><?php endif; ?>
                  <?= esc($m['text']) ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <div class="side-bottom mb-2">
          <a href="#" id="btnLogoutSide">
            <i class="bi bi-box-arrow-right"></i> Logout
          </a>
        </div>
      </aside>

      <!-- MAIN -->
      <main class="col-12 col-lg-10 content">
        <div class="page-head">
          <div class="head-left">
            <?= $this->renderSection('page_head_left') ?>
          </div>
          <span class="role-chip ms-2">
            <i class="bi bi-person-circle me-1"></i><?= esc(session('full_name')) ?> (<?= esc(session('role')) ?>)
          </span>
        </div>

        <?= $this->renderSection('content') ?>
      </main>
    </div>
  </div>

  <!-- Modal Logout -->
  <div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content shadow-lg">
        <div class="modal-header">
          <h5 class="modal-title fw-bold">Konfirmasi Logout</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Apakah kamu yakin ingin logout dari aplikasi?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
          <a href="/logout" id="btnLogoutConfirm" class="btn btn-warning rounded-pill px-3 fw-bold">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Script -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Toggle sidebar (mobile)
    const btn = document.getElementById('btnSidebar');
    const side = document.getElementById('sidebar');
    btn?.addEventListener('click', ()=>{
      side.classList.toggle('open');
      document.body.classList.toggle('sidebar-open');
    });

    // Active menu
    document.querySelectorAll('.nav-link').forEach(a=>{
      if (a.getAttribute('href') === window.location.pathname) a.classList.add('active');
    });

    // Logout pakai modal glassy
    const logoutBtn = document.getElementById('btnLogoutSide');
    const logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
    logoutBtn?.addEventListener('click', (e)=>{
      e.preventDefault();
      logoutModal.show();
    });
  </script>
</body>
</html>
