<?php

namespace Tests\Unit\App\Models;

use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

abstract class ModelTestCase extends TestCase
{
    abstract protected function model(): Model;
    abstract protected function expectedTraits(): array;
    abstract protected function expectedFillable(): array;
    abstract protected function expectedCasts(): array;

    public function test_has_traits()
    {
        $traits = array_keys(class_uses($this->model()));

        $this->assertEquals($this->expectedTraits(), $traits);
    }

    public function test_has_fillable()
    {
        $fillable = $this->model()->getFillable();

        $this->assertEquals($this->expectedFillable(), $fillable);
    }

    public function test_incrementing_is_false()
    {
        $this->assertFalse($this->model()->incrementing);
    }

    public function test_has_casts()
    {
        $casts = $this->model()->getCasts();

        $this->assertEquals($this->expectedCasts(), $casts);
    }
}
