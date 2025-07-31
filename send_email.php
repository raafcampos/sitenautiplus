<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Limpa e valida os dados do formulário
    $name = strip_tags(trim($_POST["name"]));
    $name = str_replace(array("\r","\n"),array(" "," "),$name);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = trim($_POST["phone"]);
    $message = trim($_POST["message"]);

    // Verifica se os dados essenciais foram enviados
    if ( empty($name) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Define um código de resposta 400 (bad request) e encerra o script
        http_response_code(400);
        echo "Por favor, preencha o formulário corretamente e tente novamente.";
        exit;
    }

    // Defina o endereço de e-mail do destinatário
    $recipient = "contato@gruponautiplus.com";

    // Defina o assunto do e-mail
    $subject = "Nova mensagem de contato de $name";

    // Construa o corpo do e-mail
    $email_content = "Nome: $name\n";
    $email_content .= "Email: $email\n";
    if (!empty($phone)) {
        $email_content .= "Telefone: $phone\n";
    }
    $email_content .= "\nMensagem:\n$message\n";

    // Construa os cabeçalhos do e-mail
    $email_headers = "From: contato@gruponautiplus.com\r\n";
    $email_headers .= "Reply-To: $email\r\n";
    $email_headers .= "Content-Type: text/plain; charset=UTF-8";

    // Envie o e-mail
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        // Define um código de resposta 200 (ok)
        http_response_code(200);
        echo "Obrigado! Sua mensagem foi enviada com sucesso.";
    } else {
        // Define um código de resposta 500 (internal server error)
        http_response_code(500);
        echo "Oops! Algo deu errado e não conseguimos enviar sua mensagem.";
    }

} else {
    // Se não for uma requisição POST, define um código 403 (forbidden)
    http_response_code(403);
    echo "Houve um problema com o envio. Por favor, tente novamente.";
}
?>