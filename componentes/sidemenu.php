<body>
  <nav class="sidebar col-md-2 d-none d-md-block bg-light">
    <ul class="nav nav-pills flex-column bg-light vh-100">
      <li class="nav-item">
        <h3 class="text-secondary py-3">
          SalvaAi
        </h3>
      </li>
      <li class="nav-item">
        <a href="./home.php" class="nav-link active">
          <i class="bi bi-house" style="font-size: 1.5rem; margin-right: 1rem;"></i>Inicio</a>
      </li>
      <li class="nav-item dropdown mb-auto">
        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" id="finDrop"><i class="bi bi-credit-card" style="font-size: 1.5rem; margin-right: 1rem;"></i>Finanças</a>
        <ul class="dropdown-menu ms-5">
          <li>
            <a href="#" name="tipo" id="tipo" value="entrada" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#entradaModal"><i class="bi bi-plus-circle" style="font-size: 1.5rem; margin-right: 10px;"></i>Nova entrada</a>
          </li>
          <li>
            <a href="#" name="tipo" id="tipo" value="saida" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#saidaModal"><i class="bi bi-download" style="font-size: 1.5rem; margin-right: 10px;"></i>Saida</a>
          </li>
          <div class="d-flex flex-column align-items-start ">
          </div>
        </ul>
      </li>
      <li class="btn-group dropup">
        <a class="nav-link dropdown-toggle text-primary" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" id="userDrop"><i class="bi bi-person" style="font-size: 1.5rem; margin-right: 1rem;"></i><?= ucfirst($_SESSION['userL']) ?></a>
        <ul class="dropdown-menu" aria-labelledby="userDrop">
          <li>
            <a href="./usuario/logout.php" class="dropdown-item">Sair</a>
          </li>
      </li>
    </ul>
  </nav>
</body>