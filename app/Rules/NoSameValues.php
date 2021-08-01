<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NoSameValues implements Rule
{
    /**
     * The name of current attribute.
     *
     * @var string
     */
    protected $attribute;

    /**
     * The name of a given attribute.
     *
     * @var string
     */
    protected $related_attribute;

    /**
     * The accepted values.
     *
     * @var array
     */
    protected $values;

    /**
     * Create a new no_same_values rule instance.
     *
     * @param  array  $values
     * @return void
     */
    public function __construct(string $attribute, ?array $values)
    {
        $this->related_attribute = str_replace('_', ' ', $attribute);
        $this->values = $values;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->attribute = str_replace('_', ' ', $attribute);
        return empty(array_intersect($value, $this->values));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.no_same_values', ['current_attr' => $this->attribute, 'related_attr' => $this->related_attribute]);
    }
}
