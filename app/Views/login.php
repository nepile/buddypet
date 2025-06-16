<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/react@18/umd/react.development.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/react-dom@18/umd/react-dom.development.js"></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
    <style>
      body {
        margin: 0;
        padding: 0;
        font-family: "Segoe UI", "Roboto", sans-serif;
      }
      .bg-image {
        background: url("https://awsimages.detik.net.id/community/media/visual/2024/09/19/anjing-herder_169.jpeg?w=1200") no-repeat center center; /* URL gambar asli */
        background-size: cover;
        min-height: 100%;
      }
      .form-container {
        max-width: 400px;
      }
      .password-toggle {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        z-index: 10;
      }
      .btn-custom {
        background-color: #f37100;
        border: none;
        border-radius: 8px;
      }
      .btn-custom:hover {
        background-color: #f37100;
      }
      .link-custom {
        color: #f37100;
        text-decoration: none;
      }
      .link-custom:hover {
        color: #f37100;
        text-decoration: underline;
      }
    </style>
  </head>
  <body>
    <div id="root"></div>

    <script type="text/babel">
      const { useState } = React;

      const LoginPage = () => {
        const [showPassword, setShowPassword] = useState(false);
        const [formData, setFormData] = useState({
          username: "",
          password: "",
        });

        const handleInputChange = (e) => {
          const { name, value } = e.target;
          setFormData((prev) => ({
            ...prev,
            [name]: value,
          }));
        };

        const handleSubmit = (e) => {
          e.preventDefault();
          console.log("Login attempt:", formData);
          // Handle login logic here (e.g., API call)
        };

        return (
          <div className="container-fluid vh-100 p-0">
            <div className="row h-100 g-0">
              {/* Left Side - Image */}
              <div className="col-md-6 d-none d-md-block bg-image">
                <div className="h-100"></div>
              </div>

              {/* Right Side - Login Form */}
              <div className="col-12 col-md-6 d-flex align-items-center justify-content-center bg-white">
                <div className="form-container p-4 p-md-5">
                  <h1 className="h2 fw-bold mb-3 text-dark">Login</h1>
                  <p className="text-muted mb-4">Silakan login untuk melanjutkan ke halaman utama. Jika belum punya akun, silakan daftar terlebih dahulu.</p>

                  <form onSubmit={handleSubmit}>
                    <div className="mb-3">
                      <label htmlFor="username" className="form-label fw-semibold text-dark">
                        Username
                      </label>
                      <input
                        type="text"
                        className="form-control form-control-lg border-2"
                        id="username"
                        name="username"
                        value={formData.username}
                        onChange={handleInputChange}
                        placeholder="Masukkan username"
                        required
                        style={{ borderRadius: "8px", borderColor: "#ddd", fontSize: "14px" }}
                      />
                    </div>

                    <div className="mb-4 position-relative">
                      <label htmlFor="password" className="form-label fw-semibold text-dark">
                        Password
                      </label>
                      <input
                        type={showPassword ? "text" : "password"}
                        className="form-control form-control-lg border-2"
                        id="password"
                        name="password"
                        value={formData.password}
                        onChange={handleInputChange}
                        placeholder="Masukkan password"
                        required
                        style={{ borderRadius: "8px", borderColor: "#ddd", fontSize: "14px", paddingRight: "3rem" }}
                      />
                      <button type="button" className="btn password-toggle p-0 border-0 bg-transparent" onClick={() => setShowPassword(!showPassword)}>
                        <span className="text-muted" style={{ fontSize: "1.2rem" }}></span>
                      </button>
                    </div>

                    <div className="d-grid">
                      <button type="submit" className="btn btn-custom btn-lg fw-semibold text-white">
                        Masuk
                      </button>
                    </div>
                  </form>

                  <div className="text-center mt-4">
                    <p className="text-muted mb-0">
                      Belum punya akun?{" "}
                      <a href="#" className="link-custom fw-semibold">
                        Daftar disini
                      </a>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        );
      };

      ReactDOM.render(<LoginPage />, document.getElementById("root"));
    </script>
  </body>
</html>
