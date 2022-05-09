<?php

namespace Alps\BlueprintName\Filters;

use Illuminate\Support\Collection;
use Statamic\Entries\Collection as EntryCollection;
use Statamic\Entries\Entry;
use Statamic\Extend\HasFields;
use Statamic\Facades\Blueprint as BlueprintFacade;
use Statamic\Fields\Blueprint;
use Statamic\Fields\Fieldtype;

class BlueprintFilter
{
    use HasFields;

    private Fieldtype $fieldtype;
    private ?EntryCollection $collection;

    public function __construct(Fieldtype $fieldtype, ?EntryCollection $collection = null)
    {
        $this->fieldtype = $fieldtype;
        $this->collection = $collection;
    }

    private function getCollection(): ?EntryCollection
    {
        $parent = $this->fieldtype->field()->parent();

        if ($parent instanceof EntryCollection) {
            return $parent;
        }

        if ($parent instanceof Entry) {
            return $parent->collection();
        }

        return null;
    }

    private function getBlueprints(): Collection
    {
        if (!$this->collection) {
            return new Collection;
        }

        return $this->collection->entryBlueprints();
    }

    public function fieldItems()
    {
        $options = $this->getBlueprints()
            ->map(function(Blueprint $blueprint) {
                return [
                    'handle' => $blueprint->namespace() . '.' . $blueprint->handle(),
                    'label' => $blueprint->title(),
                ];
            })
            ->pluck('label', 'handle');

        return [
            'value' => [
                'type' => 'select',
                'options' => $options,
            ],
        ];
    }
    public function apply($query, $handle, $values)
    {
        $blueprintHandle = $values['value'];

        $blueprint = BlueprintFacade::find($blueprintHandle);

        $query->where('blueprint', $blueprint ? $blueprint->handle() : $blueprintHandle);
    }

    public function badge($values)
    {
        $fieldName = $this->fieldtype->field()->display();

        $blueprintHandle = $values['value'];

        $blueprint = BlueprintFacade::find($blueprintHandle);

        $blueprintName = $blueprint ? $blueprint->title() : $blueprintHandle;

        return $fieldName . ': ' . $blueprintName;
    }
}
