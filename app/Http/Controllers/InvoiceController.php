<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Client;

use App\Http\Requests\CreditCardInvoiceRequest;
use App\Http\Requests\PaymentInvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\InvoicesCollection;

use App\Services\AppService;
use App\Services\PaymentService;

use Exception;
use Illuminate\Support\MessageBag;
use Symfony\Component\HttpFoundation\Response;

class InvoiceController extends Controller
{
    public function index()
    {     
        try{
            $invoices = new InvoicesCollection(Invoice::with("client")->get());

            return AppService::return(Response::HTTP_OK, $invoices);
        }
        catch(Exception $e){
            $error = new MessageBag(array($e->getMessage()));
            return AppService::return(Response::HTTP_INTERNAL_SERVER_ERROR, array(), "Algo errado aconteceu", $error);
        }
    }

    public function payment(PaymentInvoiceRequest $request, $client)
    {
        try{
            $request = $request->validated();

            $client = Client::find($client);

            if (!$client){
                return AppService::return(Response::HTTP_NOT_FOUND, array(), "Cliente não encontrado");
            }
            
            $paymentService = new PaymentService();

            $dueDate = date_format(now(), 'Y-m-d');

            $body = array(
                "customer" => $client->customer_id,
                "billingType" => $request['billing_type'],
                "dueDate" => $dueDate,
                "value"=> $request['value']
            );

            $response = json_decode($paymentService->generate($body));
            
            $statusCode = $paymentService->getStatusCode();

            if($statusCode == Response::HTTP_OK){
                $request["client_id"] = $client->id;
                $request["due_date"] = $dueDate;
                $request["status"] = $response->status;
                $request["payment_id"] = $response->id;
                
                $invoice = Invoice::create($request);

                $invoice->asaas = $response;

                if($invoice){
                    $invoice = new InvoiceResource($invoice);
                    return AppService::return(Response::HTTP_CREATED, $invoice, "Pedido gerado com sucesso");
                }
            }

            $errors = isset($response->errors)?$response->errors:false;
            $errors = new MessageBag(($errors?array_column($errors, 'description'):array()));
            
            return AppService::return($statusCode, null, 'Algo errado aconteceu', $errors);
        }
        catch(Exception $e){
            $error = new MessageBag(array($e->getMessage()));
            return AppService::return(Response::HTTP_INTERNAL_SERVER_ERROR, array(), "Algo errado aconteceu", $error);
        }
    }

    public function bill($invoice)
    {
        try{
            $invoice = Invoice::find($invoice); 

            if (!$invoice){
                return AppService::return(Response::HTTP_NOT_FOUND, array(), "Pedido não encontrado");
            }

            $paymentService = new PaymentService($invoice->payment_id);

            $response = json_decode($paymentService->bill());            
            $statusCode = $paymentService->getStatusCode();

            if($statusCode == Response::HTTP_OK){        
                $invoice->bill = $response;

                if($invoice){
                    $invoice = new InvoiceResource($invoice);
                    return AppService::return(Response::HTTP_OK, $invoice, "Pagamento com boleto gerado com sucesso");
                }
            }

            $errors = isset($response->errors)?$response->errors:false;
            $errors = new MessageBag(($errors?array_column($errors, 'description'):array()));

            return AppService::return($statusCode, null, 'Algo errado aconteceu', $errors);
        }
        catch(Exception $e){
            $error = new MessageBag(array($e->getMessage()));
            return AppService::return(Response::HTTP_INTERNAL_SERVER_ERROR, array(), "Algo errado aconteceu", $error);
        }
    }    

    public function pix($invoice)
    {
        try{
            $invoice = Invoice::find($invoice); 

            if (!$invoice){
                return AppService::return(Response::HTTP_NOT_FOUND, array(), "Pedido não encontrado");
            }

            $paymentService = new PaymentService($invoice->payment_id);

            $response = json_decode($paymentService->pix());            
            $statusCode = $paymentService->getStatusCode();

            if($statusCode == Response::HTTP_OK){        
                $invoice->pix = $response;

                if($invoice){
                    $invoice = new InvoiceResource($invoice);
                    return AppService::return(Response::HTTP_OK, $invoice, "Pagamento com PIX gerado com sucesso");
                }
            }

            $errors = isset($response->errors)?$response->errors:false;
            $errors = new MessageBag(($errors?array_column($errors, 'description'):array()));
            
            return AppService::return($statusCode, null, 'Algo errado aconteceu', $errors);
        }
        catch(Exception $e){
            $error = new MessageBag(array($e->getMessage()));
            return AppService::return(Response::HTTP_INTERNAL_SERVER_ERROR, array(), "Algo errado aconteceu", $error);
        }
    }

    public function creditCard(CreditCardInvoiceRequest $request, $invoice)
    {
        try{
            $request = $request->validated();

            $invoice = Invoice::with('client')->find($invoice); 

            if (!$invoice){
                return AppService::return(Response::HTTP_NOT_FOUND, array(), "Pedido não encontrado");
            }

            $paymentService = new PaymentService($invoice->payment_id);    
            $client = $invoice->client;        

            $body = array(
                "creditCard" => array(
                    "holderName" => $client->name,
                    "number" => $request['card_number'],
                    "expiryMonth" => $request['expiry_month'],
                    "expiryYear" => $request['expiry_year'],
                    "ccv" => $request['ccv']
                ),
                "creditCardHolderInfo" => array(
                    'name' => $client->name,
                    'email' => $client->email,
                    'cpfCnpj' => $client->document,
                    'postalCode' => $client->postal_code,
                    'addressComplement' => $client->address,
                    'addressNumber' => $client->address_number,
                    'phone' => $client->phone
                )
            );
            
            $response = json_decode($paymentService->creditCard($body));    
            
            $statusCode = $paymentService->getStatusCode();

            if($statusCode == Response::HTTP_OK){   
                $invoice->status = $response->status;
                $invoice->save();
                
                $invoice->credit_card = $response;

                if($invoice){
                    $invoice = new InvoiceResource($invoice);
                    return AppService::return(Response::HTTP_OK, $invoice, "Pagamento com cartão de crédito gerado com sucesso");
                }
            }

            $errors = isset($response->errors)?$response->errors:false;
            $errors = new MessageBag(($errors?array_column($errors, 'description'):array()));
            
            return AppService::return($statusCode, null, 'Algo errado aconteceu', $errors);
        }
        catch(Exception $e){
            $error = new MessageBag(array($e->getMessage()));
            return AppService::return(Response::HTTP_INTERNAL_SERVER_ERROR, array(), "Algo errado aconteceu", $error);
        }
    }

    public function money($invoice)
    {
        try{
            $invoice = Invoice::find($invoice); 

            if (!$invoice){
                return AppService::return(Response::HTTP_NOT_FOUND, array(), "Pedido não encontrado");
            }

            $paymentService = new PaymentService($invoice->payment_id); 

            $paymentDate = date_format(now(), 'Y-m-d');      

            $body = array(
                "paymentDate" => $paymentDate,
                "value" => $invoice->value,
                "notifyCustomer" => true
            );
            
            $response = json_decode($paymentService->money($body));    
            
            $statusCode = $paymentService->getStatusCode();

            if($statusCode == Response::HTTP_OK){   
                $invoice->status = $response->status;
                $invoice->save();
                
                $invoice->credit_card = $response;

                if($invoice){
                    $invoice = new InvoiceResource($invoice);
                    return AppService::return(Response::HTTP_OK, $invoice, "Pagamento com dinheiro gerado com sucesso");
                }
            }

            $errors = isset($response->errors)?$response->errors:false;
            $errors = new MessageBag(($errors?array_column($errors, 'description'):array()));
            
            return AppService::return($statusCode, null, 'Algo errado aconteceu', $errors);
        }
        catch(Exception $e){
            $error = new MessageBag(array($e->getMessage()));
            return AppService::return(Response::HTTP_INTERNAL_SERVER_ERROR, array(), "Algo errado aconteceu", $error);
        }
    }
}
