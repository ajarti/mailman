<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id'         => intval($this->id),
            'name'       => $this->name,
            'slug'       => $this->slug,
            'order'      => (int)$this->order ?? 99,
            'deleted'    => boolval($this->trashed()),
            'created_ts' => (isset($this->created_at) && is_a($this->created_at, Carbon::class)) ? $this->created_at->getTimestamp() : '',
            'updated_ts' => (isset($this->updated_at) && is_a($this->updated_at, Carbon::class)) ? $this->updated_at->getTimestamp() : '',
            'deleted_ts' => (isset($this->deleted_at) && is_a($this->deleted_at, Carbon::class)) ? $this->deleted_at->getTimestamp() : '',
        ];

        // Return Transformed.
        return $data;
    }
}
