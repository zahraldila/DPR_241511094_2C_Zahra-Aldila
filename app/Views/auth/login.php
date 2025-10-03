<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    :root{
      --brand-blue:#0a2a6b; --brand-yellow:#f7c744;
    }
    body{
      min-height:100vh; display:flex; align-items:center; justify-content:center; padding:24px;
      background: radial-gradient(1200px 600px at -10% -20%, #dfe9ff 0%, #bcd2ff 40%, #98b6ff 70%, #7aa0ff 100%),
                  linear-gradient(135deg, #f5f8ff 0%, #e9f0ff 100%);
    }
    .login-card{ background:var(--brand-yellow); border:none; border-radius:22px; box-shadow:0 12px 35px rgba(10,42,107,.18); max-width:420px; width:100%; }
    .login-card .card-body{ padding:28px 26px; }
    .login-title{ color:var(--brand-blue); font-weight:700; letter-spacing:.2px; }
    .input-group-text{ border:0; border-radius:12px; background:#ffeaa9; color:var(--brand-blue); }
    .form-control{ border:0; border-radius:12px; }
    .form-control:focus{ box-shadow:0 0 0 .25rem rgba(13,110,253,.15); }
    .btn-brand{ background:var(--brand-blue); color:#fff; border-radius:999px; padding:.6rem 1rem; border:0; }
    .btn-brand:hover{ background:#071d4b; color:#fff; }
    .err{ display:none; color:#b42318; font-size:.875rem; margin-top:.25rem; }
  </style>
</head>
<body>
  <div class="login-card card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-start mb-3">
        <h5 class="login-title mb-0">Login</h5>
        <span class="text-muted small"><i class="bi bi-shield-lock"></i> UTS Proyek3</span>
      </div>

      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger py-2 small"><?= session()->getFlashdata('error'); ?></div>
      <?php endif; ?>

      <form id="loginForm" method="post" action="<?= base_url('login') ?>" novalidate>
      <?= csrf_field() ?>
        <!-- Username -->
        <div class="mb-3">
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
            <input type="text" class="form-control" name="username" id="username" placeholder="Username/Email" autocomplete="username">
          </div>
          <div id="uErr" class="err">Username wajib diisi.</div>
        </div>

        <!-- Password -->
        <div class="mb-4">
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-eye-fill"></i></span>
            <input type="password" class="form-control" name="password" id="password" placeholder="Password" minlength="6" autocomplete="current-password">
          </div>
          <div id="pErr" class="err">Password minimal 6 karakter.</div>
        </div>

        <button class="btn btn-brand w-100" type="submit">Login</button>
      </form>
    </div>
  </div>

<script>
// Validasi hanya saat submit
const f = document.getElementById('loginForm');
const u = document.getElementById('username');
const p = document.getElementById('password');
const uErr = document.getElementById('uErr');
const pErr = document.getElementById('pErr');

function show(el, msgEl){ msgEl.style.display = 'block'; el.classList.add('is-invalid'); }
function hide(el, msgEl){ msgEl.style.display = 'none'; el.classList.remove('is-invalid'); }

f.addEventListener('submit', (e)=>{
  let ok = true;
  hide(u, uErr); hide(p, pErr); // reset

  if(!u.value.trim()){ show(u, uErr); ok = false; }
  if(!p.value || p.value.length < 6){ show(p, pErr); ok = false; }

  if(!ok) e.preventDefault();
});

// opsional: sembunyikan error saat user mulai memperbaiki
[u,p].forEach(el=>{
  el.addEventListener('input', ()=> el.classList.remove('is-invalid'));
});
</script>
</body>
</html>
