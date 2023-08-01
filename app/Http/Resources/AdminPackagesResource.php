<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;
use App\Http\Resources\UserResource;


class AdminPackagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'image_url' => $this->image ? URL::to($this->image) : null,
            'title' => $this->title,
            'tracking_number' => $this->tracking_number,
            'delivery_address' => $this->delivery_address,
            'user' => $this->user,
            'driver_name' => $this->driver_name,                                          
            'delivery_status' => $this->delivery_status,
            'special_instructions' => $this->special_instructions,
            'payment_reference' => $this->payment_reference,
            'created_at' => (new \DateTime($this->created_at))->format('Y-m-d H:i:s'),
            'updated_at' => (new \DateTime($this->updated_at))->format('Y-m-d H:i:s'),            
            
        ];
    }
}
