<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $inAdminLayer = $request->is('*/admin/*');
        $data = parent::toArray($request);

        if (!$inAdminLayer) {
            unset(
                $data['id'],
                $data['guard_name'],
                $data['created_at'],
                $data['updated_at']
            );
        }

        return [
            ...$data,
            'permissions' => $this->resource->permissions()->get()->map(fn($p) => $p->name)
        ];
    }
}
