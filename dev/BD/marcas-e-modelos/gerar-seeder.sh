#!/bin/bash

#forma de usar este script:
#./gerar-seeder.sh > seeder_output2.txt

# Criar arrays associativos para mapear ID da marca para nome
declare -A marcas

# Ler o arquivo de marcas (ignorando a primeira linha de cabeçalho)
while IFS=';' read -r id nome; do
    # Remover o BOM e quebras de linha
    id=$(echo "$id" | sed 's/^\xEF\xBB\xBF//' | tr -d '\r')
    nome=$(echo "$nome" | tr -d '\r')
    # Ignorar o cabeçalho
    if [[ "$id" != "ID" ]]; then
        marcas["$id"]="$nome"
    fi
done < "marcas-carros.csv"

# Processar o arquivo de modelos e gerar o seeder
while IFS=';' read -r id idmarca nome; do
    # Remover o BOM e quebras de linha
    id=$(echo "$id" | sed 's/^\xEF\xBB\xBF//' | tr -d '\r')
    idmarca=$(echo "$idmarca" | tr -d '\r')
    nome=$(echo "$nome" | tr -d '\r')
    # Ignorar o cabeçalho
    if [[ "$id" != "ID" ]]; then
        fabricante="${marcas[$idmarca]}"
        if [[ -n "$fabricante" ]]; then
            echo "['fabricante' => '$fabricante', 'modelo' => '$nome', 'created_at' => now(), 'updated_at' => now()],"
        else
            echo "Marca não encontrada para ID $idmarca - Modelo: $nome" >&2
        fi
    fi
done < "modelos-carros.csv"
