<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>AI Academic Portal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Navbar Styling */
    .navbar {
      background-color: #1C1C1C; /* Deep black */
      padding: 10px 0;
      box-shadow: 0 3px 8px rgba(0,0,0,0.25);
    }

    .navbar-brand {
      color: #D4AF37 !important; /* Gold */
      font-weight: 700;
      letter-spacing: 0.5px;
      font-size: 1.3rem;
      transition: color 0.3s ease;
    }

    .navbar-brand:hover {
      color: #F5EBDD !important;
    }

    .nav-link {
      color: #F5EBDD !important; /* Light beige */
      font-weight: 500;
      margin: 0 12px;
      transition: all 0.3s ease;
    }

    .nav-link:hover,
    .nav-link.active {
      color: #D4AF37 !important;
      transform: translateY(-1px);
    }

    .navbar-toggler {
      border-color: #D4AF37;
    }

    .navbar-toggler-icon {
      background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30'
      xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgb(212,175,55)'
      stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4
      15h22M4 23h22'/ %3E%3C/svg%3E");
    }

    body {
      background: linear-gradient(135deg, #F5EBDD, #F3E2C7);
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
      <a class="navbar-brand" href="index.php">AI Academic Portal</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
          <li class="nav-item"><a href="programs.php" class="nav-link">Programs</a></li>
          <li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
          <li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>
