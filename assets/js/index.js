
function toggleMobileMenu(iconSelector, menuSelector) {
  const menuIcon = document.querySelector(iconSelector);
  const mobileMenu = document.querySelector(menuSelector);

  menuIcon.addEventListener("click", function () {
    const isOpen = mobileMenu.classList.contains('open');
    mobileMenu.classList.toggle('open');
    const iconSrc = isOpen ? "assets/img/menu_white_36dp.svg" : "assets/img/close_white_36dp.svg";
    menuIcon.src = iconSrc;

  });
}

toggleMobileMenu(".icon", ".mobile-menu");

/*  filtro de meses + atualização dos cards */

// Função para atualizar a tabela com dados do servidor
function updateTable(select, month) {
  const referenceMonth = document.querySelector('.reference-month');
  fetch(`assets/php/crud_php/read.php?month=${month}`)
    .then(response => response.text())
    .then(data => {
      const tableBody = document.getElementById('table-body');
      tableBody.innerHTML = data;
      addViewIconClick();
      addDeleteClick();
      addUpdateClick();
      referenceMonth.textContent = select.options[select.selectedIndex].text;
    })
    .catch(error => console.error(error));
}

// Função para atualizar os cartões com dados do servidor
function updateCards(month) {
  fetch(`assets/php/action_php/cards.php?month=${month}`)
    .then(response => response.json())
    .then(data => {
      const expenses = data.expenses;
      const income = data.income;
      const profit = data.profit;

      document.querySelector('.expenses').innerHTML = expenses;
      document.querySelector('.income').innerHTML = income;
      document.querySelector('.profit').innerHTML = profit;
    })
    .catch(error => console.error(error));
}

// Manipulador de eventos para alterações no seletor de mês
function handleMonthChange() {
  const select = document.getElementById('month');
  const month = select.value;
  localStorage.setItem('selectedMonth', month);
  const referenceMonth = document.querySelector('.reference-month');
  if (month !== '00') {
    updateTable(select, month);
    updateCards(month);
    referenceMonth.textContent = select.options[select.selectedIndex].text;
  }
}

// Adicionar o manipulador de eventos ao seletor de mês
const filterMonth = document.querySelector("#month");
filterMonth.addEventListener("change", handleMonthChange);



function restoreSelectedMonth() {
  const select = document.getElementById('month');
  const defaultMonth = '00';
  const selectedMonth = localStorage.getItem('selectedMonth') || defaultMonth;
  select.value = selectedMonth;
  select.dispatchEvent(new Event('change'));

}

/* salvar o mes selecionado*/

document.addEventListener("DOMContentLoaded", () => {
  const select = filterMonth;
  const months = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];

  // Obter a data atual
  const today = new Date();

  // Iterar retroativamente 12 meses e gerar as opções do select
  for (let i = 0; i < 12; i++) {
    const date = new Date(today.getFullYear(), today.getMonth() - i, 1);
    const year = date.getFullYear();
    const month = date.getMonth();
    const option = document.createElement("option");
    option.value = `${year}-${month < 9 ? "0" : ""}${month + 1}`;
    option.text = `${months[month]} ${year}`;
    select.appendChild(option);
  }

  restoreSelectedMonth();
  // Executar a função de inicialização uma vez para carregar os dados iniciais
  handleMonthChange();
});




/*campo de pesquisa*/



function searchTable(searchInput, tabelaInfo, resumo) {
  searchInput.addEventListener('keyup', () => {
    resumo.style.display = 'none'
    let searchInputValue = searchInput.value.toLowerCase()

    /* vai buscar dentro do TBODY os tr que é onde estão as informações da tabela*/
    let tableValues = tabelaInfo.getElementsByTagName('tr')

    /* agora percorrer linha por linha as do tr */
    for (let posicao in tableValues) {
      if (true === isNaN(posicao)) {
        continue;
      }
      let contentLine = tableValues[posicao].innerHTML.toLowerCase()
      if (true === contentLine.includes(searchInputValue)) {
        tableValues[posicao].style.display = '';

      } else {
        tableValues[posicao].style.display = 'none';

      }
    }
  })

  searchInput.addEventListener('blur', () => {
    resumo.style.display = ''
  })
}

// Exemplo de como usar a função
const searchInput = document.querySelector('.search-input')
const tabelaInfo = document.querySelector('.table-informations')
const resumo = document.querySelector('.resumo')
searchTable(searchInput, tabelaInfo, resumo)



/*  modal lançamentos */


const modalContainer = document.querySelector('.modal-container');
const showModalbtn = document.querySelector('.btn-open');
const closeModal = document.querySelectorAll('.close-modal');

function openModal() {
  modalContainer.classList.add('active');
}

function closeModalContainer() {
  modalContainer.classList.remove('active');
}

showModalbtn.addEventListener('click', openModal);

for (let i = 0; i < closeModal.length; i++) {
  closeModal[i].addEventListener("click", closeModalContainer);
}

/* Validação de Data */

const dateInput = document.querySelector("#dateInput");

dateInput.addEventListener('input', function () {
  const selectedDate = new Date(dateInput.value);
  const currentDate = new Date();
  const small = document.querySelector('.errorMsg');

  if (isNaN(selectedDate)) {
    small.innerText = 'Digite uma data válida*';
    small.style.display = 'block';
    small.style.color = '#DB5A5A';
    return;
  } else {
    small.style.display = 'none';
  }

  if (selectedDate > currentDate) {
    small.innerText = 'Digite uma data anterior ou igual à data atual';
    small.style.display = 'block';
    small.style.color = '#DB5A5A';
    dateInput.value = "";
  } else {
    small.style.display = 'none';
  }
});

/* Máscara de Valor */

$(document).ready(function () {
  $('#valor').mask('#.##0,00', { reverse: true });
});



function createTransaction(event) {

  event.preventDefault();
  const form = event.target;
  const formData = new FormData(form);
  $.LoadingOverlay("show")

  fetch("assets/php/crud_php/create.php", {
    method: "POST",
    body: formData
  })
    .then(response => response.json())
    .then(data => {

      if (data.status === 'success') {
        const successModal = document.querySelector('.popup-success-create');

        successModal.style.visibility = 'visible';
        successModal.classList.add('animate');

        successModal.style.visibility = 'hidden';
        form.reset();
        modalContainer.classList.remove('active');
        location.reload();


      } else if (data.status === 'error') {
        alert(data.message)
      }
    })
    .catch(error => {
      console.error(error);
    }).finally(() => {
      $.LoadingOverlay("hide")
    })
}


document.getElementById("form-create").addEventListener("submit", createTransaction);


// função para adicionar evento de clique em ícones de visualização
function addViewIconClick() {
  const viewIcons = document.querySelectorAll('.view-icon');
  viewIcons.forEach(viewIcon => {
    viewIcon.addEventListener('click', async () => {
      const releaseId = viewIcon.dataset.id;
      const modal = document.getElementById('my-modal-read');
      const modalContent = modal.querySelector('.loung-description');
      try {
        const response = await fetch(`assets/php/crud_php/read.php?release_id=${releaseId}`);
        const data = await response.text();
        modalContent.innerHTML = data || 'Você não adicionou nenhuma descrição extra a esse lançamento :(';
        modal.style.display = 'block';
        console.log(response)
      } catch (error) {
        console.error('Erro ao recuperar a long_description: ', error);
      }finally {
        $.LoadingOverlay("hide");
      }
    })
  })
}

function addUpdateClick() {
  const updateIcons = document.querySelectorAll('.update-icon');
  updateIcons.forEach(updateIcon => {
    updateIcon.addEventListener('click', async () => {
      const releaseId = updateIcon.dataset.id;
      const modalUpdate = document.querySelector('#my-modal-update');
      modalUpdate.style.display = 'block';
      await retrievePostingData(releaseId);

      const formUpdate = document.querySelector('#form-update');
      formUpdate.addEventListener('submit', async (event) => {
        event.preventDefault();
        const formData = new FormData(formUpdate);
        formData.append('release_id', releaseId);
        try {
          const response = await fetch('assets/php/crud_php/update.php', {
            method: 'POST',
            body: formData
          });
          const data = await response.json();
          if (data.status === 'success') {
            const successModal = document.querySelector('.popup-success-update');
            successModal.style.visibility = 'visible';
            successModal.classList.add('animate');
            successModal.style.visibility = 'hidden';
            location.reload();
          } else if (data.status === 'error') {
            alert(data.message)
          }
        } catch (error) {
          console.error(error);
        }
      })
    });
  });
}

async function retrievePostingData(releaseId) {
  try {
    const response = await fetch(`assets/php/action_php/get_release_data.php?id=${releaseId}`);
    const data = await response.json();
    // preenche os campos do formulário com os valores retornados pela consulta
    document.querySelector('#dateInput-update').value = data.datetime;
    document.querySelector('#type').value = data.type;
    document.querySelector('#subtype').value = data.subtype;
    document.querySelector('#desc-update').value = data.description;
    document.querySelector('#long-desc-update').value = data.long_description;
    document.querySelector('#valor-update').value = data.launch_value;
  } catch (error) {
    console.error(error);
  }
}

function addDeleteClick() {
  const deleteIcons = document.querySelectorAll('.delete-icon');
  deleteIcons.forEach(deleteIcon => {
    deleteIcon.addEventListener('click', () => {
      const releaseId = deleteIcon.dataset.id;
      const modalDelete = document.querySelector('#my-modal-delete');
      modalDelete.style.display = 'block';
      const confirmaButton = document.querySelector('.btn-delete-confirm');
      confirmaButton.addEventListener("click", async () => {
        try {
          const response = await fetch(`assets/php/crud_php/delete.php?release_id=${releaseId}`);
          const data = await response.text();
          location.reload();
        } catch (error) {
          console.error('Erro ao excluir o registro: ', error);
        }
      });
    });
  });
}


function closePopUp() {
  document.querySelectorAll('.close-modal-read, .close-modal-update, .close-modal-delete, .close-modal-relatorio').forEach(closeButton => {
    closeButton.addEventListener('click', () => {
      closeButton.closest('.modal-icones').style.display = 'none';
    });
  });
}
closePopUp()

const logoutBtns = document.querySelectorAll('.logout');

logoutBtns.forEach(btn => {
  btn.addEventListener('click', () => {
    if (localStorage.getItem('selectedMonth')) {
      localStorage.removeItem('selectedMonth');
    }
  });
});

const months = [
  'Janeiro', 'Fevereiro', 'Março', 'Abril',
  'Maio', 'Junho', 'Julho', 'Agosto',
  'Setembro', 'Outubro', 'Novembro', 'Dezembro'
];

document.querySelector('#gerar-PDF').addEventListener('click', () => {
  // Faça uma requisição para o servidor e obtenha os dados da tabela
  fetch('assets/php/action_php/relatorio.php?get_reports=true')
    .then(response => response.json())
    .then(data => {
      // Crie um novo documento pdfmake
      const docDefinition = {
        content: [
          { text: 'Relatório de Lançamentos', style: 'header' },
          { text: new Date().toLocaleDateString(), style: 'subheader' },
          '\n\n',
          {
            table: {
              headerRows: 1,
              widths: ['*', '*', '*', '*'],
              body: [
                [
                  'Mês/Ano',
                  'Lucro',
                  'Despesas',
                  'Balanço'
                ],
                ...data.map(rowData => {
                  const monthName = months[rowData.month - 1]; // Obtenha o nome do mês
                  return [
                    `${monthName}/${rowData.year}`,
                    rowData.income ? `R$ ${rowData.income.replace(',', '.').replace('.', ',')}` : '-',
                    rowData.expenses ? `R$ ${rowData.expenses.replace(',', '.').replace('.', ',')}` : '-',
                    `R$ ${rowData.profit.replace(',', '.').replace('.', ',')}`
                  ]
                })
              ]
            }
          }
        ],
        styles: {
          header: {
            fontSize: 18,
            bold: true,
            alignment: 'center'
          },
          subheader: {
            fontSize: 14,
            bold: true,
            alignment: 'center'
          }
        }
      };

      // Gere o PDF e faça o download
      pdfMake.createPdf(docDefinition).download('Relatório de Lançamentos.pdf');

      // Abra o PDF em uma nova aba
      pdfMake.createPdf(docDefinition).getBlob(blob => {
        const pdfUrl = URL.createObjectURL(blob);
        window.open(pdfUrl);
      });
    });
});


function relatorio() {
  const relatorioButton = document.querySelector('.relatorio');
  const modalrelatorio = document.querySelector('#modal-relatorio');
  const modalContentRelatory = document.querySelector("#content-modal-relatory");

  // Array com os nomes dos meses
  const meses = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];

  // Função para criar a tabela HTML com os dados
  const criarTabelaHTML = (data) => {
    let html = '<table><thead><tr><th>Data lançam.</th><th>Lucro</th><th>Despesas</th><th>Balanço</th></tr></thead><tbody>';

    data.forEach(rowData => {
      const month = meses[parseInt(rowData.month) - 1]; // Obtem o nome do mês correspondente
      const row = `
        <tr>
          <td>${month}/${rowData.year}</td>
          <td>${rowData.income ? `R$ ${(rowData.income)}` : '-'}</td>
          <td>${rowData.expenses ? `R$ ${(rowData.expenses)}` : '-'}</td>
          <td>${`R$ ${(rowData.profit)}`}</td>
        </tr>
      `;
      html += row;
    });

    html += '</tbody></table>';
    return html;
  };

  relatorioButton.addEventListener("click", () => {
    modalrelatorio.style.display = 'block';

    // Requisição para obter os dados da tabela
    fetch('assets/php/action_php/relatorio.php?get_reports=true')
      .then(response => response.json())
      .then(data => {
        // Cria a tabela HTML com os dados obtidos
        const tabelaHTML = criarTabelaHTML(data);
        // Adiciona a tabela à div
        modalContentRelatory.innerHTML = tabelaHTML;
      })
      .catch(error => {
        // Trata o erro na requisição
        console.error(error);
        modalContentRelatory.innerHTML = '<p>Não foi possível obter os dados da tabela.</p>';
      });
  });
}

relatorio();

