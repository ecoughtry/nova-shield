<?php

namespace ecoughtry\NovaShield;

use ecoughtry\NovaShield\Lib\NovaResources;
use Laravel\Nova\Fields\Text as TextFeild;

class ShieldField extends TextFeild
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-shield';

    public function __construct($name, $attribute = null, $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->withMeta([
            'resources' => app(NovaResources::class)->resources,
            'enable_teams' => config('permission.teams'),
        ]);

        $this->resolveUsing(function ($value) {
            return $value->pluck('name');
        });
    }

    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            'resources' => app(NovaResources::class)->resources,
            'enable_teams' => config('permission.teams'),
        ]);
    }
}
