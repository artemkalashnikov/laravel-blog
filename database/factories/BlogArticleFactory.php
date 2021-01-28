<?php

namespace Database\Factories;

use App\Models\BlogArticle;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BlogArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BlogArticle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title       = $this->faker->sentence(rand(3,8));
        $text        = $this->faker->realText(rand(1000, 4000));
        $isPublished = rand(1, 5) > 1;

        return [
            'category_id'  => rand(1, 11),
            'user_id'      => rand(1, 2),
            'slug'         => Str::slug($title),
            'title'        => $title,
            'fragment'     => $this->faker->text(rand(40, 100)),
            'content_raw'  => $text,
            'content_html' => $text,
            'is_published' => $isPublished,
            'published_at' => $isPublished ? $this->faker->dateTimeBetween('-2 months', '-1 days') : null,
            'created_at'   => $this->faker->dateTimeBetween('-3 months', '-2 months'),
        ];
    }
}
