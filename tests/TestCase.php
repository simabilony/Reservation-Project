<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Database\Seeders\RoleSeeder;

abstract class TestCase extends BaseTestCase
{

    public bool $seed = true;
}
