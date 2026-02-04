<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Main Page</title>
</head>

<body style="
  margin:0;
  font-family:Arial, sans-serif;

  background-image: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.5)), url('img.jfif');
  background-position:center;
  background-size: cover;
  background-repeat: no-repeat;
  background-attachment: fixed;
  

  display:flex;
  flex-direction:column;
  min-height:100vh;
">

<?php include 'nav.php'; ?>
<!-- MAIN -->
<main style="
  flex:1;
  padding:10rem 7.5rem;
  text-align:center;
">

  <h2 style="
    font-size:14rem;
    margin-top: 20rem;
    margin-bottom:12rem;
    color:#f2f0ef;
  ">
    Welcome to SAHYOG
  </h2>

  <p style="
    font-size:8rem;
    margin-bottom:4rem;
    color:#ffffff;
  ">
    JOIN US
  </p>

  <div style="
    display:flex;
    gap:2.5rem;
    justify-content:center;
    flex-wrap:wrap;
  ">
    <a href="5_Signup.php">
      <button style="
        padding:4rem 7rem;
        background:#e05a00;
        border:none;
        border-radius:3rem;
        font-size:3rem;
        font-weight:bold;
        color:#ffffff;
        cursor:pointer;
        margin-right: 20px;
      ">
        SIGN UP
      </button>
    </a>

    <a href="6_Login.php">
      <button style="
        margin-left: 10px;
        padding:4rem 8rem;
        background:#e05a00;
        border:none;
        border-radius:3rem;
        font-size:3rem;
        font-weight:bold;
        color:#ffffff;
        cursor:pointer;
      ">
        LOGIN
      </button>
    </a>
  </div>

</main>

<!-- FOOTER -->
<footer style="
  background:#161516;
  text-align:center;
  padding:2.5rem;
  font-size:3.1rem;
  color:#ffffff;
  box-shadow:0 -2px 5px rgba(0,0,0,0.1);
">
  &copy; 2025 Sahyog. All rights reserved.
</footer>

</body>
</html>
