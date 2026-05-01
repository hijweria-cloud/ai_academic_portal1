<?php include('includes/header.php'); ?>

<style>
  body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    min-height: 100vh;
    background: linear-gradient(135deg, #F5EBDD, #F3E2C7);
    color: #1C1C1C;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  /* Making sure navbar stays fixed and consistent */
  .navbar {
    background-color: #1C1C1C !important;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    padding: 10px 0;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.25);
    z-index: 1000;
  }

  .navbar-brand {
    color: #D4AF37 !important;
    font-weight: 700;
  }

  .navbar-nav .nav-link {
    color: #F5EBDD !important;
    font-weight: 500;
    margin-left: 15px;
  }

  .navbar-nav .nav-link:hover {
    color: #D4AF37 !important;
  }

  /* Added padding so content doesn’t hide under navbar */
  .content-wrapper {
    padding-top: 100px;
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  /* Logout container */
  .logout-container {
    background: #fff;
    padding: 50px 70px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    border-top: 5px solid #D4AF37;
    text-align: center;
    max-width: 480px;
    width: 90%;
    opacity: 0;
    transform: translateY(40px);
    animation: fadeUp 0.8s ease forwards;
  }

  .logout-container h2 {
    font-weight: 700;
    color: #1C1C1C;
    margin-bottom: 20px;
  }

  .btn-custom {
    background-color: #D4AF37;
    color: #1C1C1C;
    border-radius: 8px;
    padding: 10px 25px;
    border: none;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    box-shadow: 0 0 10px rgba(212,175,55,0.4);
  }

  .btn-custom:hover {
    background-color: #B9962F;
    color: #F5EBDD;
    transform: scale(1.05);
    box-shadow: 0 0 15px rgba(185,150,47,0.5);
  }

  @keyframes fadeUp {
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  footer {
    background-color: #1C1C1C !important;
    color: #F5EBDD !important;
    text-align: center;
    padding: 15px 0;
  }
</style>

<div class="content-wrapper">
  <div class="logout-container">
    <h2>You have been logged out successfully.</h2>
    <a href="login.php" class="btn btn-custom">Login Again</a>
  </div>
</div>

<?php include('includes/footer.php'); ?>
