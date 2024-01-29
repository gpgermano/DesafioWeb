function validarFormularioPessoa() {
    var nome = document.getElementById('nome').value.trim();
    var sobrenome = document.getElementById('sobrenome').value.trim();

    if (nome === '' || sobrenome === '') {
        alert('Por favor, preencha todos os campos.');
        return false; // Impede o envio do formulário se os campos estiverem vazios
    } 
    return true; 
}
document.getElementById('lotacaoEvento').addEventListener('change', function() {
    // Obtém o valor atual do campo de entrada
    var valorLotação = parseInt(this.value);

    // Verifica se o valor é negativo
    if (valorLotação < 0) {
        // Define o valor do campo como 0 (ou qualquer outro valor desejado)
        this.value = 0;
    }
});

document.getElementById('lotacaoCafe').addEventListener('change', function() {
    // Obtém o valor atual do campo de entrada
    var valorLotação = parseInt(this.value);

    // Verifica se o valor é negativo
    if (valorLotação < 0) {
        // Define o valor do campo como 0 (ou qualquer outro valor desejado)
        this.value = 0;
    }
});

document.getElementById('Cadastropessoa').addEventListener('submit', function(event) {
    event.preventDefault(); // Impede o envio padrão do formulário

    var nomeInput = document.getElementById('nome').value;
    var sobrenomeInput = document.getElementById('sobrenome').value;
    var regex = /^[a-zA-Z\s]*$/; // Expressão regular para permitir apenas letras e espaços

    if (!regex.test(nomeInput)) {
        alert('Por favor, insira apenas letras e espaços no campo de nome.');
        return;
    }

    if (!regex.test(sobrenomeInput)) {
        alert('Por favor, insira apenas letras e espaços no campo de sobrenome.');
        return;
    }

    // Se a validação passar, você pode enviar o formulário ou executar outras ações aqui
    console.log('Nome válido: ' + nomeInput);
    console.log('Sobrenome válido: ' + sobrenomeInput);
    // this.submit(); // Se você deseja enviar o formulário após a validação, descomente esta linha
});