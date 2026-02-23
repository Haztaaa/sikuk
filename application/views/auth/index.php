<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login | Uji Kelayakan</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <!-- Vendor CSS -->
  <link href="<?= base_url('assets') ?>/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url('assets') ?>/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

  <!-- Toastr -->
  <link href="<?= base_url('assets') ?>/css/toastr.min.css" rel="stylesheet">

  <!-- Main CSS -->
  <link href="<?= base_url('assets') ?>/css/style.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(135deg, #c2c5ca, #4dabf7);
      min-height: 100vh;
    }

    .login-wrapper {
      width: 100%;
      max-width: 460px;
    }

    .card {
      border-radius: 14px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
      border: none;
    }

    .logo-title {
      font-weight: 600;
      font-size: 22px;
      margin-top: 10px;
      color: #fff;
      text-align: center;
    }

    .btn-login {
      height: 45px;
      border-radius: 8px;
      font-weight: 500;
    }

    /* CAPTCHA */
    .captcha-wrapper {
      position: relative;
    }

    .captcha-box {
      background: linear-gradient(135deg, #e7f1ff, #f8fbff);
      border: 1px dashed #0d6efd;
      border-radius: 10px;
      padding: 12px;
      text-align: center;
      font-size: 18px;
      font-weight: 600;
      letter-spacing: 2px;
      color: #0d6efd;
      margin-bottom: 10px;
      user-select: none;
    }

    .btn-refresh-captcha {
      position: absolute;
      right: 10px;
      top: 36px;
      border: none;
      background: none;
      color: #6c757d;
    }

    .btn-refresh-captcha i {
      transition: 0.3s;
    }

    .login-card {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
    }

    .btn-refresh-captcha:hover i {
      transform: rotate(180deg);
      color: #0d6efd;
    }

    .gaul {
      font-family: "Nunito", sans-serif;
    }

    .gaul2 {
      font-family: "Inter", sans-serif;
    }

    /* PASSWORD TOGGLE */
    .password-wrapper {
      position: relative;

    }

    .toggle-password {
      position: absolute;
      right: 12px;
      top: 38px;
      cursor: pointer;
      color: #6c757d;
    }

    .toggle-password:hover {
      color: #0d6efd;
    }
  </style>
</head>

<body>

  <main>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">

      <div class="login-wrapper">

        <div class="text-center mb-4">
          <img src="<?= base_url('assets') ?>/img/logo.png" width="60">
          <div class="logo-title">Uji Kelayakan</div>
        </div>

        <div class="card">
          <div class="card-body p-4">

            <h5 class="card-title text-center pb-0 fs-4 gaul2">Masuk Ke Akun Anda</h5>
            <p class="text-center text-muted small mb-4 gaul2">Masukkan email & password</p>

            <form id="form-login">

              <div class="mb-3">
                <label class="form-label gaul fw-bold">Username Atau Email</label>
                <input type="text" name="identity" class="form-control gaul" placeholder="Email atau Username" required>
              </div>

              <div class="mb-3 password-wrapper">
                <label class="form-label gaul fw-bold">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
                <i class="bi bi-eye toggle-password" id="toggle-password"></i>
              </div>

              <div class="mb-3 captcha-wrapper">
                <label class="form-label gaul fw-bold">Captcha</label>
                <div class="captcha-box" id="captcha-text">
                  ...
                </div>

                <button type="button" class="btn-refresh-captcha" id="refresh-captcha">
                  <i class="bi bi-arrow-clockwise"></i>
                </button>

                <input type="text" name="captcha" class="form-control" placeholder="Jawaban captcha" required>
              </div>

              <button type="submit" class="btn btn-primary w-100 btn-login" id="btn-login">
                <span id="btn-text">Login</span>
                <span id="btn-loading" class="d-none">
                  <span class="spinner-border spinner-border-sm"></span> Loading...
                </span>
              </button>

            </form>

          </div>
        </div>

      </div>

    </div>
  </main>

  <!-- Vendor JS -->
  <script src="<?= base_url('assets') ?>/js/jquery.min.js"></script>
  <script src="<?= base_url('assets') ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Toastr -->
  <script src="<?= base_url('assets') ?>/js/toastr.min.js"></script>

  <script>
    $(document).ready(function() {

      function loadCaptcha() {
        $.ajax({
          url: "<?= base_url('auth/generate_captcha') ?>",
          type: "GET",
          dataType: "JSON",
          success: function(res) {
            $('#captcha-text').text(res.captcha_text);
          },
          error: function() {
            $('#captcha-text').text('Captcha error');
          }
        });
      }

      // Load pertama kali
      loadCaptcha();

      // Refresh captcha
      $('#refresh-captcha').click(function() {
        loadCaptcha();
      });

      // Toggle password
      $('#toggle-password').click(function() {
        let input = $('#password');
        let icon = $(this);

        if (input.attr('type') === 'password') {
          input.attr('type', 'text');
          icon.removeClass('bi-eye').addClass('bi-eye-slash');
        } else {
          input.attr('type', 'password');
          icon.removeClass('bi-eye-slash').addClass('bi-eye');
        }
      });

      // Submit login
      $('#form-login').submit(function(e) {
        e.preventDefault();

        let form = $(this);
        let btn = $('#btn-login');

        // Loading state
        $('#btn-text').addClass('d-none');
        $('#btn-loading').removeClass('d-none');
        btn.prop('disabled', true);

        $.ajax({
          url: "<?= base_url('auth/login') ?>",
          type: "POST",
          data: form.serialize(),
          dataType: "JSON",

          success: function(res) {

            if (res.status === 'success') {
              toastr.success(res.message);
              setTimeout(function() {
                window.location.href = res.redirect;
              }, 1200);

            } else {
              toastr.error(res.message);
              loadCaptcha();
            }
          },

          error: function() {
            toastr.error("Server error");
          },

          complete: function() {
            $('#btn-text').removeClass('d-none');
            $('#btn-loading').addClass('d-none');
            btn.prop('disabled', false);
          }
        });

      });

    });
  </script>

</body>

</html>