Aqui está uma versão aprimorada e mais técnica do seu `README.md` para o projeto Asaas Payment, em português:

---

# Asaas Payment - Guia de Instalação

## Requisitos do Sistema

Para instalar e executar com sucesso a aplicação Asaas Payment, certifique-se de que seu ambiente atenda aos seguintes requisitos:

-   **PHP**: Versão 8.3.12 ou superior
-   **Composer**: Gerenciador de dependências para PHP
-   **Configuração do php.ini**: Certifique-se de que as seguintes extensões estejam habilitadas:
    -   `curl`
    -   `ftp`
    -   `fileinfo`
    -   `intl`
    -   `mbstring`
    -   `exif`
    -   `mysqli`
    -   `pdo_mysql`
    -   `openssl`
    -   `zip`
-   **Diretório de Extensão**: Defina o diretório de extensão no seu arquivo `php.ini`:
    ```
    extension_dir = "ext"
    ```

## Passos de Instalação

Siga estes passos para configurar o projeto Asaas Payment:

1. **Clonar o Repositório**:

    ```bash
    git clone <url-do-repositorio>
    ```

2. **Navegar até a Pasta Raiz do Projeto**:
   Certifique-se de que você está na pasta raiz do projeto clonado.

    ```bash
        cd <pasta-do-projeto>
    ```

3. **Configurar o Arquivo de Ambiente**:
   Renomeie o arquivo de exemplo de ambiente:

    ```bash
    mv .env.example .env
    ```

4. **Instalar Dependências**:
   Abra seu terminal ou prompt de comando e execute:

    ```bash
    composer install
    ```

5. **Alterar hosts**:
   Abra o arquivo hosts (C:\Windows\System32\drivers\etc\hosts) e adicione o DNS:

    ```bash
    127.0.0.1       api.asaas-payments.local
    ```

6. **Executar a Aplicação**:
   Inicie o servidor de desenvolvimento local com:
    ```bash
    php artisan serve --host=api.asaas-payments.local --port=8000
    ```

# Integração com as APIs

## Pré-requisitos

-   URL: http://api.asaas-payments.local:8000/api

## Endpoints

### Client

#### Listar todos

-   **Método:** GET
-   **Endpoint:** /client
-   **Resposta:**
    -   `status`: 200 - OK

```json
{
    "message": "Sucesso",
    "data": [
        [
            {
                "id": 1,
                "name": "Denis Cury",
                "document": "17246279024",
                "email": "denis.cury.1999@hotmail.com",
                "phone": "14998326012",
                "postal_code": "18800000",
                "address": "Rua Israel dos Santos Guerra",
                "address_number": "150",
                "customer_id": "cus_000006298156"
            },
            {
                "id": 2,
                "name": "Denis Cury",
                "document": "18050029026",
                "email": "denis.cury.1998@hotmail.com",
                "phone": "14998326013",
                "postal_code": "18800000",
                "address": "Rua Israel dos Santos Guerra",
                "address_number": "150",
                "customer_id": "cus_000006298159"
            },
            {
                "id": 3,
                "name": "Maria Antonieta",
                "document": "84335177089",
                "email": "denis.cury.1997@hotmail.com",
                "phone": "14998326014",
                "postal_code": "18800000",
                "address": "Rua Israel dos Santos Guerra",
                "address_number": "150",
                "customer_id": "cus_000006298160"
            }
        ]
    ]
}
```

#### Buscar

-   **Método:** GET
-   **Endpoint:** /client/{$client}
-   **Resposta:**
    -   `status`: 200 - OK ou 404 - NOT FOUND

```json
{
    "message": "Sucesso",
    "data": {
        "id": 1,
        "name": "Denis Cury",
        "document": "17246279024",
        "email": "denis.cury.1999@hotmail.com",
        "phone": "14998326012",
        "postal_code": "18800000",
        "address": "Rua Israel dos Santos Guerra",
        "address_number": "150",
        "invoices": [],
        "customer_id": "cus_000006298156",
        "asaas_data": {
            "object": "customer",
            "id": "cus_000006298156",
            "dateCreated": "2024-10-20",
            "name": "Denis Cury",
            "email": "denis.cury.1999@hotmail.com",
            "company": null,
            "phone": "14998326012",
            "mobilePhone": null,
            "address": "Rua Israel dos Santos Guerra",
            "addressNumber": "150",
            "complement": null,
            "province": null,
            "postalCode": "18800000",
            "cpfCnpj": "17246279024",
            "personType": "FISICA",
            "deleted": false,
            "additionalEmails": null,
            "externalReference": null,
            "notificationDisabled": false,
            "observations": null,
            "municipalInscription": null,
            "stateInscription": null,
            "canDelete": true,
            "cannotBeDeletedReason": null,
            "canEdit": true,
            "cannotEditReason": null,
            "city": 12311,
            "cityName": "Piraju",
            "state": "SP",
            "country": "Brasil"
        }
    }
}
```

```json
{
    "message": "Cliente não encontrado"
}
```

#### Cadastrar

-   **Método:** POST
-   **Endpoint:** /client
-   **Parâmetros:**
    -   `name`: Nome do cliente
    -   `document`: CPF/CNPJ
    -   `email`: Email
    -   `phone`: Telefone
    -   `postal_code`: CEP
    -   `address`: Endereço completo
    -   `address_number`: Número do endereço
-   **Resposta:**
    -   `status`: 201 - CREATED, 400 - BAD REQUEST ou 500 - INTERNAL SERVER ERROR

```json
{
    "message": "Cliente cadastrado com sucesso",
    "data": {
        "id": 3,
        "name": "Maria Antonieta",
        "document": "84335177089",
        "email": "denis.cury.1997@hotmail.com",
        "phone": "14998326014",
        "postal_code": "18800000",
        "address": "Rua Israel dos Santos Guerra",
        "address_number": 150,
        "customer_id": "cus_000006298160",
        "asaas_data": {
            "object": "customer",
            "id": "cus_000006298160",
            "dateCreated": "2024-10-20",
            "name": "Maria Antonieta",
            "email": "denis.cury.1997@hotmail.com",
            "company": null,
            "phone": "14998326014",
            "mobilePhone": null,
            "address": "Rua Israel dos Santos Guerra",
            "addressNumber": "150",
            "complement": null,
            "province": null,
            "postalCode": "18800000",
            "cpfCnpj": "84335177089",
            "personType": "FISICA",
            "deleted": false,
            "additionalEmails": null,
            "externalReference": null,
            "notificationDisabled": false,
            "observations": null,
            "municipalInscription": null,
            "stateInscription": null,
            "canDelete": true,
            "cannotBeDeletedReason": null,
            "canEdit": true,
            "cannotEditReason": null,
            "city": 12311,
            "cityName": "Piraju",
            "state": "SP",
            "country": "Brasil"
        }
    }
}
```

```json
{
    "message": "Algo errado aconteceu",
    "error": {
        "document": [
            "O campo document é obrigatório."
        ],
        "email": [
            "Identificamos que o email denis.cury.1997@hotmail.com já existe."
        ],
        "phone": [
            "Identificamos que o phone 14998326014 já existe."
        ]
    }
}
```

#### Alterar

-   **Método:** PATCH
-   **Endpoint:** /client/{client}
-   **Parâmetros:**
    -   `name`: Nome do cliente
    -   `document`: CPF/CNPJ
    -   `email`: Email
    -   `phone`: Telefone
    -   `postal_code`: CEP
    -   `address`: Endereço completo
    -   `address_number`: Número do endereço
-   **Resposta:**
    -   `status`: 201 - CREATED, 400 - BAD REQUEST ou 500 - INTERNAL SERVER ERROR

```json
{
    "message": "Cliente alterado com sucesso",
    "data": {
        "id": 1,
        "name": "Denis Cury Ortiz",
        "document": "41068108835",
        "email": "denis.cury.1996@hotmail.com",
        "phone": "14998326015",
        "postal_code": "18800000",
        "address": "Rua Celso do Amaral",
        "address_number": 50,
        "customer_id": "cus_000006298156",
        "asaas_data": {
            "object": "customer",
            "id": "cus_000006298156",
            "dateCreated": "2024-10-20",
            "name": "Denis Cury Ortiz",
            "email": "denis.cury.1996@hotmail.com",
            "company": null,
            "phone": null,
            "mobilePhone": "14998326015",
            "address": "Rua Celso do Amaral",
            "addressNumber": "50",
            "complement": null,
            "province": null,
            "postalCode": "18800000",
            "cpfCnpj": "41068108835",
            "personType": "FISICA",
            "deleted": false,
            "additionalEmails": null,
            "externalReference": null,
            "notificationDisabled": false,
            "observations": null,
            "municipalInscription": null,
            "stateInscription": null,
            "canDelete": true,
            "cannotBeDeletedReason": null,
            "canEdit": true,
            "cannotEditReason": null,
            "city": 12311,
            "cityName": "Piraju",
            "state": "SP",
            "country": "Brasil"
        }
    }
}
```

```json
{
    "message": "Algo errado aconteceu",
    "error": {
        "phone": [
            "Identificamos que o phone 14998326014 já existe."
        ]
    }
}
```

#### Excluir

-   **Método:** DELETE
-   **Endpoint:** /client/{client}
-   **Resposta:**
    -   `status`: 200 - OK ou 404 - NOT FOUND

```json
{
    "message": "Cliente excluído com sucesso",
    "data": {
        "id": 1,
        "name": "Denis Cury Ortiz",
        "document": "41068108835",
        "email": "denis.cury.1996@hotmail.com",
        "phone": "14998326015",
        "postal_code": "18800000",
        "address": "Rua Celso do Amaral",
        "address_number": "50",
        "customer_id": "cus_000006298156",
        "asaas_data": {
            "deleted": true,
            "id": "cus_000006298156"
        }
    }
}
```

```json
{
    "message": "Cliente não encontrado"
}
```

#### Restaurar

-   **Método:** POST
-   **Endpoint:** /client/{client}/restore
-   **Resposta:**
    -   `status`: 200 - OK ou 404 - NOT FOUND

```json
{
    "message": "Cliente restaurado com sucesso",
    "data": {
        "id": 1,
        "name": "Denis Cury Ortiz",
        "document": "41068108835",
        "email": "denis.cury.1996@hotmail.com",
        "phone": "14998326015",
        "postal_code": "18800000",
        "address": "Rua Celso do Amaral",
        "address_number": "50",
        "customer_id": "cus_000006298156",
        "asaas_data": {
            "object": "customer",
            "id": "cus_000006298156",
            "dateCreated": "2024-10-20",
            "name": "Denis Cury Ortiz",
            "email": "denis.cury.1996@hotmail.com",
            "company": null,
            "phone": null,
            "mobilePhone": "14998326015",
            "address": "Rua Celso do Amaral",
            "addressNumber": "50",
            "complement": null,
            "province": null,
            "postalCode": "18800000",
            "cpfCnpj": "41068108835",
            "personType": "FISICA",
            "deleted": false,
            "additionalEmails": null,
            "externalReference": null,
            "notificationDisabled": false,
            "observations": null,
            "municipalInscription": null,
            "stateInscription": null,
            "canDelete": true,
            "cannotBeDeletedReason": null,
            "canEdit": true,
            "cannotEditReason": null,
            "city": 12311,
            "cityName": "Piraju",
            "state": "SP",
            "country": "Brasil"
        }
    }
}
```

```json
{
    "message": "Cliente não encontrado"
}
```

### Payments

#### Listar todos

-   **Método:** GET
-   **Endpoint:** /payment
-   **Resposta:**
    -   `status`: 200 - OK

```json
{
    "message": "Sucesso",
    "data": [
        [
            {
                "id": 1,
                "billing_type": "PIX",
                "due_date": "2024-10-20",
                "value": "2357.91",
                "status": "PENDING",
                "client_id": 1,
                "payment_id": "pay_ibgo43pu4ul1gjfq"
            },
            {
                "id": 2,
                "billing_type": "CREDIT_CARD",
                "due_date": "2024-10-20",
                "value": "1542.90",
                "status": "PENDING",
                "client_id": 2,
                "payment_id": "pay_l7fnosmld5ogmrdb"
            },
            {
                "id": 3,
                "billing_type": "BOLETO",
                "due_date": "2024-10-20",
                "value": "256.31",
                "status": "PENDING",
                "client_id": 3,
                "payment_id": "pay_cmmv92oiovzte3x8"
            }
        ]
    ]
}
```

#### Gerar cobrança

-   **Método:** POST
-   **Endpoint:** /payment
-   **Parâmetros:**
    -   `billing_type`: Tipo de cobrança (PIX, CREDIT_CARD, BOLETO)
    -   `value`: Valor
-   **Resposta:**
    -   `status`: 201 - CREATED, 400 - BAD REQUEST ou 500 - INTERNAL SERVER ERROR

```json
{
    "message": "Sucesso",
    "data": {
        "id": 3,
        "billing_type": "BOLETO",
        "due_date": "2024-10-20",
        "value": 256.31,
        "status": "PENDING",
        "client_id": 3,
        "payment_id": "pay_cmmv92oiovzte3x8",
        "asaas_data": {
            "object": "payment",
            "id": "pay_cmmv92oiovzte3x8",
            "dateCreated": "2024-10-20",
            "customer": "cus_000006298160",
            "paymentLink": null,
            "value": 256.31,
            "netValue": 255.32,
            "originalValue": null,
            "interestValue": null,
            "description": null,
            "billingType": "BOLETO",
            "canBePaidAfterDueDate": true,
            "pixTransaction": null,
            "status": "PENDING",
            "dueDate": "2024-10-20",
            "originalDueDate": "2024-10-20",
            "paymentDate": null,
            "clientPaymentDate": null,
            "installmentNumber": null,
            "invoiceUrl": "https://sandbox.asaas.com/i/cmmv92oiovzte3x8",
            "invoiceNumber": "06765702",
            "externalReference": null,
            "deleted": false,
            "anticipated": false,
            "anticipable": false,
            "creditDate": null,
            "estimatedCreditDate": null,
            "transactionReceiptUrl": null,
            "nossoNumero": "10286661",
            "bankSlipUrl": "https://sandbox.asaas.com/b/pdf/cmmv92oiovzte3x8",
            "lastInvoiceViewedDate": null,
            "lastBankSlipViewedDate": null,
            "discount": {
                "value": 0,
                "limitDate": null,
                "dueDateLimitDays": 0,
                "type": "FIXED"
            },
            "fine": {
                "value": 0,
                "type": "FIXED"
            },
            "interest": {
                "value": 0,
                "type": "PERCENTAGE"
            },
            "postalService": false,
            "custody": null,
            "refunds": null
        }
    }
}
```

```json
{
    "message": "Algo errado aconteceu",
    "error": {
        "billing_type": [
            "O billing type não é um tipo de cobrança válido!"
        ],
        "value": [
            "O campo value é obrigatório."
        ]
    }
}
```

#### PIX

-   **Método:** GET
-   **Endpoint:** /payment/{$payment}/pix
-   **Resposta:**
    -   `status`: 200 - OK, 400 - BAD REQUEST, 404 - NOT FOUND ou 500 - INTERNAL SERVER ERROR

```json
{
    "message": "Pagamento com PIX gerado com sucesso",
    "data": {
        "id": 1,
        "billing_type": "PIX",
        "due_date": "2024-10-20",
        "value": "2357.91",
        "status": "PENDING",
        "client_id": 1,
        "payment_id": "pay_ibgo43pu4ul1gjfq",
        "pix": {
            "success": true,
            "encodedImage": "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",
            "payload": "00020101021226820014br.gov.bcb.pix2560qrpix-h.bradesco.com.br/9d36b84f-c70b-478f-b95c-12729b90ca2552040000530398654072357.915802BR5905ASAAS6009JOINVILLE62070503***6304F3B4",
            "expirationDate": "2024-10-20 23:59:59"
        }
    }
}
```

```json
{
    "message": "Algo errado aconteceu",
    "error": [
        [
            "Esta cobrança não permite pagamentos via Pix."
        ]
    ]
}
```

#### Boleto

-   **Método:** GET
-   **Endpoint:** /payment/{$payment}/bill
-   **Resposta:**
    -   `status`: 200 - OK, 400 - BAD REQUEST, 404 - NOT FOUND ou 500 - INTERNAL SERVER ERROR

```json
{
    "message": "Pagamento com boleto gerado com sucesso",
    "data": {
        "id": 3,
        "billing_type": "BOLETO",
        "due_date": "2024-10-20",
        "value": "256.31",
        "status": "PENDING",
        "client_id": 3,
        "payment_id": "pay_cmmv92oiovzte3x8",
        "bill": {
            "identificationField": "46191110000000000000010286661011898750000025631",
            "nossoNumero": "10286661",
            "barCode": "46198987500000256311110000000000001028666101"
        }
    }
}
```

```json
{
    "message": "Algo errado aconteceu",
    "error": [
        [
            "Somente é possível obter linha digitável quando a forma de pagamento for boleto bancário."
        ]
    ]
}
```

#### Cartão de Crédito

-   **Método:** POST
-   **Endpoint:** /payment/{$payment}/credit-card
-   **Parâmetros:**
    -   `card_number`: Número do cartão
    -   `expiry_month`: Mês de vencimento do cartão
    -   `expiry_year`: Ano de vencimento do cartão
    -   `ccv`: CCV do cartão
-   **Resposta:**
    -   `status`: 200 - OK, 400 - BAD REQUEST, 404 - NOT FOUND ou 500 - INTERNAL SERVER ERROR

```json
{
    "message": "Pagamento com cartão de crédito gerado com sucesso",
    "data": {
        "id": 2,
        "billing_type": "CREDIT_CARD",
        "due_date": "2024-10-20",
        "value": "1542.90",
        "status": "CONFIRMED",
        "client_id": 2,
        "client": {
            "id": 2,
            "name": "Denis Cury",
            "document": "18050029026",
            "email": "denis.cury.1998@hotmail.com",
            "phone": "14998326013",
            "postal_code": "18800000",
            "address": "Rua Israel dos Santos Guerra",
            "address_number": "150",
            "customer_id": "cus_000006298159",
            "created_at": "2024-10-20T15:09:11.000000Z",
            "updated_at": "2024-10-20T15:09:11.000000Z",
            "deleted_at": null
        },
        "payment_id": "pay_l7fnosmld5ogmrdb",
        "credit_card": {
            "object": "payment",
            "id": "pay_l7fnosmld5ogmrdb",
            "dateCreated": "2024-10-20",
            "customer": "cus_000006298159",
            "paymentLink": null,
            "value": 1542.9,
            "netValue": 1511.71,
            "originalValue": null,
            "interestValue": null,
            "description": null,
            "billingType": "CREDIT_CARD",
            "confirmedDate": "2024-10-20",
            "creditCard": {
                "creditCardNumber": "3653",
                "creditCardBrand": "UNKNOWN",
                "creditCardToken": "af48adae-c4cc-47fe-9592-566e8c8b754b"
            },
            "pixTransaction": null,
            "status": "CONFIRMED",
            "dueDate": "2024-10-20",
            "originalDueDate": "2024-10-20",
            "paymentDate": null,
            "clientPaymentDate": "2024-10-20",
            "installmentNumber": null,
            "invoiceUrl": "https://sandbox.asaas.com/i/l7fnosmld5ogmrdb",
            "invoiceNumber": "06765701",
            "externalReference": null,
            "deleted": false,
            "anticipated": false,
            "anticipable": false,
            "creditDate": "2024-11-21",
            "estimatedCreditDate": "2024-11-21",
            "transactionReceiptUrl": "https://sandbox.asaas.com/comprovantes/7716058854957332",
            "nossoNumero": null,
            "bankSlipUrl": null,
            "lastInvoiceViewedDate": null,
            "lastBankSlipViewedDate": null,
            "discount": {
                "value": 0,
                "limitDate": null,
                "dueDateLimitDays": 0,
                "type": "FIXED"
            },
            "fine": {
                "value": 0,
                "type": "FIXED"
            },
            "interest": {
                "value": 0,
                "type": "PERCENTAGE"
            },
            "postalService": false,
            "custody": null,
            "refunds": null
        }
    }
}
```

```json
{
    "message": "Pedido não encontrado"
}
```

## Observações Adicionais

-   Certifique-se de ter as permissões necessárias para os diretórios e arquivos dentro do projeto.
-   Se você encontrar algum problema, verifique suas instalações do PHP e Composer, e assegure-se de que todas as extensões necessárias estão habilitadas.
-   Para mais assistência, consulte a documentação oficial do [Laravel](https://laravel.com/docs).

---

Essa versão é estruturada, fornece comandos claros e inclui notas adicionais para melhor clareza e usabilidade.

```

```