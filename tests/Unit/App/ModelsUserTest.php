<?php

namespace Tests\Unit\App;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPUnit\Framework\TestCase;

class ModelsUserTest extends TestCase
{
    protected function model(): Model
    {
        return new User();
    }

    public function test_traits()
    {
        $traits = array_keys(class_uses($this->model()));

        $expectedTraits = [
            HasApiTokens::class,
            HasFactory::class,
            Notifiable::class,
        ];

        $this->assertEquals($expectedTraits, $traits);
    }
}
