<?php

namespace Alps\BlueprintName\Fieldtypes;

use Alps\BlueprintName\Filters\BlueprintFilter;
use Illuminate\Http\Request;
use Statamic\Entries\Collection;
use Statamic\Entries\Entry;
use Statamic\Fields\Blueprint;

class BlueprintName extends \Statamic\Fields\Fieldtype
{
    protected $icon = 'blueprint';

    public function filter()
    {
        return new BlueprintFilter($this, $this->getCollection());
    }

    private function getCollection(): ?Collection
    {
        $parent = $this->field()->parent();

        if ($parent instanceof Collection) {
            return $parent;
        }

        if ($parent instanceof Entry) {
            return $parent->collection();
        }

        /** @var Request $request */
        $request = resolve(Request::class);

        /** @var Collection|null $collection */
        $collection = $request->route()->parameter('collection');

        return $collection;
    }

    private function getBlueprint(): ?Blueprint
    {
        if (!$this->field() || !$this->field()->parent()) {
            return null;
        }

        $parent = $this->field()->parent();

        if (!$parent instanceof Entry) {
            return null;
        }

        return $parent->blueprint();
    }

    private function getBlueprintName($fallback = null): ?string
    {
        $blueprint = $this->getBlueprint();

        return $blueprint ? $blueprint->title() : $fallback;
    }

    private function getBlueprintHandle($fallback = null): ?string
    {
        $blueprint = $this->getBlueprint();

        return $blueprint ? $blueprint->handle() : $fallback;
    }

    public function preload()
    {
        return [
            'blueprintHandle' => $this->getBlueprintHandle(),
        ];
    }

    public function preProcessIndex($data)
    {
        return $this->getBlueprintName($data);
    }

//    public function preProcess($data)
//    {
//        return $this->getBlueprintName($data);
//    }
//
//    public function process($data)
//    {
//        return $this->getBlueprintHandle($data);
//    }

//    public function preProcess($data)
//    {
//        return $this->getBlueprintHandle($data);
//        return $data;
//    }

//    public function preProcessIndex($value)
//    {
//        return $this->getBlueprintName($value);
//    }

//

//    public function toQueryableValue($value)
//    {
//        return $this->getBlueprintHandle($value);
//    }

//    public function toQueryableValue($value)
//    {
//        $blueprint = $this->getBlueprint();
//
////        dump($blueprint->handle());
//
//        return $blueprint ? $blueprint->handle() : $value;
//    }
}
