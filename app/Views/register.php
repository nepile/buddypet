<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register Page</title>
    <script src="https://cdn.jsdelivr.net/npm/react@18/umd/react.development.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/react-dom@18/umd/react-dom.development.js"></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
    <style>
      body {
        margin: 0;
        padding: 0;
        font-family: "Segoe UI", "Roboto", sans-serif;
        height: 100vh;
        overflow: hidden;
      }
      .container {
        display: flex;
        height: 100vh;
        width: 100%;
      }
      .form-section {
        flex: 1;
        background-color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
      }
      .image-section {
        flex: 1;
        background: url("https://i.pinimg.com/736x/9a/80/c0/9a80c0f0dc2c9efd3fb5222f4cb7fd9c.jpg") no-repeat center center;
        background-size: cover;
        display: none;
      }
      @media (min-width: 768px) {
        .image-section {
          display: block;
        }
      }
      .form-container {
        max-width: 400px;
        width: 100%;
        padding: 40px;
      }
      .form-container h1 {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 1rem;
        color: #333;
      }
      .form-container p {
        color: #666;
        margin-bottom: 1.5rem;
      }
      .form-group {
        margin-bottom: 1rem;
      }
      .form-group label {
        font-weight: bold;
        color: #333;
        display: block;
        margin-bottom: 0.5rem;
      }
      .form-control {
        width: 100%;
        padding: 10px;
        border: 2px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
        box-sizing: border-box;
      }
      .password-container {
        position: relative;
        margin-bottom: 1.5rem;
      }
      .password-toggle {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        z-index: 10;
      }
      .password-toggle span {
        font-size: 1.2rem;
        color: #666;
      }
      .btn-custom {
        background-color: #f37100;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: bold;
        width: 100%;
        cursor: pointer;
      }
      .btn-custom:hover {
        background-color: #f37100;
      }
      .link-custom {
        color: #f37100;
        text-decoration: none;
        font-weight: bold;
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

      const RegisterPage = () => {
        const [showPassword, setShowPassword] = useState(false);
        const [formData, setFormData] = useState({
          email: "",
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
          console.log("Register attempt:", {
            email: formData.email,
            username: formData.username,
            password: formData.password,
          });
          // Handle registration logic here (e.g., API call)
        };

        return (
          <div className="container">
            {/* Left Side - Register Form */}
            <div className="form-section">
              <div className="form-container">
                <h1>Daftar</h1>
                <p className="text-muted">
                  Silakan daftar untuk membuat akun baru. Jika sudah punya akun, silakan{" "}
                  <a href="login.html" className="link-custom">
                    login disini
                  </a>
                  .
                </p>

                <form onSubmit={handleSubmit}>
                  <div className="form-group">
                    <label htmlFor="email">Email</label>
                    <input type="email" className="form-control" id="email" name="email" value={formData.email} onChange={handleInputChange} placeholder="Masukkan email" required />
                  </div>

                  <div className="form-group">
                    <label htmlFor="username">Username</label>
                    <input type="text" className="form-control" id="username" name="username" value={formData.username} onChange={handleInputChange} placeholder="Masukkan username" required />
                  </div>

                  <div className="password-container">
                    <label htmlFor="password">Password</label>
                    <input type={showPassword ? "text" : "password"} className="form-control" id="password" name="password" value={formData.password} onChange={handleInputChange} placeholder="Masukkan password" required />
                    <button type="button" className="password-toggle" onClick={() => setShowPassword(!showPassword)}></button>
                  </div>

                  <button type="submit" className="btn-custom">
                    Daftar
                  </button>
                </form>
              </div>
            </div>

            {/* Right Side - Image */}
            <div className="image-section"></div>
          </div>
        );
      };

      ReactDOM.render(<RegisterPage />, document.getElementById("root"));
    </script>
  </body>
</html>
