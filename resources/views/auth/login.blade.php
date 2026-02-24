<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Login</title>
</head>
<body>
    <section class="min-vh-100">
        <div class="container-fluid">
            <div class="row h-100 align-items-center">
            <div class="col-lg-4 col-md-4 text-black bg-white h-100">

                <div class="px-5 ms-xl-4">
                <i class="fas fa-crow fa-2x me-3 pt-5 mt-xl-4" style="color: #709085;"></i>
                <span class="h1 fw-bold mb-0">Logo</span>
                </div>

                <div class="d-flex align-items-center justify-content-center h-100 px-5">

                <form method="post" action="{{ url('login/check') }}" style="w-100" style="max-width: 360px;">
                    @csrf
                    <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">SISTEM MANAGEMENT INVENTARIS </h3>

                    <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label" for="form2Example18">Username</label>
                        <input type="name" name="name" id="form2Example18" class="form-control form-control-md" />
                    </div>

                    <div class="form-outline mb-4">
                        <label class="form-label" for="form2Example28">Password</label>

                        <div class="input-group">
                            <input type="password" name="password" id="form2Example28"class="form-control form-control-md">
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="pt-1 mb-4">
                    <button data-mdb-button-init data-mdb-ripple-init  class="btn-login" type="submit">Login</button>
                    </div>

                    <p class="small mb-2 pb-sm-2"><a class="text-muted" href="#!">Forgot password?</a></p>
                    <p>Don't have an account? <a href="#!" class="link-info">Register here</a></p>

                </form>

                </div>

            </div>
            <div class="col-lg-8 col-md-6 px-0 d-none d-md-block h-100">
                <img src="https://madiun.rsdarmayu.com/wp-content/uploads/2023/11/rs-darmayu-kota-madiun-scaled.jpg"
                alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: center;">
            </div>
            </div>
        </div>
    </section>
   <script>
        document.getElementById("togglePassword").addEventListener("click", function () {
            var passwordField = document.getElementById("form2Example28");
            var icon = this.querySelector("i");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>
</body>
</html>
