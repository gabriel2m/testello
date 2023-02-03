<?php

namespace App\Jobs;

use App\Models\Delivery;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Validator;

class FromCSVToDeliveriesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public int $customer_id, public array $data, public array $header)
    {
        // 
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->data as $item) {
            $item_csv_data = array_combine($this->header, $item);
            $item_csv_data['from_weight'] = $this->formatFloat($item_csv_data['from_weight']);
            $item_csv_data['to_weight'] = $this->formatFloat($item_csv_data['to_weight']);
            $item_csv_data['cost'] = $this->formatFloat($item_csv_data['cost']);

            $validator = Validator::make($item_csv_data, [
                'from_postcode' => [
                    'required',
                    'string',
                    'regex:/^[0-9]{2}.[0-9]{3}-[0-9]{3}$/u'
                ],
                'to_postcode' => [
                    'required',
                    'string',
                    'regex:/^[0-9]{2}.[0-9]{3}-[0-9]{3}$/u'
                ],
                'from_weight' => [
                    'required',
                    'numeric',
                ],
                'to_weight' => [
                    'required',
                    'numeric',
                ],
                'cost' => [
                    'required',
                    'numeric',
                ],
            ]);

            if ($validator->validate()) {
                $item_csv_data['customer_id'] = $this->customer_id;
                Delivery::create($item_csv_data);
            }
        }
    }

    public function formatFloat(string $float)
    {
        return str_replace(',', '.', str_replace('.', '', $float));
    }
}
