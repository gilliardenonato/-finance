// Seleciona o novo input
const dateInputUpdate = document.querySelector("#dateInput-update");

// Adiciona a validação de data
dateInputUpdate.onchange = function () {
  const selectedDate = new Date(dateInputUpdate.value);
  const currentDate = new Date();
  if (selectedDate > currentDate) {
    const small = document.querySelector('.errorMsg-update')
    small.style.visibility = 'visible'
    small.style.display    = 'block'
    small.innerText = 'digite uma data valida*'
    small.style.color = '#DB5A5A'
    dateInputUpdate.value = "";
  } else {
    const small = document.querySelector('.errorMsg-update')
    small.style.visibility = 'hidden'
  }
}

// Adiciona a máscara
$(document).ready(function () {
  $('#valor, #valor-update').mask('#.##0,00', { reverse: true });
});