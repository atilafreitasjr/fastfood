#!/bin/bash

# 1. Navega para o diretório do projeto
cd ~/Documentos/projetos/estacionamento || { echo "Diretório não encontrado"; exit 1; }

# 2. Inicia os containers do Sail
echo "Iniciando containers Docker..."
./vendor/bin/sail up -d

# 3. Verifica se os containers iniciaram corretamente
if [ $? -ne 0 ]; then
    echo "Erro ao iniciar containers Docker"
    exit 1
fi

# 4. Espera 10 segundos para garantir que todos os serviços estejam prontos
echo "Aguardando inicialização dos serviços..."
sleep 5

# 5. Inicia o servidor Vite
echo "Iniciando servidor de desenvolvimento Vite..."
./vendor/bin/sail npm run dev > vite.log 2>&1 &

# 6. Aguarda mais 3 segundos para o Vite iniciar completamente
sleep 5

# 7. Abre o navegador padrão no endereço localhost
echo "Abrindo navegador em http://localhost..."
google-chrome --start-fullscreen http://localhost || \
chromium-browser --start-fullscreen http://localhost || \
xdg-open http://localhost
xdg-open http://localhost || {
    echo "Não foi possível abrir o navegador automaticamente"
    echo "Por favor, acesse manualmente: http://localhost"
}

# 8. Mostra mensagem de sucesso
echo "----------------------------------------"
echo "Serviços iniciados com sucesso!"
echo "- Aplicação aberta no navegador"
echo "- Servidor Vite rodando na porta 5174"
echo "- Logs do Vite disponíveis em: vite.log"
echo "----------------------------------------"

# 9. Mantém o script rodando para manter os serviços ativos
tail -f /dev/null