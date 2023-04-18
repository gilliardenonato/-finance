<?php
include_once('assets/php/includes_php/validate_session.php');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Gestão Financeira</title>
  <link rel="stylesheet" href="assets/css/dashboard.css">
  <link rel="stylesheet" href="assets/css/dashboard-responsive.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  </link>
</head>

<body>

  <header>

    <nav>
      <div class="wrapper">
        <div class="logo">
          <a href="#">Logo</a>
        </div>
        <ul class="nav_links">
          <li class="nav-item">
            <a href="#">
              <?php echo $_SESSION['usuario'] ?>
            </a>
            <ul class="drop_menu">
              <li><a href="assets/php/action_php/logout.php" class="logout">Sair</a></li>
            </ul>
          </li>
        </ul>
        <div class="mobile-menu-icon">
          <button><img class="icon" src="assets/img/menu_white_36dp.svg" alt=""></button>
        </div>
      </div>
    </nav>
    <div class="mobile-menu">
      <ul>
        <li class="nav-item"><a href="assets/php/action_php/logout.php" class="nav-link" class="logout">Sair</a></li>
      </ul>
    </div>
  </header>




  <section>
    <div class="main-options">
      <div class="reference-month"></div>
      <div class="form-control-reference">
        <div class="select-control">
          <select name="select" required id="month" name="month">
            <option value="00" disabled selected>Mês para Filtro</option>
          </select>
        </div>
      </div>
      <div class="search-container">
        <i class="bi bi-search" aria-hidden="true"></i>
        <input type="text" name="search" placeholder="Filtrar Registros" autocomplete="off" class="search-input">
      </div>

      <button class="btn-open">+ Novo Registro</button>

    </div>



    <div class="modal-container">
      <div class="modal">
        <div class="modal-header">
          <h2>Registro</h2>
          <span class="close-modal"><i class="bi bi-x" id="header-icon-close"></i></span>
        </div>
        <hr>

        <div class="modal-content">
          <form action="assets/php/action_php/create.php" method="post" id="form-create">
            <div class="form-control-selects">
              <label class="form-label" for="dateInput">Data do lançamento</label>
              <input type="date" name="date" id="dateInput" required>
              <small class="errorMsg">Error message</small>
            </div>

            <div class="form-control">
              <label for="select">Tipo</label>
              <div class="select-control">
                <select name="select" required>
                  <option value="" disabled selected>Selecione</option>
                  <option value="renda">renda</option>
                  <option value="despesa">despesa</option>
                </select>
              </div>
            </div>

            <div class="form-control">
              <label for="select-sub">sub tipo</label>
              <div class="select-control">
                <select name="select-sub" required>
                  <option value="" disabled selected>Selecione</option>
                  <option value="Previsto">previsto</option>
                  <option value="Extra">extra</option>
                </select>
              </div>
            </div>

            <div class="form-control-selects">
              <label class="form-label" for="desc">Descrição breve</label>
              <input type="text" name="desc" placeholder="descrição breve do registro" id="desc" required>
            </div>

            <div class="form-control-selects">
              <label class="form-label" for="long-desc">Descrição longa</label>
              <input type="text" name="desc-detalhada" placeholder="descrição detalhada do registro [opcional]" id="long-desc">
            </div>

            <div class="form-control-selects">
              <label class="form-label" for="valor">Valor</label>
              <input type="text" name="valor" id="valor" placeholder="digite o valor R$" max="9" required>
            </div>



            <div class="popup-success-create">
              <div class="content-popup-create">
                <p class="popup">registro adicionado com sucesso</p>
              </div>
            </div>

          </form>
        </div>

        <hr>
        <div class="btns">
          <button class="close-modal" id="button-close">Cancelar</button>
          <button id="buttonOk" form="form-create">Salvar</button>
        </div>
      </div>
    </div>



    <div class="resumo">
      <div class="resume-cards">
        <p class="resume-header">Despesas</p>
        <div class="resume-body">
          <i class="bi bi-box-arrow-right"></i>
          <span>R$</span>
          <p class="expenses">0,00</p>
        </div>
      </div>
      <div class="resume-cards">
        <p class="resume-header">Lucro</p>
        <div class="resume-body">
          <i class="bi bi-cash-stack"></i>
          <span>R$</span>
          <p class="income">0,00</p>
        </div>
      </div>
      <div class="resume-cards">
        <p class="resume-header">Balanço</p>
        <div class="resume-body">
          <i class="bi bi-bank"></i>
          <span>R$</span>
          <p class="profit">0,00</p>
        </div>
      </div>
    </div>

    <div class="table-responsive custom-table-responsive" style="overflow-x:auto;">
      <table class="table custom-table" id="my-table">

        <thead>
          <tr>
            <th>DATA LANÇAMENTO </th>
            <th>TIPO</th>
            <th>SUBTIPO</th>
            <th>DESCRIÇÃO</th>
            <th>VALOR LANÇAMENTO</th>
          </tr>
        </thead>
        <tbody class='table-informations' id="table-body">
          <?php
          include_once('assets/php/crud_php/read.php');
          ?>
          <button class="relatorio btn-open-relatorio">
            Relatorio
          </button>
        </tbody>

        <div id="my-modal-read" class="modal-reading modal-icones">
          <div class="modal-content-reading">
            <div class="modal-header-table">
              <h2>detalhes lançamentos</h2>
              <span class="close-modal-read" id="close-button-read">&times;</span>
            </div>
            <div class="modal-body-read">
              <p id="content-modal" class="loung-description"></p>
            </div>
            <div class="modal-footer-reading">
              <button class="btn-cancel close-modal-read">ok</button>
            </div>
          </div>
        </div>


        <div id="my-modal-update" class="modal-update modal-icones">
          <div class="modal-content-update">
            <div class="modal-header-table">
              <h2>alterar lançamento</h2>
              <span class="close-modal-update" id="close-button-update">&times;</span>
            </div>
            <div class="modal-body-update">

              <form id="form-update">


                <div class="form-control-selects">
                  <label class="form-label" for="dateInput-update">Data do lançamento</label>
                  <input type="date" name="date-update" id="dateInput-update" required>
                  <small class="errorMsg-update">Error message</small>
                </div>

                <div class="form-control">
                  <label for="select-update">Tipo</label>
                  <div class="select-control">
                    <select name="select-update" required id="type">
                      <option value="" disabled selected>Selecione</option>
                      <option value="renda">renda</option>
                      <option value="despesa">despesa</option>
                    </select>
                  </div>
                </div>

                <div class="form-control">
                  <label for="select-sub-update">sub tipo</label>
                  <div class="select-control">
                    <select name="select-sub-update" required id="subtype">
                      <option value="" disabled selected>Selecione</option>
                      <option value="Previsto">previsto</option>
                      <option value="Extra">extra</option>
                    </select>
                  </div>
                </div>

                <div class="form-control-selects">
                  <label class="form-label" for="desc-update">Descrição breve</label>
                  <input type="text" name="desc-update" placeholder="descrição breve do registro" id="desc-update" required>
                </div>

                <div class="form-control-selects">
                  <label class="form-label" for="long-desc-update">Descrição longa</label>
                  <input type="text" name="desc-detalhada-update" placeholder="descrição detalhada do registro [opcional]" id="long-desc-update">
                </div>

                <div class="form-control-selects">
                  <label class="form-label" for="valor-update">Valor</label>
                  <input type="text" name="valor-update" id="valor-update" placeholder="digite o valor R$"min="0" max="10000" step="0.01" required>
                </div>


                <div class="popup-success-update">
                  <div class="content-popup-update">
                    <p class="popup-update">registro alterado com sucesso</p>
                  </div>
                </div>

              </form>

            </div>
            <hr>
            <div class="btns btns-footer">
              <button class="btn-cancel close-modal-delete" id="button-close">Cancelar</button>
              <button class="btn-update-confirm" id="buttonOk" form="form-update">Salvar</button>
            </div>
          </div>

        </div>



        <div id="my-modal-delete" class="modal-delete modal-icones">
          <div class="modal-content-delete">
            <div class="modal-header-table">
              <h2>Excluir lançamento</h2>
              <span class="close-modal-delete" id="close-button-delete">&times;</span>
            </div>
            <div class="modal-body-delete">
              <p id="content-modal">Tem certeza de que deseja excluir este lançamento?</p>
            </div>
            <div class="modal-footer-delete">
              <button class="btn-delete-confirm">Sim</button>
              <button class="btn-cancel close-modal-delete">Não</button>
            </div>
          </div>
        </div>


        <div id="modal-relatorio" class="modal-relatorio modal-icones">
          <div class="modal-content-relatorio">
            <div class="modal-header-table">
              <h2>Relatorio</h2>
              <span class="close-modal-relatorio" id="close-button-relatorio">&times;</span>
            </div>
            <div class="modal-body-relatorio">
              <div id="content-modal-relatory"></div>
            </div>
            <div class="modal-footer-relatorio">
              <button class="btn-cancel close-modal-relatorio">close</button>
              <button id="gerar-PDF">Gerar PDF</button>
            </div>
          </div>
        </div>

      </table>
    </div>
  </section>



  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://kit.fontawesome.com/6abdafcf4c.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.2/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.2/vfs_fonts.js"></script>
  <script src="assets/js/index.js"></script>
  <script src="assets/js/form_update_validation.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>

</body>

</html>