<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PackageResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'country' => $this->country,
            'state' => $this->state,
            'packages' => PackageResource::collection($this->whenLoaded('packages')),
            'total_packages' => $this->packages->count(),
            'latest_package' => $this->packages->last(),
            'address' => $this->address,
            'zipcode' => $this->zipcode,
            'contact_number' => $this->contact_number,
            'role' => $this->role,
            'driver_license_number' => $this->driver_license_number,
            'vehicle_info' => $this->vehicle_info,
            'created_at' => (new \DateTime($this->created_at))->format('Y-m-d H:i:s'),
            'updated_at' => (new \DateTime($this->updated_at))->format('Y-m-d H:i:s'),
            

        ];
    }
}
