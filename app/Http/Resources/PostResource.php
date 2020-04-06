<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    /**
     * @SWG\Definition(
     *  definition="PostResource",
     *  @SWG\Property(
     *      property="id",
     *      type="integer"
     *  ),
     *  @SWG\Property(
     *      property="name",
     *      type="string"
     *  ),
     *  @SWG\Property(
     *      property="text",
     *      type="string"
     *  ),
     *  @SWG\Property(
     *      property="user",
     *      type="object",
     *     @SWG\Property(
     *      property="id",
     *      type="integer",
     *      ),
     *      @SWG\Property(
     *      property="name",
     *      type="string",
     *      )
     *  ),
     *  @SWG\Property(
     *      property="category",
     *      type="object",
     *     @SWG\Property(
     *      property="id",
     *      type="integer",
     *      ),
     *      @SWG\Property(
     *      property="name",
     *      type="string",
     *      )
     *  ),
     *  @SWG\Property(
     *      property="image",
     *      type="string"
     *  ),
     *  @SWG\Property(
     *      property="created_at",
     *      type="string"
     *  )
     * )
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'text' => $this->text,
            'user' => [
                'id' => $this->user_id,
                'name' => User::find($this->user_id)->name
            ],
            'category' => [
                'id' => $this->category_id,
                'name' => Category::find($this->category_id)->name
            ],
            'image' => $this->image,
            'created_at' => $this->created_at,
        ];
    }
}
