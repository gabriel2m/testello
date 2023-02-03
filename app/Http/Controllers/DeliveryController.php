<?php

namespace App\Http\Controllers;

use App\Jobs\FromCSVToDeliveriesJob;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class DeliveryController extends Controller
{
    /**
     * Show the form for upload deliveries file for the specified customer.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function bulkCreate(Customer $customer)
    {
        return inertia('Deliveries/BulkCreate', compact('customer'));
    }

    /**
     * Create all deliveries on file for the specified customer in storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function bulkStore(Request $request, Customer $customer)
    {
        $request->validate([
            'file' =>  'required|mimes:csv,txt'
        ]);

        $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));

        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }

        $save = $receiver->receive();

        if ($save->isFinished()) {
            $response = $this->saveFile($save->getFile(), $customer->id);

            return $response;
        }

        /** @var AbstractHandler $handler */
        $handler = $save->handler();

        return response()->json([
            "done" => $handler->getPercentageDone(),
            'status' => true
        ]);
    }

    /**
     * Saves the file
     *
     * @param UploadedFile $file
     *
     * @return JsonResponse
     */
    protected function saveFile(UploadedFile $file, int $customer_id)
    {
        $fileName = $this->createFilename($file);

        $mime = str_replace('/', '-', $file->getMimeType());

        $filePath = "upload/";
        $finalPath = storage_path("app/" . $filePath);

        $file->move($finalPath, $fileName);

        $csv    = file($finalPath . $fileName);
        $chunks = array_chunk($csv, 1000);
        $header = [];

        foreach ($chunks as $key => $chunk) {
            $data = array_map(function ($str) {
                return str_getcsv($str, ";");
            }, $chunk);

            if ($key == 0) {
                $header = $data[0];
                unset($data[0]);
            }

            FromCSVToDeliveriesJob::dispatch($customer_id, $data, $header);
        }

        return response()->json([
            'path' => $filePath,
            'name' => $fileName,
            'mime_type' => $mime
        ]);
    }

    /**
     * Create unique filename for uploaded file
     * @param UploadedFile $file
     * @return string
     */
    protected function createFilename(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();

        $filename = str_replace("." . $extension, "", $file->getClientOriginalName());

        $filename .= "_" . md5(time()) . "." . $extension;

        return $filename;
    }
}
