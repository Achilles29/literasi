<!DOCTYPE html>
<html lang="id">

<head>
    <title>Login Peserta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #eef2f7, #f8f9fa);
            display: flex;
            align-items: center;
        }

        .login-card {
            border-radius: 14px;
        }

        .login-title {
            font-weight: 700;
        }

        .login-subtitle {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .form-control {
            height: 48px;
            font-size: 1rem;
            letter-spacing: 1px;
            text-align: center;
        }

        .btn-login {
            height: 48px;
            font-weight: 600;
        }

        @media (max-width: 576px) {
            .login-card {
                box-shadow: none;
                border: none;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-11 col-sm-8 col-md-5 col-lg-4">

                <div class="card shadow login-card">
                    <div class="card-body p-4">

                        <div class="text-center mb-4">
                            <h4 class="login-title mb-1">Login Peserta</h4>
                            <div class="login-subtitle">
                                Masukkan token untuk melihat hasil lomba
                            </div>
                        </div>

                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger text-center small">
                                <?= $this->session->flashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <form method="post" action="<?= base_url('auth/token_login') ?>">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    Token Peserta
                                </label>
                                <input
                                    type="text"
                                    name="token"
                                    class="form-control"
                                    placeholder="Contoh: ABC123"
                                    required
                                    autofocus>
                            </div>

                            <button class="btn btn-primary w-100 btn-login">
                                Masuk
                            </button>
                        </form>

                        <div class="text-center mt-4 text-muted small">
                            Sistem Lomba • Akses Peserta
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>