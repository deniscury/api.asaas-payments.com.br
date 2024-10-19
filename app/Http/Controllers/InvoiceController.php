<?php

namespace App\Http\Controllers;

use App\Models\Invoice;

use App\Http\Requests\BillInvoiceRequest;
use App\Http\Requests\CreditCardInvoiceRequest;
use App\Http\Requests\PaymentInvoiceRequest;
use App\Http\Resources\InvoiceResource;

use App\Models\Client;
use App\Services\AppService;
use App\Services\PaymentService;

use Exception;
use Illuminate\Support\MessageBag;
use Symfony\Component\HttpFoundation\Response;

class InvoiceController extends Controller
{
    public function payment(PaymentInvoiceRequest $request, $client)
    {
        try{
            $request = $request->validated();

            $client = Client::find($client);

            if (!$client){
                return AppService::return(Response::HTTP_NOT_FOUND, array(), "Cliente não encontrado");
            }
            
            $paymentService = new PaymentService();

            $paymentService->setCustomerId($client->customer_id);

            $dueDate = date_format(now(), 'Y-m-d');

            $body = array(
                "billingType" => $request['billing_type'],
                "dueDate" => $dueDate,
                "value"=> $request['value']
            );

            if (isset($request['installment_count']) && $request['installment_count'] > 1){
                $body['installmentCount'] = $request['installment_count'];
                $body['installmentValue'] = $request['installment_value'];
            }

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
                    return AppService::return(Response::HTTP_CREATED, $invoice);
                }
            }

            $errors = isset($response->errors)?$response->errors:false;

            if($errors){
                $errors = new MessageBag(array_column($errors, 'description'));
                return AppService::return($statusCode, null, 'Algo errado aconteceu', $errors);
            }

            return AppService::return(Response::HTTP_INTERNAL_SERVER_ERROR, array(), "Algo errado aconteceu");
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
                    return AppService::return(Response::HTTP_OK, $invoice);
                }
            }

            $errors = isset($response->errors)?$response->errors:false;

            if($errors){
                $errors = new MessageBag(array_column($errors, 'description'));
                return AppService::return($statusCode, null, 'Algo errado aconteceu', $errors);
            }

            return AppService::return(Response::HTTP_INTERNAL_SERVER_ERROR, array(), "Algo errado aconteceu");
        }
        catch(Exception $e){
            $error = new MessageBag(array($e->getMessage()));
            return AppService::return(Response::HTTP_INTERNAL_SERVER_ERROR, array(), "Algo errado aconteceu", $error);
        }
    }

    public function creditCard(CreditCardInvoiceRequest $request)
    {
        //
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
                    return AppService::return(Response::HTTP_OK, $invoice);
                }
            }

            $errors = isset($response->errors)?$response->errors:false;

            if($errors){
                $errors = new MessageBag(array_column($errors, 'description'));
                return AppService::return($statusCode, null, 'Algo errado aconteceu', $errors);
            }

            return AppService::return(Response::HTTP_INTERNAL_SERVER_ERROR, array(), "Algo errado aconteceu");
        }
        catch(Exception $e){
            $error = new MessageBag(array($e->getMessage()));
            return AppService::return(Response::HTTP_INTERNAL_SERVER_ERROR, array(), "Algo errado aconteceu", $error);
        }
    }
}
