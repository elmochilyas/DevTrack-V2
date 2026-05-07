<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'title' => $this->title,

            'status'       => $this->status,
            'status_label' => $this->status_label,

            'priority'       => $this->priority,
            'priority_label' => $this->priority_label,

            'description' => $this->description,

            'deadline'        => $this->deadline ? $this->deadline->format('d/m/Y') : null,
            'deadline_status' => $this->deadline_status,

            'assignee' => $this->whenLoaded('assignee', function () {
                return [
                    'id'    => $this->assignee->id,
                    'name'  => $this->assignee->name,
                    'email' => $this->assignee->email,
                ];
            }),

            'created_at' => $this->created_at->format('d/m/Y H:i'),
            'updated_at' => $this->updated_at->format('d/m/Y H:i'),
        ];
    }
}