<?php

namespace App\Actions\ContentBlock;


use App\Actions\Image\ImageUpsertAndSyncAction;
use App\Models\ContentBlock;
use Illuminate\Support\Carbon;

class ContentBlockCreateOrUpdateAction
{
    public function __invoke(array $data): array
    {
        $sync = array();

        foreach ($data as $index => $item) {
            $id = (isset($item['id'])) ? $item['id'] : null;

            $imagesSync = array();

            if (isset($item['images'])) {
                $imagesSync = (new ImageUpsertAndSyncAction())($item['images']);
                unset($item['images']);
            }

            $contentBlock = ContentBlock::updateOrCreate(['id' => $id], $item);

            $sync[$contentBlock->id] = ['sort' => $index];

            $contentBlock->images()->sync($imagesSync);
        }

        return $sync;
    }

}
